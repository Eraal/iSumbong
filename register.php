<?php
include('connectMySql.php');

// Include PHPMailer
require_once 'PHPMailer/PHPMailerAutoload.php';

// Include Gmail SMTP config
include('gmail_config.php');

// Lightweight perf logger (writes to logs/register.log)
function reg_log($msg) {
    $logDir = __DIR__ . DIRECTORY_SEPARATOR . 'logs';
    if (!is_dir($logDir)) {
        @mkdir($logDir, 0775, true);
    }
    $file = $logDir . DIRECTORY_SEPARATOR . 'register.log';
    $prefix = '[' . date('Y-m-d H:i:s') . '] ' . ($_SERVER['REMOTE_ADDR'] ?? 'CLI') . ' - ';
    @file_put_contents($file, $prefix . $msg . "\n", FILE_APPEND);
}

// Siniloan, Laguna boundaries (corrected to include actual municipality)
define('SINILOAN_LAT_MIN', 14.250);
define('SINILOAN_LAT_MAX', 14.520);
define('SINILOAN_LON_MIN', 121.380);
define('SINILOAN_LON_MAX', 121.540);

// Barangays in Siniloan, Laguna
$barangays = [
    'Acevida',
    'Bagong Pag-asa (Poblacion)',
    'Bagumbarangay (Poblacion)',
    'Buhay',
    'Gen. Luna',
    'Halayhayin',
    'Mendiola',
    'Kapatalan',
    'Laguio',
    'Liyang',
    'Magsaysay',
    'P. Burgos',
    'G. Redor',
    'Salubungan',
    'Wawa',
    'J. Rizal',
    'Mayatba',
    'Llvac',
    'Pandenio',
    'Macatad',
];

$addressValue = "";
$addressBorder = "";

if (isset($_POST['btn_verify'])) {

    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = basename($_FILES["id_image"]["name"]);
    // Sanitize and uniquify filename to avoid collisions
    $safeName = preg_replace('/[^A-Za-z0-9._-]/', '_', $fileName);
    $safeName = time() . '_' . $safeName;
    $targetFile = $uploadDir . $safeName;

    if (move_uploaded_file($_FILES["id_image"]["tmp_name"], $targetFile)) {
        $outputFile = $uploadDir . "output_" . uniqid();
        
        // Auto-detect Tesseract path
        $possiblePaths = [
            "C:\\Program Files\\Tesseract-OCR\\tesseract.exe",
            "C:\\Users\\User\\AppData\\Local\\Programs\\Tesseract-OCR\\tesseract.exe",
            "C:\\Program Files (x86)\\Tesseract-OCR\\tesseract.exe",
            "tesseract" // If in system PATH
        ];
        
        $tesseractPath = null;
        foreach ($possiblePaths as $path) {
            if ($path === "tesseract" || file_exists($path)) {
                $tesseractPath = ($path === "tesseract") ? $path : "\"$path\"";
                break;
            }
        }
        
        if (!$tesseractPath) {
            $addressValue = "OCR failed: Tesseract not found. Please install Tesseract OCR.";
            $addressBorder = "border: 2px solid red;";
        } else {
            $cmd = $tesseractPath . " " . escapeshellarg($targetFile) . " " . escapeshellarg($outputFile) . " -l eng";
            $output = [];
            $return_var = null;
            $t0 = microtime(true);
            exec($cmd . " 2>&1", $output, $return_var);
            $ocrMs = (int) round((microtime(true) - $t0) * 1000);
            reg_log("OCR exec for $safeName took {$ocrMs}ms (exit=$return_var)");

            if ($return_var === 0 && file_exists($outputFile . ".txt")) {
                $extractedText = file_get_contents($outputFile . ".txt");
                $cleanText = preg_replace('/\s+/', ' ', $extractedText);

                if (stripos($cleanText, "Siniloan, Laguna") !== false) {
                    $addressValue = "Siniloan, Laguna";
                    $addressBorder = "border: 2px solid green;";

                    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('submitBtn').disabled = false;
        });
    </script>";
                } else {
                    $addressValue = "Address not valid. Must be from Siniloan, Laguna only";
                    $addressBorder = "border: 2px solid red;";

                    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('submitBtn').disabled = true;
        });
    </script>";
                }
            } else {
                $addressValue = "OCR failed: Error processing image. Return code: " . $return_var;
                $addressBorder = "border: 2px solid red;";
            }
        }
    } else {
        $addressValue = "Upload failed";
        $addressBorder = "border: 2px solid red;";
    }
}

