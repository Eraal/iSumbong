<?php
/**
 * Admin Access Protection
 * Include this file at the top of admin-only pages
 */

include_once '../../connectMySql.php';
include_once '../../loginverification.php';

// Require admin access
require_admin();

// Optional: Set admin-specific variables
$current_user = get_logged_user();
$is_admin_page = true;
?>
