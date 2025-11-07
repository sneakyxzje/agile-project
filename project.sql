-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 17, 2025 at 06:18 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `bplayers`
--

CREATE TABLE `bplayers` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `nickname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `main_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `media` json DEFAULT NULL,
  `price_per_hour` int UNSIGNED NOT NULL,
  `games` json NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `voice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bplayers`
--

INSERT INTO `bplayers` (`id`, `user_id`, `nickname`, `main_image`, `media`, `price_per_hour`, `games`, `description`, `voice`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 'Sneakiiiiiii', '/public/temp/1760510345_default.png', '[\"/public/temp/1760510345_1185439.jpg\", \"/public/temp/1760510345_38bb648a2c53a0126daa684e4ba114ed.jpg\", \"/public/temp/1760510345_ad758c227b58413790077b2edebddfe2H3000W3000_464_464.jpg\", \"/public/temp/1760510345_1398035.jpg\"]', 1233, '[\"lol\", \"tft\", \"pubg\", \"lq\", \"valorant\", \"freefire\"]', 'Rent mình mình chỉ chơi game choaaaa hihihihihihi :>', '/public/temp/1760510345_Amor Na Praia (Slowed).mp3', 'approved', '2025-10-15 06:39:05', '2025-10-17 05:28:40'),
(2, 7, 'Toi dai dot', '/public/temp/1760678977_ad758c227b58413790077b2edebddfe2H3000W3000_464_464.jpg', '[\"/public/temp/1760678977_default.png\"]', 133, '[\"lol\"]', NULL, NULL, 'approved', '2025-10-17 05:29:37', '2025-10-17 05:29:52'),
(3, 10, 'Dangrangto', '/public/temp/1760680738_2.jpg', '[\"/public/temp/1760680738_333.jpg\", \"/public/temp/1760680738_zzz.jpg\"]', 3636, '[\"lol\"]', 'Cả nhà ơi, DRT đã quay trở lại rùi đâyy !!!!!\r\nThuê Đăng đăng rút ván cho nhé!!!!! :>>>', '/public/temp/1760680738_sound.mp3', 'approved', '2025-10-17 05:58:58', '2025-10-17 05:59:49'),
(4, 11, 'Bằng Cổ Tay', '/public/temp/1760680992_z7125993283941_e9b5df2ddf240a59c69e394aa785be88.jpg', '[\"/public/temp/1760680992_z7125993294118_d24179a402f6bf57ad93f15705f3e83f.jpg\", \"/public/temp/1760680992_z7125993406935_454fcdc569b8a30b85645996f2fae4ef.jpg\"]', 2424, '[\"lq\"]', NULL, NULL, 'approved', '2025-10-17 06:03:12', '2025-10-17 06:03:16'),
(5, 12, 'Maylily', '/public/temp/1760681221_img1.jpg', '[\"/public/temp/1760681221_z7125984049101_0d41c2171c286dfedeabf3977b4df507.jpg\"]', 29, '[]', NULL, '/public/temp/1760681221_mặt trời kìa dù ở đâu', 'approved', '2025-10-17 06:07:01', '2025-10-17 06:07:06');

-- --------------------------------------------------------

--
-- Table structure for table `rents`
--