if (isset($_POST['btn_save'])) {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $barangay = $_POST['barangay'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $address = $_POST['address'];


    // Validate barangay selection
    if (empty($barangay) || !in_array($barangay, $barangays)) {
        echo "<script src='js/sweetalert2.all.min.js'></script>
            <body onload='error()'></body>
            <script> 
            function error(){
              Swal.fire({
                title: 'Invalid Barangay!',
                text: 'Please select a valid barangay from Siniloan, Laguna.',
                icon: 'error',
                confirmButtonText: 'OK'
              });
            }
            </script>";
    } else if (strlen($password) < 8) {
        echo "<script src='js/sweetalert2.all.min.js'></script>
            <body onload='error()'></body>
            <script> 
            function error(){
              Swal.fire({
                title: 'Password Too Short!',
                text: 'Password must be at least 8 characters long.',
                icon: 'error',
                confirmButtonText: 'OK'
              });
            }
            </script>";
    } else if ($password !== $confirm_password) {
        echo "<script src='js/sweetalert2.all.min.js'></script>
            <body onload='error()'></body>
            <script> 
            function error(){
              Swal.fire({
                title: 'Passwords Do Not Match!',
                text: 'Please make sure both passwords are identical.',
                icon: 'error',
                confirmButtonText: 'OK'
              });
            }
            </script>";
    } else if (empty($address) || stripos($address, 'Siniloan') === false || stripos($address, 'Laguna') === false) {
        echo "<script src='js/sweetalert2.all.min.js'></script>
        <body onload='error()'></body>
        <script> 
        function error(){
          Swal.fire({
            title: 'Invalid Address!',
            text: 'You must provide a valid address in Siniloan, Laguna.',
            icon: 'error',
            confirmButtonText: 'OK'
          });
        }
        </script>";
    } else { // succes registration
        // Check if email already exists
        $check_query = "SELECT * FROM users WHERE email = '$email'";
        $check_result = mysqli_query($conn, $check_query);
        if (mysqli_num_rows($check_result) > 0) {
            echo "<script src='js/sweetalert2.all.min.js'></script>
                <body onload='error()'></body>
                <script> 
                function error(){
                  Swal.fire({
                    title: 'Email Already Exists!',
                    text: 'Please use a different email address.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                  });
                }
                </script>";
        } else {
            // Encrypt password using password_hash()
            $encrypted_password = password_hash($password, PASSWORD_DEFAULT);

            // Generate verification token
            $verification_token = bin2hex(random_bytes(32));
            $token_expiry = date('Y-m-d H:i:s', strtotime('+24 hours'));

            // Handle optional location data
            $lat_value = !empty($latitude) ? "'$latitude'" : "NULL";
            $lon_value = !empty($longitude) ? "'$longitude'" : "NULL";

            $sql = "INSERT INTO users (
                                        email,
                                        name,
                                        password,
                                        barangay,
                                        latitude,
                                        longitude,
                                        is_verified,
                                        verification_token,
                                        token_expiry,
                                        address
                                      )
            VALUES (
                    '" . $email . "',
                    '" . $name . "',
                    '" . $encrypted_password . "',
                    '" . $barangay . "',
                    " . $lat_value . ",
                    " . $lon_value . ",
                    0,
                    '" . $verification_token . "',
                    '" . $token_expiry . "',
                    '" . $address . "'
                )";
            $t0 = microtime(true);
            $result = mysqli_query($conn, $sql);
            $insertMs = (int) round((microtime(true) - $t0) * 1000);
            reg_log("DB insert for $email took {$insertMs}ms");

            if ($result) {
                // Send verification email using PHPMailer with Gmail SMTP
                $t1 = microtime(true);
                $emailResult = sendVerificationEmailPHPMailer($email, $name, $verification_token);
                $emailMs = (int) round((microtime(true) - $t1) * 1000);
                reg_log("Email send to $email took {$emailMs}ms (success=" . ($emailResult['success'] ? '1' : '0') . ")");

                if ($emailResult['success']) {
                    echo "<script src='js/sweetalert2.all.min.js'></script>
                        <body onload='save()'></body>
                        <script> 
                        function save(){
                          Swal.fire({
                            title: 'Registration Successful!',
                            text: 'Please check your email (" . $email . ") to verify your account.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                          }).then((result) => {
                            if (result.isConfirmed) {
                              window.location.href = 'login.php';
                            }
                          });
                        }
                        </script>";
                } else {
                    echo "<script src='js/sweetalert2.all.min.js'></script>
                        <body onload='warning()'></body>
                        <script> 
                        function warning(){
                          Swal.fire({
                            title: 'Account Created!',
                            text: 'Your account was created but we could not send the verification email. Error: " . addslashes($emailResult['error']) . "',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                          }).then((result) => {
                            if (result.isConfirmed) {
                              window.location.href = 'login.php';
                            }
                          });
                        }
                        </script>";
                }
            } else {
                echo "<script src='js/sweetalert2.all.min.js'></script>
                    <body onload='error()'></body>
                    <script> 
                    function error(){
                      Swal.fire({
                        title: 'Registration Failed!',
                        text: 'There was an error creating your account. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                      });
                    }
                    </script>";
            }
        }
    }
}

// PHPMailer Email Function using Gmail SMTP
function sendVerificationEmailPHPMailer($to_email, $name, $token)
{
    $verification_link = VERIFICATION_BASE_URL . '?token=' . $token;

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
        // Tighter timeouts to avoid long hangs on registration
        $mail->Timeout = 15; // seconds (socket timeout)
        $mail->SMTPKeepAlive = false;
        // Force IPv4 if requested (helps when IPv6 egress/DNS causes hangs)
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
        // Optional debug logging to file controlled via .env (SMTP_DEBUG_LOG=1)
        $debugEnabled = (function_exists('env') ? env('SMTP_DEBUG_LOG', '0') : getenv('SMTP_DEBUG_LOG')) === '1';
        if ($debugEnabled) {
            $mail->SMTPDebug = 2; // verbose server/client dialog
            $mail->Debugoutput = function ($str, $level) {
                $logDir = __DIR__ . DIRECTORY_SEPARATOR . 'logs';
                if (!is_dir($logDir)) {
                    @mkdir($logDir, 0775, true);
                }
                $file = $logDir . DIRECTORY_SEPARATOR . 'mail.log';
                @file_put_contents($file, '[' . date('Y-m-d H:i:s') . "] [level=$level] " . $str . "\n", FILE_APPEND);
            };
        }
        // Optional: relax SSL checks only if you have SSL inspection issues (uncomment if needed)
        // $mail->SMTPOptions = [
        //     'ssl' => [
        //         'verify_peer' => false,
        //         'verify_peer_name' => false,
        //         'allow_self_signed' => true,
        //     ]
        // ];
        $mail->CharSet = 'UTF-8';

        // For debugging (remove in production)
        // $mail->SMTPDebug = 2;

        // Recipients
        $mail->setFrom(FROM_EMAIL, FROM_NAME);
        // Set envelope sender (Return-Path) for proper bounces and DMARC alignment
        $mail->Sender = FROM_EMAIL;
        $mail->addAddress($to_email, $name);
        $mail->addReplyTo(REPLY_TO_EMAIL, FROM_NAME);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Verify your iSUMBONG Account';
        $mail->Body = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; background-color: white; border: 1px solid #ddd;'>
            <div style='background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); padding: 30px; text-align: center;'>
                <h1 style='color: white; margin: 0; font-size: 2rem;'>
                    <span style='color: #3498db;'>🛡️</span> iSUMBONG
                </h1>
                <p style='color: white; margin: 10px 0 0 0; opacity: 0.9;'>Incident Reporting System</p>
            </div>
            <div style='padding: 40px 30px;'>
                <h2 style='color: #2c3e50; margin-bottom: 20px;'>Hello $name,</h2>
                <p style='color: #6c757d; font-size: 16px; line-height: 1.6; margin-bottom: 30px;'>
                    Thank you for registering with iSUMBONG, the official incident reporting system for Siniloan, Laguna. 
                    Please verify your email address by clicking the button below:
                </p>
                <div style='text-align: center; margin: 40px 0;'>
                    <a href='$verification_link' style='
                        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
                        color: white;
                        padding: 15px 35px;
                        text-decoration: none;
                        border-radius: 10px;
                        font-weight: bold;
                        font-size: 16px;
                        display: inline-block;
                        box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3);
                    '>
                        🔐 Verify Email Address
                    </a>
                </div>
                <div style='background: #f8f9fa; padding: 20px; border-radius: 8px; border-left: 4px solid #17a2b8;'>
                    <p style='margin: 0; color: #6c757d; font-size: 14px;'>
                        <strong>Important:</strong> This verification link will expire in 24 hours for security purposes.
                    </p>
                </div>
                <p style='color: #6c757d; font-size: 14px; margin-top: 30px; text-align: center;'>
                    If you didn't create an account, please ignore this email or contact support.
                </p>
            </div>
            <div style='background: #f8f9fa; padding: 20px; text-align: center; border-top: 1px solid #e3e6f0;'>
                <p style='margin: 0; color: #6c757d; font-size: 12px;'>
                    © 2025 iSUMBONG System - Siniloan, Laguna<br>
                    This is an automated message, please do not reply.
                </p>
            </div>
        </div>";

        // Alternative plain text version
        $mail->AltBody = "Hello $name,\n\n" .
            "Thank you for registering with iSUMBONG.\n" .
            "Please verify your email by visiting: $verification_link\n\n" .
            "This link will expire in 24 hours.\n\n" .
            "If you didn't create an account, please ignore this email.\n\n" .
            "Thank you,\nThe iSUMBONG Team";

        $mail->send();
        return ['success' => true, 'message' => 'Verification email sent successfully'];
    } catch (Exception $e) {
        reg_log('PHPMailer error for ' . $to_email . ': ' . $mail->ErrorInfo);
        return ['success' => false, 'error' => 'Email could not be sent. Error: ' . $mail->ErrorInfo];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iSUMBONG - User Registration</title>
    <link rel="icon" type="image/x-icon" href="img/logo1.png" />
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

        .register-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 700px;
            width: 90%;
            display: flex;
            height: auto;
            min-height: 420px;
            max-height: none;
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
            padding: 1.5rem;
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
            font-size: 1.4rem;
            font-weight: bold;
        }

        .logo i {
            margin-right: 0.6rem;
            color: #3498db;
        }

        .hero-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.6rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 0.9rem;
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

        .register-section {
            flex: 1;
            padding: 1.2rem;
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .register-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .register-header {
            text-align: center;
            margin-bottom: 0.8rem;
            flex-shrink: 0;
        }

        .register-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.2rem;
        }

        .register-subtitle {
            color: #6c757d;
            font-size: 0.8rem;
        }

        .form-group {
            margin-bottom: 0.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.15rem;
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.7rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.5rem;
            border: 2px solid #e3e6f0;
            border-radius: 6px;
            font-size: 0.75rem;
            transition: all 0.3s ease;
            background: #fff;
        }

        .form-group input:focus,
        .form-group select:focus {
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
            right: 0.5rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            font-size: 0.8rem;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: #4e73df;
        }

        .match {
            border-color: #28a745 !important;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
        }

        .mismatch {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
        }


        .password-strength {
            font-size: 0.6rem;
            margin-top: 0.1rem;
            padding-left: 0.05rem;
        }

        .weak {
            color: #dc3545;
            font-weight: 600;
        }

        .medium {
            color: #ffc107;
            font-weight: 600;
        }

        .strong {
            color: #28a745;
            font-weight: 600;
        }

        .btn {
            width: 100%;
            padding: 0.6rem 0.8rem;
            border: none;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color: white;
            box-shadow: 0 8px 25px rgba(78, 115, 223, 0.3);
        }

        .btn-primary:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(78, 115, 223, 0.4);
        }

        .btn:disabled {
            background: #6c757d !important;
            cursor: not-allowed;
            opacity: 0.6;
            transform: none !important;
            box-shadow: none !important;
        }

        .form-links {
            text-align: center;
            margin-top: 0.4rem;
        }

        .form-links a {
            color: #4e73df;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
            font-size: 0.75rem;
        }

        .form-links a:hover {
            color: #224abe;
        }

        .back-btn {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: none;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.8rem;
            z-index: 3;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
                width: 95%;
                min-height: auto;
                height: auto;
                max-width: none;
            }

            .hero-section {
                padding: 1rem;
                text-align: center;
                min-height: 200px;
            }

            .hero-title {
                font-size: 1.4rem;
            }

            .hero-subtitle {
                font-size: 0.85rem;
            }

            .register-section {
                padding: 1rem;
                width: 100%;
            }

            .register-title {
                font-size: 1.2rem;
            }

            .form-group input,
            .form-group select {
                padding: 0.8rem;
                font-size: 0.9rem;
            }

            .btn {
                padding: 0.8rem 1rem;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .register-container {
                width: 98%;
                margin: 0.5rem;
                border-radius: 8px;
            }

            .hero-section {
                padding: 0.8rem;
                min-height: 180px;
            }

            .register-section {
                padding: 0.8rem;
            }

            .form-group {
                margin-bottom: 0.8rem;
            }

            .form-group input,
            .form-group select {
                padding: 1rem;
                font-size: 1rem;
            }

            .btn {
                padding: 1rem;
                font-size: 1rem;
            }
        }
    </style>
</head>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const formInputs = document.querySelectorAll("input, select");
        const submitBtn = document.getElementById("submitBtn");
        const addressField = document.getElementById("address");

        function validateForm() {
            let allFilled = true;

            formInputs.forEach(input => {
                if (input.hasAttribute("required") && !input.value.trim()) {
                    allFilled = false;
                }
            });

            // Check if address border is green
            const borderColor = window.getComputedStyle(addressField).borderColor;
            const isAddressValid = (borderColor === "rgb(0, 128, 0)"); // green

            submitBtn.disabled = !(allFilled && isAddressValid);
        }

        formInputs.forEach(input => {
            input.addEventListener("input", validateForm);
            input.addEventListener("change", validateForm);
        });

        validateForm(); // run on load
    });
