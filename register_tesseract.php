<?php
// Optional: load .env and helper env() if present
@require_once __DIR__ . '/includes/env_loader.php';
if (function_exists('loadEnv')) {
    // Try loading a .env from project root (no error if missing)
    @loadEnv(__DIR__ . '/.env');
}

// Helper: determine an available tesseract binary path
function detectTesseractPath() {
    // 1) Prefer explicit env configuration
    $envPath = function_exists('env') ? env('TESSERACT_PATH') : getenv('TESSERACT_PATH');
    if ($envPath && file_exists($envPath)) {
        return $envPath;
    }

    // 2) Platform-aware sensible defaults
    if (stripos(PHP_OS_FAMILY, 'Windows') !== false) {
        $candidates = [
            'C:\\Program Files\\Tesseract-OCR\\tesseract.exe',
            'C:\\Program Files (x86)\\Tesseract-OCR\\tesseract.exe',
        ];
        foreach ($candidates as $c) {
            if (file_exists($c)) return $c;
        }
        // Fallback to just 'tesseract' (must be in PATH)
        return 'tesseract';
    }

    // 3) Linux/Unix default assumes it's in PATH
    // Common full paths checked first
    $linuxCandidates = ['/usr/bin/tesseract', '/usr/local/bin/tesseract'];
    foreach ($linuxCandidates as $c) {
        if (file_exists($c)) return $c;
    }
    return 'tesseract';
}

// Helper: check if exec is enabled
function isExecEnabled() {
    if (!function_exists('exec')) return false;
    $disabled = ini_get('disable_functions');
    if (!$disabled) return true;
    return stripos($disabled, 'exec') === false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = basename($_FILES["id_image"]["name"]);
    // Slightly randomize to avoid collisions on the server
    $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $fileName);
    $targetFile = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES["id_image"]["tmp_name"], $targetFile)) {
        // Output text file (without extension)
        $outputFile = $uploadDir . "output_" . uniqid();

        if (!isExecEnabled()) {
            $status = "OCR failed: PHP exec() is disabled by server configuration. Please enable exec or switch to a library that doesn't require shell access.";
        } else {
            // Build command safely
            $tesseractPath = detectTesseractPath();
            $binary = $tesseractPath;
            // Quote the binary if it contains spaces and isn't already quoted
            if (preg_match('/\s/', $binary) && $binary[0] !== '"') {
                $binary = '"' . $binary . '"';
            }

            $cmd = $binary . ' ' . escapeshellarg($targetFile) . ' ' . escapeshellarg($outputFile) . ' -l eng';
            $output = [];
            $return_var = null;
            exec($cmd . ' 2>&1', $output, $return_var);

            if ($return_var === 0 && file_exists($outputFile . ".txt")) {
                $extractedText = file_get_contents($outputFile . ".txt");

                // Normalize text
                $cleanText = preg_replace('/\s+/', ' ', $extractedText);

                // Check for "Siniloan, Laguna"
                if (stripos($cleanText, "Siniloan, Laguna") !== false) {
                    $status = "✅ Registration Successful (Siniloan, Laguna found)";
                } else {
                    $status = "❌ Registration Failed (Siniloan, Laguna not found)";
                }
            } else {
                // Common failure hinting
                if ($return_var === 127) {
                    $status = "OCR failed: Tesseract binary not found (exit 127). Install Tesseract on the server and/or set TESSERACT_PATH in a .env file.\n\nCommand: $cmd\nOutput:\n" . implode("\n", $output);
                } else {
                    $status = "OCR failed. Exit code: $return_var\nCommand: $cmd\nOutput:\n" . implode("\n", $output);
                }
            }
        }
    } else {
        $status = "File upload failed.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <style>
        .result {
            margin-top: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            white-space: pre-wrap;
            background: #f9f9f9;
            font-family: monospace;
        }
    </style>
</head>

<body>
    <form method="post" enctype="multipart/form-data">
        Upload ID: <input type="file" name="id_image" required><br><br>
        <button type="submit">Check Address</button>
    </form>

    <?php if (!empty($status)): ?>
        <div class="result">
            <strong>Status:</strong><br>
            <?php echo htmlspecialchars($status); ?>
        </div>
    <?php endif; ?>
</body>

</html>