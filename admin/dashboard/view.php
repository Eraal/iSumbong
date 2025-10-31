<?php
include('../../connectMySql.php');
include '../../loginverification.php';
if(logged_in()){

$id = $_GET['id'];
$title = "";
$category = "";
$date = "";
$description = "";
$status = "";
$user_id = "";
$suggestion = "";

$query = "SELECT a.*, a.created_at FROM incident a 
WHERE a.id = '".$id."'";
$result = $conn->query($query);
$incident_data = [];
while ($row = $result->fetch_assoc()) {
$incident_data = $row;
$color = "";
if($row['status']=='PENDING'){
$color = "danger";
}
else if($row['status']=='INVESTIGATING'){
$color = "warning";
}
else if($row['status']=='RESOLVED'){
$color = "success";
}
$title = $row['title'];
$category = $row['category'];
$date = $row['date'];
$description = $row['description'];
$status = $row['status'];
$user_id = $row['user_id'];
$suggestion = $row['suggestion'];
}


if (isset($_POST['btn_save'])) {
    $status = $_POST['status'];

        $sql = "UPDATE incident SET status = '$status' WHERE id = $id";
        $result = mysqli_query($conn, $sql);

        $query = "SELECT * FROM users WHERE user_id = $user_id";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {
    require_once('../../PHPMailer/PHPMailerAutoload.php');
    require_once('../../gmail_config.php');

    $mail = new PHPMailer;
    $mail->isSMTP();
    //$mail->SMTPDebug = 2;
    $mail->Host = SMTP_HOST;
    $mail->Port = SMTP_PORT;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = SMTP_ENCRYPTION;
    $mail->Username = SMTP_USERNAME;
    $mail->Password = SMTP_PASSWORD;
    // Avoid long hangs
    $mail->Timeout = 15;
    $mail->SMTPKeepAlive = false;
    $mail->setFrom(FROM_EMAIL, FROM_NAME);
    $mail->addReplyTo(REPLY_TO_EMAIL ?: FROM_EMAIL, FROM_NAME);
        $mail->addAddress( $row['email'] , 'Receiver Name');
        $mail->isHTML(true);
        $mail->Subject = 'Update Incident Report';
        $mail->Body = '
        <!DOCTYPE html>
        <html>
        <head>
        <style>
            body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
            }
            .container {
            background-color: #ffffff;
            max-width: 600px;
            margin: 30px auto;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            color: #333;
            }
            .header {
            text-align: center;
            padding-bottom: 20px;
            }
            .header h2 {
            margin: 0;
            color: #f57c00;
            }
            .content p {
            margin: 12px 0;
            font-size: 15px;
            }
            .label {
            font-weight: bold;
            color: #555;
            }
            .footer {
            margin-top: 30px;
            font-size: 13px;
            text-align: center;
            color: #888;
            }
        </style>
        </head>
        <body>
        <div class="container">
            <div class="header">
            <h2>⚠️ Incident Report Update</h2>
            </div>
            <div class="content">
            <p><span class="label">Status:</span> '.$status.'</p>
            <p><span class="label">Title:</span> '.$title.'</p>
            <p><span class="label">Category:</span> '.$category.'</p>
            <p><span class="label">Date:</span> '.$date.'</p>
            <p><span class="label">Description:</span><br>'.$description.'</p>
            <p><span class="label">Reported By:</span> '.$_SESSION['name'].'</p>
            </div>
            <div class="footer">
            This is an automated message regarding the incident status update.
            </div>
        </div>
        </body>
        </html>';
        if (!$mail->send()) {
            echo 'Email not valid : ' . $mail->ErrorInfo;
            return;
        } else {
                echo "<script src='js/sweetalert2.all.min.js'></script>
                <body onload='success()'></body>
                <script> 
                function success(){
                Swal.fire({
                    icon: 'success',
                    title: 'Email Sent'
                })
                }</script>";
        }
        }


        echo "<script src='../../js/sweetalert2.all.min.js'></script>
        <body onload='save()'></body>
        <script> 
        function save(){
            Swal.fire(
                'Record Updated!',
                '',
                'success'
            ).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'index.php';
                }
            });
        }
        </script>";

    }


    if (isset($_POST['btn_comment'])) {
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $incident_id = $id; // Replace with the actual related incident ID
    $user_id = $_SESSION['name']; // Replace with the current logged-in user

    $sql = "INSERT INTO comments (incident_id, user_id, comment, date) 
            VALUES ('$incident_id', '$user_id', '$comment', NOW())";

    if (mysqli_query($conn, $sql)) {
       
    } else {
        echo "Error saving comment: " . mysqli_error($conn);
    }
}


