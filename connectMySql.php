<?php
// Database configuration
$servername = "localhost";
$username_server = "root";
$password_server = "";
$db = "iSUMBONG";
$port = 3306; // Default MySQL port

// Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Create connection with port specification
    $conn = new mysqli($servername, $username_server, $password_server, $db, $port);
    
    // Set charset to UTF-8
    $conn->set_charset("utf8");
    
} catch (mysqli_sql_exception $e) {
    // More detailed error handling
    $error_message = "Database Connection Failed!<br><br>";
    $error_message .= "<strong>Error:</strong> " . $e->getMessage() . "<br>";
    $error_message .= "<strong>Error Code:</strong> " . $e->getCode() . "<br><br>";
    
    // Check common issues
    if (strpos($e->getMessage(), 'actively refused') !== false) {
        $error_message .= "<strong>Possible Solutions:</strong><br>";
        $error_message .= "1. Start XAMPP MySQL service<br>";
        $error_message .= "2. Check if MySQL is running on port 3306<br>";
        $error_message .= "3. Verify XAMPP is properly installed<br>";
    } else if (strpos($e->getMessage(), 'Access denied') !== false) {
        $error_message .= "<strong>Possible Solutions:</strong><br>";
        $error_message .= "1. Check database username/password<br>";
        $error_message .= "2. Verify database 'iSUMBONG' exists<br>";
    } else if (strpos($e->getMessage(), 'Unknown database') !== false) {
        $error_message .= "<strong>Solution:</strong> Create database 'iSUMBONG' in phpMyAdmin<br>";
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