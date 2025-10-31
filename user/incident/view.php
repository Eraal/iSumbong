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
$suggestion =  "";

// Handle delete incident
if (isset($_POST['delete_incident_id'])) {
    $delete_id = intval($_POST['delete_incident_id']);
    
    // Check if user_deleted column exists, if not create it
    $check_column = $conn->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'incident' AND COLUMN_NAME = 'user_deleted'");
    if ($check_column->num_rows == 0) {
        $conn->query("ALTER TABLE incident ADD COLUMN user_deleted TINYINT(1) DEFAULT 0");
    }
    
    // Soft delete: set user_deleted = 1
    $delete_query = "UPDATE incident SET user_deleted = 1 WHERE id = $delete_id AND user_id = '".$_SESSION['user_id']."'";
    
    if ($conn->query($delete_query)) {
        echo "<script src='../../js/sweetalert2.all.min.js'></script>
        <body onload='deleteSuccess()'></body>
        <script> 
        function deleteSuccess(){
            Swal.fire(
                'Incident Deleted!',
                'The incident has been removed from your view.',
                'success'
            ).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'index.php';
                }
            });
        }
        </script>";
    } else {
        echo "<script src='../../js/sweetalert2.all.min.js'></script>
        <body onload='deleteError()'></body>
        <script> 
        function deleteError(){
            Swal.fire(
                'Error!',
                'Failed to delete incident: " . addslashes($conn->error) . "',
                'error'
            );
        }
        </script>";
    }
}

if (isset($_POST['btn_save'])) {
    $status = $_POST['status'];

    $sql = "UPDATE incident SET status = '$status' WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
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
    } else {
        echo "Error saving incident: " . mysqli_error($conn);
    }
}

    if (isset($_POST['btn_comment'])) {
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $incident_id = $id;
    $user_id = $_SESSION['name'];

    $sql = "INSERT INTO comments (incident_id, user_id, comment, date) 
            VALUES ('$incident_id', '$user_id', '$comment', NOW())";

    if (mysqli_query($conn, $sql)) {
        echo "<script src='../../js/sweetalert2.all.min.js'></script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Comment Added!',
                text: 'Your comment has been posted successfully.',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = window.location.href.split('?')[0] + '?id=$id';
            });
        });
        </script>";
    } else {
        echo "<script src='../../js/sweetalert2.all.min.js'></script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to add comment: " . addslashes(mysqli_error($conn)) . "'
            });
        });
        </script>";
    }
}

// Check if incident_type table exists first
$table_check = $conn->query("SHOW TABLES LIKE 'incident_type'");
if ($table_check && $table_check->num_rows > 0) {
    $query = "SELECT a.* FROM incident a 
              WHERE a.id = '".$id."'";
} else {
    $query = "SELECT * FROM incident WHERE id = '".$id."'";
}

