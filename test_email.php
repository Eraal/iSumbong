<?php
include('sendgrid_config.php');

echo "<h2>SendGrid Email Test</h2>";

// Test email function
function testSendGrid($to_email) {
    $api_key = SENDGRID_API_KEY;
    
    echo "<p><strong>API Key:</strong> " . substr($api_key, 0, 10) . "...</p>";
    echo "<p><strong>From Email:</strong> " . FROM_EMAIL . "</p>";
    echo "<p><strong>To Email:</strong> " . $to_email . "</p>";
    
    $email_data = [
        'personalizations' => [
            [
                'to' => [
                    ['email' => $to_email, 'name' => 'Test User']
                ],
                'subject' => 'Test Email from iREPORT'
            ]
        ],
        'from' => [
            'email' => FROM_EMAIL,
            'name' => FROM_NAME
        ],
        'content' => [
            [
                'type' => 'text/html',
                'value' => '<h1>Test Email</h1><p>This is a test email from iREPORT system.</p>'
            ]
        ]
    ];
    
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://api.sendgrid.com/v3/mail/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($email_data),
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $api_key,
            'Content-Type: application/json'
        ],
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_VERBOSE => true
    ]);
    
    $response = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($curl);
    curl_close($curl);
    
    echo "<h3>Results:</h3>";
    echo "<p><strong>HTTP Code:</strong> " . $httpcode . "</p>";
    echo "<p><strong>cURL Error:</strong> " . ($curl_error ?: 'None') . "</p>";
    echo "<p><strong>Response:</strong></p>";
    echo "<pre>" . htmlspecialchars($response) . "</pre>";
    
    if ($httpcode == 202) {
        echo "<p style='color: green;'><strong>✅ Email sent successfully!</strong></p>";
        return true;
    } else {
        echo "<p style='color: red;'><strong>❌ Email failed to send</strong></p>";
        return false;
    }
}

// Test form
if (isset($_POST['test_email'])) {
    $test_email = $_POST['test_email'];
    testSendGrid($test_email);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>SendGrid Email Test</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        form { background: #f5f5f5; padding: 20px; border-radius: 5px; margin: 20px 0; }
        input[type="email"] { width: 300px; padding: 10px; margin: 10px 0; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 3px; cursor: pointer; }
        pre { background: #f8f9fa; padding: 15px; border-left: 4px solid #007bff; overflow-x: auto; }
    </style>
</head>
<body>
    <h1>🛡️ iREPORT - SendGrid Email Test</h1>
    
    <form method="POST">
        <h3>Test Email Sending</h3>
        <p>Enter your email address to test if SendGrid is working:</p>
        <input type="email" name="test_email" placeholder="your-email@example.com" required>
        <button type="submit">Send Test Email</button>
    </form>
    
    <div style="background: #fff3cd; padding: 15px; border-radius: 5px; margin: 20px 0;">
        <h4>⚠️ Common Issues:</h4>
        <ul>
            <li><strong>API Key Invalid:</strong> Make sure your SendGrid API key is correct</li>
            <li><strong>Domain Not Verified:</strong> SendGrid requires domain verification for production</li>
            <li><strong>Rate Limits:</strong> Free accounts have sending limits</li>
            <li><strong>Blocked by ISP:</strong> Some email providers block automated emails</li>
        </ul>
    </div>
    
    <p><a href="register.php">← Back to Registration</a></p>
</body>
</html>
