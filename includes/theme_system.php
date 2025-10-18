<?php
// Global Theme System Include
// Include this file in all pages to enable theme functionality

// Handle theme saving via AJAX
if(isset($_POST['save_theme']) && $_POST['save_theme'] == '1') {
    $theme = $_POST['theme'];
    if($theme === 'light' || $theme === 'dark') {
        $_SESSION['theme'] = $theme;
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' => 'Theme saved successfully', 'theme' => $theme]);
        exit;
    } else {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Invalid theme']);
        exit;
    }
}

// Get current theme
function getCurrentTheme() {
    return isset($_SESSION['theme']) ? $_SESSION['theme'] : 'light';
}

// Get theme meta tag for JavaScript
function getThemeMeta() {
    $theme = getCurrentTheme();
    return '<meta name="session-theme" content="' . $theme . '">';
}

// Get theme CSS and JS includes
function getThemeIncludes($relativePath = '../') {
    return '
    <!-- Global Theme CSS -->
    <link href="' . $relativePath . 'css/theme.css" rel="stylesheet">
    
    <!-- Global Theme JavaScript -->
    <script src="' . $relativePath . 'js/theme.js"></script>
    ';
}
?>
