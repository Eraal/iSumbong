<?php
/**
 * User Access Protection
 * Include this file at the top of user-only pages
 */

include_once '../../connectMySql.php';
include_once '../../loginverification.php';

// Require user access (regular users only)
require_user();

// Optional: Set user-specific variables
$current_user = get_logged_user();
$is_user_page = true;
?>
