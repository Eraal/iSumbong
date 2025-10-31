<?php
include('connectMySql.php');
include 'loginverification.php';

// Load environment variables
require_once('includes/env_loader.php');
loadEnv('.env');

$results = [];
$error_message = "";

if (logged_in()) {
    if (isset($_POST['test_categorization'])) {
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        
        if (empty($title) || empty($description)) {
            $error_message = "Please provide both title and description.";
        } else {
            // Get API key from environment variables
            $apiKey = env('OPENAI_API_KEY');
            if (!$apiKey) {
                $error_message = "OpenAI API key not found in environment variables.";
            } else {
                $prompt = "
                Base sa title at description, classify mo ito:

                Title: $title
                Description: $description

                Ibigay ang sagot sa JSON format lang na ganito. 
                Plain text lang, walang HTML tags tulad ng <br>. 
                Gamitin ang newline (\\n) para sa spacing. 

                RULE: Alamin muna ang pangunahing language ng Title at Description.
                - Kung mas marami ang English words, gamitin ang English sa suggestion.
                - Kung mas marami ang Filipino words, gamitin ang Filipino sa suggestion.
                - Isang language lang dapat, huwag halo-halo.

                {
                \"category\": \" \", Based sa title at description, identify kung anong cybersecurity category ito.,
                \"severity_level\": \"Low | Medium | High | Critical\",
                \"suggestion\": \"Preventive measures (paano maiwasan / how to avoid), bullet points na may paliwanag bawat isa.\\n\\n If it happens / If it happens, ilagay ang dapat gawin step-by-step, gamit ang parehong language na ginamit sa Title at Description.\"
                }
                ";

                $ch = curl_init("https://api.openai.com/v1/chat/completions");

                $data = [
                    "model" => "gpt-4o-mini",
                    "messages" => [
                        ["role" => "user", "content" => $prompt]
                    ],
                    "max_tokens" => 1000
                ];

                curl_setopt_array($ch, [
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => [
                        "Content-Type: application/json",
                        "Authorization: Bearer $apiKey",
                    ],
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => json_encode($data),
                    CURLOPT_TIMEOUT => 60,
                    CURLOPT_CONNECTTIMEOUT => 30,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_USERAGENT => 'iSUMBONG/1.0'
                ]);

                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $curlError = curl_error($ch);

                if ($curlError) {
                    $error_message = "Connection Error: " . $curlError;
                } elseif ($httpCode !== 200) {
                    $error_message = "API Error (HTTP $httpCode)";
                } elseif (!$response) {
                    $error_message = "No response from API";
                } else {
                    $result = json_decode($response, true);

                    if (isset($result['error'])) {
                        $error_message = "API Error: " . $result['error']['message'];
                    } elseif (isset($result['choices'][0]['message']['content'])) {
                        $content = trim($result['choices'][0]['message']['content']);
                        
                        // Store raw response for debugging
                        $results['raw_response'] = $content;
                        
                        $jsonData = json_decode($content, true);

                        if (!$jsonData) {
                            // Try to clean JSON response
                            $clean = preg_replace('/```(json)?/i', '', $content);
                            $clean = trim($clean);
                            $jsonData = json_decode($clean, true);
                        }

                        if ($jsonData && isset($jsonData['category'], $jsonData['severity_level'], $jsonData['suggestion'])) {
                            $results['category'] = $jsonData['category'];
                            $results['severity_level'] = $jsonData['severity_level'];
                            $results['suggestion'] = $jsonData['suggestion'];

                            if (is_array($results['suggestion'])) {
                                $results['suggestion'] = implode("\n", $results['suggestion']);
                            }

                            $results['suggestion'] = str_replace(
                                ["<br>", "<br/>", "<br />"], 
                                "\n", 
                                $results['suggestion']
                            );
                            
                            $results['success'] = true;
                        } else {
                            $error_message = "Failed to parse JSON response. Raw response saved for debugging.";
                            $results['json_error'] = json_last_error_msg();
                        }
                    } else {
                        $error_message = "No content in API response";
                        $results['api_response'] = $result;
                    }
                }

                curl_close($ch);
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>AI Categorization Tester - iSUMBONG</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    
    <style>
        .result-card {
            background: #f8f9fc;
            border: 1px solid #e3e6f0;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .severity-low { color: #28a745; }
        .severity-medium { color: #ffc107; }
        .severity-high { color: #fd7e14; }
        .severity-critical { color: #dc3545; }
        
        .suggestion-box {
            background: #ffffff;
            border: 1px solid #d1ecf1;
            border-radius: 0.25rem;
            padding: 1rem;
            white-space: pre-line;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
        }
        
        .sample-descriptions {
            background: #e2e3e5;
            border-radius: 0.25rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        .sample-item {
            cursor: pointer;
            padding: 0.5rem;
            margin-bottom: 0.5rem;
            background: white;
            border-radius: 0.25rem;
            border: 1px solid #dee2e6;
        }
        
        .sample-item:hover {
            background: #f8f9fa;
            border-color: #007bff;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include'user/sidebar.php';?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <?php include'user/nav.php';?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="container">
                        <div class="card o-hidden border-0 shadow-lg my-5">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="p-4">
                                            <div class="text-center mb-4">
                                                <h1 class="h3 text-gray-900">
                                                    <i class="fas fa-robot text-primary"></i>
                                                    AI Categorization Tester
                                                </h1>
                                                <p class="text-muted">Test how the AI categorizes different incident descriptions</p>
                                            </div>

                                            <!-- Sample Descriptions -->
                                            <div class="sample-descriptions">
                                                <h6><i class="fas fa-lightbulb"></i> Sample Descriptions (Click to use):</h6>
                                                
                                                <div class="sample-item" onclick="setSample('Unauthorized Facebook Login', 'May nag try mag login sa aking Facebook account na hindi ko ginawa. Nakatanggap ako ng notification sa email na may nag attempt mag login galing sa ibang device.')">
                                                    <strong>Facebook Unauthorized Login:</strong> May nag try mag login sa aking Facebook account...
                                                </div>
                                                
                                                <div class="sample-item" onclick="setSample('Phishing Email Received', 'Nakatanggap ako ng email na mukhang galing sa BPI bank na nagsasabing i-verify ko ang account ko. Suspicious kasi hindi ako may account sa BPI.')">
                                                    <strong>Phishing Email:</strong> Nakatanggap ako ng email na mukhang galing sa BPI bank...
                                                </div>
                                                
                                                <div class="sample-item" onclick="setSample('GCash Money Lost', 'Nabawasan ang pera ko sa GCash ng 5000 pesos without my knowledge. Hindi ko alam paano nangyari ito.')">
                                                    <strong>GCash Money Lost:</strong> Nabawasan ang pera ko sa GCash ng 5000 pesos...
                                                </div>
                                                
                                                <div class="sample-item" onclick="setSample('Suspicious Text Message', 'Received a text message saying I won 1 million pesos in a lottery I never joined. They are asking for personal information.')">
                                                    <strong>Lottery Scam:</strong> Received a text message saying I won 1 million pesos...
                                                </div>
                                                
                                                <div class="sample-item" onclick="setSample('Instagram Account Hacked', 'My Instagram account was compromised. Someone changed my password and posted inappropriate content on my profile.')">
                                                    <strong>Instagram Hack:</strong> My Instagram account was compromised...
                                                </div>
                                            </div>

                                            <!-- Test Form -->
                                            <form method="post" class="mb-4">
                                                <div class="row">
                                                    <div class="col-lg-12 mb-3">
                                                        <label for="title" class="form-label">
                                                            <i class="fas fa-heading"></i> Incident Title
                                                        </label>
                                                        <input type="text" class="form-control" id="title" name="title" 
                                                               placeholder="Enter incident title" 
                                                               value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required>
                                                    </div>
                                                    
                                                    <div class="col-lg-12 mb-3">
                                                        <label for="description" class="form-label">
                                                            <i class="fas fa-align-left"></i> Description
                                                        </label>
                                                        <textarea class="form-control" id="description" name="description" rows="5" 
                                                                  placeholder="Enter detailed description of the incident" required><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                                                    </div>
                                                    
                                                    <div class="col-lg-12 text-center">
                                                        <button type="submit" name="test_categorization" class="btn btn-primary">
                                                            <i class="fas fa-cogs"></i> Test AI Categorization
                                                        </button>
                                                        <button type="button" onclick="clearForm()" class="btn btn-secondary ml-2">
                                                            <i class="fas fa-eraser"></i> Clear
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>

                                            <!-- Results Section -->
                                            <?php if (!empty($results) || !empty($error_message)): ?>
                                            <div class="mt-4">
                                                <h5><i class="fas fa-chart-line"></i> Results:</h5>
                                                
                                                <?php if (!empty($error_message)): ?>
                                                <div class="alert alert-danger">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    <strong>Error:</strong> <?= htmlspecialchars($error_message) ?>
                                                    
                                                    <?php if (isset($results['raw_response'])): ?>
                                                    <details class="mt-2">
                                                        <summary>Raw API Response</summary>
                                                        <pre class="mt-2"><?= htmlspecialchars($results['raw_response']) ?></pre>
                                                    </details>
                                                    <?php endif; ?>
                                                </div>
                                                <?php endif; ?>

                                                <?php if (isset($results['success']) && $results['success']): ?>
                                                <div class="result-card">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6><i class="fas fa-tag"></i> Category:</h6>
                                                            <p class="font-weight-bold text-primary"><?= htmlspecialchars($results['category']) ?></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6><i class="fas fa-exclamation-circle"></i> Severity Level:</h6>
                                                            <p class="font-weight-bold severity-<?= strtolower($results['severity_level']) ?>">
                                                                <?= htmlspecialchars($results['severity_level']) ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mt-3">
                                                        <h6><i class="fas fa-lightbulb"></i> AI Suggestion:</h6>
                                                        <div class="suggestion-box">
                                                            <?= htmlspecialchars($results['suggestion']) ?>
                                                        </div>
                                                    </div>
                                                    
                                                    <?php if (isset($results['raw_response'])): ?>
                                                    <details class="mt-3">
                                                        <summary><i class="fas fa-code"></i> Raw JSON Response</summary>
                                                        <pre class="mt-2 bg-light p-2"><?= htmlspecialchars($results['raw_response']) ?></pre>
                                                    </details>
                                                    <?php endif; ?>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php include'user/footer.php';?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <script>
        function setSample(title, description) {
            document.getElementById('title').value = title;
            document.getElementById('description').value = description;
        }
        
        function clearForm() {
            document.getElementById('title').value = '';
            document.getElementById('description').value = '';
        }
    </script>

</body>

</html>
<?php
} else {
    header('location:index.php');
}
?>