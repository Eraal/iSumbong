<?php
include('connectMySql.php');

$message = "";
$status = "";

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Validate token format (basic length check to avoid abuse)
    if (!is_string($token) || strlen($token) < 16 || strlen($token) > 255) {
        $message = "Invalid verification link.";
        $status = "error";
    } else {
        // Check if token exists and is not expired using prepared statements
        $stmt = $conn->prepare("SELECT id FROM users WHERE verification_token = ? AND token_expiry > NOW() AND is_verified = 0 LIMIT 1");
        $stmt->bind_param('s', $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            // Valid token, verify the user
            $update = $conn->prepare("UPDATE users SET is_verified = 1, verification_token = NULL, token_expiry = NULL WHERE verification_token = ?");
            $update->bind_param('s', $token);
            $update_result = $update->execute();

            if ($update_result) {
                $message = "Your email has been successfully verified! You can now log in to your account.";
                $status = "success";
            } else {
                $message = "There was an error verifying your email. Please try again.";
                $status = "error";
            }
        } else {
            // Check if token is expired
            $expired = $conn->prepare("SELECT id FROM users WHERE verification_token = ? AND token_expiry <= NOW() LIMIT 1");
            $expired->bind_param('s', $token);
            $expired->execute();
            $expired_result = $expired->get_result();

            if ($expired_result->fetch_assoc()) {
                $message = "This verification link has expired. Please register again or request a new verification email.";
                $status = "warning";
            } else {
                $message = "Invalid verification link. Please check your email and try again.";
                $status = "error";
            }
        }
    }
} else {
    $message = "No verification token provided.";
    $status = "error";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification - iSUMBONG</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="navbar">
        <div class="logo">🛡️ iSUMBONG</div>
        <div class="nav-link">EMAIL VERIFICATION</div>
    </div>

    <div class="card auth">
        <h3>Email Verification</h3>
        
        <?php if($status == "success"): ?>
            <div style="padding: 20px; background-color: #d4edda; color: #155724; border-radius: 5px; margin-bottom: 20px;">
                <strong>✅ Success!</strong> <?php echo $message; ?>
            </div>
        <?php elseif($status == "warning"): ?>
            <div style="padding: 20px; background-color: #fff3cd; color: #856404; border-radius: 5px; margin-bottom: 20px;">
                <strong>⚠️ Warning!</strong> <?php echo $message; ?>
            </div>
        <?php else: ?>
            <div style="padding: 20px; background-color: #f8d7da; color: #721c24; border-radius: 5px; margin-bottom: 20px;">
                <strong>❌ Error!</strong> <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="text-center">
            <?php if($status == "success"): ?>
                <a href="login.php" class="btn blue" style="text-decoration: none; display: inline-block; padding: 10px 20px;">Go to Login</a>
            <?php else: ?>
                <a href="register.php" class="btn blue" style="text-decoration: none; display: inline-block; padding: 10px 20px; margin-right: 10px;">Register Again</a>
                <a href="login.php" class="btn" style="text-decoration: none; display: inline-block; padding: 10px 20px; background-color: #6c757d; color: white;">Back to Login</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
