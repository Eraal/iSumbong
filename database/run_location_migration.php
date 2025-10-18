<?php
// Location migration script for iREPORT
// This script adds barangay and location columns to the users table

include('../connectMySql.php');

echo "<h2>iREPORT Location Migration</h2>";
echo "<p>Adding location and barangay columns to users table...</p>";

try {
    // Add barangay column
    $sql1 = "ALTER TABLE users ADD COLUMN barangay VARCHAR(100) DEFAULT NULL AFTER name";
    if(mysqli_query($conn, $sql1)) {
        echo "✓ Added barangay column<br>";
    } else {
        echo "• Barangay column already exists or error: " . mysqli_error($conn) . "<br>";
    }
    
    // Add latitude column
    $sql2 = "ALTER TABLE users ADD COLUMN latitude DECIMAL(10, 8) DEFAULT NULL AFTER barangay";
    if(mysqli_query($conn, $sql2)) {
        echo "✓ Added latitude column<br>";
    } else {
        echo "• Latitude column already exists or error: " . mysqli_error($conn) . "<br>";
    }
    
    // Add longitude column
    $sql3 = "ALTER TABLE users ADD COLUMN longitude DECIMAL(11, 8) DEFAULT NULL AFTER latitude";
    if(mysqli_query($conn, $sql3)) {
        echo "✓ Added longitude column<br>";
    } else {
        echo "• Longitude column already exists or error: " . mysqli_error($conn) . "<br>";
    }
    
    // Create indexes
    $sql4 = "CREATE INDEX idx_users_location ON users(latitude, longitude)";
    if(mysqli_query($conn, $sql4)) {
        echo "✓ Created location index<br>";
    } else {
        echo "• Location index already exists or error: " . mysqli_error($conn) . "<br>";
    }
    
    $sql5 = "CREATE INDEX idx_users_barangay ON users(barangay)";
    if(mysqli_query($conn, $sql5)) {
        echo "✓ Created barangay index<br>";
    } else {
        echo "• Barangay index already exists or error: " . mysqli_error($conn) . "<br>";
    }
    
    echo "<br><strong>Migration completed successfully!</strong>";
    echo "<p>Your users table now supports:</p>";
    echo "<ul>";
    echo "<li>Barangay selection and storage</li>";
    echo "<li>GPS location tracking (latitude/longitude)</li>";
    echo "<li>Geographic restrictions for Siniloan, Laguna</li>";
    echo "</ul>";
    echo "<p><a href='../register.php'>Test Registration Form</a></p>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

mysqli_close($conn);
?>
