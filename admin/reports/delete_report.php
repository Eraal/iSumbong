<?php
// filepath: c:\xampp\htdocs\ireport\admin\reports\delete_report.php
include '../../connectMySql.php';
include '../../loginverification.php';

if(logged_in() && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $report_id = $_POST['report_id'];
    
    $query = "DELETE FROM incident WHERE id = '$report_id'";
    $result = mysqli_query($conn, $query);
    
    header('Content-Type: application/json');
    
    if($result) {
        echo json_encode(['success' => true, 'message' => 'Report deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete report']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
}
?>