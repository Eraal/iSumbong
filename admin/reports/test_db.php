<?php
// Test script to verify database fields and structure
include '../../connectMySql.php';

// Test query to get all fields from incident table
$query = "SELECT * FROM incident LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result) {
    $fields = mysqli_fetch_fields($result);
    echo "<h3>Available fields in incident table:</h3>";
    echo "<ul>";
    foreach($fields as $field) {
        echo "<li>" . $field->name . " (" . $field->type . ")</li>";
    }
    echo "</ul>";
} else {
    echo "Error: " . mysqli_error($conn);
}

// Test query to get categories
$query = "SELECT * FROM category";
$result = mysqli_query($conn, $query);

if ($result) {
    echo "<h3>Available categories:</h3>";
    echo "<ul>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<li>" . $row['name'] . "</li>";
    }
    echo "</ul>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