</script>


<body>
    <button class="back-btn" onclick="window.location.href='index.php'">
        <i class="fas fa-arrow-left"></i> Back to Home
    </button>

    <div class="register-container">
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="hero-content">
                <div class="logo">
                    <i class="fas fa-shield-alt"></i>
                    iSUMBONG
                </div>
                <h1 class="hero-title">Secure Incident Reporting</h1>
                <p class="hero-subtitle">Join our community-driven safety platform for Siniloan, Laguna</p>

                <ul class="features">
                    <li><i class="fas fa-map-marker-alt"></i> Community Reporting</li>
                    <li><i class="fas fa-user-shield"></i> Secure & Anonymous</li>
                    <li><i class="fas fa-clock"></i> Real-Time Alerts</li>
                    <li><i class="fas fa-users"></i> Community Safety</li>
                </ul>
            </div>
        </div>

        <!-- Registration Form Section -->
        <div class="register-section">
            <div class="register-content">
                <div class="register-header">
                    <h2 class="register-title">Create Account</h2>
                    <p class="register-subtitle">Join our secure incident reporting system</p>
                </div>

                <form method="POST" id="registerForm" enctype="multipart/form-data">
                    <!-- Hidden fields for location (optional) -->
                    <input type="hidden" id="latitude" name="latitude" value="<?php echo isset($_POST['latitude']) ? htmlspecialchars($_POST['latitude']) : ''; ?>">
                    <input type="hidden" id="longitude" name="longitude" value="<?php echo isset($_POST['longitude']) ? htmlspecialchars($_POST['longitude']) : ''; ?>">

                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter your full name"
                            value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email address"
                            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="barangay">Barangay</label>
                        <select name="barangay" id="barangay" required>
                            <option value="">Select your Barangay</option>
                            <?php foreach ($barangays as $brgy): ?>
                                <option value="<?php echo $brgy; ?>"
                                    <?php echo (isset($_POST['barangay']) && $_POST['barangay'] == $brgy) ? 'selected' : ''; ?>>
                                    <?php echo $brgy; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_image">Upload ID</label>
                        <input type="file" name="id_image" id="id_image" accept="image/*">
                        <button type="submit" name="btn_verify" class="btn btn-primary" formnovalidate>Verify</button>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address"
                            value="<?php echo isset($addressValue) ? htmlspecialchars($addressValue) : ''; ?>"
                            readonly style="<?php echo isset($addressBorder) ? $addressBorder : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="password-container">
                            <input type="password" id="password" name="password"
                                placeholder="Create a password (min 8 characters)" required minlength="8">
                            <i class="password-toggle fas fa-eye" onclick="togglePassword('password')"></i>
                        </div>
                        <div class="password-strength" id="password-strength"></div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <div class="password-container">
                            <input type="password" id="confirm_password" name="confirm_password"
                                placeholder="Confirm 
                                your password" required>
                            <i class="password-toggle fas fa-eye"></i>
                        </div>
                    </div>

                    <button type="submit" name="btn_save" id="submitBtn" class="btn btn-primary" disabled>
                        <i class="fas fa-user-plus"></i> Create Account
                    </button>
                </form>

                <div class="form-links">
                    Already have an account? <a href="login.php">Sign in here</a>
                </div>
            </div>
        </div>

        <script>
            const password = document.getElementById("password");
            const confirm = document.getElementById("confirm_password");
            const submitBtn = document.getElementById("submitBtn");
            const strengthDiv = document.getElementById("password-strength");

            function checkPasswordStrength(password) {
                let strength = 0;
                let feedback = "";

                if (password.length >= 8) strength++;
                if (password.match(/[a-z]/)) strength++;
                if (password.match(/[A-Z]/)) strength++;
                if (password.match(/[0-9]/)) strength++;
                if (password.match(/[^a-zA-Z0-9]/)) strength++;

                switch (strength) {
                    case 0:
                    case 1:
                        feedback = "<span class='weak'>Very Weak</span>";
                        break;
                    case 2:
                        feedback = "<span class='weak'>Weak</span>";
                        break;
                    case 3:
                        feedback = "<span class='medium'>Medium</span>";
                        break;
                    case 4:
                        feedback = "<span class='strong'>Strong</span>";
                        break;
                    case 5:
                        feedback = "<span class='strong'>Very Strong</span>";
                        break;
                }

                return feedback;
            }



            function validatePasswords() {
                // Check password strength
                if (password.value.length > 0) {
                    strengthDiv.innerHTML = "Password strength: " + checkPasswordStrength(password.value);
                } else {
                    strengthDiv.innerHTML = "";
                }

                if (confirm.value === "") {
                    confirm.classList.remove("match", "mismatch");
                    updateSubmitButton();
                    return;
                }

                if (password.value === confirm.value && password.value.length >= 8) {
                    confirm.classList.remove("mismatch");
                    confirm.classList.add("match");
                    updateSubmitButton();
                } else {
                    confirm.classList.remove("match");
                    confirm.classList.add("mismatch");
                    updateSubmitButton();
                }
            }

            function updateSubmitButton() {
                const passwordsMatch = password.value === confirm.value && password.value.length >= 8;
                submitBtn.disabled = !passwordsMatch;
            }

            function togglePassword(fieldId) {
                const field = document.getElementById(fieldId);
                const icon = field.nextElementSibling;

                if (field.type === 'password') {
                    field.type = 'text';
                    icon.className = 'password-toggle fas fa-eye-slash';
                } else {
                    field.type = 'password';
                    icon.className = 'password-toggle fas fa-eye';
                }
            }

            // Initialize
            password.addEventListener("input", validatePasswords);
            confirm.addEventListener("input", validatePasswords);

            // Enable form submission since location is no longer required
            updateSubmitButton();
        </script>
</body>

</html>