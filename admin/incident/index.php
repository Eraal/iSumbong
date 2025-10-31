<?php
include '../../connectMySql.php';
include '../../loginverification.php';

if (logged_in()) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>iSumbong - Incident Management</title>
        <link rel="icon" type="image/x-icon" href="../../img/logo1.png" />
        <link rel="icon" type="image/png" sizes="32x32" href="../../img/logo1.png">
        <link rel="icon" type="image/png" sizes="16x16" href="../../img/logo1.png">
        <link rel="apple-touch-icon" sizes="180x180" href="../../img/logo1.png">

        <!-- Custom fonts for this template-->
        <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">

        <!-- Custom styles for this template-->
        <script src="../../js/html2canvas.min.js"></script>
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

            <?php include '../sidebar.php'; ?>

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <?php include '../nav.php'; ?>

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Manage Incident</h1>
                            <!--<a href="register.php" class=" btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus"></i> Report New Incident</a>-->
                        </div>

                        <!-- Content Row -->
                        <div class="card shadow-sm mb-4" style="border-radius: 1rem;">
                            <div class="card-header py-3 bg-white" style="border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                                <h6 class="m-0 font-weight-bold text-primary">Incident Reports</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle" id="dataTable" width="100%" cellspacing="0" style="border-radius: 0.75rem; overflow: hidden;">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="text-secondary text-uppercase small">Incident Type</th>
                                                <th class="text-secondary text-uppercase small">Date Reported</th>
                                                <th class="text-secondary text-uppercase small">Status</th>
                                                <th class="text-secondary text-uppercase small">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Only show incidents that are not deleted by admin
                                            $query = "SELECT * FROM incident WHERE (deleted_by_admin IS NULL OR deleted_by_admin = 0) ORDER BY date DESC";
                                            $result = $conn->query($query);
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";

                                                // Set color for badge
                                                $color = "secondary";
                                                if ($row['status'] == 'PENDING') {
                                                    $color = "danger";
                                                } else if ($row['status'] == 'INVESTIGATING') {
                                                    $color = "warning";
                                                } else if ($row['status'] == 'RESOLVED') {
                                                    $color = "success";
                                                }

                                                echo "<td class='text-dark font-weight-bold'>" . htmlspecialchars(strtoupper($row['title'])) . "</td>";
                                                echo "<td class='text-dark'>" . htmlspecialchars(strtoupper($row['date'])) . "</td>";
                                                echo "<td><span class='badge badge-pill badge-" . $color . " px-3 py-2'>" . strtoupper($row['status']) . "</span></td>";
                                                echo "<td>
                                                <a href='view.php?id=" . $row["id"] . "' class='btn btn-sm btn-outline-primary rounded-pill shadow-sm'>
                                                   <i class='fas fa-eye'></i> View
                                                </a>";

                                                // If incident has feedback, show "View Feedback" button
                                                $check_feedback = $conn->prepare("SELECT rating, improvements, comment 
                                                                         FROM feedback 
                                                                        WHERE incident_id = ?");
                                                $check_feedback->bind_param("i", $row["id"]);
                                                $check_feedback->execute();
                                                $result_feedback = $check_feedback->get_result();

                                                if ($result_feedback->num_rows > 0) {
                                                    $feedback = $result_feedback->fetch_assoc();
                                                    echo " <button class='btn btn-sm btn-outline-info rounded-pill ml-1'
                                                        data-toggle='modal'
                                                        data-target='#viewFeedbackModal'
                                                        onclick='showFeedback(" . json_encode($feedback) . ")'>
                                                        <i class='fas fa-comment-dots'></i> View Feedback
                                                    </button>";
                                                }

                                                echo "</td>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- View Feedback Modal -->
                        <div class="modal fade" id="viewFeedbackModal" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-info text-white">
                                        <h5 class="modal-title">User Feedback</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Rating:</strong> <span id="viewRating"></span> ⭐</p>
                                        <p><strong>Improvements:</strong> <span id="viewImprovements"></span></p>
                                        <p><strong>Comment:</strong></p>
                                        <p id="viewComment" class="border p-2 rounded bg-light"></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            function showFeedback(feedback) {
                                document.getElementById("viewRating").textContent = feedback.rating;
                                document.getElementById("viewImprovements").textContent = feedback.improvements || "None";
                                document.getElementById("viewComment").textContent = feedback.comment || "No comments provided.";
                            }

                            function setIncidentId(id) {
                                document.getElementById('feedback_incident_id').value = id;
                            }
                        </script>


                    </div>
                    <!-- End of Main Content -->
                </div>
                <!-- End of Content Wrapper -->
                <?php include '../footer.php'; ?>

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

            <!-- Page level custom scripts -->
            <script src="../../js/demo/chart-area-demo.js"></script>
            <script src="../../js/demo/chart-pie-demo.js"></script>
            <script src="../../vendor/datatables/jquery.dataTables.min.js"></script>
            <script src="../../vendor/datatables/dataTables.bootstrap4.min.js"></script>

            <script>
                $(function() {
                    $("#dataTable").DataTable({
                        "autoWidth": false,
                    });
                });
            </script>
            <script>
                // Function to export HTML table to Excel
                function convertToImage() {
                    const element = document.getElementById('myDiv');

                    html2canvas(element).then(canvas => {
                        const imgData = canvas.toDataURL('image/png');

                        // Create a link element
                        const downloadLink = document.createElement('a');

                        // Set the href attribute with the data URL
                        downloadLink.href = imgData;

                        // Set the download attribute with the desired file name
                        downloadLink.download = 'invoice.png'; // You can change the file name and extension

                        // Append the link to the body and click it programmatically
                        document.body.appendChild(downloadLink);
                        downloadLink.click();

                        // Remove the link from the DOM
                        document.body.removeChild(downloadLink);
                    });
                }
            </script>
    </body>

    </html>
<?php
} else {
    header('location:../../index.php');
} ?>