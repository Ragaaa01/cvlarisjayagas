-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 02, 2025 at 09:21 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cv_laris_jaya_gas`
--

-- --------------------------------------------------------

--
-- Table structure for table `akuns`
--

CREATE TABLE `akuns` (
  `id_akun` bigint UNSIGNED NOT NULL,
  `id_perorangan` bigint UNSIGNED DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('administrator','pelanggan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pelanggan',
  `status_aktif` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `akuns`
--

INSERT INTO `akuns` (`id_akun`, `id_perorangan`, `email`, `password`, `role`, `status_aktif`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'administrator@larisjayagas.com', '$2y$10$G8OlOtvWMsC02EHNe0hjqeg0bvpO0WEC4GNQki0exxDP5IYXHeI4m', 'administrator', 1, 'icsnxEH5OE', '2025-06-17 02:30:41', '2025-06-17 02:30:41', NULL),
(2, 31, 'pelanggan1@larisjayagas.com', '$2y$10$my2jrHZFEaw6uCE7yLr6wOuZvgRJuFhnB7Sfsa.7Ub7OZrZzsmDMe', 'pelanggan', 1, 'i8XhkXwUzS', '2025-06-17 02:30:41', '2025-06-17 02:30:41', NULL),
(3, 2, 'ghani.dongoran@example.net', '$2y$10$DCZdXof2EcT8NblAu/ffnOF2GjeMWWKJORX5Jjt661Vqh0in6ui.u', 'pelanggan', 1, 'FhAdtm8yKe', '2025-06-17 02:30:42', '2025-06-17 02:30:42', NULL),
(4, 3, 'harsana74@example.com', '$2y$10$r8sujCnyy28YnxNdW6NMXeZzPAhDNiGQEc30peFpapHDJXxB/pbuG', 'pelanggan', 1, 'gdTZACShRI', '2025-06-17 02:30:42', '2025-06-17 02:30:42', NULL),
(5, 4, 'makuta.setiawan@example.org', '$2y$10$.hf.WpoW4.LGKAsw5Lb9E.gQXxsCsMtDypmxzT326rKzA8dQl7uuu', 'pelanggan', 1, 't5AHJA3Cmr', '2025-06-17 02:30:42', '2025-06-17 02:30:42', NULL),
(6, 5, 'wage.melani@example.net', '$2y$10$QRJb60k15DFSnDpgN.Gouuoapr.ivoWood14aYDWhChufHlkQ1b62', 'pelanggan', 0, 'yKrJHh8p8O', '2025-06-17 02:30:42', '2025-06-17 02:30:42', NULL),
(7, 6, 'staf1@larisjayagas.com', '$2y$10$YbxQpxB7F29.m2SHejOurON58qIgWI3wZioQdTE3UjiJvHd3vEIYW', 'pelanggan', 1, '3b2vjFDpKI', '2025-06-17 02:30:42', '2025-06-17 02:30:42', NULL),
(8, 7, 'staf2@larisjayagas.com', '$2y$10$8A28kUfJhRxOBbgg/hTKquNSWjq0ToxUqvp9wjQV5z5ou.DL9LIyq', 'pelanggan', 1, 'HnjTT5cOmp', '2025-06-17 02:30:42', '2025-06-17 02:30:42', NULL),
(9, 8, 'febi.widiastuti@example.com', '$2y$10$ALqmcPqSKj1fbsNBQ1eUc.IkDoxZa4JjXEay/YeBY.6yBuodcXvZy', 'pelanggan', 1, '9Xjpbk7uP6', '2025-06-17 02:30:42', '2025-06-17 02:30:42', NULL),
(10, 9, 'jasmin85@example.com', '$2y$10$.VQCmg1XQs9U3UKPiF3sq.7fUswSFfHJ2pMV8amhf1Mu0/oozmBSS', 'pelanggan', 1, '3GgX3kfMEh', '2025-06-17 02:30:42', '2025-06-17 02:30:42', NULL),
(11, 10, 'marpaung.jinawi@example.com', '$2y$10$cpKy5B97BQt2m6mivpnY6O.Pz1YuYi4zpJBLsIEpQCJylkGgeK.9i', 'pelanggan', 1, 'PlZSYVXDAS', '2025-06-17 02:30:42', '2025-06-17 02:30:42', NULL),
(12, 11, 'ikin.pratama@example.net', '$2y$10$0PcyiXFmLJxvaLEFBIZUbu3DA60fBrrL0jAglks9EgTMtvJzlIvs6', 'pelanggan', 1, 'UgArswZO7d', '2025-06-17 02:30:42', '2025-06-17 02:30:42', NULL),
(13, 12, 'novitasari.nyana@example.org', '$2y$10$bXcKhCRsj6OJtPp090FAtuxrwW4K6Sv1u76VVrqjx5lcZwgLGXJh.', 'pelanggan', 1, 'PjxzWwLjle', '2025-06-17 02:30:42', '2025-06-17 02:30:42', NULL),
(14, 13, '$faker->unique()->safeEmail', '$2y$10$Hk3wx4b1O5UKeXWTg.imT.Erlyfo9z23GVPQX0NDGm8H/P3/r34iG', 'pelanggan', 1, 'XSpB4FwxJv', '2025-06-17 02:30:42', '2025-06-17 02:30:42', NULL),
(15, 14, 'maryadi.rahmi@example.net', '$2y$10$q8kGZELSNy5y/aKtQt0WTek9pJHsWC.se6FWR7L3JyZNWU9/doKvG', 'pelanggan', 1, 'ns6UhFnY4z', '2025-06-17 02:30:42', '2025-06-17 02:30:42', NULL),
(16, 32, 'adinda@gmail.com', '$2y$10$kEWVhNs/EO1WKLvZZl7P/e5iuTCuVd.QqndRySuzRRGB7xH1GaORy', 'pelanggan', 1, NULL, '2025-06-17 02:31:33', '2025-06-17 02:31:33', NULL),
(17, NULL, 'wiranto@gmail.com', '$2y$10$3oh9UwKYcNgsNBfyZnhvoOqlrA3GArdp0lCPP1Qn5ioznzws3h8pK', 'pelanggan', 1, NULL, '2025-06-26 13:32:13', '2025-06-27 01:50:33', NULL),
(18, 46, 'sahrul@gmail.com', '$2y$10$EPBTdieeOCe7L2ehHadKuOaW84BpaVZct9.Tb65Nv5J26TFsU4o46', 'pelanggan', 1, NULL, '2025-06-27 02:59:02', '2025-06-27 02:59:02', NULL),
(19, 47, 'adinda1@gmail.com', '$2y$10$nAp4j7AORtom6RBb4i/dfeES0Ym75VACFXey8cds31lFyat74i/Ei', 'pelanggan', 1, NULL, '2025-06-30 04:57:43', '2025-06-30 04:57:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksis`
--

