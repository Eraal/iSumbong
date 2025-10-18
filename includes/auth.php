<?php
/**
 * General Access Protection
 * Include this file at the top of any page that requires login (both admin and user)
 */

include_once '../../connectMySql.php';
include_once '../../loginverification.php';

// Require login (any role)
require_login();

// Set general variables
$current_user = get_logged_user();
$user_role = $current_user['role'];
$is_admin = is_admin();
$is_regular_user = is_user();
?>
