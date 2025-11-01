<?php
// filepath: c:\xampp\htdocs\ireport\admin\reports\index.php
include '../../connectMySql.php';
include '../../loginverification.php';

if(logged_in()){
    $session_user_id = $_SESSION['user_id'];
    
    // Get filter parameters
    $status_filter = isset($_GET['status']) ? $_GET['status'] : '';
    $category_filter = isset($_GET['category']) ? $_GET['category'] : '';
    $date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
    $date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';
    
    // Build WHERE clause for filters (removed severity filter)
    $whereConditions = [];
    if ($status_filter) $whereConditions[] = "i.status = '$status_filter'";
    if ($category_filter) $whereConditions[] = "i.category = '$category_filter'";
    if ($date_from) $whereConditions[] = "DATE(i.created_at) >= '$date_from'";
    if ($date_to) $whereConditions[] = "DATE(i.created_at) <= '$date_to'";
    
    $whereClause = !empty($whereConditions) ? 'WHERE ' . implode(' AND ', $whereConditions) : '';
    
    // Get reports with user information (simplified query without severity)
    $query = "SELECT i.*, u.name as user_name, u.email as user_email 
              FROM incident i 
              LEFT JOIN users u ON i.user_id = u.user_id 
              $whereClause 
              ORDER BY i.created_at DESC";
    
    $result = mysqli_query($conn, $query);
    
    // Get basic statistics (removed severity counts)
    $stats_query = "SELECT 
                        COUNT(*) as total_reports,
                        SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                        SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END) as in_progress,
                        SUM(CASE WHEN status = 'resolved' THEN 1 ELSE 0 END) as resolved
                    FROM incident";
    $stats_result = mysqli_query($conn, $stats_query);
    $stats = mysqli_fetch_assoc($stats_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>iSUMBONG - Reports Management</title>
    <link rel="icon" type="image/x-icon" href="../../img/logo1.png"/>
    <link rel="icon" type="image/png" sizes="32x32" href="../../img/logo1.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../img/logo1.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../../img/logo1.png">
    <!-- Font Awesome (CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
    <!-- DataTables CSS (CDN) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">
    
    <style>
        .status-pending { background-color: #ffc107; color: white; }
        .status-in_progress { background-color: #17a2b8; color: white; }
        .status-resolved { background-color: #28a745; color: white; }
        .report-card:hover { transform: translateY(-2px); transition: all 0.3s; }
        
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
    <div id="wrapper">
        <?php include '../sidebar.php'; ?>
        
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include '../nav.php'; ?>
                
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">
                            <i class="fas fa-clipboard-list"></i> Reports Management
                        </h1>
                        <div>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-download"></i> Export Reports
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="export_reports.php?format=csv<?php echo $status_filter ? '&status='.$status_filter : ''; ?><?php echo $category_filter ? '&category='.$category_filter : ''; ?><?php echo $date_from ? '&date_from='.$date_from : ''; ?><?php echo $date_to ? '&date_to='.$date_to : ''; ?>">
                                        <i class="fas fa-file-csv"></i> Export as CSV
                                    </a>
                                    <a class="dropdown-item" href="export_reports.php?format=excel<?php echo $status_filter ? '&status='.$status_filter : ''; ?><?php echo $category_filter ? '&category='.$category_filter : ''; ?><?php echo $date_from ? '&date_from='.$date_from : ''; ?><?php echo $date_to ? '&date_to='.$date_to : ''; ?>">
                                        <i class="fas fa-file-excel"></i> Export as Excel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Reports</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $stats['total_reports']; ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Pending</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $stats['pending']; ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Investigating</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $stats['in_progress']; ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-cog fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Resolved</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $stats['resolved']; ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-filter"></i> Filter Reports
                            </h6>
                        </div>
                        <div class="card-body">
                            <form method="GET" class="row">
                                <div class="col-md-2">
                                    <select name="status" class="form-control">
                                        <option value="">All Status</option>
                                        <option value="pending" <?php echo $status_filter == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="in_progress" <?php echo $status_filter == 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                                        <option value="resolved" <?php echo $status_filter == 'resolved' ? 'selected' : ''; ?>>Resolved</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="category" class="form-control">
                                        <option value="">All Categories</option>
                                        <option value="Phishing" <?php echo $category_filter == 'Phishing' ? 'selected' : ''; ?>>Phishing</option>
                                        <option value="Malware" <?php echo $category_filter == 'Malware' ? 'selected' : ''; ?>>Malware</option>
                                        <option value="Unauthorized Access" <?php echo $category_filter == 'Unauthorized Access' ? 'selected' : ''; ?>>Unauthorized Access</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="date" name="date_from" class="form-control" value="<?php echo $date_from; ?>" placeholder="From Date">
                                </div>
                                <div class="col-md-3">
                                    <input type="date" name="date_to" class="form-control" value="<?php echo $date_to; ?>" placeholder="To Date">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-search"></i> Filter
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Reports Table -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">All Incident Reports</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Reporter</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Location</th>
                                            <th>Date Occurred</th>
                                            <th>Submitted</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($result && mysqli_num_rows($result) > 0): ?>
                                            <?php while($row = mysqli_fetch_assoc($result)): ?>
                                            <tr>
                                                <td>#<?php echo $row['id']; ?></td>
                                                <td>
                                                    <div>
                                                        <strong><?php echo htmlspecialchars($row['user_name'] ?? 'Unknown'); ?></strong><br>
                                                        <small class="text-dark"><?php echo htmlspecialchars($row['user_email'] ?? 'No email'); ?></small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge badge-secondary">
                                                        <?php echo ucfirst(str_replace('_', ' ', $row['category'] ?? 'Other')); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge status-<?php echo $row['status'] ?? 'pending'; ?>">
                                                        <?php echo ucfirst(str_replace('_', ' ', $row['status'] ?? 'Pending')); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo htmlspecialchars($row['system_affected'] ?? 'Not specified'); ?></td>
                                                <td>
                                                    <?php 
                                                    if(isset($row['date']) && $row['date']) {
                                                        echo date('M j, Y g:i A', strtotime($row['date']));
                                                    } else {
                                                        echo 'Not specified';
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo date('M j, Y g:i A', strtotime($row['created_at'])); ?></td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="view_report.php?id=<?php echo $row['id']; ?>" 
                                                           class="btn btn-info btn-sm" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <button onclick="updateStatus(<?php echo $row['id']; ?>, '<?php echo $row['status']; ?>')" 
                                                                class="btn btn-warning btn-sm" title="Update Status">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button onclick="deleteReport(<?php echo $row['id']; ?>)" 
                                                                class="btn btn-danger btn-sm" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8" class="text-center">
                                                    <div class="py-4">
                                                        <i class="fas fa-inbox fa-3x text-gray-400 mb-3"></i>
                                                        <h5 class="text-gray-500">No Reports Found</h5>
                                                        <p class="text-dark">There are no incident reports to display.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include '../footer.php'; ?>
        </div>
    </div>

    <!-- Scripts -->
    <!-- jQuery (CDN) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- Bootstrap 4 Bundle (incl. Popper) (CDN) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery Easing (CDN) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="../../js/sb-admin-2.min.js"></script>
    <!-- DataTables (CDN) -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../js/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "responsive": true,
                "pageLength": 25,
                "order": [[ 6, "desc" ]] // Sort by submitted date
            });
        });

        function updateStatus(reportId, currentStatus) {
            Swal.fire({
                title: 'Update Status',
                input: 'select',
                inputOptions: {
                    'pending': 'Pending',
                    'in_progress': 'Investigation',
                    'resolved': 'Resolved'
                },
                inputValue: currentStatus,
                showCancelButton: true,
                confirmButtonText: 'Update',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Please select a status!';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // AJAX call to update status
                    fetch('update_status.php', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        body: 'report_id=' + reportId + '&new_status=' + result.value
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Updated!', 'Report status has been updated.', 'success')
                            .then(() => location.reload());
                        } else {
                            Swal.fire('Error!', 'Failed to update status.', 'error');
                        }
                    });
                }
            });
        }

        function deleteReport(reportId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // AJAX call to delete report
                    fetch('delete_report.php', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        body: 'report_id=' + reportId
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Deleted!', 'Report has been deleted.', 'success')
                            .then(() => location.reload());
                        } else {
                            Swal.fire('Error!', 'Failed to delete report.', 'error');
                        }
                    });
                }
            });
        }
    </script>
</body>
</html>

<?php
} else {
    header('location:../../index.php');
}
?>