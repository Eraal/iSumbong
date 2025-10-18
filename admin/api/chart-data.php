<?php
include '../../connectMySql.php';
include '../../loginverification.php';

// Check if user is logged in
if (!logged_in()) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Set content type to JSON
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'monthly':
        getMonthlyIncidentData($conn);
        break;
    case 'category':
        getCategoryDistribution($conn);
        break;
    case 'status':
        getStatusDistribution($conn);
        break;
    case 'severity':
        getSeverityDistribution($conn);
        break;
    default:
        http_response_code(400);
        echo json_encode(['error' => 'Invalid action']);
        break;
}

function getMonthlyIncidentData($conn) {
    $currentYear = date('Y');
    
    // Initialize array with all months
    $monthlyData = array_fill(1, 12, 0);
    
    $query = "SELECT MONTH(created_at) as month, COUNT(*) as count 
              FROM incident 
              WHERE YEAR(created_at) = ? 
              GROUP BY MONTH(created_at)";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $currentYear);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $monthlyData[(int)$row['month']] = (int)$row['count'];
    }
    
    $response = [
        'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        'data' => array_values($monthlyData),
        'year' => $currentYear
    ];
    
    echo json_encode($response);
}

function getCategoryDistribution($conn) {
    $query = "SELECT category, COUNT(*) as count 
              FROM incident 
              GROUP BY category 
              ORDER BY count DESC";
    
    $result = $conn->query($query);
    
    $labels = [];
    $data = [];
    $colors = ['#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#5a5c69', '#858796'];
    $colorIndex = 0;
    
    while ($row = $result->fetch_assoc()) {
        $labels[] = ucfirst($row['category']);
        $data[] = (int)$row['count'];
    }
    
    $response = [
        'labels' => $labels,
        'data' => $data,
        'colors' => array_slice($colors, 0, count($labels))
    ];
    
    echo json_encode($response);
}

function getStatusDistribution($conn) {
    $query = "SELECT status, COUNT(*) as count 
              FROM incident 
              GROUP BY status 
              ORDER BY 
                CASE status 
                    WHEN 'PENDING' THEN 1 
                    WHEN 'INVESTIGATING' THEN 2 
                    WHEN 'RESOLVED' THEN 3 
                    ELSE 4 
                END";
    
    $result = $conn->query($query);
    
    $labels = [];
    $data = [];
    $colors = [];
    
    while ($row = $result->fetch_assoc()) {
        $status = $row['status'];
        $labels[] = ucfirst(strtolower($status));
        $data[] = (int)$row['count'];
        
        // Assign colors based on status
        switch ($status) {
            case 'PENDING':
                $colors[] = '#f6c23e';
                break;
            case 'INVESTIGATING':
                $colors[] = '#36b9cc';
                break;
            case 'RESOLVED':
                $colors[] = '#1cc88a';
                break;
            default:
                $colors[] = '#5a5c69';
                break;
        }
    }
    
    $response = [
        'labels' => $labels,
        'data' => $data,
        'colors' => $colors
    ];
    
    echo json_encode($response);
}

function getSeverityDistribution($conn) {
    $query = "SELECT severity_level, COUNT(*) as count 
              FROM incident 
              GROUP BY severity_level 
              ORDER BY 
                CASE severity_level 
                    WHEN 'Critical' THEN 1 
                    WHEN 'High' THEN 2 
                    WHEN 'Medium' THEN 3 
                    WHEN 'Low' THEN 4 
                    ELSE 5 
                END";
    
    $result = $conn->query($query);
    
    $labels = [];
    $data = [];
    $colors = [];
    
    while ($row = $result->fetch_assoc()) {
        $severity = $row['severity_level'];
        $labels[] = ucfirst($severity);
        $data[] = (int)$row['count'];
        
        // Assign colors based on severity
        switch (strtolower($severity)) {
            case 'critical':
                $colors[] = '#e74a3b';
                break;
            case 'high':
                $colors[] = '#fd7e14';
                break;
            case 'medium':
                $colors[] = '#f6c23e';
                break;
            case 'low':
                $colors[] = '#1cc88a';
                break;
            default:
                $colors[] = '#5a5c69';
                break;
        }
    }
    
    $response = [
        'labels' => $labels,
        'data' => $data,
        'colors' => $colors
    ];
    
    echo json_encode($response);
}
?>
