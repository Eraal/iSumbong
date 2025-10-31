<?php
include '../../connectMySql.php';
include '../../loginverification.php';

// Check if user is logged in as admin
if (!logged_in()) {
    echo json_encode([
        'success' => false,
        'error' => 'Not authenticated',
        'total' => 0,
        'new_incidents' => 0,
        'new_users' => 0,
        'spam_messages' => 0,
        'recent_incidents' => []
    ]);
    exit;
}

header('Content-Type: application/json');

try {
    // Handle marking notifications as read
    if (isset($_POST['mark_read']) && $_POST['mark_read'] == 'true') {
        // Store the timestamp when notifications were last read
        $read_time = date('Y-m-d H:i:s');
        
        // You can store this in session or a simple file
        session_start();
        $_SESSION['notifications_last_read'] = $read_time;
        
        echo json_encode([
            'success' => true,
            'message' => 'Notifications marked as read',
            'read_time' => $read_time
        ]);
        exit;
    }

    // Start session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    // Get the last read time (default to 24 hours ago to show recent items)
    $last_read_time = isset($_SESSION['notifications_last_read']) ? $_SESSION['notifications_last_read'] : date('Y-m-d H:i:s', strtotime('-24 hours'));
    
    // Get recent incidents (last 5) for notifications - exclude admin-hidden incidents
    $recent_incidents_query = "SELECT id, title, date, status FROM incident 
                              WHERE (deleted_by_admin IS NULL OR deleted_by_admin = 0)
                              ORDER BY date DESC LIMIT 5";
    $recent_incidents_result = mysqli_query($conn, $recent_incidents_query);
    $recent_incidents = [];
    $unread_count = 0;
    
    if ($recent_incidents_result) {
        while($row = mysqli_fetch_assoc($recent_incidents_result)) {
            $is_new = (strtotime($row['date']) > strtotime($last_read_time));
            $recent_incidents[] = [
                'id' => $row['id'],
                'title' => $row['title'],
                'created_at' => $row['date'],
                'status' => $row['status'],
                'is_new' => $is_new
            ];
            if ($is_new) {
                $unread_count++;
            }
        }
    }

    // Count pending incidents for additional info - exclude admin-hidden incidents
    $pending_query = "SELECT COUNT(*) as count FROM incident WHERE status = 'PENDING' AND (deleted_by_admin IS NULL OR deleted_by_admin = 0)";
    $pending_result = mysqli_query($conn, $pending_query);
    $pending_count = $pending_result ? mysqli_fetch_assoc($pending_result)['count'] : 0;

    // Count investigating incidents - exclude admin-hidden incidents
    $investigating_query = "SELECT COUNT(*) as count FROM incident WHERE status = 'INVESTIGATING' AND (deleted_by_admin IS NULL OR deleted_by_admin = 0)";
    $investigating_result = mysqli_query($conn, $investigating_query);
    $investigating_count = $investigating_result ? mysqli_fetch_assoc($investigating_result)['count'] : 0;

    // Total unread notifications (based on new incidents since last read)
    $total_notifications = $unread_count;

    // Calculate total notifications
    $total_notifications = $pending_count + $investigating_count;

    $response = [
        'success' => true,
        'total' => $total_notifications,
        'unread_count' => $unread_count,
        'pending_incidents' => $pending_count,
        'investigating_incidents' => $investigating_count,
        'recent_incidents' => $recent_incidents,
        'last_read_time' => $last_read_time
    ];

    echo json_encode($response);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'total' => 0,
        'pending_incidents' => 0,
        'investigating_incidents' => 0,
        'recent_incidents' => []
    ]);
}
?>