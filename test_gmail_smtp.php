<?php
// Test Gmail SMTP Configuration
require_once 'PHPMailer/PHPMailerAutoload.php';
include('gmail_config.php');

if(isset($_POST['test_email'])) {
    $test_email = $_POST['test_email'];
    
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
        
        // Enable debugging for testing
        $mail->SMTPDebug = 2;
        
        // Recipients
        $mail->setFrom(FROM_EMAIL, FROM_NAME);
        $mail->addAddress($test_email);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'iREPORT Gmail SMTP Test';
        $mail->Body = '<h2>Gmail SMTP Test Successful!</h2><p>Your Gmail SMTP configuration is working correctly.</p>';
        
        if($mail->send()) {
            echo "<div style='color: green; font-weight: bold;'>✅ Test email sent successfully!</div>";
        }
        
    } catch (Exception $e) {
        echo "<div style='color: red; font-weight: bold;'>❌ Email failed: " . $mail->ErrorInfo . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gmail SMTP Test - iREPORT</title>
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
    <h2>🛡️ iREPORT - Gmail SMTP Test</h2>
    
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
