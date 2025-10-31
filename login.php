<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iSumbong - User Login</title>
    <link rel="icon" type="image/x-icon" href="img/logo1.png"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="js/sweetalert2.all.min.js"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
            z-index: 1;
        }
        
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 750px;
            width: 90%;
            display: flex;
            min-height: 420px;
            height: auto;
            position: relative;
            z-index: 2;
            animation: slideIn 0.8s ease-out;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .hero-section {
            flex: 1;
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
            z-index: 1;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 0.8rem;
            font-size: 1.3rem;
            font-weight: bold;
        }
        
        .logo i {
            margin-right: 0.6rem;
            color: #3498db;
        }
        
        .hero-title {
            font-size: 1.7rem;
            font-weight: 700;
            margin-bottom: 0.6rem;
            line-height: 1.2;
        }
        
        .hero-subtitle {
            font-size: 0.85rem;
            opacity: 0.9;
            margin-bottom: 1rem;
            line-height: 1.3;
        }
        
        .features {
            list-style: none;
        }
        
        .features li {
            display: flex;
            align-items: center;
            margin-bottom: 0.4rem;
            font-size: 0.8rem;
        }
        
        .features li i {
            color: #3498db;
            margin-right: 0.6rem;
            width: 14px;
        }
        
        .login-section {
            flex: 1;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 1.2rem;
        }
        
        .login-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.3rem;
        }
        
        .login-subtitle {
            color: #6c757d;
            font-size: 0.8rem;
        }
        
        .form-group {
            margin-bottom: 0.8rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.2rem;
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.75rem;
        }
        
        .form-group input {
            width: 100%;
            padding: 0.6rem;
            border: 2px solid #e3e6f0;
            border-radius: 8px;
            font-size: 0.8rem;
            transition: all 0.3s ease;
            background: #fff;
            min-height: 2.5rem;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
            transform: translateY(-2px);
        }
        
        .password-container {
            position: relative;
        }
        
        .password-toggle {
            position: absolute;
            right: 0.6rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }
        
        .password-toggle:hover {
            color: #4e73df;
        }
        
        .btn {
            width: 100%;
            padding: 0.7rem 1rem;
            border: none;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.3rem;
            margin-top: 0.6rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color: white;
            box-shadow: 0 8px 25px rgba(78, 115, 223, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(78, 115, 223, 0.4);
        }
        
        .form-links {
            text-align: center;
            margin-top: 0.8rem;
        }
        
        .form-links a {
            color: #4e73df;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
            margin: 0 0.5rem;
            font-size: 0.75rem;
        }
        
        .form-links a:hover {
            color: #224abe;
        }
        
        .divider {
            margin: 0.6rem 0;
            text-align: center;
            color: #6c757d;
            font-size: 0.75rem;
        }
        
        .back-btn {
            position: fixed;
            top: 1rem;
            left: 1rem;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: none;
            padding: 0.5rem 0.8rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.8rem;
            z-index: 1000;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }
        
        .back-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        
        @media (max-width: 768px) {
            body {
                padding: 1rem 0.5rem;
            }
            
            .login-container {
                flex-direction: column;
                width: 95%;
                min-height: auto;
                max-width: none;
                margin: 2rem auto 1rem;
            }
            
            .hero-section {
                padding: 1.5rem;
                text-align: center;
                min-height: auto;
            }
            
            .hero-title {
                font-size: 1.4rem;
            }
            
            .hero-subtitle {
                font-size: 0.85rem;
            }
            
            .login-section {
                padding: 1.5rem;
                width: 100%;
            }
            
            .login-title {
                font-size: 1.3rem;
            }
            
            .features {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 0.3rem;
                margin-top: 1rem;
            }
            
            .features li {
                font-size: 0.75rem;
            }
            
            .back-btn {
                position: fixed;
                top: 1rem;
                left: 1rem;
                padding: 0.4rem 0.7rem;
                font-size: 0.75rem;
            }
            
            .form-group input {
                padding: 0.8rem;
                font-size: 0.9rem;
                min-height: 3rem;
            }
            
            .btn {
                padding: 0.8rem;
                font-size: 0.9rem;
                min-height: 3rem;
            }
            
            .form-links {
                margin-top: 1rem;
            }
            
            .form-links a {
                font-size: 0.8rem;
                display: inline-block;
                margin: 0.2rem 0.3rem;
            }
        }
        
        @media (max-width: 480px) {
            body {
                padding: 0.5rem;
                min-height: 100vh;
            }
            
            .login-container {
                width: 100%;
                border-radius: 8px;
                margin: 3rem auto 1rem;
                max-width: none;
                min-height: auto;
            }
            
            .hero-section {
                padding: 1rem;
                min-height: auto;
                text-align: center;
            }
            
            .login-section {
                padding: 1rem;
            }
            
            .hero-title {
                font-size: 1.2rem;
                margin-bottom: 0.5rem;
            }
            
            .hero-subtitle {
                font-size: 0.8rem;
                margin-bottom: 0.8rem;
            }
            
            .login-title {
                font-size: 1.1rem;
            }
            
            .login-subtitle {
                font-size: 0.8rem;
            }
            
            .features {
                display: grid;
                grid-template-columns: 1fr;
                gap: 0.2rem;
                margin-top: 0.8rem;
            }
            
            .features li {
                font-size: 0.7rem;
                margin-bottom: 0.2rem;
            }
            
            .form-group {
                margin-bottom: 1rem;
            }
            
            .form-group label {
                font-size: 0.8rem;
                margin-bottom: 0.3rem;
            }
            
            .form-group input {
                padding: 0.9rem;
                font-size: 0.9rem;
                min-height: 3.2rem;
                border-radius: 6px;
            }
            
            .btn {
                padding: 0.9rem;
                font-size: 0.9rem;
                min-height: 3.2rem;
                margin-top: 0.8rem;
            }
            
            .back-btn {
                position: fixed;
                top: 0.8rem;
                left: 0.8rem;
                font-size: 0.7rem;
                padding: 0.4rem 0.6rem;
                z-index: 1001;
            }
            
            .form-links {
                margin-top: 1rem;
                line-height: 1.6;
            }
            
            .form-links a {
                font-size: 0.75rem;
                display: inline-block;
                margin: 0.1rem 0.2rem;
            }
            
            .divider {
                margin: 0.4rem 0;
                font-size: 0.7rem;
            }
        }
        
        @media (min-width: 769px) and (max-width: 1024px) {
            .login-container {
                max-width: 650px;
                width: 85%;
            }
            
            .hero-section {
                padding: 1.8rem;
            }
            
            .login-section {
                padding: 1.8rem;
            }
            
            .back-btn {
                position: fixed;
                top: 1rem;
                left: 1rem;
                z-index: 1000;
            }
        }
        
        @media (max-height: 600px) {
            body {
                align-items: flex-start;
                padding-top: 3rem;
            }
            
            .login-container {
                min-height: auto;
                margin-top: 1rem;
            }
            
            .hero-section {
                padding: 1rem;
            }
            
            .login-section {
                padding: 1rem;
            }
            
            .features {
                display: none;
            }
            
            .back-btn {
                position: fixed;
                top: 0.5rem;
                left: 0.5rem;
                z-index: 1000;
            }
        }
    </style>
</head>
<body>
    <button class="back-btn" onclick="window.location.href='index.php'">
        <i class="fas fa-arrow-left"></i> Back to Home
    </button>
    
    <div class="login-container">
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="hero-content">
                <div class="logo">
                    <i class="fas fa-shield-alt"></i>
                    iSumbong
                </div>
                
                <h1 class="hero-title">User Portal</h1>
                <p class="hero-subtitle">
                    Access your account to report incidents, track status, and manage your submissions with our secure platform.
                </p>
                
                <ul class="features">
                    <li><i class="fas fa-check"></i> Report new incidents</li>
                    <li><i class="fas fa-check"></i> Track your submissions</li>
                    <li><i class="fas fa-check"></i> Receive status updates</li>
                    <li><i class="fas fa-check"></i> Secure communication</li>
                    <li><i class="fas fa-check"></i> Personal dashboard</li>
                </ul>
            </div>
        </div>
        
        <!-- Login Section -->
        <div class="login-section">
            <div class="login-header">
                <h2 class="login-title text-align=center">Welcome</h2>
                <p class="login-subtitle">Sign in to your account to continue</p>
            </div>
            
            <form action="loginprocess.php" method="POST">
                <input type="hidden" name="user_login" value="1">
                
                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i> Email Address
                    </label>
                    <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                </div>
                
                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <i class="fas fa-eye password-toggle" onclick="togglePassword()"></i>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </button>
            </form>
            
            <div class="form-links">
                <a href="forgot_password.php">
                    <i class="fas fa-key"></i> Forgot Password?
                </a>
                
                <div class="divider">•</div>
                
                Don't have an account? 
                <a href="register.php">
                    <i class="fas fa-user-plus"></i> Register here
                </a>
            </div>
        </div>
    </div>
    
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
        
        // Check for success messages
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const message = urlParams.get('message');
            
            if (message === 'password_reset_success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Password Reset Successful!',
                    text: 'Your password has been updated successfully. You can now login with your new password.',
                    confirmButtonText: 'OK'
                });
                
                // Clean up URL
                if (window.history.replaceState) {
                    window.history.replaceState(null, null, 'login.php');
                }
            }
        });
        
        // Form animation
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                input.addEventListener('blur', function() {
                    if (!this.value) {
                        this.parentElement.classList.remove('focused');
                    }
                });
            });
        });
    </script>
</body>
</html>
