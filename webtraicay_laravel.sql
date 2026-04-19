-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 19, 2026 lúc 08:31 AM
-- Phiên bản máy phục vụ: 11.5.2-MariaDB
-- Phiên bản PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `webtraicay_laravel`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
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
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_11_26_165823_create_admin_table', 1),
(6, '2024_11_29_130400_create_category_product_table', 1),
(7, '2024_12_01_205725_create_product_table', 1),
(8, '2024_12_01_223947_create_oder_table', 1),
(9, '2025_07_13_153010_add_column_to_tbl_oder_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` int(10) UNSIGNED NOT NULL,
  `admin_username` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `admin_phone` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_id`, `admin_username`, `admin_password`, `admin_name`, `admin_phone`, `created_at`, `updated_at`) VALUES
(1, 'hieu', '123', 'hieu', '34534534', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_category_product`
--

CREATE TABLE `tbl_category_product` (
  `category_id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_category_product`
--

INSERT INTO `tbl_category_product` (`category_id`, `category_name`, `category_status`, `created_at`, `updated_at`) VALUES
(1, 'Táo', 0, NULL, NULL),
(2, 'Chuối', 1, NULL, NULL),
(3, 'Chuoi', 1, NULL, NULL),
(5, 'Bom', 1, NULL, NULL),
(6, 'Cam', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_coupon`
--

CREATE TABLE `tbl_coupon` (
  `coupon_id` int(11) NOT NULL,
  `coupon_code` varchar(50) DEFAULT NULL,
  `coupon_type` int(11) DEFAULT NULL,
  `coupon_value` int(11) DEFAULT NULL,
  `coupon_scope` int(11) DEFAULT 1,
  `coupon_usage_limit` int(11) DEFAULT 0,
  `coupon_used_count` int(11) DEFAULT 0,
  `coupon_expiry` date DEFAULT NULL,
  `coupon_condition` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_coupon`
--

INSERT INTO `tbl_coupon` (`coupon_id`, `coupon_code`, `coupon_type`, `coupon_value`, `coupon_scope`, `coupon_usage_limit`, `coupon_used_count`, `coupon_expiry`, `coupon_condition`, `created_at`, `updated_at`) VALUES
(9, '12', 2, 100, 1, 3, 0, '2026-04-08', 1, '2026-04-06 15:30:02', NULL),
(10, '15', 1, 100, 2, 3, 3, '2026-04-08', 1, '2026-04-06 16:34:45', NULL),
(12, 'sale30', 1, 30, 2, 100, 1, '2026-04-08', 1, '2026-04-06 17:48:53', NULL),
(17, '11', 1, 100, 1, 2, 0, '2026-04-07', 1, '2026-04-06 18:42:25', NULL),
(18, 'sale25', 1, 25, 1, 5, 2, '2026-04-08', 1, '2026-04-07 01:39:47', NULL),
(19, '155', 1, 50, 1, 3, 0, '2026-04-03', 1, '2026-04-07 02:41:49', NULL),
(20, '234', 1, 50, 2, 1, 0, '2026-04-06', 1, '2026-04-07 03:02:30', NULL),
(21, '432', 1, 50, 2, 2, 1, '2026-04-08', 1, '2026-04-07 03:03:12', NULL),
(22, 'sale10', 1, 50, 2, 2, 0, '2026-04-08', 1, '2026-04-07 03:15:19', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_coupon_product`
--

CREATE TABLE `tbl_coupon_product` (
  `id` int(11) NOT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `product_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_coupon_product`
--

INSERT INTO `tbl_coupon_product` (`id`, `coupon_id`, `product_id`) VALUES
(1, 10, 9),
(3, 12, 8),
(4, 20, 8),
(5, 21, 8),
(6, 22, 8),
(7, 22, 9);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_coupon_usage`
--

CREATE TABLE `tbl_coupon_usage` (
  `id` int(11) NOT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_coupon_usage`
--

INSERT INTO `tbl_coupon_usage` (`id`, `coupon_id`, `user_id`, `created_at`) VALUES
(4, 10, 3, '2026-04-06 16:47:29'),
(5, 10, 3, '2026-04-06 17:06:56'),
(6, 10, 3, '2026-04-06 17:08:42'),
(7, 12, 3, '2026-04-06 18:38:38'),
(8, 18, 3, '2026-04-07 01:40:30'),
(9, 18, 3, '2026-04-07 02:33:52'),
(10, 21, 3, '2026-04-07 03:04:11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_oder`
--

CREATE TABLE `tbl_oder` (
  `oder_id` int(10) UNSIGNED NOT NULL,
  `oder_soluong` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `oder_id_user` int(11) NOT NULL,
  `oder_status` int(10) NOT NULL,
  `oder_id_product` int(10) NOT NULL,
  `order_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_oder`
--

INSERT INTO `tbl_oder` (`oder_id`, `oder_soluong`, `created_at`, `updated_at`, `oder_id_user`, `oder_status`, `oder_id_product`, `order_id`) VALUES
(39, 1, NULL, '2026-04-07 02:10:20', 3, 1, 10, 20),
(40, 1, NULL, NULL, 3, 1, 14, 21),
(41, 1, NULL, NULL, 3, 1, 11, 22),
(43, 1, NULL, NULL, 3, 1, 9, 23),
(44, 1, NULL, NULL, 3, 0, 8, 23),
(45, 1, NULL, NULL, 3, 2, 8, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_order_main`
--

CREATE TABLE `tbl_order_main` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_order_main`
--

INSERT INTO `tbl_order_main` (`order_id`, `user_id`, `name`, `address`, `phone`, `total`, `payment_method`, `created_at`, `status`) VALUES
(20, 3, 'NGUYỄN THANH HIẾU', 'fsfsfds', '0336926822', 225000, NULL, '2026-04-07 01:40:30', 0),
(21, 3, 'NGUYỄN THANH HIẾU', 'fsfsfds', '0336926822', 57000, NULL, '2026-04-07 02:33:52', 0),
(22, 3, 'NGUYỄN THANH HIẾU', 'fsfsfds', '0336926822', 13000, NULL, '2026-04-07 02:45:05', 0),
(23, 3, 'NGUYỄN THANH HIẾU', 'fsfsfds', '0336926822', 138100, NULL, '2026-04-07 03:04:11', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_product`
--

CREATE TABLE `tbl_product` (
  `product_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `product_name` text NOT NULL,
  `product_price` varchar(255) NOT NULL,
  `product_desc` text NOT NULL,
  `product_content` text NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_product`
--

INSERT INTO `tbl_product` (`product_id`, `category_id`, `brand_id`, `product_name`, `product_price`, `product_desc`, `product_content`, `product_image`, `product_status`, `created_at`, `updated_at`) VALUES
(8, 1, 1, 'Táo đài loan', '230000', 'Trong thế giới của những trái mận đỏ, Mận Úc October Sun mang trong mình một câu chuyện khác biệt. Không rực rỡ như sắc đỏ thẫm thường thấy, lớp vỏ của October Sun khoác lên mình màu hồng cam ấm áp, như ánh mặt trời cuối thu lặng lẽ tỏa sáng trên những vườn cây nước Úc. Với hương vị ngọt ngào, thơm ngon và giá trị dinh dưỡng cao, mận October Sun là lựa chọn hoàn hảo cho những ai yêu thích trái cây nhập khẩu cao cấp.', 'Trong thế giới của những trái mận đỏ, Mận Úc October Sun mang trong mình một câu chuyện khác biệt. Không rực rỡ như sắc đỏ thẫm thường thấy, lớp vỏ của October Sun khoác lên mình màu hồng cam ấm áp, như ánh mặt trời cuối thu lặng lẽ tỏa sáng trên những vườn cây nước Úc. Với hương vị ngọt ngào, thơm ngon và giá trị dinh dưỡng cao, mận October Sun là lựa chọn hoàn hảo cho những ai yêu thích trái cây nhập khẩu cao cấp.', '1775485734_231.jpg', 1, '2026-04-06 14:28:54', '2026-04-06 14:28:54'),
(9, 3, 1, 'Táo la hán', '23100', 'Trong thế giới của những trái mận đỏ, Mận Úc October Sun mang trong mình một câu chuyện khác biệt. Không rực rỡ như sắc đỏ thẫm thường thấy, lớp vỏ của October Sun khoác lên mình màu hồng cam ấm áp, như ánh mặt trời cuối thu lặng lẽ tỏa sáng trên những vườn cây nước Úc. Với hương vị ngọt ngào, thơm ngon và giá trị dinh dưỡng cao, mận October Sun là lựa chọn hoàn hảo cho những ai yêu thích trái cây nhập khẩu cao cấp.', 'Trong thế giới của những trái mận đỏ, Mận Úc October Sun mang trong mình một câu chuyện khác biệt. Không rực rỡ như sắc đỏ thẫm thường thấy, lớp vỏ của October Sun khoác lên mình màu hồng cam ấm áp, như ánh mặt trời cuối thu lặng lẽ tỏa sáng trên những vườn cây nước Úc. Với hương vị ngọt ngào, thơm ngon và giá trị dinh dưỡng cao, mận October Sun là lựa chọn hoàn hảo cho những ai yêu thích trái cây nhập khẩu cao cấp.', '1775487790_266.jpg', 1, '2026-04-06 15:03:10', '2026-04-06 15:03:10'),
(10, 1, 1, 'Táo quân', '300000', 'Trong thế giới của những trái mận đỏ, Mận Úc October Sun mang trong mình một câu chuyện khác biệt. Không rực rỡ như sắc đỏ thẫm thường thấy, lớp vỏ của October Sun khoác lên mình màu hồng cam ấm áp, như ánh mặt trời cuối thu lặng lẽ tỏa sáng trên những vườn cây nước Úc. Với hương vị ngọt ngào, thơm ngon và giá trị dinh dưỡng cao, mận October Sun là lựa chọn hoàn hảo cho những ai yêu thích trái cây nhập khẩu cao cấp.', 'Trong thế giới của những trái mận đỏ, Mận Úc October Sun mang trong mình một câu chuyện khác biệt. Không rực rỡ như sắc đỏ thẫm thường thấy, lớp vỏ của October Sun khoác lên mình màu hồng cam ấm áp, như ánh mặt trời cuối thu lặng lẽ tỏa sáng trên những vườn cây nước Úc. Với hương vị ngọt ngào, thơm ngon và giá trị dinh dưỡng cao, mận October Sun là lựa chọn hoàn hảo cho những ai yêu thích trái cây nhập khẩu cao cấp.', '1775525494_71.jpg', 1, '2026-04-07 01:31:34', '2026-04-07 01:31:34'),
(11, 2, 1, 'Chuối', '13000', 'Trong thế giới của những trái mận đỏ, Mận Úc October Sun mang trong mình một câu chuyện khác biệt. Không rực rỡ như sắc đỏ thẫm thường thấy, lớp vỏ của October Sun khoác lên mình màu hồng cam ấm áp, như ánh mặt trời cuối thu lặng lẽ tỏa sáng trên những vườn cây nước Úc. Với hương vị ngọt ngào, thơm ngon và giá trị dinh dưỡng cao, mận October Sun là lựa chọn hoàn hảo cho những ai yêu thích trái cây nhập khẩu cao cấp.', 'Trong thế giới của những trái mận đỏ, Mận Úc October Sun mang trong mình một câu chuyện khác biệt. Không rực rỡ như sắc đỏ thẫm thường thấy, lớp vỏ của October Sun khoác lên mình màu hồng cam ấm áp, như ánh mặt trời cuối thu lặng lẽ tỏa sáng trên những vườn cây nước Úc. Với hương vị ngọt ngào, thơm ngon và giá trị dinh dưỡng cao, mận October Sun là lựa chọn hoàn hảo cho những ai yêu thích trái cây nhập khẩu cao cấp.', '1775525521_105.jpg', 1, '2026-04-07 01:32:01', '2026-04-07 01:32:01'),
(12, 5, 1, 'Nho mỹ', '34000', 'Trong thế giới của những trái mận đỏ, Mận Úc October Sun mang trong mình một câu chuyện khác biệt. Không rực rỡ như sắc đỏ thẫm thường thấy, lớp vỏ của October Sun khoác lên mình màu hồng cam ấm áp, như ánh mặt trời cuối thu lặng lẽ tỏa sáng trên những vườn cây nước Úc. Với hương vị ngọt ngào, thơm ngon và giá trị dinh dưỡng cao, mận October Sun là lựa chọn hoàn hảo cho những ai yêu thích trái cây nhập khẩu cao cấp.', 'Trong thế giới của những trái mận đỏ, Mận Úc October Sun mang trong mình một câu chuyện khác biệt. Không rực rỡ như sắc đỏ thẫm thường thấy, lớp vỏ của October Sun khoác lên mình màu hồng cam ấm áp, như ánh mặt trời cuối thu lặng lẽ tỏa sáng trên những vườn cây nước Úc. Với hương vị ngọt ngào, thơm ngon và giá trị dinh dưỡng cao, mận October Sun là lựa chọn hoàn hảo cho những ai yêu thích trái cây nhập khẩu cao cấp.', '1775525578_548.jpg', 1, '2026-04-07 01:32:58', '2026-04-07 01:32:58'),
(13, 6, 1, 'Cam', '34000', 'Trong thế giới của những trái mận đỏ, Mận Úc October Sun mang trong mình một câu chuyện khác biệt. Không rực rỡ như sắc đỏ thẫm thường thấy, lớp vỏ của October Sun khoác lên mình màu hồng cam ấm áp, như ánh mặt trời cuối thu lặng lẽ tỏa sáng trên những vườn cây nước Úc. Với hương vị ngọt ngào, thơm ngon và giá trị dinh dưỡng cao, mận October Sun là lựa chọn hoàn hảo cho những ai yêu thích trái cây nhập khẩu cao cấp.', 'Trong thế giới của những trái mận đỏ, Mận Úc October Sun mang trong mình một câu chuyện khác biệt. Không rực rỡ như sắc đỏ thẫm thường thấy, lớp vỏ của October Sun khoác lên mình màu hồng cam ấm áp, như ánh mặt trời cuối thu lặng lẽ tỏa sáng trên những vườn cây nước Úc. Với hương vị ngọt ngào, thơm ngon và giá trị dinh dưỡng cao, mận October Sun là lựa chọn hoàn hảo cho những ai yêu thích trái cây nhập khẩu cao cấp.', '1775525753_154.jpg', 1, '2026-04-07 01:35:53', '2026-04-07 01:35:53'),
(14, 3, 1, 'Dâu', '76000', 'Trong thế giới của những trái mận đỏ, Mận Úc October Sun mang trong mình một câu chuyện khác biệt. Không rực rỡ như sắc đỏ thẫm thường thấy, lớp vỏ của October Sun khoác lên mình màu hồng cam ấm áp, như ánh mặt trời cuối thu lặng lẽ tỏa sáng trên những vườn cây nước Úc. Với hương vị ngọt ngào, thơm ngon và giá trị dinh dưỡng cao, mận October Sun là lựa chọn hoàn hảo cho những ai yêu thích trái cây nhập khẩu cao cấp.', 'Trong thế giới của những trái mận đỏ, Mận Úc October Sun mang trong mình một câu chuyện khác biệt. Không rực rỡ như sắc đỏ thẫm thường thấy, lớp vỏ của October Sun khoác lên mình màu hồng cam ấm áp, như ánh mặt trời cuối thu lặng lẽ tỏa sáng trên những vườn cây nước Úc. Với hương vị ngọt ngào, thơm ngon và giá trị dinh dưỡng cao, mận October Sun là lựa chọn hoàn hảo cho những ai yêu thích trái cây nhập khẩu cao cấp.', '1775525794_129.jpg', 1, '2026-04-07 01:36:34', '2026-04-07 01:36:34'),
(15, 1, 1, 'mmm', '3454354', 'sádafsdfsđfsdf', 'sadfsdafsdafsdf', '1775529397_117.jpg', 1, '2026-04-07 02:36:37', '2026-04-07 02:36:37'),
(16, 1, 1, 'jsjhshjfsdsdf', '3432666', 'sdfdsfsdafsdfsadf', 'sdafsafsdfdsd', '1775529418_572.jpg', 1, '2026-04-07 02:36:58', '2026-04-07 02:36:58'),
(17, 2, 1, 'jajhfsfsdf', '234324', 'sádafsdafsdaf', 'sadfsdafsdaf', '1775529543_64.jpg', 1, '2026-04-07 02:39:03', '2026-04-07 02:39:03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'hieu', 'hieu@2004', NULL, '$2y$10$RnsyoEcC7Op8ZWhlCm02vO7X1y0oHZxDWX9bNd3JkDW53RN07NxPW', NULL, NULL, NULL),
(2, 'hieu@2004', 'sgs@gmail.com', NULL, '$2y$10$PCJeaFx2eW0muhNI4FFRiek06VcHOBNxGgP2dkDdJfOmxZsHFm00S', NULL, NULL, NULL),
(3, 'hieuuuu', 'nhieu@gmail.com', NULL, '$2y$10$zv9qmw1PIXm11qQvO.IxaeMe/3vC6MP4O1bnIhLJwPuAIZdNkUJgO', NULL, NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Chỉ mục cho bảng `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Chỉ mục cho bảng `tbl_category_product`
--
ALTER TABLE `tbl_category_product`
  ADD PRIMARY KEY (`category_id`);

--
-- Chỉ mục cho bảng `tbl_coupon`
--
ALTER TABLE `tbl_coupon`
  ADD PRIMARY KEY (`coupon_id`),
  ADD UNIQUE KEY `coupon_code` (`coupon_code`);

--
-- Chỉ mục cho bảng `tbl_coupon_product`
--
ALTER TABLE `tbl_coupon_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_coupon` (`coupon_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `tbl_coupon_usage`
--
ALTER TABLE `tbl_coupon_usage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupon_id` (`coupon_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `tbl_oder`
--
ALTER TABLE `tbl_oder`
  ADD PRIMARY KEY (`oder_id`),
  ADD KEY `fk_order_detail` (`order_id`);

--
-- Chỉ mục cho bảng `tbl_order_main`
--
ALTER TABLE `tbl_order_main`
  ADD PRIMARY KEY (`order_id`);

--
-- Chỉ mục cho bảng `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`product_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `admin_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `tbl_category_product`
--
ALTER TABLE `tbl_category_product`
  MODIFY `category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `tbl_coupon`
--
ALTER TABLE `tbl_coupon`
  MODIFY `coupon_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `tbl_coupon_product`
--
ALTER TABLE `tbl_coupon_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `tbl_coupon_usage`
--
ALTER TABLE `tbl_coupon_usage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `tbl_oder`
--
ALTER TABLE `tbl_oder`
  MODIFY `oder_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT cho bảng `tbl_order_main`
--
ALTER TABLE `tbl_order_main`
  MODIFY `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `product_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `tbl_coupon_product`
--
ALTER TABLE `tbl_coupon_product`
  ADD CONSTRAINT `fk_coupon` FOREIGN KEY (`coupon_id`) REFERENCES `tbl_coupon` (`coupon_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_coupon_product_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`product_id`);

--
-- Các ràng buộc cho bảng `tbl_coupon_usage`
--
ALTER TABLE `tbl_coupon_usage`
  ADD CONSTRAINT `fk_coupon_usage_coupon` FOREIGN KEY (`coupon_id`) REFERENCES `tbl_coupon` (`coupon_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_coupon_usage_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `tbl_oder`
--
ALTER TABLE `tbl_oder`
  ADD CONSTRAINT `fk_order_detail` FOREIGN KEY (`order_id`) REFERENCES `tbl_order_main` (`order_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
