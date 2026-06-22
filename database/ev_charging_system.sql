-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2026 at 07:08 AM
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
-- Database: `ev_charging_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_account`
--

CREATE TABLE `admin_account` (
  `id` int(11) NOT NULL,
  `total_balance` decimal(10,2) DEFAULT 0.00,
  `commission_balance` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_account`
--

INSERT INTO `admin_account` (`id`, `total_balance`, `commission_balance`) VALUES
(1, 10500.00, 675.00);

-- --------------------------------------------------------

--
-- Table structure for table `admin_commissions`
--

CREATE TABLE `admin_commissions` (
  `commission_id` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_commissions`
--

INSERT INTO `admin_commissions` (`commission_id`, `booking_id`, `amount`, `created_at`) VALUES
(1, 29, 150.00, '2026-06-21 02:50:16'),
(2, 28, 150.00, '2026-06-21 02:50:45'),
(3, 27, 150.00, '2026-06-21 02:50:53'),
(4, 30, 150.00, '2026-06-21 02:54:21'),
(5, 31, 150.00, '2026-06-21 03:05:32'),
(6, 32, 150.00, '2026-06-21 07:06:46'),
(7, 33, 75.00, '2026-06-21 20:03:51');

-- --------------------------------------------------------

--
-- Table structure for table `bank_details`
--

CREATE TABLE `bank_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `account_name` varchar(150) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `branch` varchar(100) DEFAULT NULL,
  `account_number` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `center_id` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `charging_hours` decimal(4,2) DEFAULT 1.00,
  `status` enum('Pending','Approved','Completed','Cancelled','Rejected') DEFAULT 'Pending',
  `estimated_amount` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `energy_kwh` decimal(10,2) DEFAULT 0.00,
  `payment_status` varchar(50) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `center_id`, `booking_date`, `booking_time`, `charging_hours`, `status`, `estimated_amount`, `created_at`, `energy_kwh`, `payment_status`) VALUES
(25, 5, 1, '2026-06-21', '20:00:00', 2.00, 'Completed', 3000.00, '2026-06-19 07:36:44', 0.00, 'Paid'),
(26, 5, 1, '2026-06-21', '18:57:00', 2.00, 'Cancelled', 3000.00, '2026-06-20 13:27:32', 0.00, 'Pending'),
(27, 5, 1, '2026-06-21', '19:00:00', 2.00, 'Completed', 3000.00, '2026-06-20 13:49:42', 0.00, 'Paid'),
(28, 5, 1, '2026-06-21', '20:42:00', 2.00, 'Completed', 3000.00, '2026-06-20 15:12:55', 0.00, 'Paid'),
(29, 5, 1, '2026-06-21', '21:07:00', 2.00, 'Completed', 3000.00, '2026-06-20 15:37:53', 0.00, 'Paid'),
(30, 5, 1, '2026-06-22', '09:23:00', 2.00, 'Completed', 3000.00, '2026-06-21 02:53:45', 0.00, 'Paid'),
(31, 5, 1, '2026-06-24', '11:24:00', 2.00, 'Completed', 3000.00, '2026-06-21 02:55:24', 0.00, 'Paid'),
(32, 5, 1, '2026-06-22', '12:26:00', 2.00, 'Completed', 3000.00, '2026-06-21 06:56:25', 0.00, 'Paid'),
(33, 5, 1, '2026-06-24', '03:33:00', 1.00, 'Completed', 1500.00, '2026-06-21 20:01:13', 0.00, 'Paid'),
(34, 5, 1, '2026-06-24', '08:18:00', 2.00, 'Completed', 3000.00, '2026-06-22 01:47:36', 0.00, 'Paid'),
(35, 5, 1, '2026-06-24', '07:50:00', 2.00, 'Completed', 3000.00, '2026-06-22 02:20:34', 0.00, 'Paid'),
(36, 5, 1, '2026-06-24', '05:22:00', 2.00, 'Completed', 3000.00, '2026-06-22 02:49:24', 0.00, 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `center_bank_accounts`
--

CREATE TABLE `center_bank_accounts` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `account_name` varchar(150) DEFAULT NULL,
  `account_number` varchar(50) DEFAULT NULL,
  `branch_name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `charging_centers`
--

CREATE TABLE `charging_centers` (
  `center_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `center_name` varchar(140) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(80) DEFAULT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `total_slots` int(11) NOT NULL DEFAULT 4,
  `available_slots` int(11) NOT NULL DEFAULT 4,
  `price_per_kwh` decimal(8,2) DEFAULT 0.00,
  `open_time` time DEFAULT '08:00:00',
  `close_time` time DEFAULT '22:00:00',
  `status` enum('Open','Busy','Closed') DEFAULT 'Open',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `description` text DEFAULT NULL,
  `facilities` text DEFAULT NULL,
  `emergency_contact` varchar(20) DEFAULT NULL,
  `queue_count` int(11) DEFAULT 0,
  `total_ports` int(11) NOT NULL DEFAULT 10,
  `wallet_balance` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `charging_centers`
--

INSERT INTO `charging_centers` (`center_id`, `owner_id`, `center_name`, `address`, `city`, `latitude`, `longitude`, `total_slots`, `available_slots`, `price_per_kwh`, `open_time`, `close_time`, `status`, `created_at`, `description`, `facilities`, `emergency_contact`, `queue_count`, `total_ports`, `wallet_balance`) VALUES
(1, 2, 'ECO Charging', '438A opatha ganegoda', 'Elpitiya', 6.3552630, 80.1511760, 10, 24, 1500.00, '04:00:00', '00:01:00', 'Open', '2026-05-29 09:10:02', '', 'Cafe , Parking', '0762071498', 3, 10, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `user_id`, `title`, `message`, `is_read`, `created_at`) VALUES
(19, 5, 'Booking Submitted', 'Your charging slot booking has been submitted successfully and is awaiting center approval.', 1, '2026-06-19 07:36:44'),
(20, 5, 'Booking Submitted', 'Your charging slot booking has been submitted successfully and is awaiting center approval.', 1, '2026-06-20 13:27:32'),
(21, 5, 'Booking Submitted', 'Your charging slot booking has been submitted successfully and is awaiting center approval.', 1, '2026-06-20 13:49:42'),
(22, 2, 'Booking Cancelled', 'An EV owner has cancelled a charging reservation.', 0, '2026-06-20 13:50:11'),
(23, 5, 'Booking Submitted', 'Your charging slot booking has been submitted successfully and is awaiting center approval.', 1, '2026-06-20 15:12:55'),
(24, 5, 'Booking Submitted', 'Your charging slot booking has been submitted successfully and is awaiting center approval.', 1, '2026-06-20 15:37:53'),
(25, 5, 'Booking Submitted', 'Your charging slot booking has been submitted successfully and is awaiting center approval.', 1, '2026-06-21 02:53:45'),
(26, 5, 'Booking Submitted', 'Your charging slot booking has been submitted successfully and is awaiting center approval.', 1, '2026-06-21 02:55:24'),
(27, 2, 'Booking Updated', 'An EV owner modified a booking and it requires approval again.', 0, '2026-06-21 02:56:14'),
(28, 5, 'Booking Submitted', 'Your charging slot booking has been submitted successfully and is awaiting center approval.', 0, '2026-06-21 06:56:25'),
(29, 5, 'Booking Submitted', 'Your charging slot booking has been submitted successfully and is awaiting center approval.', 0, '2026-06-21 20:01:13'),
(30, 5, 'Booking Submitted', 'Your charging slot booking has been submitted successfully and is awaiting center approval.', 0, '2026-06-22 01:47:36'),
(31, 5, 'Booking Submitted', 'Your charging slot booking has been submitted successfully and is awaiting center approval.', 0, '2026-06-22 02:20:34'),
(32, 5, 'Booking Submitted', 'Your charging slot booking has been submitted successfully and is awaiting center approval.', 0, '2026-06-22 02:49:24');

-- --------------------------------------------------------

--
-- Table structure for table `owner_bank_details`
--

CREATE TABLE `owner_bank_details` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `account_name` varchar(150) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `branch` varchar(100) DEFAULT NULL,
  `account_number` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `owner_earnings`
--

CREATE TABLE `owner_earnings` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `total_earned` decimal(10,2) DEFAULT 0.00,
  `withdrawn` decimal(10,2) DEFAULT 0.00,
  `available_balance` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `method` enum('Cash','Online') DEFAULT NULL,
  `status` enum('Pending','Paid','Refunded') DEFAULT 'Pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `release_status` enum('Pending','Released') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `booking_id`, `amount`, `method`, `status`, `paid_at`, `release_status`) VALUES
(24, 25, 3000.00, '', 'Paid', '2026-06-19 08:12:43', 'Released'),
(27, 35, 3000.00, 'Online', 'Paid', '2026-06-22 02:21:09', 'Released'),
(28, 36, 3000.00, 'Online', 'Paid', '2026-06-22 02:50:24', 'Released');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `rating_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `center_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`rating_id`, `user_id`, `center_id`, `rating`, `comment`, `created_at`) VALUES
(1, 4, 1, 5, 'Excellent Service', '2026-05-29 16:13:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('ev_owner','center_owner','admin') NOT NULL DEFAULT 'ev_owner',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `wallet_balance` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `phone`, `password_hash`, `role`, `created_at`, `wallet_balance`) VALUES
(1, 'Isuru Udeshitha', 'isuruudeshitha6@gmail.com', '0762071494', '$2y$10$Ue5x4A/7/ht.rt/ic3s0ue43d/QqM1r0/QMn8DYFB77NcWW/By6Iy', 'ev_owner', '2026-05-29 09:07:27', 0.00),
(2, 'Kamal Perera', 'kamal@gmail.com', '0762071496', '$2y$10$aTeafj/NixO4tzPOG/WPLOIb/04nUYAruDi57RRNZVrPWwdJzTu6q', 'center_owner', '2026-05-29 09:10:02', 0.00),
(3, 'System Admin', 'admin@gmail.com', '0771234567', '$2y$10$Ue5x4A/7/ht.rt/ic3s0ue43d/QqM1r0/QMn8DYFB77NcWW/By6Iy', 'admin', '2026-05-29 12:00:51', 0.00),
(4, 'Isuru Udeshitha', 'isuru@gmail.com', '0762071492', '$2y$10$rs64R0jRBkevft9kJbQ9auQsISE0zYhVpbZhfSjaM0JKqmkYfF0eW', 'ev_owner', '2026-05-29 12:31:41', 0.00),
(5, 'Himara Liyanage', 'liyanagehimara2002@gmail.com', '0769228134', '$2y$10$fmz9KF65x81Gm3SuMZ04muLONsTHRK4my/wZBwNNzRDP/THZk55lm', 'ev_owner', '2026-06-08 09:55:38', 250.00),
(6, 'Nimal Perera', 'nimal@gmail.com', '0769228133', '$2y$10$oseoox8iWLHBW/U0IzgNDekr8He16Frd9K3G3a6EbW4iMHPPYwBUe', 'ev_owner', '2026-06-14 08:00:53', 0.00),
(7, 'Sachintha Imash', 'sachintha21@gmail.com', '0772409293', '$2y$10$RZibHE2lV8nmqdEg7lQRWeUuB0dBqyzdZHv3m012YeVGJXljHteuy', 'ev_owner', '2026-06-16 04:38:12', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `vehicle_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `brand` varchar(80) DEFAULT NULL,
  `model` varchar(80) DEFAULT NULL,
  `plate_no` varchar(30) DEFAULT NULL,
  `battery_capacity` decimal(8,2) DEFAULT NULL,
  `battery_percentage` int(11) DEFAULT 50,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`vehicle_id`, `user_id`, `brand`, `model`, `plate_no`, `battery_capacity`, `battery_percentage`, `latitude`, `longitude`, `updated_at`) VALUES
(1, 1, NULL, 'BYD Shark 3', NULL, 500.00, 30, NULL, NULL, '2026-05-29 09:16:37'),
(2, 4, NULL, 'BYD Shark 2', NULL, 500.00, 65, NULL, NULL, '2026-05-29 16:39:57'),
(3, 5, NULL, 'BYD', NULL, 33.00, 23, NULL, NULL, '2026-06-22 01:50:59'),
(4, 6, NULL, 'BYD', NULL, 33.00, 45, NULL, NULL, '2026-06-22 01:51:09'),
(5, 7, NULL, 'BYD', NULL, 300.00, 55, NULL, NULL, '2026-06-22 01:51:16');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_transactions`
--

CREATE TABLE `wallet_transactions` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `type` enum('TopUp','Deduction') NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wallet_transactions`
--

INSERT INTO `wallet_transactions` (`transaction_id`, `user_id`, `amount`, `type`, `description`, `created_at`) VALUES
(1, 5, 10000.00, 'TopUp', 'Wallet Top Up', '2026-06-20 13:25:51'),
(2, 5, 100.00, 'TopUp', 'Wallet Top Up', '2026-06-20 13:26:23'),
(3, 5, 3000.00, 'Deduction', 'Charging Session', '2026-06-20 13:28:26'),
(4, 5, 3000.00, 'Deduction', 'Charging Session', '2026-06-20 13:28:34'),
(5, 5, 3000.00, 'Deduction', 'Charging Session', '2026-06-20 13:29:48'),
(6, 5, 2000.00, 'TopUp', 'Wallet Top Up', '2026-06-20 13:49:27'),
(7, 5, 3000.00, 'Deduction', 'Charging Session Payment', '2026-06-20 15:15:18'),
(8, 5, 3000.00, 'TopUp', 'Wallet Top Up', '2026-06-20 15:17:39'),
(9, 5, 3000.00, 'Deduction', 'Charging Session Payment', '2026-06-20 15:17:49'),
(10, 5, 3000.00, 'TopUp', 'Wallet Top Up', '2026-06-20 15:37:45'),
(11, 5, 3000.00, 'Deduction', 'Charging Session Payment', '2026-06-20 15:38:37'),
(12, 5, 3000.00, 'TopUp', 'Wallet Top Up', '2026-06-20 15:39:34'),
(13, 5, 3000.00, 'Deduction', 'Charging Session Payment', '2026-06-20 15:39:39'),
(14, 5, 3000.00, 'TopUp', 'Wallet Top Up', '2026-06-21 02:50:09'),
(15, 5, 3000.00, 'Deduction', 'Charging Session Payment', '2026-06-21 02:50:16'),
(16, 5, 6000.00, 'TopUp', 'Wallet Top Up', '2026-06-21 02:50:38'),
(17, 5, 3000.00, 'Deduction', 'Charging Session Payment', '2026-06-21 02:50:45'),
(18, 5, 3000.00, 'Deduction', 'Charging Session Payment', '2026-06-21 02:50:53'),
(19, 5, 3000.00, 'TopUp', 'Wallet Top Up', '2026-06-21 02:53:41'),
(20, 5, 3000.00, 'Deduction', 'Charging Session Payment', '2026-06-21 02:54:20'),
(21, 5, 3000.00, 'TopUp', 'Wallet Top Up', '2026-06-21 02:55:00'),
(22, 5, 3000.00, 'Deduction', 'Charging Session Payment', '2026-06-21 03:05:32'),
(23, 5, 100.00, 'TopUp', 'Wallet Top Up', '2026-06-21 03:25:57'),
(24, 5, 100.00, 'TopUp', 'Wallet Top Up via Card', '2026-06-21 04:09:33'),
(25, 5, 100.00, 'TopUp', 'Wallet Top Up via Card', '2026-06-21 04:24:45'),
(26, 5, 100.00, 'TopUp', 'Wallet Top Up via Card', '2026-06-21 04:31:30'),
(27, 5, 100.00, 'TopUp', 'Wallet Top Up via Card', '2026-06-21 04:34:52'),
(28, 5, 100.00, 'TopUp', 'Wallet Top Up via Card', '2026-06-21 04:46:54'),
(29, 5, 100.00, 'TopUp', 'Card Payment', '2026-06-21 04:57:19'),
(30, 5, 100.00, 'TopUp', 'Wallet Top Up via Card', '2026-06-21 05:04:44'),
(31, 5, 100.00, 'TopUp', 'Wallet Top Up via Card', '2026-06-21 05:48:11'),
(32, 5, 250.00, 'TopUp', 'Wallet Top Up via Card', '2026-06-21 06:51:18'),
(33, 5, 2000.00, 'TopUp', 'Wallet Top Up via Card', '2026-06-21 06:54:36'),
(34, 5, 2000.00, 'TopUp', 'Wallet Top Up via Online Banking', '2026-06-21 06:55:27'),
(35, 5, 3000.00, 'Deduction', 'Charging Session Payment', '2026-06-21 07:06:46'),
(36, 5, 1500.00, 'Deduction', 'Charging Session Payment', '2026-06-21 20:02:24'),
(37, 5, 1000.00, 'TopUp', 'Wallet Top Up via Card', '2026-06-21 20:03:42'),
(38, 5, 1500.00, 'Deduction', 'Charging Session Payment', '2026-06-21 20:03:51'),
(39, 5, 3000.00, 'TopUp', 'Wallet Top Up via Card', '2026-06-22 01:47:02'),
(40, 5, 3000.00, 'Deduction', 'Charging Session Payment', '2026-06-22 01:52:00'),
(41, 5, 3000.00, 'TopUp', 'Wallet Top Up via Card', '2026-06-22 02:20:01'),
(42, 5, 3000.00, 'Deduction', 'Charging Session Payment', '2026-06-22 02:21:09'),
(43, 5, 3000.00, 'TopUp', 'Wallet Top Up via Card', '2026-06-22 02:34:36'),
(44, 5, 3000.00, 'Deduction', 'Charging Session Payment', '2026-06-22 02:50:24');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal_receipts`
--

CREATE TABLE `withdrawal_receipts` (
  `receipt_id` int(11) NOT NULL,
  `request_id` int(11) DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal_requests`
--

CREATE TABLE `withdrawal_requests` (
  `request_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `request_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_account`
--
ALTER TABLE `admin_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_commissions`
--
ALTER TABLE `admin_commissions`
  ADD PRIMARY KEY (`commission_id`);

--
-- Indexes for table `bank_details`
--
ALTER TABLE `bank_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `center_id` (`center_id`);

--
-- Indexes for table `center_bank_accounts`
--
ALTER TABLE `center_bank_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `charging_centers`
--
ALTER TABLE `charging_centers`
  ADD PRIMARY KEY (`center_id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `owner_bank_details`
--
ALTER TABLE `owner_bank_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `owner_earnings`
--
ALTER TABLE `owner_earnings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `center_id` (`center_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`vehicle_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `withdrawal_receipts`
--
ALTER TABLE `withdrawal_receipts`
  ADD PRIMARY KEY (`receipt_id`);

--
-- Indexes for table `withdrawal_requests`
--
ALTER TABLE `withdrawal_requests`
  ADD PRIMARY KEY (`request_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_account`
--
ALTER TABLE `admin_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_commissions`
--
ALTER TABLE `admin_commissions`
  MODIFY `commission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bank_details`
--
ALTER TABLE `bank_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `center_bank_accounts`
--
ALTER TABLE `center_bank_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `charging_centers`
--
ALTER TABLE `charging_centers`
  MODIFY `center_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `owner_bank_details`
--
ALTER TABLE `owner_bank_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `owner_earnings`
--
ALTER TABLE `owner_earnings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `withdrawal_receipts`
--
ALTER TABLE `withdrawal_receipts`
  MODIFY `receipt_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawal_requests`
--
ALTER TABLE `withdrawal_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`center_id`) REFERENCES `charging_centers` (`center_id`) ON DELETE CASCADE;

--
-- Constraints for table `charging_centers`
--
ALTER TABLE `charging_centers`
  ADD CONSTRAINT `charging_centers_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`) ON DELETE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`center_id`) REFERENCES `charging_centers` (`center_id`) ON DELETE CASCADE;

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
