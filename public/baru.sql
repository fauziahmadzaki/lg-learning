-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 24, 2025 at 04:09 PM
-- Server version: 11.8.3-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u357836754_lg_learning`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `subject_type` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `branch_id`, `action`, `description`, `subject_type`, `subject_id`, `properties`, `created_at`, `updated_at`) VALUES
(2, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 1, '[]', '2025-12-21 20:54:45', '2025-12-21 20:54:45'),
(3, 1, NULL, 'UPDATE', 'Mengubah data di tabel Transaction', 'App\\Models\\Transaction', 1, '{\"payment_url\":{\"from\":\"#\",\"to\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/6947fc2ee01d49ab6232d1c2\"}}', '2025-12-21 20:54:46', '2025-12-21 20:54:46'),
(4, 1, NULL, 'UPDATE', 'Mengubah data di tabel Transaction', 'App\\Models\\Transaction', 1, '{\"status\":{\"from\":\"PENDING\",\"to\":\"PAID\"},\"payment_method\":{\"from\":null,\"to\":\"EWALLET\"},\"payment_channel\":{\"from\":null,\"to\":\"Unknown\"},\"paid_at\":{\"from\":null,\"to\":\"2025-12-21 20:55:17\"}}', '2025-12-21 20:55:17', '2025-12-21 20:55:17'),
(6, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 2, '[]', '2025-12-21 21:16:54', '2025-12-21 21:16:54'),
(7, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 2, '{\"next_billing_date\":{\"from\":null,\"to\":\"2026-01-21 00:00:00\"}}', '2025-12-21 21:16:54', '2025-12-21 21:16:54'),
(8, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 2, '[]', '2025-12-21 21:16:54', '2025-12-21 21:16:54'),
(9, 1, NULL, 'UPDATE', 'Mengubah data di tabel Transaction', 'App\\Models\\Transaction', 2, '{\"payment_url\":{\"from\":\"#\",\"to\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/6948015eed9720df7733c6a4\"}}', '2025-12-21 21:16:55', '2025-12-21 21:16:55'),
(10, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 3, '[]', '2025-12-21 21:18:12', '2025-12-21 21:18:12'),
(11, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 3, '{\"next_billing_date\":{\"from\":null,\"to\":\"2026-01-21 00:00:00\"}}', '2025-12-21 21:18:12', '2025-12-21 21:18:12'),
(12, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 3, '[]', '2025-12-21 21:18:12', '2025-12-21 21:18:12'),
(13, 1, NULL, 'UPDATE', 'Mengubah data di tabel Transaction', 'App\\Models\\Transaction', 3, '{\"payment_url\":{\"from\":\"#\",\"to\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/694801aced9720df7733c6c7\"}}', '2025-12-21 21:18:13', '2025-12-21 21:18:13'),
(14, NULL, NULL, 'UPDATE', 'Mengubah data di tabel Transaction', 'App\\Models\\Transaction', 3, '{\"status\":{\"from\":\"PENDING\",\"to\":\"PAID\"},\"payment_method\":{\"from\":null,\"to\":\"EWALLET\"},\"payment_channel\":{\"from\":null,\"to\":\"Unknown\"},\"paid_at\":{\"from\":null,\"to\":\"2025-12-22 06:57:40\"}}', '2025-12-22 06:57:40', '2025-12-22 06:57:40'),
(15, NULL, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 3, '{\"status\":{\"from\":\"pending\",\"to\":\"active\"}}', '2025-12-22 06:57:40', '2025-12-22 06:57:40'),
(16, 1, NULL, 'UPDATE', 'Mengubah data di tabel Transaction', 'App\\Models\\Transaction', 2, '{\"status\":{\"from\":\"PENDING\",\"to\":\"PAID\"},\"payment_method\":{\"from\":null,\"to\":\"EWALLET\"},\"payment_channel\":{\"from\":null,\"to\":\"Unknown\"},\"paid_at\":{\"from\":null,\"to\":\"2025-12-22 09:50:57\"}}', '2025-12-22 09:50:57', '2025-12-22 09:50:57'),
(17, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 2, '{\"status\":{\"from\":\"pending\",\"to\":\"active\"}}', '2025-12-22 09:50:57', '2025-12-22 09:50:57'),
(18, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 4, '[]', '2025-12-22 09:52:31', '2025-12-22 09:52:31'),
(19, 1, NULL, 'UPDATE', 'Mengubah data di tabel Transaction', 'App\\Models\\Transaction', 4, '{\"payment_url\":{\"from\":\"#\",\"to\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/6948b277ed9720df77348439\"}}', '2025-12-22 09:52:31', '2025-12-22 09:52:31'),
(20, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 2, '{\"next_billing_date\":{\"from\":\"2026-01-20T17:00:00.000000Z\",\"to\":\"2026-02-21 00:00:00\"}}', '2025-12-22 09:52:31', '2025-12-22 09:52:31'),
(21, 1, NULL, 'UPDATE', 'Mengubah data di tabel Transaction', 'App\\Models\\Transaction', 4, '{\"status\":{\"from\":\"PENDING\",\"to\":\"PAID\"},\"payment_method\":{\"from\":null,\"to\":\"EWALLET\"},\"payment_channel\":{\"from\":null,\"to\":\"Unknown\"},\"paid_at\":{\"from\":null,\"to\":\"2025-12-22 09:52:56\"}}', '2025-12-22 09:52:56', '2025-12-22 09:52:56'),
(22, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 5, '[]', '2025-12-22 09:53:46', '2025-12-22 09:53:46'),
(23, 1, NULL, 'DELETE', 'Menghapus data di tabel Student', 'App\\Models\\Student', 2, '[]', '2025-12-22 10:01:53', '2025-12-22 10:01:53'),
(24, 1, 2, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 4, '[]', '2025-12-22 10:02:54', '2025-12-22 10:02:54'),
(25, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 6, '[]', '2025-12-22 10:02:54', '2025-12-22 10:02:54'),
(26, 1, NULL, 'UPDATE', 'Mengubah data di tabel Transaction', 'App\\Models\\Transaction', 6, '{\"payment_url\":{\"from\":\"#\",\"to\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/6948b4e7ed9720df7734889b\"}}', '2025-12-22 10:02:55', '2025-12-22 10:02:55'),
(27, NULL, NULL, 'UPDATE', 'Mengubah data di tabel Transaction', 'App\\Models\\Transaction', 6, '{\"status\":{\"from\":\"PENDING\",\"to\":\"PAID\"},\"payment_method\":{\"from\":null,\"to\":\"EWALLET\"},\"payment_channel\":{\"from\":null,\"to\":\"GOPAY\"},\"paid_at\":{\"from\":null,\"to\":\"2025-12-22 03:03:12\"}}', '2025-12-22 10:03:06', '2025-12-22 10:03:06'),
(28, NULL, 2, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 4, '{\"status\":{\"from\":\"inactive\",\"to\":\"active\"},\"next_billing_date\":{\"from\":null,\"to\":\"2026-01-22 00:00:00\"}}', '2025-12-22 10:03:06', '2025-12-22 10:03:06'),
(29, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 5, '[]', '2025-12-23 19:46:46', '2025-12-23 19:46:46'),
(30, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 5, '{\"next_billing_date\":{\"from\":null,\"to\":\"2026-01-23 00:00:00\"}}', '2025-12-23 19:46:46', '2025-12-23 19:46:46'),
(31, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 7, '[]', '2025-12-23 19:46:46', '2025-12-23 19:46:46'),
(32, 1, NULL, 'UPDATE', 'Mengubah data di tabel Transaction', 'App\\Models\\Transaction', 7, '{\"payment_url\":{\"from\":\"#\",\"to\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/694a8f3ef71f8b0973b2301f\"}}', '2025-12-23 19:46:46', '2025-12-23 19:46:46'),
(33, NULL, NULL, 'UPDATE', 'Mengubah data di tabel Transaction', 'App\\Models\\Transaction', 7, '{\"status\":{\"from\":\"PENDING\",\"to\":\"PAID\"},\"payment_method\":{\"from\":null,\"to\":\"EWALLET\"},\"payment_channel\":{\"from\":null,\"to\":\"DANA\"},\"paid_at\":{\"from\":null,\"to\":\"2025-12-23 13:00:58\"}}', '2025-12-23 20:01:51', '2025-12-23 20:01:51'),
(34, NULL, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 5, '{\"status\":{\"from\":\"pending\",\"to\":\"active\"}}', '2025-12-23 20:01:51', '2025-12-23 20:01:51'),
(35, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 6, '[]', '2025-12-23 20:03:04', '2025-12-23 20:03:04'),
(36, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 6, '{\"next_billing_date\":{\"from\":null,\"to\":\"2026-01-23 00:00:00\"}}', '2025-12-23 20:03:04', '2025-12-23 20:03:04'),
(37, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 8, '[]', '2025-12-23 20:03:04', '2025-12-23 20:03:04'),
(38, 1, NULL, 'UPDATE', 'Mengubah data di tabel Transaction', 'App\\Models\\Transaction', 8, '{\"payment_url\":{\"from\":\"#\",\"to\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/694a9310e9ac6f97a03ce10d\"}}', '2025-12-23 20:03:04', '2025-12-23 20:03:04'),
(39, NULL, NULL, 'UPDATE', 'Mengubah data di tabel Transaction', 'App\\Models\\Transaction', 8, '{\"status\":{\"from\":\"PENDING\",\"to\":\"PAID\"},\"payment_method\":{\"from\":null,\"to\":\"EWALLET\"},\"payment_channel\":{\"from\":null,\"to\":\"DANA\"},\"paid_at\":{\"from\":null,\"to\":\"2025-12-23 13:04:40\"}}', '2025-12-23 20:05:37', '2025-12-23 20:05:37'),
(40, NULL, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 6, '{\"status\":{\"from\":\"pending\",\"to\":\"active\"}}', '2025-12-23 20:05:37', '2025-12-23 20:05:37'),
(41, 1, NULL, 'DELETE', 'Menghapus data di tabel Student', 'App\\Models\\Student', 6, '[]', '2025-12-24 10:18:18', '2025-12-24 10:18:18'),
(42, 1, NULL, 'DELETE', 'Menghapus data di tabel Student', 'App\\Models\\Student', 5, '[]', '2025-12-24 10:18:27', '2025-12-24 10:18:27'),
(43, 1, 2, 'DELETE', 'Menghapus data di tabel Student', 'App\\Models\\Student', 4, '[]', '2025-12-24 10:18:38', '2025-12-24 10:18:38'),
(44, 1, NULL, 'DELETE', 'Menghapus data di tabel Student', 'App\\Models\\Student', 3, '[]', '2025-12-24 10:18:44', '2025-12-24 10:18:44'),
(45, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 7, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(46, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 9, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(47, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 10, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(48, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 11, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(49, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 12, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(50, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 13, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(51, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 14, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(52, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 15, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(53, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 16, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(54, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 17, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(55, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 18, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(56, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 19, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(57, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 20, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(58, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 21, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(59, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 22, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(60, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 23, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(61, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 24, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(62, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 25, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(63, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 26, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(64, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 27, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(65, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 28, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(66, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 29, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(67, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 30, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(68, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 31, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(69, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 32, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(70, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 33, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(71, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 34, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(72, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 35, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(73, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 36, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(74, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 37, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(75, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 38, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(76, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 39, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(77, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 40, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(78, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 41, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(79, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 42, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(80, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 43, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(81, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 44, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(82, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 45, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(83, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 46, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(84, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 47, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(85, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 48, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(86, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 49, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(87, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 50, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(88, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 51, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(89, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 52, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(90, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 53, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(91, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 54, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(92, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 55, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(93, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 56, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(94, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 57, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(95, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 58, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(96, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 59, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(97, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 60, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(98, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 61, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(99, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 62, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(100, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 63, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(101, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 64, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(102, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 65, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(103, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 66, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(104, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 67, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(105, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 68, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(106, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 69, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(107, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 70, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(108, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 71, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(109, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 72, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(110, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 73, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(111, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 74, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(112, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 75, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(113, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 76, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(114, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 77, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(115, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 78, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(116, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 79, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(117, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 80, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(118, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 81, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(119, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 82, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(120, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 83, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(121, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 84, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(122, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 85, '[]', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(123, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 7, '{\"next_billing_date\":{\"from\":null,\"to\":\"2025-12-29 00:00:00\"}}', '2025-12-24 11:42:49', '2025-12-24 11:42:49'),
(124, 1, NULL, 'DELETE', 'Menghapus data di tabel Student', 'App\\Models\\Student', 7, '[]', '2025-12-24 15:11:28', '2025-12-24 15:11:28'),
(125, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 8, '[]', '2025-12-24 18:33:44', '2025-12-24 18:33:44'),
(126, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 86, '[]', '2025-12-24 18:33:44', '2025-12-24 18:33:44'),
(127, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 87, '[]', '2025-12-24 18:33:44', '2025-12-24 18:33:44'),
(128, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 88, '[]', '2025-12-24 18:33:44', '2025-12-24 18:33:44'),
(129, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 89, '[]', '2025-12-24 18:33:44', '2025-12-24 18:33:44'),
(130, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 90, '[]', '2025-12-24 18:33:44', '2025-12-24 18:33:44'),
(131, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 91, '[]', '2025-12-24 18:33:44', '2025-12-24 18:33:44'),
(132, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 8, '{\"next_billing_date\":{\"from\":null,\"to\":\"2026-01-14 00:00:00\"}}', '2025-12-24 18:33:44', '2025-12-24 18:33:44'),
(133, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 9, '[]', '2025-12-24 18:37:08', '2025-12-24 18:37:08'),
(134, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 92, '[]', '2025-12-24 18:37:08', '2025-12-24 18:37:08'),
(135, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 93, '[]', '2025-12-24 18:37:08', '2025-12-24 18:37:08'),
(136, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 94, '[]', '2025-12-24 18:37:08', '2025-12-24 18:37:08'),
(137, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 95, '[]', '2025-12-24 18:37:08', '2025-12-24 18:37:08'),
(138, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 96, '[]', '2025-12-24 18:37:08', '2025-12-24 18:37:08'),
(139, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 97, '[]', '2025-12-24 18:37:08', '2025-12-24 18:37:08'),
(140, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 9, '{\"next_billing_date\":{\"from\":null,\"to\":\"2026-01-14 00:00:00\"}}', '2025-12-24 18:37:08', '2025-12-24 18:37:08'),
(141, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 10, '[]', '2025-12-24 18:40:50', '2025-12-24 18:40:50'),
(142, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 10, '{\"next_billing_date\":{\"from\":null,\"to\":\"2025-08-14 00:00:00\"}}', '2025-12-24 18:40:50', '2025-12-24 18:40:50'),
(143, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 98, '[]', '2025-12-24 18:40:50', '2025-12-24 18:40:50'),
(144, 1, NULL, 'UPDATE', 'Mengubah data di tabel Transaction', 'App\\Models\\Transaction', 98, '{\"payment_url\":{\"from\":\"#\",\"to\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/694bd14b8e155878cdc639a1\"}}', '2025-12-24 18:40:51', '2025-12-24 18:40:51'),
(145, 1, NULL, 'DELETE', 'Menghapus data di tabel Student', 'App\\Models\\Student', 10, '[]', '2025-12-24 18:42:31', '2025-12-24 18:42:31'),
(146, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 11, '[]', '2025-12-24 18:44:56', '2025-12-24 18:44:56'),
(147, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 99, '[]', '2025-12-24 18:44:56', '2025-12-24 18:44:56'),
(148, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 100, '[]', '2025-12-24 18:44:56', '2025-12-24 18:44:56'),
(149, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 101, '[]', '2025-12-24 18:44:56', '2025-12-24 18:44:56'),
(150, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 102, '[]', '2025-12-24 18:44:56', '2025-12-24 18:44:56'),
(151, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 103, '[]', '2025-12-24 18:44:56', '2025-12-24 18:44:56'),
(152, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 104, '[]', '2025-12-24 18:44:56', '2025-12-24 18:44:56'),
(153, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 105, '[]', '2025-12-24 18:44:56', '2025-12-24 18:44:56'),
(154, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 106, '[]', '2025-12-24 18:44:56', '2025-12-24 18:44:56'),
(155, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 107, '[]', '2025-12-24 18:44:56', '2025-12-24 18:44:56'),
(156, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 108, '[]', '2025-12-24 18:44:56', '2025-12-24 18:44:56'),
(157, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 109, '[]', '2025-12-24 18:44:56', '2025-12-24 18:44:56'),
(158, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 110, '[]', '2025-12-24 18:44:56', '2025-12-24 18:44:56'),
(159, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 111, '[]', '2025-12-24 18:44:56', '2025-12-24 18:44:56'),
(160, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 112, '[]', '2025-12-24 18:44:56', '2025-12-24 18:44:56'),
(161, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 113, '[]', '2025-12-24 18:44:56', '2025-12-24 18:44:56'),
(162, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 114, '[]', '2025-12-24 18:44:56', '2025-12-24 18:44:56'),
(163, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 115, '[]', '2025-12-24 18:44:56', '2025-12-24 18:44:56'),
(164, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 116, '[]', '2025-12-24 18:44:56', '2025-12-24 18:44:56'),
(165, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 117, '[]', '2025-12-24 18:44:56', '2025-12-24 18:44:56'),
(166, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 118, '[]', '2025-12-24 18:44:56', '2025-12-24 18:44:56'),
(167, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 119, '[]', '2025-12-24 18:44:56', '2025-12-24 18:44:56'),
(168, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 120, '[]', '2025-12-24 18:44:56', '2025-12-24 18:44:56'),
(169, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 121, '[]', '2025-12-24 18:44:56', '2025-12-24 18:44:56'),
(170, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 122, '[]', '2025-12-24 18:44:56', '2025-12-24 18:44:56'),
(171, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 11, '{\"next_billing_date\":{\"from\":null,\"to\":\"2025-12-29 00:00:00\"}}', '2025-12-24 18:44:56', '2025-12-24 18:44:56'),
(172, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 11, '{\"status\":{\"from\":\"active\",\"to\":\"inactive\"}}', '2025-12-24 18:45:11', '2025-12-24 18:45:11'),
(173, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 12, '[]', '2025-12-24 18:49:52', '2025-12-24 18:49:52'),
(174, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 123, '[]', '2025-12-24 18:49:52', '2025-12-24 18:49:52'),
(175, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 124, '[]', '2025-12-24 18:49:52', '2025-12-24 18:49:52'),
(176, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 125, '[]', '2025-12-24 18:49:52', '2025-12-24 18:49:52'),
(177, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 126, '[]', '2025-12-24 18:49:52', '2025-12-24 18:49:52'),
(178, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 127, '[]', '2025-12-24 18:49:52', '2025-12-24 18:49:52'),
(179, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 128, '[]', '2025-12-24 18:49:52', '2025-12-24 18:49:52'),
(180, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 12, '{\"next_billing_date\":{\"from\":null,\"to\":\"2026-01-14 00:00:00\"}}', '2025-12-24 18:49:52', '2025-12-24 18:49:52'),
(181, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 13, '[]', '2025-12-24 18:54:14', '2025-12-24 18:54:14'),
(182, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 129, '[]', '2025-12-24 18:54:14', '2025-12-24 18:54:14'),
(183, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 130, '[]', '2025-12-24 18:54:14', '2025-12-24 18:54:14'),
(184, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 131, '[]', '2025-12-24 18:54:14', '2025-12-24 18:54:14'),
(185, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 132, '[]', '2025-12-24 18:54:14', '2025-12-24 18:54:14'),
(186, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 133, '[]', '2025-12-24 18:54:14', '2025-12-24 18:54:14'),
(187, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 134, '[]', '2025-12-24 18:54:14', '2025-12-24 18:54:14'),
(188, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 13, '{\"next_billing_date\":{\"from\":null,\"to\":\"2026-01-14 00:00:00\"}}', '2025-12-24 18:54:14', '2025-12-24 18:54:14'),
(189, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 14, '[]', '2025-12-24 18:59:16', '2025-12-24 18:59:16'),
(190, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 135, '[]', '2025-12-24 18:59:16', '2025-12-24 18:59:16'),
(191, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 136, '[]', '2025-12-24 18:59:16', '2025-12-24 18:59:16'),
(192, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 137, '[]', '2025-12-24 18:59:16', '2025-12-24 18:59:16'),
(193, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 138, '[]', '2025-12-24 18:59:16', '2025-12-24 18:59:16'),
(194, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 139, '[]', '2025-12-24 18:59:16', '2025-12-24 18:59:16'),
(195, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 140, '[]', '2025-12-24 18:59:16', '2025-12-24 18:59:16'),
(196, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 141, '[]', '2025-12-24 18:59:16', '2025-12-24 18:59:16'),
(197, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 142, '[]', '2025-12-24 18:59:16', '2025-12-24 18:59:16'),
(198, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 143, '[]', '2025-12-24 18:59:16', '2025-12-24 18:59:16'),
(199, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 144, '[]', '2025-12-24 18:59:16', '2025-12-24 18:59:16'),
(200, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 145, '[]', '2025-12-24 18:59:16', '2025-12-24 18:59:16'),
(201, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 146, '[]', '2025-12-24 18:59:16', '2025-12-24 18:59:16'),
(202, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 147, '[]', '2025-12-24 18:59:16', '2025-12-24 18:59:16'),
(203, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 148, '[]', '2025-12-24 18:59:16', '2025-12-24 18:59:16'),
(204, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 149, '[]', '2025-12-24 18:59:16', '2025-12-24 18:59:16'),
(205, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 150, '[]', '2025-12-24 18:59:16', '2025-12-24 18:59:16'),
(206, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 151, '[]', '2025-12-24 18:59:16', '2025-12-24 18:59:16'),
(207, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 152, '[]', '2025-12-24 18:59:16', '2025-12-24 18:59:16'),
(208, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 153, '[]', '2025-12-24 18:59:16', '2025-12-24 18:59:16'),
(209, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 154, '[]', '2025-12-24 18:59:16', '2025-12-24 18:59:16'),
(210, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 155, '[]', '2025-12-24 18:59:16', '2025-12-24 18:59:16'),
(211, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 156, '[]', '2025-12-24 18:59:16', '2025-12-24 18:59:16'),
(212, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 157, '[]', '2025-12-24 18:59:16', '2025-12-24 18:59:16'),
(213, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 158, '[]', '2025-12-24 18:59:16', '2025-12-24 18:59:16'),
(214, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 14, '{\"next_billing_date\":{\"from\":null,\"to\":\"2025-12-29 00:00:00\"}}', '2025-12-24 18:59:16', '2025-12-24 18:59:16'),
(215, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 15, '[]', '2025-12-24 19:06:59', '2025-12-24 19:06:59'),
(216, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 159, '[]', '2025-12-24 19:06:59', '2025-12-24 19:06:59'),
(217, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 160, '[]', '2025-12-24 19:06:59', '2025-12-24 19:06:59'),
(218, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 161, '[]', '2025-12-24 19:06:59', '2025-12-24 19:06:59'),
(219, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 162, '[]', '2025-12-24 19:06:59', '2025-12-24 19:06:59'),
(220, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 163, '[]', '2025-12-24 19:06:59', '2025-12-24 19:06:59'),
(221, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 164, '[]', '2025-12-24 19:06:59', '2025-12-24 19:06:59'),
(222, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 15, '{\"next_billing_date\":{\"from\":null,\"to\":\"2026-01-14 00:00:00\"}}', '2025-12-24 19:06:59', '2025-12-24 19:06:59'),
(223, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 16, '[]', '2025-12-24 19:13:02', '2025-12-24 19:13:02'),
(224, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 165, '[]', '2025-12-24 19:13:02', '2025-12-24 19:13:02'),
(225, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 166, '[]', '2025-12-24 19:13:02', '2025-12-24 19:13:02'),
(226, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 167, '[]', '2025-12-24 19:13:02', '2025-12-24 19:13:02'),
(227, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 168, '[]', '2025-12-24 19:13:03', '2025-12-24 19:13:03'),
(228, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 169, '[]', '2025-12-24 19:13:03', '2025-12-24 19:13:03'),
(229, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 170, '[]', '2025-12-24 19:13:03', '2025-12-24 19:13:03'),
(230, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 16, '{\"next_billing_date\":{\"from\":null,\"to\":\"2026-01-14 00:00:00\"}}', '2025-12-24 19:13:03', '2025-12-24 19:13:03'),
(231, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 8, '{\"status\":{\"from\":\"active\",\"to\":\"inactive\"}}', '2025-12-24 19:17:44', '2025-12-24 19:17:44'),
(232, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 9, '{\"status\":{\"from\":\"active\",\"to\":\"inactive\"}}', '2025-12-24 19:18:02', '2025-12-24 19:18:02'),
(233, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 12, '{\"status\":{\"from\":\"active\",\"to\":\"inactive\"}}', '2025-12-24 19:18:17', '2025-12-24 19:18:17'),
(234, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 13, '{\"status\":{\"from\":\"active\",\"to\":\"inactive\"}}', '2025-12-24 19:18:35', '2025-12-24 19:18:35'),
(235, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 16, '{\"status\":{\"from\":\"active\",\"to\":\"inactive\"}}', '2025-12-24 19:18:50', '2025-12-24 19:18:50'),
(236, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 14, '{\"status\":{\"from\":\"active\",\"to\":\"inactive\"}}', '2025-12-24 19:19:06', '2025-12-24 19:19:06'),
(237, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 15, '{\"status\":{\"from\":\"active\",\"to\":\"inactive\"}}', '2025-12-24 19:19:19', '2025-12-24 19:19:19'),
(238, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 17, '[]', '2025-12-24 19:28:14', '2025-12-24 19:28:14'),
(239, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 171, '[]', '2025-12-24 19:28:14', '2025-12-24 19:28:14'),
(240, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 172, '[]', '2025-12-24 19:28:14', '2025-12-24 19:28:14'),
(241, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 173, '[]', '2025-12-24 19:28:14', '2025-12-24 19:28:14'),
(242, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 174, '[]', '2025-12-24 19:28:14', '2025-12-24 19:28:14'),
(243, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 175, '[]', '2025-12-24 19:28:14', '2025-12-24 19:28:14'),
(244, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 176, '[]', '2025-12-24 19:28:14', '2025-12-24 19:28:14'),
(245, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 177, '[]', '2025-12-24 19:28:14', '2025-12-24 19:28:14'),
(246, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 178, '[]', '2025-12-24 19:28:14', '2025-12-24 19:28:14'),
(247, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 179, '[]', '2025-12-24 19:28:14', '2025-12-24 19:28:14'),
(248, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 180, '[]', '2025-12-24 19:28:14', '2025-12-24 19:28:14'),
(249, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 181, '[]', '2025-12-24 19:28:14', '2025-12-24 19:28:14'),
(250, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 182, '[]', '2025-12-24 19:28:14', '2025-12-24 19:28:14'),
(251, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 183, '[]', '2025-12-24 19:28:14', '2025-12-24 19:28:14'),
(252, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 184, '[]', '2025-12-24 19:28:14', '2025-12-24 19:28:14'),
(253, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 185, '[]', '2025-12-24 19:28:14', '2025-12-24 19:28:14'),
(254, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 186, '[]', '2025-12-24 19:28:14', '2025-12-24 19:28:14'),
(255, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 187, '[]', '2025-12-24 19:28:14', '2025-12-24 19:28:14'),
(256, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 188, '[]', '2025-12-24 19:28:14', '2025-12-24 19:28:14'),
(257, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 189, '[]', '2025-12-24 19:28:14', '2025-12-24 19:28:14'),
(258, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 190, '[]', '2025-12-24 19:28:14', '2025-12-24 19:28:14'),
(259, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 191, '[]', '2025-12-24 19:28:14', '2025-12-24 19:28:14'),
(260, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 192, '[]', '2025-12-24 19:28:14', '2025-12-24 19:28:14'),
(261, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 193, '[]', '2025-12-24 19:28:14', '2025-12-24 19:28:14'),
(262, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 194, '[]', '2025-12-24 19:28:14', '2025-12-24 19:28:14'),
(263, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 17, '{\"next_billing_date\":{\"from\":null,\"to\":\"2025-12-29 00:00:00\"}}', '2025-12-24 19:28:14', '2025-12-24 19:28:14'),
(264, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 17, '{\"status\":{\"from\":\"active\",\"to\":\"inactive\"}}', '2025-12-24 19:28:38', '2025-12-24 19:28:38'),
(265, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 18, '[]', '2025-12-24 19:35:24', '2025-12-24 19:35:24'),
(266, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 195, '[]', '2025-12-24 19:35:24', '2025-12-24 19:35:24'),
(267, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 196, '[]', '2025-12-24 19:35:24', '2025-12-24 19:35:24'),
(268, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 197, '[]', '2025-12-24 19:35:24', '2025-12-24 19:35:24'),
(269, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 198, '[]', '2025-12-24 19:35:24', '2025-12-24 19:35:24'),
(270, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 199, '[]', '2025-12-24 19:35:24', '2025-12-24 19:35:24'),
(271, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 200, '[]', '2025-12-24 19:35:24', '2025-12-24 19:35:24'),
(272, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 18, '{\"next_billing_date\":{\"from\":null,\"to\":\"2026-01-14 00:00:00\"}}', '2025-12-24 19:35:24', '2025-12-24 19:35:24'),
(273, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 18, '{\"status\":{\"from\":\"active\",\"to\":\"inactive\"}}', '2025-12-24 19:35:45', '2025-12-24 19:35:45'),
(274, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 19, '[]', '2025-12-24 19:39:38', '2025-12-24 19:39:38'),
(275, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 201, '[]', '2025-12-24 19:39:38', '2025-12-24 19:39:38'),
(276, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 202, '[]', '2025-12-24 19:39:38', '2025-12-24 19:39:38'),
(277, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 203, '[]', '2025-12-24 19:39:38', '2025-12-24 19:39:38'),
(278, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 204, '[]', '2025-12-24 19:39:38', '2025-12-24 19:39:38'),
(279, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 205, '[]', '2025-12-24 19:39:38', '2025-12-24 19:39:38'),
(280, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 206, '[]', '2025-12-24 19:39:38', '2025-12-24 19:39:38'),
(281, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 207, '[]', '2025-12-24 19:39:38', '2025-12-24 19:39:38'),
(282, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 208, '[]', '2025-12-24 19:39:38', '2025-12-24 19:39:38'),
(283, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 209, '[]', '2025-12-24 19:39:38', '2025-12-24 19:39:38'),
(284, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 210, '[]', '2025-12-24 19:39:38', '2025-12-24 19:39:38'),
(285, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 211, '[]', '2025-12-24 19:39:38', '2025-12-24 19:39:38'),
(286, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 212, '[]', '2025-12-24 19:39:38', '2025-12-24 19:39:38'),
(287, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 213, '[]', '2025-12-24 19:39:38', '2025-12-24 19:39:38'),
(288, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 214, '[]', '2025-12-24 19:39:38', '2025-12-24 19:39:38'),
(289, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 215, '[]', '2025-12-24 19:39:38', '2025-12-24 19:39:38'),
(290, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 216, '[]', '2025-12-24 19:39:38', '2025-12-24 19:39:38'),
(291, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 217, '[]', '2025-12-24 19:39:38', '2025-12-24 19:39:38'),
(292, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 218, '[]', '2025-12-24 19:39:38', '2025-12-24 19:39:38'),
(293, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 219, '[]', '2025-12-24 19:39:38', '2025-12-24 19:39:38'),
(294, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 220, '[]', '2025-12-24 19:39:38', '2025-12-24 19:39:38'),
(295, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 221, '[]', '2025-12-24 19:39:38', '2025-12-24 19:39:38'),
(296, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 222, '[]', '2025-12-24 19:39:38', '2025-12-24 19:39:38'),
(297, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 223, '[]', '2025-12-24 19:39:38', '2025-12-24 19:39:38'),
(298, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 224, '[]', '2025-12-24 19:39:38', '2025-12-24 19:39:38'),
(299, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 19, '{\"next_billing_date\":{\"from\":null,\"to\":\"2025-12-29 00:00:00\"}}', '2025-12-24 19:39:38', '2025-12-24 19:39:38'),
(300, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 19, '{\"status\":{\"from\":\"active\",\"to\":\"inactive\"}}', '2025-12-24 19:40:12', '2025-12-24 19:40:12'),
(301, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 20, '[]', '2025-12-24 19:43:20', '2025-12-24 19:43:20');
INSERT INTO `activity_logs` (`id`, `user_id`, `branch_id`, `action`, `description`, `subject_type`, `subject_id`, `properties`, `created_at`, `updated_at`) VALUES
(302, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 225, '[]', '2025-12-24 19:43:20', '2025-12-24 19:43:20'),
(303, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 20, '{\"next_billing_date\":{\"from\":null,\"to\":\"2025-12-31 00:00:00\"}}', '2025-12-24 19:43:20', '2025-12-24 19:43:20'),
(304, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 20, '{\"status\":{\"from\":\"active\",\"to\":\"inactive\"}}', '2025-12-24 19:43:44', '2025-12-24 19:43:44'),
(305, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 21, '[]', '2025-12-24 19:47:30', '2025-12-24 19:47:30'),
(306, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 226, '[]', '2025-12-24 19:47:30', '2025-12-24 19:47:30'),
(307, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 227, '[]', '2025-12-24 19:47:30', '2025-12-24 19:47:30'),
(308, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 228, '[]', '2025-12-24 19:47:30', '2025-12-24 19:47:30'),
(309, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 229, '[]', '2025-12-24 19:47:30', '2025-12-24 19:47:30'),
(310, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 230, '[]', '2025-12-24 19:47:30', '2025-12-24 19:47:30'),
(311, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 231, '[]', '2025-12-24 19:47:30', '2025-12-24 19:47:30'),
(312, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 232, '[]', '2025-12-24 19:47:30', '2025-12-24 19:47:30'),
(313, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 233, '[]', '2025-12-24 19:47:30', '2025-12-24 19:47:30'),
(314, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 234, '[]', '2025-12-24 19:47:30', '2025-12-24 19:47:30'),
(315, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 235, '[]', '2025-12-24 19:47:30', '2025-12-24 19:47:30'),
(316, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 236, '[]', '2025-12-24 19:47:30', '2025-12-24 19:47:30'),
(317, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 237, '[]', '2025-12-24 19:47:30', '2025-12-24 19:47:30'),
(318, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 238, '[]', '2025-12-24 19:47:30', '2025-12-24 19:47:30'),
(319, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 239, '[]', '2025-12-24 19:47:30', '2025-12-24 19:47:30'),
(320, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 240, '[]', '2025-12-24 19:47:30', '2025-12-24 19:47:30'),
(321, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 241, '[]', '2025-12-24 19:47:30', '2025-12-24 19:47:30'),
(322, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 242, '[]', '2025-12-24 19:47:30', '2025-12-24 19:47:30'),
(323, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 243, '[]', '2025-12-24 19:47:30', '2025-12-24 19:47:30'),
(324, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 244, '[]', '2025-12-24 19:47:30', '2025-12-24 19:47:30'),
(325, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 245, '[]', '2025-12-24 19:47:30', '2025-12-24 19:47:30'),
(326, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 246, '[]', '2025-12-24 19:47:30', '2025-12-24 19:47:30'),
(327, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 247, '[]', '2025-12-24 19:47:30', '2025-12-24 19:47:30'),
(328, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 248, '[]', '2025-12-24 19:47:30', '2025-12-24 19:47:30'),
(329, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 249, '[]', '2025-12-24 19:47:30', '2025-12-24 19:47:30'),
(330, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 21, '{\"next_billing_date\":{\"from\":null,\"to\":\"2025-12-29 00:00:00\"}}', '2025-12-24 19:47:30', '2025-12-24 19:47:30'),
(331, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 21, '{\"status\":{\"from\":\"active\",\"to\":\"inactive\"}}', '2025-12-24 19:47:45', '2025-12-24 19:47:45'),
(332, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 22, '[]', '2025-12-24 19:50:53', '2025-12-24 19:50:53'),
(333, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 250, '[]', '2025-12-24 19:50:53', '2025-12-24 19:50:53'),
(334, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 251, '[]', '2025-12-24 19:50:53', '2025-12-24 19:50:53'),
(335, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 252, '[]', '2025-12-24 19:50:53', '2025-12-24 19:50:53'),
(336, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 253, '[]', '2025-12-24 19:50:53', '2025-12-24 19:50:53'),
(337, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 254, '[]', '2025-12-24 19:50:53', '2025-12-24 19:50:53'),
(338, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 255, '[]', '2025-12-24 19:50:53', '2025-12-24 19:50:53'),
(339, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 22, '{\"next_billing_date\":{\"from\":null,\"to\":\"2026-01-14 00:00:00\"}}', '2025-12-24 19:50:53', '2025-12-24 19:50:53'),
(340, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 22, '{\"status\":{\"from\":\"active\",\"to\":\"inactive\"}}', '2025-12-24 19:51:40', '2025-12-24 19:51:40'),
(341, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 23, '[]', '2025-12-24 19:55:51', '2025-12-24 19:55:51'),
(342, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 256, '[]', '2025-12-24 19:55:51', '2025-12-24 19:55:51'),
(343, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 257, '[]', '2025-12-24 19:55:51', '2025-12-24 19:55:51'),
(344, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 258, '[]', '2025-12-24 19:55:51', '2025-12-24 19:55:51'),
(345, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 259, '[]', '2025-12-24 19:55:51', '2025-12-24 19:55:51'),
(346, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 260, '[]', '2025-12-24 19:55:51', '2025-12-24 19:55:51'),
(347, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 261, '[]', '2025-12-24 19:55:51', '2025-12-24 19:55:51'),
(348, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 23, '{\"next_billing_date\":{\"from\":null,\"to\":\"2026-01-14 00:00:00\"}}', '2025-12-24 19:55:51', '2025-12-24 19:55:51'),
(349, 1, NULL, 'DELETE', 'Menghapus data di tabel Student', 'App\\Models\\Student', 23, '[]', '2025-12-24 19:56:52', '2025-12-24 19:56:52'),
(350, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 24, '[]', '2025-12-24 19:58:02', '2025-12-24 19:58:02'),
(351, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 262, '[]', '2025-12-24 19:58:02', '2025-12-24 19:58:02'),
(352, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 263, '[]', '2025-12-24 19:58:02', '2025-12-24 19:58:02'),
(353, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 264, '[]', '2025-12-24 19:58:02', '2025-12-24 19:58:02'),
(354, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 265, '[]', '2025-12-24 19:58:02', '2025-12-24 19:58:02'),
(355, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 266, '[]', '2025-12-24 19:58:02', '2025-12-24 19:58:02'),
(356, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 267, '[]', '2025-12-24 19:58:02', '2025-12-24 19:58:02'),
(357, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 268, '[]', '2025-12-24 19:58:02', '2025-12-24 19:58:02'),
(358, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 269, '[]', '2025-12-24 19:58:02', '2025-12-24 19:58:02'),
(359, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 270, '[]', '2025-12-24 19:58:02', '2025-12-24 19:58:02'),
(360, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 271, '[]', '2025-12-24 19:58:02', '2025-12-24 19:58:02'),
(361, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 272, '[]', '2025-12-24 19:58:02', '2025-12-24 19:58:02'),
(362, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 273, '[]', '2025-12-24 19:58:02', '2025-12-24 19:58:02'),
(363, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 274, '[]', '2025-12-24 19:58:02', '2025-12-24 19:58:02'),
(364, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 275, '[]', '2025-12-24 19:58:02', '2025-12-24 19:58:02'),
(365, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 276, '[]', '2025-12-24 19:58:02', '2025-12-24 19:58:02'),
(366, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 277, '[]', '2025-12-24 19:58:02', '2025-12-24 19:58:02'),
(367, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 278, '[]', '2025-12-24 19:58:02', '2025-12-24 19:58:02'),
(368, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 279, '[]', '2025-12-24 19:58:02', '2025-12-24 19:58:02'),
(369, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 280, '[]', '2025-12-24 19:58:02', '2025-12-24 19:58:02'),
(370, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 281, '[]', '2025-12-24 19:58:02', '2025-12-24 19:58:02'),
(371, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 282, '[]', '2025-12-24 19:58:02', '2025-12-24 19:58:02'),
(372, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 283, '[]', '2025-12-24 19:58:02', '2025-12-24 19:58:02'),
(373, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 284, '[]', '2025-12-24 19:58:02', '2025-12-24 19:58:02'),
(374, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 285, '[]', '2025-12-24 19:58:02', '2025-12-24 19:58:02'),
(375, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 24, '{\"next_billing_date\":{\"from\":null,\"to\":\"2025-12-29 00:00:00\"}}', '2025-12-24 19:58:02', '2025-12-24 19:58:02'),
(376, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 24, '{\"status\":{\"from\":\"active\",\"to\":\"inactive\"}}', '2025-12-24 19:58:19', '2025-12-24 19:58:19'),
(377, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 25, '[]', '2025-12-24 20:01:20', '2025-12-24 20:01:20'),
(378, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 286, '[]', '2025-12-24 20:01:20', '2025-12-24 20:01:20'),
(379, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 287, '[]', '2025-12-24 20:01:20', '2025-12-24 20:01:20'),
(380, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 288, '[]', '2025-12-24 20:01:20', '2025-12-24 20:01:20'),
(381, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 289, '[]', '2025-12-24 20:01:20', '2025-12-24 20:01:20'),
(382, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 290, '[]', '2025-12-24 20:01:20', '2025-12-24 20:01:20'),
(383, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 291, '[]', '2025-12-24 20:01:20', '2025-12-24 20:01:20'),
(384, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 292, '[]', '2025-12-24 20:01:20', '2025-12-24 20:01:20'),
(385, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 293, '[]', '2025-12-24 20:01:20', '2025-12-24 20:01:20'),
(386, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 294, '[]', '2025-12-24 20:01:20', '2025-12-24 20:01:20'),
(387, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 295, '[]', '2025-12-24 20:01:20', '2025-12-24 20:01:20'),
(388, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 296, '[]', '2025-12-24 20:01:20', '2025-12-24 20:01:20'),
(389, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 297, '[]', '2025-12-24 20:01:20', '2025-12-24 20:01:20'),
(390, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 298, '[]', '2025-12-24 20:01:20', '2025-12-24 20:01:20'),
(391, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 299, '[]', '2025-12-24 20:01:20', '2025-12-24 20:01:20'),
(392, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 300, '[]', '2025-12-24 20:01:20', '2025-12-24 20:01:20'),
(393, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 301, '[]', '2025-12-24 20:01:20', '2025-12-24 20:01:20'),
(394, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 302, '[]', '2025-12-24 20:01:20', '2025-12-24 20:01:20'),
(395, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 303, '[]', '2025-12-24 20:01:20', '2025-12-24 20:01:20'),
(396, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 304, '[]', '2025-12-24 20:01:20', '2025-12-24 20:01:20'),
(397, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 305, '[]', '2025-12-24 20:01:20', '2025-12-24 20:01:20'),
(398, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 306, '[]', '2025-12-24 20:01:20', '2025-12-24 20:01:20'),
(399, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 307, '[]', '2025-12-24 20:01:20', '2025-12-24 20:01:20'),
(400, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 308, '[]', '2025-12-24 20:01:20', '2025-12-24 20:01:20'),
(401, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 309, '[]', '2025-12-24 20:01:20', '2025-12-24 20:01:20'),
(402, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 25, '{\"next_billing_date\":{\"from\":null,\"to\":\"2025-12-29 00:00:00\"}}', '2025-12-24 20:01:20', '2025-12-24 20:01:20'),
(403, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 25, '{\"status\":{\"from\":\"active\",\"to\":\"inactive\"}}', '2025-12-24 20:01:40', '2025-12-24 20:01:40'),
(404, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 26, '[]', '2025-12-24 20:05:13', '2025-12-24 20:05:13'),
(405, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 310, '[]', '2025-12-24 20:05:13', '2025-12-24 20:05:13'),
(406, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 311, '[]', '2025-12-24 20:05:13', '2025-12-24 20:05:13'),
(407, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 312, '[]', '2025-12-24 20:05:13', '2025-12-24 20:05:13'),
(408, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 313, '[]', '2025-12-24 20:05:13', '2025-12-24 20:05:13'),
(409, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 314, '[]', '2025-12-24 20:05:13', '2025-12-24 20:05:13'),
(410, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 315, '[]', '2025-12-24 20:05:13', '2025-12-24 20:05:13'),
(411, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 26, '{\"next_billing_date\":{\"from\":null,\"to\":\"2026-01-14 00:00:00\"}}', '2025-12-24 20:05:13', '2025-12-24 20:05:13'),
(412, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 26, '{\"status\":{\"from\":\"active\",\"to\":\"inactive\"}}', '2025-12-24 20:05:30', '2025-12-24 20:05:30'),
(413, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 27, '[]', '2025-12-24 20:08:37', '2025-12-24 20:08:37'),
(414, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 316, '[]', '2025-12-24 20:08:37', '2025-12-24 20:08:37'),
(415, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 317, '[]', '2025-12-24 20:08:37', '2025-12-24 20:08:37'),
(416, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 318, '[]', '2025-12-24 20:08:37', '2025-12-24 20:08:37'),
(417, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 319, '[]', '2025-12-24 20:08:37', '2025-12-24 20:08:37'),
(418, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 320, '[]', '2025-12-24 20:08:37', '2025-12-24 20:08:37'),
(419, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 321, '[]', '2025-12-24 20:08:37', '2025-12-24 20:08:37'),
(420, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 322, '[]', '2025-12-24 20:08:37', '2025-12-24 20:08:37'),
(421, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 323, '[]', '2025-12-24 20:08:37', '2025-12-24 20:08:37'),
(422, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 324, '[]', '2025-12-24 20:08:37', '2025-12-24 20:08:37'),
(423, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 325, '[]', '2025-12-24 20:08:37', '2025-12-24 20:08:37'),
(424, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 326, '[]', '2025-12-24 20:08:37', '2025-12-24 20:08:37'),
(425, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 327, '[]', '2025-12-24 20:08:37', '2025-12-24 20:08:37'),
(426, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 328, '[]', '2025-12-24 20:08:37', '2025-12-24 20:08:37'),
(427, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 329, '[]', '2025-12-24 20:08:37', '2025-12-24 20:08:37'),
(428, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 330, '[]', '2025-12-24 20:08:37', '2025-12-24 20:08:37'),
(429, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 331, '[]', '2025-12-24 20:08:37', '2025-12-24 20:08:37'),
(430, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 332, '[]', '2025-12-24 20:08:37', '2025-12-24 20:08:37'),
(431, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 333, '[]', '2025-12-24 20:08:37', '2025-12-24 20:08:37'),
(432, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 334, '[]', '2025-12-24 20:08:37', '2025-12-24 20:08:37'),
(433, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 335, '[]', '2025-12-24 20:08:37', '2025-12-24 20:08:37'),
(434, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 336, '[]', '2025-12-24 20:08:37', '2025-12-24 20:08:37'),
(435, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 337, '[]', '2025-12-24 20:08:37', '2025-12-24 20:08:37'),
(436, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 338, '[]', '2025-12-24 20:08:37', '2025-12-24 20:08:37'),
(437, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 339, '[]', '2025-12-24 20:08:37', '2025-12-24 20:08:37'),
(438, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 27, '{\"next_billing_date\":{\"from\":null,\"to\":\"2025-12-29 00:00:00\"}}', '2025-12-24 20:08:37', '2025-12-24 20:08:37'),
(439, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 27, '{\"status\":{\"from\":\"active\",\"to\":\"inactive\"}}', '2025-12-24 20:08:53', '2025-12-24 20:08:53'),
(440, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 28, '[]', '2025-12-24 20:12:52', '2025-12-24 20:12:52'),
(441, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 340, '[]', '2025-12-24 20:12:52', '2025-12-24 20:12:52'),
(442, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 341, '[]', '2025-12-24 20:12:52', '2025-12-24 20:12:52'),
(443, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 342, '[]', '2025-12-24 20:12:52', '2025-12-24 20:12:52'),
(444, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 343, '[]', '2025-12-24 20:12:52', '2025-12-24 20:12:52'),
(445, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 344, '[]', '2025-12-24 20:12:52', '2025-12-24 20:12:52'),
(446, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 345, '[]', '2025-12-24 20:12:52', '2025-12-24 20:12:52'),
(447, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 346, '[]', '2025-12-24 20:12:52', '2025-12-24 20:12:52'),
(448, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 347, '[]', '2025-12-24 20:12:52', '2025-12-24 20:12:52'),
(449, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 348, '[]', '2025-12-24 20:12:52', '2025-12-24 20:12:52'),
(450, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 349, '[]', '2025-12-24 20:12:52', '2025-12-24 20:12:52'),
(451, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 350, '[]', '2025-12-24 20:12:52', '2025-12-24 20:12:52'),
(452, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 351, '[]', '2025-12-24 20:12:52', '2025-12-24 20:12:52'),
(453, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 352, '[]', '2025-12-24 20:12:52', '2025-12-24 20:12:52'),
(454, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 353, '[]', '2025-12-24 20:12:52', '2025-12-24 20:12:52'),
(455, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 354, '[]', '2025-12-24 20:12:52', '2025-12-24 20:12:52'),
(456, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 355, '[]', '2025-12-24 20:12:52', '2025-12-24 20:12:52'),
(457, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 356, '[]', '2025-12-24 20:12:52', '2025-12-24 20:12:52'),
(458, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 357, '[]', '2025-12-24 20:12:52', '2025-12-24 20:12:52'),
(459, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 358, '[]', '2025-12-24 20:12:52', '2025-12-24 20:12:52'),
(460, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 359, '[]', '2025-12-24 20:12:52', '2025-12-24 20:12:52'),
(461, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 360, '[]', '2025-12-24 20:12:52', '2025-12-24 20:12:52'),
(462, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 361, '[]', '2025-12-24 20:12:52', '2025-12-24 20:12:52'),
(463, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 362, '[]', '2025-12-24 20:12:52', '2025-12-24 20:12:52'),
(464, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 363, '[]', '2025-12-24 20:12:52', '2025-12-24 20:12:52'),
(465, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 28, '{\"next_billing_date\":{\"from\":null,\"to\":\"2025-12-29 00:00:00\"}}', '2025-12-24 20:12:52', '2025-12-24 20:12:52'),
(466, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 29, '[]', '2025-12-24 20:15:56', '2025-12-24 20:15:56'),
(467, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 364, '[]', '2025-12-24 20:15:56', '2025-12-24 20:15:56'),
(468, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 365, '[]', '2025-12-24 20:15:56', '2025-12-24 20:15:56'),
(469, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 366, '[]', '2025-12-24 20:15:56', '2025-12-24 20:15:56'),
(470, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 367, '[]', '2025-12-24 20:15:56', '2025-12-24 20:15:56'),
(471, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 368, '[]', '2025-12-24 20:15:56', '2025-12-24 20:15:56'),
(472, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 369, '[]', '2025-12-24 20:15:56', '2025-12-24 20:15:56'),
(473, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 29, '{\"next_billing_date\":{\"from\":null,\"to\":\"2026-01-14 00:00:00\"}}', '2025-12-24 20:15:56', '2025-12-24 20:15:56'),
(474, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 29, '{\"status\":{\"from\":\"active\",\"to\":\"inactive\"}}', '2025-12-24 20:16:13', '2025-12-24 20:16:13'),
(475, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 28, '{\"status\":{\"from\":\"active\",\"to\":\"inactive\"}}', '2025-12-24 20:16:33', '2025-12-24 20:16:33'),
(476, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 30, '[]', '2025-12-24 20:20:01', '2025-12-24 20:20:01'),
(477, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 370, '[]', '2025-12-24 20:20:01', '2025-12-24 20:20:01'),
(478, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 371, '[]', '2025-12-24 20:20:01', '2025-12-24 20:20:01'),
(479, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 372, '[]', '2025-12-24 20:20:01', '2025-12-24 20:20:01'),
(480, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 373, '[]', '2025-12-24 20:20:01', '2025-12-24 20:20:01'),
(481, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 374, '[]', '2025-12-24 20:20:01', '2025-12-24 20:20:01'),
(482, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 375, '[]', '2025-12-24 20:20:01', '2025-12-24 20:20:01'),
(483, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 376, '[]', '2025-12-24 20:20:01', '2025-12-24 20:20:01'),
(484, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 377, '[]', '2025-12-24 20:20:01', '2025-12-24 20:20:01'),
(485, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 378, '[]', '2025-12-24 20:20:01', '2025-12-24 20:20:01'),
(486, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 379, '[]', '2025-12-24 20:20:01', '2025-12-24 20:20:01'),
(487, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 380, '[]', '2025-12-24 20:20:01', '2025-12-24 20:20:01'),
(488, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 381, '[]', '2025-12-24 20:20:01', '2025-12-24 20:20:01'),
(489, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 382, '[]', '2025-12-24 20:20:01', '2025-12-24 20:20:01'),
(490, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 383, '[]', '2025-12-24 20:20:01', '2025-12-24 20:20:01'),
(491, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 384, '[]', '2025-12-24 20:20:01', '2025-12-24 20:20:01'),
(492, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 385, '[]', '2025-12-24 20:20:01', '2025-12-24 20:20:01'),
(493, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 386, '[]', '2025-12-24 20:20:01', '2025-12-24 20:20:01'),
(494, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 387, '[]', '2025-12-24 20:20:01', '2025-12-24 20:20:01'),
(495, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 388, '[]', '2025-12-24 20:20:01', '2025-12-24 20:20:01'),
(496, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 389, '[]', '2025-12-24 20:20:01', '2025-12-24 20:20:01'),
(497, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 390, '[]', '2025-12-24 20:20:01', '2025-12-24 20:20:01'),
(498, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 391, '[]', '2025-12-24 20:20:01', '2025-12-24 20:20:01'),
(499, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 392, '[]', '2025-12-24 20:20:01', '2025-12-24 20:20:01'),
(500, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 393, '[]', '2025-12-24 20:20:01', '2025-12-24 20:20:01'),
(501, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 30, '{\"next_billing_date\":{\"from\":null,\"to\":\"2025-12-29 00:00:00\"}}', '2025-12-24 20:20:01', '2025-12-24 20:20:01'),
(502, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 30, '{\"status\":{\"from\":\"active\",\"to\":\"inactive\"}}', '2025-12-24 20:20:18', '2025-12-24 20:20:18'),
(503, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 31, '[]', '2025-12-24 20:23:45', '2025-12-24 20:23:45'),
(504, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 394, '[]', '2025-12-24 20:23:45', '2025-12-24 20:23:45'),
(505, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 395, '[]', '2025-12-24 20:23:45', '2025-12-24 20:23:45'),
(506, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 396, '[]', '2025-12-24 20:23:45', '2025-12-24 20:23:45'),
(507, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 397, '[]', '2025-12-24 20:23:45', '2025-12-24 20:23:45'),
(508, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 398, '[]', '2025-12-24 20:23:45', '2025-12-24 20:23:45'),
(509, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 399, '[]', '2025-12-24 20:23:45', '2025-12-24 20:23:45'),
(510, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 31, '{\"next_billing_date\":{\"from\":null,\"to\":\"2026-01-14 00:00:00\"}}', '2025-12-24 20:23:45', '2025-12-24 20:23:45'),
(511, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 31, '{\"status\":{\"from\":\"active\",\"to\":\"inactive\"}}', '2025-12-24 20:24:42', '2025-12-24 20:24:42'),
(512, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 32, '[]', '2025-12-24 20:26:36', '2025-12-24 20:26:36'),
(513, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 400, '[]', '2025-12-24 20:26:36', '2025-12-24 20:26:36'),
(514, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 401, '[]', '2025-12-24 20:26:36', '2025-12-24 20:26:36'),
(515, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 402, '[]', '2025-12-24 20:26:36', '2025-12-24 20:26:36'),
(516, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 403, '[]', '2025-12-24 20:26:36', '2025-12-24 20:26:36'),
(517, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 404, '[]', '2025-12-24 20:26:36', '2025-12-24 20:26:36'),
(518, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 405, '[]', '2025-12-24 20:26:36', '2025-12-24 20:26:36'),
(519, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 32, '{\"next_billing_date\":{\"from\":null,\"to\":\"2026-01-14 00:00:00\"}}', '2025-12-24 20:26:36', '2025-12-24 20:26:36'),
(520, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 32, '{\"status\":{\"from\":\"active\",\"to\":\"inactive\"}}', '2025-12-24 20:26:52', '2025-12-24 20:26:52'),
(521, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 33, '[]', '2025-12-24 20:29:09', '2025-12-24 20:29:09'),
(522, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 33, '{\"next_billing_date\":{\"from\":null,\"to\":\"2025-08-14 00:00:00\"}}', '2025-12-24 20:29:09', '2025-12-24 20:29:09'),
(523, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 406, '[]', '2025-12-24 20:29:09', '2025-12-24 20:29:09'),
(524, 1, NULL, 'UPDATE', 'Mengubah data di tabel Transaction', 'App\\Models\\Transaction', 406, '{\"payment_url\":{\"from\":\"#\",\"to\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/694beaae8e155878cdc64ede\"}}', '2025-12-24 20:29:10', '2025-12-24 20:29:10'),
(525, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 33, '{\"status\":{\"from\":\"pending\",\"to\":\"inactive\"}}', '2025-12-24 20:30:06', '2025-12-24 20:30:06'),
(526, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 34, '[]', '2025-12-24 20:32:52', '2025-12-24 20:32:52'),
(527, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 407, '[]', '2025-12-24 20:32:52', '2025-12-24 20:32:52'),
(528, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 408, '[]', '2025-12-24 20:32:52', '2025-12-24 20:32:52'),
(529, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 409, '[]', '2025-12-24 20:32:52', '2025-12-24 20:32:52'),
(530, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 410, '[]', '2025-12-24 20:32:52', '2025-12-24 20:32:52'),
(531, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 411, '[]', '2025-12-24 20:32:52', '2025-12-24 20:32:52'),
(532, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 412, '[]', '2025-12-24 20:32:52', '2025-12-24 20:32:52'),
(533, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 413, '[]', '2025-12-24 20:32:52', '2025-12-24 20:32:52'),
(534, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 414, '[]', '2025-12-24 20:32:52', '2025-12-24 20:32:52'),
(535, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 415, '[]', '2025-12-24 20:32:52', '2025-12-24 20:32:52'),
(536, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 416, '[]', '2025-12-24 20:32:52', '2025-12-24 20:32:52'),
(537, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 417, '[]', '2025-12-24 20:32:52', '2025-12-24 20:32:52'),
(538, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 418, '[]', '2025-12-24 20:32:52', '2025-12-24 20:32:52'),
(539, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 419, '[]', '2025-12-24 20:32:52', '2025-12-24 20:32:52'),
(540, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 420, '[]', '2025-12-24 20:32:52', '2025-12-24 20:32:52'),
(541, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 421, '[]', '2025-12-24 20:32:52', '2025-12-24 20:32:52'),
(542, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 422, '[]', '2025-12-24 20:32:52', '2025-12-24 20:32:52'),
(543, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 423, '[]', '2025-12-24 20:32:52', '2025-12-24 20:32:52'),
(544, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 424, '[]', '2025-12-24 20:32:52', '2025-12-24 20:32:52'),
(545, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 425, '[]', '2025-12-24 20:32:52', '2025-12-24 20:32:52'),
(546, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 426, '[]', '2025-12-24 20:32:52', '2025-12-24 20:32:52'),
(547, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 427, '[]', '2025-12-24 20:32:52', '2025-12-24 20:32:52'),
(548, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 428, '[]', '2025-12-24 20:32:52', '2025-12-24 20:32:52'),
(549, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 429, '[]', '2025-12-24 20:32:52', '2025-12-24 20:32:52'),
(550, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 430, '[]', '2025-12-24 20:32:52', '2025-12-24 20:32:52'),
(551, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 34, '{\"next_billing_date\":{\"from\":null,\"to\":\"2025-12-29 00:00:00\"}}', '2025-12-24 20:32:52', '2025-12-24 20:32:52'),
(552, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 34, '{\"status\":{\"from\":\"active\",\"to\":\"inactive\"}}', '2025-12-24 20:33:12', '2025-12-24 20:33:12'),
(553, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 35, '[]', '2025-12-24 20:35:30', '2025-12-24 20:35:30'),
(554, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 431, '[]', '2025-12-24 20:35:30', '2025-12-24 20:35:30'),
(555, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 432, '[]', '2025-12-24 20:35:30', '2025-12-24 20:35:30'),
(556, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 433, '[]', '2025-12-24 20:35:30', '2025-12-24 20:35:30'),
(557, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 434, '[]', '2025-12-24 20:35:30', '2025-12-24 20:35:30'),
(558, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 435, '[]', '2025-12-24 20:35:30', '2025-12-24 20:35:30'),
(559, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 436, '[]', '2025-12-24 20:35:30', '2025-12-24 20:35:30'),
(560, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 437, '[]', '2025-12-24 20:35:30', '2025-12-24 20:35:30'),
(561, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 438, '[]', '2025-12-24 20:35:30', '2025-12-24 20:35:30'),
(562, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 439, '[]', '2025-12-24 20:35:30', '2025-12-24 20:35:30'),
(563, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 440, '[]', '2025-12-24 20:35:30', '2025-12-24 20:35:30'),
(564, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 441, '[]', '2025-12-24 20:35:30', '2025-12-24 20:35:30'),
(565, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 442, '[]', '2025-12-24 20:35:30', '2025-12-24 20:35:30'),
(566, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 443, '[]', '2025-12-24 20:35:30', '2025-12-24 20:35:30'),
(567, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 444, '[]', '2025-12-24 20:35:30', '2025-12-24 20:35:30'),
(568, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 445, '[]', '2025-12-24 20:35:30', '2025-12-24 20:35:30'),
(569, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 446, '[]', '2025-12-24 20:35:30', '2025-12-24 20:35:30'),
(570, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 447, '[]', '2025-12-24 20:35:30', '2025-12-24 20:35:30'),
(571, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 448, '[]', '2025-12-24 20:35:30', '2025-12-24 20:35:30'),
(572, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 449, '[]', '2025-12-24 20:35:30', '2025-12-24 20:35:30'),
(573, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 450, '[]', '2025-12-24 20:35:30', '2025-12-24 20:35:30'),
(574, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 451, '[]', '2025-12-24 20:35:30', '2025-12-24 20:35:30'),
(575, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 452, '[]', '2025-12-24 20:35:30', '2025-12-24 20:35:30'),
(576, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 453, '[]', '2025-12-24 20:35:30', '2025-12-24 20:35:30'),
(577, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 454, '[]', '2025-12-24 20:35:30', '2025-12-24 20:35:30'),
(578, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 35, '{\"next_billing_date\":{\"from\":null,\"to\":\"2025-12-29 00:00:00\"}}', '2025-12-24 20:35:30', '2025-12-24 20:35:30'),
(579, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 35, '{\"status\":{\"from\":\"active\",\"to\":\"inactive\"}}', '2025-12-24 20:35:50', '2025-12-24 20:35:50'),
(580, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 36, '[]', '2025-12-24 20:38:21', '2025-12-24 20:38:21'),
(581, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 455, '[]', '2025-12-24 20:38:21', '2025-12-24 20:38:21'),
(582, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 456, '[]', '2025-12-24 20:38:21', '2025-12-24 20:38:21'),
(583, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 457, '[]', '2025-12-24 20:38:21', '2025-12-24 20:38:21'),
(584, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 458, '[]', '2025-12-24 20:38:21', '2025-12-24 20:38:21'),
(585, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 459, '[]', '2025-12-24 20:38:21', '2025-12-24 20:38:21'),
(586, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 460, '[]', '2025-12-24 20:38:21', '2025-12-24 20:38:21'),
(587, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 461, '[]', '2025-12-24 20:38:21', '2025-12-24 20:38:21'),
(588, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 462, '[]', '2025-12-24 20:38:21', '2025-12-24 20:38:21'),
(589, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 463, '[]', '2025-12-24 20:38:21', '2025-12-24 20:38:21'),
(590, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 464, '[]', '2025-12-24 20:38:21', '2025-12-24 20:38:21'),
(591, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 465, '[]', '2025-12-24 20:38:21', '2025-12-24 20:38:21'),
(592, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 466, '[]', '2025-12-24 20:38:21', '2025-12-24 20:38:21'),
(593, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 467, '[]', '2025-12-24 20:38:21', '2025-12-24 20:38:21'),
(594, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 468, '[]', '2025-12-24 20:38:21', '2025-12-24 20:38:21'),
(595, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 469, '[]', '2025-12-24 20:38:21', '2025-12-24 20:38:21'),
(596, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 470, '[]', '2025-12-24 20:38:21', '2025-12-24 20:38:21'),
(597, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 471, '[]', '2025-12-24 20:38:21', '2025-12-24 20:38:21'),
(598, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 472, '[]', '2025-12-24 20:38:21', '2025-12-24 20:38:21'),
(599, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 473, '[]', '2025-12-24 20:38:21', '2025-12-24 20:38:21'),
(600, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 474, '[]', '2025-12-24 20:38:21', '2025-12-24 20:38:21'),
(601, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 475, '[]', '2025-12-24 20:38:21', '2025-12-24 20:38:21'),
(602, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 476, '[]', '2025-12-24 20:38:21', '2025-12-24 20:38:21'),
(603, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 477, '[]', '2025-12-24 20:38:21', '2025-12-24 20:38:21'),
(604, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 478, '[]', '2025-12-24 20:38:21', '2025-12-24 20:38:21'),
(605, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 36, '{\"next_billing_date\":{\"from\":null,\"to\":\"2025-12-29 00:00:00\"}}', '2025-12-24 20:38:21', '2025-12-24 20:38:21'),
(606, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 36, '{\"status\":{\"from\":\"active\",\"to\":\"inactive\"}}', '2025-12-24 20:38:37', '2025-12-24 20:38:37'),
(607, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 37, '[]', '2025-12-24 20:41:06', '2025-12-24 20:41:06'),
(608, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 479, '[]', '2025-12-24 20:41:06', '2025-12-24 20:41:06'),
(609, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 480, '[]', '2025-12-24 20:41:06', '2025-12-24 20:41:06'),
(610, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 481, '[]', '2025-12-24 20:41:06', '2025-12-24 20:41:06'),
(611, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 482, '[]', '2025-12-24 20:41:06', '2025-12-24 20:41:06'),
(612, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 483, '[]', '2025-12-24 20:41:06', '2025-12-24 20:41:06'),
(613, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 484, '[]', '2025-12-24 20:41:06', '2025-12-24 20:41:06');
INSERT INTO `activity_logs` (`id`, `user_id`, `branch_id`, `action`, `description`, `subject_type`, `subject_id`, `properties`, `created_at`, `updated_at`) VALUES
(614, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 485, '[]', '2025-12-24 20:41:06', '2025-12-24 20:41:06'),
(615, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 486, '[]', '2025-12-24 20:41:06', '2025-12-24 20:41:06'),
(616, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 487, '[]', '2025-12-24 20:41:06', '2025-12-24 20:41:06'),
(617, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 488, '[]', '2025-12-24 20:41:06', '2025-12-24 20:41:06'),
(618, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 489, '[]', '2025-12-24 20:41:06', '2025-12-24 20:41:06'),
(619, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 490, '[]', '2025-12-24 20:41:06', '2025-12-24 20:41:06'),
(620, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 491, '[]', '2025-12-24 20:41:06', '2025-12-24 20:41:06'),
(621, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 492, '[]', '2025-12-24 20:41:06', '2025-12-24 20:41:06'),
(622, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 493, '[]', '2025-12-24 20:41:06', '2025-12-24 20:41:06'),
(623, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 494, '[]', '2025-12-24 20:41:06', '2025-12-24 20:41:06'),
(624, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 495, '[]', '2025-12-24 20:41:06', '2025-12-24 20:41:06'),
(625, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 496, '[]', '2025-12-24 20:41:06', '2025-12-24 20:41:06'),
(626, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 497, '[]', '2025-12-24 20:41:06', '2025-12-24 20:41:06'),
(627, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 498, '[]', '2025-12-24 20:41:06', '2025-12-24 20:41:06'),
(628, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 499, '[]', '2025-12-24 20:41:06', '2025-12-24 20:41:06'),
(629, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 500, '[]', '2025-12-24 20:41:06', '2025-12-24 20:41:06'),
(630, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 501, '[]', '2025-12-24 20:41:06', '2025-12-24 20:41:06'),
(631, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 502, '[]', '2025-12-24 20:41:06', '2025-12-24 20:41:06'),
(632, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 37, '{\"next_billing_date\":{\"from\":null,\"to\":\"2025-12-29 00:00:00\"}}', '2025-12-24 20:41:06', '2025-12-24 20:41:06'),
(633, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 38, '[]', '2025-12-24 20:43:08', '2025-12-24 20:43:08'),
(634, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 503, '[]', '2025-12-24 20:43:08', '2025-12-24 20:43:08'),
(635, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 504, '[]', '2025-12-24 20:43:08', '2025-12-24 20:43:08'),
(636, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 505, '[]', '2025-12-24 20:43:08', '2025-12-24 20:43:08'),
(637, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 506, '[]', '2025-12-24 20:43:08', '2025-12-24 20:43:08'),
(638, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 507, '[]', '2025-12-24 20:43:08', '2025-12-24 20:43:08'),
(639, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 508, '[]', '2025-12-24 20:43:08', '2025-12-24 20:43:08'),
(640, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 509, '[]', '2025-12-24 20:43:08', '2025-12-24 20:43:08'),
(641, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 510, '[]', '2025-12-24 20:43:08', '2025-12-24 20:43:08'),
(642, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 511, '[]', '2025-12-24 20:43:08', '2025-12-24 20:43:08'),
(643, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 512, '[]', '2025-12-24 20:43:08', '2025-12-24 20:43:08'),
(644, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 513, '[]', '2025-12-24 20:43:08', '2025-12-24 20:43:08'),
(645, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 514, '[]', '2025-12-24 20:43:08', '2025-12-24 20:43:08'),
(646, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 515, '[]', '2025-12-24 20:43:08', '2025-12-24 20:43:08'),
(647, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 516, '[]', '2025-12-24 20:43:08', '2025-12-24 20:43:08'),
(648, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 517, '[]', '2025-12-24 20:43:08', '2025-12-24 20:43:08'),
(649, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 518, '[]', '2025-12-24 20:43:08', '2025-12-24 20:43:08'),
(650, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 519, '[]', '2025-12-24 20:43:08', '2025-12-24 20:43:08'),
(651, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 520, '[]', '2025-12-24 20:43:08', '2025-12-24 20:43:08'),
(652, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 521, '[]', '2025-12-24 20:43:08', '2025-12-24 20:43:08'),
(653, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 522, '[]', '2025-12-24 20:43:08', '2025-12-24 20:43:08'),
(654, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 523, '[]', '2025-12-24 20:43:08', '2025-12-24 20:43:08'),
(655, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 524, '[]', '2025-12-24 20:43:08', '2025-12-24 20:43:08'),
(656, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 525, '[]', '2025-12-24 20:43:08', '2025-12-24 20:43:08'),
(657, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 526, '[]', '2025-12-24 20:43:08', '2025-12-24 20:43:08'),
(658, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 38, '{\"next_billing_date\":{\"from\":null,\"to\":\"2025-12-29 00:00:00\"}}', '2025-12-24 20:43:08', '2025-12-24 20:43:08'),
(659, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 37, '{\"status\":{\"from\":\"active\",\"to\":\"inactive\"}}', '2025-12-24 20:43:24', '2025-12-24 20:43:24'),
(660, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 38, '{\"status\":{\"from\":\"active\",\"to\":\"inactive\"}}', '2025-12-24 20:43:37', '2025-12-24 20:43:37'),
(661, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 39, '[]', '2025-12-24 20:50:05', '2025-12-24 20:50:05'),
(662, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 39, '{\"next_billing_date\":{\"from\":null,\"to\":\"2025-12-31 00:00:00\"}}', '2025-12-24 20:50:05', '2025-12-24 20:50:05'),
(663, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 527, '[]', '2025-12-24 20:50:05', '2025-12-24 20:50:05'),
(664, 1, NULL, 'UPDATE', 'Mengubah data di tabel Transaction', 'App\\Models\\Transaction', 527, '{\"payment_url\":{\"from\":\"#\",\"to\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/694bef96f71f8b0973b3b19f\"}}', '2025-12-24 20:50:06', '2025-12-24 20:50:06'),
(665, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 39, '{\"status\":{\"from\":\"pending\",\"to\":\"active\"}}', '2025-12-24 20:52:28', '2025-12-24 20:52:28'),
(666, 1, NULL, 'DELETE', 'Menghapus data di tabel Student', 'App\\Models\\Student', 39, '[]', '2025-12-24 20:54:31', '2025-12-24 20:54:31'),
(667, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Student', 'App\\Models\\Student', 40, '[]', '2025-12-24 20:56:00', '2025-12-24 20:56:00'),
(668, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 528, '[]', '2025-12-24 20:56:00', '2025-12-24 20:56:00'),
(669, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 529, '[]', '2025-12-24 20:56:00', '2025-12-24 20:56:00'),
(670, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 530, '[]', '2025-12-24 20:56:00', '2025-12-24 20:56:00'),
(671, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 531, '[]', '2025-12-24 20:56:00', '2025-12-24 20:56:00'),
(672, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 532, '[]', '2025-12-24 20:56:00', '2025-12-24 20:56:00'),
(673, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 533, '[]', '2025-12-24 20:56:00', '2025-12-24 20:56:00'),
(674, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 534, '[]', '2025-12-24 20:56:00', '2025-12-24 20:56:00'),
(675, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 535, '[]', '2025-12-24 20:56:00', '2025-12-24 20:56:00'),
(676, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 536, '[]', '2025-12-24 20:56:00', '2025-12-24 20:56:00'),
(677, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 537, '[]', '2025-12-24 20:56:00', '2025-12-24 20:56:00'),
(678, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 538, '[]', '2025-12-24 20:56:00', '2025-12-24 20:56:00'),
(679, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 539, '[]', '2025-12-24 20:56:00', '2025-12-24 20:56:00'),
(680, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 540, '[]', '2025-12-24 20:56:00', '2025-12-24 20:56:00'),
(681, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 541, '[]', '2025-12-24 20:56:00', '2025-12-24 20:56:00'),
(682, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 542, '[]', '2025-12-24 20:56:00', '2025-12-24 20:56:00'),
(683, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 543, '[]', '2025-12-24 20:56:00', '2025-12-24 20:56:00'),
(684, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 544, '[]', '2025-12-24 20:56:00', '2025-12-24 20:56:00'),
(685, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 545, '[]', '2025-12-24 20:56:00', '2025-12-24 20:56:00'),
(686, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 546, '[]', '2025-12-24 20:56:00', '2025-12-24 20:56:00'),
(687, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 547, '[]', '2025-12-24 20:56:00', '2025-12-24 20:56:00'),
(688, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 548, '[]', '2025-12-24 20:56:00', '2025-12-24 20:56:00'),
(689, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 549, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(690, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 550, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(691, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 551, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(692, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 552, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(693, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 553, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(694, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 554, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(695, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 555, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(696, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 556, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(697, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 557, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(698, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 558, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(699, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 559, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(700, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 560, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(701, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 561, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(702, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 562, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(703, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 563, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(704, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 564, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(705, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 565, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(706, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 566, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(707, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 567, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(708, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 568, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(709, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 569, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(710, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 570, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(711, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 571, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(712, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 572, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(713, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 573, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(714, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 574, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(715, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 575, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(716, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 576, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(717, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 577, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(718, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 578, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(719, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 579, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(720, 1, NULL, 'CREATE', 'Menambahkan data baru di tabel Transaction', 'App\\Models\\Transaction', 580, '[]', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(721, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 40, '{\"next_billing_date\":{\"from\":null,\"to\":\"2025-12-25 00:00:00\"}}', '2025-12-24 20:56:01', '2025-12-24 20:56:01'),
(722, 1, NULL, 'DELETE', 'Menghapus data di tabel Student', 'App\\Models\\Student', 40, '[]', '2025-12-24 20:57:10', '2025-12-24 20:57:10'),
(723, 1, NULL, 'UPDATE', 'Mengubah data di tabel Student', 'App\\Models\\Student', 11, '{\"status\":{\"from\":\"inactive\",\"to\":\"active\"}}', '2025-12-24 21:13:22', '2025-12-24 21:13:22');

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `amount` decimal(12,0) NOT NULL,
  `due_date` date NOT NULL,
  `status` enum('UNPAID','PENDING','PAID') NOT NULL DEFAULT 'UNPAID',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bills`
