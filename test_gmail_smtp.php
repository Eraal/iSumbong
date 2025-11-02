<?php
// Test Gmail SMTP Configuration
require_once 'PHPMailer/PHPMailerAutoload.php';
include('gmail_config.php');

// Optional query flags:
//  - ?debug=1   turn on verbose SMTP debug output
//  - ?check=1   run quick connectivity matrix to common SMTP hosts/ports
$debugMode = isset($_GET['debug']) && $_GET['debug'] === '1';
$runConnectivityMatrix = isset($_GET['check']) && $_GET['check'] === '1';

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

// Connectivity matrix against common SMTP providers/ports (lightweight TCP check)
function smtp_connectivity_matrix() {
    $providers = [
        SMTP_HOST,
        'smtp.gmail.com',
        'smtp.sendgrid.net',
        'smtp.mailgun.org',
    ];
    $ports = [587, 465, 25, 2525];
    $rows = [];
    foreach ($providers as $host) {
        $host = trim($host);
        if ($host === '') continue;
        $row = ['host' => $host, 'results' => []];
        foreach ($ports as $p) {
            list($ok, $msg) = smtp_preflight($host, $p, 3);
            $row['results'][$p] = $ok ? 'OK' : 'BLOCKED';
        }
        $rows[] = $row;
    }
    return $rows;
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
        // If TLS handshake fails due to cert validation or SSL inspection, allow relaxed SSL when enabled
        if ((function_exists('env') ? env('SMTP_RELAX_SSL', '0') : getenv('SMTP_RELAX_SSL')) === '1') {
            $existing = is_array($mail->SMTPOptions) ? $mail->SMTPOptions : [];
            $existing['ssl'] = array_merge($existing['ssl'] ?? [], [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ]);
            if (defined('STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT')) {
                $existing['ssl']['crypto_method'] = STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT;
            }
            $mail->SMTPOptions = $existing;
        }
        // Toggle verbose SMTP debug
        // If either URL debug=1 or .env SMTP_DEBUG_LOG=1 is set, enable verbose and write to logs/mail.log
        $debugToFile = (function_exists('env') ? env('SMTP_DEBUG_LOG', '0') : getenv('SMTP_DEBUG_LOG')) === '1';
        if ($debugMode || $debugToFile) {
            $mail->SMTPDebug = 2; // client/server conversation
            $mail->Debugoutput = function ($str, $level) {
                $logDir = __DIR__ . DIRECTORY_SEPARATOR . 'logs';
                if (!is_dir($logDir)) {
                    @mkdir($logDir, 0775, true);
                }
                $file = $logDir . DIRECTORY_SEPARATOR . 'mail.log';
                @file_put_contents($file, '[' . date('Y-m-d H:i:s') . "] [level=$level] " . $str . "\n", FILE_APPEND);
            };
        } else {
            $mail->SMTPDebug = 0;
        }
        
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
        // Helpful hint for SendGrid auth
        if (stripos(SMTP_HOST, 'sendgrid.net') !== false && strtolower(SMTP_USERNAME) !== 'apikey') {
            echo "<div style='margin-top:8px;padding:10px;border:1px solid #ffeeba;background:#fff3cd;border-radius:6px;color:#856404'>"
               . "Hint: When using SendGrid SMTP, set SMTP_USERNAME to 'apikey' and SMTP_PASSWORD to your SendGrid API key." 
               . "</div>";
        }
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
    <?php if ($runConnectivityMatrix): ?>
        <div class="warning">
            <strong>Connectivity Matrix (TCP connect, 3s timeout):</strong>
            <div style="overflow:auto">
                <table style="border-collapse:collapse; width:100%">
                    <thead>
                        <tr>
                            <th style="border:1px solid #ddd; padding:6px; text-align:left">Host</th>
                            <?php foreach ([587,465,25,2525] as $p): ?>
                                <th style="border:1px solid #ddd; padding:6px; text-align:center">Port <?php echo $p; ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (smtp_connectivity_matrix() as $row): ?>
                            <tr>
                                <td style="border:1px solid #ddd; padding:6px;"><code><?php echo htmlspecialchars($row['host']); ?></code></td>
                                <?php foreach ([587,465,25,2525] as $p): $val = $row['results'][$p]; ?>
                                    <td style="border:1px solid #ddd; padding:6px; text-align:center; color: <?php echo $val==='OK'?'#155724':'#721c24'; ?>; background: <?php echo $val==='OK'?'#d4edda':'#f8d7da'; ?>;">
                                        <?php echo $val; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div style="margin-top:8px; font-size: 0.9em; color:#6c757d;">
                Tip: Many providers block 25/465/587 by default. Port 2525 is often open for services like SendGrid/Mailgun.
            </div>
        </div>
    <?php endif; ?>
    
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
        Tips: Append <code>?debug=1</code> for verbose SMTP debug, or <code>?check=1</code> to run a quick connectivity matrix.
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
