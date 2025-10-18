<?php
include '../../connectMySql.php';
include '../../loginverification.php';

if(logged_in()){
    // Get filter parameters
    $status_filter = isset($_GET['status']) ? $_GET['status'] : '';
    $category_filter = isset($_GET['category']) ? $_GET['category'] : '';
    $date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
    $date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';
    $format = isset($_GET['format']) ? $_GET['format'] : 'csv';
    
    // Build WHERE clause for filters
    $whereConditions = [];
    if ($status_filter) $whereConditions[] = "i.status = '" . mysqli_real_escape_string($conn, $status_filter) . "'";
    if ($category_filter) $whereConditions[] = "i.category = '" . mysqli_real_escape_string($conn, $category_filter) . "'";
    if ($date_from) $whereConditions[] = "DATE(i.created_at) >= '" . mysqli_real_escape_string($conn, $date_from) . "'";
    if ($date_to) $whereConditions[] = "DATE(i.created_at) <= '" . mysqli_real_escape_string($conn, $date_to) . "'";
    
    $whereClause = !empty($whereConditions) ? 'WHERE ' . implode(' AND ', $whereConditions) : '';
    
    // Get reports with user information
    $query = "SELECT 
                i.id,
                i.title,
                i.category,
                i.status,
                i.date as incident_date,
                i.description,
                i.system_affected,
                i.severity_level,
                i.full_name,
                i.role,
                i.department,
                i.email,
                i.phone,
                i.estimated_impact,
                i.critical_infra,
                i.observed_impact,
                i.actions_taken,
                i.incident_contained,
                i.notified,
                i.additional_info,
                i.created_at,
                u.name as user_name,
                u.email as user_email
              FROM incident i 
              LEFT JOIN users u ON i.user_id = u.user_id 
              $whereClause 
              ORDER BY i.created_at DESC";
    
    $result = mysqli_query($conn, $query);
    
    if(!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
    
    // Store results in array since we may need to loop through them
    $reports = [];
    while($row = mysqli_fetch_assoc($result)) {
        $reports[] = $row;
    }
    
    // Set filename with timestamp
    $timestamp = date('Y-m-d_H-i-s');
    $filename = "incident_reports_$timestamp";
    
    if($format == 'excel' || $format == 'xlsx') {
        // Export as Excel-compatible HTML table
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '.xls"');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
        echo '<head>';
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
        echo '<meta name="ProgId" content="Excel.Sheet">';
        echo '<meta name="Generator" content="Microsoft Excel 11">';
        echo '<style>';
        echo 'table { mso-displayed-decimal-separator:"\."; mso-displayed-thousand-separator:"\,"; }';
        echo '.text { mso-number-format:"\@"; }';
        echo '.number { mso-number-format:"0"; }';
        echo '</style>';
        echo '</head>';
        echo '<body>';
        echo '<table border="1">';
        
        // Headers
        echo '<tr>';
        $headers = ['ID', 'Title', 'Category', 'Status', 'Reporter Name', 'Reporter Email', 'Role', 'Department', 'Phone', 'Incident Date', 'System Affected', 'Severity Level', 'Description', 'Estimated Impact', 'Critical Infrastructure', 'Observed Impact', 'Actions Taken', 'Incident Contained', 'Notified', 'Additional Info', 'Submitted Date'];
        foreach($headers as $header) {
            echo '<th>' . htmlspecialchars($header) . '</th>';
        }
        echo '</tr>';
        
        // Data rows
        foreach($reports as $row) {
            echo '<tr>';
            echo '<td class="number">' . htmlspecialchars($row['id']) . '</td>';
            echo '<td class="text">' . htmlspecialchars($row['title']) . '</td>';
            echo '<td class="text">' . htmlspecialchars($row['category']) . '</td>';
            echo '<td class="text">' . htmlspecialchars(ucfirst(str_replace('_', ' ', $row['status']))) . '</td>';
            echo '<td class="text">' . htmlspecialchars($row['full_name']) . '</td>';
            echo '<td class="text">' . htmlspecialchars($row['email']) . '</td>';
            echo '<td class="text">' . htmlspecialchars($row['role']) . '</td>';
            echo '<td class="text">' . htmlspecialchars($row['department']) . '</td>';
            echo '<td class="text">' . htmlspecialchars($row['phone']) . '</td>';
            echo '<td class="text">' . ($row['incident_date'] ? date('M j, Y g:i A', strtotime($row['incident_date'])) : 'Not specified') . '</td>';
            echo '<td class="text">' . htmlspecialchars($row['system_affected']) . '</td>';
            echo '<td class="text">' . htmlspecialchars($row['severity_level']) . '</td>';
            echo '<td class="text">' . htmlspecialchars($row['description']) . '</td>';
            echo '<td class="text">' . htmlspecialchars($row['estimated_impact']) . '</td>';
            echo '<td class="text">' . htmlspecialchars($row['critical_infra']) . '</td>';
            echo '<td class="text">' . htmlspecialchars($row['observed_impact']) . '</td>';
            echo '<td class="text">' . htmlspecialchars($row['actions_taken']) . '</td>';
            echo '<td class="text">' . htmlspecialchars($row['incident_contained']) . '</td>';
            echo '<td class="text">' . htmlspecialchars($row['notified']) . '</td>';
            echo '<td class="text">' . htmlspecialchars($row['additional_info']) . '</td>';
            echo '<td class="text">' . date('M j, Y g:i A', strtotime($row['created_at'])) . '</td>';
            echo '</tr>';
        }
        
        echo '</table>';
        echo '</body>';
        echo '</html>';
        
    } else {
        // Export as CSV (default)
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        $output = fopen('php://output', 'w');
        
        // CSV Headers
        fputcsv($output, [
            'ID',
            'Title',
            'Category',
            'Status',
            'Reporter Name',
            'Reporter Email',
            'Role',
            'Department',
            'Phone',
            'Incident Date',
            'System Affected',
            'Severity Level',
            'Description',
            'Estimated Impact',
            'Critical Infrastructure',
            'Observed Impact',
            'Actions Taken',
            'Incident Contained',
            'Notified',
            'Additional Info',
            'Submitted Date'
        ]);
        
        // CSV Data
        foreach($reports as $row) {
            fputcsv($output, [
                $row['id'],
                $row['title'],
                $row['category'],
                ucfirst(str_replace('_', ' ', $row['status'])),
                $row['full_name'],
                $row['email'],
                $row['role'],
                $row['department'],
                $row['phone'],
                $row['incident_date'] ? date('M j, Y g:i A', strtotime($row['incident_date'])) : 'Not specified',
                $row['system_affected'],
                $row['severity_level'],
                $row['description'],
                $row['estimated_impact'],
                $row['critical_infra'],
                $row['observed_impact'],
                $row['actions_taken'],
                $row['incident_contained'],
                $row['notified'],
                $row['additional_info'],
                date('M j, Y g:i A', strtotime($row['created_at']))
            ]);
        }
        
        fclose($output);
    }
    
} else {
    header('location:../../index.php');
}
?>