CREATE TABLE `rents` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `bplayer_id` int NOT NULL,
  `amount` int NOT NULL,
  `hours` int NOT NULL DEFAULT '1',
  `status` enum('pending','accepted','completed','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `rents`
--

INSERT INTO `rents` (`id`, `user_id`, `bplayer_id`, `amount`, `hours`, `status`, `created_at`, `updated_at`) VALUES
(12, 7, 1, 2466, 2, 'completed', '2025-10-16 12:40:44', '2025-10-16 14:54:02'),
(13, 7, 1, 4932, 4, 'completed', '2025-10-16 13:31:17', '2025-10-16 14:53:18'),
(14, 7, 1, 2466, 2, 'completed', '2025-10-16 15:09:57', '2025-10-16 15:12:21'),
(15, 7, 1, 4932, 4, 'completed', '2025-10-16 15:13:50', '2025-10-16 15:17:21'),
(16, 7, 1, 4932, 4, 'completed', '2025-10-16 15:14:05', '2025-10-16 15:17:20'),
(17, 7, 1, 4932, 4, 'completed', '2025-10-16 15:14:11', '2025-10-16 15:17:18'),
(18, 7, 1, 4932, 4, 'completed', '2025-10-16 15:15:15', '2025-10-16 15:16:47'),
(19, 7, 1, 4932, 4, 'accepted', '2025-10-16 15:28:35', '2025-10-16 15:34:56'),
(20, 7, 1, 4932, 4, 'accepted', '2025-10-16 15:29:08', '2025-10-16 15:34:55'),
(21, 7, 1, 4932, 4, 'accepted', '2025-10-16 15:29:38', '2025-10-16 15:34:54'),
(22, 7, 1, 2466, 2, 'completed', '2025-10-16 15:30:52', '2025-10-16 15:31:32'),
(23, 7, 1, 424152, 344, 'accepted', '2025-10-16 15:34:45', '2025-10-16 15:34:51'),
(24, 7, 1, 3699, 3, 'accepted', '2025-10-16 17:04:17', '2025-10-16 17:40:48'),
(25, 7, 1, 6165, 5, 'completed', '2025-10-17 03:54:21', '2025-10-17 03:54:53'),
(26, 7, 1, 3699, 3, 'cancelled', '2025-10-17 03:56:07', '2025-10-17 03:56:10'),
(27, 7, 1, 2466, 2, 'cancelled', '2025-10-17 04:49:14', '2025-10-17 05:13:27'),
(28, 7, 1, 8631, 7, 'accepted', '2025-10-17 05:12:13', '2025-10-17 05:12:19'),
(29, 7, 1, 3699, 3, 'cancelled', '2025-10-17 05:13:49', '2025-10-17 05:13:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `diamond` int DEFAULT '0',
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `role` enum('user','bplayer','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `email`, `password`, `diamond`, `avatar`, `created_at`, `updated_at`, `role`) VALUES
(3, 'Tuấn Đạt', 'sneaky', 'test@mail.com', '$2y$10$QMGm3KUMxouaZdtN1ea0iulPk.CPr8wQfMRicyKI4CKfvAW3LZRBC', 1000489500, NULL, '2025-10-15 04:20:55', '2025-10-17 05:12:19', 'bplayer'),
(4, 'test', 'test', 'testzzz@mail.com', '$2y$10$HELJoRpIwIOzVoF5GfS.NuyMCP7V0MBQcCCDEqUgVZEaMSrDA5T/u', 0, NULL, '2025-10-15 04:21:29', '2025-10-15 04:21:29', 'user'),
(5, 'asdasda', 'asdasdsad', 'asd@mail.com', '$2y$10$PHyAkoDsw2ndGit7Hjdwxeq31nsaVfK5RCxAF/zQ2nxueACup15yy', 0, NULL, '2025-10-15 04:21:48', '2025-10-15 04:21:48', 'user'),
(6, 'ádasdasd', 'fdsfsdjk', 'test@mailmailajmail.com', '$2y$10$6tt8uC0oRezQibpDVI2hjethuvpCvAyCu3QF9iEntROIP91nn5aYi', 0, NULL, '2025-10-15 04:23:41', '2025-10-15 04:23:41', 'user'),
(7, 'zzzzz', 'testaccount', 'testaccount@mail.com', '$2y$10$uMOG0EjjibSjw4dHjbOy8O7y.Ulfebzt1MMcRvyc8Lj.K1L.OnOvi', 999505634, NULL, '2025-10-16 09:08:45', '2025-10-17 05:13:54', 'user'),
(8, 'Admin', 'admin', 'admin@account.com', '$2y$10$tCfDTTwnLm3fPDCM54R4xed6x3GOi.vg2PWthu4r3h8uenjtb7jZy', 0, NULL, '2025-10-16 15:39:48', '2025-10-16 15:40:08', 'admin'),
(9, 'sadjioasdjoi', 'testusername', 'rjsaiodjioasd@mail.com', '$2y$10$yEl5oxj1xF0U2IqQpYjmP.OnbXyRRjvzld4a2diWyPVAEYCsB8e4O', 123132, NULL, '2025-10-17 04:42:12', '2025-10-17 04:42:12', 'user'),
(10, 'Trần Hải Đăng', 'dangrangto123', 'dangrangto@mail.com', '$2y$10$lal8cx7oLXJTc3GfCaHcc.dx48vmylWs/akn/Sp3IV1AgTRs9NLE6', 0, NULL, '2025-10-17 05:55:06', '2025-10-17 05:55:06', 'user'),
(11, 'Anh Bằng', 'anhbang', '24kright@mail.com', '$2y$10$/NUISukjyasjpWflzlmQ2uOcQdwJ99LORhr1J4d4rTks37N6MkCM.', 0, NULL, '2025-10-17 06:01:20', '2025-10-17 06:01:20', 'user'),
(12, 'Phương Ly', 'phuongly', 'phuongly@mail.com', '$2y$10$cp.1DGgH3.slJlA2CuRgNuIkpRRBSqd/M2Ndr73YLuIv3m.0M2M8S', 0, NULL, '2025-10-17 06:04:08', '2025-10-17 06:04:08', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bplayers`
--
ALTER TABLE `bplayers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rents`
--
ALTER TABLE `rents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `bplayer_id` (`bplayer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bplayers`
--
ALTER TABLE `bplayers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rents`
--
ALTER TABLE `rents`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bplayers`
--
ALTER TABLE `bplayers`
  ADD CONSTRAINT `bplayers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rents`
--
ALTER TABLE `rents`
  ADD CONSTRAINT `rents_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rents_ibfk_2` FOREIGN KEY (`bplayer_id`) REFERENCES `bplayers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
