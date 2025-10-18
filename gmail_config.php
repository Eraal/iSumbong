<?php
// Gmail SMTP Configuration for iREPORT
// Replace with your actual Gmail credentials

// SMTP Settings
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'ireport211@gmail.com'); // Replace with your Gmail address
define('SMTP_PASSWORD', 'zjol lwct tqfg sokf');    // Replace with your Gmail App Password
define('SMTP_ENCRYPTION', 'tls');

// Email Settings
define('FROM_EMAIL', 'ireport211@gmail.com');    // Replace with your Gmail address
define('FROM_NAME', 'iREPORT System');
define('REPLY_TO_EMAIL', 'ireport211@gmail.com'); // Replace with your Gmail address

// Verification Settings
define('VERIFICATION_BASE_URL', 'http://localhost/iSUMBONG/verify.php'); // Adjust if needed

/*
SETUP INSTRUCTIONS:
1. Enable 2-Step Verification on your Gmail account
2. Generate an App Password:
   - Go to Google Account settings
   - Security → 2-Step Verification → App passwords
   - Generate password for "Mail"
3. Replace 'your-email@gmail.com' with your actual Gmail address
4. Replace 'your-app-password' with the generated App Password
5. Update VERIFICATION_BASE_URL if your site URL is different

SECURITY NOTE:
- Never commit this file with real credentials to version control
- Use environment variables in production
- App Password is different from your regular Gmail password
*/
?>
