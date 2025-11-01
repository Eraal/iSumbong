<?php
include('../../connectMySql.php');
include '../../loginverification.php';

// Load environment variables
require_once('../../includes/env_loader.php');
loadEnv('../../.env');

if (logged_in()) {
    if (isset($_POST['btn_save'])) {
        $title = $_POST['title'];
        $category = "";
        $date = $_POST['date'];
        $description = $_POST['description'] . "\n\nLocation: " . $_POST['location'] . "\nReporter Address: " . ($_POST['address'] ?? ''); // Include both location and address in description
        $location = $_POST['location']; // Store location for database
        $address = $_POST['address'] ?? ''; // Store address with fallback
        $severity_level = "";
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'] ?? '';
        $notified = ''; // Set default value for notified field
        $evidence_logs = isset($_POST['evidence_logs']) ? 1 : 0;
        $evidence_screenshots = isset($_POST['evidence_screenshots']) ? 1 : 0;
        $evidence_email = isset($_POST['evidence_email']) ? 1 : 0;
        $evidence_other = isset($_POST['evidence_other']) ? 1 : 0;
        $additional_info = $_POST['additional_info'];
        $user_id = $_SESSION['user_id'];
        $suggestion = "";
        $table = "incident";

        // Get API key from environment variables (fail-fast: if missing, skip AI and use defaults)
        $apiKey = env('OPENAI_API_KEY');
        $hasOpenAI = !empty($apiKey);
        
        // Optional: Quick image-text consistency check via OpenAI (fail-fast and non-fatal)
        if ($hasOpenAI) {
            $url = "https://api.openai.com/v1/chat/completions";
            if (isset($_FILES['attachment']) && isset($_POST['description'])) {
                $description = $_POST['description'];
                $imageTmpName = $_FILES['attachment']['tmp_name'][0] ?? null;
                $imageType = $_FILES['attachment']['type'][0] ?? '';
                if ($imageTmpName && file_exists($imageTmpName)) {
                    $imageData = base64_encode(file_get_contents($imageTmpName));
                    $payload = [
                        "model" => "gpt-4o-mini",
                        "messages" => [[
                            "role" => "user",
                            "content" => [
                                [
                                    "type" => "text",
                                    "text" => "Suriin mo kung tugma ang larawan sa description na ito: '$description'. Sagutin lang ng 'Tugma' o 'Hindi tugma'."
                                ],
                                [
                                    "type" => "image_url",
                                    "image_url" => [
                                        "url" => "data:$imageType;base64,$imageData"
                                    ]
                                ]
                            ]
                        ]],
                        "max_tokens" => 50
                    ];

                    $ch = curl_init($url);
                    curl_setopt_array($ch, [
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_POST => true,
                        CURLOPT_HTTPHEADER => [
                            "Content-Type: application/json",
                            "Authorization: Bearer $apiKey"
                        ],
                        CURLOPT_POSTFIELDS => json_encode($payload),
                        // Fail fast to avoid 504s
                        CURLOPT_CONNECTTIMEOUT => 2,
                        CURLOPT_TIMEOUT => 6,
                        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                    ]);

                    $response = curl_exec($ch);
                    if ($response === false) {
                        error_log('OpenAI image-text check error: ' . curl_error($ch));
                    } else {
                        $result = json_decode($response, true);
                        $answer = $result['choices'][0]['message']['content'] ?? '';
                        if ($answer && stripos($answer, 'tugma') === false) {
                            $table = "spam"; // mark as spam if AI says not matching
                        }
                    }
                    curl_close($ch);
                }
            }
        }






        // Second AI call (classification + suggestion) - optional, fail-fast, with safe defaults
        $apiKey = env('OPENAI_API_KEY');
        $category = $category ?: "General Security";
        $severity_level = $severity_level ?: "Medium";
        $suggestion = $suggestion ?: "Please review this incident and take appropriate security measures.";

        $prompt = "
        Base sa title at description, classify mo ito:

        Title: $title
        Description: $description

        Ibigay ang sagot sa JSON format lang na ganito. 
        Plain text lang, walang HTML tags tulad ng <br>. 
        Gamitin ang newline (\\n) para sa spacing. 

        RULE: Alamin muna ang pangunahing language ng Title at Description.
        - Kung mas marami ang English words, gamitin ang English sa suggestion.
        - Kung mas marami ang Filipino words, gamitin ang Filipino sa suggestion.
        - Isang language lang dapat, huwag halo-halo.

        {
        \"category\": \" \", Based sa title at description, identify kung anong cybersecurity category ito.,
        \"severity_level\": \"Low | Medium | High | Critical\",
        \"suggestion\": \"Preventive measures (paano maiwasan / how to avoid), bullet points na may paliwanag bawat isa.\\n\\n If it happens / If it happens, ilagay ang dapat gawin step-by-step, gamit ang parehong language na ginamit sa Title at Description.\"
        }
        ";


    if ($hasOpenAI) {
    $ch = curl_init("https://api.openai.com/v1/chat/completions");

        $data = [
            "model" => "gpt-4o-mini",
            "messages" => [
                ["role" => "user", "content" => $prompt]
            ],
        ];

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: " . "Bearer " . $apiKey,
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Fail fast to avoid blocking request
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_TIMEOUT, 6);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $response = curl_exec($ch);
        if ($response === false) {
            error_log('OpenAI classify error: ' . curl_error($ch));
        } else {
            $result = json_decode($response, true);
            if (!isset($result['error']) && isset($result['choices'][0]['message']['content'])) {
                $content = trim($result['choices'][0]['message']['content']);
                $jsonData = json_decode($content, true);
                if (!$jsonData) {
                    $clean = preg_replace('/```(json)?/i', '', $content);
                    $clean = trim($clean);
                    $jsonData = json_decode($clean, true);
                }
                if ($jsonData && isset($jsonData['category'], $jsonData['severity_level'], $jsonData['suggestion'])) {
                    $category = $jsonData['category'] ?: $category;
                    $severity_level = $jsonData['severity_level'] ?: $severity_level;
                    $suggestion = $jsonData['suggestion'] ?: $suggestion;
                    if (is_array($suggestion)) {
                        $suggestion = implode("\n", $suggestion);
                    }
                    $suggestion = str_replace(["<br>", "<br/>", "<br />"], "\n", $suggestion);
                }
            } else {
                if (isset($result['error']['message'])) {
                    error_log('OpenAI classify API error: ' . $result['error']['message']);
                }
            }
        }
        curl_close($ch);
        } // end if($hasOpenAI)


        // Use prepared statement to prevent SQL injection
        $sql = "INSERT INTO $table (
            title, category, date, description, location, severity_level,
            full_name, address, email, phone, notified,
            evidence_logs, evidence_screenshots, evidence_email, evidence_other,
            additional_info, user_id, suggestion
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssssiiiisss", 
            $title, $category, $date, $description, $location, $severity_level,
            $full_name, $address, $email, $phone, $notified,
            $evidence_logs, $evidence_screenshots, $evidence_email, $evidence_other,
            $additional_info, $user_id, $suggestion
        );
        
        $result = $stmt->execute();

        if ($result) {
            $incident_id = $stmt->insert_id;

            // Debug: Log the incident ID
            error_log("New incident created with ID: " . $incident_id);

            if (!empty($_FILES['attachment']['name'][0])) {
                $upload_dir = "../../uploads/";
                
                // Create upload directory if it doesn't exist
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                $uploaded_files = [];
                foreach ($_FILES['attachment']['name'] as $key => $name) {
                    // Skip empty file names or invalid uploads
                    if (empty($name) || !isset($_FILES['attachment']['tmp_name'][$key])) {
                        continue;
                    }
                    
                    $tmp_name = $_FILES['attachment']['tmp_name'][$key];
                    $file_name = basename($name);
                    
                    // Create unique filename to prevent conflicts
                    $unique_name = uniqid() . "_" . time() . "_" . $file_name;
                    $file_path = $upload_dir . $unique_name;

                    // Validate file upload
                    if (is_uploaded_file($tmp_name) && move_uploaded_file($tmp_name, $file_path)) {
                        // Use prepared statement for security
                        $attachment_sql = "INSERT INTO attachment (incident_id, attachment, filename) VALUES (?, ?, ?)";
                        $attachment_stmt = $conn->prepare($attachment_sql);
                        $attachment_stmt->bind_param("iss", $incident_id, $file_path, $file_name);
                        $attachment_stmt->execute();
                        $attachment_stmt->close();
                        
                        $uploaded_files[] = $file_name;
                        error_log("Uploaded file: " . $file_name . " for incident ID: " . $incident_id);
                    }
                }
                
                error_log("Total files uploaded: " . count($uploaded_files) . " - Files: " . implode(", ", $uploaded_files));
            }

            // Send immediate success response to the user (avoid waiting for email)
            echo "<script src='../../js/sweetalert2.all.min.js'></script>
            <body onload='save()'></body>
            <script>
            function save(){
                Swal.fire({
                    title: 'Incident Reported Successfully!',
                    text: 'Your incident has been reported.',
                    icon: 'success',
                    confirmButtonText: 'View Reports'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'index.php';
                    }
                });
            }
            </script>";

            // Flush response to client now
            if (function_exists('fastcgi_finish_request')) {
                fastcgi_finish_request();
            } else {
                @ob_flush(); @flush();
            }

            // Continue: send email notification in the background (non-blocking for user)
            $query = "SELECT * FROM admin limit 1";
            $result = $conn->query($query);
            while ($row = $result->fetch_assoc()) {
                require_once('../../PHPMailer/PHPMailerAutoload.php');
                require_once('../../gmail_config.php'); // Load email configuration

                $mail = new PHPMailer;
                $mail->isSMTP();
                $mail->SMTPAuth = true;
                $mail->Host = SMTP_HOST;
                $mail->Port = SMTP_PORT;
                $mail->Username = SMTP_USERNAME;
                $mail->Password = SMTP_PASSWORD;
                $mail->SMTPSecure = SMTP_ENCRYPTION;
                $mail->CharSet = 'UTF-8';
                $mail->SMTPKeepAlive = false;
                $mail->Timeout = 10; // seconds
                // Force IPv4 if configured (helps on hosts with broken IPv6)
                if ((function_exists('env') ? env('SMTP_FORCE_IPV4', '0') : getenv('SMTP_FORCE_IPV4')) === '1') {
                    $resolved = gethostbyname(SMTP_HOST);
                    if (!empty($resolved) && $resolved !== SMTP_HOST) {
                        $mail->Host = $resolved;
                    }
                }

                $mail->setFrom(FROM_EMAIL, FROM_NAME);
                $mail->addReplyTo(defined('REPLY_TO_EMAIL') ? REPLY_TO_EMAIL : FROM_EMAIL, FROM_NAME);
                $mail->addAddress($row['email'], 'Receiver Name');
                $mail->Subject = 'New Incident Report';
                $mail->isHTML(true);

                $mail->Body = '
                <!DOCTYPE html>
                <html>
                <head>
                <style>
                    body {font-family: Arial, sans-serif;background-color: #f4f6f8;margin: 0;padding: 0;}
                    .container {background-color: #ffffff;max-width: 600px;margin: 30px auto;padding: 20px 30px;border-radius: 8px;box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);color: #333;}
                    .header {text-align: center;padding-bottom: 20px;}
                    .header h2 {margin: 0;color: #1a73e8;}
                    .content p {margin: 12px 0;font-size: 15px;}
                    .label {font-weight: bold;color: #555;}
                    .footer {margin-top: 30px;font-size: 13px;text-align: center;color: #888;}
                </style>
                </head>
                <body>
                <div class="container">
                    <div class="header"><h2>🚨 New Incident Report</h2></div>
                    <div class="content">
                    <p><span class="label">Title:</span> '.addslashes($title).'</p>
                    <p><span class="label">Category:</span> '.addslashes($category).'</p>
                    <p><span class="label">Date:</span> '.addslashes($date).'</p>
                    <p><span class="label">Description:</span><br>'.nl2br(htmlspecialchars($description)).'</p>
                    <p><span class="label">Reported By:</span> '.addslashes($_SESSION['name']).'</p>
                    </div>
                    <div class="footer">This is an automated message. Please do not reply.</div>
                </div>
                </body>
                </html>';

                if (!$mail->send()) {
                    error_log('Email not sent: ' . $mail->ErrorInfo);
                }
            }

            exit; // stop rendering the rest of the page in this POST
        } else 
        {
            echo "Error saving incident: " . $stmt->error;
        }
        
        $stmt->close();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>iReport</title>

    <!-- Custom fonts for this template (CDN to avoid /vendor 403) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

       <?php include'../sidebar.php';?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

               <?php include'../nav.php';?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                         <div class="container">

                            <div class="card o-hidden border-0 shadow-lg my-5">
                                <div class="card-body ">
                                    <!-- Nested Row within Card Body -->
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="">
                                                <a href="index.php" class="text-primary d-flex align-items-center mb-3" style="text-decoration: none;">
                                                    <i class="fas fa-arrow-left me-2"></i> Back to Manage Incidents
                                                </a>
                                                <div class="text-center">
                                                    <h1 class="h4 text-gray-900 mb-4">Report Incident</h1>
                                                </div>
                                                <form method="post" enctype="multipart/form-data" style="background: #fff; padding: 2rem; border-radius: 10px;  margin: auto;">
                                                    <div class="row">
                                                
                                                    <div class="form-group mb-3 col-lg-6 col-12">
                                                        <label for="title">Incident Title</label>
                                                        <input type="text" class="form-control" id="title" name="title" placeholder="e.g., Nabawasan ang laman ng Gcash ko" required>
                                                    </div>

                                                    <!-- Date of Incident -->
                                                    <div class="form-group mb-3  col-lg-6 col-12">
                                                        <label for="incident_date">Date and Time Discovered</label>
                                                        <input type="datetime-local" class="form-control" id="date" name="date" required>
                                                    </div>


                                                    <div class="form-group mb-3 col-lg-6 col-12">
                                                        <label for="title">Location/Address</label>
                                                        <input type="text" class="form-control" id="location" name="location" placeholder="e.g., 634 L. Deleon St. Brgy. Buhay Siniloan, Laguna" required>
                                                    </div>


                                                    <!-- Category -->
                                                    <!--<div class="form-group mb-3  col-lg-6 col-12">
                                                        <label for="category">Category</label>
                                                        <select class="form-control" id="category" name="category" required>
                                                            <option value="" disabled selected>Select a category</option>
                                                            <?php
                                                            // Check if incident_type table exists first
                                                            /*$table_check = $conn->query("SHOW TABLES LIKE 'incident_type'");
                                                            if ($table_check && $table_check->num_rows > 0) {
                                                                $query = "SELECT * FROM incident_type ";
                                                                $result = $conn->query($query);
                                                                if ($result && $result->num_rows > 0) {
                                                                    while ($row = $result->fetch_assoc()) {
                                                                        echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
                                                                    }
                                                                } else {
                                                                    echo '<option value="" disabled>No categories found</option>';
                                                                }
                                                            } else {
                                                                // Default categories if table doesn't exist
                                                                echo '<option value="Security Incident">Security Incident</option>';
                                                                echo '<option value="Network Issue">Network Issue</option>';
                                                                echo '<option value="System Malfunction">System Malfunction</option>';
                                                                echo '<option value="Data Breach">Data Breach</option>';
                                                                echo '<option value="Unauthorized Access">Unauthorized Access</option>';
                                                                echo '<option value="Other">Other</option>';
                                                            }*/
                                                            ?>
                                                        </select>
                                                    </div>-->

                                                    
                                                    <!--<div class="form-group mb-3 col-lg-6 col-12">
                                                        <label for="title">Severity Level</label>
                                                        <select class="form-control" id="severity_level" name="severity_level" required>
                                                            <option value="" disabled selected>Select severity level</option>
                                                            <option value="low">Low</option>
                                                            <option value="medium">Medium</option>
                                                            <option value="high">High</option>
                                                            <option value="critical">Critical</option>
                                                        </select>
                                                    </div>-->

                                                    <!-- Description -->
                                                    <div class="form-group mb-3  col-lg-12 col-12">
                                                        <label for="description">Description</label>
                                                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Please provide detailed information about the incident..." required></textarea>
                                                    </div>

                                                    <!-- Reporter Information -->
                                                    <div class="mb-4 col-lg-12">
                                                        <h6 class="fw-bold text-dark mb-3">
                                                            <i class="fas fa-user text-danger me-2"></i>Reporter Information
                                                        </h6>

                                                        <div class="row mb-3">
                                                            <div class="col-12 col-lg-6">
                                                                <label for="fullName" class="form-label">Full Name <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="fullName" name="full_name" placeholder="Enter full name" required>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <label for="address" class="form-label">Address</label>
                                                                <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-12 col-lg-6">
                                                                <label for="email" class="form-label">Contact Email <span class="text-danger">*</span></label>
                                                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <label for="phone" class="form-label">Contact Phone</label>
                                                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter contact number">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Actions Taken -->
                                                    <div class="mb-4 col-lg-12">
                                                        <div class="col-12 col-lg-12">
                                                            <h6 class="fw-bold text-dark mb-3">
                                                                <i class="fas fa-clipboard-check text-danger me-2"></i>Actions Taken
                                                            </h6>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-12">
                                                                <label for="actions_taken" class="form-label">What actions have been taken so far?</label>
                                                                <textarea class="form-control" id="actions_taken" name="actions_taken" rows="3" placeholder="Describe any immediate actions taken to address this incident (e.g., isolated affected systems, changed passwords, contacted IT support, etc.)"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-12">
                                                                <label class="form-label d-block">Evidence Available?</label>
                                                            
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="evidenceScreenshots" name="evidence_screenshots" value="1">
                                                                    <label class="form-check-label" for="evidenceScreenshots">Screenshots</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Attachments -->
                                                    <div class="mb-4 col-lg-12">
                                                        <div class="form-group mb-4">
                                                            <label style="width: 100%;">Attachments</label>

                                                            <!-- Upload Area Outside the Label -->
                                                            <div id="upload-area" style="border: 2px dashed #ccc; padding: 2rem; text-align: center; border-radius: 10px; cursor: pointer;">
                                                                <i class="fas fa-cloud" style="font-size: 30px; margin-bottom: 10px;"></i>
                                                                <p style="margin: 0;">Click to upload or drag and drop</p>
                                                                <small>Screenshots, logs, or other evidence (Max 10MB)</small>
                                                                <div id="file-preview" style="margin-top: 1rem; text-align: left;"></div>
                                                            </div>

                                                            <!-- Real Hidden File Input -->
                                                            <input type="file" name="attachment[]" id="file-upload" accept=".png,.jpg,.jpeg,.pdf,.log,.txt" style="display: none;" multiple>
                                                        </div>
                                                    </div>           

                                                    <!-- Additional Information -->
                                                    <div class="mb-4 col-lg-12">
                                                        <div class="col-12 col-lg-12">
                                                            <h6 class="fw-bold text-dark mb-3">
                                                                <i class="fas fa-info-circle text-danger me-2"></i>Additional Information
                                                            </h6>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-12">
                                                                <textarea class="form-control" id="additional_info" name="additional_info" rows="3" placeholder="Any additional details that might be relevant to this incident"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Submit Button -->
                                                    <div class="form-group d-flex justify-content-center">
                                                        <button type="submit" name="btn_save" class="btn btn-primary" style="background-color: #2563EB; border: none; padding: 12px 40px;">Submit Incident</button>
                                                    </div>
                                                </form>

                                                <hr>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

            </div>
        </div>
            
            <!-- End of Main Content -->

            <?php include'../footer.php';?>

        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../../logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Core JavaScript via CDN to avoid blocked /vendor assets -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin-2.min.js"></script>

    
    <!-- Page level plugins: DataTables (Bootstrap 4) -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../js/demo/datatables-demo.js"></script>
    <script>
      $(function () {
        $("#dataTable").DataTable({
          "responsive": true,
          "autoWidth": false,
          "bDestroy": true,
        });
      });
    </script>
    
    <script>
        const fileInput = document.getElementById('file-upload');
        const previewContainer = document.getElementById('file-preview');
        const uploadArea = document.getElementById('upload-area');

        uploadArea.addEventListener('click', () => {
            // Open file picker manually when user clicks the upload area
            fileInput.click();
        });

        fileInput.addEventListener('change', () => {
            previewContainer.innerHTML = ''; // Clear existing preview
            Array.from(fileInput.files).forEach(file => {
                const fileElement = document.createElement('div');
                fileElement.style.marginBottom = '5px';
                fileElement.style.fontSize = '14px';
                fileElement.innerHTML = `<i class="fas fa-paperclip"></i> ${file.name}`;
                previewContainer.appendChild(fileElement);
            });
        });
    </script>
</body>

</html>
<?php
}
else
{
    header('location:../../index.php');
}?>
