-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2025 at 04:08 PM
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
(49, '41', '../../uploads/1760183044_system_context.drawio.png', 'system_context.drawio.png');

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
(22, 36, 'admin', 'Resolved', '2025-09-22 17:37:54');

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
-- Dumping data for table `incident`
--

INSERT INTO `incident` (`id`, `title`, `category`, `date`, `description`, `system_affected`, `location`, `severity_level`, `full_name`, `address`, `department`, `email`, `phone`, `systems_affected`, `estimated_impact`, `critical_infra`, `observed_impact`, `actions_taken`, `incident_contained`, `notified`, `evidence_logs`, `evidence_screenshots`, `evidence_email`, `evidence_other`, `additional_info`, `created_at`, `status`, `user_id`, `suggestion`) VALUES
(36, 'TestReport1', 'Phishing', '2025-09-22 15:37:00', 'TestDescription\n\nLocation: Siniloan, Laguna\nReporter Address: Test', 'Siniloan, Laguna', NULL, 'Medium', 'k3nnken', NULL, NULL, 'kenneth@gmail.com', 'Test', 'Test', 'Medium', 'yes', 'Test', '', 'no', '', 0, 1, 0, 0, '0', '2025-09-22 09:36:11', 'RESOLVED', 42, 'Preventive measures:\n- Always verify the sender&#039;s email address before clicking on any links or downloading attachments. This helps to ensure that the communication is legitimate.\n- Use multi-factor authentication for your accounts to add an extra layer of security.\n- Regularly update your software and antivirus programs to protect against new threats.\n\n If it happens:\n1. Do not click on any links or download attachments from suspicious emails.\n2. Change your passwords immediately, especially for important accounts.\n3. Report the phishing attempt to your email provider and relevant authorities.'),
(37, 'Test2', 'Phishing', '2025-09-22 08:35:00', 'test2\n\nLocation: gege\nReporter Address: test', 'gege', NULL, 'Low', 'kenny', NULL, NULL, 'kenny@gmail.com', 'test', '', 'Low', 'yes', '', '', '', '', 0, 0, 0, 0, '0', '2025-09-22 16:35:31', 'RESOLVED', 42, 'Preventive measures:\n\n - Always verify the source of emails or messages before clicking on any links.\n - Use strong, unique passwords for each of your accounts to minimize risk.\n - Enable two-factor authentication wherever possible to add an extra layer of security.\n - Keep your software and security systems up to date to protect against vulnerabilities.\n\n If it happens:\n - Do not click on any links or provide personal information.\n - Report the incident to your IT department or security team.\n - Change passwords for affected accounts immediately.\n - Scan your devices for malware using updated antivirus software.'),
(38, 'test3', 'Phishing', '2025-09-16 03:51:00', 'test\n\nLocation: test\nReporter Address: ', 'test', NULL, 'Low', 'test3', NULL, NULL, 'testUser1@gmail.com', '', '', 'Medium', '', '', '', '', '', 0, 0, 0, 0, '0', '2025-09-22 16:51:25', 'PENDING', 42, 'Preventive measures:\n\n- Be cautious of unsolicited emails or messages that ask for personal information. Always verify the sender&#039;s identity before responding.\n- Use strong, unique passwords for your online accounts and enable two-factor authentication for added security.\n- Regularly update your software and antivirus programs to protect against the latest threats.\n\n If it happens:\n1. Disconnect from the internet immediately to prevent further damage.\n2. Change your passwords for affected accounts as soon as possible.\n3. Report the incident to your email provider or IT department for assistance.'),
(39, 'na hack ang aking facebook account', '', '2025-10-11 14:30:00', 'may napindot akong link sa facebook na hindi ko sinasadya\n\nLocation: Siniloan, Laguna\nReporter Address: 634 L.De leon street Siniloan Laguna', 'Siniloan, Laguna', NULL, '', 'Mark Ruiz', NULL, NULL, 'makmak032900@gmail.com', '09092771432', '', '', '', '', NULL, '', '', 0, 1, 0, 0, '0', '2025-10-11 06:31:07', 'PENDING', 37, ''),
(40, 'nawabasan ang laman ng gcash ko', '', '2025-10-11 19:38:00', 'nabawasan laman ng gcash ko ng hindi ko alam ano gagawin ko\r\n\n\nLocation: Siniloan, Laguna\nReporter Address: Siniloan, Laguna', 'Siniloan, Laguna', NULL, '', 'Danna Rosales', NULL, NULL, 'makmak032900@gmail.com', '09092771339', '', '', '', '', NULL, '', '', 0, 1, 0, 0, '0', '2025-10-11 11:39:26', 'PENDING', 46, ''),
(41, 'nawabasan ang laman ng gcash ko', '', '2025-10-11 19:38:00', 'nabawasan laman ng gcash ko ng hindi ko alam ano gagawin ko\r\n\n\nLocation: Siniloan, Laguna\nReporter Address: Siniloan, Laguna', 'Siniloan, Laguna', NULL, '', 'Danna Rosales', NULL, NULL, 'makmak032900@gmail.com', '09092771339', '', '', '', '', '', '', '', 0, 1, 0, 0, '0', '2025-10-11 11:44:04', 'PENDING', 46, '');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `used` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(46, 'makmak032900@gmail.com', '$2y$10$9W8p4oQNfqEjznxR3Vkeyutl8Rq.TLtRMLL7nB8JquQm6EScgnejK', 'Danna Rosales', 'Buhay', NULL, NULL, 'ACTIVE', 'user', 1, NULL, NULL, '2025-10-11 06:03:07', '2025-10-11 06:06:32', 'Siniloan, Laguna');

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `idx_token` (`token`),
  ADD KEY `idx_expires` (`expires_at`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `role_changes_log`
--
ALTER TABLE `role_changes_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_admin_id` (`admin_id`),
  ADD KEY `idx_target_user_id` (`target_user_id`),
  ADD KEY `idx_changed_at` (`changed_at`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `incident`
--
ALTER TABLE `incident`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role_changes_log`
--
ALTER TABLE `role_changes_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`incident_id`) REFERENCES `incident` (`id`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD CONSTRAINT `password_reset_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
