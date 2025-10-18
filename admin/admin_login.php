<?php
// Handle admin login authentication directly on this page
$error_message = '';
$success_redirect = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../connectMySql.php';
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if (empty($email) || empty($password)) {
        $error_message = 'Please enter both email and password.';
    } else {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=iSUMBONG', $username_server, $password_server);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Check for admin user only
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND role = 'admin' AND status = 'ACTIVE'");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
           
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Verify password
                $password_valid = false;
                if (password_verify($password, $row['password'])) {
                    $password_valid = true;
                } elseif ($password === $row['password']) {
                    // Plain text password support for backward compatibility
                    $password_valid = true;
                }
                
                if ($password_valid) {
                    // Start session and redirect to admin dashboard
                    session_start();
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['role'] = $row['role'];
                    $_SESSION['image'] = $row['image'] ?? null;
                    
                    header('Location: dashboard/');
                    exit;
                } else {
                    $error_message = 'Invalid admin credentials!';
                }
            } else {
                // Check legacy admin table as fallback
                $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = :email AND status = 'ACTIVE'");
                $stmt->bindParam(':email', $email);
                $stmt->execute();
               
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if (password_verify($password, $row['password']) || $password === $row['password']) {
                        session_start();
                        $_SESSION['user_id'] = $row['user_id'];
                        $_SESSION['name'] = $row['name'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['role'] = 'admin';
                        $_SESSION['image'] = $row['image'] ?? null;
                        
                        header('Location: dashboard/');
                        exit;
                    } else {
                        $error_message = 'Invalid admin credentials!';
                    }
                } else {
                    $error_message = 'Invalid admin credentials!';
                }
            }
        } catch (PDOException $e) {
            $error_message = 'System error. Please try again later.';
        }
    }
}
?>

<!DOCTYPE html>
<head>
  <meta charset="UTF-8">
  <title>iREPORT - Admin Login</title>
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="../js/sweetalert2.all.min.js"></script>
</head>
<body>
  <div class="navbar">
    <div class="logo">🛡️ iREPORT</div>
    <div class="nav-link">ADMIN LOGIN</div>
  </div>

  <div class="card auth">
    <h3>Admin Login</h3>
    <?php if (!empty($error_message)): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Login Failed',
            text: '<?php echo addslashes($error_message); ?>'
        });
    </script>
    <?php endif; ?>
    
    <form method="POST">
      <input type="email" name="email" placeholder="Enter your Email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
      
      <div class="password-container" style="position: relative; display: inline-block; width: 100%;">
        <input type="password" name="password" id="password" placeholder="Enter your Password" required style="width: 100%; padding-right: 40px;">
        <i class="password-toggle fas fa-eye" onclick="togglePassword()" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #666; font-size: 16px;"></i>
      </div>

      <button type="submit" class="btn blue full-width" style="margin-top: 20px;">Log In</button>
    </form>
  </div>
</body>

<script>
function togglePassword() {
  const passwordInput = document.getElementById('password');
  const toggleIcon = document.querySelector('.password-toggle');
  
  if (passwordInput.type === 'password') {
    passwordInput.type = 'text';
    toggleIcon.className = 'password-toggle fas fa-eye-slash';
  } else {
    passwordInput.type = 'password';
    toggleIcon.className = 'password-toggle fas fa-eye';
  }
}
</script>

</html>
