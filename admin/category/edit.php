<?php
include '../../connectMySql.php';
include '../../loginverification.php';

if (logged_in() && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $suggestion = $_POST['suggestion'];
    
    // Sanitize inputs
    $id = mysqli_real_escape_string($conn, $id);
    $name = mysqli_real_escape_string($conn, $name);
    $suggestion = mysqli_real_escape_string($conn, $suggestion);
    
    // Update query
    $query = "UPDATE incident_type SET name = '$name', suggestion = '$suggestion' WHERE id = '$id'";
    
    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success', 'message' => 'Category updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update category']);
    }
} else {
    header('location:../../index.php');
}
?>
