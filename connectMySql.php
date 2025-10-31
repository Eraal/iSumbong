<?php
// Prefer environment variables, with safe defaults for local dev
// Attempt to load .env if available
@require_once __DIR__ . '/includes/env_loader.php';
if (function_exists('loadEnv')) {
    $envLoaded = loadEnv(__DIR__ . '/.env');
}

// Database configuration (env first, then defaults)
$servername = $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?? 'localhost';
$username_server = $_ENV['DB_USER'] ?? getenv('DB_USER') ?? 'root';
$password_server = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ?? '';
// Default to lowercase 'isumbong' to match provided SQL dump
$db = $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?? 'isumbong';
$port = (int)($_ENV['DB_PORT'] ?? getenv('DB_PORT') ?? 3306); // Default MySQL port

// Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Create connection with port specification
    $conn = new mysqli($servername, $username_server, $password_server, $db, $port);
    
    // Set charset to UTF-8
    $conn->set_charset('utf8');
    
} catch (mysqli_sql_exception $e) {
    // More detailed error handling
    $error_message = "Database Connection Failed!<br><br>";
    $error_message .= "<strong>Error:</strong> " . $e->getMessage() . "<br>";
    $error_message .= "<strong>Error Code:</strong> " . $e->getCode() . "<br><br>";
    
    // Check common issues
    if (strpos($e->getMessage(), 'actively refused') !== false) {
        $error_message .= "<strong>Possible Solutions:</strong><br>";
        $error_message .= "1. Ensure MySQL service is running<br>";
        $error_message .= "2. Check if MySQL is running on port $port<br>";
        $error_message .= "3. Verify MySQL is properly installed<br>";
    } else if (strpos($e->getMessage(), 'Access denied') !== false) {
        $error_message .= "<strong>Possible Solutions:</strong><br>";
        $error_message .= "1. Check database username/password<br>";
        $error_message .= "2. Verify database '" . htmlspecialchars($db) . "' exists<br>";
    } else if (strpos($e->getMessage(), 'Unknown database') !== false) {
        $error_message .= "<strong>Solution:</strong> Create database '" . htmlspecialchars($db) . "' and import the SQL dump<br>";
    }
    
    // Display user-friendly error page
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Database Error</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 40px; }
            .error-box { 
                background: #f8d7da; 
                color: #721c24; 
                padding: 20px; 
                border: 1px solid #f5c6cb; 
                border-radius: 5px; 
                max-width: 600px; 
            }
            .btn { 
                display: inline-block; 
                padding: 10px 15px; 
                background: #007bff; 
                color: white; 
                text-decoration: none; 
                border-radius: 3px; 
                margin-top: 10px; 
            }
        </style>
    </head>
    <body>
        <div class='error-box'>
            <h2>🚨 " . $error_message . "</h2>
            <a href='test_database.php' class='btn'>Test Database Connection</a>
            <a href='javascript:history.back()' class='btn'>Go Back</a>
        </div>
    </body>
    </html>";
    
    exit;
}
?>