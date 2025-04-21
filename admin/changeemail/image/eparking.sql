-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2024 at 03:10 AM
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
-- Database: `eparking`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_table`
--

CREATE TABLE `admin_table` (
  `admin_id` int(11) NOT NULL,
  `admin_email` varchar(254) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_regdate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_table`
--

INSERT INTO `admin_table` (`admin_id`, `admin_email`, `admin_password`, `admin_regdate`) VALUES
(2, 'markjemdee01@gmail.com', '$2y$10$hZJx7EA.9Sy8k49YLkgvEOpGel37nNMbtY8f.XhVWDqkhchg2Jwka', '2024-08-16 08:11:40');

-- --------------------------------------------------------

--
-- Table structure for table `cpverification`
--

CREATE TABLE `cpverification` (
  `id` int(11) NOT NULL,
  `verify_number` int(11) NOT NULL,
  `is_used` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cpverification`
--

INSERT INTO `cpverification` (`id`, `verify_number`, `is_used`) VALUES
(1, 292724, 0),
(2, 979041, 0),
(3, 899079, 0),
(4, 255394, 0),
(5, 923911, 0),
(6, 608159, 0),
(7, 396040, 0),
(8, 112399, 0),
(9, 966928, 0),
(10, 353232, 0),
(11, 534630, 0),
(12, 862939, 0),
(13, 525612, 0),
(14, 116241, 0),
(15, 363440, 0),
(16, 588934, 0),
(17, 644801, 0),
(18, 279815, 1),
(19, 520265, 1),
(20, 762706, 1),
(21, 638290, 1),
(22, 852815, 1),
(23, 670593, 1),
(24, 328262, 1),
(25, 519516, 1),
(26, 108904, 1),
(27, 191441, 1);

-- --------------------------------------------------------

--
-- Table structure for table `parking_logs`
--

CREATE TABLE `parking_logs` (
  `ticket_id` int(11) NOT NULL,
  `rfid_uid` varchar(12) NOT NULL,
  `time_in` datetime NOT NULL,
  `time_out` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parking_logs`
--

INSERT INTO `parking_logs` (`ticket_id`, `rfid_uid`, `time_in`, `time_out`) VALUES
(8, 'a3 b3 c3 d4', '2024-07-18 08:17:00', '2024-07-18 08:24:00'),
(9, 'a6 b6 c6 d6', '2024-07-18 08:20:00', '2024-07-18 08:23:00'),
(11, 'a7 b7 c7 d7', '2024-07-18 08:23:00', '2024-07-18 08:24:00'),
(12, 'a1 b1 c1 d1', '2024-07-19 07:28:00', '2024-07-19 08:21:00'),
(13, 'a2 b2 c2 d2', '2024-07-19 08:22:00', '2024-07-19 08:42:00'),
(14, 'a3 b3 c3 d3', '2024-07-19 08:40:00', NULL),
(15, 'a2 b2 c2 d3', '2024-07-19 08:41:00', NULL),
(16, '', '2024-07-22 14:14:00', NULL),
(17, 'a6 b6 c6 d7', '2024-07-22 14:17:00', '2024-07-22 14:17:00');

-- --------------------------------------------------------

--
-- Table structure for table `rfid_user`
--

CREATE TABLE `rfid_user` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `user_email` varchar(254) NOT NULL,
  `rfid_uid` varchar(12) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rfid_user`
--

INSERT INTO `rfid_user` (`user_id`, `first_name`, `last_name`, `user_email`, `rfid_uid`, `reg_date`) VALUES
(1, 'SkyBlue', 'Color', 'facethereality01@gmail.com', 'a6 b6 c5 d', '2024-07-07 22:33:55'),
(49, 'Chent', 'Dy', 'markjemdee01@gmail.com', 'a3 b3 c3 d4', '2024-08-19 10:52:44'),
(50, 'Jemers', 'Garcia', 'markjemdee01@gmail.com', 'a6 b1 c1 d1', '2024-08-26 11:35:50'),
(51, 'Green', 'Color', 'markjemdee01@gmail.com', 'a6 b1 c1 d1', '2024-08-27 23:01:19'),
(52, 'Red ', 'Color', 'markjemdee01@gmail.com', 'a6 b1 c1 d1', '2024-08-27 23:27:25'),
(53, 'Grey', 'Color', 'markjemdee01@gmail.com', 'a6 b1 c1 d1', '2024-08-28 00:15:00'),
(54, 'Violet', 'Color', 'markjemdee01@gmail.com', '185393', '2024-08-28 00:27:34'),
(55, 'Cyan', 'Color', 'markjemdee01@gmail.com', 'a1 b1 c3 d1', '2024-08-29 23:53:36'),
(56, 'Cyan', 'Color', 'markjemdee01@gmail.com', 'a1 b1 c3 d1', '2024-08-29 23:54:47'),
(57, 'Cyan', 'Color', 'markjemdee01@gmail.com', 'a1 b1 c1 d6', '2024-08-29 23:55:44'),
(58, 'Cyan', 'Color', 'markjemdee01@gmail.com', 'a1 b1 c1 d6', '2024-08-30 00:00:52'),
(59, 'Blue', 'Color', 'markjemdee01@gmail.com', 'a7 b1 c1 d1', '2024-08-30 00:01:42'),
(60, 'Blue', 'Color', 'markjemdee01@gmail.com', 'a7 b1 c1 d1', '2024-08-30 00:02:46'),
(61, 'BlackandWhite', 'Color', 'markjemdee01@gmail.com', 'a7 b1 c1 d1', '2024-08-30 00:04:32'),
(62, 'BlackandWhite', 'Color', 'markjemdee01@gmail.com', 'a7 b1 c1 d1', '2024-08-30 00:07:37'),
(63, 'Xenotets', 'Color', 'markjemdee01@gmail.com', 'a7 b1 c1 d1', '2024-08-30 00:14:07'),
(64, 'Xenotets', 'Color', 'markjemdee01@gmail.com', 'a7 b1 c1 d1', '2024-08-30 00:15:03'),
(65, 'Sly', 'Color', 'markjemdee01@gmail.com', 'a1 b1 c1 d1', '2024-08-30 00:16:16'),
(66, 'Yellow', 'Color', 'markjemdee01@gmail.com', 'a1 b1 c1 d1', '2024-08-30 00:17:34');

-- --------------------------------------------------------

--
-- Table structure for table `verification_number`
--

CREATE TABLE `verification_number` (
  `id` int(11) NOT NULL,
  `verify_number` int(11) NOT NULL,
  `is_used` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `verification_number`
--

INSERT INTO `verification_number` (`id`, `verify_number`, `is_used`) VALUES
(1, 471177, 1),
(2, 514468, 1),
(3, 635827, 1),
(4, 289408, 1),
(5, 364336, 1),
(6, 215338, 0),
(9, 121078, 1),
(10, 887042, 1),
(11, 872747, 0),
(12, 519254, 1),
(13, 532453, 1),
(14, 409356, 1),
(15, 936266, 1),
(16, 852150, 1),
(17, 973920, 0),
(18, 536189, 0),
(19, 776121, 0),
(20, 243005, 1),
(21, 840286, 1),
(22, 718880, 1),
(23, 860583, 1),
(24, 228772, 1),
(25, 889723, 1),
(26, 178524, 1),
(27, 271552, 1),
(28, 476839, 1),
(29, 178751, 1),
(30, 974984, 1),
(31, 997117, 1),
(32, 788792, 1),
(33, 890468, 1),
(34, 100034, 1),
(35, 169177, 1),
(36, 615621, 1),
(37, 207243, 1),
(38, 320225, 1),
(39, 141011, 1),
(40, 205645, 1),
(41, 956272, 1),
(42, 566687, 1),
(43, 893134, 1),
(44, 554966, 1),
(45, 365853, 1),
(46, 507627, 1),
(47, 552256, 1),
(48, 262786, 0),
(49, 130640, 1),
(50, 530955, 1),
(51, 576365, 1),
(52, 616632, 0),
(53, 573539, 0),
(54, 522522, 0),
(55, 135008, 1),
(56, 903838, 1),
(57, 777639, 1),
(58, 906318, 1),
(59, 713764, 0),
(60, 991414, 1),
(61, 428009, 1),
(62, 455453, 1),
(63, 185393, 1),
(64, 437891, 1),
(65, 840057, 1),
(66, 123452, 1),
(67, 552904, 1),
(68, 204792, 1),
(69, 697868, 1),
(70, 736793, 1),
(71, 453800, 1),
(72, 356449, 1),
(73, 311259, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_table`
--
ALTER TABLE `admin_table`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `cpverification`
--
ALTER TABLE `cpverification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parking_logs`
--
ALTER TABLE `parking_logs`
  ADD PRIMARY KEY (`ticket_id`);

--
-- Indexes for table `rfid_user`
--
ALTER TABLE `rfid_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `verification_number`
--
ALTER TABLE `verification_number`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_table`
--
ALTER TABLE `admin_table`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cpverification`
--
ALTER TABLE `cpverification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `parking_logs`
--
ALTER TABLE `parking_logs`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `rfid_user`
--
ALTER TABLE `rfid_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `verification_number`
--
ALTER TABLE `verification_number`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
