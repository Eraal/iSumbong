<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iREPORT - Forgot Password</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="js/sweetalert2.all.min.js"></script>
</head>
<body>
    <div class="navbar">
        <div class="logo">🛡️ iREPORT</div>
        <div class="nav-link">FORGOT PASSWORD</div>
    </div>

    <div class="card auth">
        <h3>Reset Your Password</h3>
        <p style="color: #666; margin-bottom: 25px; text-align: center;">
            Enter your email address and we'll send you a link to reset your password.
        </p>
        
        <form action="forgot_password_process.php" method="POST">
            <input type="email" name="email" placeholder="Enter your email address" required>
            <button type="submit" class="btn blue full-width">Send Reset Link</button>
        </form>
        
        <div class="text-center small-text" style="margin-top: 20px;">
            <a href="login.php">
                <i class="fas fa-arrow-left"></i> Back to Login
            </a>
        </div>
        
        <div class="text-center small-text">
            Don't have an account? <a href="register.php">Register here</a>
        </div>
    </div>
</body>
</html>