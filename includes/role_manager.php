<?php
/**
 * Role Management Functions for iReport
 * Functions to manage user roles and permissions
 */

require_once 'connectMySql.php';

/**
 * Get all users with their roles
 */
function get_all_users() {
    global $conn;
    $sql = "SELECT user_id, name, email, role, status, created_at FROM users ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Get users by role
 */
function get_users_by_role($role) {
    global $conn;
    $sql = "SELECT user_id, name, email, role, status, created_at FROM users WHERE role = ? ORDER BY created_at DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $role);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Change user role
 */
function change_user_role($user_id, $new_role) {
    global $conn;
    
    // Validate role
    if (!in_array($new_role, ['user', 'admin'])) {
        return false;
    }
    
    $sql = "UPDATE users SET role = ? WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $new_role, $user_id);
    
    return mysqli_stmt_execute($stmt);
}

/**
 * Get user role by user_id
 */
function get_user_role($user_id) {
    global $conn;
    $sql = "SELECT role FROM users WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    
    return $row ? $row['role'] : null;
}

/**
 * Check if user can perform action on resource
 */
function user_can_access($user_id, $resource, $action = 'view') {
    $role = get_user_role($user_id);
    
    if (!$role) {
        return false;
    }
    
    // Admin can do everything
    if ($role === 'admin') {
        return true;
    }
    
    // Define permissions for regular users
    $permissions = [
        'incidents' => ['create', 'view_own', 'edit_own'],
        'profile' => ['view_own', 'edit_own'],
        'dashboard' => ['view'],
        'settings' => ['view', 'edit_own']
    ];
    
    if (isset($permissions[$resource])) {
        return in_array($action, $permissions[$resource]);
    }
    
    return false;
}

/**
 * Get role statistics
 */
function get_role_stats() {
    global $conn;
    $sql = "SELECT role, COUNT(*) as count FROM users WHERE status = 'ACTIVE' GROUP BY role";
    $result = mysqli_query($conn, $sql);
    $stats = [];
    
    while ($row = mysqli_fetch_assoc($result)) {
        $stats[$row['role']] = $row['count'];
    }
    
    return $stats;
}

/**
 * Create new user with role
 */
function create_user_with_role($name, $email, $password, $role = 'user') {
    global $conn;
    
    // Validate role
    if (!in_array($role, ['user', 'admin'])) {
        return false;
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // For admins, auto-verify email
    $is_verified = ($role === 'admin') ? 1 : 0;
    
    $sql = "INSERT INTO users (name, email, password, role, is_verified, status, created_at) VALUES (?, ?, ?, ?, ?, 'ACTIVE', NOW())";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssi", $name, $email, $hashed_password, $role, $is_verified);
    
    if (mysqli_stmt_execute($stmt)) {
        return mysqli_insert_id($conn);
    }
    
    return false;
}

/**
 * Disable/Enable user
 */
function toggle_user_status($user_id, $status = 'ACTIVE') {
    global $conn;
    
    // Validate status
    if (!in_array($status, ['ACTIVE', 'INACTIVE'])) {
        return false;
    }
    
    $sql = "UPDATE users SET status = ? WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $status, $user_id);
    
    return mysqli_stmt_execute($stmt);
}

/**
 * Log role changes for audit
 */
function log_role_change($admin_id, $target_user_id, $old_role, $new_role) {
    global $conn;
    
    $sql = "INSERT INTO role_changes_log (admin_id, target_user_id, old_role, new_role, changed_at) VALUES (?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iiss", $admin_id, $target_user_id, $old_role, $new_role);
        mysqli_stmt_execute($stmt);
    }
}
?>
