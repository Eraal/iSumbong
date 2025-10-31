<?php
// Test Gmail SMTP Configuration
require_once 'PHPMailer/PHPMailerAutoload.php';
include('gmail_config.php');

// Optional query flag to turn on verbose SMTP debug output: ?debug=1
$debugMode = isset($_GET['debug']) && $_GET['debug'] === '1';

// Connectivity pre-check (fast) to avoid long hangs
function smtp_preflight($host, $port, $timeout = 5) {
    $ip = gethostbyname($host);
    $start = microtime(true);
    $errno = 0; $errstr = '';
    $fp = @stream_socket_client("tcp://{$host}:{$port}", $errno, $errstr, $timeout);
    $ms = (int) round((microtime(true) - $start) * 1000);
    if ($fp) {
        fclose($fp);
        return [true, "Connectivity OK ({$host} -> {$ip}:{$port} in {$ms}ms)"];
    }
    return [false, "Connectivity FAILED ({$host}:{$port}) in {$ms}ms | errno={$errno} errstr={$errstr}"];
}

if(isset($_POST['test_email'])) {
    $test_email = $_POST['test_email'];

    // Preflight check
    list($ok, $msg) = smtp_preflight(SMTP_HOST, SMTP_PORT, 5);
    echo "<div class='precheck' style='margin:10px 0;padding:10px;border:1px solid #ddd;border-radius:6px;'>" . htmlspecialchars($msg) . "</div>";
    if (!$ok) {
        echo "<div style='color:#721c24;background:#f8d7da;border:1px solid #f5c6cb;padding:10px;border-radius:6px;'>Outbound SMTP connectivity appears blocked or failing. Check firewall (ufw), provider egress, or DNS.</div>";
    }
    
    $mail = new PHPMailer();
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME;
        $mail->Password = SMTP_PASSWORD;
        $mail->SMTPSecure = SMTP_ENCRYPTION;
        $mail->Port = SMTP_PORT;
        $mail->CharSet = 'UTF-8';
        // Avoid long hangs
        $mail->Timeout = 15;          // Socket timeout seconds
        $mail->SMTPKeepAlive = false; // No persistent connections
        // Force IPv4 if requested
        if ((function_exists('env') ? env('SMTP_FORCE_IPV4', '0') : getenv('SMTP_FORCE_IPV4')) === '1') {
            $resolved = gethostbyname(SMTP_HOST);
            if (!empty($resolved) && $resolved !== SMTP_HOST) {
                $mail->Host = $resolved; // use IPv4 address
            }
            $mail->SMTPOptions = [
                'socket' => [
                    'bindto' => '0.0.0.0:0',
                    'tcp_nodelay' => true,
                ]
            ];
        }
        // Toggle verbose SMTP debug only when requested
        $mail->SMTPDebug = $debugMode ? 2 : 0;
        
        // Recipients
        $mail->setFrom(FROM_EMAIL, FROM_NAME);
        $mail->addAddress($test_email);
        $mail->addReplyTo(REPLY_TO_EMAIL ?: FROM_EMAIL, FROM_NAME);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'iSUMBONG Gmail SMTP Test';
        $mail->Body = '<h2>Gmail SMTP Test Successful!</h2><p>Your Gmail SMTP configuration is working correctly.</p>';

        $t0 = microtime(true);
        if($mail->send()) {
            $ms = (int) round((microtime(true) - $t0) * 1000);
            echo "<div style='color: green; font-weight: bold;'>✅ Test email sent successfully in {$ms}ms!</div>";
        }
        
    } catch (Exception $e) {
        echo "<div style='color: red; font-weight: bold;'>❌ Email failed: " . htmlspecialchars($mail->ErrorInfo) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gmail SMTP Test - iSUMBONG</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        input[type="email"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        button { background: #4e73df; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #224abe; }
        .warning { background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h2>🛡️ iSUMBONG - Gmail SMTP Test</h2>
    
    <div class="warning">
        <strong>⚠️ Before testing:</strong><br>
        1. Update <code>gmail_config.php</code> with your Gmail credentials<br>
        2. Enable 2-Step Verification on your Gmail account<br>
        3. Generate an App Password for this application<br>
        <br>
        <strong>Current configuration:</strong><br>
        SMTP Host: <?php echo SMTP_HOST; ?><br>
        SMTP Username: <?php echo SMTP_USERNAME; ?><br>
        From Email: <?php echo FROM_EMAIL; ?>
        <br><br>
        Tip: Append <code>?debug=1</code> to this URL for verbose SMTP debug.
    </div>
    
    <form method="POST">
        <div class="form-group">
            <label for="test_email">Test Email Address:</label>
            <input type="email" id="test_email" name="test_email" placeholder="Enter email to test" required>
        </div>
        <button type="submit">Send Test Email</button>
    </form>
    
    <h3>Setup Instructions:</h3>
    <ol>
        <li>Open <code>gmail_config.php</code></li>
        <li>Replace <code>your-email@gmail.com</code> with your actual Gmail address</li>
        <li>Replace <code>your-app-password</code> with your Gmail App Password</li>
        <li>Test by sending an email above</li>
        <li>Once working, test registration on the main site</li>
    </ol>
    
    <p><a href="register.php">← Back to Registration</a></p>
</body>
</html>
