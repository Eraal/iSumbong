<?php
include '../../connectMySql.php';
include '../../loginverification.php';

// Set content type to JSON
header('Content-Type: application/json');

// Check if user is logged in
if (!logged_in()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Get POST data
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

// Validate input
if (empty($name) || empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email format']);
    exit;
}

// Check if email already exists
$check_query = "SELECT email FROM admin WHERE email = ?";
$check_stmt = $conn->prepare($check_query);
$check_stmt->bind_param("s", $email);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Email already exists']);
    exit;
}

// Insert new admin
$insert_query = "INSERT INTO admin (name, email, password, status) VALUES (?, ?, ?, 'ACTIVE')";
$insert_stmt = $conn->prepare($insert_query);
$insert_stmt->bind_param("sss", $name, $email, $password);

if ($insert_stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Administrator added successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add administrator: ' . $conn->error]);
}

$check_stmt->close();
$insert_stmt->close();
$conn->close();
?>
