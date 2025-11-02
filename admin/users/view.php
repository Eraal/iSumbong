<?php
include '../../connectMySql.php';
include '../../loginverification.php';

if(!logged_in()){
    header('location:../../index.php');
    exit;
}

// Get user ID from URL
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($user_id <= 0) {
    header('location:index.php');
    exit;
}

// Fetch user details
$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0) {
    header('location:index.php');
    exit;
}

$user_data = $result->fetch_assoc();

// Count user's incidents
$incident_query = "SELECT COUNT(*) as total_incidents FROM incident WHERE user_id = ?";
$incident_stmt = $conn->prepare($incident_query);
$incident_stmt->bind_param("i", $user_id);
$incident_stmt->execute();
$incident_result = $incident_stmt->get_result();
$incident_count = $incident_result->fetch_assoc()['total_incidents'];

// Get recent incidents
$recent_incidents_query = "SELECT id, title, date, status FROM incident WHERE user_id = ? ORDER BY date DESC LIMIT 5";
$recent_stmt = $conn->prepare($recent_incidents_query);
$recent_stmt->bind_param("i", $user_id);
$recent_stmt->execute();
$recent_incidents = $recent_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>iSumbong - User Profile</title>
    <link rel="icon" type="image/x-icon" href="../../img/logo1.png" />
    <!-- Font Awesome (CDN to avoid /vendor 403) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
    
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
        
        .profile-card {
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            border: none;
        }
        
        .profile-header {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
            padding: 2rem;
        }
        
        .profile-avatar {
            width: 100px;
            height: 100px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            margin: 0 auto 1rem;
        }
        
        .stat-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border: 1px solid #e3e6f0;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
            color: white;
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
                        <h1 class="h3 mb-0 text-gray-800">User Profile</h1>
                        <a href="index.php" class="btn btn-outline-secondary btn-sm" style="background: linear-gradient(45deg, #2c3e50, #34495e); color: white; border: none; border-radius: 25px; padding: 8px 20px;">
                            <i class="fas fa-arrow-left"></i> Back to Users
                        </a>
                    </div>

                    <!-- Profile Header Card -->
                    <div class="card profile-card mb-4">
                        <div class="profile-header text-center">
                            <div class="profile-avatar">
                                <i class="fas fa-user" style="font-size: 2.5rem; color: #3498db;"></i>
                            </div>
                            <h2 class="font-weight-bold mb-2"><?php echo htmlspecialchars($user_data['name']); ?></h2>
                            <p class="mb-1 opacity-75"><?php echo htmlspecialchars($user_data['email']); ?></p>
                            <span class="badge badge-<?php echo strtolower($user_data['status']) == 'active' ? 'success' : 'danger'; ?> badge-pill px-3 py-2 mt-2">
                                <?php echo strtoupper($user_data['status']); ?>
                            </span>
                        </div>
                    </div>

                    <!-- Statistics Row -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stat-card">
                                <div class="stat-icon" style="background: linear-gradient(45deg, #3498db, #2980b9);">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <h5 class="font-weight-bold text-gray-800 mb-1"><?php echo $incident_count; ?></h5>
                                <p class="text-muted mb-0">Total Reports</p>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stat-card">
                                <div class="stat-icon" style="background: linear-gradient(45deg, #2c3e50, #34495e);">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <h5 class="font-weight-bold text-gray-800 mb-1">
                                    <?php echo date('M d, Y', strtotime($user_data['created_at'] ?? 'now')); ?>
                                </h5>
                                <p class="text-muted mb-0">Member Since</p>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stat-card">
                                <div class="stat-icon" style="background: linear-gradient(45deg, #3498db, #2980b9);">
                                    <i class="fas fa-user-tag"></i>
                                </div>
                                <h5 class="font-weight-bold text-gray-800 mb-1">
                                    <?php echo ucfirst($user_data['role'] ?? 'User'); ?>
                                </h5>
                                <p class="text-muted mb-0">Role</p>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stat-card">
                                <div class="stat-icon" style="background: linear-gradient(45deg, #2c3e50, #34495e);">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <h5 class="font-weight-bold text-gray-800 mb-1">
                                    <?php echo $user_data['is_verified'] ? 'Verified' : 'Pending'; ?>
                                </h5>
                                <p class="text-muted mb-0">Status</p>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Details and Recent Activity -->
                    <div class="row">
                        <!-- Profile Details -->
                        <div class="col-lg-6 mb-4">
                            <div class="card profile-card h-100">
                                <div class="card-header py-3" style="background: linear-gradient(45deg, #3498db, #2980b9); color: white; border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                                    <h6 class="m-0 font-weight-bold text-white">
                                        <i class="fas fa-user-circle mr-2"></i>Profile Details
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <strong>User ID:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            #<?php echo $user_data['user_id']; ?>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <strong>Full Name:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <?php echo htmlspecialchars($user_data['name']); ?>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <strong>Email:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <?php echo htmlspecialchars($user_data['email']); ?>
                                        </div>
                                    </div>
                                    <?php if (!empty($user_data['barangay'])): ?>
                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <strong>Barangay:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <?php echo htmlspecialchars($user_data['barangay']); ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php if (!empty($user_data['location'])): ?>
                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <strong>Location:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <?php echo htmlspecialchars($user_data['location']); ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <strong>Account Status:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <span class="badge badge-<?php echo strtolower($user_data['status']) == 'active' ? 'success' : 'danger'; ?> badge-pill">
                                                <?php echo strtoupper($user_data['status']); ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <strong>Verified:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <?php if ($user_data['is_verified']): ?>
                                                <span class="badge badge-success badge-pill">
                                                    <i class="fas fa-check-circle mr-1"></i>Verified
                                                </span>
                                            <?php else: ?>
                                                <span class="badge badge-warning badge-pill">
                                                    <i class="fas fa-clock mr-1"></i>Pending
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php if (isset($user_data['created_at'])): ?>
                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <strong>Joined:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <?php echo date('F d, Y \a\t g:i A', strtotime($user_data['created_at'])); ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div class="col-lg-6 mb-4">
                            <div class="card profile-card h-100">
                                <div class="card-header py-3" style="background: linear-gradient(45deg, #2c3e50, #34495e); color: white; border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                                    <h6 class="m-0 font-weight-bold text-white">
                                        <i class="fas fa-history mr-2"></i>Recent Reports
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <?php if ($recent_incidents->num_rows > 0): ?>
                                        <?php while ($incident = $recent_incidents->fetch_assoc()): ?>
                                            <?php
                                            $status_color = '';
                                            switch (strtolower($incident['status'])) {
                                                case 'pending':
                                                    $status_color = 'warning';
                                                    break;
                                                case 'investigating':
                                                    $status_color = 'info';
                                                    break;
                                                case 'resolved':
                                                    $status_color = 'success';
                                                    break;
                                                case 'closed':
                                                    $status_color = 'secondary';
                                                    break;
                                                default:
                                                    $status_color = 'primary';
                                            }
                                            ?>
                                            <div class="border-left border-<?php echo $status_color; ?> border-3 pl-3 mb-3">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="mb-1 font-weight-bold">
                                                            <a href="../incident/view.php?id=<?php echo $incident['id']; ?>" class="text-decoration-none">
                                                                <?php echo htmlspecialchars($incident['title']); ?>
                                                            </a>
                                                        </h6>
                                                        <small class="text-muted">
                                                            <i class="fas fa-calendar mr-1"></i>
                                                            <?php echo date('M d, Y', strtotime($incident['date'])); ?>
                                                        </small>
                                                    </div>
                                                    <span class="badge badge-<?php echo $status_color; ?> badge-pill">
                                                        <?php echo strtoupper($incident['status']); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        <?php endwhile; ?>
                                        
                                        <!-- View All Reports Button -->
                                        <div class="text-center mt-3">
                                            <a href="../incident/index.php?user_filter=<?php echo $user_id; ?>" class="btn btn-sm" style="background: linear-gradient(45deg, #3498db, #2980b9); color: white; border: none; border-radius: 25px; padding: 8px 20px;">
                                                <i class="fas fa-eye mr-1"></i>View All Reports
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center py-4">
                                            <i class="fas fa-file-alt text-muted" style="font-size: 3rem; opacity: 0.3;"></i>
                                            <h6 class="text-muted mt-2">No Reports Yet</h6>
                                            <p class="text-muted small">This user hasn't submitted any incident reports.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- End of Main Content -->

            </div>
            <!-- End of Content -->

            <?php include'../footer.php';?>

        </div>
        <!-- End of Content Wrapper -->

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

    <!-- Bootstrap core JavaScript (CDN) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript (CDN) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin-2.min.js"></script>

</body>

</html>