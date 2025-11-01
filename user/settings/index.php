<?php
include '../../connectMySql.php';
include '../../loginverification.php';
include '../../includes/theme_system.php';

if(logged_in()){
$session_user_id = $_SESSION['user_id'];

// Handle password change
$password_message = "";
$password_error = "";

// Handle theme change via AJAX
if(isset($_POST['save_theme'])) {
    $theme = $_POST['theme'];
    if($theme === 'light' || $theme === 'dark') {
        $_SESSION['theme'] = $theme;
        echo json_encode(['status' => 'success', 'message' => 'Theme saved successfully']);
        exit;
    }
}

if(isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate inputs
    if(empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $password_error = "All fields are required.";
    } elseif(strlen($new_password) < 6) {
        $password_error = "New password must be at least 6 characters long.";
    } elseif($new_password !== $confirm_password) {
        $password_error = "New passwords do not match.";
    } else {
        // Check current password
        $check_query = "SELECT password FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("i", $session_user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        // Verify current password (support both hashed and plain text)
        $password_valid = false;
        if($user) {
            if (password_verify($current_password, $user['password'])) {
                // Hashed password verification
                $password_valid = true;
            } elseif ($user['password'] === $current_password) {
                // Plain text password (backward compatibility)
                $password_valid = true;
            }
        }
        
        if($password_valid) {
            // Hash the new password for security
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
            
            // Update password with hashed version
            $update_query = "UPDATE users SET password = ? WHERE user_id = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("si", $hashed_new_password, $session_user_id);
            
            if($update_stmt->execute()) {
                $password_message = "Password changed successfully!";
            } else {
                $password_error = "Error updating password. Please try again.";
            }
            $update_stmt->close();
        } else {
            $password_error = "Current password is incorrect.";
        }
        $stmt->close();
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

    <title>iReport - Settings</title>
    <link rel="icon" type="image/x-icon" href="../../img/logo1.png"/>

    <!-- Custom fonts for this template (CDN to avoid /vendor 403) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">

    <?php echo getThemeMeta(); ?>
    <?php echo getThemeIncludes('../../'); ?>

    <style>
        /* Custom Settings Page Styles */
        .card {
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
        }
        
        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }
        
        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }
        
        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }
        
        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }
        
        .form-control {
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        
        .btn {
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            transform: translateY(-1px);
        }
        
        /* Responsive Design for Settings Page */
        @media (max-width: 1200px) {
            .container-fluid {
                padding-left: 20px;
                padding-right: 20px;
            }
            
            .col-xl-6 {
                margin-bottom: 1rem;
            }
            
            .card-body {
                padding: 1rem;
            }
        }
        
        @media (max-width: 992px) {
            .d-sm-flex {
                flex-direction: column;
                text-align: center;
            }
            
            .h3 {
                font-size: 1.8rem;
                margin-bottom: 1rem;
            }
            
            .col-xl-6, .col-md-6 {
                margin-bottom: 1.5rem;
            }
            
            .card-body {
                padding: 1.2rem;
            }
            
            .h6 {
                font-size: 1rem;
            }
            
            .fa-2x {
                font-size: 1.5em !important;
            }
        }
        
        @media (max-width: 768px) {
            .container-fluid {
                padding-left: 15px;
                padding-right: 15px;
            }
            
            .h3 {
                font-size: 1.6rem;
            }
            
            .card {
                margin-bottom: 1rem !important;
            }
            
            .card-body {
                padding: 1rem;
            }
            
            .row.no-gutters {
                margin: 0;
            }
            
            .col-auto {
                text-align: center;
                margin-top: 0.5rem;
            }
            
            .fa-2x {
                font-size: 1.3em !important;
            }
            
            .btn-sm {
                padding: 0.4rem 0.8rem;
                font-size: 0.85rem;
            }
            
            .form-control-sm {
                padding: 0.4rem 0.6rem;
                font-size: 0.85rem;
            }
            
            .text-xs {
                font-size: 0.7rem !important;
            }
            
            .h6 {
                font-size: 0.95rem;
            }
            
            .modal-dialog {
                margin: 1rem;
            }
            
            .modal-content {
                border-radius: 0.5rem;
            }
        }
        
        @media (max-width: 576px) {
            .h3 {
                font-size: 1.4rem;
            }
            
            .card-body {
                padding: 0.8rem;
            }
            
            .row.no-gutters .col {
                flex-direction: column;
                text-align: center;
            }
            
            .col-auto {
                margin-top: 0.8rem;
                margin-bottom: 0.5rem;
            }
            
            .fa-2x {
                font-size: 1.2em !important;
            }
            
            .btn-sm {
                width: 100%;
                padding: 0.5rem;
                font-size: 0.8rem;
            }
            
            .form-control-sm {
                width: 100%;
                padding: 0.5rem;
                font-size: 0.8rem;
            }
            
            .h6 {
                font-size: 0.9rem;
                margin-bottom: 0.5rem;
            }
            
            .text-xs {
                font-size: 0.65rem !important;
            }
            
            .card-header {
                padding: 0.75rem 1rem;
            }
            
            .card-header h6 {
                font-size: 0.95rem;
            }
            
            .modal-dialog {
                margin: 0.5rem;
            }
            
            .modal-body {
                padding: 1rem;
            }
            
            .form-group {
                margin-bottom: 1rem;
            }
        }
        
        @media (max-width: 400px) {
            .container-fluid {
                padding-left: 10px;
                padding-right: 10px;
            }
            
            .h3 {
                font-size: 1.3rem;
            }
            
            .card-body {
                padding: 0.6rem;
            }
            
            .fa-2x {
                font-size: 1em !important;
            }
            
            .btn-sm {
                font-size: 0.75rem;
                padding: 0.4rem;
            }
            
            .form-control-sm {
                font-size: 0.75rem;
                padding: 0.4rem;
            }
            
            .h6 {
                font-size: 0.85rem;
            }
            
            .text-xs {
                font-size: 0.6rem !important;
            }
            
            .card-header {
                padding: 0.5rem 0.8rem;
            }
            
            .card-header h6 {
                font-size: 0.9rem;
            }
            
            .modal-body {
                padding: 0.8rem;
            }
            
            .col-xl-6, .col-md-6 {
                margin-bottom: 1rem;
            }
        }
        
        /* Additional mobile navigation fixes */
        @media (max-width: 768px) {
            #wrapper {
                background: white;
            }
            
            #content-wrapper {
                background: white;
            }
            
            .navbar-nav {
                background: transparent;
            }
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include'../nav.php';?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Settings</h1>
                    </div>

                    <!-- Account Settings Container -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Account Settings</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Profile Settings Card -->
                                <div class="col-xl-6 col-md-6 mb-3">
                                    <div class="card border-left-primary h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Profile Settings</div>
                                                    <div class="h6 mb-0 font-weight-bold text-gray-800">Edit Profile</div>
                                                    <div class="mt-2 mb-0 text-muted text-xs">
                                                        <span>Update your personal information</span>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-user fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <a href="../profile/" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit fa-sm text-white-50"></i> Edit Profile
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Password Settings Card -->
                                <div class="col-xl-6 col-md-6 mb-3">
                                    <div class="card border-left-success h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                        Security</div>
                                                    <div class="h6 mb-0 font-weight-bold text-gray-800">Change Password</div>
                                                    <div class="mt-2 mb-0 text-muted text-xs">
                                                        <span>Update your password for security</span>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-key fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#changePasswordModal">
                                                    <i class="fas fa-key fa-sm text-white-50"></i> Change Password
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Appearance Settings Container -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Appearance Settings</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Theme Settings -->
                                <div class="col-xl-6 col-md-6 mb-3">
                                    <div class="card border-left-info h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                        Theme</div>
                                                    <div class="h6 mb-0 font-weight-bold text-gray-800">Display Mode</div>
                                                    <div class="mt-2 mb-0 text-muted text-xs">
                                                        <span>Choose your preferred theme</span>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-palette fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <select class="form-control form-control-sm" id="themeSelect">
                                                    <option value="light">Light</option>
                                                    <option value="dark">Dark</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Change Password Modal -->
            <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="changePasswordModalLabel">
                                <i class="fas fa-key mr-2"></i>Change Password
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="changePasswordForm" method="POST" action="">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="currentPassword">Current Password</label>
                                    <input type="password" class="form-control" id="currentPassword" name="current_password" required>
                                </div>
                                <div class="form-group">
                                    <label for="newPassword">New Password</label>
                                    <input type="password" class="form-control" id="newPassword" name="new_password" required minlength="6">
                                </div>
                                <div class="form-group">
                                    <label for="confirmPassword">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required minlength="6">
                                </div>
                                <div id="passwordError" class="alert alert-danger" style="display: none;"></div>
                                <div id="passwordSuccess" class="alert alert-success" style="display: none;"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" name="change_password" class="btn btn-success">
                                    <i class="fas fa-save mr-2"></i>Change Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <?php include '../footer.php'; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Core JavaScript via CDN to avoid blocked /vendor assets -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin-2.min.js"></script>

    <!-- Settings Page Scripts -->
    <script>
        // Password change form validation
        document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const errorDiv = document.getElementById('passwordError');
            
            // Clear previous errors
            errorDiv.style.display = 'none';
            
            // Validate passwords match
            if (newPassword !== confirmPassword) {
                e.preventDefault();
                errorDiv.textContent = 'New passwords do not match.';
                errorDiv.style.display = 'block';
                return false;
            }
            
            // Validate password length
            if (newPassword.length < 6) {
                e.preventDefault();
                errorDiv.textContent = 'New password must be at least 6 characters long.';
                errorDiv.style.display = 'block';
                return false;
            }
        });

        // Clear form when modal is closed
        $('#changePasswordModal').on('hidden.bs.modal', function () {
            document.getElementById('changePasswordForm').reset();
            document.getElementById('passwordError').style.display = 'none';
            document.getElementById('passwordSuccess').style.display = 'none';
        });

        <?php if(!empty($password_message)): ?>
        // Show success message and close modal
        $(document).ready(function() {
            $('#changePasswordModal').modal('show');
            document.getElementById('passwordSuccess').textContent = '<?php echo $password_message; ?>';
            document.getElementById('passwordSuccess').style.display = 'block';
            setTimeout(function() {
                $('#changePasswordModal').modal('hide');
                location.reload();
            }, 2000);
        });
        <?php endif; ?>

        <?php if(!empty($password_error)): ?>
        // Show error message
        $(document).ready(function() {
            $('#changePasswordModal').modal('show');
            document.getElementById('passwordError').textContent = '<?php echo $password_error; ?>';
            document.getElementById('passwordError').style.display = 'block';
        });
        <?php endif; ?>

        // Theme Selection Handler (integrate with global theme manager)
        document.getElementById('themeSelect').addEventListener('change', function() {
            const selectedTheme = this.value;
            window.themeManager.changeTheme(selectedTheme);
        });

        // Language Selection Handler
        document.getElementById('languageSelect').addEventListener('change', function() {
            const selectedLanguage = this.value;
            localStorage.setItem('language', selectedLanguage);
            
            // You can add language switching logic here
            console.log('Language changed to: ' + selectedLanguage);
            
            // Show confirmation
            showLanguageNotification('Language changed to: ' + selectedLanguage.charAt(0).toUpperCase() + selectedLanguage.slice(1));
        });

        // Function to show language notification
        function showLanguageNotification(message) {
            // Remove existing notifications
            const existingNotifications = document.querySelectorAll('.language-notification');
            existingNotifications.forEach(notification => {
                notification.remove();
            });

            // Create notification element
            const notification = document.createElement('div');
            notification.className = 'alert alert-info alert-dismissible fade show language-notification';
            notification.style.position = 'fixed';
            notification.style.top = '100px';
            notification.style.right = '20px';
            notification.style.zIndex = '9999';
            notification.style.minWidth = '300px';
            notification.innerHTML = `
                <i class="fas fa-language mr-2"></i>${message}
                <button type="button" class="close" onclick="this.parentElement.remove()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            `;
            
            // Add to page
            document.body.appendChild(notification);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 3000);
        }

        // Load saved preferences on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Theme is handled by global theme manager
            const savedLanguage = localStorage.getItem('language');
            
            // Apply saved language
            if (savedLanguage) {
                document.getElementById('languageSelect').value = savedLanguage;
            }
            
            // Sync theme selector with global theme manager
            setTimeout(() => {
                const currentTheme = window.themeManager.getCurrentTheme();
                document.getElementById('themeSelect').value = currentTheme;
            }, 100);
        });
    </script>

</body>

</html>

<?php
}else{
    header("Location: ../../login.php");
}
?>
