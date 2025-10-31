<?php
include '../../connectMySql.php';
include '../../loginverification.php';
include '../../includes/theme_system.php';
if (logged_in()) {
    $type = isset($_GET['type']) ? strtolower(trim($_GET['type'])) : '';

    $map = [
        'phishing' => [
            'title' => 'Phishing Attacks',
            'icon' => 'fas fa-envelope',
            'color' => '#c0392b',
            'html' => '<h6 class="font-weight-bold">Ano ang Phishing?</h6>
                <p>Ang phishing ay isang cybercrime kung saan ang mga attacker ay nagpapanggap na legitimate na organization para magnakaw ng sensitive na impormasyon tulad ng passwords, credit card numbers, o personal data.</p>
                <h6 class="font-weight-bold mt-3">Mga Common Signs:</h6>
                <ul>
                    <li>Urgent o threatening na wika</li>
                    <li>Suspicious na sender addresses</li>
                    <li>Generic na pagbati ("Dear Customer")</li>
                    <li>Humihingi ng sensitive na information</li>
                    <li>Suspicious na links o attachments</li>
                </ul>
                <h6 class="font-weight-bold mt-3">Protection Tips:</h6>
                <ul>
                    <li>I-verify ang sender identity sa official channels</li>
                    <li>Huwag mag-click ng suspicious links</li>
                    <li>Tingnan mabuti ang URLs</li>
                    <li>Gumamit ng email filters at security software</li>
                </ul>'
        ],
        'malware' => [
            'title' => 'Malware Threats',
            'icon' => 'fas fa-bug',
            'color' => '#e67e22',
            'html' => '<h6 class="font-weight-bold">Ano ang Malware?</h6>
                <p>Ang malware (malicious software) ay ginawa para sirain, guluhin, o makakuha ng unauthorized access sa computer systems.</p>
                <h6 class="font-weight-bold mt-3">Mga Uri ng Malware:</h6>
                <ul>
                    <li>Viruses - Mga programa na kumakalat mag-isa</li>
                    <li>Trojans - Nakatagong malicious software</li>
                    <li>Ransomware - Nag-e-encrypt ng files para sa ransom</li>
                    <li>Spyware - Lihim na nag-monitor ng activity</li>
                    <li>Adware - Nagpapakita ng hindi gustong advertisements</li>
                </ul>
                <h6 class="font-weight-bold mt-3">Prevention:</h6>
                <ul>
                    <li>Mag-install ng trusted antivirus software</li>
                    <li>I-update ang software palagi</li>
                    <li>Iwasan ang suspicious downloads</li>
                    <li>Regular system scans</li>
                </ul>'
        ],
        'unauthorized' => [
            'title' => 'Unauthorized Access',
            'icon' => 'fas fa-lock-open',
            'color' => '#2980b9',
            'html' => '<h6 class="font-weight-bold">Ano ang Unauthorized Access?</h6>
                <p>Ang unauthorized access ay nangyayari kapag may taong nakakuha ng access sa computer system, network, o data nang walang permission.</p>
                <h6 class="font-weight-bold mt-3">Mga Common Methods:</h6>
                <ul>
                    <li>Password attacks (brute force, dictionary)</li>
                    <li>Social engineering</li>
                    <li>Pag-exploit ng security vulnerabilities</li>
                    <li>Physical access sa mga devices</li>
                    <li>Man-in-the-middle attacks</li>
                </ul>
                <h6 class="font-weight-bold mt-3">Security Measures:</h6>
                <ul>
                    <li>Malakas at unique na passwords</li>
                    <li>Two-factor authentication</li>
                    <li>Regular security updates</li>
                    <li>Access control at monitoring</li>
                    <li>Secure physical access</li>
                </ul>'
        ],
        'cyberbullying' => [
            'title' => 'Cyberbullying',
            'icon' => 'fas fa-user-slash',
            'color' => '#8e44ad',
            'html' => '<h6 class="font-weight-bold">Ano ang Cyberbullying?</h6>
                <p>Ang cyberbullying ay paggamit ng digital platforms para mang-harass, mang-intimidate, o mang-threaten ng mga tao, madalas na paulit-ulit at may intensyon na makasakit.</p>
                <h6 class="font-weight-bold mt-3">Mga Uri ng Cyberbullying:</h6>
                <ul>
                    <li>Harassment sa pamamagitan ng messages</li>
                    <li>Public shaming o pagkakahiya</li>
                    <li>Pagkalat ng fake na impormasyon</li>
                    <li>Pag-exclude sa online groups</li>
                    <li>Identity theft para sa harassment</li>
                </ul>
                <h6 class="font-weight-bold mt-3">Paano Tumugon:</h6>
                <ul>
                    <li>I-document ang evidence</li>
                    <li>I-block ang aggressor</li>
                    <li>I-report sa platform administrators</li>
                    <li>Humingi ng support sa trusted na tao</li>
                    <li>Isaalang-alang ang legal action kung kailangan</li>
                </ul>'
        ],
        'identity' => [
            'title' => 'Identity Theft',
            'icon' => 'fas fa-id-card',
            'color' => '#229954',
            'html' => '<h6 class="font-weight-bold">Ano ang Identity Theft?</h6>
                <p>Ang identity theft ay nangyayari kapag may nagnakaw ng personal information para magpanggap na ibang tao para sa financial gain o iba pang masasamang layunin.</p>
                <h6 class="font-weight-bold mt-3">Target na Information:</h6>
                <ul>
                    <li>Social Security numbers</li>
                    <li>Credit card information</li>
                    <li>Bank account details</li>
                    <li>Personal identifying information</li>
                    <li>Login credentials</li>
                </ul>
                <h6 class="font-weight-bold mt-3">Protection Strategies:</h6>
                <ul>
                    <li>I-monitor ang credit reports regularly</li>
                    <li>I-secure ang personal documents</li>
                    <li>Mag-ingat sa personal information online</li>
                    <li>Gumamit ng identity monitoring services</li>
                    <li>I-report agad ang suspicious activity</li>
                </ul>'
        ],
        'fraud' => [
            'title' => 'Online Fraud',
            'icon' => 'fas fa-credit-card',
            'color' => '#f39c12',
            'html' => '<h6 class="font-weight-bold">Ano ang Online Fraud?</h6>
                <p>Ang online fraud ay mga deceptive schemes na ginagawa sa internet para magnakaw ng pera, personal information, o iba pang valuable things sa mga victims.</p>
                <h6 class="font-weight-bold mt-3">Mga Common Types:</h6>
                <ul>
                    <li>Credit card fraud</li>
                    <li>Investment scams</li>
                    <li>Online shopping fraud</li>
                    <li>Romance scams</li>
                    <li>Advance fee fraud</li>
                </ul>
                <h6 class="font-weight-bold mt-3">Mga Red Flags:</h6>
                <ul>
                    <li>Mga offer na "too good to be true"</li>
                    <li>Pressure na mag-act agad</li>
                    <li>Humihingi ng upfront payments</li>
                    <li>Hindi mo hiniling na contact</li>
                    <li>Poor grammar o spelling</li>
                </ul>'
        ],
    ];

    $item = $map[$type] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Threat Details - iReport</title>
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
    <?php echo getThemeMeta(); ?>
    <?php echo getThemeIncludes('../../'); ?>
</head>
<body>
<div class="container-fluid p-0">
    <?php include '../nav.php'; ?>
    <div class="container py-5">
        <?php if ($item): ?>
            <div class="card shadow-sm" style="border:none; border-radius:1rem;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div style="width:60px;height:60px;border-radius:12px;background:<?= htmlspecialchars($item['color']) ?>;display:flex;align-items:center;justify-content:center;" class="mr-3">
                            <i class="<?= htmlspecialchars($item['icon']) ?> text-white fa-lg"></i>
                        </div>
                        <h4 class="mb-0 font-weight-bold"><?= htmlspecialchars($item['title']) ?></h4>
                    </div>
                    <div class="text-dark">
                        <?= $item['html'] ?>
                    </div>
                    <div class="mt-4 d-flex">
                        <a href="../incident/register.php" class="btn btn-danger mr-2"><i class="fas fa-exclamation-triangle mr-2"></i>I-report ang Incident</a>
                        <a href="./" class="btn btn-outline-secondary">← Bumalik sa Threats</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">Hindi makita ang threat na hinahanap mo.</div>
            <a href="./" class="btn btn-primary">Bumalik sa Threats</a>
        <?php endif; ?>
    </div>
    <?php include '../footer.php'; ?>
</div>
<script src="../../vendor/jquery/jquery.min.js"></script>
<script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../js/sb-admin-2.min.js"></script>
</body>
</html>
<?php } else { header('location:../../index.php'); } ?>
