<?php
session_start();

// Simple theme save endpoint
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['theme'])) {
    $theme = $_POST['theme'];
    
    if ($theme === 'light' || $theme === 'dark') {
        $_SESSION['theme'] = $theme;
        
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success', 
            'message' => 'Theme saved successfully',
            'theme' => $theme
        ]);
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'error', 
            'message' => 'Invalid theme'
        ]);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error', 
        'message' => 'Invalid request'
    ]);
}
?>
