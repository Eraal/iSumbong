<?php
include '../../connectMySql.php';
include '../../loginverification.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['incident_id'])) {
    $incident_id  = intval($_POST['incident_id']);
    $user_id      = intval($_SESSION['user_id']);
    $rating       = intval($_POST['rating']);
    $comment      = $conn->real_escape_string($_POST['comment']);
    $improvements = isset($_POST['improvements']) ? $_POST['improvements'] : [];

    $improvements_str = implode(",", $improvements);

    // check if feedback already exists for this user + incident
    $check = $conn->prepare("SELECT id FROM feedback WHERE incident_id = ? AND user_id = ?");
    $check->bind_param("ii", $incident_id, $user_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>alert('⚠️ You already submitted feedback for this incident.'); window.location.href='index.php';</script>";
    } else {
        $sql = "INSERT INTO feedback (incident_id, user_id, rating, improvements, comment, created_at)
                VALUES (?, ?, ?, ?, ?, NOW())";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiiss", $incident_id, $user_id, $rating, $improvements_str, $comment);

        if ($stmt->execute()) {
            echo "<script>alert('✅ Feedback submitted successfully!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('❌ Error submitting feedback.');</script>";
        }

        $stmt->close();
    }

    $check->close();
    $conn->close();
}

// Handle incident deletion (soft delete - hide from user view only)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_incident_id'])) {
    $incident_id = intval($_POST['delete_incident_id']);
    $user_id = intval($_SESSION['user_id']);
    
    // Add user_deleted column if it doesn't exist
    $check_column = $conn->query("SHOW COLUMNS FROM incident LIKE 'user_deleted'");
    if ($check_column->num_rows == 0) {
        $conn->query("ALTER TABLE incident ADD COLUMN user_deleted TINYINT(1) DEFAULT 0");
    }
    
    // Soft delete - only hide from user view
    $delete_sql = "UPDATE incident SET user_deleted = 1 WHERE id = ? AND user_id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("ii", $incident_id, $user_id);
    
    if ($delete_stmt->execute() && $delete_stmt->affected_rows > 0) {
        echo "<script>alert('✅ Incident deleted from your view successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('❌ Error deleting incident or incident not found.'); window.location.href='index.php';</script>";
    }
    
    $delete_stmt->close();
}



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

        <title>iReport</title>
        <link rel="icon" type="image/x-icon" href="../../img/logo1.jpg" />

        <!-- Custom fonts for this template (use CDN to avoid /vendor 403 in production) -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">

    <!-- Custom styles for this template-->
    <script src="../../js/html2canvas.min.js"></script>
    <!-- DataTables CSS (Bootstrap 4) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css" />
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">


    </head>

    <body id="page-top">

        <!-- Page Wrapper -->
        <div class="container-fluid p-0">

            <!-- Navigation -->
            <?php include '../nav.php'; ?>

            <!-- Main Content -->
            <div class="container-fluid p-0">

                <!-- Hero Section -->
                <section class="incidents-hero" style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); min-height: 50vh; display: flex; align-items: center; position: relative; overflow: hidden;">
                    <!-- Background Pattern -->
                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: radial-gradient(circle at 25% 25%, rgba(255,255,255,0.05) 1px, transparent 1px); background-size: 50px 50px; opacity: 0.3;"></div>

                    <div class="container">
                        <div class="row align-items-center">
                            <!-- Left Content -->
                            <div class="col-lg-8 text-white">
                                <h1 class="display-4 font-weight-bold mb-4" style="font-size: 3rem; line-height: 1.1;">
                                    My <span style="color: #3498db;">Incidents</span>
                                </h1>
                                <p class="lead mb-4" style="font-size: 1.2rem; opacity: 0.9; max-width: 600px;">
                                    Track, manage, and monitor all your cybersecurity incident reports in one centralized dashboard.
                                </p>

                                <!-- Action Button -->
                                <a href="register.php" class="btn btn-danger btn-lg px-4 py-3" style="border-radius: 50px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
                                    <i class="fas fa-plus mr-2"></i>Report New Incident
                                </a>
                            </div>

                            <!-- Right Content - Stats Summary -->
                            <div class="col-lg-4">
                                <div class="stats-summary p-4" style="background: rgba(255,255,255,0.1); border-radius: 1rem; backdrop-filter: blur(10px);">
                                    <h5 class="text-white mb-3 font-weight-bold">Quick Stats</h5>
                                    <div class="row text-center text-white">
                                        <div class="col-6 mb-3">
                                            <div class="stat-item">
                                                <h3 class="font-weight-bold mb-1" style="color: #3498db;">
                                                    <?php
                                                    $total_query = "SELECT count(id) as total FROM incident WHERE user_id = '" . $_SESSION['user_id'] . "' AND (user_deleted IS NULL OR user_deleted = 0)";
                                                    $total_result = $conn->query($total_query);
                                                    $total_row = $total_result->fetch_assoc();
                                                    echo $total_row['total'];
                                                    ?>
                                                </h3>
                                                <small>Total</small>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <div class="stat-item">
                                                <h3 class="font-weight-bold mb-1" style="color: #e74c3c;">
                                                    <?php
                                                    $pending_query = "SELECT count(id) as pending FROM incident WHERE status = 'PENDING' AND user_id = '" . $_SESSION['user_id'] . "' AND (user_deleted IS NULL OR user_deleted = 0)";
                                                    $pending_result = $conn->query($pending_query);
                                                    $pending_row = $pending_result->fetch_assoc();
                                                    echo $pending_row['pending'];
                                                    ?>
                                                </h3>
                                                <small>Pending</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="stat-item">
                                                <h3 class="font-weight-bold mb-1" style="color: #f39c12;">
                                                    <?php
                                                    $investigating_query = "SELECT count(id) as investigating FROM incident WHERE status = 'INVESTIGATING' AND user_id = '" . $_SESSION['user_id'] . "' AND (user_deleted IS NULL OR user_deleted = 0)";
                                                    $investigating_result = $conn->query($investigating_query);
                                                    $investigating_row = $investigating_result->fetch_assoc();
                                                    echo $investigating_row['investigating'];
                                                    ?>
                                                </h3>
                                                <small>Investigating</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="stat-item">
                                                <h3 class="font-weight-bold mb-1" style="color: #27ae60;">
                                                    <?php
                                                    $resolved_query = "SELECT count(id) as resolved FROM incident WHERE status = 'RESOLVED' AND user_id = '" . $_SESSION['user_id'] . "' AND (user_deleted IS NULL OR user_deleted = 0)";
                                                    $resolved_result = $conn->query($resolved_query);
                                                    $resolved_row = $resolved_result->fetch_assoc();
                                                    echo $resolved_row['resolved'];
                                                    ?>
                                                </h3>
                                                <small>Resolved</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Incidents Table Section -->
                <section class="incidents-table py-5" style="background: #f8f9fa;">
                    <div class="container">
                        <!-- Page Heading -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h2 class="font-weight-bold text-dark mb-2">Incident Reports</h2>
                                        <p class="text-muted">Manage and track all your security incident reports</p>
                                    </div>
                                    <div class="d-none d-md-block">
                                        <button onclick="downloadPDF()" class="btn btn-outline-primary">
                                            <i class="fas fa-download mr-2"></i>Export PDF
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Enhanced Incidents Table -->
                        <div class="card shadow-sm" style="border-radius: 1rem; border: none;">
                            <div class="card-header py-3 d-flex justify-content-between align-items-center bg-white" style="border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-list-alt mr-2"></i>All Incidents
                                </h6>
                                <div class="d-flex align-items-center">
                                    <span class="text-muted small mr-3">
                                        <i class="fas fa-clock mr-1"></i>Last updated: <?php echo date('M d, Y H:i'); ?>
                                    </span>
                                    <button onclick="location.reload()" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive" id="myDiv">
                                    <table class="table table-hover align-middle" id="dataTable" width="100%" cellspacing="0" style="border-radius: 0.75rem; overflow: hidden;">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="text-secondary text-uppercase small">Incident Title</th>
                                                <th class="text-secondary text-uppercase small">Date Reported</th>
                                                <th class="text-secondary text-uppercase small">Status</th>
                                                <th class="text-secondary text-uppercase small">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT * FROM incident WHERE user_id = '" . $_SESSION['user_id'] . "' AND (user_deleted IS NULL OR user_deleted = 0) ORDER BY date DESC";
                                            $result = $conn->query($query);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $color = "secondary";
                                                    $icon = "fas fa-question-circle";

                                                    if ($row['status'] == 'PENDING') {
                                                        $color = "danger";
                                                        $icon = "fas fa-clock";
                                                    } else if ($row['status'] == 'INVESTIGATING') {
                                                        $color = "warning";
                                                        $icon = "fas fa-search";
                                                    } else if ($row['status'] == 'RESOLVED') {
                                                        $color = "success";
                                                        $icon = "fas fa-check-circle";
                                                    }

                                                    echo "<tr>";
                                                    echo "<td class='text-dark font-weight-bold'>" . htmlspecialchars($row['title']) . "</td>";
                                                    echo "<td class='text-muted'>" . date('M d, Y', strtotime($row['date'])) . "</td>";
                                                    echo "<td><span class='badge badge-" . $color . " badge-pill px-3 py-2'>" . ucfirst(strtolower($row['status'])) . "</span></td>";
                                                    echo "<td>
                                                        <a href='view.php?id=" . $row["id"] . "' class='btn btn-sm btn-outline-primary rounded-pill mr-2'>
                                                            <i class='fas fa-eye mr-1'></i> View
                                                        </a>
                                                        <button class='btn btn-sm btn-outline-secondary rounded-pill mr-2' onclick='shareIncident(" . $row["id"] . ")'>
                                                            <i class='fas fa-share-alt mr-1'></i> Share
                                                        </button>
                                                        <button class='btn btn-sm btn-outline-danger rounded-pill mr-2' onclick='deleteIncident(" . $row["id"] . ")'>
                                                            <i class='fas fa-trash mr-1'></i> Delete
                                                        </button>";

                                                    // FEEDBACK OR VIEW FEEDBACK BUTTON
                                                    if ($row['status'] == 'RESOLVED') {
                                                        // check if user already submitted feedback
                                                        $check_feedback = $conn->prepare("SELECT rating, improvements, comment 
                                                        FROM feedback 
                                                        WHERE incident_id = ? AND user_id = ?");
                                                        $check_feedback->bind_param("ii", $row["id"], $_SESSION['user_id']);
                                                        $check_feedback->execute();
                                                        $result_feedback = $check_feedback->get_result();

                                                        if ($result_feedback->num_rows > 0) {
                                                            // user already has feedback
                                                            $feedback = $result_feedback->fetch_assoc();
                                                            echo "<button class='btn btn-sm btn-outline-info rounded-pill'
                                                                data-toggle='modal' 
                                                                data-target='#viewFeedbackModal'
                                                                onclick='showFeedback(" . json_encode($feedback) . ")'>
                                                                <i class='fas fa-eye mr-1'></i> View Feedback
                                                            </button>";
                                                        } else {
                                                            // no feedback yet
                                                            echo "<button class='btn btn-sm btn-outline-success rounded-pill'
                                                                data-toggle='modal' 
                                                                data-target='#feedbackModal'
                                                                onclick='setIncidentId(" . $row["id"] . ")'>
                                                                <i class='fas fa-comment-dots mr-1'></i> Add Feedback
                                                            </button>";
                                                        }

                                                        $check_feedback->close();
                                                    }


                                                    echo "</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr>";
                                                echo "<td colspan='4' class='text-center py-5 px-4'>
                                                <div class='empty-state'>
                                                    <i class='fas fa-inbox fa-3x text-muted mb-3'></i>
                                                    <h5 class='text-muted'>No incidents reported yet</h5>
                                                    <p class='text-muted mb-3'>Get started by reporting your first security incident</p>
                                                    <a href='register.php' class='btn btn-primary'>
                                                        <i class='fas fa-plus mr-2'></i>Report First Incident
                                                    </a>
                                                </div>
                                              </td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- View Feedback Modal -->
                    <div class="modal fade" id="viewFeedbackModal" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-info text-white">
                                    <h5 class="modal-title">Your Feedback</h5>
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


                    <!-- Feedback Modal -->
                    <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content rounded-lg">
                                <div class="modal-header">
                                    <h5 class="modal-title"><i class="fas fa-comment-dots mr-2"></i>Submit Feedback</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span>&times;</span>
                                    </button>
                                </div>
                                <form id="feedbackForm" method="POST" action="">
                                    <div class="modal-body">
                                        <!-- Hidden Incident ID -->
                                        <input type="hidden" name="incident_id" id="feedback_incident_id">

                                        <!-- Star Rating -->
                                        <div class="mb-3">
                                            <label class="font-weight-bold">Rate our response:</label>
                                            <div class="rating mb-3">
                                                <span class="star" data-value="1">&#9733;</span>
                                                <span class="star" data-value="2">&#9733;</span>
                                                <span class="star" data-value="3">&#9733;</span>
                                                <span class="star" data-value="4">&#9733;</span>
                                                <span class="star" data-value="5">&#9733;</span>
                                            </div>
                                            <input type="hidden" name="rating" id="rating" required>
                                        </div>

                                        <!-- What Can Be Improved -->
                                        <div class="mb-3">
                                            <label class="font-weight-bold">What can be improved?</label><br>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="improvements[]" value="Resolution Speed">
                                                <label class="form-check-label">Resolution Speed</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="improvements[]" value="Data Privacy">
                                                <label class="form-check-label">Data Privacy</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="improvements[]" value="Transparency">
                                                <label class="form-check-label">Transparency</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="improvements[]" value="Response Time">
                                                <label class="form-check-label">Response Time</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="improvements[]" value="Accessibility">
                                                <label class="form-check-label">Accessibility</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="improvements[]" value="Polite Communication">
                                                <label class="form-check-label">Polite Communication</label>
                                            </div>
                                        </div>

                                        <style>
                                            .star {
                                                font-size: 2rem;
                                                cursor: pointer;
                                                color: #ccc;
                                            }

                                            .star.selected,
                                            .star.hover {
                                                color: gold;
                                            }
                                        </style>

                                        <!-- Comment -->
                                        <div class="mb-3">
                                            <label class="font-weight-bold">Your Comments</label>
                                            <textarea class="form-control" name="comment" rows="3" placeholder="Write your feedback..."></textarea>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Send Feedback</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                    <script>
                        function showFeedback(feedback) {
                            document.getElementById("viewRating").textContent = feedback.rating;
                            document.getElementById("viewImprovements").textContent = feedback.improvements || "None";
                            document.getElementById("viewComment").textContent = feedback.comment || "No comments provided.";
                        }

                        document.addEventListener("DOMContentLoaded", function() {
                            const stars = document.querySelectorAll(".star");
                            const ratingInput = document.getElementById("rating");
                            const feedbackForm = document.getElementById("feedbackForm");


                            stars.forEach(star => {
                                star.addEventListener("click", function() {
                                    let value = this.getAttribute("data-value");
                                    ratingInput.value = value;

                                    stars.forEach(s => s.classList.remove("selected"));
                                    for (let i = 0; i < value; i++) {
                                        stars[i].classList.add("selected");
                                    }
                                });
                            });

                            // block submit if no rating
                            feedbackForm.addEventListener("submit", function(e) {
                                if (!ratingInput.value) {
                                    e.preventDefault();
                                    alert("⚠️ Please select a star rating before submitting feedback.");
                                }
                            });
                        });

                        document.querySelectorAll('.star').forEach(star => {
                            star.addEventListener('click', function() {
                                let value = this.getAttribute('data-value');
                                document.getElementById('rating').value = value;

                                // reset stars
                                document.querySelectorAll('.star').forEach(s => s.classList.remove('selected'));

                                // highlight selected stars
                                for (let i = 0; i < value; i++) {
                                    document.querySelectorAll('.star')[i].classList.add('selected');
                                }
                            });

                            // Optional: hover effect
                            star.addEventListener('mouseover', function() {
                                let value = this.getAttribute('data-value');
                                document.querySelectorAll('.star').forEach((s, index) => {
                                    s.classList.toggle('hover', index < value);
                                });
                            });
                            star.addEventListener('mouseout', function() {
                                document.querySelectorAll('.star').forEach(s => s.classList.remove('hover'));
                            });
                        });


                        function setIncidentId(id) {
                            document.getElementById('feedback_incident_id').value = id;
                        }
                    </script>


                </section>

            </div>
            <!-- End of Main Content -->

            <!-- Custom Styles for Incidents Page -->


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

    <!-- Core JavaScript via CDN to avoid blocked /vendor assets -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="../../js/sb-admin-2.min.js"></script>

        <!-- Ensure Bootstrap 4 dropdowns are initialized -->
        <script>
            $(function () {
                $('.dropdown-toggle').dropdown();
            });
        </script>

        <script>
            // PDF Download Function
            function downloadPDF() {
                const element = document.getElementById('myDiv');
                const opt = {
                    margin: 1,
                    filename: 'incident-reports.pdf',
                    image: {
                        type: 'jpeg',
                        quality: 0.98
                    },
                    html2canvas: {
                        scale: 2
                    },
                    jsPDF: {
                        unit: 'in',
                        format: 'letter',
                        orientation: 'portrait'
                    }
                };

                // Use html2canvas for PDF generation
                html2canvas(element).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    // Create PDF (you'll need to include jsPDF library)
                    console.log('PDF generation triggered');
                    alert('PDF export functionality would be implemented here');
                });
            }

            // Share Incident Function
            function shareIncident(incidentId) {
                const url = window.location.origin + window.location.pathname.replace('index.php', 'view.php?id=' + incidentId);

                if (navigator.share) {
                    navigator.share({
                        title: 'Incident Report #' + incidentId,
                        text: 'Check out this incident report',
                        url: url
                    });
                } else {
                    // Fallback - copy to clipboard
                    navigator.clipboard.writeText(url).then(() => {
                        alert('Incident link copied to clipboard!');
                    }).catch(() => {
                        alert('Link: ' + url);
                    });
                }
            }

            // Delete Incident Function
            function deleteIncident(incidentId) {
                if (confirm('⚠️ Are you sure you want to delete this incident?\n\nNote: This will only remove it from your personal view. The incident will still be visible to administrators for security purposes.\n\nThis action cannot be undone.')) {
                    // Create a form and submit it
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '';
                    
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'delete_incident_id';
                    input.value = incidentId;
                    
                    form.appendChild(input);
                    document.body.appendChild(form);
                    form.submit();
                }
            }

            // Navigation active state
            $(document).ready(function() {
                // Remove active class from all nav links
                $('.navbar-nav .nav-link').removeClass('active');

                // Add active class to My Incidents link
                $('.navbar-nav .nav-link[href*="incident"]').addClass('active');

                // Add loading animation for table rows
                $('.incident-row').each(function(index) {
                    $(this).css({
                        'animation-delay': (index * 0.1) + 's',
                        'animation': 'fadeInUp 0.6s ease-out forwards'
                    });
                });
            });

            // Additional animation for incident rows
            const style = document.createElement('style');
            style.textContent = `
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
        `;
            document.head.appendChild(style);
        </script>

    <!-- Page level plugins -->
    <!-- Chart.js v2 for SB Admin 2 demo scripts compatibility -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="../../js/demo/chart-area-demo.js"></script>
        <script src="../../js/demo/chart-pie-demo.js"></script>
    <!-- DataTables JS (Bootstrap 4) -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>

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
}
