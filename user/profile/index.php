<?php
include '../../connectMySQL.php';
include '../../loginverification.php';
include '../../includes/theme_system.php';
if(logged_in()){
$session_user_id = $_SESSION['user_id'];


if(isset($_POST['submit']))
{
        $email = $_POST['email'];
        $password = $_POST['password'];
        $name = $_POST['name'];


        $sql= sprintf("UPDATE users
        SET 
        email = '". $email ."',
        password  = '". $password ."',
        name  = '". $name ."'
        WHERE user_id = '". $session_user_id ."'");
        $result = mysqli_query($conn, $sql);
        
        echo "<script src='../../js/sweetalert2.all.min.js'></script>
            <body onload='save()'></body>
            <script> 
            function save(){
            Swal.fire(
                 'Record Saved!',
                 '',
                 'success'
               )
            }</script>";
}


$query = "SELECT * FROM users WHERE user_id = '".$session_user_id."'";
$result = $conn->query($query);
while ($row = $result->fetch_assoc()) {
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>iReport </title>
    <link rel="icon" type="image/x-icon" href="../../img/logo1.png"/>

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">


    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
    <?php echo getThemeMeta(); ?>
    <?php echo getThemeIncludes('../../'); ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div class="container-fluid p-0">

        <!-- Navigation -->
        <?php include'../nav.php';?>

        <!-- Main Content -->
        <div class="container-fluid p-0">
            
            <!-- Hero Section -->
            <section class="profile-hero" style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); min-height: 40vh; display: flex; align-items: center; position: relative; overflow: hidden;">
                <!-- Background Pattern -->
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: radial-gradient(circle at 25% 25%, rgba(255,255,255,0.05) 1px, transparent 1px); background-size: 50px 50px; opacity: 0.3;"></div>
                
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-8 text-white">
                            <h1 class="display-4 font-weight-bold mb-4" style="font-size: 3rem; line-height: 1.1;">
                                User <span style="color: #3498db;">Profile</span>
                            </h1>
                            <p class="lead mb-4" style="font-size: 1.2rem; opacity: 0.9; max-width: 600px;">
                                Manage your account information and security settings for your iREPORT profile.
                            </p>
                        </div>
                        <div class="col-lg-4 text-center">
                            <div class="profile-avatar" style="width: 120px; height: 120px; margin: 0 auto; background: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                                <i class="fas fa-user" style="font-size: 3rem; color: #3498db;"></i>
                            </div>
                            <h4 class="text-white mt-3 font-weight-bold"><?php echo htmlspecialchars($row['name']); ?></h4>
                            <p class="text-light opacity-75"><?php echo htmlspecialchars($row['email']); ?></p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Profile Form Section -->
            <section class="profile-form py-5" style="background: #f8f9fa;">
                <div class="container">

                        <div class="row justify-content-center">
                            
                            <div class="col-lg-8">
                                <!-- Account details card-->
                                <div class="card mb-4 shadow-sm" style="border-radius: 1rem; border: none;">
                                    <div class="card-header py-4 bg-white" style="border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-wrapper mr-3" style="width: 50px; height: 50px; background: linear-gradient(45deg, #3498db, #2980b9); border-radius: 1rem; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-user-edit text-white"></i>
                                            </div>
                                            <div>
                                                <h5 class="m-0 font-weight-bold text-dark">Account Details</h5>
                                                <small class="text-muted">Update your personal information and credentials</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-4">
                                        <form method="post">
                                        <div class="row gx-3 mb-3">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label font-weight-bold text-dark mb-2" for="name">
                                                    <i class="fas fa-user mr-2 text-primary"></i>Full Name
                                                </label>
                                                <input class="form-control form-control-lg" name="name" id="name" type="text" placeholder="Enter your name" value="<?php echo $row['name'];?>" required style="border-radius: 0.5rem; border: 2px solid #e3e6f0; padding: 0.75rem 1rem;">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label font-weight-bold text-dark mb-2" for="email">
                                                    <i class="fas fa-envelope mr-2 text-primary"></i>Email Address
                                                </label>
                                                <input class="form-control form-control-lg" name="email" id="email" type="text" placeholder="Enter your email" value="<?php echo $row['email'];?>" required style="border-radius: 0.5rem; border: 2px solid #e3e6f0; padding: 0.75rem 1rem;">
                                            </div>
                                            <div class="col-md-12 mb-4">
                                                <label class="form-label font-weight-bold text-dark mb-2" for="password">
                                                    <i class="fas fa-lock mr-2 text-primary"></i>Password
                                                </label>
                                                <input class="form-control form-control-lg" name="password" id="password" type="password" placeholder="Enter your password" value="<?php echo $row['password'];?>" required style="border-radius: 0.5rem; border: 2px solid #e3e6f0; padding: 0.75rem 1rem;">
                                                <small class="text-muted mt-1">
                                                    <i class="fas fa-info-circle mr-1"></i>
                                                    Use a strong password with at least 8 characters
                                                </small>
                                            </div>
                                        </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="text-muted">
                                                        <i class="fas fa-shield-alt mr-2"></i>
                                                        Your information is securely encrypted
                                                    </div>
                                                    <button class="btn btn-primary btn-lg px-4 py-2" name="submit" type="submit" style="border-radius: 50px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
                                                        <i class="fas fa-save mr-2"></i>Save Changes
                                                    </button>
                                                </div>
                                            
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
        <!-- End of Main Content -->
        
        <!-- Custom Styles for Profile Page -->
        <style>
            /* Profile Hero Animation */
            .profile-hero {
                animation: fadeIn 1s ease-in-out;
            }
            
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(30px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            /* Profile Avatar Animation */
            .profile-avatar {
                animation: pulse 2s infinite;
            }
            
            @keyframes pulse {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.05); }
            }
            
            /* Form Section Animation */
            .profile-form {
                animation: slideUp 1s ease-in-out 0.3s both;
            }
            
            @keyframes slideUp {
                from { opacity: 0; transform: translateY(50px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            /* Card Hover Effects */
            .card {
                transition: all 0.3s ease;
            }
            
            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
            }
            
            /* Form Input Hover Effects */
            .form-control {
                transition: all 0.3s ease;
            }
            
            .form-control:focus {
                border-color: #3498db;
                box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
            }
            
            .form-control:hover {
                border-color: #3498db;
            }
            
            /* Button Hover Effects */
            .btn {
                transition: all 0.3s ease;
            }
            
            .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            }
            
            /* Icon Wrapper Hover */
            .icon-wrapper {
                transition: all 0.3s ease;
            }
            
            .card:hover .icon-wrapper {
                transform: scale(1.1) rotate(5deg);
            }
            
            /* Responsive Design */
            @media (max-width: 1200px) {
                .container {
                    max-width: 100%;
                    padding-left: 20px;
                    padding-right: 20px;
                }
                
                .display-4 {
                    font-size: 2.5rem !important;
                }
                
                .profile-hero {
                    min-height: 35vh !important;
                }
            }
            
            @media (max-width: 992px) {
                .profile-hero {
                    min-height: 50vh !important;
                    text-align: center;
                }
                
                .display-4 {
                    font-size: 2.2rem !important;
                }
                
                .lead {
                    font-size: 1.1rem !important;
                }
                
                .col-lg-8, .col-lg-4 {
                    margin-bottom: 2rem;
                }
                
                .profile-avatar {
                    width: 100px !important;
                    height: 100px !important;
                }
                
                .profile-avatar i {
                    font-size: 2.5rem !important;
                }
                
                .card-body {
                    padding: 2rem !important;
                }
            }
            
            @media (max-width: 768px) {
                .profile-hero {
                    min-height: 60vh !important;
                    padding: 2rem 0;
                }
                
                .display-4 {
                    font-size: 2rem !important;
                }
                
                .lead {
                    font-size: 1rem !important;
                }
                
                .profile-avatar {
                    width: 90px !important;
                    height: 90px !important;
                }
                
                .profile-avatar i {
                    font-size: 2rem !important;
                }
                
                .card-body {
                    padding: 1.5rem !important;
                }
                
                .btn-lg {
                    width: 100%;
                    margin-top: 1rem;
                }
                
                .d-flex.justify-content-between {
                    flex-direction: column;
                    text-align: center;
                }
                
                .form-control-lg {
                    padding: 0.6rem 0.8rem !important;
                    font-size: 0.95rem;
                }
                
                .icon-wrapper {
                    width: 40px !important;
                    height: 40px !important;
                }
                
                .icon-wrapper i {
                    font-size: 1rem !important;
                }
                
                h5 {
                    font-size: 1.1rem !important;
                }
                
                .container {
                    padding-left: 15px;
                    padding-right: 15px;
                }
                
                .py-5 {
                    padding-top: 2rem !important;
                    padding-bottom: 2rem !important;
                }
            }
            
            @media (max-width: 576px) {
                .profile-hero {
                    min-height: 70vh !important;
                    padding: 1.5rem 0;
                }
                
                .display-4 {
                    font-size: 1.8rem !important;
                }
                
                .lead {
                    font-size: 0.95rem !important;
                }
                
                .profile-avatar {
                    width: 80px !important;
                    height: 80px !important;
                }
                
                .profile-avatar i {
                    font-size: 1.8rem !important;
                }
                
                .card-body {
                    padding: 1rem !important;
                }
                
                .form-control-lg {
                    padding: 0.5rem 0.7rem !important;
                    font-size: 0.9rem;
                }
                
                .btn-lg {
                    padding: 0.7rem 1.2rem;
                    font-size: 0.85rem;
                }
                
                .icon-wrapper {
                    width: 35px !important;
                    height: 35px !important;
                }
                
                h5 {
                    font-size: 1rem !important;
                }
                
                h4 {
                    font-size: 1.3rem !important;
                }
                
                .container {
                    padding-left: 10px;
                    padding-right: 10px;
                }
                
                .py-5 {
                    padding-top: 1.5rem !important;
                    padding-bottom: 1.5rem !important;
                }
                
                .card {
                    margin-bottom: 1rem !important;
                }
            }
            
            @media (max-width: 400px) {
                .display-4 {
                    font-size: 1.6rem !important;
                }
                
                .container {
                    padding-left: 8px;
                    padding-right: 8px;
                }
                
                .card-body {
                    padding: 0.8rem !important;
                }
                
                .form-control-lg {
                    padding: 0.4rem 0.6rem !important;
                    font-size: 0.85rem;
                }
                
                .btn-lg {
                    font-size: 0.8rem;
                    padding: 0.6rem 1rem;
                }
                
                h5 {
                    font-size: 0.9rem !important;
                }
                
                .icon-wrapper {
                    width: 30px !important;
                    height: 30px !important;
                }
                
                .icon-wrapper i {
                    font-size: 0.8rem !important;
                }
                
                .profile-avatar {
                    width: 70px !important;
                    height: 70px !important;
                }
                
                .profile-avatar i {
                    font-size: 1.5rem !important;
                }
            }
        </style>
        
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

    <!-- Bootstrap core JavaScript-->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin-2.min.js"></script>

    <script>
        // Navigation active state
        $(document).ready(function() {
            // Remove active class from all nav links
            $('.navbar-nav .nav-link').removeClass('active');
            
            // Add active class to Profile link
            $('.navbar-nav .nav-link[href*="profile"]').addClass('active');
        });
    </script>

    <!-- Page level plugins -->
    <script src="../../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../js/demo/chart-area-demo.js"></script>
    <script src="../../js/demo/chart-pie-demo.js"></script>
    <script src="../../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script>
      $(function () {
        $("#dataTable").DataTable({
          "responsive": true,
        });
      });
    </script>
</body>

</html>
<?php
}
}
else
{
    header('location:../../index.php');
}?>