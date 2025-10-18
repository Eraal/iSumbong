<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = basename($_FILES["id_image"]["name"]);
    $targetFile = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES["id_image"]["tmp_name"], $targetFile)) {
        // Output text file (without extension)
        $outputFile = $uploadDir . "output_" . uniqid();

        $tesseractPath = "\"C:\\Users\\User\\AppData\\Local\\Programs\\Tesseract-OCR\\tesseract.exe\""; // Default path, will be updated if needed

        $cmd = $tesseractPath . " " . escapeshellarg($targetFile) . " " . escapeshellarg($outputFile) . " -l eng";
        exec($cmd . " 2>&1", $output, $return_var);

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
            $status = "OCR failed. Debug: " . implode("\n", $output);
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