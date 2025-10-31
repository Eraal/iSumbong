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


if (isset($_POST['btn_save'])) {
    $status = $_POST['status'];

        $sql = "UPDATE incident SET status = '$status' WHERE id = $id";
        $result = mysqli_query($conn, $sql);

        $query = "SELECT * FROM users WHERE user_id = $user_id";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {
        require_once('../../PHPMailer/PHPMailerAutoload.php');
        
        // Load environment variables securely
        require_once('../../includes/env_loader.php');
        loadEnv('../../.env');
        
        $mail = new PHPMailer;
        $mail->isSMTP();
        //$mail->SMTPDebug = 2;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Username = env('SMTP_USERNAME');
        $mail->Password = env('SMTP_PASSWORD');
        $mail->setFrom(env('SMTP_USERNAME'), 'iSUMBONG System');
        $mail->addReplyTo(env('SMTP_USERNAME'), 'iSUMBONG System');
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
            padding: 10px 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .attachment-item:hover {
            background-color: #e9ecef;
            border-color: #007bff;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0,123,255,0.15);
        }
        
        .attachment-item .file-info {
            display: flex;
            align-items: center;
            flex: 1;
        }
        
        .attachment-item .file-info i {
            color: #007bff;
            margin-right: 8px;
        }
        
        .attachment-item .file-actions {
            display: flex;
            gap: 8px;
        }
        
        .page-break {
            page-break-before: always;
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
        
        @media (max-width: 576px) {
            .file-actions {
                flex-direction: column;
                gap: 5px;
            }
            
            .file-actions .btn {
                font-size: 0.75rem;
                padding: 0.25rem 0.5rem;
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
                        
                        <?php if (!empty($incident_data['location'])): ?>
                        <div class="field-row">
                            <div class="field-label">Location:</div>
                            <div class="field-value"><?= htmlspecialchars($incident_data['location']) ?></div>
                        </div>
                        <?php endif; ?>

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
                        
                        <?php if (!empty($incident_data['address'])): ?>
                        <div class="field-row">
                            <div class="field-label">Address:</div>
                            <div class="field-value"><?= htmlspecialchars($incident_data['address']) ?></div>
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
                                <i class="fas fa-file-text <?= $incident_data['evidence_logs'] ? 'evidence-yes' : 'evidence-no' ?>"></i>
                                <div><strong>System Logs</strong></div>
                                <div><?= $incident_data['evidence_logs'] ? 'Collected' : 'Not Collected' ?></div>
                                <?php if ($incident_data['evidence_logs']): ?>
                                <button class="btn btn-sm btn-primary no-print mt-2" onclick="viewEvidenceDetails('logs')">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <?php endif; ?>
                            </div>
                            <div class="evidence-item">
                                <i class="fas fa-image <?= $incident_data['evidence_screenshots'] ? 'evidence-yes' : 'evidence-no' ?>"></i>
                                <div><strong>Screenshots</strong></div>
                                <div><?= $incident_data['evidence_screenshots'] ? 'Collected' : 'Not Collected' ?></div>
                                <?php if ($incident_data['evidence_screenshots']): ?>
                                <?php endif; ?>
                            </div>
                            <div class="evidence-item">
                                <i class="fas fa-envelope <?= $incident_data['evidence_email'] ? 'evidence-yes' : 'evidence-no' ?>"></i>
                                <div><strong>Email Evidence</strong></div>
                                <div><?= $incident_data['evidence_email'] ? 'Collected' : 'Not Collected' ?></div>
                                <?php if ($incident_data['evidence_email']): ?>
                                <button class="btn btn-sm btn-primary no-print mt-2" onclick="viewEvidenceDetails('email')">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <?php endif; ?>
                            </div>
                            <div class="evidence-item">
                                <i class="fas fa-folder <?= $incident_data['evidence_other'] ? 'evidence-yes' : 'evidence-no' ?>"></i>
                                <div><strong>Other Evidence</strong></div>
                                <div><?= $incident_data['evidence_other'] ? 'Collected' : 'Not Collected' ?></div>
                                <?php if ($incident_data['evidence_other']): ?>
                                <button class="btn btn-sm btn-primary no-print mt-2" onclick="viewEvidenceDetails('other')">
                                    <i class="fas fa-eye"></i> View
                                </button>
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
                                echo '<li class="attachment-item">
                                        <div class="file-info">
                                            <i class="fas fa-file me-2"></i>
                                            <span>'.htmlspecialchars($row['filename']).'</span>
                                        </div>
                                        <div class="file-actions no-print">
                                            <button class="btn btn-sm btn-outline-primary" onclick="viewAttachment(\''.htmlspecialchars($row['attachment']).'\', \''.htmlspecialchars($row['filename']).'\')">
                                                <i class="fas fa-eye"></i> View
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

    <!-- Evidence Modal -->
    <div class="modal fade" id="evidenceModal" tabindex="-1" role="dialog" aria-labelledby="evidenceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="evidenceModalLabel">Evidence Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="evidenceModalBody">
                    <!-- Evidence content will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Attachment Modal -->
    <div class="modal fade" id="attachmentModal" tabindex="-1" role="dialog" aria-labelledby="attachmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="attachmentModalLabel">File Viewer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="attachmentModalBody">
                    <!-- Attachment content will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a id="downloadLink" href="#" class="btn btn-primary" download>
                        <i class="fas fa-download"></i> Download
                    </a>
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

      // Evidence viewing function
      function viewEvidenceDetails(evidenceType) {
          const evidenceData = {
              logs: {
                  title: 'System Logs Evidence',
                  icon: 'fas fa-file-text',
                  content: `
                      <div class="alert alert-info">
                          <i class="fas fa-info-circle"></i>
                          <strong>System Logs Collected</strong><br>
                          This evidence type indicates that system logs have been collected for this incident.
                      </div>
                      <h6>Evidence Type Details:</h6>
                      <ul>
                          <li><strong>Type:</strong> System Logs</li>
                          <li><strong>Status:</strong> Collected</li>
                          <li><strong>Description:</strong> System logs provide detailed information about system events, errors, and activities related to the incident.</li>
                      </ul>
                      <div class="mt-3">
                          <small class="text-muted">For detailed log files, check the attached files section below.</small>
                      </div>
                  `
              },
              screenshots: {
                  title: 'Screenshots Evidence',
                  icon: 'fas fa-image',
                  content: `
                      <div class="alert alert-success">
                          <i class="fas fa-check-circle"></i>
                          <strong>Screenshots Collected</strong><br>
                          Visual evidence has been captured for this incident.
                      </div>
                      <h6>Evidence Type Details:</h6>
                      <ul>
                          <li><strong>Type:</strong> Screenshots</li>
                          <li><strong>Status:</strong> Collected</li>
                          <li><strong>Description:</strong> Screenshots provide visual documentation of the incident, including error messages, system states, or problematic content.</li>
                      </ul>
                      <div class="mt-3">
                          <small class="text-muted">Screenshot files can be viewed and downloaded from the attached files section.</small>
                      </div>
                  `
              },
              email: {
                  title: 'Email Evidence',
                  icon: 'fas fa-envelope',
                  content: `
                      <div class="alert alert-warning">
                          <i class="fas fa-exclamation-triangle"></i>
                          <strong>Email Evidence Collected</strong><br>
                          Email communications related to this incident have been preserved.
                      </div>
                      <h6>Evidence Type Details:</h6>
                      <ul>
                          <li><strong>Type:</strong> Email Evidence</li>
                          <li><strong>Status:</strong> Collected</li>
                          <li><strong>Description:</strong> Email evidence includes relevant email communications, headers, and metadata that pertain to the incident.</li>
                      </ul>
                      <div class="mt-3">
                          <small class="text-muted">Email evidence files are available in the attachments section for review.</small>
                      </div>
                  `
              },
              other: {
                  title: 'Other Evidence',
                  icon: 'fas fa-folder',
                  content: `
                      <div class="alert alert-secondary">
                          <i class="fas fa-folder-open"></i>
                          <strong>Additional Evidence Collected</strong><br>
                          Other types of evidence have been gathered for this incident.
                      </div>
                      <h6>Evidence Type Details:</h6>
                      <ul>
                          <li><strong>Type:</strong> Other Evidence</li>
                          <li><strong>Status:</strong> Collected</li>
                          <li><strong>Description:</strong> This category includes any additional evidence types such as documents, recordings, or other digital artifacts relevant to the incident.</li>
                      </ul>
                      <div class="mt-3">
                          <small class="text-muted">Additional evidence files can be accessed through the attached files section.</small>
                      </div>
                  `
              }
          };

          const evidence = evidenceData[evidenceType];
          if (evidence) {
              $('#evidenceModalLabel').html('<i class="' + evidence.icon + ' mr-2"></i>' + evidence.title);
              $('#evidenceModalBody').html(evidence.content);
              $('#evidenceModal').modal('show');
          }
      }

      // Attachment viewing function
      function viewAttachment(filePath, fileName) {
          const fileExtension = fileName.split('.').pop().toLowerCase();
          const isImage = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'].includes(fileExtension);
          const isPDF = fileExtension === 'pdf';
          
          let content = '';
          
          if (isImage) {
              content = `
                  <div class="text-center">
                      <img src="${filePath}" class="img-fluid" style="max-height: 70vh; border-radius: 5px;" alt="${fileName}">
                  </div>
                  <div class="mt-3">
                      <h6>File Details:</h6>
                      <ul class="list-unstyled">
                          <li><strong>Filename:</strong> ${fileName}</li>
                          <li><strong>Type:</strong> Image</li>
                          <li><strong>Format:</strong> ${fileExtension.toUpperCase()}</li>
                      </ul>
                  </div>
              `;
          } else if (isPDF) {
              content = `
                  <div class="embed-responsive embed-responsive-16by9">
                      <iframe class="embed-responsive-item" src="${filePath}" style="height: 70vh; border: 1px solid #ddd; border-radius: 5px;"></iframe>
                  </div>
                  <div class="mt-3">
                      <h6>File Details:</h6>
                      <ul class="list-unstyled">
                          <li><strong>Filename:</strong> ${fileName}</li>
                          <li><strong>Type:</strong> PDF Document</li>
                      </ul>
                  </div>
              `;
          } else {
              content = `
                  <div class="alert alert-info text-center">
                      <i class="fas fa-file fa-3x mb-3"></i>
                      <h5>${fileName}</h5>
                      <p>This file type cannot be previewed directly. Please download the file to view its contents.</p>
                      <hr>
                      <h6>File Details:</h6>
                      <ul class="list-unstyled">
                          <li><strong>Filename:</strong> ${fileName}</li>
                          <li><strong>Type:</strong> ${fileExtension.toUpperCase()} File</li>
                      </ul>
                  </div>
              `;
          }
          
          $('#attachmentModalLabel').html('<i class="fas fa-file mr-2"></i>' + fileName);
          $('#attachmentModalBody').html(content);
          $('#downloadLink').attr('href', filePath).attr('download', fileName);
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
}