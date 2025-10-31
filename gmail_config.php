<?php
// Gmail SMTP Configuration for iSUMBONG
// Credentials are now stored securely in .env file

// Handle different include paths depending on where this file is called from
$base_path = dirname(__FILE__);
if (file_exists($base_path . '/includes/env_loader.php')) {
    require_once($base_path . '/includes/env_loader.php');
} elseif (file_exists($base_path . '/../../includes/env_loader.php')) {
    require_once($base_path . '/../../includes/env_loader.php');
} else {
    // Fallback - try to find it
    require_once(dirname(__FILE__) . '/includes/env_loader.php');
}

// Load .env file with correct path
$env_path = $base_path . '/.env';
if (!file_exists($env_path)) {
    $env_path = dirname(__FILE__) . '/.env';
}
loadEnv($env_path);

// SMTP Settings (allow overrides from .env)
define('SMTP_HOST', env('SMTP_HOST', 'smtp.gmail.com'));
define('SMTP_PORT', (int) env('SMTP_PORT', 587));
define('SMTP_USERNAME', env('SMTP_USERNAME'));
define('SMTP_PASSWORD', env('SMTP_PASSWORD'));
define('SMTP_ENCRYPTION', env('SMTP_ENCRYPTION', 'tls'));

// Email Settings (allow overrides; default to SMTP username)
define('FROM_EMAIL', env('FROM_EMAIL', env('SMTP_USERNAME')));
define('FROM_NAME', env('FROM_NAME', 'iSUMBONG System'));
define('REPLY_TO_EMAIL', env('REPLY_TO_EMAIL', env('SMTP_USERNAME')));

// Verification Settings - Uses environment variable for flexibility
$app_url = env('APP_URL', 'http://localhost/iSUMBONG');
define('VERIFICATION_BASE_URL', $app_url . '/verify.php');

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