--


-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `slug`, `address`, `phone`, `created_at`, `updated_at`) VALUES
(2, 'Kemiri, Sukorejo', 'kemiri-sukorejo', 'Jl Taman Safari Indonesia II Prigen, dsn Kemiri Ds Pakukerto Kec Sukorejo RT 4 RW 1 (Damri)', '085815222639', '2025-12-21 20:58:30', '2025-12-24 14:15:12'),
(3, 'Bangil', 'bangil', 'Dusun Pakebo, Ds oro-oro ombo kulon kec Rembang', '088230335620', '2025-12-21 20:58:59', '2025-12-24 14:13:21'),
(4, 'Jatiarjo (3972)', 'jatiarjo-3972', 'Tegal Kidul Jatiarjo RT 03/RW 02 Kec Prigen, Jawa Timur', '085606434802', '2025-12-21 20:59:33', '2025-12-24 14:08:32'),
(5, 'Purwosari (Privat)', 'purwosari-privat', 'Bimbel Area purwosari hanya khusus peserta bimbel privat', '082338311273', '2025-12-21 21:00:00', '2025-12-24 14:09:08');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class_schedules`
--

CREATE TABLE `class_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `package_id` bigint(20) UNSIGNED NOT NULL,
  `day_of_week` varchar(255) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `quota` int(11) NOT NULL DEFAULT 20,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `class_schedules`