$result = $conn->query($query);
while ($row = $result->fetch_assoc()) {
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
$suggestion = isset($row['suggestion']) ? $row['suggestion'] : "No specific suggestions available for this category.";
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
    
    <style>
        /* Mobile-first responsive design */
        @media (max-width: 768px) {
            /* Make containers full width on mobile */
            .container {
                max-width: 100% !important;
                padding: 0 10px !important;
            }
            
            .container.mt-5 {
                max-width: 100% !important;
                margin-top: 1rem !important;
                padding: 0 5px !important;
            }
            
            /* Adjust card padding for mobile */
            .card-body {
                padding: 1rem !important;
            }
            
            .p-5 {
                padding: 1rem !important;
            }
            
            /* Make content sections mobile-friendly */
            .d-flex.flex-wrap.gap-3 {
                flex-direction: column !important;
                gap: 0.5rem !important;
            }
            
            .d-flex.flex-wrap.gap-3 > div {
                margin-bottom: 0.5rem;
            }
            
            /* Adjust content boxes for mobile */
            .bg-light.p-3 {
                padding: 1rem !important;
                font-size: 14px;
                line-height: 1.5;
            }
            
            /* Make evidence section mobile-friendly */
            .d-flex.justify-content-between.align-items-center {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 0.5rem;
            }
            
            /* Mobile-friendly buttons */
            .btn {
                font-size: 14px;
                padding: 0.5rem 1rem;
            }
            
            /* Adjust text sizes for mobile */
            h2.fw-bold {
                font-size: 1.5rem !important;
            }
            
            h6.fw-semibold {
                font-size: 1rem !important;
            }
            
            /* Make comments section mobile-friendly */
            .card.mb-4 {
                margin-bottom: 1rem !important;
            }
            
            /* Adjust sidebar for mobile */
            #wrapper {
                padding-left: 0 !important;
            }
            
            .sidebar {
                margin-left: -224px;
            }
            
            .sidebar.toggled {
                margin-left: 0;
            }
            
            #content-wrapper {
                width: 100% !important;
                margin-left: 0 !important;
            }
        }
        
        /* Tablet adjustments */
        @media (min-width: 769px) and (max-width: 1024px) {
            .container.mt-5 {
                max-width: 95% !important;
            }
        }
        
        /* Desktop adjustments */
        @media (min-width: 1025px) {
            .container.mt-5 {
                max-width: 1200px !important;
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

                         <div class="container-fluid px-2">

                            <div class="card o-hidden border-0 shadow-lg my-5">
                                <div class="card-body p-0">
                                    <!-- Nested Row within Card Body -->
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="p-5">
                                                <div class="text-center">
                                                    <h1 class="h4 text-gray-900 mb-4">Report Incident</h1>
                                                </div>
                                               <div class="container mt-5" style="max-width: 100%; width: 100%; padding: 0 15px;">
                                                    <div class="card shadow-sm border-0 rounded-3">
                                                        <div class="card-body">
                                                            <a href="index.php" class="text-primary d-flex align-items-center mb-3" style="text-decoration: none;">
                                                                <i class="fas fa-arrow-left me-2"></i> Back to Manage Incidents
                                                            </a>
                                                            
                                                            <!-- Action Buttons -->
                                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                                <div></div>
                                                                <button type="button" class="btn btn-danger btn-sm" onclick="deleteIncident(<?=$id?>)">
                                                                    <i class="fas fa-trash"></i> Delete Incident
                                                                </button>
                                                            </div>
                                                            
                                                            <hr>
                                                            <h2 class="fw-bold"><?=$title?></h2>

                                                            <div class="d-flex flex-wrap gap-3 mt-2 mb-4">
                                                                <div><strong>Category:</strong> <?=$category?></div> &nbsp &nbsp
                                                                <div><strong>Date Reported: </strong> <?=$date?></div> &nbsp &nbsp
                                                                <div><strong>Status:</strong> <span class="badge bg-<?=$color?> text-white"><?=$status?></span></div>
                                                            </div>
                                                            <hr>

                                                            <div class="mb-4">
                                                                <h6 class="fw-semibold">Description</h6>
                                                                <div class="bg-light p-3 rounded border">
                                                                    <?=$description?>
                                                                </div>
                                                            </div>

                                                            <div class="mb-4">
                                                                <h6 class="fw-semibold">Suggestion</h6>
                                                                <div class="bg-light p-3 rounded border">
                                                                    <?= nl2br(htmlspecialchars($suggestion)) ?>
                                                                </div>
                                                            </div>


                                                            <div class="mb-4">
                                                                <h6 class="fw-semibold">Evidence</h6>
                                                                <?php
                                                                $query = "SELECT * FROM attachment WHERE incident_id = '".$id."'";
                                                                $result = $conn->query($query);
                                                                while ($row = $result->fetch_assoc()) {
                                                                echo '  <div class="bg-light p-3 rounded border d-flex justify-content-between align-items-center mb-2">
                                                                            <div><i class="fas fa-file me-2"></i> '.$row['filename'].'</div>
                                                                            <a href="'.$row['attachment'].'" target="_blank" class="text-decoration-none text-primary">
                                                                                <i class="fas fa-download me-1"></i>Download
                                                                            </a>
                                                                        </div>';
                                                                }
                                                                ?>
                                                            </div>


                                                            <div class="card mb-4">
                                                                <div class="card-header">
                                                                    <i class="fas fa-comments me-1"></i>
                                                                    Comments
                                                                </div>
                                                                <div class="card-body">
                                                                    <!-- Comment Form -->
                                                                    <form method="post">
                                                                    <div class="mb-3">
                                                                        <label for="commentInput" class="form-label">Leave a comment:</label>
                                                                        <textarea class="form-control" name="comment" id="commentInput" rows="3" placeholder="Type your comment here..."></textarea>
                                                                    </div>
                                                                    <button type="submit" name="btn_comment" class="btn btn-primary">Post Comment</button>
                                                                    </form>
                                                                    <hr>


                                                                    <?php
                                                                $query = "SELECT * FROM comments WHERE incident_id = '".$id."'";
                                                                $result = $conn->query($query);
                                                                while ($row = $result->fetch_assoc()) {
                                                                echo '  <div class="d-flex mb-3">
                                                                    <div>
                                                                        <h6 class="fw-bold mb-1">'.$row['user_id'].'</h6>
                                                                        <small class="text-muted">'.$row['date'].'</small>
                                                                        <p class="mt-2 mb-0">'.$row['comment'].'</p>
                                                                    </div>
                                                                    </div>';
                                                                }
                                                                ?>


                                                                    

                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
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
      
      // Delete incident function
      function deleteIncident(id) {
          Swal.fire({
              title: 'Are you sure?',
              text: "This will remove the incident from your view. You won't be able to see it anymore!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33',
              cancelButtonColor: '#3085d6',
              confirmButtonText: 'Yes, delete it!',
              cancelButtonText: 'Cancel'
          }).then((result) => {
              if (result.isConfirmed) {
                  document.getElementById('delete_incident_id').value = id;
                  document.getElementById('deleteForm').submit();
              }
          });
      }
    </script>
    
    <!-- Hidden form for delete action -->
    <form id="deleteForm" method="POST" style="display: none;">
        <input type="hidden" id="delete_incident_id" name="delete_incident_id" value="">
    </form>
</body>

</html>
<?php
}
else
{
    header('location:../../index.php');
}?>