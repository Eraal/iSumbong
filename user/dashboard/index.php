<?php
include '../../includes/user_auth.php';
include '../../includes/theme_system.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>iSumbong </title>
    <link rel="icon" type="image/x-icon" href="../../img/logo1.png" />

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Fallback CDN for Font Awesome in case local fonts fail to load -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <script src="../../js/html2canvas.min.js"></script>
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../js/sweetalert2.all.js"></script>
    <script src="../../js/sweetalert2.css"></script>
    <script src="../../js/sweetalert2.js"></script>
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
            <section class="hero-section" style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); min-height: 80vh; display: flex; align-items: center; position: relative; overflow: hidden;">
                <!-- Background Pattern -->
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: radial-gradient(circle at 25% 25%, rgba(255,255,255,0.05) 1px, transparent 1px); background-size: 50px 50px; opacity: 0.3;"></div>
                
                <!-- Hero Image Background -->
                <div style="position: absolute; top: 0; right: 0; width: 50%; height: 100%; background-image: url('../../img/494834102_1016804407314972_5448036501277750785_n.jpg'); background-size: cover; background-position: center; opacity: 0.1; z-index: 1;"></div>
                
                <div class="container" style="position: relative; z-index: 2;">
                    <div class="row align-items-center">
                        <!-- Left Content -->
                        <div class="col-lg-7 col-md-12 text-white mb-4 mb-lg-0">
                            <h1 class="display-3 font-weight-bold mb-4" style="font-size: 4rem; line-height: 1.1;">
                                Welcome to <span style="color: #3498db;">iSumbong</span>
                            </h1>
                            <p class="lead mb-5" style="font-size: 1.5rem; opacity: 0.9; max-width: 600px;">
                                Your trusted portal for Cybersecurity Awareness & Reporting.
                            </p>
                            
                            <!-- Action Buttons -->
                            <div class="hero-buttons mb-5">
                                <a href="../incident/register.php" class="btn btn-danger btn-lg mr-3 mb-3 px-4 py-3" style="border-radius: 50px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>Report an Incident
                                </a>
                                <a href="../threats/" class="btn btn-outline-light btn-lg px-4 py-3 mb-3" style="border-radius: 50px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; border-width: 2px;">
                                    <i class="fas fa-shield-alt mr-2"></i>Learn About Threats
                                </a>
                            </div>
                        </div>
                        
                        <!-- Right Content - Images -->
                        <div class="col-lg-5 col-md-12">
                            <div class="row justify-content-center">
                                <!-- PNP Logo -->
                                <div class="col-4 text-center mb-4">
                                    <div class="logo-container" style="position: relative;">
                                        <div class="pnp-main-logo-wrapper" style="width: 140px; height: 140px; margin: 0 auto; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.1); border-radius: 50%; backdrop-filter: blur(10px);">
                                            <img src="../../img/pnp.png" alt="Philippine National Police" style="width: 110px; height: 110px; object-fit: contain;">
                                        </div>
                                        <div class="mt-2">
                                            <p class="text-white font-weight-bold opacity-75 small" style="font-size: 0.7rem;">Philippine National<br>Police</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- System Logo (Middle) -->
                                <div class="col-4 text-center mb-4">
                                    <div class="hero-image-container" style="position: relative;">
                                        <div class="hero-image-wrapper" style="width: 140px; height: 140px; margin: 0 auto; border-radius: 15px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.3); border: 4px solid rgba(255,255,255,0.2);">
                                            <img src="../../img/494834102_1016804407314972_5448036501277750785_n.jpg" alt="Cybersecurity" style="width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                        <div class="mt-2">
                                            <p class="text-white font-weight-bold opacity-75 small" style="font-size: 0.7rem;">Secure Reporting<br>Platform</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- PNP ACG Logo -->
                                <div class="col-4 text-center mb-4">
                                    <div class="logo-container" style="position: relative;">
                                        <div class="pnp-logo-wrapper" style="width: 140px; height: 140px; margin: 0 auto; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.1); border-radius: 50%; backdrop-filter: blur(10px);">
                                            <img src="../../img/pnp-acg-logo-new.png" alt="PNP Anti-Cybercrime Group" style="width: 110px; height: 110px; object-fit: contain;">
                                        </div>
                                        <div class="mt-2">
                                            <p class="text-white font-weight-bold opacity-75 small" style="font-size: 0.7rem;">PNP Anti-Cybercrime<br>Group</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- About Section with Phone Prototype -->
            <section class="about-section py-5" style="background: white;">
                <div class="container">
                    <div class="row align-items-center">
                        <!-- About Content -->
                        <div class="col-lg-5">
                            <div class="about-content">
                                <h2 class="font-weight-bold text-dark mb-4">
                                    <i class="fas fa-shield-alt text-primary mr-3"></i>About iSumbong
                                </h2>
                                <p class="lead text-dark mb-4" style="font-size: 1.1rem;">
                                    iSumbong is a comprehensive cybersecurity incident reporting platform developed in partnership with the Philippine National Police Anti-Cybercrime Group (PNP-ACG).
                                </p>
                                <div class="feature-list">
                                    <div class="feature-item d-flex align-items-center mb-2">
                                        <div class="feature-icon bg-primary text-white mr-3" style="width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-exclamation-triangle" style="font-size: 12px;"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 text-dark font-weight-bold" style="font-size: 14px;">Incident Reporting</h6>
                                            <small class="text-dark" style="font-size: 12px;">Report cybersecurity incidents quickly and securely</small>
                                        </div>
                                    </div>
                                    <div class="feature-item d-flex align-items-center mb-2">
                                        <div class="feature-icon bg-success text-white mr-3" style="width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-graduation-cap" style="font-size: 12px;"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 text-dark font-weight-bold" style="font-size: 14px;">Cybersecurity Education</h6>
                                            <small class="text-dark" style="font-size: 12px;">Learn about latest threats and protection methods</small>
                                        </div>
                                    </div>
                                    <div class="feature-item d-flex align-items-center mb-2">
                                        <div class="feature-icon bg-info text-white mr-3" style="width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-newspaper" style="font-size: 12px;"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 text-dark font-weight-bold" style="font-size: 14px;">Latest News & Alerts</h6>
                                            <small class="text-dark" style="font-size: 12px;">Stay updated with cybercrime news and warnings</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Phone Prototype -->
                        <div class="col-lg-7">
                            <div class="phone-prototype-container" style="position: relative; overflow: hidden; padding: 40px;">
                                <!-- Circular Background -->
                                <div class="circle-bg" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 400px; height: 400px; background: linear-gradient(135deg, #74b9ff 0%, #0984e3 50%, #fd79a8 100%); border-radius: 50%; z-index: 1; opacity: 0.8;"></div>
                                
                                <div class="text-center mb-3" style="position: relative; z-index: 2;">
                                    <h4 class="font-weight-bold text-dark">Easy Mobile Reporting</h4>
                                    <p class="text-dark small">Report incidents anytime, anywhere</p>
                                </div>
                                
                                <!-- Phone Frame -->
                                <div class="phone-frame" style="width: 240px; height: 480px; margin: 0 auto; position: relative; background: #2c3e50; border-radius: 30px; padding: 15px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); z-index: 3;">
                                    <!-- Phone Screen -->
                                    <div class="phone-screen" style="width: 100%; height: 100%; background: #ffffff; border-radius: 20px; padding: 15px; overflow: hidden; position: relative;">
                                        <!-- Phone Header -->
                                        <div class="phone-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; padding-bottom: 8px; border-bottom: 1px solid #eee;">
                                            <div style="font-size: 10px; color: #666;">9:41 AM</div>
                                            <div style="font-size: 12px; font-weight: bold; color: #e74c3c;">
                                                <i class="fas fa-shield-alt" style="margin-right: 4px;"></i>iSumbong
                                            </div>
                                            <div style="font-size: 10px; color: #666;">100%</div>
                                        </div>
                                        
                                        <!-- Form Title -->
                                        <div style="text-align: center; margin-bottom: 15px;">
                                            <h6 style="color: #e74c3c; font-weight: bold; margin-bottom: 3px; font-size: 13px;">Log Incident</h6>
                                            <small style="color: #666; font-size: 10px;">Report cybersecurity incident</small>
                                        </div>
                                        
                                        <!-- Form Fields -->
                                        <div class="mobile-form">
                                            <!-- Search Field -->
                                            <div style="margin-bottom: 10px;">
                                                <div style="background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px; padding: 8px; font-size: 10px; color: #666;">
                                                    <i class="fas fa-search" style="margin-right: 6px; color: #999;"></i>Search...
                                                </div>
                                            </div>
                                            
                                            <!-- Category Selection -->
                                            <div style="margin-bottom: 10px;">
                                                <div style="display: flex; justify-content: space-between; align-items: center; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px; padding: 8px;">
                                                    <span style="font-size: 9px; color: #333;">Cybersecurity/Planning - Phishing</span>
                                                    <i class="fas fa-edit" style="font-size: 8px; color: #666;"></i>
                                                </div>
                                            </div>
                                            
                                            <!-- Procedure Field -->
                                            <div style="margin-bottom: 10px;">
                                                <div style="display: flex; justify-content: space-between; align-items: center; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px; padding: 8px;">
                                                    <span style="font-size: 9px; color: #333;">Procedure - Suspicious/Quote</span>
                                                    <i class="fas fa-edit" style="font-size: 8px; color: #666;"></i>
                                                </div>
                                            </div>
                                            
                                            <!-- Extra Fields -->
                                            <div style="margin-bottom: 10px;">
                                                <div style="background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px; padding: 8px; font-size: 9px; color: #666;">
                                                    Extra Fields - Incident
                                                </div>
                                            </div>
                                            
                                            <!-- Traffic Fields -->
                                            <div style="margin-bottom: 10px;">
                                                <div style="display: flex; justify-content: space-between; align-items: center; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px; padding: 8px;">
                                                    <span style="font-size: 9px; color: #333;">Traffic - Incident/From incident</span>
                                                    <i class="fas fa-edit" style="font-size: 8px; color: #666;"></i>
                                                </div>
                                            </div>
                                            
                                            <!-- Description Field -->
                                            <div style="margin-bottom: 15px;">
                                                <div style="background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px; padding: 8px; min-height: 40px;">
                                                    <span style="font-size: 8px; color: #999;">
                                                        This report will be encrypted and will<br>
                                                        send email, received SMS inside the folder<br>
                                                        repository where recorded...
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <!-- Submit Button -->
                                            <div style="text-align: center;">
                                                <button style="background: #e74c3c; color: white; border: none; border-radius: 20px; padding: 10px 25px; font-size: 10px; font-weight: bold; box-shadow: 0 3px 10px rgba(231, 76, 60, 0.3);">
                                                    Log Incident
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Phone Home Button -->
                                    <div style="position: absolute; bottom: 6px; left: 50%; transform: translateX(-50%); width: 40px; height: 3px; background: rgba(255,255,255,0.3); border-radius: 2px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Stats Section -->
            <section class="stats-section py-5" style="background: #f8f9fa;">
                <div class="container">
                    <div class="row text-center mb-5">
                        <div class="col-12">
                            <h2 class="font-weight-bold text-dark mb-3">Your Incident Dashboard</h2>
                            <p class="text-dark">Track and manage your cybersecurity incidents</p>
                        </div>
                    </div>
                    
                    <!-- Stats Cards -->
                    <div class="row">
                        <!-- Total Incidents -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card shadow-sm h-100" style="border-radius: 1rem; background: #fff; border: none; transition: transform 0.3s ease;">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="icon-circle bg-info text-white mr-3" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-list-alt fa-lg"></i>
                                        </div>
                                        <h6 class="text-uppercase font-weight-bold mb-0 text-info">Total Incidents</h6>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="font-weight-bold text-dark mb-0">
                                            <?php
                                                $query = "SELECT count(id) as total FROM incident WHERE user_id = '".$_SESSION['user_id']."' AND (user_deleted IS NULL OR user_deleted = 0)";
                                                $result = $conn->query($query);
                                                if ($row = $result->fetch_assoc()) {
                                                    echo $row['total'];
                                                }
                                            ?>
                                        </h3>
                                        <small class="text-dark">Your reports</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Pending -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card shadow-sm h-100" style="border-radius: 1rem; background: #fff; border: none; transition: transform 0.3s ease;">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="icon-circle bg-danger text-white mr-3" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-clock fa-lg"></i>
                                        </div>
                                        <h6 class="text-uppercase font-weight-bold mb-0 text-danger">Pending</h6>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="font-weight-bold text-dark mb-0">
                                            <?php
                                                $query = "SELECT count(id) as total FROM incident WHERE status = 'PENDING' AND user_id = '".$_SESSION['user_id']."' AND (user_deleted IS NULL OR user_deleted = 0)";
                                                $result = $conn->query($query);
                                                if ($row = $result->fetch_assoc()) {
                                                    echo $row['total'];
                                                }
                                            ?>
                                        </h3>
                                        <small class="text-dark">Awaiting review</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Investigating -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card shadow-sm h-100" style="border-radius: 1rem; background: #fff; border: none; transition: transform 0.3s ease;">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="icon-circle bg-warning text-white mr-3" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-search fa-lg"></i>
                                        </div>
                                        <h6 class="text-uppercase font-weight-bold mb-0 text-warning">Investigating</h6>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="font-weight-bold text-dark mb-0">
                                            <?php
                                                $query = "SELECT count(id) as total FROM incident WHERE status = 'INVESTIGATING' AND user_id = '".$_SESSION['user_id']."' AND (user_deleted IS NULL OR user_deleted = 0)";
                                                $result = $conn->query($query);
                                                if ($row = $result->fetch_assoc()) {
                                                    echo $row['total'];
                                                }
                                            ?>
                                        </h3>
                                        <small class="text-dark">In progress</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Resolved -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card shadow-sm h-100" style="border-radius: 1rem; background: #fff; border: none; transition: transform 0.3s ease;">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="icon-circle bg-success text-white mr-3" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-check-circle fa-lg"></i>
                                        </div>
                                        <h6 class="text-uppercase font-weight-bold mb-0 text-success">Resolved</h6>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="font-weight-bold text-dark mb-0">
                                            <?php
                                                $query = "SELECT count(id) as total FROM incident WHERE status = 'RESOLVED' AND user_id = '".$_SESSION['user_id']."' AND (user_deleted IS NULL OR user_deleted = 0)";
                                                $result = $conn->query($query);
                                                if ($row = $result->fetch_assoc()) {
                                                    echo $row['total'];
                                                }
                                            ?>
                                        </h3>
                                        <small class="text-dark">Closed cases</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Recent Incidents Section -->
            <section class="recent-incidents py-5">
                <div class="container">
                    <div class="card shadow-sm mb-4" style="border-radius: 1rem; border: none;">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center bg-white" style="border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                            <h6 class="m-0 font-weight-bold text-primary">Recent Incidents</h6>
                            <a href="../incident/" class="text-primary font-weight-semibold small">View All</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle" id="dataTable" width="100%" cellspacing="0" style="border-radius: 0.75rem; overflow: hidden;">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-dark text-uppercase small">Incident Title</th>
                                            <th class="text-dark text-uppercase small">Date Reported</th>
                                            <th class="text-dark text-uppercase small">Status</th>
                                            <th class="text-dark text-uppercase small">Action</th>
                                        </tr>
                        </thead>
                        <tbody>
                          <?php
                          $query = "SELECT * FROM incident WHERE user_id ='".$_SESSION['user_id']."' AND (user_deleted IS NULL OR user_deleted = 0)";
                          $result = $conn->query($query);
                          while ($row = $result->fetch_assoc()) {
                              $color = "secondary";
                              if($row['status']=='PENDING'){
                                  $color = "danger";
                              } else if($row['status']=='INVESTIGATING'){
                                  $color = "warning";
                              } else if($row['status']=='RESOLVED'){
                                  $color = "success";
                              }

                              echo "<tr>";
                              echo "<td class='text-dark font-weight-bold'>" . htmlspecialchars(strtoupper($row['title'])) . "</td>";
                              echo "<td class='text-dark'>" . htmlspecialchars(strtoupper($row['date'])) . "</td>";
                              echo "<td><span class='badge badge-".$color." badge-pill px-3 py-2'>" . strtoupper($row['status']) . "</span></td>";
                              echo "<td>
                                      <a href='view.php?id=" . $row["id"] . "' class='btn btn-sm btn-outline-primary rounded-pill shadow-sm'>
                                        <i class='fas fa-eye'></i> View
                                      </a>
                                    </td>";
                          }
                          ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- End of Main Content -->
        
        <!-- Custom Styles for Website Look -->
        <style>
            /* Hero Section Animations */
            .hero-section {
                animation: fadeIn 1s ease-in-out;
            }
            
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(30px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            /* Card Hover Effects */
            .card {
                transition: all 0.3s ease;
            }
            
            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
            }
            
            /* Button Hover Effects */
            .hero-buttons .btn {
                transition: all 0.3s ease;
            }
            
            .hero-buttons .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            }
            
            /* PNP Logo Animation */
            .logo-container {
                animation: float 3s ease-in-out infinite;
            }
            
            .pnp-logo-wrapper, .pnp-main-logo-wrapper {
                transition: all 0.3s ease;
            }
            
            .pnp-logo-wrapper:hover, .pnp-main-logo-wrapper:hover {
                transform: scale(1.05);
                box-shadow: 0 25px 50px rgba(0,0,0,0.3);
            }
            
            /* Hero Image Animation */
            .hero-image-container {
                animation: float 3s ease-in-out infinite 0.5s;
            }
            
            .hero-image-wrapper {
                transition: all 0.3s ease;
            }
            
            .hero-image-wrapper:hover {
                transform: scale(1.05) rotate(2deg);
                box-shadow: 0 30px 60px rgba(0,0,0,0.4);
            }
            
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
            }
            
            /* Table Row Hover */
            .table-hover tbody tr:hover {
                background-color: rgba(52, 152, 219, 0.05);
            }
            
            /* Stats Section Animation */
            .stats-section {
                animation: slideUp 1s ease-in-out 0.3s both;
            }
            
            @keyframes slideUp {
                from { opacity: 0; transform: translateY(50px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            /* Icon Circle Pulse Effect */
            .icon-circle {
                transition: all 0.3s ease;
            }
            
            .card:hover .icon-circle {
                transform: scale(1.1);
            }
            
            /* Phone Prototype Animations */
            .circle-bg {
                animation: rotate 20s linear infinite;
            }
            
            @keyframes rotate {
                from { transform: translate(-50%, -50%) rotate(0deg); }
                to { transform: translate(-50%, -50%) rotate(360deg); }
            }
            
            .phone-frame {
                animation: float 3s ease-in-out infinite;
                transition: all 0.3s ease;
            }
            
            .phone-frame:hover {
                transform: scale(1.02);
                box-shadow: 0 25px 50px rgba(0,0,0,0.4);
            }
            
            .mobile-form {
                animation: fadeInUp 1.5s ease-in-out 0.5s both;
            }
            
            @keyframes fadeInUp {
                from { 
                    opacity: 0; 
                    transform: translateY(20px); 
                }
                to { 
                    opacity: 1; 
                    transform: translateY(0); 
                }
            }
            
            /* Responsive Text */
            @media (max-width: 1200px) {
                .container {
                    max-width: 100%;
                    padding-left: 20px;
                    padding-right: 20px;
                }
                
                .display-3 {
                    font-size: 3.5rem !important;
                }
                
                .stats-section .row {
                    margin-left: -10px;
                    margin-right: -10px;
                }
                
                .col-xl-3 {
                    padding-left: 10px;
                    padding-right: 10px;
                }
            }
            
            @media (max-width: 992px) {
                .hero-section {
                    min-height: 70vh !important;
                    text-align: center;
                }
                
                .display-3 {
                    font-size: 3rem !important;
                }
                
                .lead {
                    font-size: 1.3rem !important;
                }
                
                .col-lg-7, .col-lg-5 {
                    text-align: center;
                    margin-bottom: 2rem;
                }
                
                .hero-buttons .btn {
                    margin-bottom: 1rem;
                    display: inline-block;
                    width: auto;
                    margin-right: 1rem !important;
                }
                
                .phone-prototype-container {
                    padding: 20px !important;
                }
                
                .circle-bg {
                    width: 350px !important;
                    height: 350px !important;
                }
            }
            
            @media (max-width: 768px) {
                /* Mobile-first responsive design - Proper sizing, not shrinking */
                .hero-section {
                    min-height: 100vh !important;
                    padding: 2rem 0 !important;
                }
                
                .display-3 {
                    font-size: 3rem !important;
                    line-height: 1.2;
                    text-shadow: 2px 2px 4px rgba(0,0,0,0.6);
                }
                
                .lead {
                    font-size: 1.4rem !important;
                    line-height: 1.5;
                    text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
                }
                
                .hero-buttons .btn {
                    margin-bottom: 1.5rem;
                    display: block;
                    width: 100%;
                    margin-right: 0 !important;
                    font-size: 1.2rem !important;
                    padding: 1rem 1.5rem !important;
                    min-height: 56px;
                }
                
                /* Better text sizes for mobile readability */
                h1 {
                    font-size: 2.8rem !important;
                    line-height: 1.2;
                }
                
                h2 {
                    font-size: 2.2rem !important;
                    line-height: 1.3;
                    margin-bottom: 1.5rem !important;
                }
                
                h3 {
                    font-size: 1.8rem !important;
                    line-height: 1.3;
                }
                
                h4 {
                    font-size: 1.6rem !important;
                    line-height: 1.3;
                }
                
                h5 {
                    font-size: 1.4rem !important;
                    line-height: 1.3;
                }
                
                h6 {
                    font-size: 1.2rem !important;
                    line-height: 1.3;
                }
                
                p {
                    font-size: 1.2rem !important;
                    line-height: 1.6;
                }
                
                .small {
                    font-size: 1rem !important;
                }
                
                /* Card improvements */
                .card-body {
                    padding: 2rem !important;
                }
                
                .card-title {
                    font-size: 1.6rem !important;
                    margin-bottom: 1rem !important;
                }
                
                .card-text {
                    font-size: 1.2rem !important;
                    line-height: 1.6;
                }
                
                /* Stats card improvements */
                .icon-circle {
                    width: 60px !important;
                    height: 60px !important;
                }
                
                .icon-circle i {
                    font-size: 1.5rem !important;
                }
                
                /* Table improvements */
                .table {
                    font-size: 1.1rem !important;
                }
                
                .table th,
                .table td {
                    padding: 1rem 0.75rem !important;
                    vertical-align: middle;
                }
                
                .table-responsive {
                    font-size: 1.1rem;
                }
                
                .btn-sm {
                    font-size: 1rem !important;
                    padding: 0.6rem 1rem !important;
                    min-height: 44px;
                }
                
                /* Badge improvements */
                .badge {
                    font-size: 1rem !important;
                    padding: 0.6rem 1rem !important;
                }
                
                /* Container improvements */
                .container {
                    padding-left: 1.5rem;
                    padding-right: 1.5rem;
                }
                
                .py-5 {
                    padding-top: 2.5rem !important;
                    padding-bottom: 2.5rem !important;
                }
                
                .mb-4 {
                    margin-bottom: 2rem !important;
                }
                
                .mb-5 {
                    margin-bottom: 2.5rem !important;
                }
                
                /* Feature list improvements */
                .feature-item {
                    margin-bottom: 1.5rem !important;
                }
                
                .feature-icon {
                    width: 50px !important;
                    height: 50px !important;
                    margin-right: 1rem !important;
                }
                
                .feature-icon i {
                    font-size: 1.2rem !important;
                }
                
                /* Phone prototype adjustments */
                .circle-bg {
                    width: 350px !important;
                    height: 350px !important;
                }
                
                .phone-frame {
                    width: 220px !important;
                    height: 440px !important;
                    padding: 12px !important;
                }
                
                .phone-screen {
                    padding: 12px !important;
                }
                
                /* Logo improvements */
                .hero-image-wrapper,
                .pnp-logo-wrapper,
                .pnp-main-logo-wrapper {
                    width: 120px !important;
                    height: 120px !important;
                }
                
                .hero-image-wrapper img,
                .pnp-logo-wrapper img,
                .pnp-main-logo-wrapper img {
                    width: 90px !important;
                    height: 90px !important;
                }
                
                /* General mobile improvements */
                .col-lg-7 {
                    text-align: center;
                    margin-bottom: 2rem;
                }
                
                .col-lg-5 .row {
                    justify-content: center !important;
                }
                
                .col-4 {
                    margin-bottom: 2rem !important;
                }
            }
            
            @media (max-width: 576px) {
                /* Extra mobile optimizations */
                .hero-section {
                    min-height: 100vh;
                    padding: 2rem 0;
                }
                
                .display-3 {
                    font-size: 2.5rem !important;
                    line-height: 1.1;
                }
                
                .lead {
                    font-size: 1.3rem !important;
                    line-height: 1.5;
                }
                
                h1 {
                    font-size: 2.2rem !important;
                }
                
                h2 {
                    font-size: 2rem !important;
                }
                
                h3 {
                    font-size: 1.6rem !important;
                }
                
                h4 {
                    font-size: 1.4rem !important;
                }
                
                h5 {
                    font-size: 1.3rem !important;
                }
                
                h6 {
                    font-size: 1.1rem !important;
                }
                
                /* Better button sizing */
                .hero-buttons .btn {
                    font-size: 1.1rem;
                    padding: 0.9rem 1.3rem;
                    min-height: 52px;
                }
                
                /* Card adjustments */
                .card-body {
                    padding: 1.5rem !important;
                }
                
                .icon-circle {
                    width: 50px !important;
                    height: 50px !important;
                }
                
                .icon-circle i {
                    font-size: 1.3rem !important;
                }
                
                /* Table adjustments */
                .table {
                    font-size: 1rem !important;
                }
                
                .table th,
                .table td {
                    padding: 0.8rem 0.5rem !important;
                }
                
                .btn-sm {
                    font-size: 0.9rem !important;
                    padding: 0.5rem 0.8rem !important;
                    min-height: 40px;
                }
                
                /* Logo adjustments */
                .hero-image-wrapper,
                .pnp-logo-wrapper,
                .pnp-main-logo-wrapper {
                    width: 100px !important;
                    height: 100px !important;
                }
                
                .hero-image-wrapper img,
                .pnp-logo-wrapper img,
                .pnp-main-logo-wrapper img {
                    width: 75px !important;
                    height: 75px !important;
                }
                
                /* Phone prototype for small screens */
                .circle-bg {
                    width: 280px !important;
                    height: 280px !important;
                }
                
                .phone-frame {
                    width: 190px !important;
                    height: 380px !important;
                    padding: 10px !important;
                }
                
                .phone-screen {
                    padding: 10px !important;
                }
                
                .mobile-form div {
                    margin-bottom: 8px !important;
                }
                
                /* Container adjustments */
                .container {
                    padding-left: 1rem;
                    padding-right: 1rem;
                }
                
                .py-5 {
                    padding-top: 2rem !important;
                    padding-bottom: 2rem !important;
                }
                
                .card {
                    margin-bottom: 1.5rem !important;
                }
                
                .col-xl-3 {
                    margin-bottom: 1.5rem;
                }
                
                .row {
                    margin-left: -10px;
                    margin-right: -10px;
                }
                
                .col-xl-3, .col-md-6 {
                    padding-left: 10px;
                    padding-right: 10px;
                }
            }
            
            @media (max-width: 400px) {
                /* Ultra-mobile optimizations for very small screens */
                .display-3 {
                    font-size: 2.2rem !important;
                    line-height: 1.1;
                }
                
                .lead {
                    font-size: 1.2rem !important;
                }
                
                h1 {
                    font-size: 2rem !important;
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
                
                h5 {
                    font-size: 1.2rem !important;
                }
                
                h6 {
                    font-size: 1rem !important;
                }
                
                .container {
                    padding-left: 0.8rem;
                    padding-right: 0.8rem;
                }
                
                .card-body {
                    padding: 1.2rem !important;
                }
                
                .hero-buttons .btn {
                    font-size: 1rem;
                    padding: 0.8rem 1.2rem;
                    min-height: 48px;
                }
                
                .icon-circle {
                    width: 45px !important;
                    height: 45px !important;
                }
                
                .icon-circle i {
                    font-size: 1.1rem !important;
                }
                
                .phone-frame {
                    width: 170px !important;
                    height: 340px !important;
                }
                
                .circle-bg {
                    width: 250px !important;
                    height: 250px !important;
                }
                
                .table {
                    font-size: 0.95rem !important;
                }
                
                .btn-sm {
                    font-size: 0.85rem !important;
                    padding: 0.4rem 0.7rem !important;
                }
                
                .badge {
                    font-size: 0.9rem !important;
                    padding: 0.4rem 0.8rem !important;
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
        
        <?php include'../footer.php';?>    </div>
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
    <script src="../../vendor/chart.js/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

<!-- Custom JavaScript for navbar functionality -->
<script>
    $(document).ready(function() {
        // Enhanced navbar toggle functionality
        $('.navbar-toggler').click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var target = $(this).attr('data-target');
            var navbar = $(target);
            
            // Toggle the collapse
            navbar.toggleClass('show');
            
            // Update aria-expanded
            var isExpanded = navbar.hasClass('show');
            $(this).attr('aria-expanded', isExpanded);
            
            // Add animation class
            if (isExpanded) {
                navbar.addClass('collapsing').removeClass('collapse');
                setTimeout(function() {
                    navbar.removeClass('collapsing').addClass('collapse show');
                }, 350);
            } else {
                navbar.addClass('collapsing').removeClass('show');
                setTimeout(function() {
                    navbar.removeClass('collapsing').addClass('collapse');
                }, 350);
            }
        });
        
        // Close navbar when clicking outside
        $(document).click(function(event) {
            if (!$(event.target).closest('.navbar').length) {
                $('.navbar-collapse').removeClass('show');
                $('.navbar-toggler').attr('aria-expanded', 'false');
            }
        });
        
        // Handle dropdown with proper Bootstrap 4 methods
        $('.dropdown-toggle').dropdown();
        
        // Close dropdown when clicking outside
        $(document).click(function(event) {
            if (!$(event.target).closest('.dropdown').length) {
                $('.dropdown-menu').removeClass('show');
            }
        });
        
        // Active page highlighting
        var currentPath = window.location.pathname;
        $('.navbar-nav .nav-link').each(function() {
            var href = $(this).attr('href');
            if (href && currentPath.includes(href.replace('../', ''))) {
                $(this).addClass('active');
            }
        });
    });
</script>

<script>
    // Bar Chart: Monthly Incident Count
    const ctxBar = document.getElementById('barChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Incident Count',
                data: [12, 19, 9, 15, 7, 11, 14, 8, 10, 13, 6, 17], // sample data
                backgroundColor: '#4e73df',
                borderColor: '#4e73df',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 5
                    }
                }
            }
        }
    });

    // Pie Chart: Incident Type Distribution
    const ctxPie = document.getElementById('pieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: ['Phishing', 'Malware', 'Unauthorized Access'],
            datasets: [{
                data: [40, 25, 35], // sample data
                backgroundColor: ['#1cc88a', '#36b9cc', '#f6c23e'],
            }]
        },
        options: {
            responsive: true
        }
    });
</script>

</body>

</html>