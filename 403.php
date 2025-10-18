<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>403 - Access Forbidden - iReport</title>
    <link rel="icon" type="image/x-icon" href="img/logo1.png"/>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-Padmin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <!-- 403 Error Text -->
                    <div class="text-center" style="margin-top: 100px;">
                        <div class="error mx-auto" data-text="403" style="width: 7rem; height: 7rem; color: #5a5c69; font-size: 7rem; position: relative; line-height: 1; letter-spacing: -0.05em;">
                            <p class="m-0">403</p>
                        </div>
                        <p class="text-gray-500 mb-0">Access Forbidden</p>
                        <p class="lead text-gray-800 mb-5">You don't have permission to access this resource</p>
                        <p class="text-gray-500 mb-0">
                            <?php
                            session_start();
                            if(isset($_SESSION['role'])) {
                                if($_SESSION['role'] === 'admin') {
                                    echo 'This page is restricted to regular users only.';
                                } else {
                                    echo 'This page is restricted to administrators only.';
                                }
                            } else {
                                echo 'Please log in to access this resource.';
                            }
                            ?>
                        </p>
                        <div class="mt-4">
                            <?php if(isset($_SESSION['user_id'])): ?>
                                <?php if($_SESSION['role'] === 'admin'): ?>
                                    <a href="admin/dashboard/" class="btn btn-primary">← Back to Admin Dashboard</a>
                                <?php else: ?>
                                    <a href="user/dashboard/" class="btn btn-primary">← Back to Dashboard</a>
                                <?php endif; ?>
                            <?php else: ?>
                                <a href="login.php" class="btn btn-primary">← Login</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; iReport <?php echo date('Y'); ?></span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
