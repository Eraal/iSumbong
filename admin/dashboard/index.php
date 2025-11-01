<?php
include '../../includes/admin_auth.php';
include '../../connectMySql.php';

// Admin is now authenticated and verified
$current_admin = get_logged_user();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>iSumbong - Admin Dashboard</title>
    <link rel="icon" type="image/x-icon" href="../../img/logo1.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="../../img/logo1.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../img/logo1.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../../img/logo1.png">

  <!-- Custom fonts for this template (CDN to avoid /vendor 403) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <script src="../../js/html2canvas.min.js"></script>
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
  <!-- Chart.js (CDN) -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../../js/sweetalert2.min.css">
  <script src="../../js/sweetalert2.all.min.js"></script>
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
        
        /* Chart containers */
        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
            margin: 1rem 0;
        }
        
        .chart-container canvas {
            max-height: 400px !important;
        }
        
        /* Card improvements */
        .card {
            margin-bottom: 1.5rem;
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
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
            
            .chart-container {
                height: 300px;
            }
        }
        
        /* Fix for dashboard cards */
        .row {
            margin-left: -0.75rem;
            margin-right: -0.75rem;
        }
        
        .col-xl-3, .col-md-6, .col-lg-6, .col-12 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        
        /* Hide any scroll-to-top or floating elements */
        .scroll-to-top, .fab, .floating-btn {
            display: none !important;
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
                        <h1 class="h3 mb-0 text-gray-800">Home</h1>
                        <button id="refreshBtn" class="btn btn-primary btn-sm">
                            <i class="fas fa-sync-alt fa-sm"></i> Refresh Charts
                        </button>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                      <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow-sm" style="border-radius: 1rem; background: #fff;">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                              <div class="icon-circle bg-info text-white mr-3" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-list fa-lg"></i>
                              </div>
                              <div>
                                <h6 class="text-uppercase font-weight-bold mb-1 text-info">Total</h6>
                                <small class="text-dark font-weight-normal">All Reports</small>
                              </div>
                            </div>
                            <div class="text-center">
                              <h2 class="font-weight-bold text-dark mb-0">
                                <?php
                                  $query = "SELECT COUNT(id) as total FROM incident";
                                  $result = $conn->query($query);
                                  if ($row = $result->fetch_assoc()) {
                                    echo $row['total'];
                                  }
                                ?>
                              </h2>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow-sm" style="border-radius: 1rem; background: #fff;">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                              <div class="icon-circle bg-danger text-white mr-3" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-clock fa-lg"></i>
                              </div>
                              <div>
                                <h6 class="text-uppercase font-weight-bold mb-1 text-danger">Pending</h6>
                                <small class="text-dark">Waiting</small>
                              </div>
                            </div>
                            <div class="text-center">
                              <h2 class="font-weight-bold text-dark mb-0">
                                <?php
                                  $query = "SELECT COUNT(id) as total FROM incident WHERE status = 'PENDING'";
                                  $result = $conn->query($query);
                                  if ($row = $result->fetch_assoc()) {
                                    echo $row['total'];
                                  }
                                ?>
                              </h2>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow-sm" style="border-radius: 1rem; background: #fff;">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                              <div class="icon-circle bg-warning text-white mr-3" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-search fa-lg"></i>
                              </div>
                              <div>
                                <h6 class="text-uppercase font-weight-bold mb-1 text-warning">Investigating</h6>
                                <small class="text-dark">In Progress</small>
                              </div>
                            </div>
                            <div class="text-center">
                              <h2 class="font-weight-bold text-dark mb-0">
                                <?php
                                  $query = "SELECT COUNT(id) as total FROM incident WHERE status = 'INVESTIGATING'";
                                  $result = $conn->query($query);
                                  if ($row = $result->fetch_assoc()) {
                                    echo $row['total'];
                                  }
                                ?>
                              </h2>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow-sm" style="border-radius: 1rem; background: #fff;">
                          <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                              <div class="icon-circle bg-success text-white mr-3" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-check-circle fa-lg"></i>
                              </div>
                              <div>
                                <h6 class="text-uppercase font-weight-bold mb-1 text-success">Resolved</h6>
                                <small class="text-dark">Closed</small>
                              </div>
                            </div>
                            <div class="text-center">
                              <h2 class="font-weight-bold text-dark mb-0">
                                <?php
                                  $query = "SELECT COUNT(id) as total FROM incident WHERE status = 'RESOLVED'";
                                  $result = $conn->query($query);
                                  if ($row = $result->fetch_assoc()) {
                                    echo $row['total'];
                                  }
                                ?>
                              </h2>
                            </div>
                          </div>
                        </div>
                      </div>


                    </div>


<div class="row">

<div class="col-lg-6 col-12">            <!-- Bar Chart Card -->
  <div class="card shadow mb-4">
      <div class="card-header">
          <i class="fas fa-chart-bar me-1"></i>
          Monthly Incident Count (Jan - Dec)
      </div>
      <div class="card-body">
          <canvas id="barChart" width="100%" height="40"></canvas>
      </div>
  </div>
</div>
<!-- Pie Chart Card -->
<div class="col-lg-6 col-12">            <!-- Pie Chart Card -->
  <div class="card shadow mb-4">
      <div class="card-header">
          <i class="fas fa-chart-pie me-1"></i>
          Incident Category Distribution
      </div>
      <div class="card-body">
          <canvas id="pieChart" width="100%" height="40"></canvas>
      </div>
  </div>
</div>

</div>



                  <div class="card shadow-sm mb-4" style="border-radius: 1rem;">
  <div class="card-header py-3 d-flex justify-content-between align-items-center bg-white" style="border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
    <h6 class="m-0 font-weight-bold text-primary">Recent Incidents</h6>
    <a href="../incident/index.php" class="text-primary small font-weight-bold">View All</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover align-middle" id="dataTable" width="100%" cellspacing="0" style="border-radius: 0.75rem; overflow: hidden;">
        <thead class="thead-light">
          <tr>
            <th class="text-secondary text-uppercase small">Incident Title</th>
            <th class="text-secondary text-uppercase small">Date Reported</th>
            <th class="text-secondary text-uppercase small">Status</th>
            <th class="text-secondary text-uppercase small">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = "SELECT * FROM incident ORDER BY id DESC LIMIT 5";
          $result = $conn->query($query);
          while ($row = $result->fetch_assoc()) {
              $color = "secondary";
              if ($row['status'] == 'PENDING') {
                  $color = "danger";
              } elseif ($row['status'] == 'INVESTIGATING') {
                  $color = "warning";
              } elseif ($row['status'] == 'RESOLVED') {
                  $color = "success";
              }

              echo "<tr>";
              echo "<td class='text-dark font-weight-bold'>" . htmlspecialchars(strtoupper($row['title'])) . "</td>";
              echo "<td class='text-dark'>" . htmlspecialchars(strtoupper($row['date'])) . "</td>";
              echo "<td><span class='badge badge-{$color} badge-pill px-3 py-2'>" . strtoupper($row['status']) . "</span></td>";
              echo "<td>
                      <a href='view.php?id={$row["id"]}' class='btn btn-sm btn-outline-primary rounded-pill shadow-sm'>
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
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php include'../footer.php';?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

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

  <!-- Page level plugins -->
  <!-- Chart.js loaded via CDN above -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script>
    let dashboardBarChart, dashboardPieChart;

    // Function to load monthly incident data for dashboard
    async function loadDashboardMonthlyData() {
        try {
            const response = await fetch('../api/chart-data.php?action=monthly');
            const data = await response.json();
            
            const ctxBar = document.getElementById('barChart').getContext('2d');
            
            if (dashboardBarChart) {
                dashboardBarChart.destroy();
            }
            
            dashboardBarChart = new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: `Incident Count (${data.year})`,
                        data: data.data,
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
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        } catch (error) {
            console.error('Error loading monthly data:', error);
        }
    }

    // Function to load category distribution data for dashboard
    async function loadDashboardCategoryData() {
        try {
            const response = await fetch('../api/chart-data.php?action=category');
            const data = await response.json();
            
            const ctxPie = document.getElementById('pieChart').getContext('2d');
            
            if (dashboardPieChart) {
                dashboardPieChart.destroy();
            }
            
            dashboardPieChart = new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: data.labels,
                    datasets: [{
                        data: data.data,
                        backgroundColor: data.colors,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        } catch (error) {
            console.error('Error loading category data:', error);
        }
    }

    // Load data when page loads
    document.addEventListener('DOMContentLoaded', function() {
        loadDashboardMonthlyData();
        loadDashboardCategoryData();
        
        // Add refresh button functionality
        document.getElementById('refreshBtn').addEventListener('click', function() {
            this.innerHTML = '<i class="fas fa-spinner fa-spin fa-sm"></i> Refreshing...';
            this.disabled = true;
            
            Promise.all([
                loadDashboardMonthlyData(),
                loadDashboardCategoryData()
            ]).then(() => {
                this.innerHTML = '<i class="fas fa-sync-alt fa-sm"></i> Refresh Charts';
                this.disabled = false;
                
                // Also refresh the page stats
                location.reload();
            }).catch(() => {
                this.innerHTML = '<i class="fas fa-sync-alt fa-sm"></i> Refresh Charts';
                this.disabled = false;
            });
        });
    });

    // Refresh data every 30 seconds
    setInterval(function() {
        loadDashboardMonthlyData();
        loadDashboardCategoryData();
    }, 30000);
</script>

</body>

</html>