--

INSERT INTO `class_schedules` (`id`, `branch_id`, `package_id`, `day_of_week`, `start_time`, `end_time`, `quota`, `created_at`, `updated_at`) VALUES
(7, 2, 4, 'tuesday', '16:30:00', '18:00:00', 20, '2025-12-24 13:10:48', '2025-12-24 13:10:48'),
(8, 2, 8, 'tuesday', '16:30:00', '18:00:00', 20, '2025-12-24 13:11:36', '2025-12-24 13:11:36'),
(11, 2, 5, 'tuesday', '18:00:00', '19:30:00', 20, '2025-12-24 13:14:41', '2025-12-24 13:14:41'),
(13, 2, 4, 'wednesday', '16:30:00', '18:00:00', 20, '2025-12-24 13:17:53', '2025-12-24 13:17:53'),
(14, 2, 8, 'wednesday', '16:30:00', '18:00:00', 20, '2025-12-24 13:18:29', '2025-12-24 13:18:29'),
(15, 2, 5, 'wednesday', '16:30:00', '18:00:00', 20, '2025-12-24 13:19:09', '2025-12-24 13:19:09'),
(18, 2, 4, 'thursday', '16:30:00', '18:00:00', 20, '2025-12-24 13:20:43', '2025-12-24 13:20:43'),
(20, 2, 8, 'thursday', '16:30:00', '18:00:00', 20, '2025-12-24 13:21:42', '2025-12-24 13:21:42'),
(21, 2, 5, 'thursday', '16:30:00', '18:00:00', 20, '2025-12-24 13:22:43', '2025-12-24 13:22:43'),
(25, 2, 8, 'friday', '16:30:00', '18:00:00', 20, '2025-12-24 13:25:17', '2025-12-24 13:25:17'),
(27, 2, 5, 'friday', '18:00:00', '19:30:00', 20, '2025-12-24 13:26:29', '2025-12-24 13:26:29'),
(29, 2, 4, 'monday', '16:30:00', '18:00:00', 20, '2025-12-24 13:27:52', '2025-12-24 13:27:52'),
(30, 2, 8, 'monday', '16:30:00', '18:00:00', 20, '2025-12-24 13:28:24', '2025-12-24 13:28:24'),
(32, 3, 7, 'monday', '16:00:00', '17:00:00', 20, '2025-12-24 13:29:48', '2025-12-24 13:29:48'),
(33, 2, 5, 'monday', '18:00:00', '19:30:00', 20, '2025-12-24 13:30:50', '2025-12-24 13:30:50'),
(34, 3, 7, 'tuesday', '16:00:00', '17:00:00', 20, '2025-12-24 13:31:43', '2025-12-24 13:31:43'),
(35, 3, 7, 'wednesday', '16:00:00', '17:00:00', 20, '2025-12-24 13:32:29', '2025-12-24 13:32:29'),
(36, 3, 7, 'friday', '16:00:00', '17:00:00', 20, '2025-12-24 13:33:39', '2025-12-24 13:33:39'),
(39, 4, 3, 'saturday', '18:00:00', '19:30:00', 20, '2025-12-24 13:36:09', '2025-12-24 13:36:09'),
(46, 2, 7, 'saturday', '09:00:00', '22:00:00', 2, '2025-12-24 13:48:39', '2025-12-24 13:48:39'),
(48, 2, 7, 'sunday', '09:00:00', '10:00:00', 3, '2025-12-24 13:51:13', '2025-12-24 13:51:13'),
(49, 2, 3, 'sunday', '09:00:00', '10:00:00', 20, '2025-12-24 13:53:48', '2025-12-24 13:53:48'),
(51, 5, 5, 'wednesday', '12:01:00', '13:00:00', 1, '2025-12-24 14:01:31', '2025-12-24 14:01:31'),
(52, 5, 5, 'thursday', '12:00:00', '13:00:00', 1, '2025-12-24 14:02:22', '2025-12-24 14:02:22');

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `is_carousel` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contents`
--

INSERT INTO `contents` (`id`, `title`, `description`, `image`, `type`, `is_carousel`, `created_at`, `updated_at`) VALUES
(2, 'Learning Journey', 'analisis lungkungan', 'contents/Ymkv0SI2YCU6jkl8VuDn8Q4hY1SsER3mIZDx3bAj.jpg', 'Kegiatan', 1, '2025-12-24 15:13:38', '2025-12-24 15:13:38'),
(3, 'Testimoni', '😍', 'contents/5OKGdyK1rz2MtDd3srPwOmaob5eXEVi7ajbISyfx.jpg', 'Testimoni', 1, '2025-12-24 15:26:06', '2025-12-24 15:26:06'),
(4, 'Testimoni', '😍', 'contents/DL32iCqWX4xw1bTLNNrshA3Vt8yTyDwTkR0CN4vh.jpg', 'Testimoni', 1, '2025-12-24 15:26:36', '2025-12-24 15:26:36'),
(5, 'Testimoni', 'Testimoni Jarimatika & Cermat', 'contents/YxOo3kWVX2F0Mv96G1hgfhCOvHSQACgrBXtJ9oVx.jpg', 'Testimoni', 1, '2025-12-24 15:27:20', '2025-12-24 15:27:20'),
(6, 'Testimoni', 'Testimoni kelas umum', 'contents/rv3F2aTCFveZiUjy2XOBG2tkae954vfeO9YtFPV0.jpg', 'Testimoni', 1, '2025-12-24 15:27:55', '2025-12-24 15:27:55'),
(7, 'Testimoni', 'Testimoni english class junior', 'contents/iJav8MnYnZfbhqTLxDkKLYZICY9zLzp5qkuJx3B8.jpg', 'Testimoni', 1, '2025-12-24 15:28:36', '2025-12-24 15:28:36');

-- --------------------------------------------------------

--
-- Table structure for table `financial_reports`
--

CREATE TABLE `financial_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `package_id` bigint(20) UNSIGNED DEFAULT NULL,
  `month` date NOT NULL,
  `total_income` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_expense` decimal(15,2) NOT NULL DEFAULT 0.00,
  `net_profit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `transaction_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '2025_12_15_011721_create_branches_table', 1),
(4, '2025_12_15_012053_create_tutors_table', 1),
(5, '2025_12_15_012102_create_students_table', 1),
(6, '2025_12_15_012327_create_packages_table', 1),
(7, '2025_12_15_012336_create_student_packages_table', 1),
(8, '2025_12_15_021102_create_package_tutor_table', 1),
(9, '2025_12_15_084058_add_bio_to_tutors_table', 1),
(10, '2025_12_15_090137_add_branch_id_to_tutors_table', 1),
(11, '2025_12_15_095247_update_packages_table', 1),
(12, '2025_12_15_115449_add_category_columns', 1),
(13, '2025_12_16_095101_create_transactions_table', 1),
(14, '2025_12_16_135716_create_personal_access_tokens_table', 1),
(15, '2025_12_16_180635_add_billing_cycle_to_table_students', 1),
(16, '2025_12_16_183518_create_bills_table', 1),
(17, '2025_12_17_092841_add_branch_id_columns_on_table_user_and_students', 1),
(18, '2025_12_17_194842_create_activity_logs_table', 1),
(19, '2025_12_17_211622_modify_students_table_for_single_package', 1),
(20, '2025_12_18_102600_add_slug_to_branches_table', 1),
(21, '2025_12_19_110000_create_financial_reports_table', 1),
(22, '2025_12_20_031453_create_contents_table', 1),
(23, '2025_12_20_031912_update_type_in_contents_table', 1),
(24, '2025_12_20_032451_add_is_carousel_to_contents_table', 1),
(25, '2025_12_20_101530_add_slug_to_packages_table', 1),
(26, '2025_12_20_110500_create_site_settings_table', 1),
(27, '2025_12_20_111700_add_hint_to_site_settings_table', 1),
(28, '2025_12_20_131601_modify_type_in_contents_to_string', 1),
(29, '2025_12_20_150000_create_package_categories_table', 1),
(30, '2025_12_21_015502_create_class_schedules_table', 1),
(31, '2025_12_21_101500_add_social_media_links_to_site_settings', 1);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `benefits` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`benefits`)),
  `grade` varchar(255) DEFAULT NULL,
  `session_count` int(11) DEFAULT 4,
  `price` double NOT NULL,
  `duration` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `package_category_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `created_at`, `updated_at`, `name`, `description`, `category`, `benefits`, `grade`, `session_count`, `price`, `duration`, `image`, `branch_id`, `package_category_id`) VALUES
