-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2025 at 07:37 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `isumbong`
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
(1, 'ireport211@gmail.com', 'admin123', 'admin', 'ACTIVE');

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

--
-- Dumping data for table `attachment`
--

INSERT INTO `attachment` (`id`, `incident_id`, `attachment`, `filename`) VALUES
(35, '5', '../../uploads/1751179818_Screenshot 2025-01-30 114612.png', 'Screenshot 2025-01-30 114612.png'),
(36, '6', '../../uploads/1751256410_Screenshot 2025-06-29 122621.png', 'Screenshot 2025-06-29 122621.png'),
(37, '7', '../../uploads/1751380762_Screenshot 2025-01-24 151222.png', 'Screenshot 2025-01-24 151222.png'),
(38, '8', '../../uploads/1751606137_Screenshot 2025-01-24 151222.png', 'Screenshot 2025-01-24 151222.png'),
(39, '9', '../../uploads/1751943945_Screenshot 2025-01-24 151222.png', 'Screenshot 2025-01-24 151222.png'),
(40, '10', '../../uploads/1752269073_Screenshot 2025-01-31 130631.png', 'Screenshot 2025-01-31 130631.png'),
(41, '11', '../../uploads/1752537004_Screenshot 2025-01-24 151222.png', 'Screenshot 2025-01-24 151222.png'),
(42, '12', '../../uploads/1752538290_Screenshot 2025-01-31 130631.png', 'Screenshot 2025-01-31 130631.png'),
(43, '13', '../../uploads/1752551960_Screenshot 2025-07-15 092304.png', 'Screenshot 2025-07-15 092304.png'),
(44, '14', '../../uploads/1756263649_Screenshot 2025-07-25 222722.png', 'Screenshot 2025-07-25 222722.png'),
(45, '15', '../../uploads/1756708964_Screenshot 2025-09-01 135320.png', 'Screenshot 2025-09-01 135320.png'),
(46, '16', '../../uploads/1756916875_NAG.png', 'NAG.png'),
(47, '39', '../../uploads/1760164267_Screenshot 2025-10-11 141057.png', 'Screenshot 2025-10-11 141057.png'),
(48, '40', '../../uploads/1760182766_system_context.drawio.png', 'system_context.drawio.png'),
(49, '41', '../../uploads/1760183044_system_context.drawio.png', 'system_context.drawio.png'),
(50, '42', '../../uploads/1760590487_test1.png', 'test1.png'),
(52, '43', '../../uploads/1760596204_test1.png', 'test1.png'),
(53, '44', '../../uploads/1760750125_test1.png', 'test1.png'),
(56, '49', '../../uploads/1760929935_test1.png', 'test1.png'),
(62, '49', '../../uploads/1760935655_test1.png', 'test1.png'),
(65, '52', '../../uploads/1761029162_test1.png', 'test1.png'),
(66, '52', '../../uploads/1761072065_test1.png', 'test1.png'),
(67, '53', '../../uploads/1761073178_test1.png', 'test1.png'),
(68, '53', '../../uploads/1761073691_report.png', 'report.png'),
(69, '54', '../../uploads/68f7dc6247ded_1761074274_report.png', 'report.png'),
(70, '55', '../../uploads/68f7dca85093d_1761074344_report.png', 'report.png'),
(71, '56', '../../uploads/68f86f0f8738a_1761111823_report.png', 'report.png'),
(76, '54', '../../uploads/68f92d73c2c4f_1761160563_test1.png', 'test1.png'),
(77, '55', '../../uploads/68f92f7789bce_1761161079_test1.png', 'test1.png'),
(78, '56', '../../uploads/68f9397801fcc_1761163640_test1.png', 'test1.png'),
(82, '60', '../../uploads/68f96e07ead8c_1761177095_test1.png', 'test1.png'),
(84, '62', '../../uploads/690058b8cce7a_1761630392_test1.png', 'test1.png'),
(85, '63', '../../uploads/69005b196d688_1761631001_test1.png', 'test1.png'),
(86, '64', '../../uploads/69005c1a665b5_1761631258_test1.png', 'test1.png'),
(89, '67', '../../uploads/6900d5197a892_1761662233_test1.png', 'test1.png'),
(90, '68', '../../uploads/6900e0d559b5a_1761665237_test1.png', 'test1.png'),
(91, '69', '../../uploads/6900fef76a8bb_1761672951_test1.png', 'test1.png'),
(92, '61', '../../uploads/690107bfe30ef_1761675199_mark1.png', 'mark1.png'),
(93, '62', '../../uploads/690109b4c64bf_1761675700_mark1.png', 'mark1.png'),
(94, '63', '../../uploads/69010acd2328a_1761675981_mark1.png', 'mark1.png'),
(95, '64', '../../uploads/69010bb3005b7_1761676211_mark1.png', 'mark1.png'),
(96, '65', '../../uploads/69010cf823c6b_1761676536_mark1.png', 'mark1.png');

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

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `incident_id`, `user_id`, `comment`, `date`) VALUES
(10, 7, 'admin', 'wait for investigation', '2025-07-01 22:48:21'),
(11, 7, 'Mark Ruiz', 'can you help me\r\n', '2025-07-01 23:04:28'),
(12, 9, 'Mark Ruiz', 'how', '2025-07-12 04:29:14'),
(13, 8, 'Mark Ruiz', '', '2025-07-12 06:07:56'),
(14, 8, 'Mark Ruiz', 'what is the update', '2025-07-12 06:08:11'),
(15, 14, 'Mark Ruiz', 'NEED HELP ', '2025-08-27 11:16:45'),
(17, 14, 'admin', 'Wait for 3days for processing and reviewing your report thank you\r\n', '2025-08-27 11:24:59'),
(18, 14, 'admin', 'Wait for 3days for processing and reviewing your report thank you\r\n', '2025-08-27 11:25:32'),
(19, 14, 'admin', 'Wait for 3days for processing and reviewing your report thank you\r\n', '2025-08-27 11:25:50'),
(20, 15, 'Jose Rizal', 'help', '2025-09-02 12:06:37'),
(21, 36, 'Kenny', 'TestComment', '2025-09-22 17:36:39'),
(22, 36, 'admin', 'Resolved', '2025-09-22 17:37:54'),
(26, 68, 'Danna Rosales', 'test\r\n', '2025-10-29 01:39:53');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `incident_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` tinyint(4) NOT NULL CHECK (`rating` between 1 and 5),
  `improvements` set('Resolution Speed','Data Privacy','Transparency','Response Time','Accessibility','Polite Communication') DEFAULT NULL,
  `comment` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `incident_id`, `user_id`, `rating`, `improvements`, `comment`, `created_at`) VALUES
