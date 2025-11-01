<?php
include '../../connectMySql.php';
include '../../loginverification.php';
if(logged_in()){
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>iSumbong - User Management</title>
    <link rel="icon" type="image/x-icon" href="../../img/logo1.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="../../img/logo1.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../img/logo1.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../../img/logo1.png">
    <!-- Font Awesome (CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
    <script src='../../js/sweetalert2.all.min.js'></script>
    <!-- DataTables CSS (CDN) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">
    
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

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">User Management</h1>
                    </div>

                    <!-- Content Row -->
                        <div class="card shadow-sm mb-4" style="border-radius: 1rem;">
                            <div class="card-header py-3 bg-white" style="border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                                <h6 class="m-0 font-weight-bold text-primary">User List</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <table class="table table-hover align-middle" id="dataTable" width="100%" cellspacing="0" style="border-radius: 0.75rem; overflow: hidden;">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="text-secondary text-uppercase small">Action</th>
                                        <th class="text-secondary text-uppercase small">Name</th>
                                        <th class="text-secondary text-uppercase small">Email</th>
                                        <th class="text-secondary text-uppercase small">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $query = "SELECT * FROM users ORDER BY user_id DESC";
                                    $result = $conn->query($query);
                                    while ($row = $result->fetch_assoc()) {
                                        $status = strtolower($row['status']) == 'active'
                                            ? "<span class='badge badge-success badge-pill px-3 py-2'>Active</span>"
                                            : "<span class='badge badge-danger badge-pill px-3 py-2'>Inactive</span>";

                                        echo "<tr>";
                                        echo "<td class='text-center'>".
                                             "<a href='view.php?id=".$row['user_id']."' class='btn btn-sm btn-outline-primary rounded-pill shadow-sm mr-1'>".
                                                 "<i class='fas fa-eye'></i> View".
                                             "</a>".
                                             "<a href='javascript:void(0)' data-id='".$row['user_id']."' class='btn btn-sm btn-outline-danger rounded-pill shadow-sm delete_user'>".
                                                 "<i class='fas fa-trash'></i>".
                                             "</a>".
                                         "</td>";
                                        echo "<td class='text-dark font-weight-bold'>" . htmlspecialchars($row['name']) . "</td>";
                                        echo "<td class='text-dark'>" . htmlspecialchars($row['email']) . "</td>";
                                        echo "<td>$status</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>

                </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
            <?php include'../footer.php';?>

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

    <!-- jQuery (CDN) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- Bootstrap 4 Bundle (incl. Popper) (CDN) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery Easing (CDN) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="../../js/sb-admin-2.min.js"></script>
    <!-- Chart.js (CDN) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <!-- DataTables (CDN) -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>

    <script>
      $(function () {
        $("#dataTable").DataTable({
         "createdRow": function(row, data, dataIndex) {
            $('td', row).css('white-space', 'nowrap');
        }
            });
        });


        // Use delegated event binding so clicks work even after DataTables redraws
        $(document).on('click', '.delete_user', function (e) {
            e.preventDefault();
            var dataId = $(this).data('id');

            if (!dataId) {
                console.warn('Delete action missing data-id');
                return;
            }

            // If SweetAlert is unavailable in production, fallback to native confirm
            if (typeof Swal === 'undefined') {
                if (confirm('Are you sure you want to delete this account?')) {
                    $.ajax({
                        type: 'GET',
                        url: 'delete.php',
                        data: { id: dataId },
                        success: function () {
                            alert('Deleted Successfully');
                            window.location.href = 'index.php';
                        },
                        error: function (xhr, status, error) {
                            console.error('Error deleting user:', error);
                            alert('Delete failed. Please try again.');
                        }
                    });
                }
                return;
            }

            Swal.fire({
                title: 'Are you sure you want to delete this account?',
                showDenyButton: true,
                confirmButtonText: 'Proceed',
                denyButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'GET',
                        url: 'delete.php',
                        data: { id: dataId },
                        success: function () {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted Successfully',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = 'index.php';
                            });
                        },
                        error: function (xhr, status, error) {
                            console.error('Error deleting user:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Delete failed',
                                text: 'There was a problem deleting the account. Please try again.'
                            });
                        }
                    });
                }
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