CREATE TABLE `detail_transaksis` (
  `id_detail_transaksi` bigint UNSIGNED NOT NULL,
  `id_transaksi` bigint UNSIGNED NOT NULL,
  `id_tabung` bigint UNSIGNED NOT NULL,
  `id_jenis_transaksi` bigint UNSIGNED NOT NULL,
  `harga` decimal(15,2) NOT NULL,
  `batas_waktu_peminjaman` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_transaksis`
--

INSERT INTO `detail_transaksis` (`id_detail_transaksi`, `id_transaksi`, `id_tabung`, `id_jenis_transaksi`, `harga`, `batas_waktu_peminjaman`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 150000.00, '2025-05-31 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(2, 1, 6, 1, 175000.00, '2025-05-31 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(3, 2, 11, 2, 200000.00, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(4, 3, 7, 2, 175000.00, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(5, 4, 2, 1, 150000.00, '2025-06-03 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(6, 5, 3, 1, 150000.00, '2025-06-04 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(7, 6, 5, 2, 150000.00, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(8, 7, 4, 1, 150000.00, '2025-06-06 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(9, 7, 16, 2, 225000.00, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(10, 7, 12, 2, 200000.00, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(11, 8, 17, 1, 225000.00, '2025-06-07 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(12, 8, 13, 2, 200000.00, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(13, 9, 18, 1, 225000.00, '2025-06-08 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(14, 9, 14, 2, 200000.00, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(15, 10, 19, 1, 150000.00, '2025-06-09 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(16, 11, 20, 2, 225000.00, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(17, 11, 8, 2, 175000.00, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(18, 12, 21, 1, 250000.00, '2025-06-11 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(19, 12, 22, 1, 250000.00, '2025-06-11 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(20, 12, 23, 1, 250000.00, '2025-06-11 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(21, 12, 24, 1, 250000.00, '2025-06-11 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(22, 12, 25, 1, 250000.00, '2025-06-11 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(23, 13, 9, 1, 175000.00, '2025-06-12 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(24, 13, 10, 2, 175000.00, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(25, 14, 15, 1, 200000.00, '2025-06-13 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(26, 14, 1, 1, 150000.00, '2025-06-13 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(27, 14, 6, 1, 175000.00, '2025-06-13 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(28, 14, 11, 1, 200000.00, '2025-06-13 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(29, 14, 16, 1, 225000.00, '2025-06-13 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(30, 15, 2, 2, 150000.00, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(31, 16, 26, 1, 150000.00, '2025-06-13 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(32, 16, 41, 1, 175000.00, '2025-06-14 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(33, 17, 103, 2, 200000.00, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(34, 18, 102, 2, 175000.00, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(35, 19, 42, 1, 150000.00, '2025-06-14 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(36, 20, 27, 1, 150000.00, '2025-06-13 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(37, 21, 101, 2, 150000.00, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(38, 22, 101, 2, 150000.00, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(39, 22, 56, 1, 200000.00, '2025-06-13 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(40, 22, 71, 1, 225000.00, '2025-06-13 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(41, 23, 56, 1, 200000.00, '2025-06-14 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(42, 23, 104, 2, 225000.00, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(43, 24, 57, 1, 200000.00, '2025-06-13 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(44, 24, 104, 2, 225000.00, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(45, 25, 28, 1, 150000.00, '2025-06-14 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(46, 26, 101, 2, 150000.00, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(47, 26, 102, 2, 175000.00, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(48, 27, 101, 2, 150000.00, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(49, 27, 102, 2, 175000.00, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(50, 27, 103, 2, 220000.00, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(51, 27, 72, 1, 225000.00, '2025-06-14 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(52, 27, 86, 1, 250000.00, '2025-06-14 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(53, 28, 101, 2, 150000.00, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(54, 28, 29, 1, 150000.00, '2025-06-13 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(55, 29, 30, 1, 150000.00, '2025-06-14 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(56, 29, 43, 1, 175000.00, '2025-06-14 00:00:00', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(57, 29, 103, 2, 220000.00, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(58, 29, 104, 2, 225000.00, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(59, 29, 105, 2, 250000.00, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(60, 30, 102, 2, 175000.00, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(63, 33, 1, 1, 150000.00, '2025-07-22 00:00:00', '2025-06-22 03:23:00', '2025-06-22 03:23:00'),
(64, 34, 2, 1, 150000.00, '2025-07-23 00:00:00', '2025-06-22 22:47:50', '2025-06-22 22:47:50'),
(65, 35, 10, 1, 150000.00, '2025-07-24 00:00:00', '2025-06-24 00:19:59', '2025-06-24 00:19:59'),
(66, 36, 110, 1, 150000.00, '2025-07-26 00:00:00', '2025-06-26 08:37:24', '2025-06-26 08:37:24'),
(67, 36, 109, 2, 150000.00, NULL, '2025-06-26 08:37:24', '2025-06-26 08:37:24'),
(68, 37, 11, 1, 150000.00, '2025-07-26 00:00:00', '2025-06-26 08:40:14', '2025-06-26 08:40:14'),
(69, 38, 111, 1, 150000.00, '2025-07-26 00:00:00', '2025-06-26 09:08:11', '2025-06-26 09:08:11'),
(70, 38, 112, 1, 150000.00, '2025-07-26 00:00:00', '2025-06-26 09:08:11', '2025-06-26 09:08:11'),
(71, 39, 12, 1, 150000.00, '2025-07-26 00:00:00', '2025-06-26 09:14:35', '2025-06-26 09:14:35'),
(72, 40, 4, 1, 150000.00, '2025-07-27 00:00:00', '2025-06-27 01:56:04', '2025-06-27 01:56:04'),
(73, 41, 5, 1, 150000.00, '2025-07-27 00:00:00', '2025-06-27 02:28:35', '2025-06-27 02:28:35'),
(74, 42, 13, 1, 150000.00, '2025-07-27 00:00:00', '2025-06-27 02:49:38', '2025-06-27 02:49:38'),
(75, 43, 14, 1, 150000.00, '2025-07-27 00:00:00', '2025-06-27 02:59:47', '2025-06-27 02:59:47'),
(76, 44, 15, 1, 150000.00, '2025-07-27 00:00:00', '2025-06-27 03:01:57', '2025-06-27 03:01:57'),
(77, 45, 16, 2, 150000.00, NULL, '2025-06-27 06:33:18', '2025-06-27 06:33:18'),
(78, 46, 17, 1, 150000.00, '2025-07-30 00:00:00', '2025-06-30 04:47:39', '2025-06-30 04:47:39'),
(79, 46, 19, 2, 150000.00, NULL, '2025-06-30 04:47:39', '2025-06-30 04:47:39'),
(80, 47, 23, 1, 175000.00, '2025-07-30 00:00:00', '2025-06-30 06:07:09', '2025-06-30 06:07:09'),
(81, 48, 18, 1, 150000.00, '2025-07-30 00:00:00', '2025-06-30 07:47:32', '2025-06-30 07:47:32'),
(86, 51, 10, 1, 150000.00, '2025-08-01 00:00:00', '2025-07-01 20:27:50', '2025-07-01 20:27:50'),
(87, 51, 15, 2, 50000.00, NULL, '2025-07-01 20:27:50', '2025-07-01 20:27:50'),
(88, 52, 10, 1, 150000.00, '2025-08-01 00:00:00', '2025-07-01 20:48:15', '2025-07-01 20:48:15'),
(89, 52, 15, 2, 50000.00, NULL, '2025-07-01 20:48:15', '2025-07-01 20:48:15'),
(90, 53, 10, 1, 150000.00, '2025-08-01 00:00:00', '2025-07-01 20:50:13', '2025-07-01 20:50:13'),
(91, 53, 15, 2, 50000.00, NULL, '2025-07-01 20:50:13', '2025-07-01 20:50:13'),
(92, 54, 11, 1, 150000.00, '2025-08-01 00:00:00', '2025-07-01 20:55:53', '2025-07-01 20:55:53'),
(93, 55, 11, 1, 150000.00, '2025-08-01 00:00:00', '2025-07-01 21:18:43', '2025-07-01 21:18:43'),
(94, 56, 11, 1, 150000.00, '2025-08-01 00:00:00', '2025-07-01 21:24:50', '2025-07-01 21:24:50'),
(95, 57, 11, 1, 150000.00, '2025-08-01 00:00:00', '2025-07-01 21:25:19', '2025-07-01 21:25:19'),
(96, 58, 11, 1, 150000.00, '2025-08-01 00:00:00', '2025-07-01 21:44:00', '2025-07-01 21:44:00'),
(98, 60, 11, 1, 150000.00, '2025-08-01 00:00:00', '2025-07-01 22:13:03', '2025-07-01 22:13:03'),
(99, 61, 11, 1, 150000.00, '2025-08-01 00:00:00', '2025-07-01 22:19:10', '2025-07-01 22:19:10');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_tabungs`
--

CREATE TABLE `jenis_tabungs` (
  `id_jenis_tabung` bigint UNSIGNED NOT NULL,
  `kode_jenis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_jenis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_tabungs`
--

INSERT INTO `jenis_tabungs` (`id_jenis_tabung`, `kode_jenis`, `nama_jenis`, `harga`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'O', 'Oksigen', 150000, NULL, NULL, NULL),
(2, 'N', 'Nitrogen', 175000, NULL, NULL, NULL),
(3, 'AR', 'Argon', 200000, NULL, NULL, NULL),
(4, 'ACE', 'Aceteline', 225000, NULL, NULL, NULL),
(5, 'N2O', 'Dinitrogen Oksida', 250000, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_transaksis`
--

CREATE TABLE `jenis_transaksis` (
  `id_jenis_transaksi` bigint UNSIGNED NOT NULL,
  `nama_jenis_transaksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_transaksis`
--

INSERT INTO `jenis_transaksis` (`id_jenis_transaksi`, `nama_jenis_transaksi`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'peminjaman', NULL, NULL, NULL),
(2, 'isi ulang', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_05_15_121425_create_perusahaans_table', 1),
(6, '2025_05_15_121437_create_perorangans_table', 1),
(7, '2025_05_15_121455_create_akuns_table', 1),
(8, '2025_05_15_121550_create_jenis_tabungs_table', 1),
(9, '2025_05_15_121609_create_status_tabungs_table', 1),
(10, '2025_05_15_121620_create_tabungs_table', 1),
(11, '2025_05_15_121651_create_status_transaksis_table', 1),
(12, '2025_05_15_121700_create_jenis_transaksis_table', 1),
(13, '2025_05_15_121708_create_transaksis_table', 1),
(14, '2025_05_15_121719_create_detail_transaksis_table', 1),
(15, '2025_05_15_121733_create_peminjamans_table', 1),
(16, '2025_05_15_121742_create_pengembalians_table', 1),
(17, '2025_05_15_121759_create_tagihans_table', 1),
(18, '2025_05_15_121858_create_notifikasi_templates_table', 1),
(19, '2025_05_15_121909_create_notifikasis_table', 1),
(20, '2025_05_15_121959_create_riwayat_transaksis_table', 1),
(21, '2025_06_22_092251_update_detail_transaksis_table', 2),
(22, '2025_06_22_092418_update_peminjamans_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasis`
--

CREATE TABLE `notifikasis` (
  `id_notifikasi` bigint UNSIGNED NOT NULL,
  `id_tagihan` bigint UNSIGNED NOT NULL,
  `id_template` bigint UNSIGNED NOT NULL,
  `tanggal_terjadwal` date NOT NULL,
  `status_baca` tinyint(1) NOT NULL,
  `waktu_dikirim` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifikasis`
--

INSERT INTO `notifikasis` (`id_notifikasi`, `id_tagihan`, `id_template`, `tanggal_terjadwal`, `status_baca`, `waktu_dikirim`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-01-09', 0, '2025-01-09 10:18:00', NULL, NULL),
(2, 1, 2, '2025-01-11', 0, '2025-01-11 10:18:00', NULL, NULL),
(3, 1, 3, '2025-01-12', 0, '2025-01-12 10:18:00', NULL, NULL),
(4, 2, 1, '2025-01-10', 0, '2025-01-10 10:18:00', NULL, NULL),
(5, 2, 2, '2025-01-12', 0, '2025-01-12 10:18:00', NULL, NULL),
(6, 2, 3, '2025-01-13', 0, '2025-01-13 10:18:00', NULL, NULL),
(7, 2, 4, '2025-01-14', 0, '2025-01-14 10:18:00', NULL, NULL),
(8, 3, 1, '2025-01-17', 0, '2025-01-17 10:18:00', NULL, NULL),
(9, 3, 2, '2025-01-19', 0, '2025-01-19 10:18:00', NULL, NULL),
(10, 3, 3, '2025-01-20', 0, '2025-01-20 10:18:00', NULL, NULL),
(11, 4, 1, '2025-01-22', 0, '2025-01-22 10:18:00', NULL, NULL),
(12, 4, 2, '2025-01-24', 0, '2025-01-24 10:18:00', NULL, NULL),
(13, 4, 3, '2025-01-25', 0, '2025-01-25 10:18:00', NULL, NULL),
(14, 5, 1, '2025-01-23', 0, '2025-01-23 10:18:00', NULL, NULL),
(15, 5, 2, '2025-01-25', 0, '2025-01-25 10:18:00', NULL, NULL),
(16, 5, 3, '2025-01-26', 0, '2025-01-26 10:18:00', NULL, NULL),
(17, 6, 1, '2025-01-21', 0, '2025-01-21 10:18:00', NULL, NULL),
(18, 6, 2, '2025-01-23', 0, '2025-01-23 10:18:00', NULL, NULL),
(19, 6, 3, '2025-01-24', 0, '2025-01-24 10:18:00', NULL, NULL),
(20, 6, 4, '2025-01-25', 0, '2025-01-25 10:18:00', NULL, NULL),
(21, 7, 1, '2025-01-18', 0, '2025-01-18 10:18:00', NULL, NULL),
(22, 7, 2, '2025-01-20', 0, '2025-01-20 10:18:00', NULL, NULL),
(23, 7, 3, '2025-01-21', 0, '2025-01-21 10:18:00', NULL, NULL),
(24, 7, 4, '2025-01-22', 0, '2025-01-22 10:18:00', NULL, NULL),
(25, 8, 5, '2025-01-15', 0, '2025-01-15 10:18:00', NULL, NULL),
(26, 10, 5, '2025-01-12', 0, '2025-01-12 10:18:00', NULL, NULL),
(27, 12, 5, '2025-01-15', 0, '2025-01-15 10:18:00', NULL, NULL),
(28, 13, 5, '2025-01-16', 0, '2025-01-16 10:18:00', NULL, NULL),
(29, 15, 7, '2025-01-08', 0, '2025-01-08 10:18:00', NULL, NULL),
(30, 17, 7, '2025-01-05', 0, '2025-01-05 10:18:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi_templates`
--

CREATE TABLE `notifikasi_templates` (
  `id_template` bigint UNSIGNED NOT NULL,
  `nama_template` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hari_set` int NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifikasi_templates`
--

INSERT INTO `notifikasi_templates` (`id_template`, `nama_template`, `hari_set`, `judul`, `isi`, `created_at`, `updated_at`) VALUES
(1, 'Reminder 3 Hari Sebelum', -3, 'Tagihan Akan Jatuh Tempo', 'Yth. Pelanggan, tagihan #{{id_tagihan}} akan jatuh tempo dalam 3 hari ({{tanggal_jatuh_tempo}}). Total: Rp{{total_tagihan}}. Segera lakukan pembayaran untuk menghindari denda.', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(2, 'Reminder 1 Hari Sebelum', -1, 'Tagihan Akan Jatuh Tempo Besok', 'Yth. Pelanggan, tagihan #{{id_tagihan}} akan jatuh tempo besok ({{tanggal_jatuh_tempo}}). Total: Rp{{total_tagihan}}. Mohon segera lunasi.', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(3, 'Notifikasi Jatuh Tempo', 0, 'Tagihan Jatuh Tempo Hari Ini', 'Yth. Pelanggan, tagihan #{{id_tagihan}} jatuh tempo hari ini. Total: Rp{{total_tagihan}}. Segera lakukan pembayaran.', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(4, 'Notifikasi Terlambat 1 Hari', 1, 'Tagihan Melewati Jatuh Tempo', 'Yth. Pelanggan, tagihan #{{id_tagihan}} telah melewati jatuh tempo. Denda Rp70.000/bulan akan berlaku jika tidak dibayar dalam 24 jam.', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(5, 'Notifikasi Pelunasan', 0, 'Pembayaran Diterima', 'Terima kasih! Pembayaran untuk tagihan #{{id_tagihan}} sebesar Rp{{jumlah_dibayar}} telah diterima pada {{tanggal_bayar}}.', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(7, 'Reminder Peminjaman Aktif', -7, 'Peminjaman Masih Berlangsung', 'Yth. Pelanggan, peminjaman tabung #{{id_tabung}} masih aktif. Jatuh tempo pengembalian: {{tanggal_jatuh_tempo}}. Hindari denda Rp70.000/hari jika terlambat.', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(8, 'Notifikasi Pengembalian', 0, 'Tabung Diterima Kembali', 'Terima kasih! Tabung #{{id_tabung}} telah diterima kembali pada {{tanggal_kembali}}. Kondisi: {{kondisi_tabung}}.', '2025-06-17 02:30:43', '2025-06-17 02:30:43');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peminjamans`
--

CREATE TABLE `peminjamans` (
  `id_peminjaman` bigint UNSIGNED NOT NULL,
  `id_detail_transaksi` bigint UNSIGNED NOT NULL,
  `tanggal_pinjam` datetime DEFAULT NULL,
  `status_pinjam` enum('aktif','selesai') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `peminjamans`
--

INSERT INTO `peminjamans` (`id_peminjaman`, `id_detail_transaksi`, `tanggal_pinjam`, `status_pinjam`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-01-01 00:00:00', 'selesai', NULL, NULL),
(2, 2, '2023-01-01 00:00:00', 'selesai', NULL, NULL),
(3, 5, '2023-01-04 00:00:00', 'selesai', NULL, NULL),
(4, 6, '2023-01-05 00:00:00', 'selesai', NULL, NULL),
(5, 8, '2023-01-07 00:00:00', 'selesai', NULL, NULL),
(6, 11, '2023-01-08 00:00:00', 'selesai', NULL, NULL),
(7, 13, '2023-01-09 00:00:00', 'selesai', NULL, NULL),
(8, 15, '2023-01-10 00:00:00', 'aktif', NULL, NULL),
(9, 18, '2023-01-12 00:00:00', 'aktif', NULL, NULL),
(10, 19, '2023-01-12 00:00:00', 'aktif', NULL, NULL),
(11, 20, '2023-01-12 00:00:00', 'aktif', NULL, NULL),
(12, 21, '2023-01-12 00:00:00', 'aktif', NULL, NULL),
(13, 22, '2023-01-12 00:00:00', 'aktif', NULL, NULL),
(14, 23, '2023-01-13 00:00:00', 'aktif', NULL, NULL),
(15, 25, '2023-01-14 00:00:00', 'aktif', NULL, NULL),
(16, 26, '2023-01-14 00:00:00', 'aktif', NULL, NULL),
(17, 27, '2023-01-14 00:00:00', 'aktif', NULL, NULL),
(18, 28, '2023-01-14 00:00:00', 'aktif', NULL, NULL),
(19, 29, '2023-01-14 00:00:00', 'aktif', NULL, NULL),
(20, 31, '2024-01-15 00:00:00', 'aktif', NULL, NULL),
(21, 32, '2024-01-15 00:00:00', 'aktif', NULL, NULL),
(22, 35, '2024-01-15 00:00:00', 'aktif', NULL, NULL),
(23, 36, '2024-01-15 00:00:00', 'selesai', NULL, NULL),
(24, 39, '2025-01-15 00:00:00', 'selesai', NULL, NULL),
(25, 40, '2026-01-15 00:00:00', 'selesai', NULL, NULL),
(26, 41, '2026-01-15 00:00:00', 'aktif', NULL, NULL),
(27, 43, '2026-01-15 00:00:00', 'aktif', NULL, NULL),
(28, 45, '2026-01-15 00:00:00', 'aktif', NULL, NULL),
(29, 51, '2026-01-15 00:00:00', 'selesai', NULL, NULL),
(30, 52, '2026-01-15 00:00:00', 'selesai', NULL, NULL),
(31, 54, '2026-01-15 00:00:00', 'aktif', NULL, NULL),
(32, 55, '2026-01-15 00:00:00', 'selesai', NULL, NULL),
(33, 56, '2026-01-15 00:00:00', 'selesai', NULL, NULL),
(36, 63, '2025-06-22 00:00:00', 'aktif', '2025-06-22 03:23:00', '2025-06-22 03:23:00'),
(37, 64, '2025-06-23 00:00:00', 'aktif', '2025-06-22 22:47:50', '2025-06-22 22:47:50'),
(38, 65, '2025-06-24 00:00:00', 'aktif', '2025-06-24 00:19:59', '2025-06-24 00:19:59'),
(39, 66, '2025-06-26 00:00:00', 'aktif', '2025-06-26 08:37:24', '2025-06-26 08:37:24'),
(40, 68, '2025-06-26 00:00:00', 'aktif', '2025-06-26 08:40:14', '2025-06-26 08:40:14'),
(41, 69, '2025-06-26 00:00:00', 'aktif', '2025-06-26 09:08:11', '2025-06-26 09:08:11'),
(42, 70, '2025-06-26 00:00:00', 'aktif', '2025-06-26 09:08:11', '2025-06-26 09:08:11'),
(43, 71, '2025-06-26 00:00:00', 'aktif', '2025-06-26 09:14:35', '2025-06-26 09:14:35'),
(44, 72, '2025-06-27 00:00:00', 'aktif', '2025-06-27 01:56:04', '2025-06-27 01:56:04'),
(45, 73, '2025-06-27 00:00:00', 'aktif', '2025-06-27 02:28:35', '2025-06-27 02:28:35'),
(46, 74, '2025-06-27 00:00:00', 'aktif', '2025-06-27 02:49:38', '2025-06-27 02:49:38'),
(47, 75, '2025-06-27 00:00:00', 'aktif', '2025-06-27 02:59:47', '2025-06-27 02:59:47'),
(48, 76, '2025-06-27 00:00:00', 'aktif', '2025-06-27 03:01:57', '2025-06-27 03:01:57'),
(49, 78, '2025-06-30 00:00:00', 'aktif', '2025-06-30 04:47:39', '2025-06-30 04:47:39'),
(50, 80, '2025-06-30 00:00:00', 'aktif', '2025-06-30 06:07:09', '2025-06-30 06:07:09'),
(51, 81, '2025-06-30 00:00:00', 'aktif', '2025-06-30 07:47:32', '2025-06-30 07:47:32'),
(54, 86, '2025-07-02 00:00:00', 'aktif', '2025-07-01 20:27:50', '2025-07-01 20:27:50'),
(55, 88, '2025-07-02 00:00:00', 'aktif', '2025-07-01 20:48:15', '2025-07-01 20:48:15'),
(56, 90, '2025-07-02 00:00:00', 'aktif', '2025-07-01 20:50:13', '2025-07-01 20:50:13'),
(57, 92, '2025-07-02 00:00:00', 'aktif', '2025-07-01 20:55:53', '2025-07-01 20:55:53'),
(58, 93, '2025-07-02 00:00:00', 'aktif', '2025-07-01 21:18:43', '2025-07-01 21:18:43'),
(59, 94, '2025-07-02 00:00:00', 'aktif', '2025-07-01 21:24:50', '2025-07-01 21:24:50'),
(60, 95, '2025-07-02 00:00:00', 'aktif', '2025-07-01 21:25:19', '2025-07-01 21:25:19'),
(61, 96, '2025-07-02 00:00:00', 'aktif', '2025-07-01 21:44:00', '2025-07-01 21:44:00'),
(63, 98, '2025-07-02 00:00:00', 'aktif', '2025-07-01 22:13:03', '2025-07-01 22:13:03'),
(64, 99, '2025-07-02 00:00:00', 'aktif', '2025-07-01 22:19:10', '2025-07-01 22:19:10');

-- --------------------------------------------------------

--
-- Table structure for table `pengembalians`
--

CREATE TABLE `pengembalians` (
  `id_pengembalian` bigint UNSIGNED NOT NULL,
  `id_peminjaman` bigint UNSIGNED NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `kondisi_tabung` enum('baik','rusak') COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengembalians`
--

INSERT INTO `pengembalians` (`id_pengembalian`, `id_peminjaman`, `tanggal_kembali`, `kondisi_tabung`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-01-15', 'baik', 'Pengembalian tepat waktu', NULL, NULL),
(2, 2, '2023-01-16', 'baik', 'Pengembalian normal', NULL, NULL),
(3, 3, '2023-01-19', 'rusak', 'Tabung penyok', NULL, NULL),
(4, 4, '2023-01-20', 'baik', 'Pengembalian sesuai jadwal', NULL, NULL),
(5, 5, '2023-01-22', 'baik', 'Pengembalian dengan isi ulang', NULL, NULL),
(6, 6, '2023-01-23', 'baik', 'Pengembalian bersama tabung isi ulang', NULL, NULL),
(7, 7, '2023-01-25', 'rusak', 'Kebocoran pada valve', NULL, NULL),
(8, 23, '2024-02-18', 'baik', 'Pengembalian terlambat 3 hari', NULL, NULL),
(9, 24, '2024-01-30', 'baik', 'Pengembalian tepat waktu', NULL, NULL),
(10, 25, '2024-01-30', 'baik', 'Pengembalian tepat waktu', NULL, NULL),
(11, 29, '2024-02-20', 'baik', 'Pengembalian terlambat 5 hari', NULL, NULL),
(12, 30, '2024-02-20', 'baik', 'Pengembalian terlambat 5 hari', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `perorangans`
--

CREATE TABLE `perorangans` (
  `id_perorangan` bigint UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telepon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_perusahaan` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `perorangans`
--

INSERT INTO `perorangans` (`id_perorangan`, `nama_lengkap`, `nik`, `no_telepon`, `alamat`, `id_perusahaan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Surendra Adhirajasa Kurnia', '320000000000000001', '082119128578', 'Gang 2 Utara Karangampel', 1, NULL, NULL, NULL),
(2, 'Budi Santoso', '320000000000000002', '081232129321', 'Jl. Setia Budi No.93, Jakarta', 2, NULL, NULL, NULL),
(3, 'Agus Wijaya', '320000000000000003', '81234567892', 'Jl. Thamrin No.12, Surabaya', 3, NULL, NULL, NULL),
(4, 'Dewi Lestari', '320000000000000004', '81234567893', 'Jl. Gatot Subroto No.8, Medan', 4, NULL, NULL, NULL),
(5, 'Hendra Pratama', '320000000000000005', '81234567894', 'Jl. Diponegoro No.33, Semarang', 5, NULL, NULL, NULL),
(6, 'Lina Marlina', '320000000000000006', '81234567895', 'Jl. Ahmad Yani No.78, Yogyakarta', 6, NULL, NULL, NULL),
(7, 'Rudi Hermawan', '320000000000000007', '81234567896', 'Jl. Pahlawan No.56, Bali', 7, NULL, NULL, NULL),
(8, 'Ani Susanti', '320000000000000008', '81234567897', 'Jl. Surya Sumantri No.23, Palembang', 8, NULL, NULL, NULL),
(9, 'Eko Prasetyo', '320000000000000009', '81234567898', 'Jl. Asia Afrika No.67, Makassar', 9, NULL, NULL, NULL),
(10, 'Maya Indah', '32000000000000010', '81234567899', 'Jl. Hayam Wuruk No.89, Malang', 10, NULL, NULL, NULL),
(11, 'Adi Nugroho', '320000000000000011', '81234567800', 'Jl. Pemuda No.34, Bogor', 11, NULL, NULL, NULL),
(12, 'Rina Wijayanti', '320000000000000012', '81234567801', 'Jl. Juanda No.11, Tangerang', 12, NULL, NULL, NULL),
(13, 'Fajar Setiawan', '320000000000000013', '81234567802', 'Jl. Imam Bonjol No.90, Bekasi', 13, NULL, NULL, NULL),
(14, 'Dian Permata', '320000000000000014', '81234567803', 'Jl. Teuku Umar No.77, Depok', 14, NULL, NULL, NULL),
(15, 'Irfan Maulana', '32000000000000015', '81234567804', 'Jl. Cihampelas No.55, Cimahi', 15, NULL, NULL, NULL),
(16, 'Pamungkas', '320000000000000016', '81234567805', 'Jl. Alamanda No. 88, Indramayu', NULL, NULL, NULL, NULL),
(17, 'Raditya Ernis', '320000000000000017', '81234567806', 'Jl. Alamat 17', NULL, NULL, NULL, NULL),
(18, 'Agus Setyo', '320000000000000018', '81234567807', 'Jl. Alamat 18', NULL, NULL, NULL, NULL),
(19, 'Wirawan', '320000000000000019', '81234567808', 'Jl. Alamat 19', NULL, NULL, NULL, NULL),
(20, 'Edi Setiadi', '320000000000000020', '81234567809', 'Jl. Alamat 20', NULL, NULL, NULL, NULL),
(21, 'Supriadi', '320000000000000021', '81234567810', 'Jl. Alamat 21', NULL, NULL, NULL, NULL),
(22, 'Linda Amalia', '320000000000000022', '81234567811', 'Jl. Alamat 22', NULL, NULL, NULL, NULL),
(23, 'Geo Purnomo', '320000000000000023', '81234567812', 'Jl. Alamat 23', NULL, NULL, NULL, NULL),
(24, 'Ajis Prasetyo', '320000000000000024', '81234567813', 'Jl. Alamat 24', NULL, NULL, NULL, NULL),
(25, 'Bagus Sudarma', '320000000000000025', '81234567814', 'Jl. Alamat 25', NULL, NULL, NULL, NULL),
(26, 'Adityo Warjo', '320000000000000026', '81234567815', 'Jl. Alamat 26', NULL, NULL, NULL, NULL),
(27, 'Sukoco', '320000000000000027', '81234567816', 'Jl. Alamat 27', NULL, NULL, NULL, NULL),
(28, 'Dedi Setiadi', '320000000000000028', '81234567817', 'Jl. Alamat 28', NULL, NULL, NULL, NULL),
(29, 'Samsul Maarif', '320000000000000029', '81234567818', 'Jl. Alamat 29', NULL, NULL, NULL, NULL),
(30, 'Dito', '320000000000000030', '81234567819', 'Jl. Alamat 30', NULL, NULL, NULL, NULL),
(31, 'Aditya Sukma Pratama', '3212150806040002', '081355189353', 'Jl. Mayor Sastraatmaja No.37, Indramayu', NULL, NULL, '2025-06-29 22:30:50', NULL),
(32, 'Adinda Putri Fatwanti', '3212140909090001', '081212232334', 'Bangkir', 16, '2025-06-17 02:31:33', '2025-06-17 02:31:57', '2025-06-17 02:31:57'),
(33, 'Adinda Putri Fatwanti', '3212140909090001', '081212232334', 'Bangkir', NULL, '2025-06-17 02:32:50', '2025-06-17 02:33:14', '2025-06-17 02:33:14'),
(34, 'Ragatona Besly', '3212150112040002', '089966554433', 'Margalaksana', NULL, '2025-06-17 02:41:31', '2025-06-17 02:41:31', NULL),
(38, 'Budi Santoso', '1234567890123456', '081234567890', 'Jl. Sudirman No. 1', NULL, '2025-06-22 03:23:00', '2025-06-27 01:55:16', '2025-06-27 01:55:16'),
(40, 'Budi Santoso', '1234567890123456', '081234567890', 'Jl. Sudirman No. 1', NULL, '2025-06-22 22:47:50', '2025-06-22 22:47:50', NULL),
(41, 'Aditya Sukma Pratama', '3212150806040002', '081355189353', 'Jl. Mayor Sastraatmaja No.37, Indramayu', NULL, '2025-06-26 08:37:24', '2025-06-26 09:13:30', '2025-06-26 09:13:30'),
(43, 'Ragatona Besly', '3212150112040002', '089966554433', 'Margalaksana', NULL, '2025-06-26 09:08:11', '2025-06-26 09:13:20', '2025-06-26 09:13:20'),
(45, 'Apriliady Rahman', '3212151603030003', '081245678945', 'Paoman', NULL, '2025-06-27 01:54:53', '2025-06-27 01:54:53', NULL),
(46, 'Moh. Sahrul', '3212153006040006', '08960744568', 'Arahan', 17, '2025-06-27 02:59:01', '2025-06-27 02:59:01', NULL),
(47, 'Adinda Putri Fatwanti', '3215140112040001', '081345678945', 'Bangkir', NULL, '2025-06-30 04:44:16', '2025-06-30 04:44:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(54, 'App\\Models\\Akun', 1, 'auth_token', 'dc5b8d7d1c41951ed63e6d91e50b9d8b040e79ddc7b97f825627719073a3ef00', '[\"*\"]', '2025-06-30 08:01:56', NULL, '2025-06-30 05:11:24', '2025-06-30 08:01:56'),
(55, 'App\\Models\\Akun', 1, 'auth_token', '0e060307f81d61e5d9b6eb5b8a076f853311d51464d66a2018af18f2d236846f', '[\"*\"]', '2025-06-30 06:24:59', NULL, '2025-06-30 06:11:25', '2025-06-30 06:24:59'),
(56, 'App\\Models\\Akun', 1, 'auth_token', 'cd40ebff22a1bef3656a922457c83045300ea5999a19d0062d1325bcd4112d5f', '[\"*\"]', '2025-06-30 07:30:48', NULL, '2025-06-30 07:16:28', '2025-06-30 07:30:48'),
(57, 'App\\Models\\Akun', 1, 'auth_token', '8392564011bcf87f6c5536ef7bd72f9cd8b101887ea6de543b17214f29ed66ca', '[\"*\"]', NULL, NULL, '2025-06-30 07:30:46', '2025-06-30 07:30:46'),
(58, 'App\\Models\\Akun', 1, 'auth_token', '4e9eb1f8a78b7961d7a443021e44f0ad8777a098e63aaeb88b8376d0a12cc67a', '[\"*\"]', '2025-06-30 09:03:44', NULL, '2025-06-30 07:30:54', '2025-06-30 09:03:44'),
(59, 'App\\Models\\Akun', 1, 'auth_token', '3c01b0f6017a089c2b879e236ae2a9c42ed9cdbdcf03e4d40e4d0c8a6c430684', '[\"*\"]', '2025-07-01 22:19:10', NULL, '2025-07-01 04:08:04', '2025-07-01 22:19:10');

-- --------------------------------------------------------

--
-- Table structure for table `perusahaans`
--

CREATE TABLE `perusahaans` (
  `id_perusahaan` bigint UNSIGNED NOT NULL,
  `nama_perusahaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_perusahaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_perusahaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `perusahaans`
--

INSERT INTO `perusahaans` (`id_perusahaan`, `nama_perusahaan`, `alamat_perusahaan`, `email_perusahaan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'CV Laris Jaya Gas', 'Gang 2 Utara Karangampel, Indramayu', 'larisjayagas@gasindustri.com', NULL, NULL, NULL),
(2, 'Tabung Gas Mandiri', 'Jl. Teknologi No.45, Bandung', 'contact@tabungmandiri.com', NULL, NULL, NULL),
(3, 'Berkah Gas Utama', 'Jl. Logistik No.12, Surabaya', 'admin@berkahgas.com', NULL, NULL, NULL),
(4, 'Surya Gas Lestari', 'Jl. Perdagangan No.8, Medan', 'ceo@suryagasteel.com', NULL, NULL, NULL),
(5, 'Prima Gas Nusantara', 'Jl. Niaga No.33, Semarang', 'info@primagas.id', NULL, NULL, NULL),
(6, 'Mitra Gas Sejahtera', 'Jl. Bismo No.78, Yogyakarta', 'support@mitragas.co.id', NULL, NULL, NULL),
(7, 'Karya Gas Makmur', 'Jl. Komplek No.156, Denpasar', 'admin@karyagas.com', NULL, NULL, NULL),
(8, 'Indah Gas Sentosa', 'Jl. Perindustrian No.23, Palembang', 'contact@indahgas.net', NULL, NULL, NULL),
(9, 'Tunggal Gas Perkasa', 'Jl. Strategis No.67, Makassar', 'info@tunggas.co.id', NULL, NULL, NULL),
(10, 'Maju Gas Bersama', 'Jl. Jl. Champlaas No.89, Malang', 'cs@majugas.com', NULL, NULL, NULL),
(11, 'Gas Teknik Nusantara', 'Jl. Engineering No.34, Bogor', 'sales@gasteknik.net', NULL, NULL, NULL),
(12, 'Samudra Gas Indonesia', 'Jl. Industri No.11, Tangerang', 'info@samudragas.co.id', NULL, NULL, NULL),
(13, 'Delta Gas Internasional', 'Jl. Omega No.90, Bekasi', 'contact@deltagas.com', NULL, NULL, NULL),
(14, 'Gas Medika Utama', 'Jl. Kesehatan No.77, Depok', 'support@gasmedika.com', NULL, NULL, NULL),
(15, 'Gas Kimia Nusantara', 'Jl. Science No.55, Cimahi', 'info@gaskimia.co.id', NULL, NULL, NULL),
(16, 'PT Selalu Keluar', 'Jl. Keluar Kalo Ada No.123', 'selalukeluar@gmail.com', '2025-06-17 02:31:33', '2025-06-17 02:31:33', NULL),
(17, 'PT ASMARA', 'Jl. Asmara Hancur No.123', 'asmara@gmail.com', '2025-06-27 02:59:01', '2025-06-27 02:59:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_transaksis`
--

CREATE TABLE `riwayat_transaksis` (
  `id_riwayat_transaksi` bigint UNSIGNED NOT NULL,
  `id_transaksi` bigint UNSIGNED NOT NULL,
  `id_akun` bigint UNSIGNED DEFAULT NULL,
  `id_perorangan` bigint UNSIGNED DEFAULT NULL,
  `id_perusahaan` bigint UNSIGNED DEFAULT NULL,
  `tanggal_transaksi` date NOT NULL,
  `total_transaksi` bigint UNSIGNED NOT NULL,
  `jumlah_dibayar` bigint UNSIGNED NOT NULL,
  `metode_pembayaran` enum('transfer','tunai') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_jatuh_tempo` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `status_akhir` enum('success','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'success',
  `total_pembayaran` bigint UNSIGNED NOT NULL,
  `denda` bigint UNSIGNED NOT NULL,
  `durasi_peminjaman` int DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `riwayat_transaksis`
--

INSERT INTO `riwayat_transaksis` (`id_riwayat_transaksi`, `id_transaksi`, `id_akun`, `id_perorangan`, `id_perusahaan`, `tanggal_transaksi`, `total_transaksi`, `jumlah_dibayar`, `metode_pembayaran`, `tanggal_jatuh_tempo`, `tanggal_selesai`, `status_akhir`, `total_pembayaran`, `denda`, `durasi_peminjaman`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, NULL, '2023-01-01', 325000, 325000, 'tunai', '2023-01-31', '2023-01-15', 'success', 325000, 0, 14, 'Peminjaman oksigen+nitrogen lunas (dikembalikan)', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(2, 4, 5, 4, NULL, '2023-01-04', 150000, 150000, 'tunai', '2023-02-03', '2023-01-19', 'success', 150000, 0, 15, 'Peminjaman oksigen lunas (dikembalikan)', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(3, 5, 6, 5, NULL, '2023-01-05', 150000, 150000, 'transfer', '2023-01-20', '2023-02-04', 'success', 150000, 50000, 15, 'Peminjaman oksigen lunas (tabung rusak)', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(4, 6, 7, 6, NULL, '2023-01-06', 150000, 150000, 'tunai', NULL, '2023-01-06', 'success', 150000, 0, NULL, 'Isi ulang oksigen lunas', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(5, 7, 8, 7, NULL, '2023-01-07', 375000, 375000, 'transfer', '2023-02-06', '2023-01-22', 'success', 375000, 0, 15, 'Peminjaman oksigen + isi ulang argon+aceteline (dikembalikan)', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(6, 8, 9, 8, NULL, '2023-01-08', 225000, 225000, 'tunai', '2023-02-07', '2023-01-23', 'success', 225000, 0, 15, 'Peminjaman aceteline + isi ulang argon (dikembalikan)', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(7, 9, 10, 9, NULL, '2023-01-09', 225000, 225000, 'transfer', '2023-02-08', '2023-01-25', 'success', 225000, 70000, 16, 'Peminjaman aceteline (dikembalikan terlambat)', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(8, 11, 12, 11, NULL, '2023-01-11', 325000, 325000, 'transfer', NULL, '2023-01-11', 'success', 325000, 35000, NULL, 'Isi ulang aceteline+nitrogen lunas (+denda)', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(9, 16, NULL, 16, NULL, '2024-01-15', 325000, 325000, 'transfer', NULL, '2024-02-02', 'success', 325000, 0, 17, 'Peminjaman Oksigen, Nitrogen Kode O001 dan NO001 (lunas)', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(10, 20, NULL, 20, NULL, '2024-01-15', 150000, 245000, 'transfer', '2004-02-15', '2024-02-18', 'success', 150000, 70000, 33, 'Peminjaman Oksigen (denda keterlambatan dibayar lunas)', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(11, 21, NULL, 21, NULL, '2024-01-15', 150000, 150000, 'tunai', NULL, '2024-01-15', 'success', 150000, 0, NULL, 'Perorangan Isi Ulang Oksigen Lunas', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(12, 22, NULL, 22, NULL, '2025-01-15', 725000, 725000, 'transfer', NULL, '2024-01-30', 'success', 725000, 0, 15, 'Perorangan Isi ulang dan Peminjaman (Selesai)', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(13, 26, NULL, 26, NULL, '2025-01-15', 325000, 325000, 'transfer', NULL, '2024-01-15', 'success', 325000, 0, NULL, 'Perorangan Isi Ulang Oksegen dan Nitrogen (Lunas)', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(14, 27, NULL, 27, NULL, '2025-01-15', 1000000, 500000, 'tunai', '2004-02-15', '2024-02-20', 'success', 1000000, 70000, 35, 'Perorangan isi ulang+pinjam pengembalian terlambat + denda (lunas)', '2025-06-17 02:30:43', '2025-06-17 02:30:43'),
(15, 29, NULL, 29, NULL, '2025-01-15', 1000000, 250000, 'tunai', '2004-02-15', '2004-02-25', 'success', 1000000, 70000, 40, 'Perorangan isi ulang+pinjam pengembalian terlambat + denda (lunas)', '2025-06-17 02:30:43', '2025-06-17 02:30:43');

-- --------------------------------------------------------

--
-- Table structure for table `status_tabungs`
--

CREATE TABLE `status_tabungs` (
  `id_status_tabung` bigint UNSIGNED NOT NULL,
  `status_tabung` enum('tersedia','dipinjam','rusak','hilang') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status_tabungs`
--

INSERT INTO `status_tabungs` (`id_status_tabung`, `status_tabung`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'tersedia', NULL, NULL, NULL),
(2, 'dipinjam', NULL, NULL, NULL),
(3, 'rusak', NULL, NULL, NULL),
(4, 'hilang', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `status_transaksis`
--

CREATE TABLE `status_transaksis` (
  `id_status_transaksi` bigint UNSIGNED NOT NULL,
  `status` enum('success','pending','failed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status_transaksis`
--

INSERT INTO `status_transaksis` (`id_status_transaksi`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'success', NULL, NULL, NULL),
(2, 'pending', NULL, NULL, NULL),
(3, 'failed', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tabungs`
--

CREATE TABLE `tabungs` (
  `id_tabung` bigint UNSIGNED NOT NULL,
  `kode_tabung` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_jenis_tabung` bigint UNSIGNED NOT NULL,
  `id_status_tabung` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tabungs`
--

INSERT INTO `tabungs` (`id_tabung`, `kode_tabung`, `id_jenis_tabung`, `id_status_tabung`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'O01', 1, 2, NULL, '2025-06-22 03:23:00', NULL),
(2, 'O02', 1, 2, NULL, '2025-06-22 22:47:50', NULL),
(3, 'O03', 1, 2, NULL, NULL, NULL),
(4, 'O04', 1, 2, NULL, '2025-06-27 01:56:04', NULL),
(5, 'O05', 1, 2, NULL, '2025-06-27 02:28:35', NULL),
(6, 'O06', 1, 2, NULL, NULL, NULL),
(7, 'O07', 1, 2, NULL, NULL, NULL),
(8, 'O08', 1, 2, NULL, NULL, NULL),
(9, 'O09', 1, 2, NULL, NULL, NULL),
(10, 'O10', 1, 2, NULL, '2025-07-01 20:50:13', NULL),
(11, 'O011', 1, 2, NULL, '2025-07-01 22:19:10', NULL),
(12, 'O012', 1, 2, NULL, '2025-06-26 09:14:35', NULL),
(13, 'O013', 1, 2, NULL, '2025-06-27 02:49:38', NULL),
(14, 'O014', 1, 2, NULL, '2025-06-27 02:59:47', NULL),
(15, 'O015', 1, 2, NULL, '2025-07-01 20:50:13', NULL),
(16, 'O016', 1, 2, NULL, '2025-06-27 06:33:18', NULL),
(17, 'O017', 1, 2, NULL, '2025-06-30 04:47:39', NULL),
(18, 'O018', 1, 2, NULL, '2025-06-30 07:47:32', NULL),
(19, 'O019', 1, 2, NULL, '2025-06-30 04:47:39', NULL),
(20, 'O020', 1, 1, NULL, NULL, NULL),
(21, 'OSR01', 1, 1, NULL, NULL, NULL),
(22, 'N01', 2, 2, NULL, NULL, NULL),
(23, 'N02', 2, 2, NULL, '2025-06-30 06:07:09', NULL),
(24, 'N03', 2, 1, NULL, NULL, NULL),
(25, 'N04', 2, 4, NULL, NULL, NULL),
(26, 'N05', 2, 1, NULL, NULL, NULL),
(27, 'N06', 2, 2, NULL, NULL, NULL),
(28, 'N07', 2, 2, NULL, NULL, NULL),
(29, 'N08', 2, 1, NULL, NULL, NULL),
(30, 'N09', 2, 1, NULL, NULL, NULL),
(31, 'N010', 2, 1, NULL, NULL, NULL),
(32, 'N011', 2, 1, NULL, NULL, NULL),
(33, 'N012', 2, 1, NULL, NULL, NULL),
(34, 'N013', 2, 1, NULL, NULL, NULL),
(35, 'N014', 2, 1, NULL, NULL, NULL),
(36, 'N015', 2, 1, NULL, NULL, NULL),
(37, 'N016', 2, 4, NULL, NULL, NULL),
(38, 'N017', 2, 1, NULL, NULL, NULL),
(39, 'N018', 2, 1, NULL, NULL, NULL),
(40, 'N019', 2, 1, NULL, NULL, NULL),
(41, 'N020', 2, 1, NULL, NULL, NULL),
(42, 'NSR01', 2, 1, NULL, NULL, NULL),
(43, 'AR01', 3, 1, NULL, NULL, NULL),
(44, 'AR02', 3, 1, NULL, NULL, NULL),
(45, 'AR03', 3, 1, NULL, NULL, NULL),
(46, 'AR04', 3, 2, NULL, NULL, NULL),
(47, 'AR05', 3, 1, NULL, NULL, NULL),
(48, 'AR06', 3, 2, NULL, NULL, NULL),
(49, 'AR07', 3, 2, NULL, NULL, NULL),
(50, 'AR08', 3, 1, NULL, NULL, NULL),
(51, 'AR09', 3, 1, NULL, NULL, NULL),
(52, 'AR010', 3, 2, NULL, NULL, NULL),
(53, 'AR011', 3, 1, NULL, NULL, NULL),
(54, 'AR012', 3, 1, NULL, NULL, NULL),
(55, 'AR013', 3, 1, NULL, NULL, NULL),
(56, 'AR014', 3, 1, NULL, NULL, NULL),
(57, 'AR015', 3, 1, NULL, NULL, NULL),
(58, 'AR016', 3, 3, NULL, NULL, NULL),
(59, 'AR017', 3, 1, NULL, NULL, NULL),
(60, 'AR018', 3, 1, NULL, NULL, NULL),
(61, 'AR019', 3, 1, NULL, NULL, NULL),
(62, 'AR020', 3, 1, NULL, NULL, NULL),
(63, 'ARSR01', 3, 1, NULL, NULL, NULL),
(64, 'AC01', 4, 1, NULL, NULL, NULL),
(65, 'AC02', 4, 1, NULL, NULL, NULL),
(66, 'AC03', 4, 1, NULL, NULL, NULL),
(67, 'AC04', 4, 1, NULL, NULL, NULL),
(68, 'AC05', 4, 2, NULL, NULL, NULL),
(69, 'AC06', 4, 2, NULL, NULL, NULL),
(70, 'AC07', 4, 1, NULL, NULL, NULL),
(71, 'AC08', 4, 1, NULL, NULL, NULL),
(72, 'AC09', 4, 1, NULL, NULL, NULL),
(73, 'AC010', 4, 1, NULL, NULL, NULL),
(74, 'AC011', 4, 1, NULL, NULL, NULL),
(75, 'AC012', 4, 1, NULL, NULL, NULL),
(76, 'AC013', 4, 1, NULL, NULL, NULL),
(77, 'AC014', 4, 1, NULL, NULL, NULL),
(78, 'AC015', 4, 1, NULL, NULL, NULL),
(79, 'AC016', 4, 1, NULL, NULL, NULL),
(80, 'AC017', 4, 1, NULL, NULL, NULL),
(81, 'AC018', 4, 1, NULL, NULL, NULL),
(82, 'AC019', 4, 1, NULL, NULL, NULL),
(83, 'AC020', 4, 1, NULL, NULL, NULL),
(84, 'ACSR01', 4, 1, NULL, NULL, NULL),
(85, 'N2O01', 5, 1, NULL, NULL, NULL),
(86, 'N2O02', 5, 1, NULL, NULL, NULL),
(87, 'N2O03', 5, 1, NULL, NULL, NULL),
(88, 'N2O04', 5, 1, NULL, NULL, NULL),
(89, 'N2O05', 5, 3, NULL, NULL, NULL),
(90, 'N2O06', 5, 3, NULL, NULL, NULL),
(91, 'N2O07', 5, 1, NULL, NULL, NULL),
(92, 'N2O08', 5, 1, NULL, NULL, NULL),
(93, 'N2O09', 5, 1, NULL, NULL, NULL),
(94, 'N2O010', 5, 1, NULL, NULL, NULL),
(95, 'N2O011', 5, 1, NULL, NULL, NULL),
(96, 'N2O012', 5, 1, NULL, NULL, NULL),
(97, 'N2O013', 5, 1, NULL, NULL, NULL),
(98, 'N2O014', 5, 1, NULL, NULL, NULL),
(99, 'N2O015', 5, 1, NULL, NULL, NULL),
(100, 'N2O016', 5, 1, NULL, NULL, NULL),
(101, 'N2O017', 5, 1, NULL, NULL, NULL),
(102, 'N2O018', 5, 1, NULL, NULL, NULL),
(103, 'N2O019', 5, 1, NULL, NULL, NULL),
(104, 'N2O020', 5, 1, NULL, NULL, NULL),
(105, 'N2OSR01', 5, 1, NULL, NULL, NULL),
(107, 'OX001', 1, 1, '2025-06-18 01:51:42', '2025-06-18 01:51:59', '2025-06-18 01:51:59'),
(108, 'OX002', 1, 1, '2025-06-19 00:46:58', '2025-06-19 01:01:32', '2025-06-19 01:01:32'),
(109, 'OX002', 1, 2, '2025-06-19 01:12:10', '2025-06-26 08:37:24', NULL),
(110, 'OX001', 1, 2, '2025-06-22 06:32:50', '2025-06-26 08:37:24', NULL),
(111, 'OX003', 1, 2, '2025-06-22 06:34:24', '2025-06-26 09:08:11', NULL),
(112, 'OX004', 1, 1, '2025-06-22 06:34:35', '2025-06-26 13:59:25', NULL),
(113, 'OX005', 1, 3, '2025-06-25 20:46:51', '2025-06-25 20:48:24', '2025-06-25 20:48:24'),
(114, 'OX005', 1, 1, '2025-06-25 20:48:58', '2025-06-25 20:48:58', NULL),
(115, 'OX006', 1, 1, '2025-06-26 13:58:37', '2025-06-26 13:58:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tagihans`
--

CREATE TABLE `tagihans` (
  `id_tagihan` bigint UNSIGNED NOT NULL,
  `id_transaksi` bigint UNSIGNED NOT NULL,
  `jumlah_dibayar` decimal(10,2) NOT NULL,
  `sisa` decimal(10,2) NOT NULL,
  `status` enum('lunas','belum_lunas') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_bayar_tagihan` date DEFAULT NULL,
  `hari_keterlambatan` int DEFAULT NULL,
  `periode_ke` int NOT NULL DEFAULT '0',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tagihans`
--

INSERT INTO `tagihans` (`id_tagihan`, `id_transaksi`, `jumlah_dibayar`, `sisa`, `status`, `tanggal_bayar_tagihan`, `hari_keterlambatan`, `periode_ke`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 2, 0.00, 200000.00, 'belum_lunas', NULL, 0, 0, 'Tagihan isi ulang argon - belum_dibayar', NULL, NULL),
(2, 3, 0.00, 175000.00, 'belum_lunas', NULL, 5, 1, 'Tagihan nitrogen - terlambat 5 hari', NULL, NULL),
(3, 10, 50000.00, 100000.00, 'belum_lunas', '2023-01-12', 0, 0, 'Pembayaran sebagian peminjaman oksigen', NULL, NULL),
(4, 12, 500000.00, 450000.00, 'belum_lunas', '2023-01-15', 0, 0, 'Pembayaran awal multiple tabung', NULL, NULL),
(5, 13, 100000.00, 225000.00, 'belum_lunas', '2023-01-16', 0, 0, 'Pembayaran sebagian nitrogen', NULL, NULL),
(6, 14, 0.00, 950000.00, 'belum_lunas', NULL, 10, 1, 'Tagihan multiple tabung - terlambat 10 hari', NULL, NULL),
(7, 15, 0.00, 175000.00, 'belum_lunas', NULL, 7, 1, 'Tagihan nitrogen - terlambat 7 hari', NULL, NULL),
(8, 16, 0.00, 175000.00, 'belum_lunas', NULL, 4, 1, 'Tagihan nitrogen isi ulang - telambat 4 hari', NULL, NULL),
(9, 19, 0.00, 150000.00, 'belum_lunas', NULL, 0, 0, 'Tagihan oksigen pinjam - belum_bayar', NULL, NULL),
(10, 20, 150000.00, 0.00, 'lunas', '2024-02-18', 3, 1, 'Tagihan oksigen pinjam + keterlambatan - sudah lunas', NULL, NULL),
(11, 23, 0.00, 225000.00, 'belum_lunas', NULL, 0, 0, 'Tagihan isi ulang argon dan acetelyn - belum_dibayar', NULL, NULL),
(12, 24, 0.00, 225000.00, 'belum_lunas', NULL, 2, 1, '', NULL, NULL),
(13, 25, 50000.00, 50000.00, 'belum_lunas', NULL, 0, 0, 'Bayar nyicil', NULL, NULL),
(14, 27, 500000.00, 0.00, 'lunas', '2024-02-20', 5, 1, 'Pelunasan tagihan - terlambat 5 hari', NULL, NULL),
(15, 28, 155000.00, 120000.00, 'belum_lunas', NULL, 15, 1, '', NULL, '2025-06-27 07:46:22'),
(16, 29, 750000.00, 0.00, 'lunas', '2004-02-25', 10, 1, 'Pelunasan tagihan + keterlambatan', NULL, NULL),
(17, 30, 100000.00, 75000.00, 'belum_lunas', '2004-02-17', 2, 1, 'Bayar nyicil terlambat', NULL, NULL),
(20, 33, 50000.00, 100000.00, 'belum_lunas', NULL, 0, 1, 'Pembayaran sebagian', '2025-06-22 03:23:00', '2025-06-22 03:23:00'),
(21, 34, 50000.00, 100000.00, 'belum_lunas', NULL, 0, 1, 'Pembayaran sebagian', '2025-06-22 22:47:50', '2025-06-22 22:47:50'),
(22, 35, 150000.00, 0.00, 'lunas', '2025-06-24', 0, 1, 'Pembayaran sebagian', '2025-06-24 00:19:59', '2025-06-24 00:35:06'),
(23, 36, 200000.00, 100000.00, 'belum_lunas', NULL, 0, 1, 'Transaksi dibuat melalui aplikasi', '2025-06-26 08:37:24', '2025-06-26 08:37:24'),
(24, 37, 50000.00, 100000.00, 'belum_lunas', NULL, 0, 1, 'Pembayaran sebagian', '2025-06-26 08:40:14', '2025-06-26 08:40:14'),
(25, 38, 150000.00, 150000.00, 'belum_lunas', NULL, 0, 1, 'Transaksi dibuat melalui aplikasi', '2025-06-26 09:08:11', '2025-06-26 09:08:11'),
(26, 39, 150000.00, 0.00, 'lunas', '2025-06-26', 0, 1, 'Pembayaran sebagian', '2025-06-26 09:14:35', '2025-06-26 09:17:38'),
(27, 40, 150000.00, 0.00, 'lunas', '2025-06-27', 0, 1, 'Transaksi dibuat melalui aplikasi', '2025-06-27 01:56:04', '2025-06-27 01:56:04'),
(28, 41, 15000.00, 135000.00, 'belum_lunas', NULL, 0, 1, 'Transaksi dibuat melalui aplikasi', '2025-06-27 02:28:35', '2025-06-27 02:28:35'),
(29, 42, 150000.00, 0.00, 'lunas', '2025-06-27', 0, 1, 'Transaksi dibuat melalui aplikasi', '2025-06-27 02:49:38', '2025-06-27 02:49:38'),
(30, 43, 150000.00, 0.00, 'lunas', '2025-06-27', 0, 1, 'Transaksi dibuat melalui aplikasi', '2025-06-27 02:59:47', '2025-06-27 02:59:47'),
(31, 44, 150000.00, 0.00, 'lunas', '2025-06-27', 0, 1, 'Transaksi dibuat melalui aplikasi', '2025-06-27 03:01:57', '2025-06-27 03:01:57'),
(32, 45, 150000.00, 0.00, 'lunas', '2025-06-27', 0, 1, 'Transaksi dibuat melalui aplikasi', '2025-06-27 06:33:18', '2025-06-27 06:33:18'),
(33, 46, 300000.00, 0.00, 'lunas', '2025-06-30', 0, 1, 'Transaksi dibuat melalui aplikasi', '2025-06-30 04:47:39', '2025-06-30 05:12:20'),
(34, 47, 100000.00, 75000.00, 'belum_lunas', NULL, 0, 1, 'Transaksi dibuat melalui aplikasi', '2025-06-30 06:07:09', '2025-06-30 06:07:09'),
(35, 48, 50000.00, 100000.00, 'belum_lunas', NULL, 0, 1, 'Transaksi dibuat melalui aplikasi', '2025-06-30 07:47:32', '2025-06-30 07:47:32'),
(38, 51, 200000.00, 0.00, 'lunas', '2025-07-02', NULL, 0, 'Tagihan awal dibuat saat transaksi.', '2025-07-01 20:27:50', '2025-07-01 20:27:50'),
(39, 52, 200000.00, 0.00, 'lunas', '2025-07-02', NULL, 0, 'Tagihan awal dibuat saat transaksi.', '2025-07-01 20:48:15', '2025-07-01 20:48:15'),
(40, 53, 200000.00, 0.00, 'lunas', '2025-07-02', NULL, 0, 'Tagihan awal dibuat saat transaksi.', '2025-07-01 20:50:13', '2025-07-01 20:50:13'),
(41, 54, 50000.00, 100000.00, 'belum_lunas', '2025-07-02', NULL, 0, 'Tagihan awal dibuat saat transaksi.', '2025-07-01 20:55:53', '2025-07-01 20:55:53'),
(42, 54, 100000.00, 0.00, 'lunas', '2025-07-02', NULL, 0, 'Pembayaran cicilan dicatat', '2025-07-01 21:13:43', '2025-07-01 21:13:43'),
(43, 55, 50000.00, 100000.00, 'belum_lunas', '2025-07-02', NULL, 0, 'Tagihan awal dibuat saat transaksi.', '2025-07-01 21:18:43', '2025-07-01 21:18:43'),
(44, 56, 50000.00, 100000.00, 'belum_lunas', '2025-07-02', NULL, 0, 'Tagihan awal dibuat saat transaksi.', '2025-07-01 21:24:50', '2025-07-01 21:24:50'),
(45, 57, 50000.00, 100000.00, 'belum_lunas', '2025-07-02', NULL, 0, 'Tagihan awal dibuat saat transaksi.', '2025-07-01 21:25:19', '2025-07-01 21:25:19'),
(46, 58, 50000.00, 100000.00, 'belum_lunas', '2025-07-02', NULL, 0, 'Tagihan awal dibuat saat transaksi.', '2025-07-01 21:44:00', '2025-07-01 21:44:00'),
(48, 60, 50000.00, 100000.00, 'belum_lunas', '2025-07-02', NULL, 0, 'Tagihan awal dibuat saat transaksi.', '2025-07-01 22:13:03', '2025-07-01 22:13:03'),
(49, 61, 50000.00, 100000.00, 'belum_lunas', '2025-07-02', NULL, 0, 'Tagihan awal dibuat saat transaksi.', '2025-07-01 22:19:10', '2025-07-01 22:19:10');

-- --------------------------------------------------------

--
-- Table structure for table `transaksis`
--

CREATE TABLE `transaksis` (
  `id_transaksi` bigint UNSIGNED NOT NULL,
  `id_akun` bigint UNSIGNED DEFAULT NULL,
  `id_perorangan` bigint UNSIGNED DEFAULT NULL,
  `id_perusahaan` bigint UNSIGNED DEFAULT NULL,
  `tanggal_transaksi` date NOT NULL,
  `waktu_transaksi` time NOT NULL,
  `total_transaksi` bigint UNSIGNED NOT NULL,
  `jumlah_dibayar` bigint UNSIGNED NOT NULL,
  `metode_pembayaran` enum('transfer','tunai') COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_status_transaksi` bigint UNSIGNED NOT NULL,
  `tanggal_jatuh_tempo` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksis`
--

INSERT INTO `transaksis` (`id_transaksi`, `id_akun`, `id_perorangan`, `id_perusahaan`, `tanggal_transaksi`, `waktu_transaksi`, `total_transaksi`, `jumlah_dibayar`, `metode_pembayaran`, `id_status_transaksi`, `tanggal_jatuh_tempo`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, NULL, 1, '2025-05-01', '08:00:00', 325000, 325000, 'tunai', 1, '2025-05-31', '2025-06-17 02:30:43', '2025-06-17 02:30:43', NULL),
(2, 2, NULL, 1, '2025-05-02', '09:30:00', 450000, 225000, 'tunai', 2, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43', NULL),
(3, 3, NULL, 1, '2025-05-03', '10:15:00', 600000, 300000, 'transfer', 2, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43', NULL),
(4, 4, NULL, 1, '2025-05-04', '11:00:00', 150000, 150000, 'tunai', 1, '2025-06-03', '2025-06-17 02:30:43', '2025-06-17 02:30:43', NULL),
(5, 5, NULL, 1, '2025-05-05', '13:45:00', 150000, 150000, 'transfer', 1, '2025-06-04', '2025-06-17 02:30:43', '2025-06-17 02:30:43', NULL),
(6, 6, NULL, 1, '2025-05-06', '14:30:00', 150000, 150000, 'tunai', 1, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43', NULL),
(7, 7, NULL, 1, '2025-05-07', '15:00:00', 375000, 375000, 'transfer', 1, '2025-06-06', '2025-06-17 02:30:43', '2025-06-17 02:30:43', NULL),
(8, 8, NULL, 1, '2025-05-08', '16:15:00', 225000, 225000, 'tunai', 1, '2025-06-07', '2025-06-17 02:30:43', '2025-06-17 02:30:43', NULL),
(9, 9, NULL, 1, '2025-05-09', '09:00:00', 225000, 225000, 'transfer', 1, '2025-06-08', '2025-06-17 02:30:43', '2025-06-17 02:30:43', NULL),
(10, 10, NULL, 1, '2025-05-10', '10:30:00', 50000, 50000, 'tunai', 1, '2025-06-09', '2025-06-17 02:30:43', '2025-06-17 02:30:43', NULL),
(11, 11, NULL, 1, '2025-05-11', '11:45:00', 325000, 325000, 'transfer', 1, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43', NULL),
(12, 12, NULL, 1, '2025-05-12', '13:00:00', 500000, 500000, 'tunai', 1, '2025-06-11', '2025-06-17 02:30:43', '2025-06-17 02:30:43', NULL),
(13, 13, NULL, 1, '2025-05-13', '14:15:00', 100000, 100000, 'transfer', 1, '2025-06-12', '2025-06-17 02:30:43', '2025-06-17 02:30:43', NULL),
(14, 14, NULL, 1, '2025-05-14', '15:30:00', 750000, 375000, 'tunai', 3, '2025-06-13', '2025-06-17 02:30:43', '2025-06-17 02:30:43', NULL),
(15, 15, NULL, 1, '2025-05-15', '16:45:00', 800000, 400000, 'transfer', 3, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43', NULL),
(16, NULL, 16, 1, '2025-05-14', '11:20:00', 325000, 325000, 'transfer', 1, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43', NULL),
(17, NULL, 17, 1, '2025-05-15', '10:00:00', 275000, 137500, 'tunai', 2, '2025-06-14', '2025-06-17 02:30:43', '2025-06-17 02:30:43', NULL),
(18, NULL, 18, 1, '2025-05-14', '10:00:00', 300000, 150000, 'tunai', 2, '2025-06-13', '2025-06-17 02:30:43', '2025-06-17 02:30:43', NULL),
(19, NULL, 19, 1, '2025-05-15', '10:00:00', 350000, 175000, 'tunai', 2, '2025-06-14', '2025-06-17 02:30:43', '2025-06-17 02:30:43', NULL),
(20, NULL, 20, 1, '2025-05-14', '10:00:00', 400000, 400000, 'transfer', 1, '2025-06-13', '2025-06-17 02:30:43', '2025-06-17 02:30:43', NULL),
(21, NULL, 21, 1, '2025-05-15', '10:00:00', 150000, 150000, 'tunai', 1, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43', NULL),
(22, NULL, 22, 1, '2025-05-14', '10:00:00', 725000, 725000, 'transfer', 1, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43', NULL),
(23, NULL, 23, 1, '2025-05-15', '10:00:00', 225000, 200000, 'tunai', 2, '2025-06-14', '2025-06-17 02:30:43', '2025-06-17 02:30:43', NULL),
(24, NULL, 24, 1, '2025-05-14', '10:00:00', 250000, 125000, 'tunai', 2, '2025-06-13', '2025-06-17 02:30:43', '2025-06-17 02:30:43', NULL),
(25, NULL, 25, 1, '2025-05-15', '10:00:00', 75000, 50000, 'tunai', 2, '2025-06-14', '2025-06-17 02:30:43', '2025-06-17 02:30:43', NULL),
(26, NULL, 26, 1, '2025-05-14', '10:00:00', 325000, 325000, 'transfer', 1, NULL, '2025-06-17 02:30:43', '2025-06-17 02:30:43', NULL),
(27, NULL, 27, 1, '2025-05-15', '10:00:00', 500000, 500000, 'tunai', 1, '2025-06-14', '2025-06-17 02:30:43', '2025-06-17 02:30:43', NULL),
(28, NULL, 28, 1, '2025-05-14', '10:00:00', 275000, 155000, 'transfer', 2, '2025-06-13', '2025-06-17 02:30:43', '2025-06-27 07:46:22', NULL),
(29, NULL, 29, 1, '2025-05-15', '10:00:00', 325000, 250000, 'tunai', 1, '2025-06-14', '2025-06-17 02:30:43', '2025-06-17 02:30:43', NULL),
(30, NULL, 30, 1, '2025-05-14', '10:00:00', 175000, 175000, 'tunai', 2, '2025-06-13', '2025-06-17 02:30:43', '2025-06-17 02:30:43', NULL),
(33, 2, 31, NULL, '2025-06-22', '17:30:00', 100000, 75000, 'tunai', 2, '2025-07-22', '2025-06-22 03:23:00', '2025-06-22 03:32:18', NULL),
(34, NULL, 40, NULL, '2025-06-23', '05:47:50', 150000, 50000, 'tunai', 2, '2025-07-23', '2025-06-22 22:47:50', '2025-06-22 22:47:50', NULL),
(35, NULL, 31, NULL, '2025-06-24', '07:19:59', 150000, 150000, 'tunai', 1, '2025-07-24', '2025-06-24 00:19:59', '2025-06-24 00:35:06', NULL),
(36, NULL, 41, NULL, '2025-06-26', '15:37:24', 300000, 200000, 'tunai', 2, '2025-07-26', '2025-06-26 08:37:24', '2025-06-26 08:37:24', NULL),
(37, NULL, 31, NULL, '2025-06-26', '15:40:14', 150000, 50000, 'tunai', 2, '2025-07-26', '2025-06-26 08:40:14', '2025-06-26 08:40:14', NULL),
(38, NULL, 43, NULL, '2025-06-26', '16:08:11', 300000, 150000, 'tunai', 2, '2025-07-26', '2025-06-26 09:08:11', '2025-06-26 09:08:11', NULL),
(39, NULL, 31, NULL, '2025-06-26', '16:14:35', 150000, 150000, 'tunai', 1, '2025-07-26', '2025-06-26 09:14:35', '2025-06-26 09:17:38', NULL),
(40, NULL, NULL, NULL, '2025-06-27', '08:56:04', 150000, 150000, 'transfer', 2, '2025-07-27', '2025-06-27 01:56:04', '2025-06-27 01:56:04', NULL),
(41, NULL, 45, NULL, '2025-06-27', '09:28:35', 150000, 15000, 'tunai', 2, '2025-07-27', '2025-06-27 02:28:35', '2025-06-27 02:28:35', NULL),
(42, NULL, 45, NULL, '2025-06-27', '09:49:38', 150000, 150000, 'tunai', 2, '2025-07-27', '2025-06-27 02:49:38', '2025-06-27 02:49:38', NULL),
(43, NULL, 46, NULL, '2025-06-27', '09:59:47', 150000, 150000, 'tunai', 2, '2025-07-27', '2025-06-27 02:59:47', '2025-06-27 02:59:47', NULL),
(44, NULL, 46, NULL, '2025-06-27', '10:01:57', 150000, 150000, 'tunai', 2, '2025-07-27', '2025-06-27 03:01:57', '2025-06-27 03:01:57', NULL),
(45, NULL, 45, NULL, '2025-06-27', '13:33:18', 150000, 150000, 'tunai', 2, NULL, '2025-06-27 06:33:18', '2025-06-27 06:33:18', NULL),
(46, NULL, 47, NULL, '2025-06-30', '11:47:39', 300000, 300000, 'tunai', 1, '2025-07-30', '2025-06-30 04:47:39', '2025-06-30 05:12:20', NULL),
(47, NULL, 47, NULL, '2025-06-30', '13:07:09', 175000, 100000, 'tunai', 2, '2025-07-30', '2025-06-30 06:07:09', '2025-06-30 06:07:09', NULL),
(48, NULL, 47, NULL, '2025-06-30', '14:47:32', 150000, 50000, 'tunai', 2, '2025-07-30', '2025-06-30 07:47:32', '2025-06-30 07:47:32', NULL),
(51, 18, 46, NULL, '2025-07-02', '03:27:50', 200000, 200000, 'tunai', 1, '2025-08-01', '2025-07-01 20:27:50', '2025-07-01 20:27:50', NULL),
(52, 18, 46, NULL, '2025-07-02', '03:48:15', 200000, 200000, 'tunai', 1, '2025-08-01', '2025-07-01 20:48:15', '2025-07-01 20:48:15', NULL),
(53, 18, 46, NULL, '2025-07-02', '03:50:13', 200000, 200000, 'tunai', 1, '2025-08-01', '2025-07-01 20:50:13', '2025-07-01 20:50:13', NULL),
(54, 2, 31, NULL, '2025-07-02', '03:55:53', 150000, 150000, 'transfer', 1, '2025-08-01', '2025-07-01 20:55:53', '2025-07-01 21:13:43', NULL),
(55, 4, 3, NULL, '2025-07-02', '04:18:43', 150000, 50000, 'transfer', 2, '2025-08-01', '2025-07-01 21:18:43', '2025-07-01 21:18:43', NULL),
(56, 4, 3, NULL, '2025-07-02', '04:24:50', 150000, 50000, 'transfer', 2, '2025-08-01', '2025-07-01 21:24:50', '2025-07-01 21:24:50', NULL),
(57, 4, 3, NULL, '2025-07-02', '04:25:19', 150000, 50000, 'transfer', 2, '2025-08-01', '2025-07-01 21:25:19', '2025-07-01 21:25:19', NULL),
(58, NULL, 34, NULL, '2025-07-02', '04:44:00', 150000, 50000, 'transfer', 2, '2025-08-01', '2025-07-01 21:44:00', '2025-07-01 21:44:00', NULL),
(60, 4, 3, NULL, '2025-07-02', '05:13:03', 150000, 50000, 'transfer', 2, '2025-08-01', '2025-07-01 22:13:03', '2025-07-01 22:13:03', NULL),
(61, 4, 3, NULL, '2025-07-02', '05:19:10', 150000, 50000, 'transfer', 2, '2025-08-01', '2025-07-01 22:19:10', '2025-07-01 22:19:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akuns`
--
ALTER TABLE `akuns`
  ADD PRIMARY KEY (`id_akun`),
  ADD UNIQUE KEY `akuns_email_unique` (`email`),
  ADD UNIQUE KEY `akuns_id_perorangan_unique` (`id_perorangan`);

--
-- Indexes for table `detail_transaksis`
--
ALTER TABLE `detail_transaksis`
  ADD PRIMARY KEY (`id_detail_transaksi`),
  ADD KEY `detail_transaksis_id_transaksi_foreign` (`id_transaksi`),
  ADD KEY `detail_transaksis_id_tabung_foreign` (`id_tabung`),
  ADD KEY `detail_transaksis_id_jenis_transaksi_foreign` (`id_jenis_transaksi`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jenis_tabungs`
--
ALTER TABLE `jenis_tabungs`
  ADD PRIMARY KEY (`id_jenis_tabung`);

--
-- Indexes for table `jenis_transaksis`
--
ALTER TABLE `jenis_transaksis`
  ADD PRIMARY KEY (`id_jenis_transaksi`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasis`
--
ALTER TABLE `notifikasis`
  ADD PRIMARY KEY (`id_notifikasi`),
  ADD KEY `notifikasis_id_tagihan_foreign` (`id_tagihan`),
  ADD KEY `notifikasis_id_template_foreign` (`id_template`);

--
-- Indexes for table `notifikasi_templates`
--
ALTER TABLE `notifikasi_templates`
  ADD PRIMARY KEY (`id_template`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `peminjamans`
--
ALTER TABLE `peminjamans`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `peminjamans_id_detail_transaksi_foreign` (`id_detail_transaksi`);

--
-- Indexes for table `pengembalians`
--
ALTER TABLE `pengembalians`
  ADD PRIMARY KEY (`id_pengembalian`),
  ADD KEY `pengembalians_id_peminjaman_foreign` (`id_peminjaman`);

--
-- Indexes for table `perorangans`
--
ALTER TABLE `perorangans`
  ADD PRIMARY KEY (`id_perorangan`),
  ADD KEY `perorangans_id_perusahaan_foreign` (`id_perusahaan`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `perusahaans`
--
ALTER TABLE `perusahaans`
  ADD PRIMARY KEY (`id_perusahaan`);

--
-- Indexes for table `riwayat_transaksis`
--
ALTER TABLE `riwayat_transaksis`
  ADD PRIMARY KEY (`id_riwayat_transaksi`),
  ADD KEY `riwayat_transaksis_id_transaksi_foreign` (`id_transaksi`),
  ADD KEY `riwayat_transaksis_id_akun_foreign` (`id_akun`),
  ADD KEY `riwayat_transaksis_id_perorangan_foreign` (`id_perorangan`),
  ADD KEY `riwayat_transaksis_id_perusahaan_foreign` (`id_perusahaan`);

--
-- Indexes for table `status_tabungs`
--
ALTER TABLE `status_tabungs`
  ADD PRIMARY KEY (`id_status_tabung`);

--
-- Indexes for table `status_transaksis`
--
ALTER TABLE `status_transaksis`
  ADD PRIMARY KEY (`id_status_transaksi`);

--
-- Indexes for table `tabungs`
--
ALTER TABLE `tabungs`
  ADD PRIMARY KEY (`id_tabung`),
  ADD KEY `tabungs_id_jenis_tabung_foreign` (`id_jenis_tabung`),
  ADD KEY `tabungs_id_status_tabung_foreign` (`id_status_tabung`);

--
-- Indexes for table `tagihans`
--
ALTER TABLE `tagihans`
  ADD PRIMARY KEY (`id_tagihan`),
  ADD KEY `tagihans_id_transaksi_foreign` (`id_transaksi`);

--
-- Indexes for table `transaksis`
--
ALTER TABLE `transaksis`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `transaksis_id_akun_foreign` (`id_akun`),
  ADD KEY `transaksis_id_perorangan_foreign` (`id_perorangan`),
  ADD KEY `transaksis_id_perusahaan_foreign` (`id_perusahaan`),
  ADD KEY `transaksis_id_status_transaksi_foreign` (`id_status_transaksi`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akuns`
--
ALTER TABLE `akuns`
  MODIFY `id_akun` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `detail_transaksis`
--
ALTER TABLE `detail_transaksis`
  MODIFY `id_detail_transaksi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jenis_tabungs`
--
ALTER TABLE `jenis_tabungs`
  MODIFY `id_jenis_tabung` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jenis_transaksis`
--
ALTER TABLE `jenis_transaksis`
  MODIFY `id_jenis_transaksi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `notifikasis`
--
ALTER TABLE `notifikasis`
  MODIFY `id_notifikasi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `notifikasi_templates`
--
ALTER TABLE `notifikasi_templates`
  MODIFY `id_template` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `peminjamans`
--
ALTER TABLE `peminjamans`
  MODIFY `id_peminjaman` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `pengembalians`
--
ALTER TABLE `pengembalians`
  MODIFY `id_pengembalian` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `perorangans`
--
ALTER TABLE `perorangans`
  MODIFY `id_perorangan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `perusahaans`
--
ALTER TABLE `perusahaans`
  MODIFY `id_perusahaan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `riwayat_transaksis`
--
ALTER TABLE `riwayat_transaksis`
  MODIFY `id_riwayat_transaksi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `status_tabungs`
--
ALTER TABLE `status_tabungs`
  MODIFY `id_status_tabung` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `status_transaksis`
--
ALTER TABLE `status_transaksis`
  MODIFY `id_status_transaksi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tabungs`
--
ALTER TABLE `tabungs`
  MODIFY `id_tabung` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `tagihans`
--
ALTER TABLE `tagihans`
  MODIFY `id_tagihan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `transaksis`
--
ALTER TABLE `transaksis`
  MODIFY `id_transaksi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `akuns`
--
ALTER TABLE `akuns`
  ADD CONSTRAINT `akuns_id_perorangan_foreign` FOREIGN KEY (`id_perorangan`) REFERENCES `perorangans` (`id_perorangan`) ON DELETE CASCADE;

--
-- Constraints for table `detail_transaksis`
--
ALTER TABLE `detail_transaksis`
  ADD CONSTRAINT `detail_transaksis_id_jenis_transaksi_foreign` FOREIGN KEY (`id_jenis_transaksi`) REFERENCES `jenis_transaksis` (`id_jenis_transaksi`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_transaksis_id_tabung_foreign` FOREIGN KEY (`id_tabung`) REFERENCES `tabungs` (`id_tabung`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_transaksis_id_transaksi_foreign` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksis` (`id_transaksi`) ON DELETE CASCADE;

--
-- Constraints for table `notifikasis`
--
ALTER TABLE `notifikasis`
  ADD CONSTRAINT `notifikasis_id_tagihan_foreign` FOREIGN KEY (`id_tagihan`) REFERENCES `tagihans` (`id_tagihan`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifikasis_id_template_foreign` FOREIGN KEY (`id_template`) REFERENCES `notifikasi_templates` (`id_template`) ON DELETE CASCADE;

--
-- Constraints for table `peminjamans`
--
ALTER TABLE `peminjamans`
  ADD CONSTRAINT `peminjamans_id_detail_transaksi_foreign` FOREIGN KEY (`id_detail_transaksi`) REFERENCES `detail_transaksis` (`id_detail_transaksi`) ON DELETE CASCADE;

--
-- Constraints for table `pengembalians`
--
ALTER TABLE `pengembalians`
  ADD CONSTRAINT `pengembalians_id_peminjaman_foreign` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjamans` (`id_peminjaman`) ON DELETE CASCADE;

--
-- Constraints for table `perorangans`
--
ALTER TABLE `perorangans`
  ADD CONSTRAINT `perorangans_id_perusahaan_foreign` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaans` (`id_perusahaan`) ON DELETE SET NULL;

--
-- Constraints for table `riwayat_transaksis`
--
ALTER TABLE `riwayat_transaksis`
  ADD CONSTRAINT `riwayat_transaksis_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akuns` (`id_akun`) ON DELETE SET NULL,
  ADD CONSTRAINT `riwayat_transaksis_id_perorangan_foreign` FOREIGN KEY (`id_perorangan`) REFERENCES `perorangans` (`id_perorangan`) ON DELETE SET NULL,
  ADD CONSTRAINT `riwayat_transaksis_id_perusahaan_foreign` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaans` (`id_perusahaan`) ON DELETE SET NULL,
  ADD CONSTRAINT `riwayat_transaksis_id_transaksi_foreign` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksis` (`id_transaksi`) ON DELETE CASCADE;

--
-- Constraints for table `tabungs`
--
ALTER TABLE `tabungs`
  ADD CONSTRAINT `tabungs_id_jenis_tabung_foreign` FOREIGN KEY (`id_jenis_tabung`) REFERENCES `jenis_tabungs` (`id_jenis_tabung`) ON DELETE CASCADE,
  ADD CONSTRAINT `tabungs_id_status_tabung_foreign` FOREIGN KEY (`id_status_tabung`) REFERENCES `status_tabungs` (`id_status_tabung`) ON DELETE CASCADE;

--
-- Constraints for table `tagihans`
--
ALTER TABLE `tagihans`
  ADD CONSTRAINT `tagihans_id_transaksi_foreign` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksis` (`id_transaksi`);

--
-- Constraints for table `transaksis`
--
ALTER TABLE `transaksis`
  ADD CONSTRAINT `transaksis_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akuns` (`id_akun`) ON DELETE SET NULL,
  ADD CONSTRAINT `transaksis_id_perorangan_foreign` FOREIGN KEY (`id_perorangan`) REFERENCES `perorangans` (`id_perorangan`) ON DELETE SET NULL,
  ADD CONSTRAINT `transaksis_id_perusahaan_foreign` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaans` (`id_perusahaan`) ON DELETE SET NULL,
  ADD CONSTRAINT `transaksis_id_status_transaksi_foreign` FOREIGN KEY (`id_status_transaksi`) REFERENCES `status_transaksis` (`id_status_transaksi`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
