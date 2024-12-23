-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 21, 2024 lúc 04:50 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `quanlyksk`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admins`
--

CREATE TABLE `admins` (
  `id` int(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admins`
--

INSERT INTO `admins` (`id`, `email`, `password`, `admin_id`, `created_at`, `updated_at`) VALUES
(2, 'ngocvy@gmail.com', '$2y$12$0L3U9gLp8O3MlZhmqSiDsuwkMV93vk2PiOxgmo4IW6Jw7Lqv2DjoO', 2, '2024-12-19 11:52:36', '2024-12-19 04:52:36');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('captcha_18a1e3188a201db5a324a35511e2a5bb', 's:9:\"23 + 7 = \";', 1734751436),
('captcha_290ebfb4d9e5750ba489ce2c7faa2380', 's:9:\"30 + 7 = \";', 1734688494),
('captcha_35cede4c6e42430294153569dccd6d03', 'a:6:{i:0;s:1:\"e\";i:1;s:1:\"3\";i:2;s:1:\"z\";i:3;s:1:\"y\";i:4;s:1:\"e\";i:5;s:1:\"n\";}', 1734682989),
('captcha_550f249d23092cfdba11440219913273', 'a:6:{i:0;s:1:\"6\";i:1;s:1:\"6\";i:2;s:1:\"y\";i:3;s:1:\"u\";i:4;s:1:\"j\";i:5;s:1:\"p\";}', 1734688625),
('captcha_7a877e1eac7f93708c6b145ab3dc8e7c', 's:9:\"28 + 1 = \";', 1734782794),
('captcha_83c25400867cbcba4d3bf3cd6c86bd1b', 's:9:\"13 + 7 = \";', 1734748304),
('captcha_8c894be1db817966b40279e73f13f28b', 's:9:\"18 + 1 = \";', 1734688581),
('captcha_8e72f64854ef0d437aab601488de4b43', 's:9:\"23 + 2 = \";', 1734680257),
('captcha_91f5668f809c3b62159f0cb477aa8777', 'a:6:{i:0;s:1:\"j\";i:1;s:1:\"g\";i:2;s:1:\"z\";i:3;s:1:\"1\";i:4;s:1:\"q\";i:5;s:1:\"c\";}', 1734688875),
('captcha_aa605953a7bdda1f44a43f6c719a3f87', 's:9:\"15 + 1 = \";', 1734682259),
('captcha_af9606e52e35a62507a8d23936873d99', 's:9:\"11 + 8 = \";', 1734685110),
('captcha_c7cb31c294484efe146a1aa718e10897', 'a:6:{i:0;s:1:\"t\";i:1;s:1:\"4\";i:2;s:1:\"r\";i:3;s:1:\"b\";i:4;s:1:\"1\";i:5;s:1:\"p\";}', 1734748308),
('captcha_cad045c79434bf9e26e804fa4a741310', 's:9:\"12 + 5 = \";', 1734681513),
('captcha_ce548d03cf68c922c65d339638f076f1', 's:9:\"14 + 8 = \";', 1734682162),
('captcha_de6905c3e6da8170ba41371a75c13efe', 'a:6:{i:0;s:1:\"2\";i:1;s:1:\"u\";i:2;s:1:\"z\";i:3;s:1:\"e\";i:4;s:1:\"e\";i:5;s:1:\"d\";}', 1734705264),
('captcha_e1227a9571d59775c969d72c6825bf9c', 's:9:\"20 + 2 = \";', 1734681520),
('captcha_e8ccfef3939a20081bad64c50f14af52', 'a:6:{i:0;s:1:\"a\";i:1;s:1:\"u\";i:2;s:1:\"r\";i:3;s:1:\"c\";i:4;s:1:\"9\";i:5;s:1:\"e\";}', 1734680259),
('captcha_fd9d90494d70daa37782d646ae33fbf8', 's:9:\"11 + 1 = \";', 1734682307);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cakham`
--

CREATE TABLE `cakham` (
  `cakham_id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `time_start` time NOT NULL,
  `time_finish` time NOT NULL,
  `total_time` varchar(255) NOT NULL,
  `extra_cost` decimal(10,0) DEFAULT NULL,
  `doctor_id` int(10) UNSIGNED NOT NULL,
  `location_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cakham`
--

