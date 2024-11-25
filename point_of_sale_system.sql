-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 25, 2024 at 05:47 AM
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
-- Database: `point_of_sale_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Osaka', NULL, NULL, '1', '2024-08-27 09:42:22', '2024-08-27 11:00:15'),
(2, 'Kay Gillespie', NULL, NULL, '1', '2024-08-27 09:42:27', '2024-08-27 09:42:27'),
(3, 'Karly Hyde', NULL, NULL, '1', '2024-08-27 09:47:17', '2024-08-27 09:47:17'),
(4, 'Alana Roth', NULL, NULL, '1', '2024-08-27 09:47:59', '2024-08-27 09:47:59'),
(6, 'BMW', NULL, NULL, '1', '2024-09-17 22:41:35', '2024-09-17 22:41:35');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `unit_price` decimal(8,2) NOT NULL DEFAULT '0.00',
  `quantity` decimal(8,2) NOT NULL DEFAULT '0.00',
  `sub_total` decimal(8,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `product_id`, `unit_price`, `quantity`, `sub_total`, `created_at`, `updated_at`) VALUES
(37, 2, '10.00', '1.00', '10.00', '2024-09-24 10:15:51', '2024-09-24 23:21:34'),
(38, 3, '10.00', '1.00', '10.00', '2024-09-24 10:49:29', '2024-09-24 23:21:41');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_category_id` bigint UNSIGNED DEFAULT NULL,
  `position_no` int NOT NULL DEFAULT '0',
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_by_id` bigint UNSIGNED DEFAULT NULL,
  `updated_by_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `thumbnail`, `parent_category_id`, `position_no`, `status`, `created_by_id`, `updated_by_id`, `created_at`, `updated_at`) VALUES
(1, 'A', 'subcategory-110087900866d56dde689040.63661412.jpeg', NULL, 0, '1', 1, NULL, '2024-09-02 01:48:46', '2024-09-02 01:48:46'),
(2, 'B', 'category-14202196866d5708a8d77e8.46751600.jpg', 1, 1, '1', 1, NULL, '2024-09-02 02:00:10', '2024-09-02 02:00:10'),
(3, 'Electronics', 'category-85619874766d6e9d40061e9.29944300.jpg', NULL, 0, '1', 1, NULL, '2024-09-03 04:49:56', '2024-09-03 04:49:56'),
(4, 'Mobile', 'category-24557299466d6e9f05f9214.77949734.jpeg', 3, 1, '1', 1, NULL, '2024-09-03 04:50:24', '2024-09-03 04:50:24'),
(5, 'Vehicle', 'category-169840924366e9b117805b69.88454088.jpg', NULL, 0, '1', 1, NULL, '2024-09-17 10:40:55', '2024-09-17 10:40:55'),
(6, 'BMW', 'category-166383396566e9b1df2bbcd1.14514811.jpg', 5, 1, '1', 1, NULL, '2024-09-17 10:44:15', '2024-09-17 10:44:15');

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
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2024_08_25_152905_create_categories_table', 2),
(7, '2024_08_27_120845_create_brands_table', 3),
(8, '2024_08_27_182830_create_products_table', 4),
(9, '2024_08_27_191054_create_pictures_table', 5),
(10, '2024_08_28_102310_create_products_table', 6),
(11, '2024_08_29_131024_create_subcategories_table', 7),
(16, '2024_08_29_221128_create_categories_table', 8),
(17, '2024_08_30_185657_create_origins_table', 8),
(18, '2024_08_31_154838_create_units_table', 8),
(19, '2024_09_01_233404_create_product_pictures_table', 9),
(20, '2024_09_01_233438_create_product_categories_table', 9),
(21, '2024_09_03_114354_create_purchases_table', 10),
(22, '2024_09_03_165111_create_purchase_products_table', 11),
(23, '2024_09_04_041231_create_carts_table', 11),
(24, '2024_09_07_222147_create_product_stocks_table', 12),
(25, '2024_09_08_082426_create_sales_table', 13),
(26, '2024_09_08_090619_create_sales_carts_table', 14),
(27, '2024_09_08_090817_create_sales_products_table', 15),
(28, '2024_09_10_171106_create_transactions_table', 16),
(29, '2024_09_23_053251_create_permission_tables', 17);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 8),
(3, 'App\\Models\\User', 8);

-- --------------------------------------------------------

--
-- Table structure for table `origins`
--