(1, 36, 42, 3, 'Resolution Speed,Data Privacy', 'Test', '2025-09-22 15:50:02'),
(2, 37, 42, 5, 'Resolution Speed,Data Privacy,Transparency,Response Time,Accessibility,Polite Communication', 'test2', '2025-09-22 16:45:28');

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
  `location` varchar(255) DEFAULT NULL,
  `severity_level` varchar(50) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `notified` varchar(255) DEFAULT NULL,
  `evidence_logs` tinyint(1) DEFAULT 0,
  `evidence_screenshots` tinyint(1) DEFAULT 0,
  `evidence_email` tinyint(1) DEFAULT 0,
  `evidence_other` tinyint(1) DEFAULT 0,
  `additional_info` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) DEFAULT 'PENDING',
  `user_id` int(11) DEFAULT NULL,
  `suggestion` text DEFAULT NULL,
  `user_deleted` tinyint(1) DEFAULT 0 COMMENT 'Flag to mark incidents as deleted from user view',
  `deleted_by_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `incident`
--

INSERT INTO `incident` (`id`, `title`, `category`, `date`, `description`, `location`, `severity_level`, `full_name`, `address`, `email`, `phone`, `notified`, `evidence_logs`, `evidence_screenshots`, `evidence_email`, `evidence_other`, `additional_info`, `created_at`, `status`, `user_id`, `suggestion`, `user_deleted`, `deleted_by_admin`) VALUES
(36, 'TestReport1', 'Phishing', '2025-09-22 15:37:00', 'TestDescription\n\nLocation: Siniloan, Laguna\nReporter Address: Test', NULL, 'Medium', 'k3nnken', NULL, 'kenneth@gmail.com', 'Test', '', 0, 1, 0, 0, '0', '2025-09-22 09:36:11', 'RESOLVED', 42, 'Preventive measures:\n- Always verify the sender&#039;s email address before clicking on any links or downloading attachments. This helps to ensure that the communication is legitimate.\n- Use multi-factor authentication for your accounts to add an extra layer of security.\n- Regularly update your software and antivirus programs to protect against new threats.\n\n If it happens:\n1. Do not click on any links or download attachments from suspicious emails.\n2. Change your passwords immediately, especially for important accounts.\n3. Report the phishing attempt to your email provider and relevant authorities.', 0, 0),
(37, 'Test2', 'Phishing', '2025-09-22 08:35:00', 'test2\n\nLocation: gege\nReporter Address: test', NULL, 'Low', 'kenny', NULL, 'kenny@gmail.com', 'test', '', 0, 0, 0, 0, '0', '2025-09-22 16:35:31', 'RESOLVED', 42, 'Preventive measures:\n\n - Always verify the source of emails or messages before clicking on any links.\n - Use strong, unique passwords for each of your accounts to minimize risk.\n - Enable two-factor authentication wherever possible to add an extra layer of security.\n - Keep your software and security systems up to date to protect against vulnerabilities.\n\n If it happens:\n - Do not click on any links or provide personal information.\n - Report the incident to your IT department or security team.\n - Change passwords for affected accounts immediately.\n - Scan your devices for malware using updated antivirus software.', 0, 0),
(38, 'test3', 'Phishing', '2025-09-16 03:51:00', 'test\n\nLocation: test\nReporter Address: ', NULL, 'Low', 'test3', NULL, 'testUser1@gmail.com', '', '', 0, 0, 0, 0, '0', '2025-09-22 16:51:25', 'in_progress', 42, 'Preventive measures:\n\n- Be cautious of unsolicited emails or messages that ask for personal information. Always verify the sender&#039;s identity before responding.\n- Use strong, unique passwords for your online accounts and enable two-factor authentication for added security.\n- Regularly update your software and antivirus programs to protect against the latest threats.\n\n If it happens:\n1. Disconnect from the internet immediately to prevent further damage.\n2. Change your passwords for affected accounts as soon as possible.\n3. Report the incident to your email provider or IT department for assistance.', 0, 0),
(53, 'unauthorized login in facebook', 'Unauthorized Access', '2025-10-22 02:58:00', 'mag nag notify sakin na mag gustong mag login ng facebook account ko sa ibang device', '164 Siniloan, Laguna', 'Medium', 'Mark Ruiz', 'Siniloan, Laguna', 'makmak032900@gmail.com', '09092771339', '', 0, 1, 0, 0, '', '2025-10-21 18:59:38', 'PENDING', 46, 'Preventive measures:\n\n- I-enable ang Two-Factor Authentication (2FA) sa iyong Facebook account upang madagdagan ang seguridad.\n- Gumamit ng malakas at natatanging password na hindi madaling mahulaan.\n- Regular na suriin ang mga login activity sa iyong account upang makita kung may mga kahina-hinalang aktibidad.\n\n If it happens:\n1. I-reset ang iyong password agad upang hindi makapasok ang hindi awtorisadong tao.\n2. I-enable ang 2FA kung hindi pa ito naka-enable.\n3. Suriin ang mga nakaraang login attempts at i-report ang anumang kahina-hinalang aktibidad sa Facebook.\n4. Kung kinakailangan, i-logout ang lahat ng iba pang devices na naka-login sa iyong account.', 1, 0),
(54, 'someone wants to login my account', 'Account Security', '2025-10-23 03:14:00', 'someone trying to login my facebook account on another device', 'Siniloan, Laguna', 'High', 'Mark Ruiz', 'Siniloan, Laguna', 'makmak032900@gmail.com', '09092771339', '', 0, 1, 0, 0, '', '2025-10-22 19:16:03', 'PENDING', 46, 'Preventive measures:\n\n- Enable Two-Factor Authentication (2FA):\n  Ito ay nagdaragdag ng karagdagang layer ng seguridad sa iyong account. Kapag may nag-login, kailangan ng isang code na ipinapadala sa iyong telepono o email.\n\n- Regularly Update Passwords:\n  Siguraduhin na ang iyong password ay mahirap hulaan at regular na ito ay pinapalitan upang maiwasan ang hindi awtorisadong pag-access.\n\n- Monitor Account Activity:\n  Tingnan ang mga aktibidad sa iyong account. Kung mayroong hindi pamilyar na aktibidad, agad na baguhin ang iyong password.\n\n If it happens:\n1. Change your password immediately.\n2. Log out of all devices from the account settings.\n3. Review recent activity and report any unauthorized access to Facebook.\n4. Notify your contacts if you think they may be at risk.', 1, 0),
(55, 'may naglogin ng account ko sa facebbok', 'Account Compromise', '2025-10-23 03:23:00', 'may nag login ng account ko sa faebook gamit ang ibang device', 'Siniloan, Laguna', 'Medium', 'Mark Ruiz', 'Siniloan, Laguna', 'makmak032900@gmail.com', '09092771339', '', 0, 1, 0, 0, '', '2025-10-22 19:24:39', 'PENDING', 46, 'Preventive measures:\n\n- Gumamit ng malakas na password: Siguraduhing ang password ay mahirap hulaan.\n- I-enable ang two-factor authentication: Dagdag na seguridad para sa iyong account.\n- Huwag ibahagi ang iyong account credentials: Panatilihing lihim ang iyong impormasyon.\n- Regular na suriin ang mga aktibidad sa iyong account: Tiyaking walang ibang gumagamit sa iyong account.\n\nIf it happens:\n1. I-reset ang iyong password kaagad.\n2. Suriin ang mga aktibidad sa iyong account para sa anumang hindi kilalang login.\n3. I-enable ang two-factor authentication kung hindi pa ito naka-enable.\n4. I-report ang insidente sa Facebook support.', 1, 1),
(56, 'mag nagLogin ng facebook ko', 'Account Compromise', '2025-10-23 04:07:00', 'mag nagLogin ng facebook ko sa ibang device na ang location ay ibang bansa', 'Siniloan, Laguna', 'High', 'Mark Ruiz', '634 L.De leon street Siniloan Laguna', 'markojoruiz2022@gmail.com', '09092771432', '', 0, 1, 0, 0, '', '2025-10-22 20:07:19', 'PENDING', 46, 'Preventive measures:\n- Gamitin ang two-factor authentication (2FA) para sa iyong Facebook account upang dagdagan ang seguridad nito. Ang 2FA ay nagdadagdag ng karagdagang layer ng proteksyon sa iyong account.\n- Regular na palitan ang iyong password at siguraduhing gumamit ng mahirap hulaan na password. Ang isang malakas na password ay dapat may halong malalaki at maliliit na letra, numero, at simbolo.\n- Iwasan ang pag-log in sa mga pampublikong Wi-Fi networks kapag gumagamit ng importanteng credentials. Kung kinakailangan, gumamit ng VPN para protektahan ang iyong koneksyon.\n\nIf it happens:\n1. Agad na baguhin ang iyong password sa Facebook account.\n2. I-enable ang two-factor authentication kung hindi pa ito naka-activate.\n3. Siyasatin ang mga aktibidad sa account mo sa security settings.\n4. Kung may mga hindi kilalang device na naka-login, i-log out ang mga ito at i-report ang insidente sa Facebook.', 1, 1),
(60, 'magnag login ng account ko', 'Account Compromise', '2025-10-23 07:47:00', 'may nag login ng facebook ko sa ibang devices na nakaaddress sa ibang bansa', '164 Siniloan, Laguna', 'High', 'Danna Rosales', 'Siniloan, Laguna', 'makmak032900@gmail.com', '09092771339', '', 0, 1, 0, 0, '', '2025-10-22 23:51:35', 'PENDING', 46, 'Preventive measures:\n- I-enable ang two-factor authentication (2FA) sa iyong Facebook account upang masigurong ikaw lamang ang makakapasok dito.\n- Regular na suriin ang mga aktibong device at logins sa iyong account settings. Alisin ang mga hindi kilalang devices.\n- Huwag mag-share ng iyong password sa sinuman at huwag gumamit ng parehong password sa iba\'t ibang accounts.\n- Gumamit ng isang password manager upang lumikha at mag-imbak ng malalakas at natatanging passwords para sa bawat account.\n\n If it happens:\n1. Baguhin agad ang iyong password sa Facebook.\n2. I-enable ang two-factor authentication kung hindi pa ito naka-enable.\n3. Suriin ang mga settings ng iyong account at alamin kung mayroong mga pagbabago na hindi mo ginawa.\n4. I-report ang anumang hindi pangkaraniwang activity sa Facebook support.', 0, 1),
(61, 'Mag nag login ng facebook ko gamit ang ibang device', 'Account Compromise', '2025-10-28 13:36:00', 'may naglogin ng facebook account ko gamit ang ibang device at nakaaddress ito sa ibang bansa', '634 L Deleon St. Brgy Aciveda', 'High', 'Mark Ruiz', 'Siniloan, Laguna', 'makmak032900@gmail.com', '09092771432', '', 0, 1, 0, 0, '', '2025-10-28 05:38:44', 'PENDING', 52, 'Preventive measures:\n\n- Gumamit ng two-factor authentication (2FA):\n  Ang 2FA ay nagbibigay ng karagdagang seguridad sa iyong account sa pamamagitan ng paghingi ng verification code mula sa iyong mobile device kapag nag-login.\n\n- Regular na baguhin ang password: \n  Siguraduhing palitan ang iyong password nang regular at gumamit ng mahirap hulaan na password na may iba\'t-ibang karakter.\n\n- I-check ang mga aktibong session: \n  Tiyakin na walang ibang device ang nakalog-in sa iyong account at i-log out ang mga session na hindi mo kinikilala.\n\nIf it happens:\n1. I-reset ang iyong password agad gamit ang tinukoy na \'Forgot Password\' na opsyon.\n2. I-enable ang two-factor authentication kung hindi mo pa ito nagagawa.\n3. I-review ang security settings ng iyong account.\n4. I-report ang insidente sa Facebook support.', 1, 1),
(62, 'unauthorized access in facebook', 'Unauthorized Access', '2025-10-28 13:42:00', 'unauthorized access on facebook and it address in other country', '634 L Deleon St. Brgy Aciveda', 'High', 'Danna Rosales', 'Siniloan, Laguna', 'makmak032900@gmail.com', '09092771432', '', 0, 1, 0, 0, '', '2025-10-28 05:46:32', 'PENDING', 52, 'Preventive measures:\n\n- Gamitin ang malakas na password: Tiyaking ang iyong password ay mahirap mahulaan, gamit ang kombinasyon ng mga letra, numero, at simbolo.\n- I-enable ang two-factor authentication: Magdagdag ng karagdagang layer ng seguridad sa pamamagitan ng paggamit ng two-factor authentication upang makasigurado na ikaw lamang ang makaka-access sa iyong account.\n- I-update ang privacy settings: Suriin ang iyong privacy settings sa Facebook at tiyaking limitado ang access ng iba sa iyong impormasyon.\n- Mag-ingat sa phishing attempts: Huwag mag-click sa mga kahina-hinalang link o magbigay ng personal na impormasyon sa mga email na hindi mo kilala.\n\nIf it happens:\n1. I-reset ang iyong password sa Facebook nang mabilis.\n2. Suriin ang iyong account activity at i-report ang hindi kanais-nais na mga transaksyon.\n3. I-check ang mga device na naka-log in sa iyong account at i-log out sa mga hindi pamilyar na device.\n4. Makipag-ugnayan sa Facebook support para sa karagdagang tulong.', 1, 0),
(63, 'unauthorized access on facebook', 'Account Security', '2025-10-28 13:55:00', 'may gusto maglogin ng account ko sa ibang device', '634 L Deleon St. Brgy Aciveda', 'Medium', 'Mark Ruiz', 'Siniloan, Laguna', 'markojoruiz2022@gmail.com', '09092771432', '', 0, 1, 0, 0, '', '2025-10-28 05:56:41', 'PENDING', 54, 'Preventive measures:\n- Gumamit ng two-factor authentication para sa iyong account. Nakakatulong ito sa pagdagdag ng karagdagang layer ng seguridad.\n- Huwag ibahagi ang iyong password sa ibang tao. Tiyakin na ito ay confidential at secure.\n- Regular na suriin ang mga aktibong session sa iyong account at mga device na naka-login.\n- Mag-install ng security software upang mapanatiling ligtas ang iyong device mula sa mga unauthorized access.\n\n If it happens:\n1. Subukang mag-change ng password agad upang mapigilan ang access sa iyong account.\n2. I-enable ang two-factor authentication kung hindi pa ito naka-set up.\n3. I-check ang mga device na may access sa iyong account at i-log out sa mga hindi kilalang device.\n4. I-report ang unauthorized access sa Facebook kung kinakailangan.', 0, 0),
(64, 'unauthorized access on facebook', 'Account Security', '2025-10-28 13:55:00', 'may gusto maglogin ng account ko sa ibang device', '634 L Deleon St. Brgy Aciveda', 'Medium', 'Mark Ruiz', 'Siniloan, Laguna', 'markojoruiz2022@gmail.com', '09092771432', '', 0, 1, 0, 0, '', '2025-10-28 06:00:58', 'PENDING', 54, 'Preventive measures:\n\n- I-enable ang two-factor authentication (2FA): Tinitiyak nito na kailangan ng karagdagang verification para makapag-login sa account mo.\n- Palitan ang password ng account: Gumamit ng matibay na password na may kombinasyon ng mga letra, numero, at simbolo.\n- Regular na i-review ang active sessions: Mag-check ng mga device na naka-log in sa iyong account at i-log out sa mga hindi kakilala.\n\nIf it happens:\n1. Baguhin agad ang iyong password para mapigilan ang access ng hindi awtorisadong tao.\n2. I-enable ang two-factor authentication kung hindi pa ito nakasagawa.\n3. Mag-report sa Facebook ang hindi awtorisadong access sa kanilang support page.\n4. I-monitor ang iyong account para sa anumang kahina-hinalang aktibidad.', 0, 0),
(67, 'unauthorized login', 'Unauthorized Access', '2025-10-28 22:36:00', 'unauthorized login on my fb account', '164 Siniloan, Laguna', 'High', 'Danna Rosales', 'Siniloan, Laguna', 'makmak032900@gmail.com', '09092771339', '', 0, 1, 0, 0, '', '2025-10-28 14:37:13', 'PENDING', 52, 'Preventive measures:\n- Use strong and unique passwords: Gumamit ng mga malalakas at natatanging password para sa bawat account mo upang maiwasan ang madaling pag-access.\n- Enable two-factor authentication: I-enable ang two-factor authentication upang madagdagan ang seguridad ng iyong account.\n- Be cautious of phishing attempts: Maging maingat sa mga email o mensahe na humihimok na i-click ang mga link, dahil maaaring ito ay phishing.\n\nIf it happens:\n1. Change your password immediately: Agad na palitan ang iyong password upang mapigilan pa ang ibang unauthorized access.\n2. Enable two-factor authentication: Kung hindi ito naka-enable sa iyong account, ipatupad ito agad para sa dagdag na seguridad.\n3. Review the recent activities on your account: Suriin ang mga kamakailang aktibidad sa iyong account upang malaman kung ano ang mga na-access.\n4. Report the unauthorized access to Facebook: I-report ang unauthorized access sa Facebook para sa karagdagang tulong at proteksyon.', 1, 0),
(68, 'unauthorized login', 'Account Compromise', '2025-10-28 23:26:00', 'may naglogin ng account ko sa ibang device', 'Siniloan, Laguna', 'High', 'Mark Ruiz', '163 siniloan laguna', 'makmak032900@gmail.com', '09092771339', '', 0, 1, 0, 0, '', '2025-10-28 15:27:17', 'PENDING', 52, 'Preventive measures:\n\n- Enable Two-Factor Authentication: Mas mataas ang seguridad ng iyong account kung kinakailangan ng one-time code sa tuwing mag-login.\n- Regularly Update Passwords: Palitan ang iyong password nang regular upang maiwasan ang unauthorized access.\n- Monitor Account Activity: Tingnan ang mga activity logs ng iyong account para sa anumang kahina-hinalang login attempts.\n\nIf it happens:\n1. Change Your Password Immediately: Agad na palitan ang iyong password upang hindi na ma-access ng iba.\n2. Check Account Activity: Tiyakin ang mga aktibidad sa iyong account upang makita kung mayroong ibang nag-login.\n3. Contact Support: Kung may nangyaring hindi kaayon sa iyong account, agad na makipag-ugnayan sa customer support ng serbisyo.', 0, 0),
(69, 'may gusto mag login ng FB account ko', 'Account Security', '2025-10-29 01:34:00', 'may unauthorized login na nag notif saking facebook account na naka address sa ibang bansa\r\n', '634 L Deleon St. Brgy Aciveda', 'High', 'Danna Rosales', '634 L.De leon street Siniloan Laguna', 'makmak032900@gmail.com', '09092771432', '', 0, 1, 0, 0, '', '2025-10-28 17:35:51', 'INVESTIGATING', 52, 'Preventive measures:\n\n - Enable two-factor authentication: Mag-enable ng two-factor authentication para sa iyong Facebook account upang mas maging secure ito.\n - Regularly check login history: Suriin ang iyong login history para makita kung may mga kahina-hinalang activity.\n - Use a strong password: Gumamit ng malakas at hindi madaling hulaan na password para sa iyong account.\n - Be cautious of phishing attempts: Maging maingat sa mga email o messages na humihingi ng iyong login information.\n\n If it happens:\n 1. Immediately change your password: Agad na palitan ang password ng iyong account.\n 2. Review active sessions: Suriin ang mga active sessions at i-log out ang anumang kahina-hinalang devices.\n 3. Report the incident to Facebook: I-report ang unauthorized login sa Facebook support.\n 4. Enable alerts for unusual activity: I-enable ang mga alerto para sa mga hindi pangkaraniwang activity sa iyong account.', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `role_changes_log`
--

CREATE TABLE `role_changes_log` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `target_user_id` int(11) NOT NULL,
  `old_role` varchar(50) DEFAULT NULL,
  `new_role` varchar(50) DEFAULT NULL,
  `changed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `spam`
