<?php
include('../../connectMySql.php');
include '../../loginverification.php';

if (logged_in()) {
    if (isset($_POST['btn_save'])) {
        $title = $_POST['title'];
        $category = $_POST['category'];
        $date = $_POST['date'];
        $description = $_POST['description'];
        $system_affected = $_POST['system_affected'];
        $severity_level = $_POST['severity_level'];
        $full_name = $_POST['full_name'];
        $role = $_POST['role'];
        $department = $_POST['department'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $systems_affected = $_POST['systems_affected'];
        $estimated_impact = $_POST['estimated_impact'];
        $critical_infra = $_POST['critical_infra'] ?? '';
        $observed_impact = $_POST['observed_impact'];
        $actions_taken = $_POST['actions_taken'];
        $incident_contained = $_POST['incident_contained'] ?? '';
        $notified = $_POST['notified'];
        $evidence_logs = isset($_POST['evidence_logs']) ? 1 : 0;
        $evidence_screenshots = isset($_POST['evidence_screenshots']) ? 1 : 0;
        $evidence_email = isset($_POST['evidence_email']) ? 1 : 0;
        $evidence_other = isset($_POST['evidence_other']) ? 1 : 0;
        $additional_info = $_POST['additional_info'];

        $sql = "INSERT INTO incident (
            title, category, date, description, system_affected, severity_level,
            full_name, role, department, email, phone,
            systems_affected, estimated_impact, critical_infra, observed_impact,
            actions_taken, incident_contained, notified,
            evidence_logs, evidence_screenshots, evidence_email, evidence_other,
            additional_info
        ) VALUES (
            '$title', '$category', '$date', '$description', '$system_affected', '$severity_level',
            '$full_name', '$role', '$department', '$email', '$phone',
            '$systems_affected', '$estimated_impact', '$critical_infra', '$observed_impact',
            '$actions_taken', '$incident_contained', '$notified',
            '$evidence_logs', '$evidence_screenshots', '$evidence_email', '$evidence_other',
            '$additional_info')";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            $incident_id = mysqli_insert_id($conn);

            if (!empty($_FILES['attachment']['name'][0])) {
                $upload_dir = "../../uploads/";

                foreach ($_FILES['attachment']['name'] as $key => $name) {
                    $tmp_name = $_FILES['attachment']['tmp_name'][$key];
                    $file_name = basename($name);
                    $file_path = $upload_dir . time() . "_" . $file_name;

                    if (move_uploaded_file($tmp_name, $file_path)) {
                        $attachment_sql = "INSERT INTO attachment (incident_id, attachment, filename)
                                           VALUES ('$incident_id', '$file_path', '$file_name')";
                        mysqli_query($conn, $attachment_sql);
                    }
                }
            }

            echo "<script src='../../js/sweetalert2.all.min.js'></script>
            <body onload='save()'></body>
            <script> 
            function save(){
                Swal.fire(
                    'Record Saved!',
                    '',
                    'success'
                ).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'index.php';
                    }
                });
            }
            </script>";
        } else {
            echo "Error saving incident: " . mysqli_error($conn);
        }
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

    <title>iReport - New Incident</title>
    <link rel="icon" type="image/x-icon" href="../../img/logo1.jpg" />
    <link rel="icon" type="image/png" sizes="32x32" href="../../img/logo1.jpg">
    <link rel="icon" type="image/png" sizes="16x16" href="../../img/logo1.jpg">
    <link rel="apple-touch-icon" sizes="180x180" href="../../img/logo1.jpg">

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
    
    <style>
        /* Custom styles for fixed sidebar */
        #wrapper {
            height: 100vh;
            overflow: hidden;
        }
        
        .sidebar {
            position: fixed !important;
            top: 0;
            left: 0;
            height: 100vh !important;
            overflow-y: auto;
            z-index: 1000;
        }
        
        #content-wrapper {
            margin-left: 14rem;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -14rem;
                transition: margin-left 0.3s ease;
            }
            
            .sidebar.toggled {
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

                         <div class="container">

                            <div class="card o-hidden border-0 shadow-lg my-5">
                                <div class="card-body ">
                                    <!-- Nested Row within Card Body -->
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="">
                                                <a href="index.php" class="text-primary d-flex align-items-center mb-3" style="text-decoration: none;">
                                                    <i class="fas fa-arrow-left me-2"></i> Back to Manange Incidents
                                                </a>
                                                <div class="text-center">
                                                    <h1 class="h4 text-gray-900 mb-4">Report Incident</h1>
                                                </div>
                                                <form method="post" enctype="multipart/form-data" style="background: #fff; padding: 2rem; border-radius: 10px;  margin: auto;">
                                                    <div class="row">
                                                
                                                    <div class="form-group mb-3 col-lg-6 col-12">
                                                        <label for="title">Incident Title</label>
                                                        <input type="text" class="form-control" id="title" name="title" placeholder="e.g., Phishing Email Attempt" required>
                                                    </div>

                                                    <!-- Date of Incident -->
                                                    <div class="form-group mb-3  col-lg-6 col-12">
                                                        <label for="incident_date">Date and Time Discovered</label>
                                                        <input type="datetime-local" class="form-control" id="date" name="date" required>
                                                    </div>


                                                    <div class="form-group mb-3 col-lg-6 col-12">
                                                        <label for="title">Location/System Affected</label>
                                                        <input type="text" class="form-control" id="system_affected" name="system_affected" placeholder="e.g., Server,Work Station" required>
                                                    </div>


                                                    <!-- Category -->
                                                    <div class="form-group mb-3  col-lg-6 col-12">
                                                        <label for="category">Category</label>
                                                        <select class="form-control" id="category" name="category" required>
                                                            <option value="" disabled selected>Select a category</option>
                                                            <?php
                                                            $query = "SELECT * FROM category ";
                                                            $result = $conn->query($query);
                                                            while ($row = $result->fetch_assoc()) {
                                                                echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                    
                                                    <div class="form-group mb-3 col-lg-6 col-12">
                                                        <label for="title">Severity Level</label>
                                                        <input type="text" class="form-control" id="severity_level" name="severity_level" placeholder="" required>
                                                    </div>

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
            <input type="text" class="form-control" id="fullName" name="full_name" placeholder="Enter full name">
        </div>
        <div class="col-12 col-lg-6">
            <label for="role" class="form-label">Role/Position</label>
            <input type="text" class="form-control" id="role" name="role" placeholder="Enter role or position">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12 col-lg-6">
            <label for="department" class="form-label">Department/Unit</label>
            <input type="text" class="form-control" id="department" name="department" placeholder="Enter department">
        </div>
        <div class="col-12 col-lg-6">
            <label for="email" class="form-label">Contact Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12 col-lg-6">
            <label for="phone" class="form-label">Contact Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter contact number">
        </div>
    </div>
</div>

<!-- Impact Assessment -->
<div class="mb-4 col-lg-12">
    <h6 class="fw-bold text-dark mb-3">
        <i class="fas fa-chart-line text-danger me-2"></i>Impact Assessment
    </h6>

    <div class="row mb-3">
        <div class="col-12">
            <label for="systems" class="form-label">Systems/Data Affected</label>
            <textarea class="form-control" id="systems" name="systems_affected" rows="3" placeholder="List affected systems, databases, or data types"></textarea>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12 col-lg-6">
            <label for="estimatedImpact" class="form-label">Estimated Impact</label>
            <input type="text" class="form-control" id="estimatedImpact" name="estimated_impact" placeholder="e.g., High, Medium, Low">
        </div>
        <div class="col-12 col-lg-6">
            <label class="form-label d-block">Is critical infrastructure affected?</label>
            <div class="form-check form-check-inline me-3">
                <input class="form-check-input" type="radio" name="critical_infra" id="infraYes" value="yes">
                <label class="form-check-label" for="infraYes">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="critical_infra" id="infraNo" value="no">
                <label class="form-check-label" for="infraNo">No</label>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <label for="observedImpact" class="form-label">Describe observed impact</label>
            <textarea class="form-control" id="observedImpact" name="observed_impact" rows="3" placeholder="What impact has been observed so far?"></textarea>
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
            <label for="actions_taken" class="form-label">Immediate Actions Taken</label>
            <textarea class="form-control" id="actions_taken" name="actions_taken" rows="3" placeholder="What steps have been taken to address the incident?"></textarea>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12 col-lg-6">
            <label class="form-label d-block">Was the incident contained?</label>
            <div class="form-check form-check-inline me-3">
                <input class="form-check-input" type="radio" name="incident_contained" id="containedYes" value="yes">
                <label class="form-check-label" for="containedYes">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="incident_contained" id="containedNo" value="no">
                <label class="form-check-label" for="containedNo">No</label>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <label for="notified" class="form-label">Who was notified?</label>
            <input type="text" class="form-control" id="notified" name="notified" placeholder="List people/teams notified">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <label class="form-label d-block">Evidence Available?</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="evidenceLogs" name="evidence_logs" value="1">
                <label class="form-check-label" for="evidenceLogs">Logs</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="evidenceScreenshots" name="evidence_screenshots" value="1">
                <label class="form-check-label" for="evidenceScreenshots">Screenshots</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="evidenceEmail" name="evidence_email" value="1">
                <label class="form-check-label" for="evidenceEmail">Email</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="evidenceOther" name="evidence_other" value="1">
                <label class="form-check-label" for="evidenceOther">Other</label>
            </div>
        </div>
    </div>
</div>

<!-- Attachments -->
<div class="mb-4 col-lg-12">
<div class="form-group mb-4">
                                                        <label style="width: 100%;">Attachment</label>

                                                        <!-- Upload Area Outside the Label -->
                                                        <div id="upload-area" style="border: 2px dashed #ccc; padding: 2rem; text-align: center; border-radius: 10px; cursor: pointer;">
                                                            <i class="fas fa-cloud" style="font-size: 30px; margin-bottom: 10px;"></i>
                                                            <p style="margin: 0;">Click to upload or drag and drop</p>
                                                            <small>Screenshots, logs, or other evidence (Max 10MB)</small>
                                                            <div id="file-preview" style="margin-top: 1rem; text-align: left;"></div>
                                                        </div>

                                                        <!-- Real Hidden File Input -->
                                                        <input type="file" name="attachment[]" id="file-upload" accept=".png,.jpg,.jpeg,.pdf,.log,.txt" style="display: none;" multiple required>
                                                    </div>
                                                    </div>           
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



                                                    <!-- File Upload -->
                                                    



                                                    <!-- Submit Button -->
                                                    <div class="form-group">
                                                        <button type="submit" name="btn_save" class="btn btn-primary w-100" style="background-color: #2563EB; border: none;">Submit Incident</button>
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
    </script>
</body>

</html>
<?php
}
else
{
    header('location:../../index.php');
}?>