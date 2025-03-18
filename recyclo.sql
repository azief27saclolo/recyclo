-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2025 at 02:45 PM
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
-- Database: `recyclo`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$12$rl71nNaYRaGZEtWVvXOcDeEDnurcu.RFpwvUCkQEVbiJD9Br9jcla', '2025-03-16 16:27:27', '2025-03-16 16:27:27');

-- --------------------------------------------------------

--
-- Table structure for table `buys`
--

CREATE TABLE `buys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit` varchar(10) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `buys`
--

INSERT INTO `buys` (`id`, `user_id`, `category`, `quantity`, `unit`, `description`, `created_at`, `updated_at`) VALUES
(2, 11, 'Plastic', 10, 'kg', 'Buying any plastic bottles', '2025-03-05 09:14:32', '2025-03-05 09:14:32'),
(3, 11, 'Plastic', 5, 'dz', 'Buying empty plastic bottles', '2025-03-17 19:00:24', '2025-03-17 19:00:24'),
(4, 11, 'Metal', 5, 'pc', 'Buy metal rods', '2025-03-17 19:30:04', '2025-03-17 19:30:04'),
(5, 11, 'Paper', 10, 'pc', 'Buy any paper', '2025-03-17 19:34:37', '2025-03-17 19:34:37'),
(6, 11, 'Glass', 15, 'pc', 'Buy glass bottles', '2025-03-17 19:35:01', '2025-03-17 19:35:01');

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
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('active','completed','abandoned') NOT NULL DEFAULT 'active',
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `status`, `total`, `created_at`, `updated_at`) VALUES
(1, 11, 'active', 1.00, '2025-03-18 12:00:07', '2025-03-18 13:00:07');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1.00, '2025-03-18 13:00:07', '2025-03-18 13:00:07');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `post_id`, `created_at`, `updated_at`) VALUES
(21, 11, 20, NULL, NULL),
(22, 11, 20, NULL, NULL),
(23, 11, 14, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
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
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_11_24_145731_create_posts_table', 1),
(5, '2024_12_06_175333_add_description_to_posts_table', 2),
(6, '2024_12_06_204351_create_orders_table', 3),
(7, '2024_12_06_205014_add_quantity_to_orders_table', 4),
(8, '2024_12_06_205607_add_quantity_to_orders_table', 5),
(9, '2023_10_10_000000_create_reviews_table', 6),
(10, '2023_10_10_000003_create_favorites_table', 7),
(11, '2023_10_10_000000_create_buys_table', 8),
(12, '2023_10_10_000000_add_unit_to_buys_table', 9),
(13, '2024_06_15_000000_add_birthday_field_to_users_table', 10),
(14, '2023_11_01_000000_create_shops_table', 11),
(15, '2023_11_02_000000_add_location_to_users_table', 12),
(16, '2023_11_03_000000_remove_business_permit_path_from_shops_table', 13),
(17, '2023_10_20_000000_create_admins_table', 14),
(18, '2023_10_20_000001_create_orders_table', 15),
(19, '2023_10_20_100000_create_order_items_table', 16),
(20, '2023_10_21_000000_add_status_to_users_table', 17),
(21, '2023_10_22_000000_ensure_total_amount_in_orders_table', 18),
(22, '2024_06_15_100000_update_reviews_table_structure', 19),
(23, '2024_06_15_200000_add_rating_column_to_reviews_table', 20),
(24, '2024_03_18_000000_add_status_and_total_amount_to_orders_table', 21),
(25, '2023_05_25_000000_create_carts_table', 22),
(27, '2023_05_24_000000_create_products_table', 23),
(28, '2023_05_25_000001_create_cart_items_table', 23),
(29, '2024_05_30_000000_add_post_id_to_products_table', 24);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `buyer_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `seller_id`, `buyer_id`, `post_id`, `quantity`, `status`, `created_at`, `updated_at`, `total_amount`) VALUES
(1, 1, 1, 3, '5', 'pending', '2024-12-06 13:40:03', '2024-12-06 13:40:03', 0.00),
(2, 1, 8, 3, '5', 'pending', '2024-12-06 19:46:15', '2024-12-06 19:46:15', 0.00),
(3, 1, 9, 3, '5', 'pending', '2024-12-06 20:24:07', '2024-12-06 20:24:07', 0.00),
(4, 1, 9, 3, '20', 'pending', '2024-12-06 20:50:50', '2024-12-06 20:50:50', 0.00),
(5, 1, 11, 3, '1', 'pending', '2025-02-19 08:46:57', '2025-02-19 08:46:57', 0.00),
(6, 1, 11, 5, '1', 'pending', '2025-03-17 21:12:48', '2025-03-17 21:12:48', 0.00),
(7, 1, 11, 5, '1', 'pending', '2025-03-17 21:16:22', '2025-03-17 21:16:22', 0.00),
(8, 1, 11, 5, '1', 'pending', '2025-03-17 22:00:28', '2025-03-17 22:00:28', 55.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('azief27saclolo@gmail.com', '$2y$12$/vGx45vNLc4ytIrjERzc/eDz1AwGDa0D7r/QGbtcFQRX0T6.jK8Nm', '2024-12-05 23:16:55');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `category`, `location`, `unit`, `price`, `quantity`, `description`, `image`, `created_at`, `updated_at`) VALUES
(3, 1, 'Selling Plastic', 'Plastic', 'Canelar, Zamboanga City', '', '20', '', '', 'posts_images/OnnMriXgsM8RKKW8yYavUPdDR2t9H3CU5NQw3Prn.jpg', '2024-12-04 23:07:16', '2024-12-04 23:22:15'),
(5, 1, 'Email post', 'metal', 'Canelar, Zamboanga City', '', '20', '', '', 'posts_images/UDv1hAW2IA2lP6zt4WvWkQw20N3rkIhLBwJGLlSd.jpg', '2024-12-05 07:14:29', '2024-12-05 07:14:29'),
(6, 1, 'email post test', 'metal', 'asdasd', '', '20', '', '', 'posts_images/yuj7LkcNgSjvzhHglRrcINM43cdzXYf2MpDV1O5b.jpg', '2024-12-05 07:22:45', '2024-12-05 07:22:45'),
(7, 1, 'email test', 'metal', 'Canelar, Zamboanga City', '', '12', '', '', 'posts_images/tAQDbpXQ4HuOlsUJshbGt2QjqfixWgNVzvAnEtZz.jpg', '2024-12-05 07:24:26', '2024-12-05 07:24:26'),
(8, 7, 'Selling Plastic Waste', 'Plastic', 'Camino Nuevo, Zamboanga City', '', '30', '', '', 'posts_images/1BHCsyGwTcBS7x0uoFxdd6VHALTEFuMi0Nb6fQ5H.jpg', '2024-12-05 23:21:42', '2024-12-05 23:23:35'),
(9, 1, 'Selling used bond paper', 'Paper', 'Canelar, Zamboanga City', '', '20', '', '', 'posts_images/kdHCVa14vdraXBgoLyBsYWzJUudxiqEcFFLgVCpP.jpg', '2024-12-06 04:31:22', '2024-12-06 04:31:22'),
(10, 1, 'Selling used bond paper', 'Paper', 'Canelar, Zamboanga City', '', '20', '', '', 'posts_images/RHaJSdu94RFWrnUeYFcNL0TddwMQvHeK8iVozP5R.jpg', '2024-12-06 04:32:25', '2024-12-06 04:32:25'),
(14, 8, 'Selling Metal Cans', 'Metal', 'San Jose, Gusu', '', '15', '', 'Selling crushed metal cans', 'posts_images/3CQN7nLHwBSsFm8sHG8QrMKHCGh9n6KB8NoFVM6n.jpg', '2024-12-06 19:20:35', '2024-12-06 19:20:35'),
(16, 8, 'Selling Plastic Bottles', 'Plastic', 'San Jose, Gusu', '', '20', '', 'selling plastic', 'posts_images/rlfPXGKid8l42WSCqVNSp6rfcGorbWGAtGuEAXJg.jpg', '2024-12-06 19:37:29', '2024-12-06 19:42:56'),
(18, 9, 'Jaydee', 'Metal', 'Jaydee', '', '10000', '', 'selling jaydee', 'posts_images/d4xUksGLjPSO9HBnYMN0Ojmfjhgr0gtO9vTvHAy7.jpg', '2024-12-06 20:48:16', '2024-12-06 20:48:16'),
(20, 11, 'Used News Paper', 'Paper', 'Canelar, Zamboanga City', 'pc', '1', '100', 'Selling used news paper for recycling or other purposes.', 'posts_images/eafnP5qFIPOewle98HTWrRjeMKAZoMlu142BNRq8.jpg', '2025-03-17 16:50:11', '2025-03-17 16:50:11');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(191) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `stock`, `user_id`, `post_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Used News Paper', 'Selling used news paper for recycling or other purposes.', 1.00, 'posts_images/eafnP5qFIPOewle98HTWrRjeMKAZoMlu142BNRq8.jpg', 100, 11, NULL, 1, '2025-03-18 12:53:36', '2025-03-18 12:53:36'),
(2, 'Jaydee', 'selling jaydee', 10000.00, 'posts_images/d4xUksGLjPSO9HBnYMN0Ojmfjhgr0gtO9vTvHAy7.jpg', 1, 9, NULL, 1, '2025-03-18 12:59:55', '2025-03-18 12:59:55'),
(3, 'Selling Plastic Bottles', 'selling plastic', 20.00, 'posts_images/rlfPXGKid8l42WSCqVNSp6rfcGorbWGAtGuEAXJg.jpg', 1, 8, NULL, 1, '2025-03-18 12:59:55', '2025-03-18 12:59:55'),
(4, 'Selling Metal Cans', 'Selling crushed metal cans', 15.00, 'posts_images/3CQN7nLHwBSsFm8sHG8QrMKHCGh9n6KB8NoFVM6n.jpg', 1, 8, NULL, 1, '2025-03-18 12:59:55', '2025-03-18 12:59:55'),
(5, 'Selling used bond paper', '', 20.00, 'posts_images/RHaJSdu94RFWrnUeYFcNL0TddwMQvHeK8iVozP5R.jpg', 1, 1, NULL, 1, '2025-03-18 12:59:55', '2025-03-18 12:59:55'),
(6, 'Selling Plastic Waste', '', 30.00, 'posts_images/1BHCsyGwTcBS7x0uoFxdd6VHALTEFuMi0Nb6fQ5H.jpg', 1, 7, NULL, 1, '2025-03-18 12:59:55', '2025-03-18 12:59:55'),
(7, 'email test', '', 12.00, 'posts_images/tAQDbpXQ4HuOlsUJshbGt2QjqfixWgNVzvAnEtZz.jpg', 1, 1, NULL, 1, '2025-03-18 12:59:55', '2025-03-18 12:59:55'),
(8, 'email post test', '', 20.00, 'posts_images/yuj7LkcNgSjvzhHglRrcINM43cdzXYf2MpDV1O5b.jpg', 1, 1, NULL, 1, '2025-03-18 12:59:55', '2025-03-18 12:59:55'),
(9, 'Email post', '', 20.00, 'posts_images/UDv1hAW2IA2lP6zt4WvWkQw20N3rkIhLBwJGLlSd.jpg', 1, 1, NULL, 1, '2025-03-18 12:59:55', '2025-03-18 12:59:55');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `review` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `seller_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL DEFAULT 5
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
('kuemjJjwASPbRGmr3ZJLpAFb29AvmhyBJsMNap79', 11, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36 OPR/117.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYkFQOFBYRXEyMmxCdkJyTkFYamJiM0tBQ1lYWnlsR0lOeldPSTVBWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jYXJ0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTE7fQ==', 1742305152);

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `shop_address` text NOT NULL,
  `valid_id_path` varchar(255) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`id`, `user_id`, `shop_name`, `shop_address`, `valid_id_path`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(2, 11, 'Sample Shop', 'Macrohon Dr., Canelar, Zamboanga City', 'shop_documents/W9uDwoW6yf4oRjiMLyVldzEu427nBS4YX0czpDkB.jpg', 'approved', NULL, '2025-03-16 15:22:25', '2025-03-16 18:45:46');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `birthday` date DEFAULT NULL,
  `number` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `email`, `location`, `profile_picture`, `status`, `birthday`, `number`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Azief', 'Saclolo', 'azief', 'azief27saclolo@gmail.com', NULL, NULL, 'active', NULL, '09474526036', '2024-12-05 18:52:22', '$2y$12$xBvjQ56mnzwt6NU3Btmez.4jLIDswu.gyXLs.W4qArk9I/W.sBune', '4gvHz2SLAJZb5PBRdurJgwTh1VV6zXgVaCeqMcX7AJbZG6zQ7qqHH66bGNhV', '2024-12-04 10:11:53', '2024-12-05 23:09:07'),
(2, 'ian', 'alama', 'ian', 'ian@gmail.com', NULL, NULL, 'active', NULL, '12345678911', NULL, '$2y$12$LB3e0KPT.Qb0fXg9FUbQouZ6VCyOrYvP8fNeBMJz9Yr6q10FFWvTC', 'ZTU3NLawQLLTvdCjHV1s51AqDXovYZlOlCbgwZOp1bwNnwHMOBlEg0l80f6D', '2024-12-05 09:49:45', '2024-12-05 09:49:45'),
(3, 'herwayne', 'cawili', 'wenwen', 'wenwen@gmail.com', NULL, NULL, 'active', NULL, '12345678912', NULL, '$2y$12$FAKuysmfdS4lX61.SLhQJe8N0vNiYr00XxWFA1DtSGwnoOrO2/Rcq', NULL, '2024-12-05 09:53:03', '2024-12-05 09:53:03'),
(4, 'bom', 'bom', 'bom', 'bom@gmail.com', NULL, NULL, 'active', NULL, '12345678913', NULL, '$2y$12$p.bXHbBf1b3YwPYngEp3I.5a8ueK0AhP850T0Q/.L7ZdboNTW24aa', NULL, '2024-12-05 10:18:00', '2024-12-05 10:18:00'),
(5, 'myke', 'sayabi', 'myke', 'myke@gmail.com', NULL, NULL, 'active', NULL, '12345678914', '2024-12-05 10:23:01', '$2y$12$QNgt1YhZ0/wBaj.nhBSDeeEk3vGfK9VKlrlaMt2W8i1DhYXqJXFUK', NULL, '2024-12-05 10:19:36', '2024-12-05 10:23:01'),
(6, 'dean', 'wong', 'dean', 'dean@gmail.com', NULL, NULL, 'active', NULL, '12345678915', NULL, '$2y$12$Cm7JcuLAnitgGfMM2Fbe/eq.yIB9..cYziwhZn3oD786wyZR17upG', 'raixy044ZGvzUdHk6DxgyLmTwYs8HvIICdCPSHu1n1p99KWW3ykbsmfURCqD', '2024-12-05 10:24:35', '2024-12-05 10:24:35'),
(7, 'Ronald', 'Panganiban', 'ronron', 'ronron@gmail.com', NULL, NULL, 'active', NULL, '12345678917', '2024-12-05 23:21:05', '$2y$12$mnbkTDHn39ox2SMhqUsiEul5EYF5DBwBF1xCb2BFTlah1tj.4F86G', NULL, '2024-12-05 23:20:46', '2024-12-05 23:21:05'),
(8, 'matthew', 'lim', 'matt', 'matt@gmail.com', NULL, NULL, 'active', NULL, '12345678918', '2024-12-06 19:08:48', '$2y$12$kiAfkvLIvvHbCwqXq34moO.b96UjpfnfatfE.W/C26Ls0Krvm0CWa', 'OMLvEi2fRQlgc1fkyt3JmcVBvEQFXGuo3jzNxgx3cFCLh9EbvNRp3ogo5NmE', '2024-12-06 18:59:17', '2024-12-06 19:49:53'),
(9, 'Harry', 'Potter', 'harry', 'harrypotter@gmail.com', NULL, NULL, 'active', NULL, '09123456789', '2024-12-06 20:14:10', '$2y$12$Dgrj.pTKI5KOT7Dd9GyEEeuC6HF05BttxhUaFtEdl5xH95URgPS/y', NULL, '2024-12-06 20:13:28', '2024-12-06 20:14:10'),
(11, 'sample', 'sample', 'sample', 'sample@gmail.com', 'Canelar, Zamboanga City', 'profile_pictures/wGHptRgiZ5c5nqOauh5bsNigsKuiaIyRMEaLqL4b.png', 'active', NULL, '12345678910', '2025-02-16 02:33:36', '$2y$12$1InjzGJFOXI.NmXB3OI6QukD3Blckb7R92bsrqv0kl8pHrh0ttIsm', 'ELF1ScNw59gYuGacLXUgb52lkD3MVIlcFFlXjwhp3XXlYxE4lQHj8eQKKDSW', '2025-02-16 02:32:41', '2025-03-16 07:13:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `buys`
--
ALTER TABLE `buys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buys_user_id_foreign` (`user_id`);

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
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_cart_id_foreign` (`cart_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `favorites_user_id_foreign` (`user_id`),
  ADD KEY `favorites_post_id_foreign` (`post_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `orders_seller_id_foreign` (`seller_id`),
  ADD KEY `orders_buyer_id_foreign` (`buyer_id`),
  ADD KEY `orders_post_id_foreign` (`post_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_user_id_foreign` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_user_id_foreign` (`user_id`),
  ADD KEY `products_post_id_foreign` (`post_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reviews_seller_customer_unique` (`seller_id`,`customer_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shops_user_id_foreign` (`user_id`);

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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `buys`
--
ALTER TABLE `buys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buys`
--
ALTER TABLE `buys`
  ADD CONSTRAINT `buys_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `orders_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shops`
--
ALTER TABLE `shops`
  ADD CONSTRAINT `shops_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