CREATE TABLE `origins` (
  `id` bigint UNSIGNED NOT NULL,
  `origin_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `origins`
--

INSERT INTO `origins` (`id`, `origin_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Bangladesh', '1', '2024-09-17 13:58:35', '2024-09-17 13:58:35'),
(2, 'England', '1', '2024-09-17 14:02:06', '2024-09-17 14:02:06'),
(3, 'China', '1', '2024-09-17 14:03:10', '2024-09-17 14:03:10'),
(4, 'Japan', '1', '2024-09-17 14:03:18', '2024-09-17 14:03:18'),
(5, 'Koria', '1', '2024-09-17 14:03:34', '2024-09-17 14:03:34'),
(6, 'Iran', '1', '2024-09-17 14:03:44', '2024-09-17 14:03:44'),
(7, 'USA', '1', '2024-09-17 14:03:56', '2024-09-17 14:03:56');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view user', 'web', '2024-09-23 04:22:22', '2024-09-23 04:35:32'),
(3, 'create user', 'web', '2024-09-23 04:37:09', '2024-09-23 04:37:09'),
(4, 'update user', 'web', '2024-09-23 04:37:24', '2024-09-23 04:37:24'),
(5, 'delete user', 'web', '2024-09-23 04:37:37', '2024-09-23 04:37:37'),
(6, 'view unit', 'web', '2024-09-23 04:42:15', '2024-09-23 04:42:15'),
(7, 'create unit', 'web', '2024-09-23 04:42:23', '2024-09-23 04:42:23'),
(8, 'update unit', 'web', '2024-09-23 04:42:33', '2024-09-23 04:42:33'),
(9, 'delete unit', 'web', '2024-09-23 04:44:18', '2024-09-23 04:44:18'),
(10, 'view origin', 'web', '2024-09-23 04:44:29', '2024-09-23 04:44:29'),
(11, 'create origin', 'web', '2024-09-23 04:44:36', '2024-09-23 04:44:36'),
(12, 'update origin', 'web', '2024-09-23 04:44:43', '2024-09-23 04:44:43'),
(13, 'delete origin', 'web', '2024-09-23 04:44:50', '2024-09-23 04:44:50'),
(14, 'view brand', 'web', '2024-09-23 04:44:57', '2024-09-23 04:44:57'),
(15, 'create brand', 'web', '2024-09-23 04:45:03', '2024-09-23 04:45:03'),
(16, 'update brand', 'web', '2024-09-23 04:45:09', '2024-09-23 04:45:09'),
(17, 'delete brand', 'web', '2024-09-23 04:45:16', '2024-09-23 04:45:16'),
(18, 'view category', 'web', '2024-09-23 04:45:28', '2024-09-23 04:45:28'),
(19, 'create category', 'web', '2024-09-23 04:45:34', '2024-09-23 04:45:34'),
(20, 'update category', 'web', '2024-09-23 04:45:41', '2024-09-23 04:45:41'),
(21, 'delete category', 'web', '2024-09-23 04:45:49', '2024-09-23 04:45:49'),
(22, 'view product', 'web', '2024-09-23 04:46:02', '2024-09-23 04:46:02'),
(23, 'create product', 'web', '2024-09-23 04:46:10', '2024-09-23 04:46:10'),
(24, 'update product', 'web', '2024-09-23 04:46:18', '2024-09-23 04:46:18'),
(25, 'delete product', 'web', '2024-09-23 04:46:25', '2024-09-23 04:46:25'),
(26, 'view purchase', 'web', '2024-09-23 04:46:31', '2024-09-23 04:46:31'),
(27, 'create purchase', 'web', '2024-09-23 04:46:40', '2024-09-23 04:46:40'),
(28, 'update purchase', 'web', '2024-09-23 04:46:46', '2024-09-23 04:46:46'),
(29, 'delete purchase', 'web', '2024-09-23 04:46:52', '2024-09-23 04:46:52'),
(30, 'view add to cart', 'web', '2024-09-23 04:46:58', '2024-09-23 04:46:58'),
(31, 'create add to cart', 'web', '2024-09-23 04:47:18', '2024-09-23 04:47:18'),
(32, 'update add to cart', 'web', '2024-09-23 04:47:25', '2024-09-23 04:47:25'),
(33, 'delete add to cart', 'web', '2024-09-23 04:47:32', '2024-09-23 04:47:32'),
(34, 'view sale', 'web', '2024-09-23 04:47:48', '2024-09-23 04:47:48'),
(35, 'create sale', 'web', '2024-09-23 04:47:55', '2024-09-23 04:47:55'),
(36, 'view purchase dues', 'web', '2024-09-23 04:48:01', '2024-09-23 04:48:01'),
(37, 'create purchase payment', 'web', '2024-09-23 04:48:08', '2024-09-23 04:48:08'),
(38, 'view sales dues', 'web', '2024-09-23 04:48:15', '2024-09-23 04:48:15'),
(39, 'create sales payment', 'web', '2024-09-23 04:48:23', '2024-09-23 04:49:10');

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

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

CREATE TABLE `pictures` (
  `id` bigint UNSIGNED NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `subcategory_id` bigint UNSIGNED DEFAULT NULL,
  `brand_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pictures`
--

INSERT INTO `pictures` (`id`, `filename`, `product_id`, `user_id`, `category_id`, `subcategory_id`, `brand_id`, `created_at`, `updated_at`) VALUES
(1, 'jasmine-fry-105651042766cf8b96aff182.26001623.jpg', 1, NULL, NULL, NULL, NULL, '2024-08-28 14:41:58', NULL),
(2, 'jasmine-fry-207272912366cf8b96bf4c66.84813873.jpg', 1, NULL, NULL, NULL, NULL, '2024-08-28 14:41:58', NULL),
(3, 'jasmine-fry-199971907966cf8b96c00dc7.78833829.jpg', 1, NULL, NULL, NULL, NULL, '2024-08-28 14:41:58', NULL),
(4, 'jasmine-fry-100385161166cf8b96c09292.23812190.jpg', 1, NULL, NULL, NULL, NULL, '2024-08-28 14:41:58', NULL),
(5, 'alika-schmidt-178843004466d05a9ea74ed1.00825781.jpeg', 2, NULL, NULL, NULL, NULL, '2024-08-29 05:25:19', NULL),
(6, 'alika-schmidt-203482374566d05a9f079c32.06323396.jpeg', 2, NULL, NULL, NULL, NULL, '2024-08-29 05:25:19', NULL),
(7, 'alika-schmidt-91818494366d05a9f080ba6.12249912.jpeg', 2, NULL, NULL, NULL, NULL, '2024-08-29 05:25:19', NULL),
(8, 'alika-schmidt-174104622266d05a9f086fc2.33880963.jpeg', 2, NULL, NULL, NULL, NULL, '2024-08-29 05:25:19', NULL),
(9, 'harlan-velez-43448828566d05fd3331bd4.91944977.jpeg', 3, NULL, NULL, NULL, NULL, '2024-08-29 05:47:31', NULL),
(10, 'harlan-velez-123468429266d05fd3363980.40150977.jpeg', 3, NULL, NULL, NULL, NULL, '2024-08-29 05:47:31', NULL),
(19, 'bbbbbbbbbbbbbbbb-70803995566d59feb44fd18.21277609.jpg', 8, NULL, NULL, NULL, NULL, '2024-09-02 05:22:19', NULL),
(20, 'bbbbbbbbbbbbbbbb-105620226466d59feb45ea38.74050576.jpeg', 8, NULL, NULL, NULL, NULL, '2024-09-02 05:22:19', NULL),
(21, 'bbbbbbbbbbbbbbbb-182447443766d59feb4644f2.90883198.jpg', 8, NULL, NULL, NULL, NULL, '2024-09-02 05:22:19', NULL),
(22, 'bbbbbbbbbbbbbbbb-125408827866d59feb46a473.10463646.jpg', 8, NULL, NULL, NULL, NULL, '2024-09-02 05:22:19', NULL),
(23, 'bbbbbbbbbbbbbbbb-147578478766d59feb471928.36700520.jpeg', 8, NULL, NULL, NULL, NULL, '2024-09-02 05:22:19', NULL),
(24, 'bbbbbbbbbbbbbbbb-55377562466d59feb479946.62352821.jpg', 8, NULL, NULL, NULL, NULL, '2024-09-02 05:22:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sku` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `long_description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `thumbnail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand_id` bigint UNSIGNED NOT NULL,
  `status` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_by_id` bigint UNSIGNED DEFAULT NULL,
  `updated_by_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `slug`, `sku`, `short_description`, `long_description`, `thumbnail`, `brand_id`, `status`, `user_id`, `created_by_id`, `updated_by_id`, `created_at`, `updated_at`) VALUES
(1, 'Apple', 'jasmine-fry', '', 'Multicolor food. In botany, a fruit is the seed-bearing structure in flowering plants that is formed from the ovary after flowering (see Fruit anatomy).', 'World!\" program is generally a simple computer program which emits (or displays) to the screen (often the console) a message similar to \"Hello, World!\" ', NULL, 3, '1', 0, NULL, NULL, '2024-08-28 14:41:58', '2024-08-28 14:41:58'),
(2, 'Orrange', 'alika-schmidt', '', 'Color is orrange with vitamin C. In botany, a fruit is the seed-bearing structure in flowering plants that is formed from the ovary after flowering (see Fruit anatomy).', 'World!\" program is generally a simple computer program which emits (or displays) to the screen (often the console) a message similar to \"Hello, World!\" ', NULL, 3, '1', 0, NULL, NULL, '2024-08-29 05:25:18', '2024-08-29 05:25:18'),
(3, 'Banana', 'harlan-velez', '', 'color green and yellow and full of magnasiam and calsiam', 'World!\" program is generally a simple computer program which emits (or displays) to the screen (often the console) a message similar to \"Hello, World!\" ', NULL, 1, '1', 0, NULL, NULL, '2024-08-29 05:47:31', '2024-08-29 05:47:31'),
(7, 'Mango', 'aaaa', 'SKU-AAA-3531', 'In botany, a fruit is the seed-bearing structure in flowering plants that is formed from the ovary after flowering (see Fruit anatomy).', 'World!\" program is generally a simple computer program which emits (or displays) to the screen (often the console) a message similar to \"Hello, World!\" ', NULL, 4, '1', 1, NULL, NULL, '2024-09-02 05:15:41', NULL),
(8, 'Jackfroot', 'bbbbbb', 'SKU-BBB-2950', 'In botany, a fruit is the seed-bearing structure in flowering plants that is formed from the ovary after flowering (see Fruit anatomy).', 'World!\" program is generally a simple computer program which emits (or displays) to the screen (often the console) a message similar to \"Hello, World!\" ', 'product_thumbnail-177771877766d59feb3f0375.37575344.jpeg', 3, '1', 1, 1, NULL, '2024-09-02 05:22:19', NULL),
(11, 'Cuting edge car', 'cuting-edge-car', 'SKU-CUT-486', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin tristique libero ut nulla tristique, et vestibulum lacus scelerisque. Nulla facilisi. Vestibulum interdum, erat nec dictum scelerisque, eros sapien suscipit ante, id viverra turpis nulla sit amet mauris. Etiam at orci vel mi volutpat fringilla at nec orci. Integer dapibus eros at varius laoreet.', 'product_thumbnail-193108838366eb0a1ab84001.50961402.jpg', 6, '1', 2, 2, 2, '2024-09-18 19:12:59', '2024-09-18 11:13:34');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `product_id`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 7, 1, '2024-09-02 05:15:41', '2024-09-02 05:15:41'),
(2, 7, 2, '2024-09-02 05:15:41', '2024-09-02 05:15:41'),
(3, 8, 1, '2024-09-02 05:22:19', '2024-09-02 05:22:19'),
(4, 8, 2, '2024-09-02 05:22:19', '2024-09-02 05:22:19'),
(8, 11, 3, '2024-09-18 11:12:59', '2024-09-18 11:12:59'),
(9, 11, 5, '2024-09-18 11:12:59', '2024-09-18 11:12:59');

-- --------------------------------------------------------

--
-- Table structure for table `product_pictures`
--

CREATE TABLE `product_pictures` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extension` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_stocks`
--

CREATE TABLE `product_stocks` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `brand_id` bigint UNSIGNED DEFAULT NULL,
  `origin_id` bigint UNSIGNED DEFAULT NULL,
  `unit_id` bigint UNSIGNED DEFAULT NULL,
  `all_time_stock_in` int NOT NULL DEFAULT '0',
  `all_time_stock_out` int NOT NULL DEFAULT '0',
  `available_quantity` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_stocks`
--

INSERT INTO `product_stocks` (`id`, `product_id`, `brand_id`, `origin_id`, `unit_id`, `all_time_stock_in`, `all_time_stock_out`, `available_quantity`, `created_at`, `updated_at`) VALUES
(17, 1, 3, NULL, NULL, 90, 16, 90, '2024-09-08 13:36:05', '2024-09-11 07:31:35'),
(18, 2, 3, NULL, NULL, 90, 16, 90, '2024-09-08 13:36:05', '2024-09-11 07:31:35'),
(20, 8, 3, NULL, NULL, 90, 0, 90, '2024-09-10 07:34:46', '2024-09-11 07:31:35'),
(21, 7, 4, NULL, NULL, 1000, 0, 1000, '2024-09-11 07:31:35', '2024-09-11 07:31:35'),
(22, 3, 1, NULL, NULL, 500, 0, 500, '2024-09-11 07:31:35', '2024-09-11 07:31:35');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint UNSIGNED NOT NULL,
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL COMMENT 'this is admin or salesman id',
  `supplier_id` bigint UNSIGNED NOT NULL,
  `sub_total` decimal(10,2) NOT NULL,
  `total_quantity` int NOT NULL DEFAULT '0',
  `discount_type` enum('0','1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0=no, 1=flat, 2=percentage',
  `discount_value` decimal(6,2) NOT NULL DEFAULT '0.00',
  `discount_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `shipping_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `vat_amount` decimal(5,2) NOT NULL DEFAULT '0.00',
  `tax_amount` decimal(5,2) NOT NULL DEFAULT '0.00',
  `grand_total` decimal(15,2) NOT NULL DEFAULT '0.00',
  `paid_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `due_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `payment_status` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=panding, 1=complete',
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `invoice_no`, `customer_id`, `supplier_id`, `sub_total`, `total_quantity`, `discount_type`, `discount_value`, `discount_amount`, `shipping_amount`, `vat_amount`, `tax_amount`, `grand_total`, `paid_amount`, `due_amount`, `payment_status`, `status`, `created_at`, `updated_at`) VALUES
(29, 'INV-0001', 2, 3, '350.00', 17, '2', '83.00', '290.50', '73.00', '82.00', '0.00', '108.29', '68.00', '40.29', '0', '0', '2024-09-08 13:36:05', '2024-09-08 13:36:05'),
(31, 'INV-0030', 2, 3, '1000.00', 100, '2', '11.00', '110.00', '111.00', '11.00', '11.00', '1110.00', '1111.00', '-1.00', '1', '1', '2024-09-10 07:03:02', '2024-09-10 07:03:02'),
(32, 'INV-0032', 2, 3, '1000.00', 50, '2', '11.00', '110.00', '111.00', '11.00', '11.00', '1110.00', '1111.00', '-1.00', '1', '1', '2024-09-10 07:08:18', '2024-09-10 07:08:18'),
(35, 'INV-0033', 2, 3, '10000.00', 10, '2', '11.00', '1100.00', '111.00', '11.00', '11.00', '11100.00', '11111.00', '-11.00', '1', '1', '2024-09-10 07:34:46', '2024-09-10 07:34:46'),
(38, 'INV-0036', 2, 7, '31000.00', 1580, '2', '11.00', '3410.00', '1000.00', '11.00', '11.00', '34410.00', '30820.00', '3590.00', '0', '1', '2024-09-19 07:31:35', '2024-09-15 02:44:36');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_products`
--

CREATE TABLE `purchase_products` (
  `id` bigint UNSIGNED NOT NULL,
  `purchase_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `unit_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quantity` int NOT NULL DEFAULT '0',
  `sub_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `brand_id` bigint UNSIGNED DEFAULT NULL,
  `origin_id` bigint UNSIGNED DEFAULT NULL,
  `unit_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_products`
--

INSERT INTO `purchase_products` (`id`, `purchase_id`, `product_id`, `unit_price`, `quantity`, `sub_total`, `brand_id`, `origin_id`, `unit_id`, `created_at`, `updated_at`) VALUES
(41, 29, 1, '10.00', 500, '150.00', 3, NULL, NULL, '2024-09-08 13:36:05', '2024-09-08 13:36:05'),
(42, 29, 2, '723.00', 845, '610935.00', 3, NULL, NULL, '2024-09-08 13:36:05', '2024-09-08 13:36:05'),
(45, 31, 1, '10.00', 100, '1000.00', 3, NULL, NULL, '2024-09-10 07:03:02', '2024-09-10 07:03:02'),
(46, 32, 2, '20.00', 500, '1000.00', 3, NULL, NULL, '2024-09-10 07:08:18', '2024-09-10 07:08:18'),
(49, 35, 8, '1000.00', 10, '10000.00', 3, NULL, NULL, '2024-09-10 07:34:46', '2024-09-10 07:34:46'),
(50, 38, 8, '200.00', 80, '16000.00', 3, NULL, NULL, '2024-09-11 07:31:35', '2024-09-11 07:31:35'),
(51, 38, 7, '10.00', 1000, '10000.00', 4, NULL, NULL, '2024-09-11 07:31:35', '2024-09-11 07:31:35'),
(52, 38, 3, '10.00', 500, '5000.00', 1, NULL, NULL, '2024-09-11 07:31:35', '2024-09-11 07:31:35');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2024-09-23 01:08:12', '2024-09-23 02:17:01'),
(3, 'salesman', 'web', '2024-09-23 02:13:19', '2024-09-23 02:17:13'),
(7, 'user', 'web', '2024-09-23 09:04:16', '2024-09-23 09:04:16');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(1, 3),
(3, 3),
(4, 3),
(6, 3),
(10, 3),
(14, 3),
(18, 3),
(22, 3),
(30, 3),
(31, 3),
(32, 3),
(33, 3),
(34, 3),
(35, 3),
(38, 3),
(39, 3),
(22, 7);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint UNSIGNED NOT NULL,
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `salesman_id` bigint UNSIGNED NOT NULL,
  `sub_total` decimal(10,2) NOT NULL,
  `total_quantity` int NOT NULL DEFAULT '0',
  `discount_type` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `discount_value` decimal(6,2) NOT NULL DEFAULT '0.00',
  `discount_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `shipping_amount` decimal(5,2) NOT NULL DEFAULT '0.00',
  `vat_amount` decimal(5,2) NOT NULL DEFAULT '0.00',
  `tax_amount` decimal(5,2) NOT NULL DEFAULT '0.00',
  `grand_total` decimal(15,2) NOT NULL DEFAULT '0.00',
  `paid_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `due_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `payment_status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=Inactive, 1=Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `invoice_no`, `customer_id`, `salesman_id`, `sub_total`, `total_quantity`, `discount_type`, `discount_value`, `discount_amount`, `shipping_amount`, `vat_amount`, `tax_amount`, `grand_total`, `paid_amount`, `due_amount`, `payment_status`, `status`, `created_at`, `updated_at`) VALUES
(3, 'INV-0001', 3, 2, '1506.00', 8, '2', '11.00', '165.66', '111.00', '11.00', '11.00', '1794.87', '1411.00', '383.87', '0', '1', '2024-09-10 05:44:07', '2024-09-15 01:15:02'),
(8, 'INV-0004', 3, 2, '1446.00', 2, '2', '11.00', '159.06', '111.00', '11.00', '11.00', '1728.27', '1531.00', '197.27', '0', '1', '2024-09-10 06:58:21', '2024-09-15 02:14:35');

-- --------------------------------------------------------

--
-- Table structure for table `sales_carts`
--

CREATE TABLE `sales_carts` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `unit_price` decimal(8,2) NOT NULL DEFAULT '0.00',
  `quantity` decimal(8,2) NOT NULL DEFAULT '0.00',
  `sub_total` decimal(8,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales_carts`
--

INSERT INTO `sales_carts` (`id`, `product_id`, `unit_price`, `quantity`, `sub_total`, `created_at`, `updated_at`) VALUES
(6, 1, '10.00', '3.00', '30.00', '2024-09-10 08:13:04', '2024-09-24 23:44:51'),
(7, 2, '723.00', '1.00', '723.00', '2024-09-11 09:42:16', '2024-09-11 09:42:16');

-- --------------------------------------------------------

--
-- Table structure for table `sales_products`
--

CREATE TABLE `sales_products` (
  `id` bigint UNSIGNED NOT NULL,
  `sales_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `unit_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quantity` int NOT NULL DEFAULT '0',
  `sub_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `brand_id` bigint UNSIGNED DEFAULT NULL,
  `origin_id` bigint UNSIGNED DEFAULT NULL,
  `unit_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales_products`
--

INSERT INTO `sales_products` (`id`, `sales_id`, `product_id`, `unit_price`, `quantity`, `sub_total`, `brand_id`, `origin_id`, `unit_id`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '10.00', 6, '60.00', 3, NULL, NULL, '2024-09-10 05:44:07', '2024-09-10 05:44:07'),
(2, 3, 1, '10.00', 6, '60.00', 3, NULL, NULL, '2024-09-10 05:44:07', '2024-09-10 05:44:07'),
(3, 3, 2, '723.00', 2, '1446.00', 3, NULL, NULL, '2024-09-10 05:44:07', '2024-09-10 05:44:07'),
(8, 8, 2, '723.00', 2, '1446.00', 3, NULL, NULL, '2024-09-10 06:58:21', '2024-09-10 06:58:21');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `position_no` int DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_by_id` bigint UNSIGNED DEFAULT NULL,
  `updated_by_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `title`, `category_id`, `position_no`, `thumbnail`, `status`, `created_by_id`, `updated_by_id`, `created_at`, `updated_at`) VALUES
(1, 'Sunt fugit fugit d', 2, 77, 'subcategory-200110025466d0a4570a6db0.42850005.jpg', '0', 1, NULL, '2024-08-29 10:39:51', '2024-08-29 13:37:45');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `trx_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_id` bigint UNSIGNED DEFAULT NULL,
  `sales_id` bigint UNSIGNED DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `trx_id`, `purchase_id`, `sales_id`, `amount`, `note`, `customer_id`, `created_at`, `updated_at`) VALUES
(1, 'TRX1726061495VYSP3', 38, NULL, '30000.00', 'Your due amount is : 4410', 3, '2024-09-11 07:31:35', '2024-09-11 07:31:35'),
(2, 'TRX1726387106HCYL4', NULL, 8, '1511.00', 'Your due amount is : 217.27', 3, '2024-09-15 01:58:26', '2024-09-15 01:58:26'),
(3, 'TRX1726388075DKIJQ', NULL, 8, '20.00', 'Your due amount is : 197.27', 3, '2024-09-15 02:14:35', '2024-09-15 02:14:35'),
(4, 'TRX1726389876IPEUD', 38, NULL, '410.00', 'Your due amount is : 3590', 3, '2024-09-15 02:44:36', '2024-09-15 02:44:36');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'KG', '1', '2024-09-18 01:11:19', '2024-09-18 02:27:37'),
(2, 'PIECE', '1', '2024-09-18 02:18:34', '2024-09-18 02:27:49');

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
  `role` enum('0','1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0=user, 1=admin, 2=supplier',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$10$CNi6.iMeFjjm4fBRviDkoO.llQa5j97EfLVuCVK9W7L2228m4woLa', '1', NULL, '2024-08-25 09:18:50', '2024-08-25 09:18:50'),
(2, 'salesman', 'salesman@gmail.com', NULL, '$2y$10$2lM1k0CjgYdWmNqy4iIjKuuAD5Ckzs88v86ufWYzKTun.XCGFKjfa', '0', NULL, '2024-09-04 22:58:05', '2024-09-04 22:58:05'),
(3, 'Maxwell Daniels', 'hijed@mailinator.com', NULL, '$2y$10$8B8GaRdpUtpjknU4EIcVEuJPjy/73MaIXVIM6SR/kc8TrxuDgLtR2', '2', NULL, '2024-09-07 00:33:31', '2024-09-07 00:33:31'),
(4, 'Abdur Rahman', 'abdur@gmail.com', NULL, '$2y$10$ZCypi99NljWmrNYOH8vXLOlc4adUVN18XuiIWrq4VNqOcVLBs8u9G', '0', NULL, '2024-09-17 02:01:44', '2024-09-17 02:01:44'),
(5, 'Shamim', 'shamim@gmail.com', NULL, '$2y$10$R.nDazvzGAG9agwj.B8eNOWg22x6ECLaRH8dJ.zwsGoYUwsoYjQIa', '0', NULL, '2024-09-17 02:06:28', '2024-09-17 02:06:28'),
(6, 'Mamun', 'mamun@gmail.com', NULL, '$2y$10$33lUHJc6bKSnkD2AHkvIIeISZ.a.TCXRlRwn6hmLRo/KlJzeWNG2q', '0', NULL, '2024-09-17 02:07:15', '2024-09-17 02:07:15'),
(7, 'kawser', 'kawser@gmail.com', NULL, '$2y$10$m4X9RRsudt.TIwgSxivZqenMuvoWTqrOYQVSKJqda44McIuVr3b.e', '2', NULL, '2024-09-17 02:10:17', '2024-09-17 02:10:17'),
(8, 'Walter Best', 'bipasha@gmail.com', NULL, '$2y$10$6KWG6fPshhAiWR5xxpAsVObwUKCrS0xwkpHLu7gGoTGO.qV8LYO.q', '0', NULL, '2024-09-23 09:02:44', '2024-09-23 09:02:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_slug_unique` (`slug`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_unique_cat` (`title`,`parent_category_id`),
  ADD KEY `categories_parent_category_id_foreign` (`parent_category_id`),
  ADD KEY `categories_created_by_id_foreign` (`created_by_id`),
  ADD KEY `categories_updated_by_id_foreign` (`updated_by_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `origins`
--
ALTER TABLE `origins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pictures`
--
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pictures_product_id_foreign` (`product_id`),
  ADD KEY `pictures_user_id_foreign` (`user_id`),
  ADD KEY `pictures_category_id_foreign` (`category_id`),
  ADD KEY `pictures_brand_id_foreign` (`brand_id`),
  ADD KEY `pictures_subcategory_id_foreign` (`subcategory_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_categories_product_id_foreign` (`product_id`),
  ADD KEY `product_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `product_pictures`
--
ALTER TABLE `product_pictures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_pictures_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_stocks`
--
ALTER TABLE `product_stocks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_id` (`product_id`),
  ADD KEY `product_stocks_brand_id_foreign` (`brand_id`),
  ADD KEY `product_stocks_origin_id_foreign` (`origin_id`),
  ADD KEY `product_stocks_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchases_invoice_no_unique` (`invoice_no`),
  ADD KEY `purchases_customer_id_foreign` (`customer_id`),
  ADD KEY `purchases_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `purchase_products`
--
ALTER TABLE `purchase_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_products_purchase_id_foreign` (`purchase_id`),
  ADD KEY `purchase_products_product_id_foreign` (`product_id`),
  ADD KEY `purchase_products_brand_id_foreign` (`brand_id`),
  ADD KEY `purchase_products_origin_id_foreign` (`origin_id`),
  ADD KEY `purchase_products_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sales_invoice_no_unique` (`invoice_no`),
  ADD KEY `sales_customer_id_foreign` (`customer_id`),
  ADD KEY `sales_salesman_id_foreign` (`salesman_id`);

--
-- Indexes for table `sales_carts`
--
ALTER TABLE `sales_carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_carts_product_id_foreign` (`product_id`);

--
-- Indexes for table `sales_products`
--
ALTER TABLE `sales_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_products_sales_id_foreign` (`sales_id`),
  ADD KEY `sales_products_product_id_foreign` (`product_id`),
  ADD KEY `sales_products_brand_id_foreign` (`brand_id`),
  ADD KEY `sales_products_origin_id_foreign` (`origin_id`),
  ADD KEY `sales_products_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subcategories_title_unique` (`title`),
  ADD KEY `subcategories_category_id_foreign` (`category_id`),
  ADD KEY `subcategories_created_by_id_foreign` (`created_by_id`),
  ADD KEY `subcategories_updated_by_id_foreign` (`updated_by_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transactions_trx_id_unique` (`trx_id`),
  ADD KEY `transactions_purchase_id_foreign` (`purchase_id`),
  ADD KEY `transactions_sale_id_foreign` (`sales_id`),
  ADD KEY `transactions_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `origins`
--
ALTER TABLE `origins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pictures`
--
ALTER TABLE `pictures`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product_pictures`
--
ALTER TABLE `product_pictures`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_stocks`
--
ALTER TABLE `product_stocks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `purchase_products`
--
ALTER TABLE `purchase_products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sales_carts`
--
ALTER TABLE `sales_carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sales_products`
--
ALTER TABLE `sales_products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_created_by_id_foreign` FOREIGN KEY (`created_by_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `categories_parent_category_id_foreign` FOREIGN KEY (`parent_category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `categories_updated_by_id_foreign` FOREIGN KEY (`updated_by_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pictures`
--
ALTER TABLE `pictures`
  ADD CONSTRAINT `pictures_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `pictures_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `pictures_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`);

--
-- Constraints for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD CONSTRAINT `product_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_categories_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_pictures`
--
ALTER TABLE `product_pictures`
  ADD CONSTRAINT `product_pictures_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_stocks`
--
ALTER TABLE `product_stocks`
  ADD CONSTRAINT `product_stocks_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_stocks_origin_id_foreign` FOREIGN KEY (`origin_id`) REFERENCES `origins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_stocks_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_stocks_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchases_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_products`
--
ALTER TABLE `purchase_products`
  ADD CONSTRAINT `purchase_products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_products_origin_id_foreign` FOREIGN KEY (`origin_id`) REFERENCES `origins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_products_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_products_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_salesman_id_foreign` FOREIGN KEY (`salesman_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales_carts`
--
ALTER TABLE `sales_carts`
  ADD CONSTRAINT `sales_carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `sales_products`
--
ALTER TABLE `sales_products`
  ADD CONSTRAINT `sales_products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_products_origin_id_foreign` FOREIGN KEY (`origin_id`) REFERENCES `origins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_products_sales_id_foreign` FOREIGN KEY (`sales_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_products_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_created_by_id_foreign` FOREIGN KEY (`created_by_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subcategories_updated_by_id_foreign` FOREIGN KEY (`updated_by_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_sale_id_foreign` FOREIGN KEY (`sales_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
