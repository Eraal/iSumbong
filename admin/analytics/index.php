<?php
include '../../connectMySql.php';
include '../../loginverification.php';
if(logged_in()){

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>iSumbong - Analytics</title>
    <link rel="icon" type="image/x-icon" href="../../img/logo1.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="../../img/logo1.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../img/logo1.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../../img/logo1.png">

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <script src="../../js/html2canvas.min.js"></script>
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../js/sweetalert2.all.js"></script>
    <script src="../../js/sweetalert2.css"></script>
    <script src="../../js/sweetalert2.js"></script>
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        #content {
            flex: 1;
        }
        
        .sticky-footer {
            margin-top: auto;
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
                        <h1 class="h3 mb-0 text-dark-800">Analytics</h1>
                        <button id="refreshBtn" class="btn btn-primary btn-sm">
                            <i class="fas fa-sync-alt fa-sm"></i> Refresh Data
                        </button>
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

<div class="row">

<div class="col-lg-6 col-12">            <!-- Status Chart Card -->
  <div class="card shadow mb-4">
      <div class="card-header">
          <i class="fas fa-chart-doughnut me-1"></i>
          Incident Status Distribution
      </div>
      <div class="card-body">
          <canvas id="statusChart" width="100%" height="40"></canvas>
      </div>
  </div>
</div>
<!-- Severity Chart Card -->
<div class="col-lg-6 col-12">            <!-- Severity Chart Card -->
  <div class="card shadow mb-4">
      <div class="card-header">
          <i class="fas fa-chart-bar me-1"></i>
          Severity Level Distribution
      </div>
      <div class="card-body">
          <canvas id="severityChart" width="100%" height="40"></canvas>
      </div>
  </div>
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
<script>
    let barChart, pieChart, statusChart, severityChart;

    // Function to show loading state
    function showLoading(chartId) {
        const canvas = document.getElementById(chartId);
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.font = '16px Arial';
        ctx.fillStyle = '#666';
        ctx.textAlign = 'center';
        ctx.fillText('Loading...', canvas.width / 2, canvas.height / 2);
    }

    // Function to load monthly incident data
    async function loadMonthlyData() {
        showLoading('barChart');
        try {
            const response = await fetch('../api/chart-data.php?action=monthly');
            const data = await response.json();
            
            const ctxBar = document.getElementById('barChart').getContext('2d');
            
            if (barChart) {
                barChart.destroy();
            }
            
            barChart = new Chart(ctxBar, {
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

    // Function to load category distribution data
    async function loadCategoryData() {
        showLoading('pieChart');
        try {
            const response = await fetch('../api/chart-data.php?action=category');
            const data = await response.json();
            
            const ctxPie = document.getElementById('pieChart').getContext('2d');
            
            if (pieChart) {
                pieChart.destroy();
            }
            
            pieChart = new Chart(ctxPie, {
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

    // Function to load status distribution data
    async function loadStatusData() {
        showLoading('statusChart');
        try {
            const response = await fetch('../api/chart-data.php?action=status');
            const data = await response.json();
            
            const ctxStatus = document.getElementById('statusChart').getContext('2d');
            
            if (statusChart) {
                statusChart.destroy();
            }
            
            statusChart = new Chart(ctxStatus, {
                type: 'doughnut',
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
            console.error('Error loading status data:', error);
        }
    }

    // Function to load severity distribution data
    async function loadSeverityData() {
        showLoading('severityChart');
        try {
            const response = await fetch('../api/chart-data.php?action=severity');
            const data = await response.json();
            
            const ctxSeverity = document.getElementById('severityChart').getContext('2d');
            
            if (severityChart) {
                severityChart.destroy();
            }
            
            severityChart = new Chart(ctxSeverity, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Severity Count',
                        data: data.data,
                        backgroundColor: data.colors,
                        borderColor: data.colors,
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
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        } catch (error) {
            console.error('Error loading severity data:', error);
        }
    }

    // Load all data when page loads
    document.addEventListener('DOMContentLoaded', function() {
        loadMonthlyData();
        loadCategoryData();
        loadStatusData();
        loadSeverityData();
        
        // Add refresh button functionality
        document.getElementById('refreshBtn').addEventListener('click', function() {
            this.innerHTML = '<i class="fas fa-spinner fa-spin fa-sm"></i> Refreshing...';
            this.disabled = true;
            
            Promise.all([
                loadMonthlyData(),
                loadCategoryData(),
                loadStatusData(),
                loadSeverityData()
            ]).then(() => {
                this.innerHTML = '<i class="fas fa-sync-alt fa-sm"></i> Refresh Data';
                this.disabled = false;
            }).catch(() => {
                this.innerHTML = '<i class="fas fa-sync-alt fa-sm"></i> Refresh Data';
                this.disabled = false;
            });
        });
    });

    // Refresh data every 30 seconds
    setInterval(function() {
        loadMonthlyData();
        loadCategoryData();
        loadStatusData();
        loadSeverityData();
    }, 30000);
</script>

</body>

</html>
<?php
}
else
{
    header('location:../../index.php');
}?>