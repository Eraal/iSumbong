-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2025 at 05:52 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ireport`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(11) NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`user_id`, `email`, `password`, `name`, `status`) VALUES
(1, 'admin@gmail.com', '123', 'admin', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `attachment`
--

CREATE TABLE `attachment` (
  `id` int(11) NOT NULL,
  `incident_id` varchar(255) DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `suggestion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `suggestion`) VALUES
(1, 'Phishing', '✅ PAANO MAIIWASAN ANG PHISHING (Preventive Tips)\nHuwag basta-basta mag-click ng links sa email o text.\n→ I-hover muna ang mouse sa link (kung nasa PC) para makita kung legit ang website.\n\nTingnan ang email address ng sender.\n→ Halimbawa, ang tunay na email ng isang bangko ay @bdo.com.ph at hindi @bdoph-login123.xyz.\n\nHuwag magbigay ng personal information online.\n→ Huwag isulat ang password, OTP, o account number sa kahit anong online form na hindi ka sigurado.\n\nGumamit ng 2-Factor Authentication (2FA).\n→ Dagdag na layer ng seguridad para kahit makuha ang password mo, hindi pa rin sila makakapasok agad.\n\nI-update ang antivirus at software regularly.\n→ Para may proteksyon ka sa mga bagong uri ng phishing attacks.\n\nMag-ingat sa mga urgent messages.\n→ \"Account Locked\", \"Immediate Action Needed\", o \"Free Prize\" ay kadalasang ginagamit sa phishing para madali kang mapa-click.\n\nI-check ang grammar at spelling.\n→ Karaniwang may maling grammar o kakaibang format ang phishing emails.\n\nGamitin ang official apps ng mga bangko o serbisyo.\n→ Huwag gumamit ng browser search lang; i-download ang verified apps sa Play Store o App Store.\n\n🚨 KUNG NAPHISHING KA NA (What to do step-by-step)\nI-disconnect agad sa internet.\n→ Para mapigilan ang tuloy-tuloy na pag-access ng attacker sa iyong device.\n\nPalitan kaagad ang mga password mo.\n→ Lalo na kung pareho ang password sa ibang accounts (email, social media, banking, etc.).\n\nI-enable ang 2FA (Two-Factor Authentication).\n→ Kahit alam na nila ang password mo, hindi pa rin sila makakapasok agad.\n\nI-scan ang device gamit ang updated antivirus.\n→ Baka may na-download kang malware o keylogger.\n\nI-report ang insidente sa ahensya o kumpanya.\n→ Halimbawa:\n\nBangko → tawagan ang customer service\n\nFacebook/Google → gamitin ang “Report a Problem”\n\nNational Computer Emergency Response Team (PH-CERT) → https://www.ncert.gov.ph\n\nI-monitor ang iyong accounts.\n→ Baka may kakaibang transactions o activities na nangyayari.\n\nMagpa-blotter kung may nawalang pera o sensitibong impormasyon.\n→ Para may legal record at ma-investigahan ng pulisya.\n\nMagturo sa iba.\n→ I-share ang experience mo para makaiwas rin ang iba sa phishing scams.\n\n'),
(2, 'Malware', '✅ PAANO MAIIWASAN ANG MALWARE (Preventive Tips)\nMag-install ng trusted antivirus o anti-malware software.\n→ Gumamit ng kilala at updated na antivirus (hal. Windows Defender, Avast, Malwarebytes).\n\nLaging i-update ang operating system at apps.\n→ Updates often include security patches para di ka mapasok ng bagong uri ng malware.\n\nIwasang mag-download ng pirated software o movies.\n→ Madalas, may kasamang malware ang mga ito (lalo na sa .exe files at cracked apps).\n\nHuwag mag-click ng pop-up ads or “Free Download” buttons.\n→ Madalas itong nagdadala ng unwanted software o virus.\n\nMag-download lang mula sa official websites o app stores.\n→ Iwasan ang third-party APKs at hindi kilalang installer sources.\n\nMag-ingat sa USB o external drives.\n→ I-scan muna bago buksan, lalo na kung galing sa ibang tao.\n\nHuwag i-disable ang security settings ng device mo.\n→ Halimbawa: Huwag i-off ang firewall o allow unknown sources kung hindi kailangan.\n\nMag-backup ng important files regularly.\n→ Para kung mahawa ng malware gaya ng ransomware, may kopya ka pa rin ng files.\n\n🚨 KUNG NAHAWA KA NA NG MALWARE (What to do step-by-step)\nI-disconnect agad sa internet.\n→ Para di na kumalat pa ang malware o makapagpadala ng data online.\n\nGamitin ang antivirus para mag full scan.\n→ Pa-scannin agad ang buong system, hindi lang quick scan.\n\nI-delete o i-quarantine ang infected files.\n→ Sundin ang rekomendasyon ng antivirus tool kung ano ang dapat gawin sa infected items.\n\nGamitin ang Safe Mode (Windows) o Recovery Mode (Mac).\n→ Para mas madaling alisin ang malware na hindi tumatakbo agad pag start-up.\n\nTanggalin ang unknown programs sa Control Panel (Windows) o Applications (Mac).\n→ Baka may na-install na hindi mo alam na siya palang malware.\n\nI-reset ang browser settings.\n→ Kung nagbabago ang homepage mo o may sariling search engine na lumalabas, baka browser hijacker ‘yan.\n\nIbalik ang backup kung sobrang dami na ng na-infect.\n→ Minsan mas okay nang i-reformat kaysa magkalat pa ang malware.\n\nPalitan ang lahat ng passwords mo pagkatapos maalis ang malware.\n→ Lalo na kung may keylogger ang malware na naka-record ng mga pinindot mong keys.\n\nMag-report kung ang malware ay nanggaling sa email o company system.\n→ Para ma-contain din agad sa network.'),
(3, 'Unauthorized Access', '✅ PAANO MAIIWASAN ANG UNAUTHORIZED ACCESS\nGumamit ng malalakas at unique na password.\n→ Iwasan ang mga password tulad ng 123456, password, birthday, o pangalan mo.\n\nI-activate ang Two-Factor Authentication (2FA).\n→ Kahit alam ng attacker ang password mo, di pa rin sila makakapasok agad.\n\nHuwag i-save ang password sa public or shared computers.\n→ Iwasang mag-check ng “Remember Me” sa mga public device.\n\nI-lock ang iyong device kapag iiwanan.\n→ Gumamit ng password, PIN, fingerprint o facial recognition.\n\nRegular na mag-log out ng accounts.\n→ Lalo na sa mga banking, email, o government-related apps.\n\nI-monitor ang login history kung may ganitong option.\n→ Halimbawa: Google at Facebook ay nagpapakita kung saan at kailan ka nag-login.\n\nIwasang gumamit ng public Wi-Fi sa pag-access ng sensitibong accounts.\n→ Kung kailangan, gumamit ng VPN.\n\nGumamit ng antivirus/firewall.\n→ Para maprotektahan ang device mo laban sa keyloggers o spyware.\n\nMag-ingat sa mga phishing links at scam websites.\n→ Maaaring dito nila makuha ang login credentials mo.\n\n🚨 KUNG MAY UNAUTHORIZED ACCESS NA (What to do step-by-step)\nPalitan kaagad ang password ng affected account.\n→ Gumamit ng mas malakas at hindi pa nagamit na password.\n\nLog out sa lahat ng devices.\n→ Halimbawa: Sa Facebook, may option na “Log Out of All Sessions”.\n\nI-enable ang 2FA kung wala pa.\n→ Para hindi na maulit.\n\nI-check ang settings ng account.\n→ Baka may binago sila gaya ng recovery email, phone number, or privacy settings.\n\nI-scan ang device mo para sa malware o spyware.\n→ Baka meron kang unknowingly na-install na keylogger.\n\nI-report ang insidente sa provider ng service.\n→ Email? I-report sa Gmail/Yahoo. Bank account? Tawagan ang bangko agad.\n\nMag-monitor ng unusual activity.\n→ Halimbawa: mga biglaang transactions, bagong contacts, or sent messages na hindi ikaw ang gumawa.\n\nSabihan ang mga contact mo kung may possibility na ginamit ang account para mang-scam.\n→ Halimbawa: kung na-access ang iyong Facebook, baka may napadalhan ng scam messages.');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `incident_id` int(11) DEFAULT NULL,
  `user_id` text DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incident`
--

CREATE TABLE `incident` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `description` text NOT NULL,
  `system_affected` varchar(255) NOT NULL,
  `severity_level` varchar(50) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `role` varchar(100) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `systems_affected` text DEFAULT NULL,
  `estimated_impact` varchar(100) DEFAULT NULL,
  `critical_infra` enum('yes','no') DEFAULT NULL,
  `observed_impact` text DEFAULT NULL,
  `actions_taken` text DEFAULT NULL,
  `incident_contained` enum('yes','no') DEFAULT NULL,
  `notified` varchar(255) DEFAULT NULL,
  `evidence_logs` tinyint(1) DEFAULT 0,
  `evidence_screenshots` tinyint(1) DEFAULT 0,
  `evidence_email` tinyint(1) DEFAULT 0,
  `evidence_other` tinyint(1) DEFAULT 0,
  `additional_info` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) DEFAULT 'PENDING',
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(11) NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `name`, `status`) VALUES
(1, 'test@gmail.com', '123', 'Juan', 'ACTIVE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `attachment`
--
ALTER TABLE `attachment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incident`
--
ALTER TABLE `incident`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `attachment`
--
ALTER TABLE `attachment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `incident`
--
ALTER TABLE `incident`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
