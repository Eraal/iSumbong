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

    <title>iReport - Category Management</title>
    <link rel="icon" type="image/x-icon" href="../../img/logo1.jpg" />
    <link rel="icon" type="image/png" sizes="32x32" href="../../img/logo1.jpg">
    <link rel="icon" type="image/png" sizes="16x16" href="../../img/logo1.jpg">
    <link rel="apple-touch-icon" sizes="180x180" href="../../img/logo1.jpg">
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
    <script src='../../js/sweetalert2.all.min.js'></script>
    
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
        
        /* Custom styles for suggestion column */
        .suggestion-cell {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: pointer;
        }
        
        .suggestion-cell:hover {
            background-color: #f8f9fa;
        }
        
        /* Tooltip styling */
        .tooltip-inner {
            max-width: 400px;
            text-align: left;
            white-space: pre-wrap;
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
                        <h1 class="h3 mb-0 text-gray-800">Category</h1>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCategoryModal">
                            <i class="fas fa-plus me-2"></i>Add Category
                        </button>
                    </div>

                    <!-- Content Row -->
                        <div class="card shadow-sm mb-4" style="border-radius: 1rem;">
                            <div class="card-header py-3 bg-white" style="border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                                <h6 class="m-0 font-weight-bold text-primary">Category Suggestions</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <table class="table table-hover align-middle" id="dataTable" width="100%" cellspacing="0" style="border-radius: 0.75rem; overflow: hidden;">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="text-secondary text-uppercase small">Name</th>
                                        <th class="text-secondary text-uppercase small">Suggestion</th>
                                        <th class="text-secondary text-uppercase small">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $query = "SELECT * FROM incident_type ORDER BY id DESC";
                                    $result = $conn->query($query);
                                    while ($row = $result->fetch_assoc()) {
                                        $shortSuggestion = strlen($row['suggestion']) > 50 ? substr($row['suggestion'], 0, 50) . '...' : $row['suggestion'];
                                        echo "<tr>";
                                        echo "<td class='text-dark font-weight-bold'>" . htmlspecialchars($row['name']) . "</td>";
                                        echo "<td class='text-muted suggestion-cell' title='" . htmlspecialchars($row['suggestion']) . "' data-toggle='tooltip' data-placement='top' data-html='true'>" . htmlspecialchars($shortSuggestion) . "</td>";
                                        echo "<td style='white-space: nowrap;'>
                                                <button class='btn btn-sm btn-outline-info view-category' data-id='" . $row['id'] . "' data-name='" . htmlspecialchars($row['name']) . "' data-suggestion='" . htmlspecialchars($row['suggestion']) . "'>
                                                    <i class='fas fa-eye'></i> View
                                                </button>
                                                <button class='btn btn-sm btn-outline-primary edit-category ml-1' data-id='" . $row['id'] . "' data-name='" . htmlspecialchars($row['name']) . "' data-suggestion='" . htmlspecialchars($row['suggestion']) . "'>
                                                    <i class='fas fa-edit'></i> Edit
                                                </button>
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
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
            <?php include'../footer.php';?>

    </div>
    <!-- End of Page Wrapper -->

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addCategoryForm" method="POST" action="add.php">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="categoryName">Category Name</label>
                            <input type="text" class="form-control" id="categoryName" name="name" required placeholder="Enter category name">
                        </div>
                        <div class="form-group">
                            <label for="categorySuggestion">Suggestion</label>
                            <textarea class="form-control" id="categorySuggestion" name="suggestion" rows="4" required placeholder="Enter suggestion for this category"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Category Modal -->
    <div class="modal fade" id="viewCategoryModal" tabindex="-1" role="dialog" aria-labelledby="viewCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewCategoryModalLabel">View Category</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label><strong>Category Name:</strong></label>
                        <p id="viewCategoryName" class="form-control-plaintext"></p>
                    </div>
                    <div class="form-group">
                        <label><strong>Suggestion:</strong></label>
                        <p id="viewCategorySuggestion" class="form-control-plaintext"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editCategoryForm" method="POST">
                    <div class="modal-body">
                        <input type="hidden" id="editCategoryId" name="id">
                        <div class="form-group">
                            <label for="editCategoryName">Category Name</label>
                            <input type="text" class="form-control" id="editCategoryName" name="name" required placeholder="Enter category name">
                        </div>
                        <div class="form-group">
                            <label for="editCategorySuggestion">Suggestion</label>
                            <textarea class="form-control" id="editCategorySuggestion" name="suggestion" rows="4" required placeholder="Enter suggestion for this category"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../../js/sb-admin-2.min.js"></script>
    <script src="../../vendor/chart.js/Chart.min.js"></script>
    <script src="../../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script>
      $(function () {
        $("#dataTable").DataTable({
         "createdRow": function(row, data, dataIndex) {
            $('td', row).css('white-space', 'nowrap');
        }
            });
        });

        $(document).ready(function() {
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
            
            // Re-initialize tooltips after DataTable draws
            $('#dataTable').on('draw.dt', function() {
                $('[data-toggle="tooltip"]').tooltip();
            });
            // Handle Add Category Form
            $("#addCategoryForm").on("submit", function(e) {
                e.preventDefault();
                
                var formData = {
                    name: $("#categoryName").val(),
                    suggestion: $("#categorySuggestion").val()
                };
                
                $.ajax({
                    type: 'POST',
                    url: 'add.php',
                    data: formData,
                    success: function(response) {
                        $("#addCategoryModal").modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Category Added Successfully',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = "index.php";
                        });
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to add category. Please try again.',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            // Handle View Category
            $(document).on("click", ".view-category", function() {
                var categoryName = $(this).data("name");
                var categorySuggestion = $(this).data("suggestion");
                
                $("#viewCategoryName").text(categoryName);
                $("#viewCategorySuggestion").text(categorySuggestion);
                $("#viewCategoryModal").modal('show');
            });

            // Handle Edit Category
            $(document).on("click", ".edit-category", function() {
                var categoryId = $(this).data("id");
                var categoryName = $(this).data("name");
                var categorySuggestion = $(this).data("suggestion");
                
                $("#editCategoryId").val(categoryId);
                $("#editCategoryName").val(categoryName);
                $("#editCategorySuggestion").val(categorySuggestion);
                $("#editCategoryModal").modal('show');
            });

            // Handle Edit Category Form
            $("#editCategoryForm").on("submit", function(e) {
                e.preventDefault();
                
                var formData = {
                    id: $("#editCategoryId").val(),
                    name: $("#editCategoryName").val(),
                    suggestion: $("#editCategorySuggestion").val()
                };
                
                $.ajax({
                    type: 'POST',
                    url: 'edit.php',
                    data: formData,
                    success: function(response) {
                        $("#editCategoryModal").modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Category Updated Successfully',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = "index.php";
                        });
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to update category. Please try again.',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            // Handle Delete functionality (if needed in future)
            $(".delete_user").on("click", function() {
                  var dataId = $(this).data("id");
                  Swal.fire({
                      title: "Are you sure you want to delete this category?",
                      showDenyButton: true,
                      confirmButtonText: "Proceed",
                      denyButtonText: `Cancel`
                    }).then((result) => {
                      if (result.isConfirmed) {
                       $.ajax({
                            type: 'GET',
                            url: 'delete.php',
                            data: { id: dataId }, 
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted Successfully',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.href = "index.php";
                                });
                            },
                            error: function (xhr, status, error) {
                                  console.error('Error deleting category:', error);
                                }
                        });
                      } 
                    });
            });

            // Clear forms when modals are closed
            $('#addCategoryModal').on('hidden.bs.modal', function () {
                $('#addCategoryForm')[0].reset();
            });
            
            $('#editCategoryModal').on('hidden.bs.modal', function () {
                $('#editCategoryForm')[0].reset();
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
}?>