<?php
include '../../includes/admin_auth.php';
include '../../includes/role_manager.php';
include '../../connectMySql.php';

// Handle role change requests
if ($_POST && isset($_POST['action'])) {
    $response = ['success' => false, 'message' => 'Unknown error'];
    
    switch ($_POST['action']) {
        case 'change_role':
            $user_id = intval($_POST['user_id']);
            $new_role = $_POST['new_role'];
            $old_role = get_user_role($user_id);
            
            if (change_user_role($user_id, $new_role)) {
                log_role_change($_SESSION['user_id'], $user_id, $old_role, $new_role);
                $response = ['success' => true, 'message' => 'Role updated successfully'];
            } else {
                $response = ['success' => false, 'message' => 'Failed to update role'];
            }
            break;
            
        case 'toggle_status':
            $user_id = intval($_POST['user_id']);
            $status = $_POST['status'];
            
            if (toggle_user_status($user_id, $status)) {
                $response = ['success' => true, 'message' => 'User status updated successfully'];
            } else {
                $response = ['success' => false, 'message' => 'Failed to update status'];
            }
            break;
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Get all users
$all_users = get_all_users();
$role_stats = get_role_stats();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>User Role Management - iSumbong</title>
    <link rel="icon" type="image/x-icon" href="../../img/logo1.png"/>

    <!-- Custom fonts for this template -->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Fallback CDN for Font Awesome in case local fonts fail to load -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include '../nav.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">User Role Management</h1>
                    </div>

                    <!-- Role Statistics -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Admins</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $role_stats['admin'] ?? 0; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-shield fa-2x text-gray-300"></i>
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
                                                Total Users</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $role_stats['user'] ?? 0; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Users DataTable -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">All Users</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Created</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($all_users as $user): ?>
                                        <tr>
                                            <td><?php echo $user['user_id']; ?></td>
                                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                                            <td>
                                                <span class="badge badge-<?php echo $user['role'] === 'admin' ? 'primary' : 'success'; ?>">
                                                    <?php echo ucfirst($user['role']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-<?php echo $user['status'] === 'ACTIVE' ? 'success' : 'secondary'; ?>">
                                                    <?php echo $user['status']; ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <h6 class="dropdown-header">Change Role:</h6>
                                                        <a class="dropdown-item" href="#" onclick="changeRole(<?php echo $user['user_id']; ?>, 'admin')">
                                                            <i class="fas fa-user-shield"></i> Make Admin
                                                        </a>
                                                        <a class="dropdown-item" href="#" onclick="changeRole(<?php echo $user['user_id']; ?>, 'user')">
                                                            <i class="fas fa-user"></i> Make User
                                                        </a>
                                                        <div class="dropdown-divider"></div>
                                                        <h6 class="dropdown-header">Status:</h6>
                                                        <a class="dropdown-item" href="#" onclick="toggleStatus(<?php echo $user['user_id']; ?>, 'ACTIVE')">
                                                            <i class="fas fa-check"></i> Activate
                                                        </a>
                                                        <a class="dropdown-item" href="#" onclick="toggleStatus(<?php echo $user['user_id']; ?>, 'INACTIVE')">
                                                            <i class="fas fa-ban"></i> Deactivate
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include '../footer.php'; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin-2.min.js"></script>
    <script src="../../js/sweetalert2.all.min.js"></script>

    <script>
        function changeRole(userId, newRole) {
            Swal.fire({
                title: 'Change User Role',
                text: `Are you sure you want to change this user's role to ${newRole}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `action=change_role&user_id=${userId}&new_role=${newRole}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Success!', data.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    });
                }
            });
        }

        function toggleStatus(userId, status) {
            const action = status === 'ACTIVE' ? 'activate' : 'deactivate';
            
            Swal.fire({
                title: `${action.charAt(0).toUpperCase() + action.slice(1)} User`,
                text: `Are you sure you want to ${action} this user?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: status === 'ACTIVE' ? '#28a745' : '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: `Yes, ${action}!`
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `action=toggle_status&user_id=${userId}&status=${status}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Success!', data.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    });
                }
            });
        }
    </script>

</body>

</html>
