<?php
include '../../connectMySql.php';
$user_id = $_GET['id'] ?? null; 

if ($user_id) {
    $sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "No book ID provided";
}

?>