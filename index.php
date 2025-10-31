<?php
include('connectMySql.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="description" content="iSumbong - Cybersecurity Incident Reporting Platform">
    <meta name="author" content="PNP Anti-Cybercrime Group">

    <title>iSumbong - Incident Reporting System</title>
    <link rel="icon" type="image/x-icon" href="img/logo1.png"/>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        .hero-section {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        /* Background Pattern */
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(circle at 25% 25%, rgba(255,255,255,0.05) 1px, transparent 1px);
            background-size: 50px 50px;
            opacity: 0.3;
            z-index: 1;
        }
        
        .hero-content {
            color: white;
            text-align: center;
            position: relative;
            z-index: 2;
        }
        
        .hero-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
        }
        
        .hero-logo img {
            margin-right: 1rem;
        }
        
        .hero-logo .brand-text {
            font-size: 2.5rem;
            font-weight: 800;
            color: #3498db;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .btn-custom {
            border-radius: 50px;
            padding: 15px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 10px;
        }
        
        .feature-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
        }
        
        .features-section {
            background: #f8f9fc;
        }
        
        .features-section h2 {
            color: #2c3e50;
        }
        
        .features-section .text-muted {
            color: #6c757d !important;
        }
        
        .about-section {
            background: #ffffff;
        }
        
        .about-section h2 {
            color: #2c3e50;
        }
        
        .about-section p {
            color: #495057;
        }
        
        .partnership-logos {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 2rem;
            margin: 2rem 0;
            flex-wrap: nowrap;
        }
        
        .logo-container {
            text-align: center;
            position: relative;
        }
        
        .logo-box {
            width: 160px;
            height: 160px;
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 35px rgba(44, 62, 80, 0.4);
            position: relative;
            overflow: hidden;
        }
        
        .logo-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, transparent 50%);
            z-index: 1;
        }
        
        .logo-box img {
            max-width: 90px;
            max-height: 90px;
            z-index: 2;
            position: relative;
        }
        
        .logo-label {
            font-size: 1rem;
            font-weight: 600;
            color: #2c3e50;
            line-height: 1.3;
        }
        
        /* Mobile-first responsive design - Proper sizing, not shrinking */
        @media (max-width: 575px) {
            .hero-section {
                padding: 2rem 0;
                min-height: 100vh;
            }
            
            .hero-logo .brand-text {
                font-size: 2.8rem !important;
                line-height: 1.2;
                text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
            }
            
            .hero-logo img {
                width: 80px;
                height: 80px;
            }
            
            .display-3 {
                font-size: 3.2rem !important;
                line-height: 1.1;
                margin-bottom: 1.5rem !important;
                text-shadow: 2px 2px 4px rgba(0,0,0,0.6);
            }
            
            .lead {
                font-size: 1.5rem !important;
                line-height: 1.4;
                margin-bottom: 2rem !important;
                text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
                font-weight: 500;
            }
            
            .btn-custom {
                padding: 18px 30px !important;
                font-size: 1.2rem !important;
                margin: 10px 0 !important;
                display: block;
                width: 100%;
                max-width: 350px;
                margin-left: auto;
                margin-right: auto;
                margin-bottom: 1.5rem !important;
                border-radius: 50px;
                font-weight: 700;
                min-height: 56px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            }
            
            .container-fluid {
                padding-left: 1.5rem !important;
                padding-right: 1.5rem !important;
            }
            
            .partnership-logos {
                flex-direction: row;
                gap: 1.2rem;
                justify-content: center;
                flex-wrap: wrap;
                margin-top: 2rem;
            }
            
            .logo-box {
                width: 120px;
                height: 120px;
            }
            
            .logo-box img {
                max-width: 75px;
                max-height: 75px;
            }
            
            .logo-label {
                font-size: 1rem !important;
                line-height: 1.3;
                font-weight: 600;
            }
            
            .step-number {
                width: 55px !important;
                height: 55px !important;
                font-size: 1.4rem !important;
            }
            
            .feature-card {
                margin-bottom: 2rem;
            }
            
            .card-body.p-4 {
                padding: 2rem !important;
            }
            
            .card-body.p-5 {
                padding: 2.5rem !important;
            }
            
            /* Enhanced typography for mobile readability */
            h2 {
                font-size: 2.5rem !important;
                line-height: 1.2;
                margin-bottom: 1.5rem !important;
            }
            
            h4 {
                font-size: 2rem !important;
                line-height: 1.3;
            }
            
            h5 {
                font-size: 1.6rem !important;
                line-height: 1.3;
            }
            
            .card-title {
                font-size: 1.7rem !important;
                margin-bottom: 1rem !important;
            }
            
            .card-text {
                font-size: 1.2rem !important;
                line-height: 1.6;
            }
            
            p {
                font-size: 1.2rem !important;
                line-height: 1.6;
            }
            
            .text-muted {
                font-size: 1.1rem !important;
            }
            
            /* Form improvements for mobile */
            .form-label {
                font-size: 1.2rem !important;
                font-weight: 600 !important;
                margin-bottom: 0.75rem !important;
            }
            
            .form-control {
                font-size: 1.2rem !important;
                padding: 1rem 1.2rem !important;
                border-radius: 10px !important;
                min-height: 50px;
            }
            
            .btn {
                font-size: 1.2rem !important;
                padding: 1rem 1.5rem !important;
                min-height: 50px;
                border-radius: 10px !important;
            }
            
            /* Alert improvements */
            .alert {
                font-size: 1.2rem !important;
                padding: 1.5rem !important;
                border-radius: 12px !important;
            }
                padding: 2rem !important;
            }
        }
        
        @media (min-width: 576px) and (max-width: 767px) {
            .hero-logo .brand-text {
                font-size: 2.2rem;
            }
            
            .display-3 {
                font-size: 2.5rem !important;
            }
            
            .btn-custom {
                padding: 14px 25px;
                margin: 8px;
            }
            
            .partnership-logos {
                flex-direction: row;
                gap: 1rem;
                justify-content: center;
                flex-wrap: nowrap;
            }
            
            .logo-box {
                width: 110px;
                height: 110px;
            }
            
            .logo-box img {
                max-width: 65px;
                max-height: 65px;
            }
            
            .logo-label {
                font-size: 0.85rem;
            }
        }
        
        @media (min-width: 768px) and (max-width: 991px) {
            .hero-logo .brand-text {
                font-size: 2.3rem;
            }
            
            .partnership-logos {
                flex-direction: row;
                gap: 1.5rem;
                justify-content: center;
                flex-wrap: nowrap;
            }
            
            .logo-box {
                width: 120px;
                height: 120px;
            }
            
            .logo-box img {
                max-width: 70px;
                max-height: 70px;
            }
            
            .btn-custom {
                margin: 8px;
                padding: 14px 25px;
            }
        }
        
        @media (min-width: 992px) and (max-width: 1199px) {
            .hero-logo .brand-text {
                font-size: 2.4rem;
            }
            
            .partnership-logos {
                gap: 2rem;
            }
            
            .logo-box {
                width: 140px;
                height: 140px;
            }
            
            .logo-box img {
                max-width: 80px;
                max-height: 80px;
            }
        }
        
        @media (min-width: 1200px) {
            .partnership-logos {
                gap: 2.5rem;
            }
            
            .logo-box {
                width: 150px;
                height: 150px;
            }
            
            .logo-box img {
                max-width: 85px;
                max-height: 85px;
            }
        }
        
        /* Form responsive enhancements */
        @media (max-width: 991px) {
            .col-lg-6.mb-3 {
                margin-bottom: 1rem !important;
            }
            
            .col-lg-3.col-md-6 {
                margin-bottom: 1rem;
            }
            
            .alert ol {
                text-align: center !important;
            }
        }
        
        /* Table and card responsive */
        @media (max-width: 768px) {
            .card {
                margin-bottom: 1rem;
            }
            
            .row {
                margin-left: 0;
                margin-right: 0;
            }
            
            .container {
                padding-left: 15px;
                padding-right: 15px;
            }
            
            .text-center h2 {
                font-size: 1.75rem;
            }
            
            .text-center h4 {
                font-size: 1.5rem;
            }
            
            .text-center h5 {
                font-size: 1.25rem;
            }
        }
        
        /* Utility classes for better mobile experience */
        @media (max-width: 575px) {
            .d-mobile-block {
                display: block !important;
            }
            
            .text-mobile-center {
                text-align: center !important;
            }
            
            .mb-mobile-3 {
                margin-bottom: 1rem !important;
            }
            
            .p-mobile-2 {
                padding: 0.5rem !important;
            }
        }
        
        /* Enhanced button responsiveness */
        @media (max-width: 575px) {
            .hero-buttons {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 1rem;
            }
            
            .hero-buttons .btn {
                width: 100%;
                max-width: 280px;
            }
        }
        
        /* Fix for very small devices */
        @media (max-width: 360px) {
            .hero-logo .brand-text {
                font-size: 1.6rem;
            }
            
            .hero-logo img {
                width: 50px;
                height: 50px;
                margin-right: 0.5rem;
            }
            
            .display-3 {
                font-size: 1.8rem !important;
            }
            
            .logo-box {
                width: 100px;
                height: 100px;
            }
            
            .logo-box img {
                max-width: 60px;
                max-height: 60px;
            }
            
            .step-number {
                width: 45px !important;
                height: 45px !important;
                font-size: 1.1rem !important;
            }
            
            .card-body.p-4 {
                padding: 1rem !important;
            }
        }
        
        /* Tutorial Gallery Styles */
        .tutorial-card {
            transition: all 0.3s ease;
            cursor: pointer;
            overflow: hidden;
        }
        
        .tutorial-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.2) !important;
        }
        
        .tutorial-image-container {
            position: relative;
            overflow: hidden;
            height: 200px;
            border-radius: 15px 15px 0 0;
        }
        
        .tutorial-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top;
            transition: transform 0.3s ease;
        }
        
        .tutorial-card:hover .tutorial-image {
            transform: scale(1.1);
        }
        
        .tutorial-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(0,0,0,0.7) 0%, transparent 50%);
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 15px;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }
        
        .tutorial-card:hover .tutorial-overlay,
        .tutorial-image-container:hover .tutorial-overlay {
            opacity: 1;
        }
        
        .tutorial-image-container {
            cursor: pointer;
        }
        
        .tutorial-step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        
        .tutorial-zoom-icon {
            background: rgba(255,255,255,0.9);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        
        /* Modal styles for image gallery */
        .modal-dialog.modal-xl {
            max-width: 90%;
        }
        
        .tutorial-modal-image {
            max-width: 100%;
            max-height: 70vh;
            object-fit: contain;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        
        /* Responsive tutorial gallery */
        @media (max-width: 767px) {
            .tutorial-image-container {
                height: 180px;
            }
            
            .tutorial-overlay {
                padding: 10px;
            }
            
            .tutorial-step-number {
                width: 35px;
                height: 35px;
                font-size: 1rem;
            }
            
            .tutorial-zoom-icon {
                width: 35px;
                height: 35px;
                font-size: 1rem;
            }
        }
        
        @media (max-width: 575px) {
            .tutorial-image-container {
                height: 160px;
            }
            
            .tutorial-step-number {
                width: 30px;
                height: 30px;
                font-size: 0.9rem;
            }
            
            .tutorial-zoom-icon {
                width: 30px;
                height: 30px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container-fluid px-3 px-md-4">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10 col-xl-8">
                    <div class="hero-content">
                        <div class="hero-logo">
                            <img src="img/logo1.png" alt="iReport Logo" class="img-fluid" style="width: 80px; height: 80px;">
                            <span class="brand-text">iSumbong</span>
                        </div>
                        <h1 class="display-3 font-weight-bold mb-3 mb-md-4">Welcome to iSumbong</h1>
                        <p class="lead mb-4 mb-md-5 px-2 px-md-0">Your trusted portal for Cybersecurity Incident Reporting and Awareness</p>
                        
                        <div class="hero-buttons">
                            <a href="login.php" class="btn btn-light btn-lg btn-custom">
                                <i class="fas fa-sign-in-alt mr-2"></i>Login
                            </a>
                            <a href="register.php" class="btn btn-outline-light btn-lg btn-custom">
                                <i class="fas fa-user-plus mr-2"></i>Register
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-4 py-md-5 features-section">
        <div class="container">
            <div class="row text-center mb-4 mb-md-5">
                <div class="col-12">
                    <h2 class="font-weight-bold">Key Features</h2>
                    <p class="text-muted">Comprehensive cybersecurity incident reporting and management</p>
                </div>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-3 p-md-4">
                            <div class="mb-3">
                                <i class="fas fa-exclamation-triangle fa-3x text-danger"></i>
                            </div>
                            <h5 class="card-title">Report Incidents</h5>
                            <p class="card-text">Quickly and securely report cybersecurity incidents to the authorities.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-3 p-md-4">
                            <div class="mb-3">
                                <i class="fas fa-shield-alt fa-3x text-primary"></i>
                            </div>
                            <h5 class="card-title">Track Progress</h5>
                            <p class="card-text">Monitor the status and progress of your reported incidents.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-3 p-md-4">
                            <div class="mb-3">
                                <i class="fas fa-graduation-cap fa-3x text-success"></i>
                            </div>
                            <h5 class="card-title">Learn & Protect</h5>
                            <p class="card-text">Access educational resources about cybersecurity threats and protection.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tutorial Section -->
    <section class="py-4 py-md-5" style="background: linear-gradient(135deg, #f8f9fc 0%, #e3f2fd 100%);">
        <div class="container">
            <div class="row text-center mb-4 mb-md-5">
                <div class="col-12">
                    <h2 class="font-weight-bold" style="color: #2c3e50;">How to Use iSumbong</h2>
                    <p class="text-muted">Visual guide showing the actual system interface</p>
                </div>
            </div>
            
            <!-- Image Gallery -->
            <div class="row justify-content-center">
                <!-- Landing Page -->
                <div class="col-12 col-md-6 col-xl-3 mb-4">
                    <div class="card tutorial-card h-100 border-0 shadow-lg" style="background: white;">
                        <div class="tutorial-image-container" onclick="openImageModal('img/landing.png', 'Landing Page', 'Welcome to iSumbong - Your starting point for cybersecurity incident reporting')">
                            <img src="img/landing.png" alt="Landing Page" class="img-fluid tutorial-image">
                            <div class="tutorial-overlay">
                                <div class="tutorial-step-number bg-primary text-white">1</div>
                                <div class="tutorial-zoom-icon">
                                    <i class="fas fa-search-plus"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-center p-3">
                            <h5 class="card-title text-primary font-weight-bold">Landing Page</h5>
                            <p class="card-text small">Start here to access the iSumbong incident reporting system</p>
                        </div>
                    </div>
                </div>
                
                <!-- Register Page -->
                <div class="col-12 col-md-6 col-xl-3 mb-4">
                    <div class="card tutorial-card h-100 border-0 shadow-lg" style="background: white;">
                        <div class="tutorial-image-container" onclick="openImageModal('img/register.png', 'Register Account', 'Create your secure account by providing personal information and verifying your identity')">
                            <img src="img/register.png" alt="Register Account" class="img-fluid tutorial-image">
                            <div class="tutorial-overlay">
                                <div class="tutorial-step-number bg-success text-white">2</div>
                                <div class="tutorial-zoom-icon">
                                    <i class="fas fa-search-plus"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-center p-3">
                            <h5 class="card-title text-success font-weight-bold">Register Account</h5>
                            <p class="card-text small">Create your secure account with personal information and ID verification</p>
                        </div>
                    </div>
                </div>
                
                <!-- Login Page -->
                <div class="col-12 col-md-6 col-xl-3 mb-4">
                    <div class="card tutorial-card h-100 border-0 shadow-lg" style="background: white;">
                        <div class="tutorial-image-container" onclick="openImageModal('img/login.png', 'Login & Access', 'Sign in to your account to access the incident reporting dashboard')">
                            <img src="img/login.png" alt="Login Page" class="img-fluid tutorial-image">
                            <div class="tutorial-overlay">
                                <div class="tutorial-step-number bg-warning text-white">3</div>
                                <div class="tutorial-zoom-icon">
                                    <i class="fas fa-search-plus"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-center p-3">
                            <h5 class="card-title text-warning font-weight-bold">Login & Access</h5>
                            <p class="card-text small">Sign in to access your dashboard and view submitted reports</p>
                        </div>
                    </div>
                </div>
                
                <!-- Report Page -->
                <div class="col-12 col-md-6 col-xl-3 mb-4">
                    <div class="card tutorial-card h-100 border-0 shadow-lg" style="background: white;">
                        <div class="tutorial-image-container" onclick="openImageModal('img/report.png', 'Report Incident', 'Fill out the comprehensive incident report form with detailed information')">
                            <img src="img/report.png" alt="Report Incident" class="img-fluid tutorial-image">
                            <div class="tutorial-overlay">
                                <div class="tutorial-step-number bg-info text-white">4</div>
                                <div class="tutorial-zoom-icon">
                                    <i class="fas fa-search-plus"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-center p-3">
                            <h5 class="card-title text-info font-weight-bold">Report Incident</h5>
                            <p class="card-text small">Complete the detailed incident report form with evidence and information</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tutorial Instructions -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="alert alert-info text-center border-0" style="background: rgba(255,255,255,0.9); backdrop-filter: blur(10px);">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Click on any image above to view it in full size and see detailed instructions</strong>
                    </div>
                </div>
            </div>
            
            <!-- Detailed Instructions -->
            <div class="row mt-4 mt-md-5">
                <div class="col-12">
                    <div class="card border-0" style="background: rgba(255,255,255,0.9); backdrop-filter: blur(10px);">
                        <div class="card-body p-3 p-md-5">
                            <h4 class="text-center mb-4" style="color: #2c3e50;">
                                <i class="fas fa-info-circle mr-2"></i>Detailed Instructions
                            </h4>
                            
                            <div class="row">
                                <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                                    <h5 style="color: #2c3e50;"><i class="fas fa-clipboard-list mr-2 text-primary"></i>What to Include in Your Report</h5>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-check text-success mr-2"></i>Detailed description of the incident</li>
                                        <li><i class="fas fa-check text-success mr-2"></i>Date and time when it occurred</li>
                                        <li><i class="fas fa-check text-success mr-2"></i>Type of cybersecurity threat (phishing, malware, etc.)</li>
                                        <li><i class="fas fa-check text-success mr-2"></i>Any evidence (screenshots, emails, logs)</li>
                                        <li><i class="fas fa-check text-success mr-2"></i>Impact assessment of the incident</li>
                                    </ul>
                                </div>
                                
                                <div class="col-12 col-lg-6">
                                    <h5 style="color: #2c3e50;"><i class="fas fa-shield-alt mr-2 text-success"></i>Security & Privacy</h5>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-lock text-primary mr-2"></i>All reports are encrypted and secure</li>
                                        <li><i class="fas fa-lock text-primary mr-2"></i>Your identity is protected</li>
                                        <li><i class="fas fa-lock text-primary mr-2"></i>Only authorized PNP-ACG personnel can access reports</li>
                                        <li><i class="fas fa-lock text-primary mr-2"></i>Email notifications keep you updated</li>
                                        <li><i class="fas fa-lock text-primary mr-2"></i>24/7 monitoring and response</li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="text-center mt-4">
                                <div class="alert alert-info border-0" style="background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);">
                                    <i class="fas fa-lightbulb mr-2"></i>
                                    <strong>Tip:</strong> The more detailed your report, the better we can assist you and prevent similar incidents.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Report Form Preview Section -->
    <section class="py-4 py-md-5" style="background: #f8f9fc;">
        <div class="container">
            <div class="row text-center mb-4 mb-md-5">
                <div class="col-12">
                    <h2 class="font-weight-bold" style="color: #2c3e50;">Report Form Preview</h2>
                    <p class="text-muted">See what information you'll need to provide when reporting an incident</p>
                    <div class="alert alert-warning d-inline-block">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Note:</strong> You must <a href="register.php" class="alert-link">register an account</a> to submit incident reports
                    </div>
                </div>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-12 col-xl-10">
                    <div class="card border-0 shadow-lg">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0"><i class="fas fa-file-alt mr-2"></i>Cybersecurity Incident Report Form</h4>
                        </div>
                        
                        <div class="card-body p-3 p-md-4">
                            <form>
                                <div class="row">
                                    <!-- Basic Information -->
                                    <div class="col-12 mb-3 mb-md-4">
                                        <h5 class="text-primary border-bottom pb-2">
                                            <i class="fas fa-info-circle mr-2"></i>Basic Information
                                        </h5>
                                    </div>
                                    
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label font-weight-bold">Incident Title *</label>
                                        <input type="text" class="form-control" placeholder="Brief title describing the incident" disabled>
                                    </div>
                                    
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label font-weight-bold">Category *</label>
                                        <select class="form-control" disabled>
                                            <option>Phishing Attack</option>
                                            <option>Malware/Virus</option>
                                            <option>Data Breach</option>
                                            <option>Identity Theft</option>
                                            <option>Financial Fraud</option>
                                            <option>Social Engineering</option>
                                            <option>Other</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label font-weight-bold">Date of Incident *</label>
                                        <input type="date" class="form-control" disabled>
                                    </div>
                                    
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label font-weight-bold">Severity Level *</label>
                                        <select class="form-control" disabled>
                                            <option>Low - Minor inconvenience</option>
                                            <option>Medium - Moderate impact</option>
                                            <option>High - Significant damage</option>
                                            <option>Critical - Severe consequences</option>
                                        </select>
                                    </div>
                                    
                                    <!-- Reporter Information -->
                                    <div class="col-12 mb-3 mb-md-4 mt-2 mt-md-3">
                                        <h5 class="text-primary border-bottom pb-2">
                                            <i class="fas fa-user mr-2"></i>Reporter Information
                                        </h5>
                                    </div>
                                    
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label font-weight-bold">Full Name *</label>
                                        <input type="text" class="form-control" placeholder="Your complete name" disabled>
                                    </div>
                                    
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label font-weight-bold">Email Address *</label>
                                        <input type="email" class="form-control" placeholder="your.email@example.com" disabled>
                                    </div>
                                    
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label font-weight-bold">Phone Number</label>
                                        <input type="tel" class="form-control" placeholder="+63 9XX XXX XXXX" disabled>
                                    </div>
                                    
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label font-weight-bold">Organization/Company</label>
                                        <input type="text" class="form-control" placeholder="Your workplace or organization" disabled>
                                    </div>
                                    
                                    <!-- Incident Details -->
                                    <div class="col-12 mb-3 mb-md-4 mt-2 mt-md-3">
                                        <h5 class="text-primary border-bottom pb-2">
                                            <i class="fas fa-clipboard-list mr-2"></i>Incident Details
                                        </h5>
                                    </div>
                                    
                                    <div class="col-12 mb-3">
                                        <label class="form-label font-weight-bold">Detailed Description *</label>
                                        <textarea class="form-control" rows="4" placeholder="Provide a comprehensive description of what happened, when it occurred, and any relevant details..." disabled></textarea>
                                    </div>
                                    
                                    <!-- Evidence Collection -->
                                    <div class="col-12 mb-3 mb-md-4 mt-2 mt-md-3">
                                        <h5 class="text-primary border-bottom pb-2">
                                            <i class="fas fa-file-alt mr-2"></i>Evidence Collection
                                        </h5>
                                    </div>
                                    
                                    <div class="col-12 mb-3">
                                        <label class="form-label font-weight-bold">Available Evidence (check all that apply)</label>
                                        <div class="row">
                                            <div class="col-6 col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" disabled>
                                                    <label class="form-check-label">Screenshots</label>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" disabled>
                                                    <label class="form-check-label">Email Evidence</label>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" disabled>
                                                    <label class="form-check-label">System Logs</label>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" disabled>
                                                    <label class="form-check-label">Other Files</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 mb-3">
                                        <label class="form-label font-weight-bold">File Attachments</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" multiple disabled>
                                            <label class="custom-file-label">Upload supporting documents, screenshots, or evidence files</label>
                                        </div>
                                        <small class="text-muted">Supported formats: PDF, DOC, JPG, PNG, ZIP (Max 10MB per file)</small>
                                    </div>
                                    
                                    <!-- Additional Information -->
                                    <div class="col-12 mb-3 mb-md-4 mt-2 mt-md-3">
                                        <h5 class="text-primary border-bottom pb-2">
                                            <i class="fas fa-plus-circle mr-2"></i>Additional Information
                                        </h5>
                                    </div>
                                    
                                    <div class="col-12 mb-3">
                                        <label class="form-label font-weight-bold">Actions Taken</label>
                                        <textarea class="form-control" rows="3" placeholder="Describe any actions you've already taken in response to this incident..." disabled></textarea>
                                    </div>
                                    
                                    <div class="col-12 mb-3 mb-md-4">
                                        <label class="form-label font-weight-bold">Additional Comments</label>
                                        <textarea class="form-control" rows="3" placeholder="Any other relevant information or special circumstances..." disabled></textarea>
                                    </div>
                                    
                                    <!-- Submit Section -->
                                    <div class="col-12 text-center">
                                        <div class="alert alert-info">
                                            <i class="fas fa-lock mr-2"></i>
                                            <strong>To submit this report, you need to:</strong>
                                            <ol class="mt-2 mb-0 text-left d-inline-block">
                                                <li>Create an account by clicking "Register" above</li>
                                                <li>Verify your identity with a valid ID</li>
                                                <li>Log in to access the reporting dashboard</li>
                                            </ol>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-3">
                                                <a href="register.php" class="btn btn-primary btn-lg mb-2 mb-md-0 mr-md-3">
                                                    <i class="fas fa-user-plus mr-2"></i>Register Now
                                                </a>
                                                <a href="login.php" class="btn btn-outline-primary btn-lg">
                                                    <i class="fas fa-sign-in-alt mr-2"></i>Already Have Account?
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Preparation Tips -->
            <div class="row mt-4 mt-md-5">
                <div class="col-12">
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-lightbulb mr-2"></i>Preparation Tips</h5>
                        </div>
                        <div class="card-body p-3 p-md-4">
                            <div class="row">
                                <div class="col-12 col-md-4 mb-3 mb-md-0">
                                    <h6 class="text-primary"><i class="fas fa-camera mr-2"></i>Gather Evidence</h6>
                                    <ul class="list-unstyled small">
                                        <li>• Take screenshots of suspicious emails or websites</li>
                                        <li>• Save any error messages or suspicious files</li>
                                        <li>• Document the timeline of events</li>
                                    </ul>
                                </div>
                                <div class="col-12 col-md-4 mb-3 mb-md-0">
                                    <h6 class="text-success"><i class="fas fa-shield-alt mr-2"></i>Secure Your System</h6>
                                    <ul class="list-unstyled small">
                                        <li>• Disconnect from the internet if compromised</li>
                                        <li>• Run antivirus scans</li>
                                        <li>• Change passwords on affected accounts</li>
                                    </ul>
                                </div>
                                <div class="col-12 col-md-4">
                                    <h6 class="text-warning"><i class="fas fa-clock mr-2"></i>Act Quickly</h6>
                                    <ul class="list-unstyled small">
                                        <li>• Report incidents as soon as possible</li>
                                        <li>• Preserve evidence before it's lost</li>
                                        <li>• Contact your bank if financial data is involved</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-4 py-md-5 about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-6 mb-4 mb-lg-0 text-center text-lg-left">
                    <h2 class="font-weight-bold mb-4">About iSumbong</h2>
                    <p class="lead">iSumbong is a comprehensive cybersecurity incident reporting platform.</p>
                    <p>Our platform enables citizens to report cybersecurity incidents quickly and securely, while providing educational resources to help protect against cyber threats.</p>
                </div>
                <div class="col-12 col-lg-6 text-center">
                    <div class="partnership-logos">
                        <div class="logo-container">
                            <div class="logo-box">
                                <img src="img/pnp.png" alt="PNP Logo" class="img-fluid">
                            </div>
                            <div class="logo-label">
                                Philippine<br>National Police
                            </div>
                        </div>
                        
                        <div class="logo-container">
                            <div class="logo-box">
                                <img src="img/logo1.png" alt="iREPORT Logo" class="img-fluid">
                            </div>
                            <div class="logo-label">
                                Secure Reporting<br>Platform
                            </div>
                        </div>
                        
                        <div class="logo-container">
                            <div class="logo-box">
                                <img src="img/pnp-acg-logo-new.png" alt="PNP ACG Logo" class="img-fluid">
                            </div>
                            <div class="logo-label">
                                Philippine National Police<br>Anti-Cybercrime Group
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Tutorial Step</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Tutorial Image" class="tutorial-modal-image">
                    <div class="mt-3">
                        <p id="modalDescription" class="lead"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p>&copy; 2025 iSumbong. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Tutorial Gallery JavaScript -->
    <script>
        // Function to open image modal
        function openImageModal(imageSrc, imageTitle, imageDescription) {
            $('#modalImage').attr('src', imageSrc);
            $('#imageModalLabel').text(imageTitle);
            $('#modalDescription').text(imageDescription);
            $('#imageModal').modal('show');
        }
        
        $(document).ready(function() {
            // Add cursor pointer to tutorial cards
            $('.tutorial-image-container').css('cursor', 'pointer');
            
            // Add hover effect for tutorial cards
            $('.tutorial-card').on('mouseenter', function() {
                $(this).find('.tutorial-overlay').css('opacity', '1');
            }).on('mouseleave', function() {
                $(this).find('.tutorial-overlay').css('opacity', '0');
            });
            
            // Smooth scrolling for any anchor links
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if (target.length) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top
                    }, 1000);
                }
            });
            
            // Add loading animation for images
            $('.tutorial-image').on('load', function() {
                $(this).closest('.tutorial-card').addClass('loaded');
            });
            
            // Ensure modal is properly initialized
            $('#imageModal').on('shown.bs.modal', function() {
                $(this).find('.modal-dialog').addClass('modal-dialog-centered');
            });
        });
    </script>

</body>
</html>
