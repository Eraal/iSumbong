<?php
session_start();

/**
 * Check if user is logged in
 */
function logged_in(){
    if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
        return true;
    } else {
        return false;
    }
}

/**
 * Check if user has specific role
 */
function has_role($required_role){
    if(!logged_in()) {
        return false;
    }
    
    return isset($_SESSION['role']) && $_SESSION['role'] === $required_role;
}

/**
 * Check if user is admin
 */
function is_admin(){
    return has_role('admin');
}

/**
 * Check if user is regular user
 */
function is_user(){
    return has_role('user');
}

/**
 * Require login - redirect to login page if not logged in
 */
function require_login($redirect_url = '../../login.php'){
    if(!logged_in()) {
        header("Location: $redirect_url");
        exit();
    }
}

/**
 * Require admin role - redirect if not admin
 */
function require_admin($redirect_url = '../../403.php'){
    require_login();
    if(!is_admin()) {
        header("Location: $redirect_url");
        exit();
    }
}

/**
 * Require user role - redirect if not user
 */
function require_user($redirect_url = '../../403.php'){
    require_login();
    if(!is_user()) {
        header("Location: $redirect_url");
        exit();
    }
}

/**
 * Redirect if already logged in (for login/register pages)
 */
function login_redirect(){
    if(logged_in()){
        if(is_admin()) {
            header('Location: admin/dashboard/');
        } else {
            header('Location: user/dashboard/');
        }
        exit();
    }
}

/**
 * Get current user info
 */
function get_logged_user(){
    if(!logged_in()) {
        return null;
    }
    
    return [
        'user_id' => $_SESSION['user_id'],
        'name' => $_SESSION['name'] ?? 'Unknown',
        'email' => $_SESSION['email'] ?? '',
        'role' => $_SESSION['role'] ?? 'user',
        'image' => $_SESSION['image'] ?? null
    ];
}

/**
 * Check if user can access resource based on role
 */
function can_access($resource, $action = 'view'){
    if(!logged_in()) {
        return false;
    }
    
    $role = $_SESSION['role'];
    
    // Admin can access everything
    if($role === 'admin') {
        return true;
    }
    
    // Define user permissions
    $user_permissions = [
        'incidents' => ['create', 'view_own', 'edit_own'],
        'profile' => ['view_own', 'edit_own'],
        'dashboard' => ['view'],
        'settings' => ['view', 'edit_own']
    ];
    
    // Check if user has permission
    if(isset($user_permissions[$resource])) {
        return in_array($action, $user_permissions[$resource]) || in_array('*', $user_permissions[$resource]);
    }
    
    return false;
}

?>