--

CREATE TABLE `spam` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `description` text NOT NULL,
  `system_affected` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `severity_level` varchar(50) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
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
  `user_id` int(11) DEFAULT NULL,
  `suggestion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `spam`
--

INSERT INTO `spam` (`id`, `title`, `category`, `date`, `description`, `system_affected`, `location`, `severity_level`, `full_name`, `address`, `department`, `email`, `phone`, `systems_affected`, `estimated_impact`, `critical_infra`, `observed_impact`, `actions_taken`, `incident_contained`, `notified`, `evidence_logs`, `evidence_screenshots`, `evidence_email`, `evidence_other`, `additional_info`, `created_at`, `status`, `user_id`, `suggestion`) VALUES
(56, 'Nakatanggap po ako ng email na galing daw sa bangko ko', 'Phishing', '2025-10-22 12:29:00', 'Nakatanggap po ako ng email na galing daw sa bangko ko, sinasabi na kailangan kong i-update ang aking account. Pag-click ko ng link, parang ibang website yung lumabas', NULL, 'Siniloan, Laguna', 'High', 'Danna Rosales', 'Siniloan, Laguna', NULL, 'makmak032900@gmail.com', '09092771339', NULL, NULL, NULL, NULL, NULL, NULL, '', 0, 1, 0, 0, '', '2025-10-22 05:43:43', 'PENDING', 46, 'Preventive measures:\n\n - Huwag mag-click sa mga link mula sa mga di kilalang email.\n   - Ang mga phishing emails ay kadalasang may mga link na naglalaman ng pekeng website. Mas mabuti na i-type ang URL ng banko mo sa browser.\n\n - I-verify ang sender ng email.\n   - Siguraduhing ang email address ay galing sa opisyal na domain ng iyong bangko upang maiwasan ang mga pekeng email.\n\n - Gumamit ng multi-factor authentication.\n   - Ang pag-enable ng dagdag na security steps ay makatutulong upang mas protektahan ang iyong account.\n\n If it happens:\n - Huwag mag-input ng anumang personal na impormasyon sa website.\n - I-report ang email sa iyong bangko.\n - I-reset ang iyong password at tingnan ang anumang kahina-hinalang aktibidad sa iyong account.\n - Mag-install ng updated antivirus software sa iyong devices upang maiwasan ang malware attacks.'),
(57, 'may text akong natanggap na nanalo daw ako', 'Phishing', '2025-10-22 23:54:00', 'May text  po akong natanggap na nagsasabing nanalo daw ako ng load promo, pero humihingi ng account number', NULL, 'Siniloan, Laguna', 'Medium', 'Danna Rosales', 'Siniloan, Laguna', NULL, 'makmak032900@gmail.com', '09092771339', NULL, NULL, NULL, NULL, NULL, NULL, '', 0, 1, 0, 0, '', '2025-10-22 15:55:20', 'PENDING', 46, 'Preventive measures:\n- Huwag magbigay ng personal na impormasyon tulad ng account number sa mga text na hindi kilala.\n- I-verify ang mga mensahe mula sa mga opisyal na kumpanya bago magbigay ng impormasyon.\n- Iwasan ang pag-click sa mga link na nasa text na hindi mo inaasahan.\n\n If it happens:\n1. Itigil ang anumang komunikasyon sa nagpadala ng text.\n2. I-report ang insidente sa iyong network provider o sa mga awtoridad.\n3. I-monitor ang iyong mga account para sa anumang hindi awtorisadong transaksyon.'),
(58, 'may nag-aalok ng work sakin abroad ', 'Job Scam', '2025-10-22 23:59:00', 'May nag-message po sa akin sa Messenger na nag-aalok ng trabaho abroad, pero kailangan daw magbayad muna ng registration', NULL, 'Siniloan, Laguna', 'Medium', 'Mark Ruiz', 'Siniloan, Laguna', NULL, 'makmak032900@gmail.com', '09092771339', NULL, NULL, NULL, NULL, NULL, NULL, '', 0, 1, 0, 0, '', '2025-10-22 16:01:20', 'PENDING', 46, 'Preventive measures:\n- **Huwag magbayad agad**: Kung may nag-aalok ng trabaho na nangangailangan ng bayad bago makapasok, kadalasang ito ay scam.\n- **Suriin ang kumpanya**: Hanapin ang impormasyon tungkol sa kumpanya at alamin kung legal ito.\n- **I-verify ang nag-aalok**: Makipag-ugnayan sa kumpanya gamit ang mga opisyal na contact details na makikita sa kanilang website.\n\nIf it happens:\n1. **Itigil ang komunikasyon**: Huwag nang makipag-ugnayan sa taong nag-aalok ng trabaho kung sa tingin mo ito ay scam.\n2. **I-report ang scam**: I-report ito sa mga awtoridad o sa social media platform kung saan mo ito natanggap.\n3. **Mag-ingat sa personal na impormasyon**: Huwag ibigay ang iyong mga personal na detalye tulad ng bank account at ID information.'),
(59, 'May nag-message po sa akin sa Messenger na nag-aalok ng trabaho abroad', 'Job Offer Scam', '2025-10-23 00:07:00', 'May nag-message po sa akin sa Messenger na nag-aalok ng trabaho abroad, pero kailangan daw magbayad muna ng registration', NULL, 'Siniloan, Laguna', 'Medium', 'Mark Ruiz', 'Siniloan, Laguna', NULL, 'makmak032900@gmail.com', '09092771339', NULL, NULL, NULL, NULL, NULL, NULL, '', 0, 1, 0, 0, '', '2025-10-22 16:07:56', 'PENDING', 46, 'Preventive measures:\n\n- Be wary of unsolicited job offers, especially those that require payment upfront.\n  - Many scams involve fraudulent job postings that ask for money to secure a position.\n\n- Verify the legitimacy of the job offer with official company channels.\n  - Always check the company\'s official website or contact them directly to confirm the job\'s existence.\n\n- Trust your instincts; if something feels off, it probably is.\n  - Do not ignore red flags such as high salaries for little work or unprofessional communication.\n\nIf it happens:\n1. Cease communication with the sender immediately.\n2. Report the scam to the platform (Messenger) and any relevant authorities.\n3. Block the user who contacted you to prevent further messages.\n4. Consider informing friends and family to raise awareness about the scam.'),
(60, 'pagbukas ko ng laptop ko hindi ko ma-access', 'Data Recovery or Ransomware', '2025-10-23 00:10:00', 'Pagbukas ko ng laptop, hindi ko na ma-access yung mga files ko. May lumabas na message na kailangan daw magbayad para mabuksan ulit', NULL, '164 Siniloan, Laguna', 'High', 'Mark Ruiz', 'Siniloan, Laguna', NULL, 'makmak032900@gmail.com', '09092771339', NULL, NULL, NULL, NULL, NULL, NULL, '', 0, 1, 0, 0, '', '2025-10-22 16:11:17', 'PENDING', 46, 'Preventive measures:\n\n- Regular backups: Mag-rekord ng backups ng mga files mo upang magkaroon ka ng kopya kung sakaling mawala ang access sa original files mo.\n- Use reputable antivirus software: Mag-install ng kilalang antivirus software na kayang protektahan ang iyong laptop mula sa malware at ransomware.\n- Be cautious with downloads: Huwag basta-basta mag-download ng mga files o programs mula sa mga hindi pinagkakatiwalaang sources.\n- Keep software updated: Siguraduhing ang operating system at lahat ng applications ay updated para sa pinakabagong security features.\n\nIf it happens:\n1. Disconnect from the internet: Agad na idiskonekta ang laptop mula sa internet upang mapigilan ang maaaring karagdagang pinsala.\n2. Do not pay the ransom: Huwag magbayad muli sa mga ito sapagkat wala itong garantiya na maibabalik ang access sa mga files.\n3. Run antivirus software: I-scan ang laptop gamit ang antivirus software upang makita at alisin ang malware.\n4. Restore from backup: Kung mayroon kang backup ng iyong mga files, i-restore ito mula sa backup.\n5. Seek professional help: Kung hindi mo maayos ang problema, makipag-ugnayan sa isang IT expert o data recovery specialist.'),
(61, 'mag nag login ng account ko', 'Account Security', '2025-10-29 02:12:00', 'test test', NULL, '634 L Deleon St. Brgy Aciveda', 'Medium', 'Danna Rosales', 'Siniloan, Laguna', NULL, 'makmak032900@gmail.com', '09092771432', NULL, NULL, NULL, NULL, NULL, NULL, '', 0, 1, 0, 0, '', '2025-10-28 18:13:19', 'PENDING', 52, 'Mga hakbang upang maiwasan ang hindi awtorisadong pag-login sa iyong account:\n\n- Gumamit ng malakas at natatanging password: Siguraduhin na ang iyong password ay may iba\'t ibang letra, numero, at simbolo upang maging mahirap mahulaan.\n- I-enable ang two-factor authentication: Nagbibigay ito ng karagdagang layer ng seguridad sa iyong account sa pamamagitan ng pangangailangan ng isang code na ipinapadala sa iyong mobile device.\n- Regular na suriin ang account activity: Tingnan ang mga aktibidad ng iyong account upang makita kung mayroong hindi kilalang pag-login.\n\nKung mangyari ang hindi awtorisadong pag-login:\n1. Agad na baguhin ang iyong password.\n2. I-enable ang two-factor authentication kung hindi pa ito naka-on.\n3. Suriin ang mga setting ng account para sa anumang pagbabago at ibalik ito kung kinakailangan.\n4. I-report ang insidente sa serbisyo ng customer support kung kinakailangan.'),
(62, 'test', 'General Testing', '2025-10-29 02:20:00', 'test', NULL, '634 L Deleon St. Brgy Aciveda', 'Low', 'Mark Ruiz', 'Siniloan, Laguna', NULL, 'makmak032900@gmail.com', '09092771432', NULL, NULL, NULL, NULL, NULL, NULL, '', 0, 1, 0, 0, '', '2025-10-28 18:21:40', 'PENDING', 52, 'Preventive measures:\n- Regularly update your software and systems to protect against vulnerabilities.\n- Conduct routine security audits to identify potential threats.\n- Educate users about phishing and social engineering attacks.\n\n If it happens:\n1. Identify the source of the test.\n2. Ensure that no real vulnerabilities were exploited.\n3. Report any findings to your cybersecurity team for further assessment.'),
(63, 'test2', 'General Testing', '2025-10-29 02:25:00', 'test2', NULL, '634 L Deleon St. Brgy Aciveda', 'Low', 'Danna Rosales', 'Siniloan, Laguna', NULL, 'makmak032900@gmail.com', '09092771432', NULL, NULL, NULL, NULL, NULL, NULL, '', 0, 1, 0, 0, '', '2025-10-28 18:26:21', 'PENDING', 52, 'Preventive measures:\n- Regularly update software to patch vulnerabilities.\n- Utilize strong, unique passwords for different accounts.\n- Enable two-factor authentication where available.\n\n If it happens:\n1. Assess the situation to determine if any data was compromised.\n2. Change passwords for affected accounts immediately.\n3. Monitor accounts for suspicious activity.'),
(64, 'test2', 'General Cybersecurity Awareness', '2025-10-29 02:25:00', 'test2', NULL, '634 L Deleon St. Brgy Aciveda', 'Low', 'Danna Rosales', 'Siniloan, Laguna', NULL, 'makmak032900@gmail.com', '09092771432', NULL, NULL, NULL, NULL, NULL, NULL, '', 0, 1, 0, 0, '', '2025-10-28 18:30:10', 'PENDING', 52, 'Preventive measures:\n- Be cautious with email attachments and links: Always verify the source before opening any attachment or clicking on links to prevent phishing attacks.\n- Use strong passwords: Create complex passwords that include a mix of letters, numbers, and special characters to enhance security.\n- Keep software updated: Regularly update your operating system and applications to protect against vulnerabilities.\n\n If it happens:\n1. Disconnect from the internet immediately to prevent further damage.\n2. Run a full antivirus/malware scan to identify and remove threats.\n3. Change passwords for all accounts, especially sensitive ones.\n4. Monitor your accounts for unauthorized access and report any suspicious activity.'),
(65, 'test3', 'General Testing', '2025-10-29 02:33:00', 'test 3', NULL, '634 L Deleon St. Brgy Aciveda', 'Low', 'Jeann San Juan', '634 L.De leon street Siniloan Laguna', NULL, 'makmak032900@gmail.com', '09092771432', NULL, NULL, NULL, NULL, NULL, NULL, '', 0, 1, 0, 0, '', '2025-10-28 18:35:36', 'PENDING', 52, 'Preventive measures:\n- Regularly update software: Ensure that all software is up to date to avoid vulnerabilities.\n- Use strong passwords: Implement complex passwords to reduce unauthorized access.\n- Conduct regular audits: Regularly assess your systems for security gaps.\n\n If it happens:\n1. Identify the issue: Confirm the nature of the problem.\n2. Notify the team: Inform your cybersecurity team about the incident.\n3. Analyze the impact: Determine what data or systems may be affected.\n4. Remediate: Take necessary actions to resolve the issue and prevent recurrence.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `barangay` varchar(100) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `status` varchar(11) NOT NULL DEFAULT 'ACTIVE',
  `role` varchar(50) NOT NULL DEFAULT 'user',
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `verification_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `name`, `barangay`, `latitude`, `longitude`, `status`, `role`, `is_verified`, `verification_token`, `token_expiry`, `created_at`, `updated_at`, `address`) VALUES
(1, 'test@gmail.com', '$2y$10$ay91T/8OgM.JytqD2DUPweltUqlP1wRZv0MSmc6nYT8L6Xy2qQc9e', 'Juan', NULL, NULL, NULL, 'ACTIVE', 'user', 1, NULL, NULL, '2025-09-03 16:57:28', '2025-09-09 03:38:29', NULL),
(37, 'ireport211@gmail.com', '$2y$10$uEjsE.FEMjmfhMv9rP.3Fe8gb7ZezWwypRZoIDGamcxH4LfnzBYJ.', 'admin', NULL, NULL, NULL, 'ACTIVE', 'admin', 1, NULL, NULL, '2025-09-03 16:57:28', '2025-09-03 19:38:24', NULL),
(41, 'testUser1@gmail.com', '$2y$10$zdKgzObFuiuD7YNwobD.Su/aCDRiBUz7N.KiF9bUe4Hj9Asy7mjGy', 'testUser1', 'Pandenio', NULL, NULL, 'ACTIVE', 'user', 0, '0b83f146fb1f450a7e4779d2a54d0be9e9a0d83d8a808c0be6b054b9e3ff0ddf', '2025-09-21 01:47:09', '2025-09-19 23:47:09', '2025-09-19 23:47:09', NULL),
(42, 'kenneth@gmail.com', '$2y$10$IYcX0MdeNTKELGhLPMkNB.Z5gQRtGfo6ShJc3qaZU7LeeJx6vmGoa', 'Kenny', 'Mendiola', NULL, NULL, 'ACTIVE', 'user', 1, '1ed5ca7164b7b90b044ef7b52b921a9d49f133991902adc905e5fe9cd96e1877', '2025-09-21 07:16:47', '2025-09-20 05:16:47', '2025-09-20 05:18:04', 'Siniloan, Laguna'),
(52, 'makmak032900@gmail.com', '$2y$10$nsykFTIsAMTRwMz2N6JhsuANUoy2J/7iin877U9E1stDVehtD9E9O', 'Danna Rosales', 'Buhay', NULL, NULL, 'ACTIVE', 'user', 1, NULL, NULL, '2025-10-27 23:04:50', '2025-10-27 23:05:08', 'Siniloan, Laguna'),
(54, 'markojoruiz2022@gmail.com', '$2y$10$5OgvWq7lxcevaBuHPnO4oOs3AnLleFl5y9i.U4QcKGGm6EoJHkXZC', 'Mark Ruiz', 'Buhay', NULL, NULL, 'ACTIVE', 'user', 1, NULL, NULL, '2025-10-27 23:27:38', '2025-10-27 23:28:13', 'Siniloan, Laguna');

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
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `incident_id` (`incident_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `incident`
--
ALTER TABLE `incident`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_deleted` (`user_deleted`);

--
-- Indexes for table `role_changes_log`
--
ALTER TABLE `role_changes_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_admin_id` (`admin_id`),
  ADD KEY `idx_target_user_id` (`target_user_id`),
  ADD KEY `idx_changed_at` (`changed_at`);

--
-- Indexes for table `spam`
--
ALTER TABLE `spam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_role` (`role`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_users_location` (`latitude`,`longitude`),
  ADD KEY `idx_users_barangay` (`barangay`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `incident`
--
ALTER TABLE `incident`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `role_changes_log`
--
ALTER TABLE `role_changes_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spam`
--
ALTER TABLE `spam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`incident_id`) REFERENCES `incident` (`id`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
