<?php
// Simple DB connectivity test
// Remove this file after verification in production

require_once __DIR__ . '/connectMySql.php';

header('Content-Type: text/plain');

echo "DB connection OK\n";

try {
    $res = $conn->query('SHOW TABLES');
    $tables = [];
    while ($row = $res->fetch_array()) {
        $tables[] = $row[0];
    }
    echo "Tables (" . count($tables) . "):\n";
    foreach ($tables as $t) {
        echo " - $t\n";
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo "Error: " . $e->getMessage() . "\n";
}
