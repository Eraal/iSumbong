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
    <meta name="description" content="Cybersecurity Threats - Learn about common cyber threats">
    <meta name="author" content="">

    <title>Threats - iReport</title>
    <link rel="icon" type="image/x-icon" href="../../img/logo1.png" />

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    
    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
    <script src="../../js/sweetalert2.all.js"></script>
    <?php echo getThemeMeta(); ?>
    <?php echo getThemeIncludes('../../'); ?>
    
    <style>
        /* Custom Threats Page Styles */
        .threats-hero {
            animation: fadeIn 1s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .threat-card {
            transition: all 0.3s ease;
        }
        
        .threat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
        }
        
        .threat-icon {
            transition: all 0.3s ease;
        }
        
        .threat-card:hover .threat-icon {
            transform: scale(1.1) rotate(5deg);
        }
        
        .protection-tip {
            transition: all 0.3s ease;
        }
        
        .protection-tip:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
        }
        
        .tip-icon {
            transition: all 0.3s ease;
        }
        
        .protection-tip:hover .tip-icon {
            transform: scale(1.1);
        }
        
        .btn {
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        /* Hero buttons animation */
        .hero-buttons .btn {
            animation: slideUp 1s ease-in-out 0.5s both;
        }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Responsive Design for Threats Page */
        @media (max-width: 1200px) {
            .container {
                max-width: 100%;
                padding-left: 20px;
                padding-right: 20px;
            }
            
            .display-3 {
                font-size: 3rem !important;
            }
            
            .threats-hero {
                min-height: 55vh !important;
            }
            
            .threat-card, .protection-tip {
                padding: 1.5rem !important;
            }
        }
        
        @media (max-width: 992px) {
            .threats-hero {
                min-height: 60vh !important;
                text-align: center;
            }
            
            .display-3 {
                font-size: 2.5rem !important;
            }
            
            .lead {
                font-size: 1.2rem !important;
            }
            
            .hero-buttons .btn {
                margin-bottom: 1rem;
                display: inline-block;
                width: auto;
            }
            
            .col-lg-4, .col-lg-3 {
                margin-bottom: 2rem;
            }
            
            .threat-card, .protection-tip {
                padding: 1.5rem !important;
            }
            
            .threat-icon {
                width: 60px !important;
                height: 60px !important;
            }
            
            .threat-icon i {
                font-size: 1.5rem !important;
            }
        }
        
        @media (max-width: 768px) {
            .threats-hero {
                min-height: 70vh !important;
                padding: 2rem 0;
            }
            
            .display-3 {
                font-size: 2.2rem !important;
            }
            
            .lead {
                font-size: 1.1rem !important;
            }
            
            .hero-buttons .btn {
                margin-bottom: 1rem;
                display: block;
                width: 100%;
                margin-right: 0 !important;
            }
            
            .container {
                padding-left: 15px;
                padding-right: 15px;
            }
            
            .py-5 {
                padding-top: 2rem !important;
                padding-bottom: 2rem !important;
            }
            
            .threat-card, .protection-tip {
                padding: 1.2rem !important;
                margin-bottom: 1.5rem !important;
            }
            
            .threat-icon {
                width: 50px !important;
                height: 50px !important;
            }
            
            .threat-icon i {
                font-size: 1.3rem !important;
            }
            
            .tip-icon {
                width: 50px !important;
                height: 50px !important;
            }
            
            .tip-icon i {
                font-size: 1rem !important;
            }
            
            h4 {
                font-size: 1.3rem !important;
            }
            
            h5 {
                font-size: 1.1rem !important;
            }
            
            h2 {
                font-size: 1.8rem !important;
            }
            
            .btn-sm {
                padding: 0.4rem 0.8rem;
                font-size: 0.85rem;
            }
            
            .col-lg-4, .col-md-6 {
                margin-bottom: 1.5rem;
            }
            
            .col-lg-3, .col-md-6 {
                margin-bottom: 1.5rem;
            }
        }
        
        @media (max-width: 576px) {
            .threats-hero {
                min-height: 80vh !important;
                padding: 1.5rem 0;
            }
            
            .display-3 {
                font-size: 2rem !important;
            }
            
            .lead {
                font-size: 1rem !important;
            }
            
            .container {
                padding-left: 10px;
                padding-right: 10px;
            }
            
            .py-5 {
                padding-top: 1.5rem !important;
                padding-bottom: 1.5rem !important;
            }
            
            .threat-card, .protection-tip {
                padding: 1rem !important;
                margin-bottom: 1rem !important;
            }
            
            .threat-icon {
                width: 45px !important;
                height: 45px !important;
            }
            
            .threat-icon i {
                font-size: 1.2rem !important;
            }
            
            .tip-icon {
                width: 45px !important;
                height: 45px !important;
            }
            
            .tip-icon i {
                font-size: 0.9rem !important;
            }
            
            h4 {
                font-size: 1.2rem !important;
            }
            
            h5 {
                font-size: 1rem !important;
            }
            
            h2 {
                font-size: 1.6rem !important;
            }
            
            .btn-sm {
                padding: 0.3rem 0.6rem;
                font-size: 0.8rem;
            }
            
            .hero-buttons .btn {
                font-size: 0.85rem;
                padding: 0.7rem 1.2rem;
            }
            
            p.text-muted {
                font-size: 0.9rem;
            }
            
            .small {
                font-size: 0.8rem !important;
            }
        }
        
        @media (max-width: 400px) {
            .display-3 {
                font-size: 1.8rem !important;
            }
            
            .container {
                padding-left: 8px;
                padding-right: 8px;
            }
            
            .threat-card, .protection-tip {
                padding: 0.8rem !important;
            }
            
            .threat-icon {
                width: 40px !important;
                height: 40px !important;
            }
            
            .threat-icon i {
                font-size: 1rem !important;
            }
            
            .tip-icon {
                width: 40px !important;
                height: 40px !important;
            }
            
            .tip-icon i {
                font-size: 0.8rem !important;
            }
            
            h4 {
                font-size: 1.1rem !important;
            }
            
            h5 {
                font-size: 0.9rem !important;
            }
            
            h2 {
                font-size: 1.4rem !important;
            }
            
            .btn-sm {
                font-size: 0.75rem;
                padding: 0.25rem 0.5rem;
            }
            
            .hero-buttons .btn {
                font-size: 0.8rem;
                padding: 0.6rem 1rem;
            }
            
            p.text-muted {
                font-size: 0.85rem;
            }
            
            .small {
                font-size: 0.75rem !important;
            }
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div class="container-fluid p-0">

        <!-- Navigation -->
        <?php include'../nav.php';?>

        <!-- Main Content -->
        <div class="container-fluid p-0">
            
            <!-- Hero Section -->
            <section class="threats-hero" style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); min-height: 60vh; display: flex; align-items: center; position: relative; overflow: hidden;">
                <!-- Background Pattern -->
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: radial-gradient(circle at 25% 25%, rgba(255,255,255,0.05) 1px, transparent 1px); background-size: 50px 50px; opacity: 0.3;"></div>
                
                <div class="container text-center">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 text-white">
                            <h1 class="display-3 font-weight-bold mb-4" style="font-size: 3.5rem; line-height: 1.1;">
                                Cybersecurity <span style="color: #3498db;">Threats</span>
                            </h1>
                            <p class="lead mb-5" style="font-size: 1.3rem; opacity: 0.9; max-width: 600px; margin: 0 auto;">
                                Learn about common cyber threats and how to protect yourself from them.
                            </p>
                            
                            <!-- Action Buttons -->
                            <div class="hero-buttons">
                                <a href="../dashboard/" class="btn btn-outline-light btn-lg mr-3 px-4 py-3" style="border-radius: 50px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; border-width: 2px;">
                                    <i class="fas fa-home mr-2"></i>Back to Dashboard
                                </a>
                                <a href="#threats-section" class="btn btn-danger btn-lg px-4 py-3" style="border-radius: 50px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
                                    <i class="fas fa-shield-alt mr-2"></i>Learn About Threats
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Cybersecurity Incidents Section -->
            <section id="threats-section" class="incidents-section py-5" style="background: #f8f9fa;">
                <div class="container">
                    <div class="row text-center mb-5">
                        <div class="col-12">
                            <h2 class="font-weight-bold text-dark mb-3">Cybersecurity Incidents</h2>
                            <p class="text-muted">Understand the most common online threats and how to avoid them.</p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <!-- Phishing -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="threat-card h-100" style="background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.08); border: none; transition: all 0.3s ease;">
                                <div class="threat-icon mb-3" style="width: 70px; height: 70px; background: linear-gradient(45deg, #e74c3c, #c0392b); border-radius: 1rem; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-envelope text-white fa-2x"></i>
                                </div>
                                <h4 class="font-weight-bold text-dark mb-3">Phishing</h4>
                                <p class="text-muted mb-4">Tricking users to reveal sensitive info via fake messages.</p>
                                <a href="#" class="btn btn-outline-danger btn-sm view-details-btn" data-threat="phishing">
                                    View details <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Malware -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="threat-card h-100" style="background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.08); border: none; transition: all 0.3s ease;">
                                <div class="threat-icon mb-3" style="width: 70px; height: 70px; background: linear-gradient(45deg, #f39c12, #e67e22); border-radius: 1rem; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-bug text-white fa-2x"></i>
                                </div>
                                <h4 class="font-weight-bold text-dark mb-3">Malware</h4>
                                <p class="text-muted mb-4">Malicious software that harms or exploits.</p>
                                <a href="#" class="btn btn-outline-warning btn-sm view-details-btn" data-threat="malware">
                                    View details <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Unauthorized Access -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="threat-card h-100" style="background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.08); border: none; transition: all 0.3s ease;">
                                <div class="threat-icon mb-3" style="width: 70px; height: 70px; background: linear-gradient(45deg, #3498db, #2980b9); border-radius: 1rem; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-lock-open text-white fa-2x"></i>
                                </div>
                                <h4 class="font-weight-bold text-dark mb-3">Unauthorized Access</h4>
                                <p class="text-muted mb-4">Illegal access to accounts or systems.</p>
                                <a href="#" class="btn btn-outline-primary btn-sm view-details-btn" data-threat="unauthorized">
                                    View details <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Cyberbullying -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="threat-card h-100" style="background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.08); border: none; transition: all 0.3s ease;">
                                <div class="threat-icon mb-3" style="width: 70px; height: 70px; background: linear-gradient(45deg, #9b59b6, #8e44ad); border-radius: 1rem; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-user-slash text-white fa-2x"></i>
                                </div>
                                <h4 class="font-weight-bold text-dark mb-3">Cyberbullying</h4>
                                <p class="text-muted mb-4">Harassment or intimidation through digital platforms.</p>
                                <a href="#" class="btn btn-outline-secondary btn-sm view-details-btn" data-threat="cyberbullying">
                                    View details <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Identity Theft -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="threat-card h-100" style="background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.08); border: none; transition: all 0.3s ease;">
                                <div class="threat-icon mb-3" style="width: 70px; height: 70px; background: linear-gradient(45deg, #27ae60, #229954); border-radius: 1rem; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-id-card text-white fa-2x"></i>
                                </div>
                                <h4 class="font-weight-bold text-dark mb-3">Identity Theft</h4>
                                <p class="text-muted mb-4">Stealing personal information to impersonate.</p>
                                <a href="#" class="btn btn-outline-success btn-sm view-details-btn" data-threat="identity">
                                    View details <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Online Fraud -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="threat-card h-100" style="background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.08); border: none; transition: all 0.3s ease;">
                                <div class="threat-icon mb-3" style="width: 70px; height: 70px; background: linear-gradient(45deg, #f1c40f, #f39c12); border-radius: 1rem; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-credit-card text-white fa-2x"></i>
                                </div>
                                <h4 class="font-weight-bold text-dark mb-3">Online Fraud</h4>
                                <p class="text-muted mb-4">Deceptive schemes to steal money or valuables online.</p>
                                <a href="#" class="btn btn-outline-warning btn-sm view-details-btn" data-threat="fraud">
                                    View details <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Protection Tips Section -->
            <section class="protection-section py-5">
                <div class="container">
                    <div class="row text-center mb-5">
                        <div class="col-12">
                            <h2 class="font-weight-bold text-dark mb-3">Protection Guidelines</h2>
                            <p class="text-muted">Essential security practices to keep you safe online</p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="protection-tip text-center p-4" style="background: white; border-radius: 1rem; box-shadow: 0 5px 15px rgba(0,0,0,0.08); height: 100%;">
                                <div class="tip-icon mb-3" style="width: 60px; height: 60px; background: linear-gradient(45deg, #3498db, #2980b9); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                    <i class="fas fa-key text-white fa-lg"></i>
                                </div>
                                <h5 class="font-weight-bold mb-3">Strong Passwords</h5>
                                <p class="text-muted small">Use complex passwords with numbers, symbols, and letters. Enable two-factor authentication.</p>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="protection-tip text-center p-4" style="background: white; border-radius: 1rem; box-shadow: 0 5px 15px rgba(0,0,0,0.08); height: 100%;">
                                <div class="tip-icon mb-3" style="width: 60px; height: 60px; background: linear-gradient(45deg, #e74c3c, #c0392b); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                    <i class="fas fa-eye text-white fa-lg"></i>
                                </div>
                                <h5 class="font-weight-bold mb-3">Verify Sources</h5>
                                <p class="text-muted small">Always verify email senders and website URLs before clicking links or downloading files.</p>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="protection-tip text-center p-4" style="background: white; border-radius: 1rem; box-shadow: 0 5px 15px rgba(0,0,0,0.08); height: 100%;">
                                <div class="tip-icon mb-3" style="width: 60px; height: 60px; background: linear-gradient(45deg, #27ae60, #229954); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                    <i class="fas fa-sync text-white fa-lg"></i>
                                </div>
                                <h5 class="font-weight-bold mb-3">Keep Updated</h5>
                                <p class="text-muted small">Regularly update your software, operating system, and antivirus programs.</p>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="protection-tip text-center p-4" style="background: white; border-radius: 1rem; box-shadow: 0 5px 15px rgba(0,0,0,0.08); height: 100%;">
                                <div class="tip-icon mb-3" style="width: 60px; height: 60px; background: linear-gradient(45deg, #f39c12, #e67e22); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                    <i class="fas fa-exclamation-triangle text-white fa-lg"></i>
                                </div>
                                <h5 class="font-weight-bold mb-3">Report Incidents</h5>
                                <p class="text-muted small">Immediately report any suspicious activity or security incidents to the appropriate authorities.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
        <!-- End of Main Content -->
        
        <!-- Custom Styles -->
        <style>
            /* Hero Animation */
            .threats-hero {
                animation: fadeIn 1s ease-in-out;
            }
            
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(30px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            /* Threat Card Hover Effects */
            .threat-card {
                transition: all 0.3s ease;
            }
            
            .threat-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
            }
            
            .threat-card:hover .threat-icon {
                transform: scale(1.1) rotate(5deg);
            }
            
            /* Protection Tip Hover */
            .protection-tip {
                transition: all 0.3s ease;
            }
            
            .protection-tip:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 30px rgba(0,0,0,0.15) !important;
            }
            
            .protection-tip:hover .tip-icon {
                transform: scale(1.1);
            }
            
            /* Icon Animations */
            .threat-icon, .tip-icon {
                transition: all 0.3s ease;
            }
            
            /* Button Hover Effects */
            .btn {
                transition: all 0.3s ease;
            }
            
            .btn:hover {
                transform: translateY(-2px);
            }
            
            /* Section Animations */
            .incidents-section, .protection-section {
                animation: slideUp 1s ease-in-out 0.3s both;
            }
            
            @keyframes slideUp {
                from { opacity: 0; transform: translateY(50px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            /* Smooth Scroll */
            html {
                scroll-behavior: smooth;
            }
            
            /* Responsive Design */
            @media (max-width: 768px) {
                .display-3 {
                    font-size: 2.5rem !important;
                }
                
                .hero-buttons .btn {
                    margin-bottom: 1rem;
                    display: block;
                    width: 100%;
                }
                
                .threat-card, .protection-tip {
                    margin-bottom: 2rem;
                }
            }
        </style>
        
        <?php include'../footer.php';?>

    </div>
    <!-- End of Page Wrapper -->

    <!-- Threat Details Modal -->
    <div class="modal fade" id="threatModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="threatModalTitle">Threat Details</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="threatModalBody">
                    <!-- Content will be loaded dynamically -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a href="../incident/register.php" class="btn btn-danger">Report Incident</a>
                </div>
            </div>
        </div>
    </div>

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
        // Threat Details Data
        const threatDetails = {
            phishing: {
                title: "Phishing Attacks",
                content: `
                    <div class="threat-detail">
                        <h6 class="font-weight-bold">What is Phishing?</h6>
                        <p>Phishing is a cybercrime where attackers impersonate legitimate organizations to steal sensitive information like passwords, credit card numbers, or personal data.</p>
                        
                        <h6 class="font-weight-bold mt-3">Common Signs:</h6>
                        <ul>
                            <li>Urgent or threatening language</li>
                            <li>Suspicious sender addresses</li>
                            <li>Generic greetings</li>
                            <li>Requests for sensitive information</li>
                            <li>Suspicious links or attachments</li>
                        </ul>
                        
                        <h6 class="font-weight-bold mt-3">Protection Tips:</h6>
                        <ul>
                            <li>Verify sender identity through official channels</li>
                            <li>Don't click suspicious links</li>
                            <li>Check URLs carefully</li>
                            <li>Use email filters and security software</li>
                        </ul>
                    </div>
                `
            },
            malware: {
                title: "Malware Threats",
                content: `
                    <div class="threat-detail">
                        <h6 class="font-weight-bold">What is Malware?</h6>
                        <p>Malware (malicious software) is designed to damage, disrupt, or gain unauthorized access to computer systems.</p>
                        
                        <h6 class="font-weight-bold mt-3">Types of Malware:</h6>
                        <ul>
                            <li>Viruses - Self-replicating programs</li>
                            <li>Trojans - Disguised malicious software</li>
                            <li>Ransomware - Encrypts files for ransom</li>
                            <li>Spyware - Secretly monitors activity</li>
                            <li>Adware - Displays unwanted advertisements</li>
                        </ul>
                        
                        <h6 class="font-weight-bold mt-3">Prevention:</h6>
                        <ul>
                            <li>Install reputable antivirus software</li>
                            <li>Keep software updated</li>
                            <li>Avoid suspicious downloads</li>
                            <li>Regular system scans</li>
                        </ul>
                    </div>
                `
            },
            unauthorized: {
                title: "Unauthorized Access",
                content: `
                    <div class="threat-detail">
                        <h6 class="font-weight-bold">What is Unauthorized Access?</h6>
                        <p>Unauthorized access occurs when someone gains access to a computer system, network, or data without permission.</p>
                        
                        <h6 class="font-weight-bold mt-3">Common Methods:</h6>
                        <ul>
                            <li>Password attacks (brute force, dictionary)</li>
                            <li>Social engineering</li>
                            <li>Exploiting security vulnerabilities</li>
                            <li>Physical access to devices</li>
                            <li>Man-in-the-middle attacks</li>
                        </ul>
                        
                        <h6 class="font-weight-bold mt-3">Security Measures:</h6>
                        <ul>
                            <li>Strong, unique passwords</li>
                            <li>Two-factor authentication</li>
                            <li>Regular security updates</li>
                            <li>Access control and monitoring</li>
                            <li>Secure physical access</li>
                        </ul>
                    </div>
                `
            },
            cyberbullying: {
                title: "Cyberbullying",
                content: `
                    <div class="threat-detail">
                        <h6 class="font-weight-bold">What is Cyberbullying?</h6>
                        <p>Cyberbullying involves using digital platforms to harass, intimidate, or threaten individuals, often repeatedly and with intent to harm.</p>
                        
                        <h6 class="font-weight-bold mt-3">Forms of Cyberbullying:</h6>
                        <ul>
                            <li>Harassment through messages</li>
                            <li>Public shaming or humiliation</li>
                            <li>Spreading false information</li>
                            <li>Exclusion from online groups</li>
                            <li>Identity theft for harassment</li>
                        </ul>
                        
                        <h6 class="font-weight-bold mt-3">How to Respond:</h6>
                        <ul>
                            <li>Document evidence</li>
                            <li>Block the aggressor</li>
                            <li>Report to platform administrators</li>
                            <li>Seek support from trusted individuals</li>
                            <li>Consider legal action if necessary</li>
                        </ul>
                    </div>
                `
            },
            identity: {
                title: "Identity Theft",
                content: `
                    <div class="threat-detail">
                        <h6 class="font-weight-bold">What is Identity Theft?</h6>
                        <p>Identity theft occurs when someone steals personal information to impersonate another person for financial gain or other malicious purposes.</p>
                        
                        <h6 class="font-weight-bold mt-3">Targeted Information:</h6>
                        <ul>
                            <li>Social Security numbers</li>
                            <li>Credit card information</li>
                            <li>Bank account details</li>
                            <li>Personal identifying information</li>
                            <li>Login credentials</li>
                        </ul>
                        
                        <h6 class="font-weight-bold mt-3">Protection Strategies:</h6>
                        <ul>
                            <li>Monitor credit reports regularly</li>
                            <li>Secure personal documents</li>
                            <li>Be cautious with personal information online</li>
                            <li>Use identity monitoring services</li>
                            <li>Report suspicious activity immediately</li>
                        </ul>
                    </div>
                `
            },
            fraud: {
                title: "Online Fraud",
                content: `
                    <div class="threat-detail">
                        <h6 class="font-weight-bold">What is Online Fraud?</h6>
                        <p>Online fraud involves deceptive schemes conducted over the internet to steal money, personal information, or other valuables from victims.</p>
                        
                        <h6 class="font-weight-bold mt-3">Common Types:</h6>
                        <ul>
                            <li>Credit card fraud</li>
                            <li>Investment scams</li>
                            <li>Online shopping fraud</li>
                            <li>Romance scams</li>
                            <li>Advance fee fraud</li>
                        </ul>
                        
                        <h6 class="font-weight-bold mt-3">Red Flags:</h6>
                        <ul>
                            <li>Too-good-to-be-true offers</li>
                            <li>Pressure to act quickly</li>
                            <li>Requests for upfront payments</li>
                            <li>Unsolicited contact</li>
                            <li>Poor grammar or spelling</li>
                        </ul>
                    </div>
                `
            }
        };

        // Handle threat detail buttons
        $('.view-details-btn').click(function(e) {
            e.preventDefault();
            const threatType = $(this).data('threat');
            const threat = threatDetails[threatType];
            
            if (threat) {
                $('#threatModalTitle').text(threat.title);
                $('#threatModalBody').html(threat.content);
                $('#threatModal').modal('show');
            }
        });

        // Navigation active state
        $(document).ready(function() {
            // Remove active class from all nav links
            $('.navbar-nav .nav-link').removeClass('active');
            
            // Add active class to Threats link (you'll need to add this to nav)
            $('.navbar-nav .nav-link[href*="threats"]').addClass('active');
            
            // Stagger animation for threat cards
            $('.threat-card').each(function(index) {
                $(this).css({
                    'animation-delay': (index * 0.1) + 's',
                    'animation': 'slideUp 0.6s ease-out forwards'
                });
            });
            
            // Stagger animation for protection tips
            $('.protection-tip').each(function(index) {
                $(this).css({
                    'animation-delay': (index * 0.1 + 0.5) + 's',
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
