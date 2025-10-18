<?php
include('connectMySql.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>iREPORT - Incident Reporting System</title>
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
            gap: 3rem;
            margin: 2rem 0;
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
        
        @media (max-width: 768px) {
            .partnership-logos {
                flex-direction: column;
                gap: 2rem;
            }
        }
    </style>
</head>

<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="hero-content">
                        <div class="hero-logo">
                            <img src="img/logo1.png" alt="iReport Logo" style="width: 80px; height: 80px;">
                            <span class="brand-text">iSUMBONG</span>
                        </div>
                        <h1 class="display-3 font-weight-bold mb-4">Welcome to iSUMBONG</h1>
                        <p class="lead mb-5">Your trusted portal for Cybersecurity Incident Reporting and Awareness</p>
                        
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
    <section class="py-5 features-section">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-12">
                    <h2 class="font-weight-bold">Key Features</h2>
                    <p class="text-muted">Comprehensive cybersecurity incident reporting and management</p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-exclamation-triangle fa-3x text-danger"></i>
                            </div>
                            <h5 class="card-title">Report Incidents</h5>
                            <p class="card-text">Quickly and securely report cybersecurity incidents to the authorities.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-shield-alt fa-3x text-primary"></i>
                            </div>
                            <h5 class="card-title">Track Progress</h5>
                            <p class="card-text">Monitor the status and progress of your reported incidents.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
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
    <section class="py-5" style="background: linear-gradient(135deg, #f8f9fc 0%, #e3f2fd 100%);">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-12">
                    <h2 class="font-weight-bold" style="color: #2c3e50;">How to Use iSUMBONG</h2>
                    <p class="text-muted">Follow these simple steps to report cybersecurity incidents</p>
                </div>
            </div>
            
            <div class="row">
                <!-- Step 1 -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card feature-card h-100 border-0" style="background: white;">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <div class="step-number bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px; font-size: 1.5rem; font-weight: bold;">1</div>
                            </div>
                            <h5 class="card-title text-primary">Register Account</h5>
                            <p class="card-text">Create your secure account by providing your personal information and verifying your identity with a valid ID.</p>
                            <div class="mt-3">
                                <i class="fas fa-user-plus fa-2x text-primary opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Step 2 -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card feature-card h-100 border-0" style="background: white;">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <div class="step-number bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px; font-size: 1.5rem; font-weight: bold;">2</div>
                            </div>
                            <h5 class="card-title text-success">Login & Access</h5>
                            <p class="card-text">Sign in to your account to access the incident reporting dashboard and view your submitted reports.</p>
                            <div class="mt-3">
                                <i class="fas fa-sign-in-alt fa-2x text-success opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Step 3 -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card feature-card h-100 border-0" style="background: white;">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <div class="step-number bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px; font-size: 1.5rem; font-weight: bold;">3</div>
                            </div>
                            <h5 class="card-title text-warning">Report Incident</h5>
                            <p class="card-text">Fill out the incident report form with detailed information about the cybersecurity threat or incident you experienced.</p>
                            <div class="mt-3">
                                <i class="fas fa-file-alt fa-2x text-warning opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Step 4 -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card feature-card h-100 border-0" style="background: white;">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <div class="step-number bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px; font-size: 1.5rem; font-weight: bold;">4</div>
                            </div>
                            <h5 class="card-title text-info">Track Progress</h5>
                            <p class="card-text">Monitor your report status and receive updates from the PNP-ACG team as they investigate your case.</p>
                            <div class="mt-3">
                                <i class="fas fa-chart-line fa-2x text-info opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Detailed Instructions -->
            <div class="row mt-5">
                <div class="col-lg-12">
                    <div class="card border-0" style="background: rgba(255,255,255,0.9); backdrop-filter: blur(10px);">
                        <div class="card-body p-5">
                            <h4 class="text-center mb-4" style="color: #2c3e50;">
                                <i class="fas fa-info-circle mr-2"></i>Detailed Instructions
                            </h4>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <h5 style="color: #2c3e50;"><i class="fas fa-clipboard-list mr-2 text-primary"></i>What to Include in Your Report</h5>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-check text-success mr-2"></i>Detailed description of the incident</li>
                                        <li><i class="fas fa-check text-success mr-2"></i>Date and time when it occurred</li>
                                        <li><i class="fas fa-check text-success mr-2"></i>Type of cybersecurity threat (phishing, malware, etc.)</li>
                                        <li><i class="fas fa-check text-success mr-2"></i>Any evidence (screenshots, emails, logs)</li>
                                        <li><i class="fas fa-check text-success mr-2"></i>Impact assessment of the incident</li>
                                    </ul>
                                </div>
                                
                                <div class="col-lg-6">
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
    <section class="py-5" style="background: #f8f9fc;">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-12">
                    <h2 class="font-weight-bold" style="color: #2c3e50;">Report Form Preview</h2>
                    <p class="text-muted">See what information you'll need to provide when reporting an incident</p>
                    <div class="alert alert-warning d-inline-block">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Note:</strong> You must <a href="register.php" class="alert-link">register an account</a> to submit incident reports
                    </div>
                </div>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card border-0 shadow-lg">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0"><i class="fas fa-file-alt mr-2"></i>Cybersecurity Incident Report Form</h4>
                        </div>
                        
                        <div class="card-body p-4">
                            <form>
                                <div class="row">
                                    <!-- Basic Information -->
                                    <div class="col-lg-12 mb-4">
                                        <h5 class="text-primary border-bottom pb-2">
                                            <i class="fas fa-info-circle mr-2"></i>Basic Information
                                        </h5>
                                    </div>
                                    
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label font-weight-bold">Incident Title *</label>
                                        <input type="text" class="form-control" placeholder="Brief title describing the incident" disabled>
                                    </div>
                                    
                                    <div class="col-lg-6 mb-3">
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
                                    
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label font-weight-bold">Date of Incident *</label>
                                        <input type="date" class="form-control" disabled>
                                    </div>
                                    
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label font-weight-bold">Severity Level *</label>
                                        <select class="form-control" disabled>
                                            <option>Low - Minor inconvenience</option>
                                            <option>Medium - Moderate impact</option>
                                            <option>High - Significant damage</option>
                                            <option>Critical - Severe consequences</option>
                                        </select>
                                    </div>
                                    
                                    <!-- Reporter Information -->
                                    <div class="col-lg-12 mb-4 mt-3">
                                        <h5 class="text-primary border-bottom pb-2">
                                            <i class="fas fa-user mr-2"></i>Reporter Information
                                        </h5>
                                    </div>
                                    
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label font-weight-bold">Full Name *</label>
                                        <input type="text" class="form-control" placeholder="Your complete name" disabled>
                                    </div>
                                    
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label font-weight-bold">Email Address *</label>
                                        <input type="email" class="form-control" placeholder="your.email@example.com" disabled>
                                    </div>
                                    
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label font-weight-bold">Phone Number</label>
                                        <input type="tel" class="form-control" placeholder="+63 9XX XXX XXXX" disabled>
                                    </div>
                                    
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label font-weight-bold">Organization/Company</label>
                                        <input type="text" class="form-control" placeholder="Your workplace or organization" disabled>
                                    </div>
                                    
                                    <!-- Incident Details -->
                                    <div class="col-lg-12 mb-4 mt-3">
                                        <h5 class="text-primary border-bottom pb-2">
                                            <i class="fas fa-clipboard-list mr-2"></i>Incident Details
                                        </h5>
                                    </div>
                                    
                                    <div class="col-lg-12 mb-3">
                                        <label class="form-label font-weight-bold">Detailed Description *</label>
                                        <textarea class="form-control" rows="4" placeholder="Provide a comprehensive description of what happened, when it occurred, and any relevant details..." disabled></textarea>
                                    </div>
                                    
                                    <!-- Evidence Collection -->
                                    <div class="col-lg-12 mb-4 mt-3">
                                        <h5 class="text-primary border-bottom pb-2">
                                            <i class="fas fa-file-alt mr-2"></i>Evidence Collection
                                        </h5>
                                    </div>
                                    
                                    <div class="col-lg-12 mb-3">
                                        <label class="form-label font-weight-bold">Available Evidence (check all that apply)</label>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" disabled>
                                                    <label class="form-check-label">Screenshots</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" disabled>
                                                    <label class="form-check-label">Email Evidence</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" disabled>
                                                    <label class="form-check-label">System Logs</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" disabled>
                                                    <label class="form-check-label">Other Files</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-12 mb-3">
                                        <label class="form-label font-weight-bold">File Attachments</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" multiple disabled>
                                            <label class="custom-file-label">Upload supporting documents, screenshots, or evidence files</label>
                                        </div>
                                        <small class="text-muted">Supported formats: PDF, DOC, JPG, PNG, ZIP (Max 10MB per file)</small>
                                    </div>
                                    
                                    <!-- Additional Information -->
                                    <div class="col-lg-12 mb-4 mt-3">
                                        <h5 class="text-primary border-bottom pb-2">
                                            <i class="fas fa-plus-circle mr-2"></i>Additional Information
                                        </h5>
                                    </div>
                                    
                                    <div class="col-lg-12 mb-3">
                                        <label class="form-label font-weight-bold">Actions Taken</label>
                                        <textarea class="form-control" rows="3" placeholder="Describe any actions you've already taken in response to this incident..." disabled></textarea>
                                    </div>
                                    
                                    <div class="col-lg-12 mb-4">
                                        <label class="form-label font-weight-bold">Additional Comments</label>
                                        <textarea class="form-control" rows="3" placeholder="Any other relevant information or special circumstances..." disabled></textarea>
                                    </div>
                                    
                                    <!-- Submit Section -->
                                    <div class="col-lg-12 text-center">
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
                                            <a href="register.php" class="btn btn-primary btn-lg mr-3">
                                                <i class="fas fa-user-plus mr-2"></i>Register Now
                                            </a>
                                            <a href="login.php" class="btn btn-outline-primary btn-lg">
                                                <i class="fas fa-sign-in-alt mr-2"></i>Already Have Account?
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Preparation Tips -->
            <div class="row mt-5">
                <div class="col-lg-12">
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-lightbulb mr-2"></i>Preparation Tips</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <h6 class="text-primary"><i class="fas fa-camera mr-2"></i>Gather Evidence</h6>
                                    <ul class="list-unstyled small">
                                        <li>• Take screenshots of suspicious emails or websites</li>
                                        <li>• Save any error messages or suspicious files</li>
                                        <li>• Document the timeline of events</li>
                                    </ul>
                                </div>
                                <div class="col-lg-4">
                                    <h6 class="text-success"><i class="fas fa-shield-alt mr-2"></i>Secure Your System</h6>
                                    <ul class="list-unstyled small">
                                        <li>• Disconnect from the internet if compromised</li>
                                        <li>• Run antivirus scans</li>
                                        <li>• Change passwords on affected accounts</li>
                                    </ul>
                                </div>
                                <div class="col-lg-4">
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
    <section class="py-5 about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="font-weight-bold mb-4">About iSUMBONG</h2>
                    <p class="lead">iSUMBONG is a comprehensive cybersecurity incident reporting platform developed in partnership with the Philippine National Police Anti-Cybercrime Group (PNP-ACG).</p>
                    <p>Our platform enables citizens to report cybersecurity incidents quickly and securely, while providing educational resources to help protect against cyber threats.</p>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="partnership-logos">
                        <div class="logo-container">
                            <div class="logo-box">
                                <img src="img/logo1.png" alt="iREPORT Logo">
                            </div>
                            <div class="logo-label">
                                Secure Reporting<br>Platform
                            </div>
                        </div>
                        
                        <div class="logo-container">
                            <div class="logo-box">
                                <img src="img/pnp-acg-logo-new.png" alt="PNP ACG Logo">
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

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p>&copy; 2025 iSUMBONG. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

</body>
</html>