INSERT INTO `cakham` (`cakham_id`, `date`, `time_start`, `time_finish`, `total_time`, `extra_cost`, `doctor_id`, `location_id`, `created_at`, `updated_at`, `created_by`) VALUES
(2, '2024-12-19', '10:00:00', '11:00:00', '60', 50000, 2, 1, '2024-12-18 17:45:50', NULL, 1),
(3, '2024-12-27', '00:50:00', '06:50:00', '30', 0, 8, 1, '2024-12-21 03:05:36', NULL, NULL),
(4, '2024-12-22', '09:27:00', '17:38:00', '30', 0, 5, 2, '2024-12-21 03:05:46', NULL, NULL),
(5, '2024-12-24', '09:39:00', '21:39:00', '30', 50000, 3, 1, '2024-12-21 02:40:18', NULL, NULL),
(6, '2024-12-23', '09:05:00', '21:05:00', '30', 50000, 7, 1, '2024-12-21 03:05:23', NULL, NULL),
(7, '2024-12-23', '09:06:00', '17:06:00', '30', 0, 4, 3, '2024-12-21 03:06:34', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `doctors`
--

CREATE TABLE `doctors` (
  `id` int(10) UNSIGNED NOT NULL,
  `HoTen` varchar(255) NOT NULL,
  `ChucVu` varchar(255) NOT NULL,
  `PhiCoBan` decimal(10,0) NOT NULL,
  `specialty_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `location_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `doctors`
--

INSERT INTO `doctors` (`id`, `HoTen`, `ChucVu`, `PhiCoBan`, `specialty_id`, `created_at`, `updated_at`, `created_by`, `location_id`) VALUES
(1, 'BS. Nguyễn Văn A', 'Bác sĩ chính', 500000, 1, '2024-12-21 02:48:47', '2024-12-20 19:48:47', 1, 2),
(2, 'BS.Trần Thị B', 'Trưởng khoa', 700000, 2, '2024-12-21 02:48:52', '2024-12-20 19:48:52', 1, 2),
(3, 'BS. Trần Văn Tiến', 'Bác sĩ thường', 300000, 4, '2024-12-21 02:41:43', '2024-12-20 19:41:43', NULL, 1),
(4, 'BS. Nguyễn Hữu Thịnh', 'Trưởng khoa', 500000, 3, '2024-12-21 02:42:43', '2024-12-20 19:42:43', NULL, 3),
(5, 'BS. Đinh Văn Dũng', 'Bác sĩ chính', 500000, 2, '2024-12-21 03:02:59', '2024-12-20 20:02:59', NULL, 2),
(6, 'BS. Nguyễn Mai Hoa', 'Trưởng khoa', 700000, 4, '2024-12-20 19:52:26', '2024-12-20 19:52:26', NULL, 3),
(7, 'BS. Đỗ Thị Dung', 'Bác sĩ thường', 300000, 1, '2024-12-21 03:02:25', '2024-12-20 20:02:25', NULL, 1),
(8, 'BS. Mai Đinh Tùng', 'Bác sĩ chính', 500000, 3, '2024-12-21 03:03:48', '2024-12-20 20:03:48', NULL, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `enrolls`
--

CREATE TABLE `enrolls` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `total_cost` decimal(10,2) NOT NULL,
  `date` date DEFAULT NULL,
  `time_slot` text NOT NULL,
  `patient_id` int(10) UNSIGNED NOT NULL,
  `doctor_id` int(10) UNSIGNED NOT NULL,
  `specialty_id` int(10) UNSIGNED NOT NULL,
  `location_id` int(10) UNSIGNED NOT NULL,
  `reason` text DEFAULT NULL,
  `result_pdf` text DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_admin` int(10) UNSIGNED DEFAULT NULL,
  `updated_by_admin` int(10) UNSIGNED DEFAULT NULL,
  `updated_by_user` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `enrolls`
--

INSERT INTO `enrolls` (`id`, `status`, `total_cost`, `date`, `time_slot`, `patient_id`, `doctor_id`, `specialty_id`, `location_id`, `reason`, `result_pdf`, `updated_at`, `created_at`, `created_by_admin`, `updated_by_admin`, `updated_by_user`) VALUES
(2, 1, 350000.00, '2024-12-09', '2024-12-16', 12, 1, 1, 1, NULL, 'pdf/result_2.pdf', '2024-12-18 08:36:41', '2024-12-09 17:23:32', NULL, NULL, NULL),
(13, 0, 550000.00, '2024-12-09', '8:00 - 11:00', 12, 2, 3, 1, NULL, 'pdf/result_13.pdf', '2024-12-19 03:39:04', NULL, NULL, NULL, NULL),
(15, 0, 750000.00, '2024-12-19', '10:00 - 11:00', 22, 2, 2, 1, NULL, NULL, '2024-12-19 04:34:04', '2024-12-19 18:34:04', NULL, NULL, NULL),
(16, 0, 750000.00, '2024-12-19', '10:00 - 11:00', 22, 2, 2, 1, NULL, NULL, '2024-12-19 04:34:32', '2024-12-19 18:34:32', NULL, NULL, NULL),
(17, 1, 500000.00, '2024-12-23', '10:06 - 10:36', 28, 4, 3, 3, NULL, NULL, '2024-12-21 01:36:52', NULL, NULL, 2, NULL),
(18, 0, 350000.00, '2024-12-23', '09:05 - 09:35', 25, 7, 1, 1, NULL, 'pdf/result_18.pdf', '2024-12-21 05:36:34', '2024-12-21 10:06:57', NULL, 2, NULL),
(19, 1, 350000.00, '2024-12-23', '09:35 - 10:05', 30, 7, 1, 1, NULL, 'pdf/result_19.pdf', '2024-12-20 22:07:59', '2024-12-21 10:41:16', NULL, NULL, NULL),
(20, 2, 350000.00, '2024-12-23', '10:05 - 10:35', 30, 7, 1, 1, NULL, NULL, '2024-12-21 06:16:35', '2024-12-21 19:08:12', NULL, NULL, NULL),
(26, 0, 350000.00, '2024-12-23', '09:05 - 09:35', 30, 7, 1, 1, NULL, NULL, '2024-12-21 06:19:01', '2024-12-21 20:19:01', NULL, NULL, NULL),
(27, 0, 350000.00, '2024-12-23', '17:35 - 18:05', 30, 7, 1, 1, NULL, NULL, '2024-12-21 06:53:00', '2024-12-21 20:53:00', NULL, NULL, NULL);

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
-- Cấu trúc bảng cho bảng `info_admins`
--

CREATE TABLE `info_admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `HoTen` varchar(255) NOT NULL,
  `NgaySinh` date NOT NULL,
  `SDT` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `info_admins`
--

INSERT INTO `info_admins` (`id`, `HoTen`, `NgaySinh`, `SDT`, `created_at`, `updated_at`) VALUES
(2, 'Hoàng Ngọc Vy', '2002-11-22', '0934567890', '2024-12-19 09:27:15', '2024-12-19 09:27:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `info_patients`
--

CREATE TABLE `info_patients` (
  `id` int(10) UNSIGNED NOT NULL,
  `HoTen` varchar(255) NOT NULL,
  `NgaySinh` date NOT NULL,
  `GioiTinh` int(1) NOT NULL,
  `DiaChi` text NOT NULL,
  `province` text NOT NULL,
  `district` text NOT NULL,
  `ward` text NOT NULL,
  `sdt` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `info_patients`
--

INSERT INTO `info_patients` (`id`, `HoTen`, `NgaySinh`, `GioiTinh`, `DiaChi`, `province`, `district`, `ward`, `sdt`, `created_at`, `updated_at`, `created_by`) VALUES
(12, 'Nguyễn Lan Nhi', '2024-11-25', 0, 'Bạch Mai', 'Thành phố Hà Nội', 'Quận Hai Bà Trưng', 'Phường Bạch Mai', '0943508008', '2024-12-18 15:53:34', '2024-12-18 15:53:34', 1),
(24, 'Mai Nga', '2024-11-26', 0, 'Bạch Mai', 'Tỉnh Bắc Ninh', 'Thị xã Từ Sơn', 'Xã Tương Giang', '0123451412', '2024-12-21 04:56:37', '2024-12-20 08:28:58', 0),
(25, 'Hoàng Ngọc Vy', '2024-11-25', 0, 'Bạch Mai', 'Tỉnh Phú Thọ', 'Huyện Tam Nông', 'Xã Tề Lễ', '0435342511', '2024-12-21 04:56:33', '2024-12-18 09:21:37', 0),
(28, 'Phạm Kiều Anh', '2024-11-19', 0, 'Hàng Bài1', 'Tỉnh Bắc Ninh', 'Thành phố Bắc Ninh', 'Phường Vân Dương', '0432135651', '2024-12-21 04:56:24', '2024-12-19 11:45:40', 2),
(29, 'Ngô Mai Linh', '2024-11-25', 0, 'Bạch Mai', 'Tỉnh Thái Nguyên', 'Huyện Võ Nhai', 'Xã Liên Minh', '0914172412', '2024-12-21 04:56:12', '2024-12-20 01:19:53', 2),
(30, 'Trần Mai Hoa', '2024-11-25', 0, 'số 12 phố Minh Mai', 'Thành phố Hà Nội', 'Quận Hai Bà Trưng', 'Phường Minh Khai', '0923412412', '2024-12-21 04:59:19', '2024-12-21 04:59:19', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
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
-- Cấu trúc bảng cho bảng `job_batches`
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
-- Cấu trúc bảng cho bảng `ketqua`
--

CREATE TABLE `ketqua` (
  `hoso_id` int(10) UNSIGNED NOT NULL,
  `xn_id` int(10) NOT NULL,
  `ketqua` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `ketqua`
--

INSERT INTO `ketqua` (`hoso_id`, `xn_id`, `ketqua`) VALUES
(2, 1, 'có kết quả tiến triển'),
(13, 1, 'bất thường'),
(13, 2, 'ổn'),
(17, 1, 'lượng bạch cầu ít'),
(18, 7, 'bình thường'),
(19, 2, 'bình thường');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaixn`
--

CREATE TABLE `loaixn` (
  `xetnghiem_id` int(10) NOT NULL,
  `tenxn` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `loaixn`
--

INSERT INTO `loaixn` (`xetnghiem_id`, `tenxn`) VALUES
(1, 'Xét nghiệm máu'),
(2, 'Xét nghiệm nước tiểu'),
(3, 'Xét nghiệm XQuang'),
(4, 'Xét nghiệm nội tiết'),
(5, 'Xét nghiệm sinh học phân tử'),
(6, 'Xét nghiệm dịch'),
(7, 'Siêu âm'),
(8, 'Nội soi');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `locations`
--

CREATE TABLE `locations` (
  `location_id` int(10) UNSIGNED NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `location_address` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `locations`
--

INSERT INTO `locations` (`location_id`, `location_name`, `location_address`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'Bệnh viện đa khoa HealthCare chi nhánh TPHCM', '123 Đường A, Quận Thủ  Đức, TP. HCM', '2024-12-21 02:37:56', '2024-12-20 19:37:56', 1, NULL),
(2, 'Bệnh viện đa khoa HealthCare', 'số 8 Trần Duy Hưng, Cầu Giấy, Hà Nội', '2024-12-20 19:35:53', '2024-12-20 19:35:53', 2, NULL),
(3, 'Bệnh viện tư nhân HealthCenter', 'số 12 phố Hàng Bài, Quận Hoàn Kiếm, TP Hà Nội', '2024-12-20 19:37:20', '2024-12-20 19:37:20', 2, NULL);

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `patients`
--

CREATE TABLE `patients` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `patients`
--

INSERT INTO `patients` (`id`, `email`, `password`, `user_id`, `created_at`, `updated_at`, `created_by`) VALUES
(6, 'nhisocun1809@gmail.com', '$2y$12$egau9NxQGRhd8HiLZwhrJej4EGHuE5a0092ipA9.lP/B6RURpMPRq', 12, '2024-12-14 05:25:34', '2024-12-13 11:24:33', 0),
(18, 'mainga203@gmail.com', '$2y$12$bDKA0QSdHMmy9V57ZLA6lu6DobJDA0NYNrCjoQvHBlECjPl9c3Tw2', 24, '2024-12-20 08:28:58', '2024-12-18 09:21:00', 0),
(19, 'namlun@gmail.com', '$2y$12$upUU84/T.uRCPQ55QdE/XubLFGVYfoXRzEkqmbOZlDDojNfHxJt/O', 25, '2024-12-18 09:21:37', '2024-12-18 09:21:37', 0),
(22, 'kieuanh@gmail.com', '$2y$12$IkR25oUsA71uZsjhzKYt1.y1xWLDuUy9JemrvqnxrUKiTYRF61vwy', 28, '2024-12-19 11:45:40', '2024-12-19 04:21:42', 2),
(23, 'mailinh@gmail.com', '$2y$12$P4kWyi9vS2VQ.YM23RJK/e9/bDb6WgsxK8Kj/lfsVQtfTss.Usnlm', 29, '2024-12-20 01:19:53', '2024-12-20 01:19:53', 2),
(24, 'namlunnnn203@gmail.com', '$2y$12$lFVM75wcLHY40zV.bT94PexRP/Ek1Cogio2DVFlPCtsmXteGRZCy6', 30, '2024-12-20 20:32:40', '2024-12-20 20:32:40', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
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
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('8MDlgQi6DUTXQm8TsS3Zx714pnoqbmoJ4ahJCfuE', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo5OntzOjY6Il90b2tlbiI7czo0MDoiTmR1Rm83aTdKVmx6dFNNZFprZ014VzlndVF4STJWb0NuWkRCNko0ViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly9sb2NhbGhvc3QvcXVhbmx5a3NrL2FkbWluL2FsbC1hZG1pbnMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjc6InVzZXJfaWQiO2k6MjQ7czo4OiJhZG1pbl9pZCI7aToyO3M6NTU6ImxvZ2luX3BhdGllbnRzXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjQ7czoyOiJpZCI7czoyOiIyNyI7czo3OiJtZXNzYWdlIjtzOjUxOiJYw7NhIHTDoGkga2hv4bqjbiB2w6AgdGjDtG5nIHRpbiBhZG1pbiB0aMOgbmggY8O0bmciO3M6NTM6ImxvZ2luX2FkbWluc181OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1734796117);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `specialties`
--

CREATE TABLE `specialties` (
  `specialty_id` int(10) UNSIGNED NOT NULL,
  `specialty` varchar(255) NOT NULL,
  `mota` text DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `specialties`
--

INSERT INTO `specialties` (`specialty_id`, `specialty`, `mota`, `updated_at`, `created_at`, `created_by`) VALUES
(1, 'Nhi khoa', 'Khám và điều trị các bệnh cho trẻ em', NULL, '2024-12-11 01:15:00', NULL),
(2, 'Tim mạch', 'Khám và điều trị các bệnh về tim', '2024-12-21 08:42:18', '2024-12-21 08:42:18', 4),
(3, 'Răng hàm mặt', 'Khám và điều trị các bệnh về răng', '2024-12-19 03:17:16', '2024-12-19 02:50:23', 2),
(4, 'Da liễu', 'Khám và điều trị các bệnh về da', '2024-12-19 04:20:09', '2024-12-19 04:20:09', 2);

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
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cakham`
--
ALTER TABLE `cakham`
  ADD PRIMARY KEY (`cakham_id`),
  ADD KEY `fk_cakham_admins` (`created_by`),
  ADD KEY `fk_cakham_doctors` (`doctor_id`),
  ADD KEY `fk_cakham_locations` (`location_id`);

--
-- Chỉ mục cho bảng `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_doctors_admins` (`created_by`),
  ADD KEY `fk_doctors_specialties` (`specialty_id`),
  ADD KEY `fk_location` (`location_id`);

--
-- Chỉ mục cho bảng `enrolls`
--
ALTER TABLE `enrolls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_enrolls_updated_by_user` (`updated_by_user`),
  ADD KEY `fk_enrolls_admins` (`created_by_admin`),
  ADD KEY `fk_enrolls_doctors` (`doctor_id`),
  ADD KEY `fk_enrolls_info_patients` (`patient_id`),
  ADD KEY `fk_enrolls_locations` (`location_id`),
  ADD KEY `fk_enrolls_specialties` (`specialty_id`),
  ADD KEY `fk_enrolls_updated_by_admins` (`updated_by_admin`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `info_admins`
--
ALTER TABLE `info_admins`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `info_patients`
--
ALTER TABLE `info_patients`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ketqua`
--
ALTER TABLE `ketqua`
  ADD PRIMARY KEY (`hoso_id`,`xn_id`),
  ADD KEY `fk_xn` (`xn_id`);

--
-- Chỉ mục cho bảng `loaixn`
--
ALTER TABLE `loaixn`
  ADD PRIMARY KEY (`xetnghiem_id`);

--
-- Chỉ mục cho bảng `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`location_id`),
  ADD KEY `fk_locations_admins` (`created_by`),
  ADD KEY `fk_locations_updated_by_admins` (`updated_by`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_benhnhan` (`user_id`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `specialties`
--
ALTER TABLE `specialties`
  ADD PRIMARY KEY (`specialty_id`),
  ADD KEY `fk_spe_admins` (`created_by`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `cakham`
--
ALTER TABLE `cakham`
  MODIFY `cakham_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `enrolls`
--
ALTER TABLE `enrolls`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `info_admins`
--
ALTER TABLE `info_admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `info_patients`
--
ALTER TABLE `info_patients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `loaixn`
--
ALTER TABLE `loaixn`
  MODIFY `xetnghiem_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `locations`
--
ALTER TABLE `locations`
  MODIFY `location_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `specialties`
--
ALTER TABLE `specialties`
  MODIFY `specialty_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