$query = "SELECT a.* FROM incident a 
WHERE a.id = '".$id."'";
$result = $conn->query($query);
$incident_data = [];
while ($row = $result->fetch_assoc()) {
$incident_data = $row;
$color = "";
if($row['status']=='PENDING'){
$color = "danger";
}
else if($row['status']=='INVESTIGATING'){
$color = "warning";
}
else if($row['status']=='RESOLVED'){
$color = "success";
}
$title = $row['title'];
$category = $row['category'];
$date = $row['date'];
$description = $row['description'];
$status = $row['status'];
$user_id = $row['user_id'];
$suggestion = $row['suggestion'];
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

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Fallback CDN for Font Awesome in case local fonts fail to load -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
    
    <!-- Custom styles for document view -->
    <style>
        /* Document-style report styling */
        @media print {
            .no-print { display: none !important; }
            .card { border: 1px solid #dee2e6 !important; box-shadow: none !important; }
            .container-fluid { padding: 0 !important; }
            .card-body { padding: 15px !important; }
            body { font-size: 12pt; }
            .document-container { max-width: none !important; }
        }
        
        .document-container {
            background: white;
            font-family: 'Times New Roman', serif;
            line-height: 1.6;
            color: #333;
            max-width: 900px;
            margin: 0 auto;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        
        .document-header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 25px;
            margin-bottom: 35px;
        }
        
        .document-title {
            font-family: 'Times New Roman', serif;
            font-size: 2.5rem;
            font-weight: bold;
            letter-spacing: 3px;
            margin-bottom: 10px;
            color: #000;
        }
        
        .document-subtitle {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 15px;
        }
        
        .report-meta {
            font-size: 0.95rem;
            color: #777;
            margin-top: 15px;
        }
        
        .section-header {
            font-size: 1.3rem;
            font-weight: bold;
            color: #000;
            border-bottom: 2px solid #007bff;
            padding-bottom: 8px;
            margin-top: 30px;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .field-row {
            display: flex;
            margin-bottom: 12px;
            border-bottom: 1px dotted #ddd;
            padding-bottom: 8px;
        }
        
        .field-label {
            font-weight: bold;
            min-width: 180px;
            color: #000;
            font-size: 0.95rem;
        }
        
        .field-value {
            flex: 1;
            padding-left: 15px;
            color: #333;
            font-size: 0.95rem;
        }
        
        .description-box {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            font-size: 0.95rem;
            line-height: 1.7;
        }
        
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .status-pending { background-color: #dc3545; color: white; }
        .status-investigating { background-color: #ffc107; color: #000; }
        .status-resolved { background-color: #28a745; color: white; }
        
        .evidence-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        
        .evidence-item {
            text-align: center;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        
        .evidence-item i {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        
        .evidence-yes { color: #28a745; }
        .evidence-no { color: #6c757d; }
        
        .attachment-list {
            list-style: none;
            padding: 0;
        }
        
        .attachment-item {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 15px 20px;
            margin-bottom: 10px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .attachment-item:hover {
            background-color: #e9ecef;
            border-color: #007bff;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .attachment-info {
            display: flex;
            align-items: center;
            flex: 1;
        }
        
        .attachment-name {
            font-weight: 500;
            color: #333;
            font-size: 0.95rem;
        }
        
        .attachment-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        
        .attachment-actions .btn {
            padding: 6px 12px;
            font-size: 0.875rem;
            border-radius: 6px;
            min-width: 80px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        
        .attachment-actions .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }
        
        .attachment-actions .btn .btn-text {
            font-weight: 500;
        }
        
        .attachment-actions .btn i {
            font-size: 0.8rem;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        /* Clean up form styling for document view */
        .no-print {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            margin-top: 30px;
        }
        
        .control-buttons {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            display: flex;
            gap: 10px;
        }
        
        /* Fixed sidebar styles */
        #wrapper {
            overflow-x: hidden;
        }
        
        #wrapper #content-wrapper {
            background-color: #f8f9fa;
            width: 100%;
            overflow-x: hidden;
        }
        
        #wrapper.toggled #accordionSidebar {
            margin-left: -224px;
        }
        
        #accordionSidebar {
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 224px;
            z-index: 100;
        }
        
        #content-wrapper {
            margin-left: 224px;
            min-height: 100vh;
        }
        
        @media (max-width: 768px) {
            .document-container {
                padding: 15px;
                margin: 10px;
            }
            
            .field-row {
                flex-direction: column;
            }
            
            .field-label {
                min-width: auto;
                margin-bottom: 5px;
            }
            
            .field-value {
                padding-left: 0;
            }
            
            .control-buttons {
                position: relative;
                top: auto;
                right: auto;
                justify-content: center;
                margin-bottom: 20px;
            }
            
            .attachment-item {
                flex-direction: column;
                align-items: flex-start;
                padding: 15px;
            }
            
            .attachment-info {
                margin-bottom: 10px;
                width: 100%;
            }
            
            .attachment-actions {
                width: 100%;
                justify-content: space-between;
            }
            
            .attachment-actions .btn {
                flex: 1;
                margin: 0 4px;
                min-width: auto;
            }
            
            /* Fixed sidebar responsive styles */
            #accordionSidebar {
                margin-left: -224px;
            }
            
            #wrapper.toggled #accordionSidebar {
                margin-left: 0;
            }
            
            #content-wrapper {
                margin-left: 0;
            }
        }
    </style>

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
                    <!-- Control Buttons -->
                    <div class="control-buttons no-print">
                        <a href="index.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Reports
                        </a>
                        <button onclick="window.print()" class="btn btn-primary">
                            <i class="fas fa-print me-2"></i>Print Report
                        </button>
                    </div>

                    <!-- Document Container -->
                    <div class="document-container">
                        
                        <!-- Document Header -->
                        <div class="document-header">
                            <h1 class="document-title">INCIDENT REPORT</h1>
                            <div class="document-subtitle">Official Investigation Document</div>
                            <div class="status-badge status-<?= strtolower($status) ?>"><?= $status ?></div>
                            <div class="report-meta">
                                <strong>Report ID:</strong> #<?= str_pad($id, 6, '0', STR_PAD_LEFT) ?> | 
                                <strong>Generated:</strong> <?= date('F j, Y \a\t g:i A') ?>
                            </div>
                        </div>

                        <!-- Report Information Section -->
                        <div class="section-header">
                            <i class="fas fa-info-circle me-2"></i>Report Information
                        </div>
                        
                        <div class="field-row">
                            <div class="field-label">Report ID:</div>
                            <div class="field-value">#<?= str_pad($id, 6, '0', STR_PAD_LEFT) ?></div>
                        </div>
                        
                        <div class="field-row">
                            <div class="field-label">Incident Title:</div>
                            <div class="field-value"><?= htmlspecialchars($incident_data['title']) ?></div>
                        </div>
                        
                        <div class="field-row">
                            <div class="field-label">Category:</div>
                            <div class="field-value"><?= htmlspecialchars($incident_data['category']) ?></div>
                        </div>
                        
                        <div class="field-row">
                            <div class="field-label">Date Reported:</div>
                            <div class="field-value"><?= date('F j, Y \a\t g:i A', strtotime($incident_data['date'])) ?></div>
                        </div>
                        
                        <div class="field-row">
                            <div class="field-label">Date Created:</div>
                            <div class="field-value"><?= date('F j, Y \a\t g:i A', strtotime($incident_data['created_at'])) ?></div>
                        </div>
                        
                        <?php if (!empty($incident_data['location'])): ?>
                        <div class="field-row">
                            <div class="field-label">Incident Location:</div>
                            <div class="field-value"><?= htmlspecialchars($incident_data['location']) ?></div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="field-row">
                            <div class="field-label">Current Status:</div>
                            <div class="field-value">
                                <span class="status-badge status-<?= strtolower($status) ?>"><?= $status ?></span>
                            </div>
                        </div>
                        
                        <div class="field-row">
                            <div class="field-label">Severity Level:</div>
                            <div class="field-value"><?= htmlspecialchars($incident_data['severity_level']) ?></div>
                        </div>

                        <!-- Reporter Information Section -->
                        <div class="section-header">
                            <i class="fas fa-user me-2"></i>Reporter Information
                        </div>
                        
                        <div class="field-row">
                            <div class="field-label">Full Name:</div>
                            <div class="field-value"><?= htmlspecialchars($incident_data['full_name']) ?></div>
                        </div>
                        
                        <div class="field-row">
                            <div class="field-label">Email Address:</div>
                            <div class="field-value"><?= htmlspecialchars($incident_data['email']) ?></div>
                        </div>
                        
                        <?php if (!empty($incident_data['address'])): ?>
                        <div class="field-row">
                            <div class="field-label">Address:</div>
                            <div class="field-value"><?= htmlspecialchars($incident_data['address']) ?></div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($incident_data['phone'])): ?>
                        <div class="field-row">
                            <div class="field-label">Phone Number:</div>
                            <div class="field-value"><?= htmlspecialchars($incident_data['phone']) ?></div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($incident_data['role'])): ?>
                        <div class="field-row">
                            <div class="field-label">Role/Position:</div>
                            <div class="field-value"><?= htmlspecialchars($incident_data['role']) ?></div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($incident_data['department'])): ?>
                        <div class="field-row">
                            <div class="field-label">Department:</div>
                            <div class="field-value"><?= htmlspecialchars($incident_data['department']) ?></div>
                        </div>
                        <?php endif; ?>

                        <!-- Incident Description Section -->
                        <div class="section-header">
                            <i class="fas fa-clipboard-list me-2"></i>Incident Description
                        </div>
                        
                        <div class="description-box">
                            <?= nl2br(htmlspecialchars($incident_data['description'])) ?>
                        </div>

                        <!-- Evidence Section -->
                        <div class="section-header">
                            <i class="fas fa-file-alt me-2"></i>Evidence Collected
                        </div>
                        
                        <div class="evidence-grid">
                            
                            <div class="evidence-item">
                                <i class="fas fa-image <?= $incident_data['evidence_screenshots'] ? 'evidence-yes' : 'evidence-no' ?>"></i>
                                <div><strong>Screenshots</strong></div>
                                <div><?= $incident_data['evidence_screenshots'] ? 'Collected' : 'Not Collected' ?></div>
                                <?php if ($incident_data['evidence_screenshots']): ?>
                                
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- File Attachments -->
                        <?php
                        $query = "SELECT * FROM attachment WHERE incident_id = '".$id."'";
                        $result = $conn->query($query);
                        if ($result->num_rows > 0):
                        ?>
                        <div class="section-header">
                            <i class="fas fa-paperclip me-2"></i>Attached Files
                        </div>
                        
                        <ul class="attachment-list">
                            <?php
                            while ($row = $result->fetch_assoc()) {
                                $file_extension = pathinfo($row['filename'], PATHINFO_EXTENSION);
                                $is_image = in_array(strtolower($file_extension), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']);
                                
                                echo '<li class="attachment-item">
                                        <div class="attachment-info">
                                            <i class="fas fa-file me-2"></i>
                                            <span class="attachment-name">'.htmlspecialchars($row['filename']).'</span>
                                        </div>
                                        <div class="attachment-actions no-print">
                                            <button class="btn btn-sm btn-outline-primary me-2" onclick="viewAttachment(\''.htmlspecialchars($row['attachment']).'\', \''.htmlspecialchars($row['filename']).'\', '.($is_image ? 'true' : 'false').')">
                                                <i class="fas fa-eye"></i>
                                                <span class="btn-text">View</span>
                                            </button>
                                            <a href="'.htmlspecialchars($row['attachment']).'" download="'.htmlspecialchars($row['filename']).'" class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        </div>
                                    </li>';
                            }
                            ?>
                        </ul>
                        <?php endif; ?>

                        <!-- Additional Information Section -->
                        <?php if (!empty($incident_data['additional_info'])): ?>
                        <div class="section-header">
                            <i class="fas fa-plus-circle me-2"></i>Additional Information
                        </div>
                        
                        <div class="description-box">
                            <?= nl2br(htmlspecialchars($incident_data['additional_info'])) ?>
                        </div>
                        <?php endif; ?>

                        <!-- Report Footer -->
                        <div style="margin-top: 50px; border-top: 2px solid #000; padding-top: 20px; text-align: center;">
                            <p style="font-size: 0.9rem; color: #666;">
                                <strong>End of Report</strong><br>
                                This document contains confidential information and should be handled according to organizational security policies.
                            </p>
                        </div>

                    </div>
                    <!-- End Document Container -->

                    <!-- Administrative Controls (No Print) -->
                    <div class="no-print">
                        <div style="background: white; padding: 30px; margin-top: 30px; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
                            
                            <!-- Comments Section -->
                            <h5><i class="fas fa-comments me-2"></i>Administrative Comments</h5>
                            
                            <!-- Comment Form -->
                            <form method="post" class="mb-4">
                                <div class="mb-3">
                                    <label for="commentInput" class="form-label">Add Comment:</label>
                                    <textarea class="form-control" name="comment" id="commentInput" rows="3" placeholder="Enter your administrative comment here..."></textarea>
                                </div>
                                <button type="submit" name="btn_comment" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Post Comment
                                </button>
                            </form>
                            
                            <!-- Existing Comments -->
                            <?php
                            $query = "SELECT * FROM comments WHERE incident_id = '".$id."' ORDER BY date DESC";
                            $result = $conn->query($query);
                            if ($result->num_rows > 0):
                            ?>
                            <hr>
                            <h6>Comment History</h6>
                            <?php
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="border-start border-primary border-3 ps-3 mb-3">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-1">'.$row['user_id'].'</h6>
                                            <small class="text-muted">'.$row['date'].'</small>
                                        </div>
                                        <p class="mb-0">'.$row['comment'].'</p>
                                    </div>';
                            }
                            ?>
                            <?php endif; ?>

                            <!-- Status Update Form -->
                            <hr>
                            <form method="post">
                                <h5><i class="fas fa-edit me-2"></i>Update Status</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="" disabled>Select new status</option>
                                            <option value="PENDING" <?= ($status == 'PENDING') ? 'selected' : '' ?>>PENDING</option>
                                            <option value="INVESTIGATING" <?= ($status == 'INVESTIGATING') ? 'selected' : '' ?>>INVESTIGATING</option>
                                            <option value="RESOLVED" <?= ($status == 'RESOLVED') ? 'selected' : '' ?>>RESOLVED</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <button name="btn_save" type="submit" class="btn btn-success">
                                            <i class="fas fa-save me-2"></i>Update Status
                                        </button>
                                    </div>
                                </div>
                            </form>
                            
                        </div>
                    </div>            </div>
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

    <!-- Evidence Details Modal -->
    <div class="modal fade" id="evidenceModal" tabindex="-1" role="dialog" aria-labelledby="evidenceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="evidenceModalLabel">
                        <i class="fas fa-file-alt me-2"></i>Evidence Details
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="evidenceModalBody">
                    <!-- Evidence details will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Attachment Viewer Modal -->
    <div class="modal fade" id="attachmentModal" tabindex="-1" role="dialog" aria-labelledby="attachmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="attachmentModalLabel">
                        <i class="fas fa-paperclip me-2"></i>Attachment Viewer
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="attachmentModalBody">
                    <!-- Attachment will be displayed here -->
                </div>
                <div class="modal-footer">
                    <a href="#" id="downloadAttachmentBtn" class="btn btn-success" target="_blank">
                        <i class="fas fa-download"></i> Download
                    </a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

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

    <!-- Bootstrap core JavaScript-->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin-2.min.js"></script>

    
    <!-- Page level plugins -->
    <script src="../../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../vendor/datatables/dataTables.bootstrap4.min.js"></script>

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

      // Function to view evidence details
      function viewEvidenceDetails(evidenceType) {
          const incidentId = <?= $id ?>;
          let modalContent = '';
          
          switch(evidenceType) {
              case 'logs':
                  modalContent = `
                      <div class="alert alert-info">
                          <h6><i class="fas fa-file-text me-2"></i>System Logs Evidence</h6>
                          <p>System logs have been collected for incident #${incidentId.toString().padStart(6, '0')}.</p>
                          <p><strong>Evidence Type:</strong> System Logs<br>
                          <strong>Status:</strong> Collected<br>
                          <strong>Collection Date:</strong> <?= date('F j, Y \a\t g:i A', strtotime($incident_data['created_at'])) ?></p>
                      </div>
                      <div class="evidence-note">
                          <h6>Log Details:</h6>
                          <p>System logs contain important information about the incident including timestamps, user activities, and system events that occurred during the incident timeframe.</p>
                      </div>
                  `;
                  break;
              case 'screenshots':
                  modalContent = `
                      <div class="alert alert-success">
                          <h6><i class="fas fa-image me-2"></i>Screenshots Evidence</h6>
                          <p>Screenshots have been collected for incident #${incidentId.toString().padStart(6, '0')}.</p>
                          <p><strong>Evidence Type:</strong> Screenshots<br>
                          <strong>Status:</strong> Collected<br>
                          <strong>Collection Date:</strong> <?= date('F j, Y \a\t g:i A', strtotime($incident_data['created_at'])) ?></p>
                      </div>
                      <div class="evidence-note">
                          <h6>Screenshot Details:</h6>
                          <p>Screenshots provide visual evidence of the incident including error messages, suspicious activities, or other relevant visual information captured at the time of the incident.</p>
                      </div>
                  `;
                  break;
              case 'email':
                  modalContent = `
                      <div class="alert alert-warning">
                          <h6><i class="fas fa-envelope me-2"></i>Email Evidence</h6>
                          <p>Email evidence has been collected for incident #${incidentId.toString().padStart(6, '0')}.</p>
                          <p><strong>Evidence Type:</strong> Email Evidence<br>
                          <strong>Status:</strong> Collected<br>
                          <strong>Collection Date:</strong> <?= date('F j, Y \a\t g:i A', strtotime($incident_data['created_at'])) ?></p>
                      </div>
                      <div class="evidence-note">
                          <h6>Email Details:</h6>
                          <p>Email evidence includes phishing emails, suspicious communications, or other email-related artifacts that are relevant to the cybersecurity incident.</p>
                      </div>
                  `;
                  break;
              case 'other':
                  modalContent = `
                      <div class="alert alert-secondary">
                          <h6><i class="fas fa-folder me-2"></i>Other Evidence</h6>
                          <p>Additional evidence has been collected for incident #${incidentId.toString().padStart(6, '0')}.</p>
                          <p><strong>Evidence Type:</strong> Other Evidence<br>
                          <strong>Status:</strong> Collected<br>
                          <strong>Collection Date:</strong> <?= date('F j, Y \a\t g:i A', strtotime($incident_data['created_at'])) ?></p>
                      </div>
                      <div class="evidence-note">
                          <h6>Additional Evidence Details:</h6>
                          <p>This category includes any other relevant evidence that doesn't fit into the standard categories but is important for the investigation of this cybersecurity incident.</p>
                      </div>
                  `;
                  break;
          }
          
          document.getElementById('evidenceModalBody').innerHTML = modalContent;
          $('#evidenceModal').modal('show');
      }

      // Function to view attachments
      function viewAttachment(filePath, fileName, isImage) {
          const modalTitle = document.getElementById('attachmentModalLabel');
          const modalBody = document.getElementById('attachmentModalBody');
          const downloadBtn = document.getElementById('downloadAttachmentBtn');
          
          modalTitle.innerHTML = `<i class="fas fa-paperclip me-2"></i>${fileName}`;
          downloadBtn.href = filePath;
          
          if (isImage) {
              modalBody.innerHTML = `
                  <div class="text-center">
                      <img src="${filePath}" class="img-fluid" alt="${fileName}" style="max-height: 70vh; border: 1px solid #ddd; border-radius: 5px;">
                  </div>
              `;
          } else {
              const fileExtension = fileName.split('.').pop().toLowerCase();
              let icon = 'fas fa-file';
              let description = 'File';
              
              switch(fileExtension) {
                  case 'pdf':
                      icon = 'fas fa-file-pdf';
                      description = 'PDF Document';
                      break;
                  case 'doc':
                  case 'docx':
                      icon = 'fas fa-file-word';
                      description = 'Word Document';
                      break;
                  case 'xls':
                  case 'xlsx':
                      icon = 'fas fa-file-excel';
                      description = 'Excel Document';
                      break;
                  case 'txt':
                      icon = 'fas fa-file-alt';
                      description = 'Text Document';
                      break;
                  case 'zip':
                  case 'rar':
                      icon = 'fas fa-file-archive';
                      description = 'Archive File';
                      break;
              }
              
              modalBody.innerHTML = `
                  <div class="text-center py-5">
                      <i class="${icon}" style="font-size: 5rem; color: #6c757d; margin-bottom: 20px;"></i>
                      <h4>${fileName}</h4>
                      <p class="text-muted">${description}</p>
                      <p class="text-info">Click "Download" to view this file on your device.</p>
                      <a href="${filePath}" target="_blank" class="btn btn-primary btn-lg">
                          <i class="fas fa-external-link-alt me-2"></i>Open in New Tab
                      </a>
                  </div>
              `;
          }
          
          $('#attachmentModal').modal('show');
      }
    </script>
</body>

</html>
<?php
}
else
{
    header('location:../../index.php');
}?>