(3, '2025-12-21 21:02:50', '2025-12-24 16:21:15', 'Jarimatika Jatiarjo', 'Harga yg tertera adalah harga untuk 1x pertemuan', 'ROMBEL', '[\"Tutor berpengalaman dan profesional\",\"Buku Prisma level 1-10\",\"Hitung cepat 10 jari tangan\",\"Penambahan, pengurangan, perkalian, pembagian, akar, dan quadrat\",\"Meningkatkan bakat dlm berhitung\"]', NULL, 2, 80000, 60, NULL, 2, 1),
(4, '2025-12-21 21:03:35', '2025-12-24 12:10:50', 'Jarimatika', 'Jumlah pertemuan dalam 1 minggu 4x pertemuan senin- kamis', 'ROMBEL', '[\"Buku Prisma level 1-10\",\"Tutor berpengalaman dan profesional\",\"Metode hitung cepat 10 jari tangan\",\"Penambahan, pengurangan, perkaluan, pembagian, akar, dan kuadrat\"]', NULL, 4, 120000, 30, NULL, 2, 1),
(5, '2025-12-21 21:04:22', '2025-12-24 16:24:06', 'Umum Kelas 1 - 6', 'Harga tertera untuk durasi belajar selama 1 minggu', 'ROMBEL', '[\"Tutor berpengalaman dan profesional\",\"Belajar lebih mudah dan menyenangkan\",\"Metode belajar dan bermain\",\"Mengasah bakat\",\"Meningkatkan Softskill\"]', NULL, 6, 100000, 30, NULL, 2, 1),
(6, '2025-12-21 21:12:42', '2025-12-24 16:23:44', 'English Class (intermediate)', 'Harga yang tertera untuk kehadiran selama satu minggu, harga untuk kelas selain SD start from (35000-45000)\r\nSenin-Jumat', 'ROMBEL', '[\"Cepat dan mudah berbahasa inggris\",\"Grammar\",\"Speaking English\"]', NULL, 6, 100000, 30, NULL, 2, 1),
(7, '2025-12-21 21:13:38', '2025-12-24 15:10:08', 'Jarimatika Privat', 'Harga tertera bisa berubah sesuai dengan jarak rumah ❤️', 'PRIVATE', '[\"Buku Prisma level 1-10\",\"Berhitung lebih mudah dan menyenangkan\",\"Berhitung lebih cepat\",\"Hitungan tambah, kurang, perkalian, pembagian, akar, dan kuadrat\"]', NULL, 2, 200000, 30, NULL, 3, 1),
(8, '2025-12-23 20:20:37', '2025-12-24 16:23:07', 'English for Junior Class', 'Harga paket tertera 25k durasi belajar 5 hari', 'ROMBEL', '[\"Vocabbulary\"]', NULL, 6, 100000, 30, 'packages/p6yqzGtZGRQWn9CiHkqAKP9ay7WwGICGDvZGpjP2.png', 2, 1),
(9, '2025-12-24 14:59:48', '2025-12-24 14:59:48', 'Cerdas Matematika (CerMat)', 'cara mudah menyelesaikan soal matematika dengan metode CerMat', 'ROMBEL', '[\"Tutor yang berpengalaman\",\"Modul CerMat\",\"Penyelesaian soal matematika dengan lebih mudah\"]', NULL, 16, 120000, 30, NULL, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `package_categories`
--

CREATE TABLE `package_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `package_categories`
--

INSERT INTO `package_categories` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'SD', 'sd', NULL, '2025-12-21 18:44:43', '2025-12-21 18:44:43'),
(2, 'Pra SD', 'pra-sd', NULL, '2025-12-21 21:00:36', '2025-12-21 21:00:36'),
(3, 'SMP', 'smp', NULL, '2025-12-21 21:00:45', '2025-12-21 21:00:45'),
(4, 'TK', 'tk kecil - besar', 'blablabla', '2025-12-23 21:00:48', '2025-12-23 21:00:48');

-- --------------------------------------------------------

--
-- Table structure for table `package_tutor`
--

CREATE TABLE `package_tutor` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tutor_id` bigint(20) UNSIGNED NOT NULL,
  `package_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `package_tutor`
--

INSERT INTO `package_tutor` (`id`, `tutor_id`, `package_id`, `created_at`, `updated_at`) VALUES
(3, 3, 4, NULL, NULL),
(4, 2, 4, NULL, NULL),
(5, 5, 4, NULL, NULL),
(6, 5, 5, NULL, NULL),
(7, 6, 7, NULL, NULL),
(8, 7, 5, NULL, NULL),
(9, 7, 6, NULL, NULL),
(10, 9, 4, NULL, NULL),
(11, 9, 5, NULL, NULL),
(12, 10, 5, NULL, NULL),
(13, 8, 6, NULL, NULL),
(14, 4, 4, NULL, NULL),
(15, 4, 5, NULL, NULL),
(16, 2, 5, NULL, NULL),
(17, 2, 9, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1vngakx0ofNRjawYcoShxXSnX1P1GtYgIrjzye0R', NULL, '103.52.212.50', 'node', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicE4zS01aaW9IME54THU4NENvdmMzdDE2MVQ3a0FJa1dtR0dOT0RvdyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjM6Imh0dHBzOi8vbC1nbGVhcm5pbmcuY29tL3BvcnRhbC9rZW1TSThpbUkwMVdVczhZcVplVzNFUW1FQXJUUDBsWCI7czo1OiJyb3V0ZSI7czoyMDoic3R1ZGVudC5wb3J0YWwuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1766576230),
('3s2jHItHYcRpuUI33hCmrt2EbvVW5TvE0RJrIwhP', NULL, '66.249.66.198', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.7390.122 Mobile Safari/537.36 (compatible; GoogleOther)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWk83ajZxeUxHd2FYeWdCR2VDTG5saVpYa2s4eEpMRHpNbFhlcENiTyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHBzOi8vbC1nbGVhcm5pbmcuY29tL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1766587911),
('4vgfbJoh5caZVsLq8fI1RvAM1Ch2H8T7hlSh3req', NULL, '114.8.229.119', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN3VWNFAwZXB1YVhPTlN6Z2NHNEttTTdGMVpUWWFNWllnSlZjVlI5USI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjM6Imh0dHBzOi8vbC1nbGVhcm5pbmcuY29tL3BvcnRhbC9ZNWgwbENENlJwajZXcTVUUXE2aWZCUXA3U3JDMGRFQyI7czo1OiJyb3V0ZSI7czoyMDoic3R1ZGVudC5wb3J0YWwuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1766578045),
('5YuYXJhjNFJ2LVHFmcn33Ob3oAvF7mEqLOH5U6U1', NULL, '36.81.166.118', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSkhyRWR1aUdUS2VmekV3NFBRVHlSUkNtN1VYR1Q3YzlqNFlTdXdubiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjM6Imh0dHBzOi8vbC1nbGVhcm5pbmcuY29tL3BvcnRhbC9ZNWgwbENENlJwajZXcTVUUXE2aWZCUXA3U3JDMGRFQyI7czo1OiJyb3V0ZSI7czoyMDoic3R1ZGVudC5wb3J0YWwuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1766585641),
('7aXTesVZROu53nJ6aVZVZU7iVykbyLzLGJzqR31k', NULL, '91.98.178.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibGo5OVlOdFpIOTdaaG1BN3A2SzdmdVUzSGxFY0ZaY3Q4bEVjM2tLeiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vbC1nbGVhcm5pbmcuY29tL3Bha2V0LzgiO3M6NToicm91dGUiO3M6MTM6InBhY2thZ2VzLnNob3ciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1766575775),
('7QV2WSHwyCzo4Fr6RAuPZF1liW4W5RZM3ScIIsSY', NULL, '66.249.66.203', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.7390.122 Mobile Safari/537.36 (compatible; GoogleOther)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS0IyTGVTRThrMGNKSVNyVlcwZ1kxNllrc0s3VmVlTmVva1VyU1QwNCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vd3d3LmwtZ2xlYXJuaW5nLmNvbS9wYWtldC8yIjtzOjU6InJvdXRlIjtzOjEzOiJwYWNrYWdlcy5zaG93Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1766575911),
('8TMBbEYVIUv0JTNWdmrciWsjN3EXEncbSq75t1z6', NULL, '103.52.212.50', 'node', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVThIUG1vUEM0dWtrTXdPa0RsWFBIQTd3eENIWnBYVWdlUzRGdXhVSiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjM6Imh0dHBzOi8vbC1nbGVhcm5pbmcuY29tL3BvcnRhbC8xb1pkdjZlMEhENExZM1NnbHlRb1pJcUFXbE5QdnNKaSI7czo1OiJyb3V0ZSI7czoyMDoic3R1ZGVudC5wb3J0YWwuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1766576697),
('A5PtFBCuDhpfhMP6Q4eOa2IyCf71iTh9PVBbvLxG', NULL, '36.81.166.118', 'WhatsApp/2.23.20.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT2VVc1Z4RmdieWg1a0hYTkxTSTNLdDVQWFJBT2w2S2xYOFU3QWlibSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjM6Imh0dHBzOi8vbC1nbGVhcm5pbmcuY29tIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1766580672),
('ayUIIPKRZN7dp3HF8RFLmekzpcQCMTHuAPXOaixZ', NULL, '46.4.198.155', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMko3UUVXV1ZUeUdXVmMzOTF4S1VKd01HbkpzQWJDZWJVS3hEU3dQQiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vbC1nbGVhcm5pbmcuY29tL3Bha2V0LzIiO3M6NToicm91dGUiO3M6MTM6InBhY2thZ2VzLnNob3ciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1766575705),
('C61fA2hyzGl2683loVZean2op9xMclTdEpr8RPhV', NULL, '103.52.212.50', 'node', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSUt5cExuY01yTkNhRFptcTl6QzRBNURyelE2ZHJvV244OEZiVllCZSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjM6Imh0dHBzOi8vbC1nbGVhcm5pbmcuY29tL3BvcnRhbC8yUUZkcHJTZzYwbFlYd3BCYlo3Y0NualZ0WHNWaVB2VSI7czo1OiJyb3V0ZSI7czoyMDoic3R1ZGVudC5wb3J0YWwuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1766576026),
('dKUzKZNe2YonD8mkmjbpLT8eGo3MZwGpIJLL5Kvc', NULL, '161.115.234.85', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36 Vivaldi/5.3.2679.68', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZW5ybGxmQ0lyRDk1R05zSzVhMjdKZWFZc0wxTTNBMU1oRnRvQnIzMiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vbC1nbGVhcm5pbmcuY29tL2tvbnRhayI7czo1OiJyb3V0ZSI7czoxMzoiY29udGFjdC5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1766584713),
('DZ7vX8Wlranl8R1EqAV6otJnQcy59JPMvP4bAK12', NULL, '162.244.144.31', 'Mozilla/5.0 (X11; Fedora; Linux x86_64; rv:89.0) Gecko/20100101 Firefox/89.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV3pkb3VYVWFqN0h5RDFMRjdaVUdkTUp1RlM1RHNWMXVOS2NCcDFxaSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjM6Imh0dHBzOi8vbC1nbGVhcm5pbmcuY29tIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1766580460),
('EuWksOkHnwcR0tfJ5MxrMz6M99aKkyDpqG2k9iv3', NULL, '103.88.90.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM2VyZlVEUGVvVVc5NEpQY01hclRzZzU0RU50alhMVTdIbDhxQkpMViI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vbC1nbGVhcm5pbmcuY29tL3Bha2V0LzgiO3M6NToicm91dGUiO3M6MTM6InBhY2thZ2VzLnNob3ciO319', 1766586303),
('Fuk6GtXqlZrkfDw2z41Ye0Xh3zKcNTYIRaVPgklA', NULL, '157.90.70.224', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaHg3UkoyTzJqMlpobDZyZDExNm0xYlpRbmZidk5rSU5ZZkFDbURBbyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8vbC1nbGVhcm5pbmcuY29tL3Bha2V0LzUvZGFmdGFyIjtzOjU6InJvdXRlIjtzOjE3OiJwYWNrYWdlcy5yZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1766578718),
('g3gs37XUvIc8afGxet7biM9fLt2mjpSrChrenZAA', NULL, '54.157.175.138', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUk9QZ1J0VUlqdXN0NWdnNDRwM3ZNdk5CT1RXcXZuS1h4dnVjT2YwdSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjM6Imh0dHBzOi8vbC1nbGVhcm5pbmcuY29tIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1766581655),
('g5CXhtUl1MdpjuYyOJRGfxFNrYlw3yDepozf2IhE', NULL, '36.81.166.118', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRXJkV0dzVmRUMGtRZEVJR0M5YXlzRXhyZXduTDJ2dzcyamwxYktjYyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHBzOi8vbC1nbGVhcm5pbmcuY29tL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1766585493),
('G8dafAqwf8w3x0mYGOopcNeYRFYncjkCUuBRmG6X', NULL, '66.249.66.10', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.7390.122 Mobile Safari/537.36 (compatible; GoogleOther)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSEJJUXJXazFIbkUyNkp5N0tpSGR4VUJYZ3FOVEdwaGJBT2JjUlZ2ZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjM6Imh0dHBzOi8vbC1nbGVhcm5pbmcuY29tIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1766591661),
('gU3Z1cDzDYJB1xh28hGpracmRw6e9bh4VZDwIOCL', NULL, '35.232.68.163', 'Mozilla/5.0 (compatible; CMS-Checker/1.0; +https://example.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYVM0dUlaMjdVbUtHVk92cHVJaFZSWWFDRWVTUjdvbnRJZHFXSGtIcSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vd3d3LmwtZ2xlYXJuaW5nLmNvbSI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1766586810),
('j3Nbh54kb04hPCDqEoCzj25BBhDHduUF3FAqm7RZ', 1, '36.81.166.118', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUU40SzhMN0pmTFJXNzBYNExTT0ZQVnVsNTVXWHd2NjZ0cUVOaHRPYyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vbC1nbGVhcm5pbmcuY29tL2FkbWluL3Npc3dhIjtzOjU6InJvdXRlIjtzOjIwOiJhZG1pbi5zdHVkZW50cy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1766585702),
('j3z3BdW7IW9G99xGidf1ukV7QGBk295ZwfvQA8iO', NULL, '91.98.178.154', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMWxQcko5VkdEbUpSTlNPekZxSjZlUGlQaU1MemRoS0J5RU51QWVFciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vbC1nbGVhcm5pbmcuY29tL3Bha2V0LzUiO3M6NToicm91dGUiO3M6MTM6InBhY2thZ2VzLnNob3ciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1766580214),
('lLUvfEC7lE8LlVHutBGyObwg8OJQlsTGQIeebL52', NULL, '157.15.62.95', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTkw3bDNYRFU5aEFJa25UUjhHWFRWU1c4MEt4cE9DQjhPMnlva2RqNCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjM6Imh0dHBzOi8vbC1nbGVhcm5pbmcuY29tIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1766582537),
('MPkHzY0BsDNOE8B0vB6pa2qtxZ9XTmi4JAWy6u9r', NULL, '13.221.31.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiemNLQmYzV2JQUkIyUzJMWW1PTTBtcUVpNWRweUw0Q2Zia0JrbGdEVCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjM6Imh0dHBzOi8vbC1nbGVhcm5pbmcuY29tIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1766581633),
('nJLg37WKgsMQtuVXaNwh8KpKYRZ2QASxlSvwE0Oe', NULL, '167.235.93.252', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRng4QWVuS1VPdlZUTXB1SzNnOXhwVkMwUWZuYmNSR1pNcnVnQXl4ZCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vbC1nbGVhcm5pbmcuY29tL3Bha2V0LzYiO3M6NToicm91dGUiO3M6MTM6InBhY2thZ2VzLnNob3ciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1766579057),
('qUHRM6rBBCmJS5gTj6oz5ojSi0OvE2cb8FNxneSx', NULL, '34.90.66.213', 'Mozilla/5.0 (compatible; CMS-Checker/1.0; +https://example.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZXA5MkFlaDBLVWRab1MyVDRKRmQ0R3VUc3FQWFh5WDB6aGRvcnVIQyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjM6Imh0dHBzOi8vbC1nbGVhcm5pbmcuY29tIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1766585430),
('UhfM6wjQkVHS3IHpt2nQeapHSx5cEsmBlFNf1kyD', NULL, '103.52.212.50', 'node', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR3d6T0dZeEhvU3NnS3k0NmExRmtWSDdnTmJxRW41RUtodlJwa3JvWiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjM6Imh0dHBzOi8vbC1nbGVhcm5pbmcuY29tL3BvcnRhbC9ZNWgwbENENlJwajZXcTVUUXE2aWZCUXA3U3JDMGRFQyI7czo1OiJyb3V0ZSI7czoyMDoic3R1ZGVudC5wb3J0YWwuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1766576453),
('urqIsXF0tvCo6a1Dx9lntLB24MO5L1BFC5mwK7WO', NULL, '66.249.66.15', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.7390.122 Mobile Safari/537.36 (compatible; GoogleOther)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYTJ2Wk5Gb3BJU0FrcG15MWdlcTV1T3FvcERlWHg4d2RZWXF3bG1FeCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHBzOi8vd3d3LmwtZ2xlYXJuaW5nLmNvbS9wYWtldC8yL2RhZnRhciI7czo1OiJyb3V0ZSI7czoxNzoicGFja2FnZXMucmVnaXN0ZXIiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1766582661),
('XY5DbIaTk23ZoW7Vo8TtVTuH0V3XVVJZkOVlF3nT', NULL, '36.81.166.118', 'Mozilla/5.0 (Linux; U; Android 14; in-id; CPH2473 Build/TP1A.220905.001) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.6422.72 Mobile Safari/537.36 HeyTapBrowser/45.13.4.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOGZzSVpSczV5a1FLRHB6eWZRR01uRFBCOElkVGZqWXB5TjZsa0NvQyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjM6Imh0dHBzOi8vbC1nbGVhcm5pbmcuY29tIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1766585021),
('y5YR04o8OP8RsP4Y506cm8SGAnV7elhzyADmXe8k', NULL, '66.249.66.75', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.7390.122 Mobile Safari/537.36 (compatible; GoogleOther)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidnBpWGhLSGhGbDBxSU82ZTZMa2lHNEcwdU5qb3JRemlUcmw4VnFZSiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vbC1nbGVhcm5pbmcuY29tL2dhbGVyaSI7czo1OiJyb3V0ZSI7czoxMzoiZ2FsbGVyeS5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1766576661);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'text',
  `hint` varchar(255) DEFAULT NULL,
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `key`, `value`, `type`, `hint`, `group`, `created_at`, `updated_at`) VALUES
(1, 'contact_instagram', 'BIMBINGAN_BELAJAR_LG', 'text', NULL, 'contact', '2025-12-21 18:40:09', '2025-12-24 16:32:12'),
(2, 'contact_tiktok', 'l_glearningfunclass', 'text', NULL, 'contact', '2025-12-21 18:40:09', '2025-12-24 16:32:12'),
(3, 'contact_facebook', 'https://facebook.com/lglearning', 'text', NULL, 'contact', '2025-12-21 18:40:09', '2025-12-21 18:40:09'),
(4, 'site_logo', NULL, 'image', 'Upload logo website (Format: PNG/JPG). Jika kosong, akan menggunakan logo default.', 'general', '2025-12-21 18:40:09', '2025-12-21 18:40:09'),
(5, 'hero_title', 'Raih Masa Depan Gemilang Bersama L-G Learning', 'text', 'Judul utama di halaman depan.', 'hero', '2025-12-21 18:40:09', '2025-12-23 21:16:41'),
(6, 'hero_description', 'Bimbingan belajar terbaik dengan metode fun learning yang terbukti meningkatkan prestasi siswa.', 'textarea', 'Deskripsi singkat di bawah judul.', 'hero', '2025-12-21 18:40:09', '2025-12-21 18:40:09'),
(7, 'hero_button_text', 'Daftar Sekarang', 'text', 'Teks tombol aksi utama.', 'hero', '2025-12-21 18:40:09', '2025-12-21 18:40:09'),
(8, 'hero_image', 'settings/EtaFERe3IUCw88TdHyTzUsPvo272OrL8A7Hrm39G.jpg', 'image', 'Ukuran rekomendasi: 800x600px atau rasio 4:3. Format: JPG/PNG.', 'hero', '2025-12-21 18:40:09', '2025-12-24 14:46:49'),
(9, 'hero_badge_title', 'Hasil Terjamin', 'text', 'Judul kecil di badge hero image.', 'hero', '2025-12-21 18:40:09', '2025-12-21 18:40:09'),
(10, 'hero_badge_subtitle', 'Menghasilkan Nilai dan Pengalaman Terbaik🪙🏆', 'text', 'Teks besar di badge hero image.', 'hero', '2025-12-21 18:40:09', '2025-12-24 14:47:55'),
(11, 'faq_data', '[{\"question\":\"Apakah materi di bimbel disesuaikan dengan jadwal sekolah anak ?\",\"answer\":\"Tidak, bimbel mengajar sesuai jadwal yg di tetapkan di bimbel\"},{\"question\":\"Apakah materi sesuai dengan yg dipelajari di sekolah anak?\",\"answer\":\"IyA\"},{\"question\":\"Apakah metode belajar dikemas dengan praktek?\",\"answer\":\"Iya\"},{\"question\":\"Apakah bimbel disini bisa melatih anak untuk percaya diri?\",\"answer\":\"Iya\"},{\"question\":\"Apakah ruang kelas jadi satu dengan kelas lain?\",\"answer\":\"Tidak, bimbel kami disetting perkelas\"}]', 'json_list', 'Kelola daftar pertanyaan dan jawaban.', 'faq', '2025-12-21 18:40:09', '2025-12-24 14:54:08'),
(12, 'about_title', 'Mengapa Memilih LG Learning?', 'text', NULL, 'about', '2025-12-21 18:40:09', '2025-12-21 18:40:09'),
(13, 'about_description', 'Kami berkomitmen mencetak generasi cerdas dan berkarakter melalui metode pembelajaran yang adaptif dan menyenangkan. Didukung oleh tentor berpengalaman dan profesional', 'textarea', NULL, 'about', '2025-12-21 18:40:09', '2025-12-24 14:48:31'),
(14, 'feature_1_title', 'Metode Personal', 'text', NULL, 'features', '2025-12-21 18:40:09', '2025-12-21 18:40:09'),
(15, 'feature_1_desc', 'Setiap anak unik. Kami menyesuaikan pendekatan belajar sesuai dengan gaya belajar dan bakat  minat anak.', 'textarea', NULL, 'features', '2025-12-21 18:40:09', '2025-12-24 14:49:21'),
(16, 'feature_2_title', 'Tutor Selektif', 'text', NULL, 'features', '2025-12-21 18:40:09', '2025-12-21 18:40:09'),
(17, 'feature_2_desc', 'Tutor kami tidak hanya pintar akademis, tapi juga sabar dan mampu memotivasi siswa untuk berprestasi.', 'textarea', NULL, 'features', '2025-12-21 18:40:09', '2025-12-21 18:40:09'),
(18, 'feature_3_title', 'Laporan Berkala', 'text', NULL, 'features', '2025-12-21 18:40:09', '2025-12-21 18:40:09'),
(19, 'feature_3_desc', 'Pantau perkembangan anak Anda dengan laporan progress yang detail dan transparan setiap bulannya.', 'textarea', NULL, 'features', '2025-12-21 18:40:09', '2025-12-21 18:40:09'),
(20, 'contact_whatsapp', '085815222639', 'text', NULL, 'contact', '2025-12-21 18:40:09', '2025-12-24 16:32:12'),
(21, 'contact_address', 'Jl. Taman Safari Indonesia Prigen Kemiri Pakukerto Sukorejo (Kampung Damri)', 'text', NULL, 'contact', '2025-12-21 18:40:09', '2025-12-24 16:32:12'),
(22, 'contact_email', 'info@lglearning.com', 'text', NULL, 'contact', '2025-12-21 18:40:09', '2025-12-21 18:40:09');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `access_token` varchar(64) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `parent_phone` varchar(255) NOT NULL,
  `school` varchar(255) NOT NULL,
  `grade` varchar(255) NOT NULL,
  `status` enum('pending','active','inactive') NOT NULL,
  `billing_cycle` enum('full','monthly','weekly') NOT NULL DEFAULT 'monthly',
  `next_billing_date` date DEFAULT NULL,
  `join_date` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `package_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--


-- --------------------------------------------------------

--
-- Table structure for table `student_packages`
--

CREATE TABLE `student_packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `package_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_code` varchar(255) NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `total_amount` decimal(12,0) NOT NULL,
  `status` enum('PENDING','PAID','EXPIRED','FAILED','CANCELLED') NOT NULL DEFAULT 'PENDING',
  `payment_url` text DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_channel` varchar(255) DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `transaction_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--


-- --------------------------------------------------------

--
-- Table structure for table `tutors`
--

CREATE TABLE `tutors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `jobs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`jobs`)),
  `bio` text DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tutors`
--

INSERT INTO `tutors` (`id`, `user_id`, `branch_id`, `address`, `jobs`, `bio`, `phone`, `image`, `created_at`, `updated_at`) VALUES
(2, 3, 2, 'Kemiri Pakukerto, Sukorejo', '[\"Guru\",\"IRT\",\"Tutor (Leader Jarimatika)\"]', 'Hallo, Perkenalkan saya adalah Heni sering dipanggil Aunty atau Bu Heni oleh anak didik saya.\r\nsaya founder bimbel L-G Learning, bimbel yang saya kemas dengan metode belajar sambil bermain agar anak semakin termotifasi dan semangat untuk belajar', '085815222639', 'tutors/vL6a22n8i8ku26BQLvyzj0zxl1AJjircCoEMOhLL.jpg', '2025-12-21 21:06:15', '2025-12-24 10:38:05'),
(3, 4, 2, 'Kemiri Pakukerto, Sukorejo', '[\"Guru\",\"Tutor\"]', NULL, '085731072115', 'tutors/UNl9VT2MiyynvbrVWraeOL3hTAG6vILwqEe2vRqg.jpg', '2025-12-21 21:08:10', '2025-12-24 10:43:19'),
(4, 5, 2, 'Kemiri, Sukorejo', '[\"Mahasiswa\",\"Tutor\"]', NULL, '082338311273', 'tutors/XLJDnha073mTeaPgTtFkRTVOgzBjgl3UDCKoE1aL.jpg', '2025-12-24 10:56:21', '2025-12-24 10:57:12'),
(5, 6, 2, 'Karangrejo, Purwosari', '[\"Pelajar\\/ Mahasiswa\",\"Tutor\"]', NULL, '085604197990', 'tutors/aSvjwPQYR5xQziNfJrrI22shUz9KTALXbVFWvqzA.jpg', '2025-12-24 11:03:40', '2025-12-24 11:03:40'),
(6, 7, 3, 'Rembang, Bangil', '[\"Guru\",\"Tutor\",\"IRT\"]', NULL, '088230335620', 'tutors/Mm1jwGc46bRlNZTJqKyCIaiPbdt4fgKjJlHMjfpT.jpg', '2025-12-24 11:10:20', '2025-12-24 16:43:44'),
(7, 8, 2, 'Jatiarjo, Prigen', '[\"Guru\",\"Tutor\",\"Trainer\",\"IRT\"]', 'Cara menikmati kesulitan adalah dengan meyakini bahwa \"tidak ada jalan yg mudah\"', '08563558872', 'tutors/2FYG7I4tChTyWS23kWpfeiXLt2HOhv9KmvJ5WbgV.jpg', '2025-12-24 11:14:51', '2025-12-24 11:36:20'),
(8, 9, 2, 'Jatiarjo, Prigen', '[\"Fasilitator Trainer\",\"Tutor English\",\"Grafologi\"]', 'Hallo... Nama saya Wartib.SM, Panggilan terkenal saya Khoir djawal, profesi saya adalah seoarang Trainer, Analisis tulisan tangan Grafologi, Director, Konseptor, Fasilitator Outbound Bahasa inggris,  Pemandu gunung dan Pemandu ekowisata, Pramuwisata HPI Pasuruan Spesialisasi Bahasa Inggris.\r\n\r\n Profesi lain saya Narasumber Pelatihan Peningkatan SDM  kepariwisataan, Publick speaking, Coaching Fasilitator, Tutor Bahasa Inggris, Digital marketer, Sales, Marketing dan Enterprenure.\r\n\r\n   Founder Terapi Menulis Indah 30 hari, Analisis tulisan tangan Grafologi.\r\n\r\n     Owner Jasa Usaha Outbound PT.Karya Adventure Indonesia\r\n\r\n\r\nSalam\r\nKhoir Djawal', '082231861653', 'tutors/B22xBi0RJPHPcujYrSp0URCW8EVDlXv6KKs9xc9f.jpg', '2025-12-24 11:19:00', '2025-12-24 11:37:47'),
(9, 10, 2, 'Gersik', '[\"Guru\",\"Turor\"]', NULL, '085536615600', NULL, '2025-12-24 11:28:42', '2025-12-24 11:28:42'),
(10, 11, 2, 'Glagasari, Sukorejo', '[\"Mahasiswa\",\"Freelance Tutor\"]', NULL, '082142929637', 'tutors/4GPobQjpYN8aw4CRiLnhtKULMWDyhrW7gAyRbvwW.jpg', '2025-12-24 11:30:58', '2025-12-24 16:41:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','tutor') NOT NULL DEFAULT 'tutor',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `branch_id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Admin keren L-G Learning', 'admin@bimbel.com', '2025-12-21 18:40:09', '$2y$12$/Utz3ECrOthTDICIYnfmc.FRn/y86IN4WhCE2n3SMQIEZqD0H.ea6', 'admin', NULL, '2025-12-21 18:40:09', '2025-12-24 21:14:50'),
(3, 2, 'Heni Safitri S.Psi', 'henisafitri.hs@gmail.com', NULL, '$2y$12$SiYW6JGi9JRekZLk7pLE.OKZYWzLz0UxDsRGiRtkucqE4Noq5lBiK', 'tutor', NULL, '2025-12-21 21:06:15', '2025-12-24 10:32:43'),
(4, 2, 'Naili Ilfi Amami S.Pd', 'nayfiilfiamami@bimbel.com', NULL, '$2y$12$bz/qYzygQ15ai8w/kORC9O5ACyQgEvE5kPCg7LCNIzdT4ReUfSwaG', 'tutor', NULL, '2025-12-21 21:08:10', '2025-12-24 11:38:54'),
(5, 2, 'Zahrotul Awalia', 'zahrotulawalia@gmail.com', NULL, '$2y$12$XBZn0LinNZ9p1F.2WNgfEuvuVxPs2Vcpa3pOeZOCIqxmz6yjN5UCG', 'tutor', NULL, '2025-12-24 10:56:21', '2025-12-24 10:56:21'),
(6, 2, 'Cinde Laras Indira S', 'cinde@gmail.com', NULL, '$2y$12$KbOqy5dgrefuCqnJcQwFUu7RkFexTjC2PGxOYlqy7Av12outaWp9G', 'tutor', NULL, '2025-12-24 11:03:40', '2025-12-24 11:03:40'),
(7, 3, 'Aisyah', 'Aisyahwardana269@gmail.com', NULL, '$2y$12$dfdpIJ3Lj0szjeAeJFqZfef4pjiPspjZ/GR8X5aSL0WJgUKCkYera', 'tutor', NULL, '2025-12-24 11:10:20', '2025-12-24 16:44:33'),
(8, 2, 'Silfiatul Badi\'ah', 'zahraadek807@gmail.com', NULL, '$2y$12$LUMzc33EeK/X5ks9KmiueuvGFFKzepXMzzOEA.Ca/109eWevly5NO', 'tutor', NULL, '2025-12-24 11:14:51', '2025-12-24 11:36:20'),
(9, 2, 'Khoir Djawal', 'khoir.djawal@gmail.com', NULL, '$2y$12$i6e0fDCoerBjTDGDQ8PJnO5okmTGuRiiXMEGXYg7pGWzll7JveJ9a', 'tutor', NULL, '2025-12-24 11:19:00', '2025-12-24 11:38:30'),
(10, 2, 'Faizatur Rahmawati', 'faisisfish@gmail.com', NULL, '$2y$12$7S4Xsxorp4RtP5E7jssO9e0obkhVGRuLljSzPbjAjP9cpmK8DOFKS', 'tutor', NULL, '2025-12-24 11:28:42', '2025-12-24 11:28:42'),
(11, 2, 'Wilda Aulia (Memey)', 'wildamemey10@gmail.com', NULL, '$2y$12$IrPcsAo2jUVVH4UyizR7seU4aXTKIaGL/H.zjTn6SOeu1uBvINlvu', 'tutor', NULL, '2025-12-24 11:30:58', '2025-12-24 16:43:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`),
  ADD KEY `activity_logs_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bills_student_id_foreign` (`student_id`),
  ADD KEY `bills_transaction_id_foreign` (`transaction_id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branches_slug_unique` (`slug`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `class_schedules`
--
ALTER TABLE `class_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_schedules_branch_id_foreign` (`branch_id`),
  ADD KEY `class_schedules_package_id_foreign` (`package_id`);

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `financial_reports`
--
ALTER TABLE `financial_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `financial_reports_branch_id_foreign` (`branch_id`),
  ADD KEY `financial_reports_package_id_foreign` (`package_id`),
  ADD KEY `financial_reports_month_branch_id_index` (`month`,`branch_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `packages_branch_id_foreign` (`branch_id`),
  ADD KEY `packages_package_category_id_foreign` (`package_category_id`);

--
-- Indexes for table `package_categories`
--
ALTER TABLE `package_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `package_categories_slug_unique` (`slug`);

--
-- Indexes for table `package_tutor`
--
ALTER TABLE `package_tutor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `package_tutor_tutor_id_package_id_unique` (`tutor_id`,`package_id`),
  ADD KEY `package_tutor_package_id_foreign` (`package_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `site_settings_key_unique` (`key`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `students_branch_id_foreign` (`branch_id`),
  ADD KEY `students_package_id_foreign` (`package_id`);

--
-- Indexes for table `student_packages`
--
ALTER TABLE `student_packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_packages_student_id_foreign` (`student_id`),
  ADD KEY `student_packages_package_id_foreign` (`package_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transactions_invoice_code_unique` (`invoice_code`),
  ADD KEY `transactions_student_id_foreign` (`student_id`),
  ADD KEY `transactions_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `tutors`
--
ALTER TABLE `tutors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tutors_user_id_foreign` (`user_id`),
  ADD KEY `tutors_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_branch_id_foreign` (`branch_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=724;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=578;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `class_schedules`
--
ALTER TABLE `class_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `financial_reports`
--
ALTER TABLE `financial_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `package_categories`
--
ALTER TABLE `package_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `package_tutor`
--
ALTER TABLE `package_tutor`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `student_packages`
--
ALTER TABLE `student_packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=581;

--
-- AUTO_INCREMENT for table `tutors`
--
ALTER TABLE `tutors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bills_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `class_schedules`
--
ALTER TABLE `class_schedules`
  ADD CONSTRAINT `class_schedules_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_schedules_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `financial_reports`
--
ALTER TABLE `financial_reports`
  ADD CONSTRAINT `financial_reports_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `financial_reports_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `packages`
--
ALTER TABLE `packages`
  ADD CONSTRAINT `packages_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `packages_package_category_id_foreign` FOREIGN KEY (`package_category_id`) REFERENCES `package_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `package_tutor`
--
ALTER TABLE `package_tutor`
  ADD CONSTRAINT `package_tutor_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `package_tutor_tutor_id_foreign` FOREIGN KEY (`tutor_id`) REFERENCES `tutors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_packages`
--
ALTER TABLE `student_packages`
  ADD CONSTRAINT `student_packages_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_packages_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tutors`
--
ALTER TABLE `tutors`
  ADD CONSTRAINT `tutors_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tutors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
