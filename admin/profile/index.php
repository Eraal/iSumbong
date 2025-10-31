<?php
include '../../connectMySql.php';
include '../../loginverification.php';

// Check if user is logged in and is admin
if(!logged_in() || !is_admin()) {
    header("Location: ../../403.php");
    exit();
}

$session_user_id = $_SESSION['user_id'];

if(isset($_POST['submit']))
{
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $password = $_POST['password'];
    
    // If password is provided, hash it; otherwise keep current password
    if (!empty($password)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET email = ?, name = ?, password = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $email, $name, $password_hash, $session_user_id);
    } else {
        $sql = "UPDATE users SET email = ?, name = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $email, $name, $session_user_id);
    }
    
    if ($stmt->execute()) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Success!',
                    text: 'Profile updated successfully!',
                    icon: 'success',
                    confirmButtonColor: '#4e73df'
                });
            });
        </script>";
        
        // Update session data
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to update profile.',
                    icon: 'error',
                    confirmButtonColor: '#e74a3b'
                });
            });
        </script>";
    }
    $stmt->close();
}

// Get user details
$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $session_user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: ../../login.php");
    exit();
}

$row = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Admin Profile - iSumbong System">
    <meta name="author" content="iSumbong">

    <title>Admin Profile - iSumbong</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../img/logo1.png"/>
    <link rel="icon" type="image/png" sizes="32x32" href="../../img/logo1.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../img/logo1.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../../img/logo1.png">

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
    
    <!-- SweetAlert2 -->
    <script src="../../js/sweetalert2.all.min.js"></script>
    
    <style>
        /* Admin Profile Page - User Style Design */
        
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
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        
        .form-control:hover {
            border-color: #4e73df;
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
        
        /* Modal Styling */
        .modal-content {
            border-radius: 1rem;
            border: none;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        
        .modal-header {
            background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%);
            color: white;
            border-radius: 1rem 1rem 0 0;
            border-bottom: none;
            padding: 2rem;
        }
        
        .modal-title {
            font-weight: 700;
            font-size: 1.3rem;
        }
        
        .modal-body {
            padding: 2rem;
        }
        
        .modal-footer {
            border-top: 2px solid #f1f3f4;
            padding: 1.5rem 2rem;
            border-radius: 0 0 1rem 1rem;
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
                font-size: 1.8rem !important;
            }
            
            .lead {
                font-size: 1rem !important;
            }
            
            .profile-avatar {
                width: 80px !important;
                height: 80px !important;
            }
            
            .profile-avatar i {
                font-size: 2rem !important;
            }
        }
        
        .form-input.is-valid {
            border-color: #1cc88a;
        }
        
        .form-input.is-invalid {
            border-color: #e74a3b;
        }
    </style>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include '../sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php include '../nav.php'; ?>

                <!-- Begin Page Content -->
                <!-- Main Content -->
                <div class="container-fluid p-0">
                    
                    <!-- Profile Form Section -->
                    <section class="profile-form py-5" style="background: #f8f9fa;">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <!-- Account details card-->
                                    <div class="card mb-4 shadow-sm" style="border-radius: 1rem; border: none;">
                                        <div class="card-header py-4 bg-white" style="border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-wrapper mr-3" style="width: 50px; height: 50px; background: linear-gradient(45deg, #4e73df, #224abe); border-radius: 1rem; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-user-edit text-white"></i>
                                                </div>
                                                <div>
                                                    <h5 class="m-0 font-weight-bold text-dark">Administrator Account</h5>
                                                    <small class="text-muted">Update your administrative credentials and information</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body p-4">
                                            <form method="post" id="profileForm">
                                                <div class="row gx-3 mb-3">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label font-weight-bold text-dark mb-2" for="name">
                                                            <i class="fas fa-user mr-2 text-primary"></i>Full Name
                                                        </label>
                                                        <input class="form-control form-control-lg" name="name" id="name" type="text" 
                                                               placeholder="Enter your full name" 
                                                               value="<?php echo htmlspecialchars($row['name']); ?>" 
                                                               required style="border-radius: 0.5rem; border: 2px solid #e3e6f0; padding: 0.75rem 1rem;">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label font-weight-bold text-dark mb-2" for="email">
                                                            <i class="fas fa-envelope mr-2 text-primary"></i>Email Address
                                                        </label>
                                                        <input class="form-control form-control-lg" name="email" id="email" type="email" 
                                                               placeholder="Enter your email address" 
                                                               value="<?php echo htmlspecialchars($row['email']); ?>" 
                                                               required style="border-radius: 0.5rem; border: 2px solid #e3e6f0; padding: 0.75rem 1rem;">
                                                    </div>
                                                </div>
                                                <div class="row gx-3 mb-4">
                                                    <div class="col-md-12 mb-4">
                                                        <label class="form-label font-weight-bold text-dark mb-2" for="password">
                                                            <i class="fas fa-lock mr-2 text-primary"></i>New Password
                                                        </label>
                                                        <input class="form-control form-control-lg" name="password" id="password" type="password" 
                                                               placeholder="Enter new password (optional)" style="border-radius: 0.5rem; border: 2px solid #e3e6f0; padding: 0.75rem 1rem;">
                                                        <small class="text-muted mt-1">
                                                            <i class="fas fa-info-circle mr-1"></i>
                                                            Leave empty to keep your current password
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
                    </section>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include '../footer.php'; ?>
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Add Admin Modal -->
    <div class="modal fade" id="addAdminModal" tabindex="-1" role="dialog" aria-labelledby="addAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex align-items-center">
                        <div class="icon-wrapper mr-3" style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 1rem; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user-shield text-white"></i>
                        </div>
                        <div>
                            <h5 class="modal-title m-0" id="addAdminModalLabel">Add New Administrator</h5>
                            <small class="text-light opacity-75">Create a new administrator account</small>
                        </div>
                    </div>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addAdminForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label font-weight-bold text-dark mb-2">
                                        <i class="fas fa-user mr-2 text-primary"></i>Full Name
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="adminName" name="adminName" 
                                           placeholder="Enter administrator's full name" required style="border-radius: 0.5rem; border: 2px solid #e3e6f0; padding: 0.75rem 1rem;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label font-weight-bold text-dark mb-2">
                                        <i class="fas fa-envelope mr-2 text-primary"></i>Email Address
                                    </label>
                                    <input type="email" class="form-control form-control-lg" id="adminEmail" name="adminEmail" 
                                           placeholder="Enter administrator's email" required style="border-radius: 0.5rem; border: 2px solid #e3e6f0; padding: 0.75rem 1rem;">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label font-weight-bold text-dark mb-2">
                                        <i class="fas fa-lock mr-2 text-primary"></i>Password
                                    </label>
                                    <input type="password" class="form-control form-control-lg" id="adminPassword" name="adminPassword" 
                                           placeholder="Enter secure password" required style="border-radius: 0.5rem; border: 2px solid #e3e6f0; padding: 0.75rem 1rem;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label font-weight-bold text-dark mb-2">
                                        <i class="fas fa-lock mr-2 text-primary"></i>Confirm Password
                                    </label>
                                    <input type="password" class="form-control form-control-lg" id="adminPasswordConfirm" name="adminPasswordConfirm" 
                                           placeholder="Confirm password" required style="border-radius: 0.5rem; border: 2px solid #e3e6f0; padding: 0.75rem 1rem;">
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-info" role="alert" style="border-radius: 0.5rem; border: none; background: rgba(52, 152, 219, 0.1);">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Security Note:</strong> The new administrator will have full access to the system.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <div class="text-muted">
                                <i class="fas fa-shield-alt mr-2"></i>
                                Password will be securely encrypted
                            </div>
                            <div>
                                <button class="btn btn-secondary mr-2" type="button" data-dismiss="modal" style="border-radius: 50px; font-weight: 600;">
                                    <i class="fas fa-times mr-2"></i>Cancel
                                </button>
                                <button class="btn btn-success" type="submit" style="border-radius: 50px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
                                    <i class="fas fa-user-plus mr-2"></i>Add Administrator
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
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

    <!-- Add Admin Form Handler -->
    <script>
        $(document).ready(function() {
            $('#addAdminForm').on('submit', function(e) {
                e.preventDefault();
                
                // Check if passwords match
                if ($('#adminPassword').val() !== $('#adminPasswordConfirm').val()) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Passwords do not match.',
                        icon: 'error',
                        confirmButtonColor: '#e74a3b'
                    });
                    return;
                }
                
                // Show loading
                Swal.fire({
                    title: 'Adding Administrator...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Submit form
                $.ajax({
                    url: 'add_admin.php',
                    type: 'POST',
                    data: {
                        name: $('#adminName').val(),
                        email: $('#adminEmail').val(),
                        password: $('#adminPassword').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonColor: '#1cc88a'
                            }).then(() => {
                                $('#addAdminModal').modal('hide');
                                $('#addAdminForm')[0].reset();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonColor: '#e74a3b'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to add administrator. Please try again.',
                            icon: 'error',
                            confirmButtonColor: '#e74a3b'
                        });
                    }
                });
            });
            
            // Form validation styling
            $('.form-control').on('input', function() {
                if (this.checkValidity()) {
                    $(this).removeClass('is-invalid').addClass('is-valid');
                } else {
                    $(this).removeClass('is-valid').addClass('is-invalid');
                }
            });
            
            // Add focus animations to form inputs
            $('.form-control').on('focus', function() {
                $(this).parent().find('.form-label').addClass('text-primary');
            }).on('blur', function() {
                $(this).parent().find('.form-label').removeClass('text-primary');
            });
        });
    </script>
</body>
</html>

