<?php
session_start();
include 'connectMySql.php'; 
require_once('PHPMailer/PHPMailerAutoload.php');
// Centralized SMTP config (reads from .env)
require_once(__DIR__ . '/gmail_config.php');

function generateRandomPassword($length = 12) {
    return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
}

echo '<!DOCTYPE html><html><head>
<script src="js/sweetalert2.all.min.js"></script>
</head><body>';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $newPassword = generateRandomPassword();
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $update = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $update->bind_param("ss", $hashedPassword, $email);
        $update->execute();

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->Port = SMTP_PORT;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = SMTP_ENCRYPTION;
            $mail->Username = SMTP_USERNAME;
            $mail->Password = SMTP_PASSWORD; // App password when using Gmail
            // Keep mail fast and resilient
            $mail->Timeout = 15;
            $mail->SMTPKeepAlive = false;
            // Optional IPv4 forcing
            if ((function_exists('env') ? env('SMTP_FORCE_IPV4', '0') : getenv('SMTP_FORCE_IPV4')) === '1') {
                $resolved = gethostbyname(SMTP_HOST);
                if (!empty($resolved) && $resolved !== SMTP_HOST) {
                    $mail->Host = $resolved; // IPv4 address
                }
                $mail->SMTPOptions = [
                    'socket' => [
                        'bindto' => '0.0.0.0:0',
                        'tcp_nodelay' => true,
                    ]
                ];
            }
            // Optional relaxed SSL for tricky environments
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
            $mail->setFrom(FROM_EMAIL, FROM_NAME);
            $mail->addReplyTo(REPLY_TO_EMAIL ?: FROM_EMAIL, FROM_NAME);
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'iSumbong Password Reset';
            $mail->Body = "
                <h3>Password Reset Successful</h3>
                <p>Your new password is:</p>
                <div style='padding:10px;background:#f1f1f1;border-radius:8px;font-size:16px;'>
                    <b>$newPassword</b>
                </div>
                <p>You can now log in using your new password. It's recommended to change it after logging in.</p>
                <br>
                <p>iSumbong</p>
            ";

            if ($mail->send()) {
                echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Password Reset Sent!',
                        text: 'A new password has been sent to your email.',
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                </script>";
            } else {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Email Failed!',
                        text: 'Mailer error occurred.'
                    }).then(() => {
                        window.location.href = 'forgot_password.php';
                    });
                </script>";
            }

        } catch (Exception $e) {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Email Failed!',
                    text: 'Could not send email: " . addslashes($mail->ErrorInfo) . "'
                }).then(() => {
                    window.location.href = 'forgot_password.php';
                });
            </script>";
        }

    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Email Not Found',
                text: 'No account found with that email address.'
            }).then(() => {
                window.location.href = 'forgot_password.php';
            });
        </script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Invalid Request',
            text: 'Please submit the form properly.'
        }).then(() => {
            window.location.href = 'forgot_password.php';
        });
    </script>";
}

echo '</body></html>';
?>