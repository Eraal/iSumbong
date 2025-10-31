<?php
include 'connectMySql.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_login = isset($_POST['user_login']) ? $_POST['user_login'] : false;

    if (empty($email) || empty($password)) {
        // Display error message if username or password is empty
        echo "<script src='js/sweetalert2.all.min.js'></script>
           <body onload='error()'></body>
           <script> 
           function error(){
           Swal.fire({
                icon: 'error',
                title: 'Login failed!',
                text: 'Please enter both email and password.'
           })
           }</script>";
        include 'login.php';
    } else {
        try {
            // Build DSN from existing env-aware config in connectMySql.php
            $host = $servername ?? 'localhost';
            $database = $db ?? 'isumbong'; // default aligns with SQL dump (lowercase)
            $portNum = isset($port) ? (int)$port : 3306;
            $dsn = "mysql:host={$host};port={$portNum};dbname={$database};charset=utf8mb4";

            $pdo = new PDO($dsn, $username_server, $password_server, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
            
            // Check for regular users only (not admin)
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND role != 'admin' AND status = 'ACTIVE'");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
           
            $rowCount = $stmt->rowCount();

            if ($rowCount > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Check if email is verified
                if (isset($row['is_verified']) && $row['is_verified'] == 0) {
                    echo "<script src='js/sweetalert2.all.min.js'></script>
                       <body onload='notVerified()'></body>
                       <script> 
                       function notVerified(){
                       Swal.fire({
                            icon: 'warning',
                            title: 'Email Not Verified',
                            text: 'Please verify your email before logging in. Check your inbox for the verification link.',
                            confirmButtonText: 'OK'
                       })
                       }</script>";
                    include 'login.php';
                    exit;
                }
                
                // Verify password (support both hashed and plain text for backward compatibility)
                $password_valid = false;
                if (password_verify($password, $row['password'])) {
                    $password_valid = true;
                } elseif ($password === $row['password']) {
                    // Plain text password - hash it for future use
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $update_stmt = $pdo->prepare("UPDATE users SET password = :password WHERE user_id = :user_id");
                    $update_stmt->bindParam(':password', $hashed_password);
                    $update_stmt->bindParam(':user_id', $row['user_id']);
                    $update_stmt->execute();
                    $password_valid = true;
                }
                
                if ($password_valid) {
                    // Password is correct - start session
                    session_start();
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['role'] = $row['role'];
                    $_SESSION['image'] = $row['image'] ?? null;
                    
                    // Redirect to user dashboard
                    header('Location: user/dashboard/');
                    exit;
                } else {
                    // Wrong password
                    echo "<script src='js/sweetalert2.all.min.js'></script>
                       <body onload='error()'></body>
                       <script> 
                       function error(){
                       Swal.fire({
                            icon: 'error',
                            title: 'Login Failed',
                            text: 'Invalid email or password!'
                       })
                       }</script>";
                    include 'login.php';
                    exit;
                }
            } else {
                // Check if user tried to login with admin credentials
                $admin_check = $pdo->prepare("SELECT * FROM users WHERE email = :email AND role = 'admin' AND status = 'ACTIVE'");
                $admin_check->bindParam(':email', $email);
                $admin_check->execute();
                
                if ($admin_check->rowCount() > 0) {
                    echo "<script src='js/sweetalert2.all.min.js'></script>
                       <body onload='adminRedirect()'></body>
                       <script> 
                       function adminRedirect(){
                       Swal.fire({
                            icon: 'info',
                            title: 'Admin Account Detected',
                            text: 'Please use the admin login portal.',
                            confirmButtonText: 'Go to Admin Login'
                       }).then((result) => {
                           if (result.isConfirmed) {
                               window.location.href = 'admin/admin_login.php';
                           }
                       });
                       }</script>";
                    include 'login.php';
                    exit;
                }
                
                // No valid user credentials found
                echo "<script src='js/sweetalert2.all.min.js'></script>
                   <body onload='error()'></body>
                   <script> 
                   function error(){
                   Swal.fire({
                        icon: 'error',
                        title: 'Login Failed',
                        text: 'Invalid email or password!'
                   })
                   }</script>";
                include 'login.php';
                exit;
            }
        } catch (PDOException $e) {
            // Database error
            echo "<script src='js/sweetalert2.all.min.js'></script>
               <body onload='error()'></body>
               <script> 
               function error(){
               Swal.fire({
                    icon: 'error',
                    title: 'System Error',
                    text: 'Please try again later or contact support.'
               })
               }</script>";
            include 'login.php';
            exit;
        }
    }
}
?>
