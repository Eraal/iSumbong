<?php
include '../../connectMySql.php';
include '../../loginverification.php';
include '../../includes/theme_system.php';
if(logged_in()){
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="About iSumbong - Cybersecurity Awareness & Reporting Platform">
    <meta name="author" content="">

    <title>About - iSumbong</title>
    <link rel="icon" type="image/x-icon" href="../../img/logo1.png" />

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Fallback CDN for Font Awesome in case local fonts fail to load -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    
    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
    <script src="../../js/sweetalert2.all.js"></script>
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
            <section class="about-hero" style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); min-height: 60vh; display: flex; align-items: center; position: relative; overflow: hidden;">
                <!-- Background Pattern -->
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: radial-gradient(circle at 25% 25%, rgba(255,255,255,0.05) 1px, transparent 1px); background-size: 50px 50px; opacity: 0.3;"></div>
                
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-8 text-white">
                            <h1 class="display-3 font-weight-bold mb-4" style="font-size: 3.5rem; line-height: 1.1;">
                                About <span style="color: #3498db;">iSumbong</span>
                            </h1>
                            <p class="lead mb-4" style="font-size: 1.3rem; opacity: 0.9; max-width: 600px;">
                                Empowering organizations and individuals with comprehensive cybersecurity awareness and incident reporting solutions.
                            </p>
                        </div>
                        <div class="col-lg-4 text-center">
                            <div class="about-icon" style="width: 150px; height: 150px; margin: 0 auto; background: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                                <i class="fas fa-info-circle" style="font-size: 4rem; color: #3498db;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Mission Section -->
            <section class="mission-section py-5" style="background: #f8f9fa;">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <div class="mission-card h-100" style="background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.08); border: none;">
                                <div class="icon-wrapper mb-3" style="width: 60px; height: 60px; background: linear-gradient(45deg, #2c3e50, #34495e); border-radius: 1rem; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-bullseye text-white fa-lg"></i>
                                </div>
                                <h3 class="font-weight-bold text-dark mb-3">Our Mission</h3>
                                <p class="text-dark mb-0" style="line-height: 1.7;">
                                    To provide a comprehensive platform that enables organizations to effectively manage cybersecurity incidents, 
                                    educate users about emerging threats, and build a proactive security culture through awareness and reporting.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="vision-card h-100" style="background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.08); border: none;">
                                <div class="icon-wrapper mb-3" style="width: 60px; height: 60px; background: linear-gradient(45deg, #3498db, #2980b9); border-radius: 1rem; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-eye text-white fa-lg"></i>
                                </div>
                                <h3 class="font-weight-bold text-dark mb-3">Our Vision</h3>
                                <p class="text-dark mb-0" style="line-height: 1.7;">
                                    To create a safer digital environment where every individual is empowered with the knowledge and tools 
                                    necessary to identify, report, and respond to cybersecurity threats effectively.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Features Section -->
            <section class="features-section py-5">
                <div class="container">
                    <div class="row text-center mb-5">
                        <div class="col-12">
                            <h2 class="font-weight-bold text-dark mb-3">Platform Features</h2>
                            <p class="text-dark">Comprehensive tools for cybersecurity management</p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <!-- Incident Reporting -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="feature-card text-center p-4" style="background: white; border-radius: 1rem; box-shadow: 0 5px 15px rgba(0,0,0,0.08); border: none; height: 100%; transition: all 0.3s ease;">
                                <div class="feature-icon mb-3" style="width: 80px; height: 80px; background: linear-gradient(45deg, #e74c3c, #c0392b); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                    <i class="fas fa-exclamation-triangle text-white fa-2x"></i>
                                </div>
                                <h4 class="font-weight-bold text-dark mb-3">Incident Reporting</h4>
                                <p class="text-dark">Easy-to-use incident reporting system with detailed tracking and status updates.</p>
                            </div>
                        </div>

                        <!-- Real-time Monitoring -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="feature-card text-center p-4" style="background: white; border-radius: 1rem; box-shadow: 0 5px 15px rgba(0,0,0,0.08); border: none; height: 100%; transition: all 0.3s ease;">
                                <div class="feature-icon mb-3" style="width: 80px; height: 80px; background: linear-gradient(45deg, #3498db, #2980b9); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                    <i class="fas fa-chart-line text-white fa-2x"></i>
                                </div>
                                <h4 class="font-weight-bold text-dark mb-3">Real-time Analytics</h4>
                                <p class="text-dark">Comprehensive dashboard with real-time statistics and incident analytics.</p>
                            </div>
                        </div>

                        <!-- Security Awareness -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="feature-card text-center p-4" style="background: white; border-radius: 1rem; box-shadow: 0 5px 15px rgba(0,0,0,0.08); border: none; height: 100%; transition: all 0.3s ease;">
                                <div class="feature-icon mb-3" style="width: 80px; height: 80px; background: linear-gradient(45deg, #27ae60, #229954); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                    <i class="fas fa-shield-alt text-white fa-2x"></i>
                                </div>
                                <h4 class="font-weight-bold text-dark mb-3">Security Education</h4>
                                <p class="text-dark">Educational resources and threat awareness materials to enhance security knowledge.</p>
                            </div>
                        </div>

                        <!-- User Management -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="feature-card text-center p-4" style="background: white; border-radius: 1rem; box-shadow: 0 5px 15px rgba(0,0,0,0.08); border: none; height: 100%; transition: all 0.3s ease;">
                                <div class="feature-icon mb-3" style="width: 80px; height: 80px; background: linear-gradient(45deg, #9b59b6, #8e44ad); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                    <i class="fas fa-users text-white fa-2x"></i>
                                </div>
                                <h4 class="font-weight-bold text-dark mb-3">User Management</h4>
                                <p class="text-dark">Comprehensive user management system with role-based access control.</p>
                            </div>
                        </div>

                        <!-- Notification System -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="feature-card text-center p-4" style="background: white; border-radius: 1rem; box-shadow: 0 5px 15px rgba(0,0,0,0.08); border: none; height: 100%; transition: all 0.3s ease;">
                                <div class="feature-icon mb-3" style="width: 80px; height: 80px; background: linear-gradient(45deg, #f39c12, #e67e22); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                    <i class="fas fa-bell text-white fa-2x"></i>
                                </div>
                                <h4 class="font-weight-bold text-dark mb-3">Smart Notifications</h4>
                                <p class="text-dark">Automated notification system for incident updates and security alerts.</p>
                            </div>
                        </div>

                        <!-- Secure Platform -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="feature-card text-center p-4" style="background: white; border-radius: 1rem; box-shadow: 0 5px 15px rgba(0,0,0,0.08); border: none; height: 100%; transition: all 0.3s ease;">
                                <div class="feature-icon mb-3" style="width: 80px; height: 80px; background: linear-gradient(45deg, #1abc9c, #16a085); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                    <i class="fas fa-lock text-white fa-2x"></i>
                                </div>
                                <h4 class="font-weight-bold text-dark mb-3">Secure Platform</h4>
                                <p class="text-dark">Enterprise-grade security with encrypted data transmission and secure authentication.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Contact Section -->
            <section class="contact-section py-5" style="background: #f8f9fa;">
                <div class="container">
                    <div class="row text-center mb-5">
                        <div class="col-12">
                            <h2 class="font-weight-bold text-dark mb-3">Get Started Today</h2>
                            <p class="text-dark">Ready to enhance your cybersecurity posture?</p>
                        </div>
                    </div>
                    
                    <div class="row justify-content-center">
                        <div class="col-lg-8 text-center">
                            <div class="cta-card p-5" style="background: white; border-radius: 1rem; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                                <h3 class="font-weight-bold text-dark mb-3">Start Reporting Incidents</h3>
                                <p class="text-dark mb-4">Join thousands of organizations using iSumbong to manage their cybersecurity incidents effectively.</p>
                                
                                <div class="cta-buttons">
                                    <a href="../incident/register.php" class="btn btn-danger btn-lg mr-3 px-4 py-3" style="border-radius: 50px; font-weight: 600;">
                                        <i class="fas fa-plus mr-2"></i>Report Incident
                                    </a>
                                    <a href="../incident/" class="btn btn-outline-primary btn-lg px-4 py-3" style="border-radius: 50px; font-weight: 600;">
                                        <i class="fas fa-list mr-2"></i>View Incidents
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
        <!-- End of Main Content -->
        
        <!-- Custom Styles -->
        <style>
            /* Page Animations */
            .about-hero {
                animation: fadeIn 1s ease-in-out;
            }
            
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(30px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            /* Card Hover Effects */
            .mission-card, .vision-card, .feature-card, .cta-card {
                transition: all 0.3s ease;
            }
            
            .mission-card:hover, .vision-card:hover, .feature-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
            }
            
            /* Icon Animations */
            .about-icon {
                animation: pulse 2s infinite;
            }
            
            @keyframes pulse {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.05); }
            }
            
            .feature-icon {
                transition: all 0.3s ease;
            }
            
            .feature-card:hover .feature-icon {
                transform: scale(1.1) rotate(5deg);
            }
            
            /* Button Effects */
            .cta-buttons .btn {
                transition: all 0.3s ease;
            }
            
            .cta-buttons .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            }
            
            /* Section Animations */
            .mission-section, .features-section {
                animation: slideUp 1s ease-in-out 0.3s both;
            }
            
            @keyframes slideUp {
                from { opacity: 0; transform: translateY(50px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            /* Counter Animation */
            .counter-item {
                animation: fadeInUp 1s ease-in-out 0.5s both;
            }
            
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(30px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            /* Responsive */
            @media (max-width: 1200px) {
                .container {
                    max-width: 100%;
                    padding-left: 20px;
                    padding-right: 20px;
                }
                
                .display-3 {
                    font-size: 3rem !important;
                }
                
                .feature-icon {
                    width: 70px !important;
                    height: 70px !important;
                }
                
                .icon-wrapper {
                    width: 50px !important;
                    height: 50px !important;
                }
            }
            
            @media (max-width: 992px) {
                .about-hero {
                    min-height: 50vh !important;
                    text-align: center;
                }
                
                .display-3 {
                    font-size: 2.8rem !important;
                }
                
                .lead {
                    font-size: 1.1rem !important;
                }
                
                .about-icon {
                    width: 120px !important;
                    height: 120px !important;
                    margin-bottom: 2rem;
                }
                
                .about-icon i {
                    font-size: 3rem !important;
                }
                
                .row {
                    margin-left: -10px;
                    margin-right: -10px;
                }
                
                .col-lg-4, .col-lg-6, .col-lg-8, .col-md-6 {
                    padding-left: 10px;
                    padding-right: 10px;
                    margin-bottom: 2rem;
                }
                
                .feature-card, .mission-card, .vision-card {
                    margin-bottom: 1.5rem;
                }
            }
            
            @media (max-width: 768px) {
                .display-3 {
                    font-size: 2.5rem !important;
                    line-height: 1.2;
                }
                
                .lead {
                    font-size: 1rem !important;
                }
                
                .about-hero {
                    min-height: 40vh !important;
                    padding: 2rem 0;
                }
                
                .container {
                    padding-left: 15px;
                    padding-right: 15px;
                }
                
                .py-5 {
                    padding-top: 2rem !important;
                    padding-bottom: 2rem !important;
                }
                
                .mb-5 {
                    margin-bottom: 2rem !important;
                }
                
                .feature-card, .mission-card, .vision-card {
                    padding: 1.5rem !important;
                    margin-bottom: 1.5rem;
                }
                
                .feature-icon {
                    width: 60px !important;
                    height: 60px !important;
                }
                
                .feature-icon i {
                    font-size: 1.5rem !important;
                }
                
                .icon-wrapper {
                    width: 45px !important;
                    height: 45px !important;
                }
                
                .cta-buttons .btn {
                    margin-bottom: 1rem;
                    display: block;
                    width: 100%;
                    font-size: 0.9rem;
                    padding: 0.8rem 1.5rem;
                }
                
                h2 {
                    font-size: 1.8rem !important;
                }
                
                h3 {
                    font-size: 1.5rem !important;
                }
                
                h4 {
                    font-size: 1.3rem !important;
                }
                
                .text-center {
                    text-align: center !important;
                }
                
                .col-lg-4, .col-lg-6, .col-lg-8, .col-md-6 {
                    text-align: center;
                    margin-bottom: 2rem;
                }
            }
            
            @media (max-width: 576px) {
                .display-3 {
                    font-size: 2rem !important;
                    line-height: 1.1;
                }
                
                .lead {
                    font-size: 0.95rem !important;
                }
                
                .about-hero {
                    min-height: 35vh !important;
                    padding: 1.5rem 0;
                }
                
                .container {
                    padding-left: 10px;
                    padding-right: 10px;
                }
                
                .py-5 {
                    padding-top: 1.5rem !important;
                    padding-bottom: 1.5rem !important;
                }
                
                .feature-card, .mission-card, .vision-card {
                    padding: 1rem !important;
                    margin-bottom: 1rem;
                }
                
                .feature-icon {
                    width: 50px !important;
                    height: 50px !important;
                }
                
                .feature-icon i {
                    font-size: 1.2rem !important;
                }
                
                .icon-wrapper {
                    width: 40px !important;
                    height: 40px !important;
                }
                
                .about-icon {
                    width: 100px !important;
                    height: 100px !important;
                }
                
                .about-icon i {
                    font-size: 2.5rem !important;
                }
                
                h1 {
                    font-size: 1.8rem !important;
                }
                
                h2 {
                    font-size: 1.5rem !important;
                }
                
                h3 {
                    font-size: 1.3rem !important;
                }
                
                h4 {
                    font-size: 1.1rem !important;
                }
                
                .cta-buttons .btn {
                    font-size: 0.85rem;
                    padding: 0.7rem 1.2rem;
                }
                
                .mb-4 {
                    margin-bottom: 1rem !important;
                }
                
                .mb-3 {
                    margin-bottom: 0.8rem !important;
                }
                
                .p-4 {
                    padding: 1rem !important;
                }
                
                .row {
                    margin-left: -5px;
                    margin-right: -5px;
                }
                
                .col-lg-4, .col-lg-6, .col-lg-8, .col-md-6 {
                    padding-left: 5px;
                    padding-right: 5px;
                    margin-bottom: 1.5rem;
                }
            }
            
            @media (max-width: 400px) {
                .display-3 {
                    font-size: 1.7rem !important;
                }
                
                .container {
                    padding-left: 8px;
                    padding-right: 8px;
                }
                
                .feature-card, .mission-card, .vision-card {
                    padding: 0.8rem !important;
                }
                
                .cta-buttons .btn {
                    font-size: 0.8rem;
                    padding: 0.6rem 1rem;
                }
                
                h2 {
                    font-size: 1.3rem !important;
                }
                
                .about-icon {
                    width: 80px !important;
                    height: 80px !important;
                }
                
                .about-icon i {
                    font-size: 2rem !important;
                }
            }
            
            /* Navigation Responsive */
            @media (max-width: 768px) {
                .navbar-nav {
                    text-align: center;
                }
                
                .navbar-nav .nav-item {
                    margin-bottom: 0.5rem;
                }
                
                .dropdown-menu {
                    position: static !important;
                    float: none;
                    width: auto;
                    margin-top: 0;
                    background-color: transparent;
                    border: 0;
                    box-shadow: none;
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
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            
            // Add active class to About link
            $('.navbar-nav .nav-link[href*="about"]').addClass('active');
            
            // Stagger animation for feature cards
            $('.feature-card').each(function(index) {
                $(this).css({
                    'animation-delay': (index * 0.1) + 's',
                    'animation': 'slideUp 0.6s ease-out forwards'
                });
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
}
?>
