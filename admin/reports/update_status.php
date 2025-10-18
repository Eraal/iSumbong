<?php
// filepath: c:\xampp\htdocs\ireport\admin\reports\update_status.php
include '../../connectMySql.php';
include '../../loginverification.php';

if(logged_in() && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $report_id = $_POST['report_id'];
    $new_status = $_POST['new_status'];
    
    $query = "UPDATE incident SET status = '$new_status' WHERE id = '$report_id'";
    $result = mysqli_query($conn, $query);
    
    header('Content-Type: application/json');
    
    if($result) {
        echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update status']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
}
?>