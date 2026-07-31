-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Jul 2026 pada 11.19
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rekapaja`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `accesses`
--

CREATE TABLE `accesses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `accesses`
--

INSERT INTO `accesses` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(2, 3, 17, '2025-01-15 06:39:44', '2025-01-15 06:39:44'),
(3, 3, 25, '2025-01-15 06:40:10', '2025-01-15 06:40:10'),
(4, 3, 22, '2025-01-15 06:40:20', '2025-01-15 06:40:20'),
(5, 3, 20, '2025-01-15 06:40:35', '2025-01-15 06:40:35'),
(8, 3, 33, '2025-02-13 03:02:05', '2025-02-13 03:02:05'),
(11, 7, 40, '2025-04-09 01:11:57', '2025-04-09 01:11:57'),
(13, 5, 30, '2025-04-11 06:20:04', '2025-04-11 06:20:04'),
(14, 3, 41, '2025-04-14 07:05:12', '2025-04-14 07:05:12'),
(16, 13, 42, '2026-06-17 06:57:36', '2026-06-17 06:57:36'),
(19, 5, 31, '2026-07-21 23:39:50', '2026-07-21 23:39:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `category`, `created_at`, `updated_at`) VALUES
(1, 'UMKM', '2025-03-13 08:48:42', '2025-03-13 08:48:42'),
(2, 'Pariwisata', '2025-03-13 08:48:57', '2025-03-13 08:48:57'),
(3, 'Villa', '2025-03-13 08:50:45', '2025-03-13 08:50:45'),
(4, 'Camping', '2025-03-13 08:52:16', '2025-03-13 08:52:16'),
(5, 'Kendaraan', '2025-03-13 08:54:05', '2025-03-13 08:54:05'),
(6, 'Profile', '2025-03-13 08:55:19', '2025-03-13 08:55:19'),
(7, 'sembako', '2025-03-26 23:19:17', '2025-03-26 23:19:17'),
(8, 'Handsock', '2025-04-01 07:54:00', '2025-04-01 07:54:00'),
(9, 'Rumah Handsock', '2025-04-01 07:54:00', '2025-04-01 07:54:00'),
(10, 'Sabun Pencuci', '2025-04-14 06:50:59', '2025-04-14 06:50:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `highlights`
--

CREATE TABLE `highlights` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `available` tinyint(1) NOT NULL DEFAULT 1,
  `rating` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `highlights`
--

INSERT INTO `highlights` (`id`, `product_id`, `image`, `title`, `price`, `description`, `available`, `rating`, `created_at`, `updated_at`) VALUES
(4, 17, 'IMG-20241205-WA0019_20241231032011.webp', 'Lokasi Tenang & Asri', NULL, 'Berada di tengah alam, cocok untuk liburan yang damai.', 1, NULL, '2024-12-31 03:20:11', '2024-12-31 03:20:11'),
(5, 17, 'IMG-20241205-WA0012_20241231032100.webp', 'Fasilitas Lengkap', NULL, 'Villa modern dengan kolam renang dan dapur pribadi.', 1, NULL, '2024-12-31 03:21:00', '2024-12-31 03:21:00'),
(6, 17, 'IMG-20241205-WA0016_20241231032129.webp', 'Layanan Ramah', NULL, 'Staf siap melayani dengan profesional dan penuh kehangatan.', 1, NULL, '2024-12-31 03:21:29', '2024-12-31 03:21:29'),
(7, 16, 'IMG-20241205-WA0006_20241231035137.webp', 'Fasilitas Lengkap', NULL, 'Kamar mandi dan lain-lain', 1, NULL, '2024-12-31 03:51:37', '2024-12-31 03:51:37'),
(8, 16, 'IMG-20241205-WA0002_20241231035204.webp', 'Pemandangan Memukau', NULL, 'Nikmati panorama alam yang indah langsung dari villa.', 1, NULL, '2024-12-31 03:52:05', '2024-12-31 03:52:05'),
(9, 16, 'IMG-20241205-WA0003_20241231035306.webp', 'Privasi Terjamin', NULL, 'Villa eksklusif untuk liburan yang tenang dan nyaman.', 1, NULL, '2024-12-31 03:53:06', '2024-12-31 03:53:06'),
(10, 18, 'IMG-20241205-WA0034_20241231043612.webp', 'Fasilitas Lengkap', NULL, 'Dapur full cooking set', 1, NULL, '2024-12-31 04:36:12', '2024-12-31 04:36:12'),
(11, 18, 'IMG-20241205-WA0037_20241231043755.webp', 'Kamar dengan area luas', NULL, 'Kamar dengan kapasitas hingga 12 orang', 1, NULL, '2024-12-31 04:37:55', '2024-12-31 04:37:55'),
(12, 11, 'Kebun-Teh-Malabar_20241231071754.webp', 'Keindahan Alam Teh Malabar', NULL, 'Nikmati panorama indah dan teh terbaik di Malabar.', 1, NULL, '2024-12-31 07:17:54', '2024-12-31 07:17:54'),
(13, 11, 'perkebunan-teh-peninggalan-bosscha-di-pangalengan_169_20241231071941.webp', 'Wisata Teh yang Menyegarkan', NULL, 'Jelajahi kebun teh Malabar, rasakan kesejukan alam.', 1, NULL, '2024-12-31 07:19:41', '2024-12-31 07:19:41'),
(14, 9, 'villa jerman Foto dari  @zainfoto_20241231072944.webp', 'Keindahan Alam Rumah Putih', NULL, 'Nikmati panorama alam yang memukau di Rumah Putih Cukul.', 1, NULL, '2024-12-31 07:28:23', '2024-12-31 07:29:44'),
(15, 9, '54513330_2257408134531641_4076840707879688841_n_20241231072935.webp', 'Tempat Wisata Rumah Putih C', NULL, 'Eksplorasi wisata yang menenangkan dengan pemandangan alam luar', 1, NULL, '2024-12-31 07:29:35', '2024-12-31 07:29:35'),
(16, 8, 'Kampung-Singkur-3-e1565092849604_20241231084801.webp', 'Eksplorasi Alam Asri', NULL, 'Deskripsi: Nikmati rafting seru dan kuliner tradisional.', 1, NULL, '2024-12-31 08:48:01', '2025-03-20 08:43:47'),
(18, 8, 'snapinstaapp-286788624-405199791341095-569903744759454982-n-1080-28598b7784be39d2a0e7a69c686d02c1-d92790bcc31cba1aff1bc3b6729d8b60_20241231084829.webp', 'Relaksasi di Kampung Singku', NULL, 'Deskripsi: Rasakan ketenangan di alam terbuka nan hijau.', 1, NULL, '2024-12-31 08:48:29', '2024-12-31 08:48:29'),
(19, 10, '239752508-4670768159634824-7604271202362122992-n-bfb992da3e868dc126514a39313affd2-e1b389ccd2770edc612e5e639e26dab3_20241231085240.webp', 'Pesona Alam Terpadu', NULL, 'Nikmati suasana tenang dan segarnya udara pegunungan.', 1, NULL, '2024-12-31 08:52:40', '2024-12-31 08:52:40'),
(20, 10, 'Curug-Panganten-di-musim-hujan-Kang-Ery-Joy_20241231085319.webp', 'Air Terjun Mempesona', NULL, 'Spot foto cantik dengan aliran air yang jernih dan asri.', 1, NULL, '2024-12-31 08:53:19', '2024-12-31 08:53:19'),
(21, 12, 'cileunca_nilqu9_20241231085925.webp', 'Pesona Danau Cileunca', NULL, 'Nikmati panorama danau, udara segar, dan suasana menenangkan.', 1, NULL, '2024-12-31 08:59:25', '2024-12-31 08:59:25'),
(22, 12, '@camping_pangalengan_20241231085949.webp', 'Petualangan Seru', NULL, 'Coba rafting, berkemah, dan aktivitas seru di sekitar danau.', 1, NULL, '2024-12-31 08:59:50', '2024-12-31 08:59:50'),
(23, 7, 'IMG_3041_20241231090629.webp', 'Kelezatan Yogurt Segar', NULL, 'Rasakan sensasi yogurt segar yang sehat dan penuh nutrisi.', 1, NULL, '2024-12-31 09:06:29', '2024-12-31 09:06:29'),
(24, 7, 'IMG_3045c copy_20241231090709.webp', 'Varian Rasa Favorit', NULL, 'Tersedia berbagai rasa unik yang cocok untuk semua selera.', 1, NULL, '2024-12-31 09:07:09', '2024-12-31 09:07:09'),
(25, 13, 'LRM_EXPORT_94371454228616_20191216_225422398_20241231095051.webp', 'Keindahan Alam Cukul', NULL, 'Nikmati udara segar dan hamparan hijau kebun teh.', 1, NULL, '2024-12-31 09:50:52', '2024-12-31 09:50:52'),
(27, 13, 'Lokasi-Sunrise-Point-Cukul-Bandung-1030x541_20241231095152.webp', 'Spot Foto Instagramable', NULL, 'Abadikan momen indah di tengah kebun teh nan asri.', 1, NULL, '2024-12-31 09:51:52', '2024-12-31 09:51:52'),
(28, 14, 'Pia-Kawitan3_20241231095620.webp', 'Rasa Autentik Tradisional', NULL, 'Menghadirkan cita rasa khas yang autentik dari resep turun-temur', 1, NULL, '2024-12-31 09:56:20', '2024-12-31 09:56:20'),
(29, 14, '3753053_BKOI6X2i7Va_eXh6r6EQ9RvG0W18SdSZJw0wQLzMC4c_20241231095650.webp', 'Tekstur Lembut Menggoda', NULL, 'Setiap gigitan memberikan sensasi lembut dan kenikmatan sempurna', 1, NULL, '2024-12-31 09:56:50', '2024-12-31 09:56:50'),
(30, 15, 'images_20241231103253.webp', 'Abon Asep Pos, Lezat dan Be', NULL, 'Nikmati abon dengan rasa istimewa dan kandungan gizi terbaik.', 1, NULL, '2024-12-31 10:32:53', '2024-12-31 10:32:53'),
(31, 15, 'data.jpeg_20241231103338.webp', 'Abon Asep Pos, Pilihan Terb', NULL, 'Abon Asep Pos, kenikmatan dalam setiap gigitan, pilihan sempurna', 1, NULL, '2024-12-31 10:33:39', '2024-12-31 10:33:39'),
(32, 19, 'Screenshot 2025-01-02 113428_20250102043445.webp', 'Udara Sejuk dan Segar', NULL, 'Nikmati udara pegunungan yang menyegarkan sepanjang hari.', 1, NULL, '2025-01-02 04:33:03', '2025-01-02 04:34:46'),
(33, 19, 'Screenshot 2025-01-02 112111_20250102043337.webp', 'Fasilitas Outdoor Asri', NULL, 'Bersantai di taman hijau dengan fasilitas yang nyaman.', 1, NULL, '2025-01-02 04:33:38', '2025-01-02 04:33:38'),
(36, 21, 'Screenshot 2025-01-02 125912_20250102061041.webp', 'Suasana Keluarga Nyaman', NULL, 'Warna tosca menawan, cocok untuk liburan santai bersama keluarga', 1, NULL, '2025-01-02 06:10:41', '2025-01-02 06:10:41'),
(37, 21, 'Screenshot 2025-01-02 130125_20250102061112.webp', 'Fasilitas Lengkap Tosca', NULL, 'Dapur dengan perlengkapan lengkap', 1, NULL, '2025-01-02 06:11:12', '2025-01-02 06:11:12'),
(40, 23, 'Screenshot 2025-01-02 141839_20250102072512.webp', 'Keindahan Alam Sejati', NULL, 'Eksplorasi alam dengan danau, udara segar, dan langit berbintang', 1, NULL, '2025-01-02 07:25:12', '2025-01-02 07:25:12'),
(41, 23, 'Screenshot 2025-01-02 142004_20250102072527.webp', 'Fasilitas Lengkap Modern', NULL, 'Nikmati camping nyaman dengan fasilitas api unggun & kafe.', 1, NULL, '2025-01-02 07:25:27', '2025-01-02 07:25:27'),
(42, 24, 'Nimo-Highland-1068x601_20250102073946.webp', 'Pesona Nimo Highland', NULL, 'Destinasi alam memukau, cocok untuk liburan santai keluarga.', 1, NULL, '2025-01-02 07:39:46', '2025-01-02 07:39:46'),
(43, 25, 'IMG-20241213-WA0002_20250102080040.webp', 'Villa dengan Pemandangan', NULL, 'Nikmati panorama alam indah dari setiap sudut villa.', 1, NULL, '2025-01-02 08:00:40', '2025-01-02 08:00:40'),
(44, 25, 'IMG-20241213-WA0005_20250102080055.webp', 'Fasilitas Lengkap', NULL, 'Dilengkapi dapur, ruang keluarga, dan area outdoor nyaman.', 1, NULL, '2025-01-02 08:00:55', '2025-01-02 08:00:55'),
(45, 26, 'Screenshot 2025-01-02 151604_20250102082158.webp', 'Pemandangan Memukau', NULL, 'Nikmati panorama alam indah langsung dari villa Anda.', 1, NULL, '2025-01-02 08:21:58', '2025-01-02 08:21:58'),
(46, 26, 'Screenshot 2025-01-02 151925_20250102082309.webp', 'Lingkungan Asri', NULL, 'Nikmati lingkungan asri jauh dari hiruk piruk kerumunan.', 1, NULL, '2025-01-02 08:23:09', '2025-01-02 08:23:09'),
(47, 27, 'IMG-20241213-WA0022_20250102090349.webp', 'Penginapan Asri Nyaman', NULL, 'Desain semi villa modern di tengah alam hijau.', 1, NULL, '2025-01-02 09:03:49', '2025-01-02 09:03:49'),
(48, 27, 'IMG-20241213-WA0019_20250102090459.webp', 'Liburan Keluarga Ideal', NULL, 'Fasilitas lengkap untuk pengalaman menginap tak terlupakan.', 1, NULL, '2025-01-02 09:04:59', '2025-01-02 09:04:59'),
(49, 29, 'SUPRA-1_20250127042146.webp', 'Toyota Supra', NULL, 'Keren', 1, NULL, '2025-01-27 04:20:18', '2025-01-27 04:21:47'),
(50, 29, '1-crystal-white-pearl_20250127042224.webp', 'Toyota GR 86', NULL, 'Cool', 1, NULL, '2025-01-27 04:20:32', '2025-01-27 04:22:25'),
(51, 29, 'platinum-white-pearl_20250127043104.webp', 'Corolla Cross', NULL, 'Gagah', 1, NULL, '2025-01-27 04:31:04', '2025-01-27 04:31:04'),
(52, 30, 'Picture4_20250128060025.webp', 'Ayam Bakar Perawan', NULL, 'Ayam Bakar dengan menggunakan ayam muda dan bumbu yang meresap s', 1, NULL, '2025-01-28 06:00:26', '2025-01-28 06:00:26'),
(53, 30, 'Picture4ww_20250128060127.webp', 'Ayam Geprek Merdeka', NULL, 'Ayam Geprek dengan 12 macam sambal bebas pilih', 1, NULL, '2025-01-28 06:01:27', '2025-01-28 06:01:27'),
(54, 30, 'Picture4_20250128060407.webp', 'Ramesan Cumi', NULL, 'Dibuat dari Baby Cumi pilihan plus jukut goreng', 1, NULL, '2025-01-28 06:04:07', '2025-01-28 06:04:07'),
(55, 31, 'MNU_1_20241112175346_optim_20250131070205.webp', 'Chicken Steak', NULL, 'Steak ayam digoreng tepung disajikan dengan kentang dan sayur', 1, NULL, '2025-01-31 07:02:06', '2025-01-31 07:02:06'),
(56, 31, 'MNU_2_20241113103441_optim_20250131070533.webp', 'Sirloin', NULL, 'Steak daging sapi bagian has luar digoreng tepung', 1, NULL, '2025-01-31 07:05:33', '2025-01-31 07:05:33'),
(57, 32, 'MNU_6_20241112175359_thumb_20250131070736.webp', 'Cordon Bleu', NULL, 'Daging ayam filet yang digulung dan diisi dengan keju dan daging', 1, NULL, '2025-01-31 07:07:36', '2025-01-31 07:07:36'),
(58, 31, 'MNU_5_20241113103514_optim_20250131070755.webp', 'Steak Waroeng', NULL, 'Perpaduan steak ayam dan daging sapi digoreng tepung', 1, NULL, '2025-01-31 07:07:55', '2025-01-31 07:07:55'),
(59, 32, 'MNU_2_20241113103441_thumb_20250131070805.webp', 'Sirloin', NULL, 'Steak daging sapi bagian has luar digoreng tepung', 1, NULL, '2025-01-31 07:08:05', '2025-01-31 07:15:28'),
(60, 32, 'MNU_7_20241112175246_thumb_20250131070848.webp', 'Chicken Double', NULL, 'Steak ayam 2 potong digoreng tepung disajikan dengan kentang', 1, NULL, '2025-01-31 07:08:48', '2025-01-31 07:15:16'),
(61, 31, 'MNU_21_20241112174600_optim_20250131071052.webp', 'Beef Meltique BBQ', NULL, 'Daging meltique yang lembut di olah dengan cara di grill', 1, NULL, '2025-01-31 07:10:53', '2025-01-31 07:10:53'),
(62, 31, 'MNU_19_20241112175228_optim_20250131071230.webp', 'Chicken BBQ', NULL, 'Daging ayam yang empuk di olah dengan cara di grill / dipanggang', 1, NULL, '2025-01-31 07:12:30', '2025-01-31 07:12:30'),
(63, 32, 'MNU_21_20241112174600_thumb_20250131071458.webp', 'Beef Meltique BBQ', NULL, 'Daging meltique yang lembut di olah dengan cara di grill', 1, NULL, '2025-01-31 07:14:58', '2025-01-31 07:15:05'),
(64, 31, 'MNU_39_20241112180959_optim_20250131071618.webp', 'Paket Chicko', NULL, 'Steak ayam disajikan dengan nasi, mix vegetable, brown sauce', 1, NULL, '2025-01-31 07:16:18', '2025-01-31 07:16:18'),
(65, 32, 'MNU_29_20241113103434_thumb_20250131071644.webp', 'Sirloin Import', NULL, 'Steak daging has luar import yang di olah dengan di grill', 1, NULL, '2025-01-31 07:16:44', '2025-01-31 07:16:44'),
(66, 32, 'MNU_26_20241112175411_thumb_20250131071734.webp', 'Dori Grill', NULL, 'Steak ikan DORI yang lembut dan kaya protein', 1, NULL, '2025-01-31 07:17:34', '2025-01-31 07:17:34'),
(67, 31, 'MNU_87_20241112180353_optim_20250131071822.webp', 'Milkshake Chocolate Special', NULL, 'Milkshake Chocolate dengan tambahan es krim coklat', 1, NULL, '2025-01-31 07:18:22', '2025-01-31 07:18:22'),
(68, 32, 'MNU_1_20241112175346_thumb_20250131071851.webp', 'Steak Waroeng', NULL, 'Perpaduan steak ayam dan daging sapi digoreng', 1, NULL, '2025-01-31 07:18:51', '2025-01-31 07:18:51'),
(69, 32, 'MNU_24_20241112174632_thumb_20250131071951.webp', 'Beef Steak', NULL, 'Steak daging sapi yang lembut dan kaya protein', 1, NULL, '2025-01-31 07:19:51', '2025-01-31 07:19:51'),
(71, 31, 'MNU_97_20241112180346_optim_20250131072040.webp', 'Lychee Tea Ice', NULL, 'Teh Leci Dingin', 1, NULL, '2025-01-31 07:20:40', '2025-01-31 07:20:40'),
(72, 32, 'MNU_18_20241113103713_thumb_20250131072158.webp', 'Tenderloin Double Cheese', NULL, 'Steak daging bagian has dalam 2 potong digoreng tepung disajikan', 1, NULL, '2025-01-31 07:21:58', '2025-01-31 07:21:58'),
(73, 31, 'MNU_114_20241112180251_optim_20250131072237.webp', 'Kopi Susu Gula Aren Ice', NULL, 'Kopi Susu dengan tambahan Gula Aren', 1, NULL, '2025-01-31 07:22:37', '2025-01-31 07:22:37'),
(79, 17, '1000694627_20250318071044.webp', 'Sapi Pangalengan', 300000000, 'Test', 1, NULL, '2025-03-18 07:10:44', '2025-03-18 07:10:44'),
(80, 33, '1000694011_20250321015436.webp', 'Website Simple', 500000, 'Website tipe simpe', 1, NULL, '2025-03-21 01:54:37', '2025-03-21 01:54:37'),
(81, 33, '1000694012_20250321015518.webp', 'Warung Temolate', 650000, 'Warung onis template', 1, NULL, '2025-03-21 01:55:18', '2025-03-21 01:55:18'),
(82, 33, 'three_20250325073104.webp', 'Website a', 300000, 'test', 0, NULL, '2025-03-25 07:31:04', '2025-03-25 07:38:30'),
(83, 33, 'screencapture-localhost-8000-peci-simbol-identitas-dan-keanggunan-budaya-nusantara-2025-03-25-10_09_21_20250325073533.webp', 'Website b', 500000, 'test', 1, NULL, '2025-03-25 07:35:34', '2025-03-25 07:35:34'),
(84, 22, '1000711031_20250326232219.webp', 'Tgm Gelas Plastik (Dus)', 20000, 'Harga per dus', 1, NULL, '2025-03-26 23:22:19', '2025-03-26 23:27:08'),
(85, 22, '1000711033_20250326232827.webp', 'Beras 5 KG  (Merk Sawah)', 75000, 'Beras premium 5 KG Merk Sawah', 1, NULL, '2025-03-26 23:28:27', '2025-03-26 23:28:31'),
(86, 22, '1000711038_20250326234228.webp', 'Le Mineral 15 ltr', 20000, 'Air Galon Kemasan Le Mineral 15 Litrr', 1, NULL, '2025-03-26 23:42:28', '2025-03-26 23:42:30'),
(87, 22, '1000711039_20250326234609.webp', 'Beras 25 KG Sawah Jingga', 380000, 'Sawah Jingga', 1, NULL, '2025-03-26 23:46:09', '2025-03-26 23:46:15'),
(88, 20, 'IMG-20250401-WA0001_20250401094257.webp', 'Handsock 1', 23000, '-', 1, NULL, '2025-04-01 08:42:58', '2025-04-01 08:43:25'),
(89, 20, 'IMG-20250401-WA0007_20250401094320.webp', 'Handsock 2', 23000, '-', 1, NULL, '2025-04-01 08:43:20', '2025-04-01 08:43:24'),
(90, 20, 'IMG-20250401-WA0002_20250401094355.webp', 'Handsock 3', 23000, '-', 1, NULL, '2025-04-01 08:43:55', '2025-04-01 08:43:58'),
(91, 20, 'IMG-20250401-WA0000_20250401094414.webp', 'Handsock 4', 23000, '-', 1, NULL, '2025-04-01 08:44:14', '2025-04-01 08:44:18'),
(92, 20, 'IMG-20250401-WA0005_20250401094434.webp', 'H 5', 23000, '-', 1, NULL, '2025-04-01 08:44:34', '2025-04-01 08:44:59'),
(93, 20, 'IMG-20250401-WA0009_20250401094456.webp', 'H6', 23000, '-', 1, NULL, '2025-04-01 08:44:56', '2025-04-01 08:44:58'),
(94, 20, 'IMG-20250401-WA0011_20250401094519.webp', 'H7', 23000, '-', 1, NULL, '2025-04-01 08:45:19', '2025-04-01 08:45:21'),
(95, 20, 'IMG-20250401-WA0010_20250401094539.webp', 'H8', 23000, '-', 1, NULL, '2025-04-01 08:45:39', '2025-04-01 08:45:41'),
(96, 20, 'IMG-20250401-WA0006_20250401094600.webp', 'H9', 23000, '-', 1, NULL, '2025-04-01 08:46:00', '2025-04-01 08:46:02'),
(97, 20, 'IMG-20250401-WA0003_20250401094618.webp', 'H10', 23000, '-', 1, NULL, '2025-04-01 08:46:18', '2025-04-01 08:46:21'),
(98, 20, 'IMG-20250401-WA0004_20250401094644.webp', 'H11', 23000, '-', 1, NULL, '2025-04-01 08:46:44', '2025-04-01 08:46:47'),
(99, 20, 'IMG-20250401-WA0008_20250401094718.webp', 'H12', 23000, '-', 1, NULL, '2025-04-01 08:47:18', '2025-04-01 08:47:20'),
(100, 41, 'gojes-2_20250414075200.webp', 'Deterejen Liquid', 54000, NULL, 1, NULL, '2025-04-14 06:52:00', '2025-04-14 07:04:51'),
(101, 41, 'GOJES-CUPIR-4-600x600_20250414075200.webp', 'Sabun Cuci Piring', 55000, NULL, 1, NULL, '2025-04-14 06:52:00', '2025-04-14 07:04:53'),
(102, 41, 'GOJES-HAND-SOAP-3-600x600_20250414075200.webp', 'Hand Soap', 53000, NULL, 1, NULL, '2025-04-14 06:52:00', '2025-04-14 07:04:53'),
(103, 41, 'GOJES-KARBOL-PINE-1-600x600_20250414075200.webp', 'Karbol Pine', 60000, NULL, 1, NULL, '2025-04-14 06:52:00', '2025-04-14 07:04:54'),
(104, 41, 'GOJES-KARBOL-SEREH-1-600x600_20250414075200.webp', 'Karbol Sereh', 60000, NULL, 1, NULL, '2025-04-14 06:52:00', '2025-04-14 07:04:55'),
(105, 41, 'GOJES-PEMBERSIH-LANTAI-LEMON-1-600x600_20250414075200.webp', 'Pembersih Lantai Lemo', 53000, NULL, 1, NULL, '2025-04-14 06:52:00', '2025-04-14 07:04:57'),
(106, 41, 'GOJES-PEMBERSIH-LANTAI-SEREH-1-600x599_20250414075200.webp', 'Pembersih Lantai Sereh', 57000, NULL, 1, NULL, '2025-04-14 06:52:00', '2025-04-14 07:04:58'),
(107, 41, 'GOJES-PEWANGI-PAKAIAN-1-600x600_20250414075200.webp', 'Pewangi Pakaian', 145000, NULL, 1, NULL, '2025-04-14 06:52:00', '2025-04-14 07:04:59'),
(108, 41, 'GOJES-PEWANGI-PAKAIAN-600x599_20250414075200.webp', 'Pelicin Pakaian', 52000, NULL, 1, NULL, '2025-04-14 06:52:00', '2025-04-14 07:05:00'),
(123, 40, '9603_20251208023741.webp', 'Testing', 2000, 'Testing', 0, NULL, '2025-12-08 02:37:41', '2025-12-08 02:37:41'),
(127, 22, 'kapalapi_20251208025555.webp', '1 Dus Kapal Api Mix', 230000, 'Kopi Kapal Api Mix', 1, NULL, '2025-12-08 02:55:55', '2025-12-08 03:08:44'),
(129, 22, 'indomie_20251208030636.webp', 'Indomie Mi Instant', 140000, '1 Dus Indomie', 0, NULL, '2025-12-08 03:06:36', '2025-12-08 03:07:19'),
(130, 22, '1_20251208030721.webp', 'Beras SPHP Bulog 5 Kg', 60000, 'Beras SPHP merek Bulog', 0, NULL, '2025-12-08 03:07:21', '2025-12-08 03:07:21'),
(131, 22, 'teh pucuk_20251208030737.webp', 'Teh Pucuk Harum', 65000, '1 Dus Teh Pucuk Harum 350ml', 0, NULL, '2025-12-08 03:07:37', '2025-12-08 03:09:21'),
(132, 22, 'le minerale 330 ml_20251208030933.webp', 'le minerale 330 ml', 50000, '1 Dus le minerale 330 ml', 0, NULL, '2025-12-08 03:09:33', '2025-12-08 03:12:34'),
(133, 22, 'goodday_20251208031236.webp', '1 Dus Kopi Good Day', 190000, 'Kopi Good Day Varian Moccacino', 1, NULL, '2025-12-08 03:12:36', '2025-12-08 03:20:23'),
(134, 22, 'Sierra-Karton-1500ml_20251208031301.webp', 'Air Mineral Sierra All 240', 29500, '1 Dus Isi 48 Botol', 0, NULL, '2025-12-08 03:13:01', '2025-12-08 03:19:20'),
(135, 22, 'le minerale 600ml_20251208031543.webp', 'le minerale 600 ml', 62000, '1 Dus le minerale 600 ml', 0, NULL, '2025-12-08 03:15:43', '2025-12-08 03:18:02'),
(136, 22, 'abc susu_20251208031703.webp', '1 Dus Kopi Abc Susu', 220000, 'Kopi Abc Varian Kopi Susu', 1, NULL, '2025-12-08 03:17:03', '2025-12-08 03:20:21'),
(137, 22, '2_20251208031753.webp', 'Okky Jelly Drink 150 ml', 28000, '1 Dus Isi 24 Cup', 0, NULL, '2025-12-08 03:17:53', '2025-12-08 03:44:35'),
(138, 22, 'le minerale 1500ml_20251208031811.webp', 'le minerale 1500 ml', 65000, '1 Dus le minerale 1500 ml', 0, NULL, '2025-12-08 03:18:11', '2025-12-08 03:20:41'),
(139, 22, 'id-11134207-7r98w-lrphq23nl25jc9 (1)_20251208031935.webp', 'Happy ES Cincau 170ml', 24000, 'Minuman Happy ES Cincau 1 Dus (24pcs)', 1, NULL, '2025-12-08 03:19:35', '2025-12-08 03:27:29'),
(140, 22, '3_20251208032129.webp', 'Mountea Teh 330 ml', 80000, '1 Dus Isi 24 Botol', 0, NULL, '2025-12-08 03:21:30', '2025-12-08 03:21:30'),
(141, 22, 'gudeg_20251208032350.webp', 'Beras 5KG Merk Gudeg', 80000, 'Beras Gudeg', 1, NULL, '2025-12-08 03:23:50', '2025-12-08 03:36:01'),
(142, 22, 'd6639705-949b-4604-8311-17e4f4cecafb.9d03da3269ddac363ca1d2dc6f7df14f_20251208032443.webp', 'Steam Cup & Botol Minuman', 250000, 'Steam Cup Plastik 12–14 Oz (1 Dus)', 0, NULL, '2025-12-08 03:24:43', '2025-12-08 03:24:43'),
(143, 22, '07eae84db28024e577ba5ca9df2ff4fb.png_720x720q80_20251208032733.webp', 'Nipis Madu', 47000, 'Nipis Madu Botol (1 Dus Isi 12 Botol)', 0, NULL, '2025-12-08 03:27:33', '2025-12-08 03:27:33'),
(144, 22, 'd3132328-3219-4231-8eb4-d387b091456d_20251208032910.webp', 'Happy Es Teller BIG 260 ml', 28000, 'Happy Es Teller BIG 1 Dus (24pcs)', 1, NULL, '2025-12-08 03:29:10', '2025-12-08 03:33:48'),
(145, 22, 'ladang pangan_20251208033117.webp', '5KG Beras Ladang Pangan', 85000, 'Beras Ladang Pangan', 1, NULL, '2025-12-08 03:31:17', '2025-12-08 03:36:02'),
(146, 22, 'download (11)_20251208034859.webp', 'Okky Jelly Big 220ml', 45000, 'Okky Jelly Big 1 Dus (24pcs)', 1, NULL, '2025-12-08 03:48:59', '2025-12-08 03:50:46'),
(147, 22, 'ClassTea_20251208035143.webp', 'ClassTea', 24000, '1 dus Classtea', 1, NULL, '2025-12-08 03:51:43', '2025-12-08 04:15:26'),
(148, 22, 'Beras 5 kg_20251208035143.webp', 'Beras 5 kg', 70000, '1 Karung Beras 5 kg', 1, NULL, '2025-12-08 03:51:43', '2025-12-08 04:15:28'),
(149, 22, 'Beras 25 kg_20251208035143.webp', 'Beras 25 kg', 350000, '1 Karung Beras 25 kg', 1, NULL, '2025-12-08 03:51:43', '2025-12-08 04:15:30'),
(150, 22, 'Dus Aqua 1500 ML_20251208035143.webp', 'Aqua 1600 ml', 60000, '1 dus Aqua 1600 ml isi 12 botol', 1, NULL, '2025-12-08 03:51:44', '2025-12-08 04:15:33'),
(151, 22, 'Dus Aqua 600 ML_20251208035144.webp', 'Aqua 600 ml', 55000, '1 dus Aqua 600 ml isi 24 botol', 1, NULL, '2025-12-08 03:51:44', '2025-12-08 04:15:35'),
(152, 22, 'Dus Tulip 1 kg_20251208035144.webp', 'Tepung Tulip 1 kg', 100000, '1 dus Tepung Tulip 1 kg isi 10 pcs', 1, NULL, '2025-12-08 03:51:44', '2025-12-08 04:15:37'),
(153, 22, 'Dus Le Vontea_20251208035144.webp', 'Le Vontea', 25000, '1 dus Le Vontea isi 24 cup', 1, NULL, '2025-12-08 03:51:44', '2025-12-08 04:15:40'),
(154, 42, '1000236125_20260705113040.webp', 'Choco latte', 18000, 'Perpaduan Cokelat, susu, cream', 1, NULL, '2026-06-17 11:52:05', '2026-07-05 10:30:40'),
(155, 42, '1000236040_20260705091151.webp', 'Hazelnut Choco', 20000, 'Perpaduan Cokelat, Hazelnut, susu', 1, NULL, '2026-06-21 06:02:16', '2026-07-05 08:11:51'),
(156, 42, '1000236041_20260705093520.webp', 'Pistachio Choco latte', 20000, 'Perpaduan, cokelat, pistachio, susu', 1, NULL, '2026-06-21 06:03:19', '2026-07-05 08:35:21'),
(157, 42, '1000236038_20260705100310.webp', 'Double Chocolate latte', 22000, 'Pepraduan Cokelat premium, susu, cream', 1, NULL, '2026-06-21 06:04:45', '2026-07-05 09:03:10'),
(158, 42, '1000236075_20260705113122.webp', 'Cookies & Cream', 20000, 'Perpaduan Rasa oreo, cream, susu', 1, NULL, '2026-06-24 15:28:31', '2026-07-05 10:31:22'),
(159, 42, '1000224071_20260624162949.webp', 'Thai tea Latte', 18000, 'Perpaduan Rasa Thai tea, susu', 1, NULL, '2026-06-24 15:29:49', '2026-06-25 02:42:57'),
(160, 42, '1000236057_20260705102426.webp', 'Kopi susu Aren', 18000, 'Perpaduan, espresso, susu, gula aren', 1, NULL, '2026-06-24 15:31:26', '2026-07-05 09:24:26'),
(161, 42, '1000236065_20260705100749.webp', 'Butterscooth Sea Salt Latte', 22000, 'Perpaduan, Espresso, susu, butterscooth', 1, NULL, '2026-06-24 15:32:51', '2026-07-05 09:07:49'),
(162, 42, '1000224058_20260624163411.webp', 'Hazelnut Coffe Latte', 20000, 'Perpaduan, espresso, susu, hazelnut', 1, NULL, '2026-06-24 15:34:11', '2026-07-05 07:36:30'),
(163, 42, '1000224063_20260624163715.webp', 'Americano', 15000, 'Perpaduan, Espresso, Mineral, es', 1, NULL, '2026-06-24 15:37:15', '2026-06-25 02:42:49'),
(164, 42, '1000236064_20260705100548.webp', 'Matcha Latte', 20000, 'Perpaduan, Matcha, Susu, Cream', 1, NULL, '2026-06-24 15:38:57', '2026-07-05 09:05:48'),
(166, 42, '1000230682_20260628014228.webp', 'Black Berry Matoreh', 20000, 'Perpaduan rasa segar, buah Berry, espresso, citrus', 1, NULL, '2026-06-28 00:42:28', '2026-06-28 00:42:31'),
(167, 42, '1000234503_20260704030409.webp', 'Paket Nobar Kopi Susu ber 5', 75000, 'Buat Rame rame Nobar Piala Dunia', 1, NULL, '2026-07-04 02:04:10', '2026-07-05 07:37:40'),
(168, 42, '1000236012_20260705083437.webp', 'Peach Black Matoreh', 22000, 'Perpaduan Espresso, Peach Fruit, cream', 1, NULL, '2026-07-05 07:34:37', '2026-07-05 07:34:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_code` varchar(255) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_address` text DEFAULT NULL,
  `invoice_text` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `invoices`
--

INSERT INTO `invoices` (`id`, `business_id`, `invoice_code`, `customer_name`, `customer_address`, `invoice_text`, `created_at`, `updated_at`) VALUES
(1, 30, '3AaHhdi1Ca', NULL, NULL, '===== INVOICE =====\n\nAyam Bakar Perawan\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nAyam Geprek Merdeka\nJumlah: 5 x 0\nSubtotal: 0\n----------------------\nTOTAL: 0\n===================\n', '2025-03-19 08:36:22', '2025-03-19 08:36:22'),
(2, 15, 'GI3kEdwPuy', NULL, NULL, '===== INVOICE =====\n\nAbon Asep Pos, Lezat dan Be\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nAbon Asep Pos, Pilihan Terb\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nTOTAL: 0\n===================\n', '2025-03-19 09:44:23', '2025-03-19 09:44:23'),
(3, 15, 'BkS5Tz9lrp', NULL, NULL, '===== INVOICE =====\n\nAbon Asep Pos, Lezat dan Be\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nAbon Asep Pos, Pilihan Terb\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nTOTAL: 0\n===================\n', '2025-03-21 01:45:39', '2025-03-21 01:45:39'),
(4, 15, 'TAVKAhLF7h', NULL, NULL, '===== INVOICE =====\n\nAbon Asep Pos, Lezat dan Be\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nAbon Asep Pos, Pilihan Terb\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nTOTAL: 0\n===================\n', '2025-03-21 01:45:54', '2025-03-21 01:45:54'),
(5, 32, 'LYKnq2klt0', NULL, NULL, 'Cordon Bleu\r\nJumlah: 1 x 0\r\nSubtotal: 0\r\n----------------------\r\nSirloin\r\nJumlah: 1 x 0\r\nSubtotal: 0\r\n----------------------\r\nChicken Double\r\nJumlah: 1 x 0\r\nSubtotal: 0\r\n----------------------\r\nBeef Meltique BBQ\r\nJumlah: 1 x 0\r\nSubtotal: 0\r\n----------------------\r\nSirloin Import\r\nJumlah: 1 x 0\r\nSubtotal: 0\r\n----------------------\r\nDori Grill\r\nJumlah: 1 x 0\r\nSubtotal: 0\r\n----------------------\r\nSteak Waroeng\r\nJumlah: 1 x 0\r\nSubtotal: 0\r\n----------------------\r\nBeef Steak\r\nJumlah: 1 x 0\r\nSubtotal: 0\r\n----------------------\r\n<b>TOTAL: 0</b>\r\n', '2025-03-21 01:50:59', '2025-03-21 01:50:59'),
(6, 33, 'jGHi44f8wT', NULL, NULL, '===== INVOICE =====\n\nWebsite Simple\nJumlah: 1 x 500.000\nSubtotal: 500.000\n----------------------\nWarung Temolate\nJumlah: 1 x 650.000\nSubtotal: 650.000\n----------------------\nTOTAL: 1.150.000\n===================\n', '2025-03-21 01:56:02', '2025-03-21 01:56:02'),
(7, 33, 'W7ulz1NbAw', NULL, NULL, '\nWebsite Simple\nJumlah: 1 x 500.000\nSubtotal: 500.000\n----------------------\n<b>TOTAL: 500.000</b>\n*Belum termasuk ongkir\n', '2025-03-21 02:28:12', '2025-03-21 02:28:12'),
(8, 31, 'CVNHcmsvbW', NULL, NULL, '\nChicken Steak\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nSirloin\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nSteak Waroeng\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nBeef Meltique BBQ\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\n<b>TOTAL: 0</b>\n*Belum termasuk ongkir\n', '2025-03-22 10:55:16', '2025-03-22 10:55:16'),
(9, 31, 'l22wt0NZFB', NULL, NULL, '\nChicken BBQ\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\n<b>TOTAL: 0</b>\n*Belum termasuk ongkir\n', '2025-03-22 10:55:25', '2025-03-22 10:55:25'),
(10, 32, 'Y7jRFZFdbq', NULL, NULL, '\nCordon Bleu\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nChicken Double\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nBeef Meltique BBQ\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nSirloin Import\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nDori Grill\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\n<b>TOTAL: 0</b>\n*Belum termasuk ongkir\n', '2025-03-25 07:16:16', '2025-03-25 07:16:16'),
(11, 33, '93kBlzH821', NULL, NULL, '\nWebsite Simple\nJumlah: 1 x 500.000\nSubtotal: 500.000\n----------------------\nWarung Temolate\nJumlah: 1 x 650.000\nSubtotal: 650.000\n----------------------\n<b>TOTAL: 1.150.000</b>\n*Belum termasuk ongkir\n', '2025-03-25 07:23:25', '2025-03-25 07:23:25'),
(12, 31, '96KgdO4Gvk', NULL, NULL, '\nChicken BBQ\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nKopi Susu Gula Aren Ice\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\n<b>TOTAL: 0</b>\n*Belum termasuk ongkir\n', '2025-03-25 07:42:10', '2025-03-25 07:42:10'),
(13, 31, 'd97ivTQuOg', NULL, NULL, '\nChicken Steak\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nSteak Waroeng\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nBeef Meltique BBQ\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nPaket Chicko\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nLychee Tea Ice\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nKopi Susu Gula Aren Ice\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\n<b>TOTAL: 0</b>\n*Belum termasuk ongkir\n', '2025-03-25 07:42:21', '2025-03-25 07:42:21'),
(14, 32, '4EKZSJOp1P', NULL, NULL, '\nCordon Bleu\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nSirloin\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nChicken Double\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nBeef Meltique BBQ\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\n<b>TOTAL: 0</b>\n*Belum termasuk ongkir\n', '2025-03-25 07:42:38', '2025-03-25 07:42:38'),
(15, 31, 'flfVzYhCj7', NULL, NULL, '\nChicken Steak\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\n<b>TOTAL: 0</b>\n*Belum termasuk ongkir\n', '2025-03-25 07:43:17', '2025-03-25 07:43:17'),
(16, 30, 'wMb6dt8F7G', NULL, NULL, '\nAyam Bakar Perawan\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nAyam Geprek Merdeka\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nRamesan Cumi\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\n<b>TOTAL: 0</b>\n*Belum termasuk ongkir\n', '2025-03-25 07:48:19', '2025-03-25 07:48:19'),
(17, 14, '9g9aZlsDFx', NULL, NULL, '\nRasa Autentik Tradisional\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nTekstur Lembut Menggoda\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\n<b>TOTAL: 0</b>\n*Belum termasuk ongkir\n', '2025-03-25 13:39:13', '2025-03-25 13:39:13'),
(18, 33, 'N7bkJsoRd6', NULL, NULL, '\nWebsite Simple\nJumlah: 1 x 500.000\nSubtotal: 500.000\n----------------------\nWarung Temolate\nJumlah: 1 x 650.000\nSubtotal: 650.000\n----------------------\nWebsite b\nJumlah: 1 x 500.000\nSubtotal: 500.000\n----------------------\n<b>TOTAL: 1.650.000</b>\n*Belum termasuk ongkir\n', '2025-03-26 02:41:12', '2025-03-26 02:41:12'),
(19, 33, 'GBEsw8WL55', NULL, NULL, '\nWebsite Simple\nJumlah: 1 x 500.000\nSubtotal: 500.000\n----------------------\nWarung Temolate\nJumlah: 1 x 650.000\nSubtotal: 650.000\n----------------------\nWebsite b\nJumlah: 1 x 500.000\nSubtotal: 500.000\n----------------------\n<b>TOTAL: 1.650.000</b>\n*Belum termasuk ongkir\n', '2025-03-26 02:41:27', '2025-03-26 02:41:27'),
(20, 22, 'Tyd056Ev50', NULL, NULL, '\nTgm Gelas Plastik (Dus)\nJumlah: 1 x 20.000\nSubtotal: 20.000\n----------------------\nBeras 5 KG  (Merk Sawah)\nJumlah: 1 x 75.000\nSubtotal: 75.000\n----------------------\n<b>TOTAL: 95.000</b>\n*Belum termasuk ongkir\n', '2025-03-26 23:29:05', '2025-03-26 23:29:05'),
(21, 22, 'j3aLTLodxn', NULL, NULL, '\nTgm Gelas Plastik (Dus)\nJumlah: 1 x 20.000\nSubtotal: 20.000\n----------------------\nBeras 5 KG  (Merk Sawah)\nJumlah: 1 x 75.000\nSubtotal: 75.000\n----------------------\nLe Mineral 15 ltr\nJumlah: 1 x 20.000\nSubtotal: 20.000\n----------------------\nBeras 25 KG Sawah Jingga\nJumlah: 1 x 380.000\nSubtotal: 380.000\n----------------------\n<b>TOTAL: 495.000</b>\n*Belum termasuk ongkir\n', '2025-03-28 03:29:31', '2025-03-28 03:29:31'),
(22, 22, 'yl3LZ9IKM8', NULL, NULL, '\nTgm Gelas Plastik (Dus)\nJumlah: 1 x 20.000\nSubtotal: 20.000\n----------------------\nBeras 5 KG  (Merk Sawah)\nJumlah: 1 x 75.000\nSubtotal: 75.000\n----------------------\n<b>TOTAL: 95.000</b>\n*Belum termasuk ongkir\n', '2025-03-28 03:40:48', '2025-03-28 03:40:48'),
(23, 22, 'Ixz8M2naiq', NULL, NULL, '\nTgm Gelas Plastik (Dus)\nJumlah: 1 x 20.000\nSubtotal: 20.000\n----------------------\nBeras 5 KG  (Merk Sawah)\nJumlah: 1 x 75.000\nSubtotal: 75.000\n----------------------\n<b>TOTAL: 95.000</b>\n*Belum termasuk ongkir\n', '2025-03-28 03:42:25', '2025-03-28 03:42:25'),
(24, 31, 'S6vAD3ro0M', NULL, NULL, '\nChicken Steak\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nSirloin\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nSteak Waroeng\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nBeef Meltique BBQ\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\n<b>TOTAL: 0</b>\n*Belum termasuk ongkir\n', '2025-04-01 07:47:37', '2025-04-01 07:47:37'),
(25, 20, 'ZixCdjIDoq', NULL, NULL, '\nH8\nJumlah: 1 x 23.000\nSubtotal: 23.000\n----------------------\n<b>TOTAL: 23.000</b>\n*Belum termasuk ongkir\n', '2025-04-02 02:51:14', '2025-04-02 02:51:14'),
(26, 32, 'G2wHEnhK90', NULL, NULL, '\nCordon Bleu\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nSirloin\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nChicken Double\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nBeef Meltique BBQ\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\n<b>TOTAL: 0</b>\n*Belum termasuk ongkir\n', '2025-04-06 09:09:55', '2025-04-06 09:09:55'),
(27, 20, 'eFff3JfZwI', NULL, NULL, '\nHandsock 1\nJumlah: 1 x 23.000\nSubtotal: 23.000\n----------------------\nHandsock 2\nJumlah: 1 x 23.000\nSubtotal: 23.000\n----------------------\n<b>TOTAL: 46.000</b>\n*Belum termasuk ongkir\n', '2025-04-09 01:14:44', '2025-04-09 01:14:44'),
(28, 22, '3WBKFMYueE', NULL, NULL, '\nTgm Gelas Plastik (Dus)\nJumlah: 2 x 20.000\nSubtotal: 40.000\n----------------------\nBeras 5 KG  (Merk Sawah)\nJumlah: 1 x 75.000\nSubtotal: 75.000\n----------------------\n<b>TOTAL: 115.000</b>\n*Belum termasuk ongkir\n', '2025-04-09 03:50:24', '2025-04-09 03:50:24'),
(29, 9, 'Ch6Mhgjyu4', NULL, NULL, '\nKeindahan Alam Rumah Putih\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\n<b>TOTAL: 0</b>\n*Belum termasuk ongkir\n', '2025-04-09 04:10:04', '2025-04-09 04:10:04'),
(30, 22, 'qed7NqWKn6', NULL, NULL, '\nTgm Gelas Plastik (Dus)\nJumlah: 1 x 20.000\nSubtotal: 20.000\n----------------------\nBeras 5 KG  (Merk Sawah)\nJumlah: 1 x 75.000\nSubtotal: 75.000\n----------------------\nLe Mineral 15 ltr\nJumlah: 1 x 20.000\nSubtotal: 20.000\n----------------------\n<b>TOTAL: 115.000</b>\n*Belum termasuk ongkir\n', '2025-04-09 06:05:45', '2025-04-09 06:05:45'),
(31, 22, 'WHPFmVM6Ds', NULL, NULL, '\nTgm Gelas Plastik (Dus)\nJumlah: 1 x 20.000\nSubtotal: 20.000\n----------------------\nBeras 5 KG  (Merk Sawah)\nJumlah: 1 x 75.000\nSubtotal: 75.000\n----------------------\nLe Mineral 15 ltr\nJumlah: 1 x 20.000\nSubtotal: 20.000\n----------------------\n<b>TOTAL: 115.000</b>\n*Belum termasuk ongkir\n', '2025-04-09 06:06:31', '2025-04-09 06:06:31'),
(32, 22, 'fJCEN7begp', NULL, NULL, '\nTgm Gelas Plastik (Dus)\nJumlah: 1 x 20.000\nSubtotal: 20.000\n----------------------\nBeras 5 KG  (Merk Sawah)\nJumlah: 1 x 75.000\nSubtotal: 75.000\n----------------------\nLe Mineral 15 ltr\nJumlah: 1 x 20.000\nSubtotal: 20.000\n----------------------\n<b>TOTAL: 115.000</b>\n*Belum termasuk ongkir\n', '2025-04-09 06:06:52', '2025-04-09 06:06:52'),
(33, 22, '4hLIyHgEF9', NULL, NULL, '\nTgm Gelas Plastik (Dus)\nJumlah: 1 x 20.000\nSubtotal: 20.000\n----------------------\nBeras 5 KG  (Merk Sawah)\nJumlah: 1 x 75.000\nSubtotal: 75.000\n----------------------\nLe Mineral 15 ltr\nJumlah: 1 x 20.000\nSubtotal: 20.000\n----------------------\n<b>TOTAL: 115.000</b>\n*Belum termasuk ongkir\n', '2025-04-09 06:07:09', '2025-04-09 06:07:09'),
(34, 22, 'HlseMDFWU0', NULL, NULL, '\nTgm Gelas Plastik (Dus)\nJumlah: 1 x 20.000\nSubtotal: 20.000\n----------------------\nBeras 5 KG  (Merk Sawah)\nJumlah: 1 x 75.000\nSubtotal: 75.000\n----------------------\nLe Mineral 15 ltr\nJumlah: 1 x 20.000\nSubtotal: 20.000\n----------------------\n<b>TOTAL: 115.000</b>\n*Belum termasuk ongkir\n', '2025-04-09 06:07:30', '2025-04-09 06:07:30'),
(35, 22, 'Sh5VVhYmnz', NULL, NULL, '\nTgm Gelas Plastik (Dus)\nJumlah: 1 x 20.000\nSubtotal: 20.000\n----------------------\nBeras 5 KG  (Merk Sawah)\nJumlah: 1 x 75.000\nSubtotal: 75.000\n----------------------\nLe Mineral 15 ltr\nJumlah: 1 x 20.000\nSubtotal: 20.000\n----------------------\n<b>TOTAL: 115.000</b>\n*Belum termasuk ongkir\n', '2025-04-09 06:10:01', '2025-04-09 06:10:01'),
(36, 22, 'jwv1WgDNou', NULL, NULL, '\nTgm Gelas Plastik (Dus)\nJumlah: 1 x 20.000\nSubtotal: 20.000\n----------------------\nBeras 5 KG  (Merk Sawah)\nJumlah: 1 x 75.000\nSubtotal: 75.000\n----------------------\nLe Mineral 15 ltr\nJumlah: 1 x 20.000\nSubtotal: 20.000\n----------------------\n<b>TOTAL: 115.000</b>\n*Belum termasuk ongkir\n', '2025-04-09 06:11:05', '2025-04-09 06:11:05'),
(37, 22, 'GbaNSRnic5', NULL, NULL, '\nTgm Gelas Plastik (Dus)\nJumlah: 1 x 20.000\nSubtotal: 20.000\n----------------------\nBeras 5 KG  (Merk Sawah)\nJumlah: 1 x 75.000\nSubtotal: 75.000\n----------------------\nLe Mineral 15 ltr\nJumlah: 1 x 20.000\nSubtotal: 20.000\n----------------------\n<b>TOTAL: 115.000</b>\n*Belum termasuk ongkir\n', '2025-04-09 06:11:38', '2025-04-09 06:11:38'),
(38, 22, 'FlwSg9mLZC', NULL, NULL, '\nTgm Gelas Plastik (Dus)\nJumlah: 1 x 20.000\nSubtotal: 20.000\n----------------------\n<b>TOTAL: 20.000</b>\n*Belum termasuk ongkir\n', '2025-04-09 08:16:23', '2025-04-09 08:16:23'),
(39, 22, '1rM3T7WNp5', NULL, NULL, '\nTgm Gelas Plastik (Dus)\nJumlah: 1 x 20.000\nSubtotal: 20.000\n----------------------\nBeras 5 KG  (Merk Sawah)\nJumlah: 1 x 75.000\nSubtotal: 75.000\n----------------------\n<b>TOTAL: 95.000</b>\n*Belum termasuk ongkir\n', '2025-04-09 08:18:38', '2025-04-09 08:18:38'),
(40, 22, 'VGHnfjkhr3', NULL, NULL, '\nTgm Gelas Plastik (Dus)\nJumlah: 1 x 20.000\nSubtotal: 20.000\n----------------------\nBeras 5 KG  (Merk Sawah)\nJumlah: 1 x 75.000\nSubtotal: 75.000\n----------------------\n<b>TOTAL: 95.000</b>\n*Belum termasuk ongkir\n', '2025-04-09 08:18:57', '2025-04-09 08:18:57'),
(41, 31, 'rodHMgUZyz', NULL, NULL, '\nChicken BBQ\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nPaket Chicko\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\n<b>TOTAL: 0</b>\n*Belum termasuk ongkir\n', '2025-04-09 08:31:25', '2025-04-09 08:31:25'),
(42, 23, 'aKP3GCB1LW', NULL, NULL, '\nKeindahan Alam Sejati\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nFasilitas Lengkap Modern\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\n<b>TOTAL: 0</b>\n*Belum termasuk ongkir\n', '2025-04-09 08:33:17', '2025-04-09 08:33:17'),
(43, 31, 's1UQ9YNazi', NULL, NULL, '\nChicken Steak\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nSirloin\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nMilkshake Chocolate Special\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nKopi Susu Gula Aren Ice\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\n<b>TOTAL: 0</b>\n*Belum termasuk ongkir\n', '2025-04-10 01:59:48', '2025-04-10 01:59:48'),
(44, 31, 'd6y6UbJyK6', NULL, NULL, '\nChicken Steak\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nBeef Meltique BBQ\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nMilkshake Chocolate Special\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nLychee Tea Ice\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\n<b>TOTAL: 0</b>\n*Belum termasuk ongkir\n', '2025-04-10 02:03:40', '2025-04-10 02:03:40'),
(45, 31, '95Trr2OFJV', NULL, NULL, '\nChicken Steak\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nSteak Waroeng\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nMilkshake Chocolate Special\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nLychee Tea Ice\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\n<b>TOTAL: 0</b>\n*Belum termasuk ongkir\n', '2025-04-10 04:45:58', '2025-04-10 04:45:58'),
(46, 31, 'Yk0GvqwOT8', NULL, NULL, '\nChicken Steak\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nSirloin\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nMilkshake Chocolate Special\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nLychee Tea Ice\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\n<b>TOTAL: 0</b>\n*Belum termasuk ongkir\n', '2025-04-10 04:50:14', '2025-04-10 04:50:14'),
(47, 17, 'lAsG6p8V9G', NULL, NULL, '\nLokasi Tenang & Asri\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nFasilitas Lengkap\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nLayanan Ramah\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nSapi Pangalengan\nJumlah: 1 x 300.000.000\nSubtotal: 300.000.000\n----------------------\n<b>TOTAL: 300.000.000</b>\n*Belum termasuk ongkir\n', '2025-04-10 06:07:04', '2025-04-10 06:07:04'),
(48, 30, 'BwIfhYbhg9', NULL, NULL, '\nAyam Bakar Perawan\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nAyam Geprek Merdeka\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\n<b>TOTAL: 0</b>\n*Belum termasuk ongkir\n', '2025-04-11 06:22:47', '2025-04-11 06:22:47'),
(49, 30, 'WccmrEd3oI', NULL, NULL, '\nRamesan Cumi\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\n<b>TOTAL: 0</b>\n*Belum termasuk ongkir\n', '2025-04-11 06:27:52', '2025-04-11 06:27:52'),
(50, 30, 'wlsh5KaF05', NULL, NULL, '\nAyam Geprek Merdeka\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\n<b>TOTAL: 0</b>\n*Belum termasuk ongkir\n', '2025-04-11 06:29:02', '2025-04-11 06:29:02'),
(51, 32, 'Fj1TV2Tf8N', NULL, NULL, '\nSirloin Import\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nDori Grill\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nBeef Steak\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\n<b>TOTAL: 0</b>\n*Belum termasuk ongkir\n', '2025-04-11 13:06:10', '2025-04-11 13:06:10'),
(52, 32, 'p7DY1NSyoR', NULL, NULL, '\nCordon Bleu\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nSirloin\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nChicken Double\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nBeef Meltique BBQ\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nSirloin Import\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nDori Grill\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\n<b>TOTAL: 0</b>\n*Belum termasuk ongkir\n', '2025-04-13 03:09:43', '2025-04-13 03:09:43'),
(53, 32, 'DClmrG5uFO', NULL, NULL, '\nCordon Bleu\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nSirloin\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nChicken Double\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nBeef Meltique BBQ\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nSirloin Import\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nDori Grill\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\n<b>TOTAL: 0</b>\n*Belum termasuk ongkir\n', '2025-04-13 03:09:54', '2025-04-13 03:09:54'),
(54, 22, 'rw06KhbMUT', NULL, NULL, '\nTgm Gelas Plastik (Dus)\nJumlah: 1 x 20.000\nSubtotal: 20.000\n----------------------\nBeras 5 KG  (Merk Sawah)\nJumlah: 1 x 75.000\nSubtotal: 75.000\n----------------------\nLe Mineral 15 ltr\nJumlah: 1 x 20.000\nSubtotal: 20.000\n----------------------\n<b>TOTAL: 115.000</b>\n*Belum termasuk ongkir\n', '2025-04-13 03:11:16', '2025-04-13 03:11:16'),
(55, 31, 'dfa9uzX7da', NULL, NULL, '\nChicken Steak\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nChicken BBQ\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nMilkshake Chocolate Special\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nLychee Tea Ice\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\n<b>TOTAL: 0</b>\n*Belum termasuk ongkir\n', '2025-04-14 02:14:20', '2025-04-14 02:14:20'),
(56, 20, 'XeDVj8TYZG', NULL, NULL, '\nHandsock 1\nJumlah: 1 x 23.000\nSubtotal: 23.000\n----------------------\nHandsock 2\nJumlah: 1 x 23.000\nSubtotal: 23.000\n----------------------\nHandsock 3\nJumlah: 1 x 23.000\nSubtotal: 23.000\n----------------------\n<b>TOTAL: 69.000</b>\n*Belum termasuk ongkir\n', '2025-04-14 02:34:37', '2025-04-14 02:34:37'),
(57, 29, 'uoLVXi3QQK', NULL, NULL, '\nToyota Supra\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nToyota GR 86\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\n<b>TOTAL: 0</b>\n*Belum termasuk ongkir\n', '2025-04-14 05:09:09', '2025-04-14 05:09:09'),
(58, 10, 'No4AYhkvz1', NULL, NULL, '\nPesona Alam Terpadu\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nAir Terjun Mempesona\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\n<b>TOTAL: 0</b>\n*Belum termasuk ongkir\n', '2025-04-14 05:10:36', '2025-04-14 05:10:36'),
(59, 10, 'ih5Kcme680', NULL, NULL, '\nPesona Alam Terpadu\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\nAir Terjun Mempesona\nJumlah: 1 x 0\nSubtotal: 0\n----------------------\n<b>TOTAL: 0</b>\n*Belum termasuk ongkir\n', '2025-04-14 05:10:45', '2025-04-14 05:10:45'),
(60, 41, 'IS8iQaAms8', NULL, NULL, '\nPewangi Pakaian\nJumlah: 1 x 145.000\nSubtotal: 145.000\n----------------------\nPelicin Pakaian\nJumlah: 1 x 52.000\nSubtotal: 52.000\n----------------------\n<b>TOTAL: 197.000</b>\n*Belum termasuk ongkir\n', '2025-04-14 07:05:37', '2025-04-14 07:05:37'),
(61, 18, 'JELMXLACIQ', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>24-04-2025</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Kamar dengan area luas</b><p>1 x 0 = 0</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp0</b>', '2025-04-24 15:27:44', '2025-04-24 15:27:44'),
(62, 32, 'XIQZXRCQHB', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>06-05-2025</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Cordon Bleu</b><p>1 x 0 = 0</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp0</b>', '2025-05-06 11:05:00', '2025-05-06 11:05:00'),
(63, 32, 'SUYPDK3SRV', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>21-05-2025</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Cordon Bleu</b><p>1 x 0 = 0</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Sirloin</b><p>1 x 0 = 0</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Chicken Double</b><p>1 x 0 = 0</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Beef Meltique BBQ</b><p>1 x 0 = 0</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Sirloin Import</b><p>1 x 0 = 0</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Dori Grill</b><p>1 x 0 = 0</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp0</b>', '2025-05-21 07:46:43', '2025-05-21 07:46:43'),
(64, 15, 'VFHRU9YVFT', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>25-06-2025</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Abon Asep Pos, Lezat dan Be</b><p>1 x 0 = 0</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Abon Asep Pos, Pilihan Terb</b><p>1 x 0 = 0</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp0</b>', '2025-06-25 09:29:16', '2025-06-25 09:29:16'),
(65, 26, 'QLLQ25AA1N', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>25-06-2025</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Pemandangan Memukau</b><p>1 x 0 = 0</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Lingkungan Asri</b><p>1 x 0 = 0</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp0</b>', '2025-06-25 09:30:52', '2025-06-25 09:30:52'),
(66, 41, 'BM1SSUYMIJ', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>25-06-2025</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Deterejen Liquid</b><p>21 x 54.000 = 1.134.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Sabun Cuci Piring</b><p>1 x 55.000 = 55.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Hand Soap</b><p>1 x 53.000 = 53.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Karbol Sereh</b><p>1 x 60.000 = 60.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Pembersih Lantai Lemo</b><p>1 x 53.000 = 53.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp1.355.000</b>', '2025-06-25 09:31:42', '2025-06-25 09:31:42'),
(67, 41, 'LUBGDNXXGJ', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>11-07-2025</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Deterejen Liquid</b><p>1 x 54.000 = 54.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Sabun Cuci Piring</b><p>1 x 55.000 = 55.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Hand Soap</b><p>1 x 53.000 = 53.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Karbol Pine</b><p>1 x 60.000 = 60.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp222.000</b>', '2025-07-11 13:47:07', '2025-07-11 13:47:07'),
(68, 8, 'DFOPRFTP08', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>21-08-2025</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Eksplorasi Alam Asri</b><p>1 x 0 = 0</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Relaksasi di Kampung Singku</b><p>1 x 0 = 0</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp0</b>', '2025-08-21 09:24:37', '2025-08-21 09:24:37'),
(69, 41, '3KILXLLGGU', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>17-09-2025</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Deterejen Liquid</b><p>1 x 54.000 = 54.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Sabun Cuci Piring</b><p>1 x 55.000 = 55.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Hand Soap</b><p>1 x 53.000 = 53.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Karbol Pine</b><p>1 x 60.000 = 60.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp222.000</b>', '2025-09-17 09:51:07', '2025-09-17 09:51:07'),
(70, 41, 'XNHYAL8UUY', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>17-09-2025</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Deterejen Liquid</b><p>1 x 54.000 = 54.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Sabun Cuci Piring</b><p>1 x 55.000 = 55.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Hand Soap</b><p>1 x 53.000 = 53.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Karbol Pine</b><p>1 x 60.000 = 60.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp222.000</b>', '2025-09-17 09:51:17', '2025-09-17 09:51:17'),
(71, 11, 'HK86YXV18R', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>10-10-2025</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Keindahan Alam Teh Malabar</b><p>1 x 0 = 0</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Wisata Teh yang Menyegarkan</b><p>1 x 0 = 0</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp0</b>', '2025-10-10 05:54:40', '2025-10-10 05:54:40'),
(72, 25, 'QQ4RKZCU7W', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>28-11-2025</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Villa dengan Pemandangan</b><p>1 x 0 = 0</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Fasilitas Lengkap</b><p>1 x 0 = 0</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp0</b>', '2025-11-28 06:50:30', '2025-11-28 06:50:30'),
(73, 11, 'YH41PIS7B4', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>27-01-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Keindahan Alam Teh Malabar</b><p>1 x 0 = 0</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Wisata Teh yang Menyegarkan</b><p>1 x 0 = 0</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp0</b>', '2026-01-27 12:46:53', '2026-01-27 12:46:53'),
(74, 7, 'TZSRDWND9I', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>31-03-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Kelezatan Yogurt Segar</b><p>1 x 0 = 0</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Varian Rasa Favorit</b><p>1 x 0 = 0</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp0</b>', '2026-03-31 10:43:06', '2026-03-31 10:43:06'),
(75, 30, 'X4UPLIV9E2', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>08-04-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Ayam Bakar Perawan</b><p>1 x 0 = 0</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Ayam Geprek Merdeka</b><p>1 x 0 = 0</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Ramesan Cumi</b><p>1 x 0 = 0</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp0</b>', '2026-04-08 06:58:07', '2026-04-08 06:58:07'),
(76, 42, '8GLZI4ACD1', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>25-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Choco latte</b><p>1 x 18.000 = 18.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Hazelnut Choco</b><p>1 x 20.000 = 20.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Americano</b><p>1 x 15.000 = 15.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp53.000</b>', '2026-06-25 03:47:23', '2026-06-25 03:47:23'),
(77, 42, 'ZVQXVUPH5Z', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>26-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Choco latte</b><p>1 x 18.000 = 18.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp18.000</b>', '2026-06-26 02:26:26', '2026-06-26 02:26:26'),
(78, 42, 'PFEKMRJGXJ', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>26-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Choco latte</b><p>2 x 18.000 = 36.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Hazelnut Choco</b><p>2 x 20.000 = 40.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp76.000</b>', '2026-06-26 11:06:34', '2026-06-26 11:06:34'),
(79, 42, '0NNG6ARP0B', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>26-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Choco latte</b><p>2 x 18.000 = 36.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Hazelnut Choco</b><p>2 x 20.000 = 40.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp76.000</b>', '2026-06-26 11:06:53', '2026-06-26 11:06:53'),
(80, 42, 'YUL6RDDJVW', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>26-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Choco latte</b><p>1 x 18.000 = 18.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Pistachio Choco latte</b><p>1 x 20.000 = 20.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp38.000</b>', '2026-06-26 11:19:31', '2026-06-26 11:19:31'),
(81, 42, 'QUJFTBKCHQ', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>26-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Choco latte</b><p>1 x 18.000 = 18.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp18.000</b>', '2026-06-26 11:36:57', '2026-06-26 11:36:57'),
(82, 42, 'HACGAXLA5X', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>26-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Choco latte</b><p>1 x 18.000 = 18.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Hazelnut Choco</b><p>1 x 20.000 = 20.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp38.000</b>', '2026-06-26 14:06:23', '2026-06-26 14:06:23'),
(83, 42, 'FPQCJSLY2T', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>27-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Matcha Latte</b><p>1 x 20.000 = 20.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp20.000</b>', '2026-06-27 01:18:37', '2026-06-27 01:18:37'),
(84, 42, 'TGWIMCQ961', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>27-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Choco latte</b><p>1 x 18.000 = 18.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Hazelnut Choco</b><p>1 x 20.000 = 20.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Pistachio Choco latte</b><p>1 x 20.000 = 20.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp58.000</b>', '2026-06-27 08:24:04', '2026-06-27 08:24:04'),
(85, 42, '328WS3NXIL', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>29-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Black Berry Matoreh</b><p>1 x 20.000 = 20.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp20.000</b>', '2026-06-29 00:35:29', '2026-06-29 00:35:29'),
(86, 42, 'HNAWE6QDG5', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>29-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Pistachio Choco latte</b><p>1 x 20.000 = 20.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp20.000</b>', '2026-06-29 01:03:08', '2026-06-29 01:03:08'),
(87, 42, 'QBMSCKA4PF', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>29-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Choco latte</b><p>1 x 18.000 = 18.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Hazelnut Choco</b><p>1 x 20.000 = 20.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Pistachio Choco latte</b><p>1 x 20.000 = 20.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Kopi susu Aren</b><p>2 x 18.000 = 36.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Butterscooth Sea Salt Latte</b><p>1 x 20.000 = 20.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Black Berry Matoreh</b><p>1 x 20.000 = 20.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp134.000</b>', '2026-06-29 01:09:34', '2026-06-29 01:09:34'),
(88, 42, 'TV3M0WH7SU', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>29-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Hazelnut Coffe Latte</b><p>1 x 18.000 = 18.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp18.000</b>', '2026-06-29 01:12:12', '2026-06-29 01:12:12'),
(89, 42, 'AC31ORP8WS', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>29-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Matcha Latte</b><p>1 x 20.000 = 20.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp20.000</b>', '2026-06-29 01:13:25', '2026-06-29 01:13:25'),
(90, 42, 'T6ZH6QTRSI', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>29-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Choco latte</b><p>1 x 18.000 = 18.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp18.000</b>', '2026-06-29 01:14:02', '2026-06-29 01:14:02'),
(91, 42, 'VOL8BY3TSG', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>29-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Hazelnut Choco</b><p>1 x 20.000 = 20.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp20.000</b>', '2026-06-29 01:15:00', '2026-06-29 01:15:00'),
(92, 42, 'WX7OCWQVOP', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>29-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Double Chocolate latte</b><p>1 x 22.000 = 22.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp22.000</b>', '2026-06-29 01:16:32', '2026-06-29 01:16:32'),
(93, 42, 'U6FZWTAZIE', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>29-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Black Berry Matoreh</b><p>1 x 20.000 = 20.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp20.000</b>', '2026-06-29 01:17:17', '2026-06-29 01:17:17'),
(94, 42, 'LCWUJUW35B', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>29-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Hazelnut Coffe Latte</b><p>1 x 18.000 = 18.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp18.000</b>', '2026-06-29 01:17:27', '2026-06-29 01:17:27'),
(95, 42, '7ROR6KLPXF', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>29-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Hazelnut Choco</b><p>1 x 20.000 = 20.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp20.000</b>', '2026-06-29 01:18:00', '2026-06-29 01:18:00'),
(96, 42, '1X24PSLGME', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>29-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Hazelnut Choco</b><p>1 x 20.000 = 20.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp20.000</b>', '2026-06-29 01:18:10', '2026-06-29 01:18:10'),
(97, 42, 'B1PVJ1UHJY', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>29-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Hazelnut Choco</b><p>1 x 20.000 = 20.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp20.000</b>', '2026-06-29 01:18:11', '2026-06-29 01:18:11'),
(98, 42, 'WWN98PNLIO', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>29-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Hazelnut Choco</b><p>1 x 20.000 = 20.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp20.000</b>', '2026-06-29 01:18:19', '2026-06-29 01:18:19'),
(99, 42, 'UI0QBFI26H', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>29-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Hazelnut Choco</b><p>1 x 20.000 = 20.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp20.000</b>', '2026-06-29 01:18:20', '2026-06-29 01:18:20'),
(100, 42, 'ZENFYR7LLB', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>29-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Hazelnut Coffe Latte</b><p>1 x 18.000 = 18.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp18.000</b>', '2026-06-29 01:18:35', '2026-06-29 01:18:35'),
(101, 42, 'OIZCJYNGVC', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>29-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Double Chocolate latte</b><p>1 x 22.000 = 22.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp22.000</b>', '2026-06-29 01:18:45', '2026-06-29 01:18:45'),
(102, 42, 'F8TJATVLXN', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>29-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Hazelnut Coffe Latte</b><p>1 x 18.000 = 18.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp18.000</b>', '2026-06-29 01:18:51', '2026-06-29 01:18:51'),
(103, 42, 'S9OU5BGA9H', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>29-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Double Chocolate latte</b><p>1 x 22.000 = 22.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp22.000</b>', '2026-06-29 06:10:28', '2026-06-29 06:10:28'),
(104, 42, '6BJRJO7ZFT', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>30-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Butterscooth Sea Salt Latte</b><p>1 x 20.000 = 20.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp20.000</b>', '2026-06-30 03:52:37', '2026-06-30 03:52:37'),
(105, 42, 'PK5SMOBTN5', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>30-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Double Chocolate latte</b><p>1 x 22.000 = 22.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp22.000</b>', '2026-06-30 03:55:49', '2026-06-30 03:55:49'),
(106, 42, 'DMEECCBTA8', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>30-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Double Chocolate latte</b><p>1 x 22.000 = 22.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp22.000</b>', '2026-06-30 03:57:27', '2026-06-30 03:57:27'),
(107, 42, 'MLZCQBDDCU', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>30-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Double Chocolate latte</b><p>1 x 22.000 = 22.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp22.000</b>', '2026-06-30 03:59:01', '2026-06-30 03:59:01'),
(108, 42, 'DDPGZWLAFI', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>30-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Double Chocolate latte</b><p>1 x 22.000 = 22.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp22.000</b>', '2026-06-30 04:03:01', '2026-06-30 04:03:01'),
(109, 42, 'RXMBZJDL9S', NULL, NULL, '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>30-06-2026</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Kopi susu Aren</b><p>1 x 18.000 = 18.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp18.000</b>', '2026-06-30 04:13:06', '2026-06-30 04:13:06');
INSERT INTO `invoices` (`id`, `business_id`, `invoice_code`, `customer_name`, `customer_address`, `invoice_text`, `created_at`, `updated_at`) VALUES
(110, 42, 'Q87BKKFPS8', 'Kurnia', 'Komp. Sapta taruna Blok B1 no 10 \r\nDepan lapangan voli', '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>02-07-2026</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Nama Pemesan</p><p>Kurnia</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Alamat</p><p>Komp. Sapta taruna Blok B1 no 10 <br />\r\nDepan lapangan voli</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Choco latte</b><p>1 x 18.000 = 18.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Hazelnut Choco</b><p>1 x 20.000 = 20.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp38.000</b>', '2026-07-02 08:47:42', '2026-07-02 08:47:42'),
(111, 42, 'ELQERDYRP8', 'Kurnia', 'Komp. Sapta taruna Blok B1 no 10 \r\nDepan lapangan voli', '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>02-07-2026</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Nama Pemesan</p><p>Kurnia</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Alamat</p><p>Komp. Sapta taruna Blok B1 no 10 <br />\r\nDepan lapangan voli</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Choco latte</b><p>1 x 18.000 = 18.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Hazelnut Choco</b><p>1 x 20.000 = 20.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp38.000</b>', '2026-07-02 08:47:42', '2026-07-02 08:47:42'),
(112, 42, 'HKZMSILTV9', 'Adi', 'Jalan sapta taruna', '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>02-07-2026</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Nama Pemesan</p><p>Adi</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Alamat</p><p>Jalan sapta taruna</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Choco latte</b><p>1 x 18.000 = 18.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp18.000</b>', '2026-07-02 08:50:18', '2026-07-02 08:50:18'),
(113, 42, 'G87PMEMDUE', 'Adi', 'Jalan sapta taruna', '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>02-07-2026</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Nama Pemesan</p><p>Adi</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Alamat</p><p>Jalan sapta taruna</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Choco latte</b><p>1 x 18.000 = 18.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp18.000</b>', '2026-07-02 08:52:14', '2026-07-02 08:52:14'),
(114, 42, 'HUKKVDRAGJ', 'Yeti', 'Sapta taruna blok b1 no 10', '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>02-07-2026</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Nama Pemesan</p><p>Yeti</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Alamat</p><p>Sapta taruna blok b1 no 10</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Hazelnut Choco</b><p>1 x 20.000 = 20.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp20.000</b>', '2026-07-02 12:39:50', '2026-07-02 12:39:50'),
(115, 42, 'JM1H4RBI8E', 'Yeti', 'Sapta taruna blok b1 no 10', '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>02-07-2026</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Nama Pemesan</p><p>Yeti</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Alamat</p><p>Sapta taruna blok b1 no 10</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Hazelnut Choco</b><p>1 x 20.000 = 20.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp20.000</b>', '2026-07-02 12:42:28', '2026-07-02 12:42:28'),
(116, 42, 'ZEU1POSQOB', 'Heru Yugo Prasetyo', 'Komplek PU Sapta Taruna Blok B1 No.10', '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>03-07-2026</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Nama Pemesan</p><p>Heru Yugo Prasetyo</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Alamat</p><p>Komplek PU Sapta Taruna Blok B1 No.10</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Black Berry Matoreh</b><p>1 x 20.000 = 20.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp20.000</b>', '2026-07-03 01:44:47', '2026-07-03 01:44:47'),
(117, 42, 'GMNNOKR45U', 'Ismail', 'Perum sapta taruna blok b no 10', '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>03-07-2026</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Nama Pemesan</p><p>Ismail</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Alamat</p><p>Perum sapta taruna blok b no 10</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Kopi susu Aren</b><p>1 x 18.000 = 18.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp18.000</b>', '2026-07-03 03:48:06', '2026-07-03 03:48:06'),
(118, 42, 'ZJXO3HG6AC', 'Ismail', 'Perum sapta taruna blok b no 10', '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>03-07-2026</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Nama Pemesan</p><p>Ismail</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Alamat</p><p>Perum sapta taruna blok b no 10</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Kopi susu Aren</b><p>1 x 18.000 = 18.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp18.000</b>', '2026-07-03 03:48:07', '2026-07-03 03:48:07'),
(119, 42, 'KG7TTVWRKN', 'Diar cantik', 'Erafone Margacinta 2, Jl. Margacinta No.420, Margasari, Kec. Buahbatu, Kota Bandung, Jawa Barat 40287', '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>04-07-2026</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Nama Pemesan</p><p>Diar cantik</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Alamat</p><p>Erafone Margacinta 2, Jl. Margacinta No.420, Margasari, Kec. Buahbatu, Kota Bandung, Jawa Barat 40287</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Hazelnut Choco</b><p>2 x 20.000 = 40.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Double Chocolate latte</b><p>1 x 22.000 = 22.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Kopi susu Aren</b><p>1 x 18.000 = 18.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Matcha Latte</b><p>2 x 20.000 = 40.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp120.000</b>', '2026-07-04 03:03:47', '2026-07-04 03:03:47'),
(120, 42, '2C7HIOIBCY', 'Miman', 'Komplek pu', '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>04-07-2026</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Nama Pemesan</p><p>Miman</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Alamat</p><p>Komplek pu</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Double Chocolate latte</b><p>1 x 22.000 = 22.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp22.000</b>', '2026-07-04 03:59:23', '2026-07-04 03:59:23'),
(121, 42, 'MCCVEU87XF', 'Nia JBiz (americano nya request 3shot ya kak)', 'Komplek PU Blok B1 No.10, Buah Batu (Cipagalo Cipagalo Bojongsoang, Kujangsari, Kec. Bandung Kidul, Kota Bandung, Jawa Barat 40287', '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>06-07-2026</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Nama Pemesan</p><p>Nia JBiz (americano nya request 3shot ya kak)</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Alamat</p><p>Komplek PU Blok B1 No.10, Buah Batu (Cipagalo Cipagalo Bojongsoang, Kujangsari, Kec. Bandung Kidul, Kota Bandung, Jawa Barat 40287</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Butterscooth Sea Salt Latte</b><p>1 x 22.000 = 22.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Americano</b><p>1 x 15.000 = 15.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp37.000</b>', '2026-07-06 01:31:13', '2026-07-06 01:31:13'),
(122, 42, 'M0ADNOR3GA', 'miman', 'komplek pu', '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>06-07-2026</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Nama Pemesan</p><p>miman</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Alamat</p><p>komplek pu</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Double Chocolate latte</b><p>1 x 22.000 = 22.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp22.000</b>', '2026-07-06 02:50:37', '2026-07-06 02:50:37'),
(123, 42, 'MQRL8MPQHO', 'Kurnia Ganteng', 'Komplek sapta taruna', '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>07-07-2026</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Nama Pemesan</p><p>Kurnia Ganteng</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Alamat</p><p>Komplek sapta taruna</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Double Chocolate latte</b><p>1 x 22.000 = 22.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp22.000</b>', '2026-07-06 23:14:44', '2026-07-06 23:14:44'),
(124, 42, 'V3JLDRVJFV', 'Sintia', 'Kantor Jasawebsite.biz', '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>07-07-2026</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Nama Pemesan</p><p>Sintia</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Alamat</p><p>Kantor Jasawebsite.biz</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Pistachio Choco latte</b><p>1 x 20.000 = 20.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp20.000</b>', '2026-07-06 23:30:38', '2026-07-06 23:30:38'),
(125, 42, 'ZYH3NZMSIL', 'Sintia', 'Kantor Jasawebsite.biz', '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>07-07-2026</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Nama Pemesan</p><p>Sintia</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Alamat</p><p>Kantor Jasawebsite.biz</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Pistachio Choco latte</b><p>1 x 20.000 = 20.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp20.000</b>', '2026-07-06 23:30:59', '2026-07-06 23:30:59'),
(126, 42, 'BGBYSLCCEL', 'Sintia', 'Kantor Jbiz', '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>07-07-2026</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Nama Pemesan</p><p>Sintia</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Alamat</p><p>Kantor Jbiz</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Pistachio Choco latte</b><p>1 x 20.000 = 20.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp20.000</b>', '2026-07-06 23:31:55', '2026-07-06 23:31:55'),
(127, 42, 'HORMRI22J4', 'Sintia', 'Kantor Jbiz', '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>07-07-2026</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Nama Pemesan</p><p>Sintia</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Alamat</p><p>Kantor Jbiz</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Hazelnut Choco</b><p>1 x 20.000 = 20.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Pistachio Choco latte</b><p>1 x 20.000 = 20.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp40.000</b>', '2026-07-06 23:34:32', '2026-07-06 23:34:32'),
(128, 42, 'F8BACNEE7D', 'Arya', 'Kantor Jbiz - Sapta Taruna PU blok b1 no 10', '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>07-07-2026</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Nama Pemesan</p><p>Arya</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Alamat</p><p>Kantor Jbiz - Sapta Taruna PU blok b1 no 10</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Kopi susu Aren</b><p>1 x 18.000 = 18.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp18.000</b>', '2026-07-06 23:50:58', '2026-07-06 23:50:58'),
(129, 42, 'XXTW2MUIU1', 'Kurnia irawan', 'Komp sapta taruna Blok B no 10 buah batu', '<p style=\"font-size: 0.875rem; color: #525252; font-weight: 600;\">Tanggal</p><p>07-07-2026</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Nama Pemesan</p><p>Kurnia irawan</p><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Alamat</p><p>Komp sapta taruna Blok B no 10 buah batu</p><p style=\"margin-top:8px;\"><b>Detail Rekapan</b></p><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Double Chocolate latte</b><p>1 x 22.000 = 22.000</p></div><div style=\"font-size: 0.875rem;display: flex; justify-content: space-between;\"><b>- Kopi susu Aren</b><p>1 x 18.000 = 18.000</p></div><p style=\"font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;\">Total</p><b>Rp40.000</b>', '2026-07-07 04:39:22', '2026-07-07 04:39:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_11_14_083309_create_products_table', 1),
(6, '2024_11_14_083354_create_product_galleries_table', 1),
(9, '2024_11_15_064705_add_field', 2),
(10, '2024_11_15_075223_create_no_handphones_table', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `no_handphones`
--

CREATE TABLE `no_handphones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_tlp` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `no_handphones`
--

INSERT INTO `no_handphones` (`id`, `no_tlp`, `created_at`, `updated_at`) VALUES
(1, '085798765798', '2024-11-15 01:40:30', '2025-01-07 08:03:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pivot_product_categories`
--

CREATE TABLE `pivot_product_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pivot_product_categories`
--

INSERT INTO `pivot_product_categories` (`id`, `product_id`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 7, 1, NULL, NULL),
(2, 8, 2, NULL, NULL),
(3, 9, 2, NULL, NULL),
(4, 10, 2, NULL, NULL),
(5, 11, 2, NULL, NULL),
(6, 12, 2, NULL, NULL),
(7, 13, 2, NULL, NULL),
(8, 14, 1, NULL, NULL),
(9, 15, 1, NULL, NULL),
(10, 16, 3, NULL, NULL),
(11, 18, 3, NULL, NULL),
(12, 19, 3, NULL, NULL),
(14, 21, 3, NULL, NULL),
(16, 23, 3, NULL, NULL),
(17, 23, 4, NULL, NULL),
(18, 24, 2, NULL, NULL),
(19, 25, 3, NULL, NULL),
(20, 26, 3, NULL, NULL),
(21, 27, 3, NULL, NULL),
(22, 27, 4, NULL, NULL),
(23, 29, 5, NULL, NULL),
(24, 30, 1, NULL, NULL),
(25, 31, 1, NULL, NULL),
(26, 32, 1, NULL, NULL),
(27, 33, 6, NULL, NULL),
(28, 22, 1, NULL, NULL),
(29, 22, 7, NULL, NULL),
(30, 20, 8, NULL, NULL),
(31, 20, 9, NULL, NULL),
(32, 40, 1, NULL, NULL),
(33, 41, 10, NULL, NULL),
(34, 42, 2, NULL, NULL),
(35, 42, 3, NULL, NULL),
(36, 42, 4, NULL, NULL),
(37, 42, 7, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pivot_product_tags`
--

CREATE TABLE `pivot_product_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pivot_product_tags`
--

INSERT INTO `pivot_product_tags` (`id`, `product_id`, `tag_id`, `created_at`, `updated_at`) VALUES
(152, 7, 2, '2025-03-13 08:48:42', '2025-03-13 08:48:42'),
(153, 8, 3, '2025-03-13 08:48:57', '2025-03-13 08:48:57'),
(154, 9, 3, '2025-03-13 08:49:11', '2025-03-13 08:49:11'),
(155, 10, 3, '2025-03-13 08:49:20', '2025-03-13 08:49:20'),
(156, 12, 3, '2025-03-13 08:49:57', '2025-03-13 08:49:57'),
(157, 14, 2, '2025-03-13 08:50:16', '2025-03-13 08:50:16'),
(158, 15, 2, '2025-03-13 08:50:34', '2025-03-13 08:50:34'),
(159, 16, 1, '2025-03-13 08:50:45', '2025-03-13 08:50:45'),
(160, 19, 1, '2025-03-13 08:51:19', '2025-03-13 08:51:19'),
(161, 21, 1, '2025-03-13 08:51:38', '2025-03-13 08:51:38'),
(164, 25, 1, '2025-03-13 08:52:44', '2025-03-13 08:52:44'),
(165, 26, 1, '2025-03-13 08:53:10', '2025-03-13 08:53:10'),
(166, 27, 1, '2025-03-13 08:53:38', '2025-03-13 08:53:38'),
(167, 27, 4, '2025-03-13 08:53:38', '2025-03-13 08:53:38'),
(168, 29, 6, '2025-03-13 08:54:05', '2025-03-13 08:54:05'),
(175, 32, 10, '2025-03-13 08:55:02', '2025-03-13 08:55:02'),
(176, 32, 11, '2025-03-13 08:55:02', '2025-03-13 08:55:02'),
(177, 32, 12, '2025-03-13 08:55:02', '2025-03-13 08:55:02'),
(186, 33, 13, '2025-03-21 02:13:09', '2025-03-21 02:13:09'),
(187, 33, 14, '2025-03-21 02:13:09', '2025-03-21 02:13:09'),
(188, 33, 15, '2025-03-21 02:13:09', '2025-03-21 02:13:09'),
(189, 33, 16, '2025-03-21 02:13:09', '2025-03-21 02:13:09'),
(296, 30, 8, '2025-04-11 06:19:40', '2025-04-11 06:19:40'),
(297, 30, 9, '2025-04-11 06:19:40', '2025-04-11 06:19:40'),
(322, 41, 24, '2025-04-15 06:24:33', '2025-04-15 06:24:33'),
(323, 41, 25, '2025-04-15 06:24:33', '2025-04-15 06:24:33'),
(324, 41, 26, '2025-04-15 06:24:33', '2025-04-15 06:24:33'),
(325, 41, 27, '2025-04-15 06:24:33', '2025-04-15 06:24:33'),
(326, 41, 28, '2025-04-15 06:24:33', '2025-04-15 06:24:33'),
(327, 41, 29, '2025-04-15 06:24:33', '2025-04-15 06:24:33'),
(328, 41, 30, '2025-04-15 06:24:33', '2025-04-15 06:24:33'),
(329, 41, 31, '2025-04-15 06:24:33', '2025-04-15 06:24:33'),
(330, 23, 4, '2025-06-30 03:00:23', '2025-06-30 03:00:23'),
(429, 22, 17, '2025-12-15 02:49:47', '2025-12-15 02:49:47'),
(430, 22, 18, '2025-12-15 02:49:47', '2025-12-15 02:49:47'),
(431, 22, 19, '2025-12-15 02:49:47', '2025-12-15 02:49:47'),
(432, 22, 20, '2025-12-15 02:49:47', '2025-12-15 02:49:47'),
(433, 22, 21, '2025-12-15 02:49:47', '2025-12-15 02:49:47'),
(434, 22, 22, '2025-12-15 02:49:47', '2025-12-15 02:49:47'),
(435, 22, 23, '2025-12-15 02:49:47', '2025-12-15 02:49:47'),
(436, 17, 1, '2026-03-31 10:50:47', '2026-03-31 10:50:47'),
(725, 42, 1, '2026-07-05 10:31:44', '2026-07-05 10:31:44'),
(726, 42, 2, '2026-07-05 10:31:44', '2026-07-05 10:31:44'),
(727, 42, 3, '2026-07-05 10:31:44', '2026-07-05 10:31:44'),
(728, 42, 8, '2026-07-05 10:31:44', '2026-07-05 10:31:44'),
(729, 42, 9, '2026-07-05 10:31:44', '2026-07-05 10:31:44'),
(730, 42, 10, '2026-07-05 10:31:44', '2026-07-05 10:31:44'),
(731, 42, 12, '2026-07-05 10:31:44', '2026-07-05 10:31:44'),
(732, 42, 16, '2026-07-05 10:31:44', '2026-07-05 10:31:44'),
(733, 42, 18, '2026-07-05 10:31:44', '2026-07-05 10:31:44'),
(734, 24, 3, '2026-07-13 02:02:28', '2026-07-13 02:02:28'),
(737, 31, 8, '2026-07-21 23:39:50', '2026-07-21 23:39:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `premium_packages`
--

CREATE TABLE `premium_packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `desc` longtext NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `premium_packages`
--

INSERT INTO `premium_packages` (`id`, `name`, `desc`, `price`, `created_at`, `updated_at`) VALUES
(1, 'Free', '- Sistem edit terbatas\r\n- Tanpa order Whatsapp\r\n- Input produk maks(3)', 0, NULL, '2025-04-21 00:32:14'),
(2, 'Standart', '- Sistem edit komplit\r\n- Sistem order WhatsApp\r\n- Fungsi rekap otomatis\r\n- Input produk maks(50)\r\n- Penyesuaian contact', 150000, NULL, '2025-04-21 00:34:24'),
(3, 'Premium', '- Sistem edit komplit\r\n- Sistem order WhatsApp\r\n- Fungsi rekap otomatis\r\n- Input produk unlimited\r\n- Penyesuaian contact', 450000, NULL, '2025-04-21 00:34:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `template` varchar(255) NOT NULL DEFAULT 'four',
  `template_id` bigint(20) UNSIGNED DEFAULT 1,
  `youtube` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `description` longtext NOT NULL,
  `product_title` varchar(255) NOT NULL DEFAULT 'Produk Kami',
  `order_title` varchar(255) NOT NULL DEFAULT 'beli',
  `status` varchar(255) NOT NULL DEFAULT 'unactive',
  `customer_data` enum('active','unactive') NOT NULL DEFAULT 'active',
  `qris_status` enum('active','unactive') NOT NULL DEFAULT 'active',
  `no_tlp` varchar(255) DEFAULT NULL,
  `qris` varchar(255) DEFAULT NULL,
  `domain` varchar(255) DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `home_button` enum('on','off') NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `image`, `template`, `template_id`, `youtube`, `subtitle`, `price`, `description`, `product_title`, `order_title`, `status`, `customer_data`, `qris_status`, `no_tlp`, `qris`, `domain`, `address`, `home_button`, `created_at`, `updated_at`) VALUES
(7, 'CSN Yogurt', 'csn-yogurt', '1732087358.jpg.webp', 'twelve', 6, 'https://www.youtube.com/watch?v=zGoCL-71D5c', 'Yogurt sehat dan lezat, kaya probiotik untuk kesehatan.', NULL, 'Yogurt adalah produk susu fermentasi yang kaya akan probiotik, baik untuk kesehatan pencernaan dan sistem kekebalan tubuh. Proses fermentasi mengubah laktosa menjadi asam laktat, memberikan rasa asam khas dan tekstur kental pada yogurt. Selain kaya akan protein dan kalsium, yogurt juga mengandung berbagai nutrisi penting lainnya. Ada banyak jenis yogurt, mulai dari yang plain hingga yang kaya rasa buah. Yogurt bisa dinikmati sebagai sarapan, camilan, atau bahkan bahan untuk membuat berbagai macam makanan dan minuman.', 'Produk Kami', 'beli', 'active', 'active', 'active', NULL, NULL, NULL, NULL, 'on', '2024-11-20 07:22:38', '2025-03-05 09:07:46'),
(8, 'Wisata Kampung Singkur', 'wisata-kampung-singkur', '1732087533.jpeg.webp', 'two', 2, 'https://www.youtube.com/watch?v=qA-P-UVsO28', 'Wisata alam asri di tepi Sungai Palayangan, Bandung Selatan.', NULL, 'Kampung Singkur adalah destinasi wisata alam yang terletak di tengah hutan pinus Rahong, Pangalengan, Bandung. Tempat ini menawarkan pengalaman liburan yang seru dan menyegarkan, dengan beragam aktivitas outdoor yang dapat dinikmati.\r\n\r\nDaya Tarik Kampung Singkur:\r\n\r\n- Pemandangan Alam yang Menakjubkan: Dikelilingi oleh hutan pinus yang hijau dan segar, Kampung Singkur menyajikan pemandangan alam yang menenangkan. Udara yang sejuk dan suasana yang tenang sangat cocok untuk melepas penat.\r\n\r\nBeragam Aktivitas Outdoor:\r\n\r\n- Rafting: Arungi sungai Palayangan dengan jeram-jeramnya yang menantang. Aktivitas ini sangat cocok untuk memacu adrenalin dan melatih kerja sama tim.\r\n- Camping: Nikmati sensasi menginap di alam bebas dengan mendirikan tenda di area yang telah disediakan.\r\n- Outbound: Latih kekompakan dan kerjasama tim melalui berbagai permainan outbound yang seru.\r\n- Paintball: Uji keberanian dan ketangkasan dengan permainan tembak-menembak menggunakan peluru cat.\r\n- ATV Ride: Jelajahi medan yang menantang dengan mengendarai ATV.\r\n- Flying Fox: Rasakan sensasi meluncur dari ketinggian sambil menikmati pemandangan sekitar.', 'Produk Kami', 'beli', 'active', 'active', 'active', '082319614320', NULL, NULL, NULL, 'on', '2024-11-20 07:25:33', '2025-03-05 09:08:09'),
(9, 'Rumah Putih Cukul', 'rumah-putih-cukul', '1732087558.jpg.webp', 'thirteen', 1, 'https://www.youtube.com/watch?v=W1La2GYyAd0', 'Rumah Putih Cukul, tempat wisata indah dengan pemandangan alami.', NULL, 'Rumah Putih Cukul adalah sebuah bangunan bersejarah dengan arsitektur khas Eropa, tepatnya bergaya Jerman. Terletak di tengah keindahan perkebunan teh dan danau di kawasan Sukaluyu, Pangalengan, Bandung, Jawa Barat, rumah ini menawarkan pesona yang unik dan menarik.\r\n\r\nCiri-ciri khas Rumah Putih Cukul:\r\n\r\nArsitektur Eropa Klasik: Dinding putih yang bersih, jendela-jendela besar, dan atap yang menjulang tinggi menjadi ciri khas bangunan ini. Desainnya yang elegan dan klasik memberikan nuansa Eropa yang kuat.\r\nLokasi yang Strategis:\r\nBerada di tengah perkebunan teh yang hijau subur, Rumah Putih Cukul menyuguhkan pemandangan alam yang menyegarkan mata. Udara sejuk pegunungan dan keindahan alam sekitar membuat suasana semakin nyaman.\r\n\r\nSejarah yang Menarik: Bangunan ini telah berdiri sejak zaman Belanda dan menyimpan banyak cerita sejarah. Konon, rumah ini pernah menjadi tempat tinggal para pekerja perkebunan teh pada masanya.\r\n\r\nNuansa Misteri: \r\nSelain keindahan alam dan sejarahnya, Rumah Putih Cukul juga dikenal memiliki aura mistis. Banyak cerita rakyat dan legenda yang berkembang di sekitar bangunan ini, menambah daya tarik tersendiri bagi para pengunjung yang penasaran.\r\n\r\nAlasan Mengapa Rumah Putih Cukul Menarik untuk Dikunjungi:\r\n\r\nPelarian dari Hiruk Pikuk Kota:\r\nBagi Anda yang ingin mencari ketenangan dan suasana yang berbeda, Rumah Putih Cukul adalah pilihan yang tepat.\r\n\r\nMengenal Lebih Jauh Sejarah:\r\nBagi Anda yang tertarik dengan sejarah, mengunjungi Rumah Putih Cukul bisa menjadi pengalaman yang berharga.\r\n\r\nAktivitas yang Bisa Dilakukan di Rumah Putih Cukul:\r\n\r\nBerkeliling Rumah:\r\nAnda bisa menjelajahi setiap sudut rumah dan menikmati keindahan arsitekturnya.\r\n\r\nBerfoto: \r\nAbadikan momen indah Anda dengan latar belakang Rumah Putih Cukul dan perkebunan teh.\r\n\r\nPiknik: \r\nBawa bekal dan nikmati suasana alam yang sejuk sambil bersantai.\r\n\r\nBerjalan-jalan di Perkebunan Teh:Jelajahi perkebunan teh yang luas dan nikmati udara segarnya.\r\n\r\nTips Berkunjung ke Rumah Putih Cukul:\r\n\r\nDatang Pagi Hari:\r\nSuasana pagi hari di Rumah Putih Cukul sangat sejuk dan indah.\r\n\r\nJangan Buang Sampah Sembarangan: Jaga kebersihan lingkungan sekitar.\r\n\r\nKesimpulan:\r\n\r\nRumah Putih Cukul adalah destinasi wisata yang menarik dengan perpaduan unik antara keindahan alam, sejarah, dan nuansa mistis. Jika Anda berkunjung ke Bandung, jangan lewatkan kesempatan untuk mengunjungi tempat yang satu ini.', 'Produk Kami', 'beli', 'active', 'active', 'active', '082021234471', NULL, NULL, NULL, 'on', '2024-11-20 07:25:58', '2025-03-05 09:08:22'),
(10, 'Curug Penganten', 'curug-penganten', '1732087974.jpeg.webp', 'five', 16, 'https://www.youtube.com/watch?v=FoIMs3BC37c', 'Air terjun eksotis dengan panorama asri, cocok untuk liburan san', NULL, 'Curug Penganten adalah destinasi wisata alam yang menawarkan pesona keindahan alam yang luar biasa. Tersembunyi di pangalengan, curug ini menyajikan pemandangan dua air terjun dengan ketinggian yang berbeda, menciptakan panorama yang sangat memikat. Air terjun yang lebih besar memiliki debit air yang deras, sementara air terjun yang lebih kecil memberikan kesan yang lebih lembut. Suara gemericik air yang jatuh dari ketinggian, ditambah dengan udara segar pegunungan, menciptakan suasana yang sangat menenangkan.\r\n\r\nDaya tarik lain dari Curug Penganten:\r\n\r\nKeunikan dua aliran air terjun: Simbolisasi dari sepasang pengantin yang abadi.\r\n\r\nKolam alami: Sempurna untuk berenang dan menikmati kesegaran air pegunungan.\r\n\r\nTracking ringan: Menawarkan pengalaman menjelajahi alam yang menyenangkan.\r\nKeindahan alam sekitar: Hutan hijau yang asri dan udara yang segar.', 'Produk Kami', 'beli', 'active', 'active', 'active', '088271234212', NULL, NULL, NULL, 'on', '2024-11-20 07:32:55', '2025-03-05 09:08:32'),
(11, 'Perkebunan Teh Malabar', 'perkebunan-teh-malabar', '1732087976.jpg.webp', 'two', 2, 'https://youtu.be/dRfvxkVxooA?si=OrwonDv3v3Y_kkd9', 'Perkebunan Teh Malabar, pesona alam dengan teh berkualitas.', NULL, 'Perkebunan Teh Malabar adalah salah satu perkebunan teh tertua dan terbesar di Indonesia. Terletak di kawasan Pangalengan, Kabupaten Bandung, Jawa Barat, perkebunan ini menawarkan pesona alam yang luar biasa dengan hamparan kebun teh hijau sejauh mata memandang.\r\n\r\nKeindahan Alam yang Memukau\r\n\r\n- Hamparan Kebun Teh: Pemandangan utama yang paling menarik di Malabar adalah hamparan kebun teh yang hijau dan berundak-undak. Pemandangan ini sangat instagramable dan sering dijadikan latar belakang foto.\r\n- Udara Sejuk: Suhu udara di Malabar cenderung sejuk karena berada di dataran tinggi. Udara segar dan bersih ini sangat baik untuk kesehatan.\r\n- Pegunungan: Perkebunan ini dikelilingi oleh pegunungan yang menjulang tinggi, menambah keindahan panorama alamnya.', 'Produk Kami', 'beli', 'active', 'active', 'active', NULL, NULL, NULL, NULL, 'on', '2024-11-20 07:32:56', '2025-03-05 09:08:43'),
(12, 'Situ Cileunca', 'situ-cileunca', '1732088219.jpg.webp', 'five', 1, 'https://www.youtube.com/watch?v=PhBFDDl6LVM', 'Situ Cileunca: Danau indah untuk rekreasi alam dan aktivitas ser', NULL, 'Objek wisata lain di Pangalengan yang bisa Moms kunjungi adalah Situ Cileunca. Danau buatan seluar 1.400 hektar ini merupakan salah satu tempat favorit para wisatawan saat datang ke lokasi ini.\r\n\r\nSalah satu spot paling terkenal di lokasi ini adalah Jembatan Cinta dan sering dijadikan tempat untuk berforo para wisatawan.\r\n\r\nTak hanya itu, para pelancong yang datang juga tidak perlu merogoh kocek yang dalam.\r\n\r\nMoms pun dapat menikmati berbagai wahana termasuk keindahan perkebunan arbei dan jeruk.', 'Produk Kami', 'beli', 'active', 'active', 'active', '087762212219', NULL, NULL, NULL, 'on', '2024-11-20 07:36:59', '2025-03-05 09:08:57'),
(13, 'Perkebunan Teh Cukul', 'perkebunan-teh-cukul', '1732088293.jpeg.webp', 'two', 2, 'https://www.youtube.com/watch?v=X1LXHyiKQGc', 'Kebun teh asri dengan udara sejuk dan pemandangan memukau.', NULL, 'Meskipun tidak sebesar dan seterkenal beberapa perkebunan teh lainnya di Indonesia, Perkebunan Teh Cukul memiliki pesona tersendiri yang patut untuk dikunjungi. Terletak di kawasan pegunungan dengan udara sejuk, perkebunan teh ini menawarkan pengalaman yang berbeda bagi para wisatawan.\r\n\r\nKeunikan Perkebunan Teh Cukul\r\n\r\n- Pemandangan Alam yang Asri: Hamparan kebun teh hijau yang luas, udara segar, dan suara gemericik air sungai kecil menjadikan Cukul sebagai tempat yang sempurna untuk melepas penat.\r\n- Ketenangan dan Kedamaian: Jauh dari hiruk pikuk kota, Cukul menawarkan suasana yang tenang dan damai, sangat cocok bagi Anda yang mencari ketenangan.\r\n- Potensi Wisata Edukasi: Selain menikmati keindahan alam, pengunjung juga dapat belajar tentang proses pembuatan teh dari mulai petik hingga pengemasan.', 'Produk Kami', 'beli', 'active', 'active', 'active', NULL, NULL, NULL, NULL, 'on', '2024-11-20 07:38:13', '2025-03-05 09:09:09'),
(14, 'Kue Pia Kawitan', 'kue-pia-kawitan', '1732088340.jpg.webp', 'six', 15, 'https://www.youtube.com/watch?v=hJ6Xstg6T38', 'Kue tradisional dengan rasa autentik dan tekstur lembut menggoda', NULL, 'Kue pia Kawitan adalah oleh-oleh khas dari Pangalengan, Bandung Selatan. Kue ini memiliki kemiripan dengan bakpia pada umumnya, namun memiliki ciri khas rasa dan tekstur yang berbeda. Pia Kawitan biasanya memiliki ukuran yang sedikit lebih besar dan tekstur kulit yang lebih renyah. Isiannya pun beragam, mulai dari kacang hijau, cokelat, keju, hingga susu. Nama \"Kawitan\" sendiri memiliki arti \"asli\" atau \"pertama\" dalam bahasa Sunda, yang mungkin merujuk pada asal usul kue ini di daerah Pangalengan. Dengan rasa manis dan gurih yang seimbang, pia Kawitan menjadi salah satu oleh-oleh favorit bagi wisatawan yang berkunjung ke Bandung Selatan.', 'Produk Kami', 'beli', 'active', 'active', 'active', NULL, NULL, NULL, NULL, 'on', '2024-11-20 07:39:00', '2025-03-13 02:20:27'),
(15, 'Abon Asep Pos', 'abon-asep-pos', '1732088651.jpg.webp', 'six', 15, 'https://www.youtube.com/watch?v=fYWFLJpUZrk', 'Abon Asep Pos, abon rasa lezat dan berkualitas tinggi.', NULL, 'Abon adalah makanan olahan khas Indonesia yang terbuat dari serat daging hewan seperti sapi, ayam, atau ikan. Daging tersebut diiris tipis, lalu dimasak bersama bumbu-bumbu seperti gula, garam, merica, dan rempah-rempah lainnya hingga kering dan berserat. Abon memiliki rasa yang gurih dan manis, serta tekstur yang renyah. Biasanya digunakan sebagai lauk pauk untuk nasi, taburan mi atau bubur, atau sebagai isian makanan seperti lemper.', 'Produk Kami', 'beli', 'active', 'active', 'active', NULL, NULL, NULL, NULL, 'on', '2024-11-20 07:44:11', '2025-03-05 09:09:28'),
(16, 'Boemi Cileunca', 'boemi-cileunca', '1734496552.jpg.webp', 'five', 19, 'https://youtube.com/shorts/yT_fdTs5LzQ', 'Villa eksklusif dengan pemandangan indah dan fasilitas modern.', NULL, 'Villa ini menawarkan pengalaman liburan tak terlupakan dengan pemandangan alam yang memukau dan suasana yang menenangkan. Dirancang dengan konsep modern dan sentuhan elegan, villa ini dilengkapi fasilitas lengkap seperti kolam renang pribadi, dapur yang sepenuhnya fungsional, serta ruang tamu yang luas dan nyaman. Setiap detailnya dirancang untuk memberikan kenyamanan maksimal dan menjadikan liburan Anda lebih istimewa.\r\n\r\nSelain itu, lokasinya yang strategis memudahkan Anda untuk menjelajahi berbagai destinasi wisata populer di sekitarnya. Dengan privasi penuh dan layanan ramah dari staf yang profesional, villa ini menjadi pilihan sempurna untuk menghabiskan waktu berkualitas bersama keluarga atau teman. Nikmati momen istimewa Anda di tempat yang indah dan penuh ketenangan ini.', 'Produk Kami', 'beli', 'active', 'active', 'active', NULL, NULL, NULL, NULL, 'on', '2024-12-18 04:35:52', '2025-03-13 02:20:48'),
(17, 'D Bloem', 'd-bloem', '1734496699.jpg.webp', 'six', NULL, NULL, 'Villa asri dan nyaman, sempurna untuk liburan tenang.', NULL, 'D\'Bloem adalah sebuah villa asri yang dirancang untuk memberikan pengalaman liburan yang santai dan menyenangkan. Terletak di lokasi yang tenang dengan pemandangan alam yang memukau, villa ini menawarkan suasana damai yang jauh dari hiruk-pikuk kota. Dengan desain interior yang elegan dan sentuhan modern, setiap sudut D\'Bloem dirancang untuk memberikan kenyamanan maksimal kepada para tamu. Kamar-kamar yang luas, dapur yang lengkap, dan area outdoor yang memukau menjadikan villa ini tempat yang ideal untuk bersantai bersama keluarga atau teman terdekat.\r\n\r\nSelain fasilitas yang lengkap, D\'Bloem juga menawarkan berbagai aktivitas yang mendukung momen liburan Anda. Anda dapat menikmati keindahan taman hijau, berenang di kolam pribadi, atau sekadar bersantai di teras sambil menikmati udara segar. Layanan ramah dari staf profesional siap memastikan kebutuhan Anda terpenuhi dengan sempurna. D\'Bloem bukan hanya sebuah tempat menginap, tetapi juga destinasi untuk menciptakan kenangan indah yang tak terlupakan.', 'Produk Kami', 'beli', 'active', 'active', 'active', NULL, NULL, NULL, NULL, 'on', '2024-12-18 04:38:19', '2026-03-31 10:50:47'),
(18, 'Salabim Villa', 'salabim-villa', '1734496930.jpg.webp', 'nine', 16, 'https://youtube.com/shorts/hOvJne8-GRU', 'Vila luas dan nyaman, ideal untuk liburan bersama-sama.', NULL, 'Vila ini dirancang khusus untuk memenuhi kebutuhan liburan kelompok besar, dengan fasilitas luas yang dapat menampung banyak tamu dengan nyaman. Dilengkapi dengan beberapa kamar tidur, ruang tamu yang luas, dan area makan besar, vila ini menawarkan kenyamanan dan privasi bagi setiap anggota kelompok. Pemandangan alam yang indah dan ruang outdoor yang luas memungkinkan Anda untuk menikmati waktu bersama sambil bersantai atau melakukan kegiatan bersama.\r\n\r\nTerletak di lokasi strategis, vila ini juga dekat dengan berbagai tempat wisata dan aktivitas yang cocok untuk kelompok. Dengan layanan yang ramah dan profesional, vila ini siap membuat liburan kelompok Anda semakin berkesan. Nikmati kebersamaan, kenyamanan, dan ketenangan dalam satu tempat yang sempurna.', 'Produk Kami', 'beli', 'active', 'active', 'active', NULL, NULL, NULL, NULL, 'on', '2024-12-18 04:42:10', '2025-03-13 02:21:22'),
(19, 'Citere Resort Hotel', 'citere-resort-hotel', '1735792336.jpg.webp', 'two', 13, 'https://youtube.com/shorts/JgfdE5iFsFQ', 'Resort nyaman dengan nuansa alam asri, ideal untuk relaksasi.', NULL, 'Citere Resort Hotel menawarkan pengalaman menginap yang memadukan kenyamanan modern dengan keindahan alam. Dikelilingi oleh pepohonan hijau dan udara sejuk, resort ini memberikan suasana tenang yang sempurna untuk melepas penat. Setiap sudut dirancang untuk menghadirkan relaksasi maksimal, mulai dari kamar yang nyaman hingga fasilitas outdoor yang memanjakan.\r\n\r\nSelain itu, Citere Resort juga menyediakan akses mudah ke berbagai aktivitas alam seperti trekking dan bersepeda, menjadikannya pilihan ideal bagi pecinta petualangan. Dengan layanan yang ramah dan fasilitas lengkap, resort ini adalah tempat yang tepat untuk bersantai bersama keluarga atau pasangan.', 'Produk Kami', 'beli', 'active', 'active', 'active', NULL, NULL, NULL, NULL, 'on', '2025-01-02 04:32:16', '2025-03-13 02:22:09'),
(20, 'Rumahhandsock', 'rumahhandsock', '1743504347.webp.webp', 'five', 21, 'https://youtube.com/shorts/ACWoBrn1lgE?feature=share', 'Produsen Handsock Premium dengan Harga Terjangkau. Siap kirim seluruh Indonesia, Singapura, Malaysia dan Taiwan.', NULL, 'Order disini untuk memudahkan rekap', 'Produk Kami', 'beli', 'active', 'active', 'active', '085798765798', NULL, NULL, NULL, 'on', '2025-01-02 04:57:16', '2025-04-01 09:45:48'),
(21, 'Villa Family', 'villa-family', '1735798141.jpg.webp', 'eleven', 17, 'https://youtube.com/shorts/28mVVa0CseQ', 'Villa Family dengan nuansa tosca yang cerah, nyaman untuk keluar', NULL, 'Villa Family menawarkan suasana yang hangat dengan dominasi warna tosca yang memikat. Terletak di lokasi strategis, villa ini dirancang khusus untuk kenyamanan keluarga dengan ruang yang luas dan fasilitas lengkap. Setiap sudut villa memberikan sentuhan elegan yang memanjakan mata.\r\n\r\nTidak hanya menyediakan tempat menginap, Villa Family juga dilengkapi dengan kolam renang pribadi, taman hijau, dan area bermain anak. Keindahan interior dan eksteriornya menjadi daya tarik tersendiri untuk pengalaman menginap yang tak terlupakan bersama orang tercinta.', 'Produk Kami', 'beli', 'active', 'active', 'active', NULL, NULL, NULL, NULL, 'on', '2025-01-02 06:09:01', '2025-02-24 03:07:32'),
(22, 'gudangsembako', 'gudangsembako', '1743031582.jpg.webp', 'ten', 20, NULL, 'Grosir Murah Sembako Pameungpeuk Bandung', NULL, 'Untuk order silakan klik tombol beli dan checkout langsung  di pojok kanan atas.', 'Produk Kami', 'Pilih', 'active', 'active', 'active', '085798765798', NULL, NULL, NULL, 'on', '2025-01-02 06:59:38', '2025-12-15 02:49:47'),
(23, 'Terace Danoe Camp', 'terace-danoe-camp', '1735802637.jpg.webp', 'two', 3, 'https://youtube.com/shorts/TqUPKITFkFo', 'Nikmati keindahan alam, udara sejuk, dan camping tak terlupakan.', NULL, 'Terace Danoe Camp adalah destinasi sempurna untuk Anda yang ingin menikmati liburan di alam terbuka. Terletak di kawasan dengan pemandangan danau yang memukau, tempat ini menawarkan suasana tenang dan udara segar yang jarang ditemukan di perkotaan. Cocok untuk keluarga, teman, atau bahkan solo travelers yang ingin melepaskan diri dari rutinitas harian.\r\n\r\nSelain keindahan alamnya, Terace Danoe Camp juga dilengkapi dengan fasilitas modern untuk memastikan kenyamanan Anda selama menginap. Nikmati malam di bawah langit penuh bintang dengan fasilitas api unggun, atau mulai pagi Anda dengan secangkir kopi sambil menikmati pemandangan danau.', 'Produk Kami', 'beli', 'active', 'active', 'active', NULL, NULL, NULL, NULL, 'on', '2025-01-02 07:23:57', '2025-06-30 03:00:23'),
(24, 'Nimo Highland', 'nimo-highland', '1735803528.png.webp', 'three', 1, 'https://youtube.com/shorts/-YzIV-VKF_U', 'Nikmati pesona alam dan budaya di Nimo Highland', NULL, 'Nimo Highland adalah destinasi wisata unik yang memadukan keindahan alam pegunungan dengan sentuhan budaya lokal. Terletak di ketinggian, tempat ini menawarkan pemandangan memukau yang membentang sejauh mata memandang. Udara segar dan suasana yang tenang membuatnya cocok untuk melepas penat dari rutinitas sehari-hari.\r\n\r\nTidak hanya menyuguhkan keindahan alam, Nimo Highland juga menghadirkan beragam atraksi budaya dan aktivitas menarik. Mulai dari mencicipi kuliner khas, mengikuti workshop kerajinan lokal, hingga menjelajahi spot foto ikonik yang Instagram-worthy. Semua ini dirancang untuk memberikan pengalaman liburan yang tak terlupakan.', 'Produk Kami', 'beli', 'active', 'active', 'unactive', NULL, NULL, NULL, NULL, 'on', '2025-01-02 07:38:48', '2026-07-13 02:02:28'),
(25, 'Villa The Kabayan Pangalengan', 'villa-the-kabayan-pangalengan', '1735804801.jpg.webp', 'six', 20, NULL, 'Villa asri di Pangalengan, cocok untuk keluarga atau acara kelom', NULL, 'Villa The Kabayan Pangalengan adalah tempat peristirahatan nyaman di kawasan sejuk Pangalengan. Dengan suasana pedesaan yang asri, villa ini menjadi destinasi favorit untuk keluarga atau rombongan yang mencari ketenangan jauh dari hiruk pikuk kota. Dikelilingi oleh pemandangan alam yang memukau, Villa The Kabayan menawarkan kenyamanan dengan fasilitas modern yang lengkap.\r\n\r\nSelain itu, lokasinya yang strategis memungkinkan tamu untuk mengeksplorasi berbagai wisata alam di sekitar Pangalengan, seperti perkebunan teh, danau, serta spot hiking. Villa ini juga memiliki ruang yang luas untuk kegiatan outdoor, menjadikannya tempat ideal untuk acara kumpul keluarga, team building, atau sekadar liburan santai.', 'Produk Kami', 'beli', 'active', 'active', 'active', NULL, NULL, NULL, NULL, 'on', '2025-01-02 08:00:01', '2025-03-13 02:23:22'),
(26, 'Villa Amissa', 'villa-amissa', '1735806031.jpg.webp', 'four', 14, 'https://youtube.com/shorts/yqsLLuuSsdc', 'Villa Amissa: Penginapan dengan pemandangan alam menawan', NULL, 'Villa Amissa adalah destinasi sempurna untuk pengalaman menginap yang nyaman dan mewah. Terletak di tengah pemandangan alam yang asri, villa ini menawarkan suasana yang tenang dan jauh dari hiruk-pikuk perkotaan. Dilengkapi dengan fasilitas modern dan desain interior elegan, Villa Amissa memberikan kenyamanan maksimal untuk keluarga atau pasangan.\r\n\r\nNikmati momen santai di kolam renang pribadi atau bersantai di teras sambil menikmati panorama alam yang memukau. Dengan layanan yang ramah dan profesional, Villa Amissa memastikan setiap tamu merasa seperti di rumah sendiri. Lokasinya yang strategis membuat villa ini mudah diakses dari berbagai destinasi wisata populer di sekitarnya.', 'Produk Kami', 'beli', 'active', 'active', 'active', NULL, NULL, NULL, NULL, 'on', '2025-01-02 08:20:31', '2025-03-13 02:23:45'),
(27, 'Shifa Camp 2', 'shifa-camp-2', '1735808597.jpg.webp', 'six', 1, 'https://youtube.com/shorts/ESE5U4vUlFg', 'Shifa Camp 2: Semi Villa nyaman di alam pegunungan.', NULL, 'Shifa Camp 2 menawarkan pengalaman menginap yang unik dengan konsep semi villa yang dikelilingi oleh suasana pegunungan asri. Tempat ini cocok untuk liburan keluarga atau kumpul bersama teman dengan pemandangan indah dan udara segar yang menenangkan.\r\n\r\nSetiap unit dilengkapi fasilitas modern untuk kenyamanan maksimal, seperti kamar tidur yang luas, ruang tamu minimalis, dan dapur kecil yang fungsional. Nikmati momen istimewa dengan api unggun atau bersantai di area luar yang dirancang untuk memberikan pengalaman liburan tak terlupakan.', 'Produk Kami', 'beli', 'active', 'active', 'active', NULL, NULL, NULL, NULL, 'on', '2025-01-02 09:03:17', '2025-03-13 02:24:09'),
(29, 'Plaza Toyota', 'plaza-toyota', '1737951489.jpg.webp', 'fourteen', 20, 'https://www.youtube.com/watch?v=5yuoM39IbLg', 'Enjoy Every Journey Life Every Moment', NULL, 'Toyota: Pilihan Terbaik untuk Mobil Berkualitas\r\n\r\nToyota adalah merek otomotif global yang dikenal karena kualitas, keandalan, dan inovasinya. Dengan berbagai jenis kendaraan, mulai dari mobil keluarga yang nyaman, SUV tangguh, hingga kendaraan ramah lingkungan seperti hybrid, Toyota menawarkan solusi mobilitas untuk berbagai kebutuhan.\r\n\r\nKeunggulan Toyota\r\n\r\nToyota mengutamakan efisiensi bahan bakar, performa, dan fitur keselamatan modern. Sistem seperti Toyota Safety Sense memberikan perlindungan ekstra, menjadikannya pilihan ideal bagi pengemudi yang mengutamakan kenyamanan dan keamanan.\r\n\r\nPilihan Kendaraan yang Beragam\r\nDealer Toyota menyediakan berbagai model populer, termasuk:\r\n\r\n- Toyota Avanza - Mobil keluarga yang luas dan andal.\r\n- Toyota Fortuner - SUV mewah dengan performa tangguh.\r\n- Toyota Yaris - Hatchback stylish untuk gaya hidup dinamis.\r\n\r\nDealer Toyota: Mitra Mobil Impian Anda\r\n\r\nKami menawarkan pengalaman membeli mobil yang menyenangkan, dengan layanan lengkap seperti:\r\n\r\n- Konsultasi: Rekomendasi kendaraan sesuai kebutuhan.\r\n- Test Drive: Rasakan langsung performa mobil.\r\n- Program Pembiayaan: Opsi cicilan fleksibel.\r\n- Layanan Purna Jual: Servis berkualitas dengan suku cadang asli.\r\n\r\nToyota juga berkomitmen pada inovasi berkelanjutan melalui pengembangan kendaraan hybrid dan listrik untuk masa depan yang lebih hijau. Kunjungi dealer kami dan temukan mobil Toyota impian Anda dengan mudah!', 'Produk Kami', 'beli', 'active', 'active', 'active', NULL, NULL, NULL, NULL, 'on', '2025-01-27 04:18:09', '2025-02-24 03:09:14'),
(30, 'Waroeng \'Onis', 'waroeng-onis', '1738041160.png.webp', 'fourteen', 21, NULL, NULL, NULL, 'Waroeng O’nis adalah produsen masakan Spesialis Sambal Seruit Lampung & Cemilan Jamur Crispy JACY. Berawal dari usaha rumahan dengan konsep Ghost Kitchen di Kuningan yang berdiri tahun 2017, sekarang Waroeng O’nis berdiri sebagai perusahaan dibidang Resto & Catering, Cemilan Kemasan Jamur Crispy JACY, Supplier Bahan Baku Fried Chicken.\r\n\r\nWaroeng O’nis memasarkan produknya via Online & Offline.', 'Produk Kami', 'beli', 'active', 'active', 'active', '085624203799', NULL, NULL, NULL, 'on', '2025-01-28 05:12:40', '2025-04-11 06:19:40'),
(31, 'Brave Steak', 'brave-steak', '1738306603.jpeg.webp', 'eleven', 28, NULL, 'Steaknya Indonesia', NULL, 'Waroeng Steak & Shake adalah sebuah jaringan rumah makan yang menyajikan aneka steik, susu kocok, dan hidangan lainnya. Berkantor pusat di Yogyakarta, perusahaan ini didirikan oleh Jody Brotosuseno pada tanggal 4 September 2000. Restoran ini telah memiliki lebih dari 90 cabang yang tersebar di Indonesia.', 'Menu Pilihan', 'Pesan', 'active', 'active', 'active', '085624203799', '0e418edb-0568-46b3-82b4-1594092cedc9.webp', NULL, NULL, 'on', '2025-01-31 06:56:43', '2026-07-21 23:39:50'),
(32, 'Waroeng Steak', 'waroeng-steak', '1738309735.jpg.webp', 'fourteen', 20, 'https://www.youtube.com/watch?v=d6ZOQbS6qKg', 'Rasakan pengalaman kuliner tak terlupakan di Steak And Shake', NULL, 'Rasakan pengalaman kuliner tak terlupakan di Waroeng Steak And Shake, tempat di mana kelezatan daging bertemu dengan suasana yang hangat dan nyaman. Kami menghadirkan steak dengan kualitas terbaik, disajikan dengan pilihan saus yang menggoda dan side dish yang lezat. Setiap hidangan kami dibuat dengan cinta dan perhatian, memastikan setiap suapan adalah kenikmatan yang tak terlupakan.', 'Produk Kami', 'beli', 'active', 'active', 'active', NULL, NULL, NULL, NULL, 'on', '2025-01-31 07:04:37', '2025-03-13 02:24:59'),
(33, 'Ugo', 'ugo', '1742523189.jpg.webp', 'four', 3, NULL, 'Jasa Pembuatan Website, Digital Marketing Bandung', NULL, 'Jasa Website, Jasa SEO, Google Ads Bandung.', 'Produk Kami', 'beli', 'active', 'active', 'active', '085798765798', NULL, NULL, NULL, 'on', '2025-02-13 02:55:43', '2025-03-21 02:13:09'),
(35, 'Seblak Bandung Juara', 'seblak-bandung-juara', '1740641363.jpeg.webp', 'four', 1, NULL, 'Seblak Paling JUara', NULL, 'Deskripsi tentnag usaha anda', 'Produk Kami', 'beli', 'unactive', 'active', 'active', '0123456789', NULL, NULL, NULL, 'on', '2025-02-27 07:29:23', '2025-02-27 07:29:23'),
(37, 'keyboard bandung', 'keyboard-bandung', '1740722895.jpg.webp', 'four', 1, NULL, 'Keyboard paling murah', NULL, 'Kami menjual berbagai jenis dan merek keyboard', 'Produk Kami', 'beli', 'unactive', 'active', 'active', '08123456789', NULL, NULL, NULL, 'on', '2025-02-28 06:08:17', '2025-02-28 06:08:17'),
(40, 'Dummy', 'dummy', '1744164694.png.webp', 'four', 19, NULL, 'dummy', NULL, 'dummy', 'Produk Kami', 'beli', 'unactive', 'active', 'active', NULL, NULL, NULL, NULL, 'on', '2025-04-09 01:11:39', '2025-04-09 01:20:44'),
(41, 'Gojes', 'gojes', '1744617059.png.webp', 'four', 16, NULL, 'Sabun Pencuci Serba Bisa - Gojes Pembersih', NULL, 'GOJES tidak hanya fokus pada produksi dan penjualan, tetapi juga berkomitmen untuk tumbuh bersama melalui kemitraan program subdistributor.\r\n\r\nMembuka peluang usaha berbasis kepercayaan (trust) yang menarik dan bisa dijalankan tanpa modal.\r\n\r\nProgram ini memberikan kesempatan bagi siapa pun untuk memulai usaha sendiri dengan dukungan penuh dari GOJES.', 'Produk Kami', 'beli', 'active', 'active', 'active', NULL, NULL, NULL, NULL, 'on', '2025-04-14 06:50:59', '2025-04-15 06:24:33'),
(42, 'Kopi Om Adul', 'kopi-om-adul', '19957bc3-02b8-4752-ba38-e0e0596a4879.webp', 'four', 4, NULL, 'Nikmati hari dengan Kopi Om Adul', NULL, 'Kopi Om Adul salah satu produk kopi Lokal yang menciptakan rasa Premium dengan harga Ekonomis.', 'Produk Kami', 'Order', 'active', 'active', 'active', '081372565174', '879290fb-7cba-4632-b455-828103e71c24.webp', NULL, NULL, 'off', '2026-06-17 06:49:12', '2026-07-07 02:15:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_galleries`
--

CREATE TABLE `product_galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `product_galleries`
--

INSERT INTO `product_galleries` (`id`, `product_id`, `image`, `created_at`, `updated_at`) VALUES
(32, 7, 'IMG-20241120-WA0016_20241120072238.webp', '2024-11-20 07:22:38', '2024-11-20 07:22:38'),
(33, 7, 'IMG-20241120-WA0015_20241120072238.webp', '2024-11-20 07:22:38', '2024-11-20 07:22:38'),
(34, 8, '69b7436c30e1e6c58f4181026a55924b_20241120072533.webp', '2024-11-20 07:25:34', '2024-11-20 07:25:34'),
(35, 9, 'rumah putih cukul 3_20241120072558.webp', '2024-11-20 07:25:58', '2024-11-20 07:25:58'),
(36, 8, 'Kampung-Singkur-Pangalengan-Destinasi-Paling-Asri-Lengkap-dengan-Hutan-Pinusnya_20241120072647.webp', '2024-11-20 07:26:47', '2024-11-20 07:26:47'),
(37, 10, 'DnswEe7U0AAj4q5_20241120073255.webp', '2024-11-20 07:32:55', '2024-11-20 07:32:55'),
(38, 11, 'jembatan-kaca-nimo-highland-1536x780-1-1024x520-4117543662_20241120073256.webp', '2024-11-20 07:32:56', '2024-11-20 07:32:56'),
(39, 11, 'images (2)_20241120073256.webp', '2024-11-20 07:32:56', '2024-11-20 07:32:56'),
(40, 12, 'Situ-Cileunca_-Destinasi-Wisata-Bandung-yang-Menawan-dengan-Keindahan-Alam-dan-Danau-Buatan-Belanda_20241120073659.webp', '2024-11-20 07:37:00', '2024-11-20 07:37:00'),
(41, 13, 'WhatsApp-Image-2023-04-28-at-12.12.25_20241120073813.webp', '2024-11-20 07:38:14', '2024-11-20 07:38:14'),
(42, 13, 'img-20240714-172129-66978b75c925c467e82d8924_20241120073814.webp', '2024-11-20 07:38:15', '2024-11-20 07:38:15'),
(43, 14, 'IMG-20241120-WA0019_20241120073900.webp', '2024-11-20 07:39:01', '2024-11-20 07:39:01'),
(44, 14, 'IMG-20241120-WA0018_20241120073901.webp', '2024-11-20 07:39:01', '2024-11-20 07:39:01'),
(45, 15, 'IMG-20241120-WA0020_20241120074411.webp', '2024-11-20 07:44:11', '2024-11-20 07:44:11'),
(46, 15, 'IMG-20241120-WA0021_20241120074411.webp', '2024-11-20 07:44:11', '2024-11-20 07:44:11'),
(51, 16, 'IMG-20241205-WA0007_20241218043640.webp', '2024-12-18 04:36:40', '2024-12-18 04:36:40'),
(52, 16, 'IMG-20241205-WA0002_20241218043640.webp', '2024-12-18 04:36:41', '2024-12-18 04:36:41'),
(56, 17, 'IMG-20241205-WA0017_20241218043925.webp', '2024-12-18 04:39:26', '2024-12-18 04:39:26'),
(58, 17, 'IMG-20241205-WA0024_20241218043926.webp', '2024-12-18 04:39:27', '2024-12-18 04:39:27'),
(60, 17, 'IMG-20241205-WA0013_20241218043926.webp', '2024-12-18 04:39:27', '2024-12-18 04:39:27'),
(61, 17, 'IMG-20241205-WA0026_20241218043926.webp', '2024-12-18 04:39:27', '2024-12-18 04:39:27'),
(62, 17, 'IMG-20241205-WA0033_20241218043926.webp', '2024-12-18 04:39:27', '2024-12-18 04:39:27'),
(63, 18, 'IMG-20241205-WA0034_20241218044250.webp', '2024-12-18 04:42:50', '2024-12-18 04:42:50'),
(64, 18, 'IMG-20241205-WA0037_20241218044250.webp', '2024-12-18 04:42:50', '2024-12-18 04:42:50'),
(65, 18, 'IMG-20241205-WA0035_20241218044250.webp', '2024-12-18 04:42:50', '2024-12-18 04:42:50'),
(66, 18, 'IMG-20241205-WA0038_20241218044250.webp', '2024-12-18 04:42:50', '2024-12-18 04:42:50'),
(67, 18, 'IMG-20241205-WA0036_20241218044250.webp', '2024-12-18 04:42:51', '2024-12-18 04:42:51'),
(68, 16, 'IMG-20241205-WA0005_20241231035401.webp', '2024-12-31 03:54:01', '2024-12-31 03:54:01'),
(69, 11, 'Gunung Nini Perkebunan Teh Malabar Photo credited to @willy_photograph_20241231071956.webp', '2024-12-31 07:19:56', '2024-12-31 07:19:56'),
(70, 9, '3031896578_20241231073017.webp', '2024-12-31 07:30:17', '2024-12-31 07:30:17'),
(71, 9, '00C_Bandung_20241231073018.webp', '2024-12-31 07:30:18', '2024-12-31 07:30:18'),
(72, 8, 'penginapan_20241231084839.webp', '2024-12-31 08:48:40', '2024-12-31 08:48:40'),
(73, 10, '1db23502-2642-4c33-abe0-d4dad9edaf59_169_20241231085327.webp', '2024-12-31 08:53:27', '2024-12-31 08:53:27'),
(74, 10, 'Berwisata-Asik-ke-Curug-Panganten-Kembar_Daarut-Tauhiid_20241231085327.webp', '2024-12-31 08:53:27', '2024-12-31 08:53:27'),
(75, 12, '629cae0bd4e68_20241231085823.webp', '2024-12-31 08:58:23', '2024-12-31 08:58:23'),
(76, 12, 'Screenshot_2024-05-31-10-48-25-60_1c337646f29875672b5a61192b9010f9-4257875981_20241231085823.webp', '2024-12-31 08:58:23', '2024-12-31 08:58:23'),
(77, 7, '2020-11-16_20241231090524.webp', '2024-12-31 09:05:24', '2024-12-31 09:05:24'),
(79, 14, '3753053_BKOI6X2i7Va_eXh6r6EQ9RvG0W18SdSZJw0wQLzMC4c_20241231095658.webp', '2024-12-31 09:56:58', '2024-12-31 09:56:58'),
(80, 15, 'f792094ed91cfb1c0d59e92c61422817_20241231103346.webp', '2024-12-31 10:33:46', '2024-12-31 10:33:46'),
(81, 19, 'Screenshot 2025-01-02 112354_20250102043503.webp', '2025-01-02 04:35:03', '2025-01-02 04:35:03'),
(82, 19, 'Screenshot 2025-01-02 112031_20250102043503.webp', '2025-01-02 04:35:03', '2025-01-02 04:35:03'),
(83, 19, 'Screenshot 2025-01-02 111819_20250102043503.webp', '2025-01-02 04:35:03', '2025-01-02 04:35:03'),
(87, 21, 'Screenshot 2025-01-02 125650_20250102061141.webp', '2025-01-02 06:11:41', '2025-01-02 06:11:41'),
(88, 21, 'Screenshot 2025-01-02 125806_20250102061141.webp', '2025-01-02 06:11:41', '2025-01-02 06:11:41'),
(89, 21, 'Screenshot 2025-01-02 130017_20250102061141.webp', '2025-01-02 06:11:41', '2025-01-02 06:11:41'),
(93, 23, 'Screenshot 2025-01-02 142038_20250102072545.webp', '2025-01-02 07:25:45', '2025-01-02 07:25:45'),
(94, 23, 'Screenshot 2025-01-02 141649_20250102072545.webp', '2025-01-02 07:25:45', '2025-01-02 07:25:45'),
(95, 23, 'Screenshot 2025-01-02 141735_20250102072545.webp', '2025-01-02 07:25:45', '2025-01-02 07:25:45'),
(97, 24, 'WhatsApp Image 2024-12-05 at 17.38.05_436d2e37_20250102073957.webp', '2025-01-02 07:39:59', '2025-01-02 07:39:59'),
(98, 24, 'WhatsApp Image 2024-12-05 at 17.38.04_909490b5_20250102073958.webp', '2025-01-02 07:39:59', '2025-01-02 07:39:59'),
(101, 24, 'Nimo-Highland-1068x601_20250102074511.webp', '2025-01-02 07:45:11', '2025-01-02 07:45:11'),
(102, 25, 'IMG-20241213-WA0008_20250102080119.webp', '2025-01-02 08:01:19', '2025-01-02 08:01:19'),
(103, 25, 'IMG-20241213-WA0007_20250102080119.webp', '2025-01-02 08:01:20', '2025-01-02 08:01:20'),
(104, 25, 'IMG-20241213-WA0002_20250102080120.webp', '2025-01-02 08:01:21', '2025-01-02 08:01:21'),
(105, 25, 'IMG-20241213-WA0012_20250102080120.webp', '2025-01-02 08:01:21', '2025-01-02 08:01:21'),
(106, 25, 'IMG-20241213-WA0003_20250102080121.webp', '2025-01-02 08:01:22', '2025-01-02 08:01:22'),
(107, 25, 'IMG-20241213-WA0014_20250102080121.webp', '2025-01-02 08:01:22', '2025-01-02 08:01:22'),
(108, 25, 'IMG-20241213-WA0004_20250102080121.webp', '2025-01-02 08:01:22', '2025-01-02 08:01:22'),
(109, 25, 'IMG-20241213-WA0011_20250102080121.webp', '2025-01-02 08:01:22', '2025-01-02 08:01:22'),
(110, 25, 'IMG-20241213-WA0013_20250102080121.webp', '2025-01-02 08:01:22', '2025-01-02 08:01:22'),
(111, 26, 'Screenshot 2025-01-02 151844_20250102082321.webp', '2025-01-02 08:23:21', '2025-01-02 08:23:21'),
(112, 26, 'Screenshot 2025-01-02 151743_20250102082321.webp', '2025-01-02 08:23:21', '2025-01-02 08:23:21'),
(113, 26, 'Screenshot 2025-01-02 151503_20250102082321.webp', '2025-01-02 08:23:21', '2025-01-02 08:23:21'),
(114, 27, 'IMG-20241213-WA0020_20250102090517.webp', '2025-01-02 09:05:17', '2025-01-02 09:05:17'),
(115, 27, 'IMG-20241213-WA0018_20250102090517.webp', '2025-01-02 09:05:17', '2025-01-02 09:05:17'),
(116, 27, 'IMG-20241213-WA0025_20250102090517.webp', '2025-01-02 09:05:17', '2025-01-02 09:05:17'),
(117, 8, 'Image 4_20250106050053.webp', '2025-01-06 05:00:53', '2025-01-06 05:00:53'),
(118, 8, 'Image 1_20250106050054.webp', '2025-01-06 05:00:54', '2025-01-06 05:00:54'),
(119, 7, 'Screenshot_2_20250106050230.webp', '2025-01-06 05:02:30', '2025-01-06 05:02:30'),
(120, 7, 'Screenshot_1_20250106050235.webp', '2025-01-06 05:02:35', '2025-01-06 05:02:35'),
(121, 7, 'Screenshot_3_20250106050235.webp', '2025-01-06 05:02:35', '2025-01-06 05:02:35'),
(122, 7, 'Screenshot_7_20250106052211.webp', '2025-01-06 05:22:11', '2025-01-06 05:22:11'),
(123, 7, 'Screenshot_6_20250106052211.webp', '2025-01-06 05:22:11', '2025-01-06 05:22:11'),
(124, 7, 'Screenshot_5_20250106052211.webp', '2025-01-06 05:22:11', '2025-01-06 05:22:11'),
(125, 8, 'Image 5_20250106052239.webp', '2025-01-06 05:22:40', '2025-01-06 05:22:40'),
(126, 8, 'Image 9_20250106052240.webp', '2025-01-06 05:22:40', '2025-01-06 05:22:40'),
(127, 8, 'Image 7_20250106052240.webp', '2025-01-06 05:22:40', '2025-01-06 05:22:40'),
(128, 8, 'Image 10_20250106060941.webp', '2025-01-06 06:09:41', '2025-01-06 06:09:41'),
(129, 9, 'Screenshot_15_20250106061751.webp', '2025-01-06 06:17:51', '2025-01-06 06:17:51'),
(130, 9, 'Screenshot_14_20250106061752.webp', '2025-01-06 06:17:54', '2025-01-06 06:17:54'),
(131, 9, 'Screenshot_12_20250106061753.webp', '2025-01-06 06:17:54', '2025-01-06 06:17:54'),
(132, 9, 'Screenshot_13_20250106061753.webp', '2025-01-06 06:17:54', '2025-01-06 06:17:54'),
(133, 9, 'Screenshot_16_20250106061753.webp', '2025-01-06 06:17:54', '2025-01-06 06:17:54'),
(134, 9, 'Screenshot_17_20250106061753.webp', '2025-01-06 06:17:54', '2025-01-06 06:17:54'),
(135, 11, 'Screenshot_21_20250106062317.webp', '2025-01-06 06:23:18', '2025-01-06 06:23:18'),
(136, 11, 'Screenshot_20_20250106062317.webp', '2025-01-06 06:23:18', '2025-01-06 06:23:18'),
(137, 11, 'Screenshot_24_20250106062317.webp', '2025-01-06 06:23:19', '2025-01-06 06:23:19'),
(138, 11, 'Screenshot_23_20250106062318.webp', '2025-01-06 06:23:19', '2025-01-06 06:23:19'),
(139, 11, 'Screenshot_22_20250106062318.webp', '2025-01-06 06:23:19', '2025-01-06 06:23:19'),
(140, 11, 'Screenshot_18_20250106062328.webp', '2025-01-06 06:23:29', '2025-01-06 06:23:29'),
(141, 10, 'Image 15_20250106062603.webp', '2025-01-06 06:26:04', '2025-01-06 06:26:04'),
(142, 10, 'Image 14_20250106062603.webp', '2025-01-06 06:26:04', '2025-01-06 06:26:04'),
(143, 10, 'Image 12_20250106062606.webp', '2025-01-06 06:26:07', '2025-01-06 06:26:07'),
(144, 10, 'Image 13_20250106062606.webp', '2025-01-06 06:26:07', '2025-01-06 06:26:07'),
(145, 10, 'Image 11_20250106062606.webp', '2025-01-06 06:26:07', '2025-01-06 06:26:07'),
(146, 12, 'Screenshot_29_20250106062652.webp', '2025-01-06 06:26:52', '2025-01-06 06:26:52'),
(147, 12, 'Screenshot_27_20250106062654.webp', '2025-01-06 06:26:55', '2025-01-06 06:26:55'),
(148, 12, 'Screenshot_30_20250106062658.webp', '2025-01-06 06:26:58', '2025-01-06 06:26:58'),
(149, 12, 'Screenshot_25_20250106062700.webp', '2025-01-06 06:27:00', '2025-01-06 06:27:00'),
(150, 12, 'Screenshot_28_20250106062700.webp', '2025-01-06 06:27:00', '2025-01-06 06:27:00'),
(151, 12, 'Screenshot_26_20250106062701.webp', '2025-01-06 06:27:01', '2025-01-06 06:27:01'),
(152, 10, 'Image 16_20250106062745.webp', '2025-01-06 06:27:45', '2025-01-06 06:27:45'),
(153, 14, 'Screenshot_36_20250106063617.webp', '2025-01-06 06:36:17', '2025-01-06 06:36:17'),
(154, 14, 'Screenshot_33_20250106063637.webp', '2025-01-06 06:36:37', '2025-01-06 06:36:37'),
(155, 14, 'Screenshot_34_20250106063638.webp', '2025-01-06 06:36:38', '2025-01-06 06:36:38'),
(156, 14, 'Screenshot_35_20250106063639.webp', '2025-01-06 06:36:39', '2025-01-06 06:36:39'),
(157, 14, 'Screenshot_31_20250106063640.webp', '2025-01-06 06:36:40', '2025-01-06 06:36:40'),
(158, 14, 'Screenshot_32_20250106063641.webp', '2025-01-06 06:36:41', '2025-01-06 06:36:41'),
(159, 13, '044026600_1564069467-IMG_20190725_222948_20250106063928.webp', '2025-01-06 06:39:28', '2025-01-06 06:39:28'),
(160, 13, 'Image 17_20250106063932.webp', '2025-01-06 06:39:32', '2025-01-06 06:39:32'),
(161, 13, 'Image 18_20250106063932.webp', '2025-01-06 06:39:32', '2025-01-06 06:39:32'),
(162, 13, 'Malabar_Tea_Plantation_Bandung_South-1024x641_20250106074504.webp', '2025-01-06 07:45:04', '2025-01-06 07:45:04'),
(163, 13, 'sunrise-point-cukul_20250106074504.webp', '2025-01-06 07:45:04', '2025-01-06 07:45:04'),
(164, 13, '044026600_1564069467-IMG_20190725_222948_20250106074504.webp', '2025-01-06 07:45:05', '2025-01-06 07:45:05'),
(165, 13, 'Image 18_20250106074506.webp', '2025-01-06 07:45:06', '2025-01-06 07:45:06'),
(166, 13, 'Image 17_20250106074506.webp', '2025-01-06 07:45:07', '2025-01-06 07:45:07'),
(169, 29, 'photo-1712755557909-53bb6376796b_20250127042423.webp', '2025-01-27 04:24:25', '2025-01-27 04:24:25'),
(170, 29, '6db404d8492b8db8c079578a7a5a94cd_20250127042511.webp', '2025-01-27 04:25:11', '2025-01-27 04:25:11'),
(171, 29, 'Q-Hero ORI Compose Main KV Extended_Rev_NP - portrait_20250127042653.webp', '2025-01-27 04:26:53', '2025-01-27 04:26:53'),
(172, 29, '9f266358bad9fe70b0b05ce7b616e9f5_20250127042720.webp', '2025-01-27 04:27:20', '2025-01-27 04:27:20'),
(173, 32, 'WhatsApp Image 2025-01-31 at 13.36.28_20250131070901.webp', '2025-01-31 07:09:01', '2025-01-31 07:09:01'),
(174, 32, 'WhatsApp Image 2025-01-31 at 13.36.27 (2)_20250131070901.webp', '2025-01-31 07:09:02', '2025-01-31 07:09:02'),
(175, 32, 'WhatsApp Image 2025-01-31 at 13.36.27 (1)_20250131070902.webp', '2025-01-31 07:09:02', '2025-01-31 07:09:02'),
(176, 32, 'WhatsApp Image 2025-01-31 at 13.36.27_20250131070902.webp', '2025-01-31 07:09:02', '2025-01-31 07:09:02'),
(177, 32, 'WhatsApp Image 2025-01-31 at 13.36.28_20250131070906.webp', '2025-01-31 07:09:07', '2025-01-31 07:09:07'),
(178, 31, 'WhatsApp Image 2025-01-31 at 13.36.27_20250131072338.webp', '2025-01-31 07:23:39', '2025-01-31 07:23:39'),
(179, 31, 'WhatsApp Image 2025-01-31 at 13.36.27 (2)_20250131072338.webp', '2025-01-31 07:23:39', '2025-01-31 07:23:39'),
(180, 31, 'WhatsApp Image 2025-01-31 at 13.36.28_20250131072339.webp', '2025-01-31 07:23:39', '2025-01-31 07:23:39'),
(181, 31, 'WhatsApp Image 2025-01-31 at 13.36.27 (1)_20250131072339.webp', '2025-01-31 07:23:39', '2025-01-31 07:23:39'),
(200, 33, '1000694009_20250321020548.webp', '2025-03-21 02:05:48', '2025-03-21 02:05:48'),
(201, 33, '1000694012_20250321020615.webp', '2025-03-21 02:06:15', '2025-03-21 02:06:15'),
(202, 33, '1000694010_20250321020629.webp', '2025-03-21 02:06:29', '2025-03-21 02:06:29'),
(203, 33, '1000694011_20250321020629.webp', '2025-03-21 02:06:29', '2025-03-21 02:06:29'),
(206, 22, '1000711033_20250326233428.webp', '2025-03-26 23:34:28', '2025-03-26 23:34:28'),
(207, 22, '1000711032_20250326233428.webp', '2025-03-26 23:34:28', '2025-03-26 23:34:28'),
(208, 22, '1000711031_20250326233428.webp', '2025-03-26 23:34:28', '2025-03-26 23:34:28'),
(209, 20, 'Snapinsta.app_346067878_5366549390114272_2233360717502658508_n_1080_20250401094938.webp', '2025-04-01 08:49:38', '2025-04-01 08:49:38'),
(210, 20, 'IMG_20241202_082003_300_20250401094942.webp', '2025-04-01 08:49:43', '2025-04-01 08:49:43'),
(211, 20, 's_image_chooser_20241213_112322_3988551798870754372_20250401094946.webp', '2025-04-01 08:49:47', '2025-04-01 08:49:47'),
(212, 20, 'IMG20250215080907_20250401095035.webp', '2025-04-01 08:50:37', '2025-04-01 08:50:37'),
(213, 20, 'IMG-20250401-WA0007_20250401095040.webp', '2025-04-01 08:50:40', '2025-04-01 08:50:40'),
(214, 20, '2_20250220_095353_0001_20250401095054.webp', '2025-04-01 08:50:54', '2025-04-01 08:50:54'),
(215, 20, 'IMG20250124094627_20250401095053.webp', '2025-04-01 08:50:55', '2025-04-01 08:50:55'),
(216, 20, 'IMG20241219142842_20250401095056.webp', '2025-04-01 08:50:58', '2025-04-01 08:50:58'),
(217, 20, 'IMG20241211140720_20250401095101.webp', '2025-04-01 08:51:03', '2025-04-01 08:51:03'),
(218, 20, 'IMG20250219105148_20250401095105.webp', '2025-04-01 08:51:08', '2025-04-01 08:51:08'),
(219, 20, 'IMG20241219143028_20250401095106.webp', '2025-04-01 08:51:09', '2025-04-01 08:51:09'),
(220, 41, 'GOJES-HAND-SOAP-3-600x600_20250414075140.webp', '2025-04-14 06:51:41', '2025-04-14 06:51:41'),
(221, 41, 'GOJES-PEWANGI-PAKAIAN-600x599_20250414075141.webp', '2025-04-14 06:51:42', '2025-04-14 06:51:42'),
(222, 41, 'GOJES-PEMBERSIH-LANTAI-SEREH-1-600x599_20250414075141.webp', '2025-04-14 06:51:42', '2025-04-14 06:51:42'),
(223, 41, 'GOJES-PEWANGI-PAKAIAN-1-600x600_20250414075141.webp', '2025-04-14 06:51:42', '2025-04-14 06:51:42'),
(224, 41, 'GOJES-KARBOL-PINE-1-600x600_20250414075141.webp', '2025-04-14 06:51:42', '2025-04-14 06:51:42'),
(225, 41, 'GOJES-CUPIR-4-600x600_20250414075141.webp', '2025-04-14 06:51:42', '2025-04-14 06:51:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_tags`
--

CREATE TABLE `product_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tag` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `product_tags`
--

INSERT INTO `product_tags` (`id`, `tag`, `created_at`, `updated_at`) VALUES
(1, 'Vila', '2024-12-31 03:14:54', '2024-12-31 03:14:54'),
(2, 'Jajanan', '2024-12-31 04:02:04', '2024-12-31 04:02:04'),
(3, 'Wisata', '2024-12-31 07:27:47', '2024-12-31 07:27:47'),
(4, 'Camping', '2025-01-02 07:23:57', '2025-01-02 07:23:57'),
(5, 'Test', '2025-01-13 04:30:17', '2025-01-13 04:30:17'),
(6, 'Kendaraan', '2025-01-27 04:18:09', '2025-01-27 04:18:09'),
(8, 'Waroeng makan', '2025-01-29 06:25:12', '2025-01-29 06:25:12'),
(9, 'Warung makan', '2025-01-29 06:25:12', '2025-01-29 06:25:12'),
(10, 'Steak', '2025-01-31 07:04:37', '2025-01-31 07:04:37'),
(11, 'Joyasteak', '2025-01-31 07:04:37', '2025-01-31 07:04:37'),
(12, 'Bbq', '2025-01-31 07:04:37', '2025-01-31 07:04:37'),
(13, 'Profile', '2025-02-13 02:55:43', '2025-02-13 02:55:43'),
(14, 'JasaWebsite', '2025-03-21 02:09:48', '2025-03-21 02:09:48'),
(15, 'Jasa pembuatan website', '2025-03-21 02:09:48', '2025-03-21 02:09:48'),
(16, 'Bandung', '2025-03-21 02:09:48', '2025-03-21 02:09:48'),
(17, 'Sembako', '2025-03-26 23:19:17', '2025-03-26 23:19:17'),
(18, 'Makanan', '2025-03-26 23:19:17', '2025-03-26 23:19:17'),
(19, 'Tgm', '2025-03-26 23:19:17', '2025-03-26 23:19:17'),
(20, 'Tgm bandung', '2025-03-26 23:19:17', '2025-03-26 23:19:17'),
(21, 'Grosir tgm', '2025-03-26 23:19:17', '2025-03-26 23:19:17'),
(22, 'Grosir beras', '2025-03-26 23:19:17', '2025-03-26 23:19:17'),
(23, 'Beras murah', '2025-03-26 23:19:17', '2025-03-26 23:19:17'),
(24, 'Karbol', '2025-04-14 06:50:59', '2025-04-14 06:50:59'),
(25, 'Sampo mobil & motor', '2025-04-14 06:50:59', '2025-04-14 06:50:59'),
(26, 'Sabun cuci tangan', '2025-04-14 06:50:59', '2025-04-14 06:50:59'),
(27, 'Sabun cuci piring', '2025-04-14 06:50:59', '2025-04-14 06:50:59'),
(28, 'Pewangi pakaian', '2025-04-14 06:50:59', '2025-04-14 06:50:59'),
(29, 'Pembersih lantai', '2025-04-14 06:50:59', '2025-04-14 06:50:59'),
(30, 'Deterjen', '2025-04-14 06:50:59', '2025-04-14 06:50:59'),
(31, 'Pelicin pakaian', '2025-04-14 06:50:59', '2025-04-14 06:50:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `templates`
--

CREATE TABLE `templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `bg_type` varchar(255) NOT NULL,
  `bg_image` varchar(255) DEFAULT NULL,
  `bg_main_color` varchar(255) DEFAULT NULL,
  `bg_second_color` varchar(255) DEFAULT NULL,
  `accent_color` varchar(255) NOT NULL DEFAULT '#A72018',
  `head_type` varchar(255) NOT NULL,
  `gallery_type` varchar(255) NOT NULL,
  `desc_type` varchar(255) NOT NULL DEFAULT 'default',
  `desc_main_color` varchar(255) NOT NULL,
  `desc_text_color` varchar(255) NOT NULL,
  `product_type` varchar(255) NOT NULL,
  `product_main_color` varchar(255) NOT NULL,
  `product_second_color` varchar(255) NOT NULL,
  `product_text_color` varchar(255) NOT NULL,
  `contact_main_color` varchar(255) NOT NULL,
  `contact_second_color` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `templates`
--

INSERT INTO `templates` (`id`, `name`, `image`, `bg_type`, `bg_image`, `bg_main_color`, `bg_second_color`, `accent_color`, `head_type`, `gallery_type`, `desc_type`, `desc_main_color`, `desc_text_color`, `product_type`, `product_main_color`, `product_second_color`, `product_text_color`, `contact_main_color`, `contact_second_color`, `created_at`, `updated_at`) VALUES
(1, 'one', 'one.webp', 'normal', NULL, '#f5f5f5', NULL, '#1679ab', 'three', 'square', 'default', '#1679ab', '#ffffff', 'grid', '#1679ab', '#074173', '#ffffff', '#074173', '#1679ab', '2025-02-24 22:08:54', '2025-02-25 02:10:17'),
(2, 'two', 'two.webp', 'gradient', NULL, '#eabe95', '#d99d81', '#77b254', 'four', 'potrait', 'default', '#5b913b', '#ffffff', 'list', '#77b254', '#5b913b', '#ffffff', '#5b913b', '#77b254', '2025-02-24 22:10:36', '2025-02-25 02:11:01'),
(3, 'three', 'three.webp', 'normal', NULL, '#5f111d', NULL, '#408263', 'four', 'square', 'default', '#a02334', '#ffffff', 'grid', '#a02334', '#408263', '#ffffff', '#a02334', '#408263', '2025-02-25 00:15:53', '2025-03-25 07:46:33'),
(4, 'four', 'four.webp', 'image', '1740469117.webp', '#f5f5f5', NULL, '#00b0ad', 'three', 'potrait', 'default', '#00596b', '#ffffff', 'grid', '#00596b', '#00b0ad', '#ffffff', '#00596b', '#00b0ad', '2025-02-25 00:37:37', '2025-02-25 02:12:16'),
(5, 'five', 'five.webp', 'gradient', NULL, '#4635b1', '#b771e5', '#4635b1', 'four', 'square', 'default', '#ffffff', '#000000', 'grid', '#4635b1', '#b771e5', '#ffffff', '#4635b1', '#4635b1', '2025-02-25 00:50:40', '2025-02-25 02:13:06'),
(6, 'six', 'six.webp', 'normal', NULL, '#f8ddf5', '#f3f0ff', '#d789cf', 'four', 'potrait', 'default', '#d789cf', '#ffffff', 'list', '#d789cf', '#9f5fec', '#ffffff', '#9f5fec', '#d789cf', '2025-02-24 01:34:36', '2025-02-25 01:59:21'),
(13, 'seven', 'seven.webp', 'normal', NULL, '#ffd666', NULL, '#e73879', 'three', 'potrait', 'default', '#7e1891', '#ffffff', 'list', '#7e1891', '#e73879', '#ffffff', '#7e1891', '#e73879', '2025-02-24 21:50:17', '2025-02-25 02:02:50'),
(14, 'eight', 'eight.webp', 'gradient', NULL, '#eaeaea', '#e3d2c3', '#66d2ce', 'four', 'square', 'default', '#2daa9e', '#ffffff', 'list', '#66d2ce', '#2daa9e', '#ffffff', '#2daa9e', '#66d2ce', '2025-02-24 21:53:46', '2025-02-26 00:54:10'),
(15, 'nine', 'nine.webp', 'gradient', NULL, '#fef9e1', '#e5d0ac', '#ff9d23', 'three', 'square', 'default', '#c14600', '#ffffff', 'grid', '#ff9d23', '#c14600', '#ffffff', '#c14600', '#ff9d23', '2025-02-24 21:59:43', '2025-02-25 02:09:14'),
(16, 'ten', 'ten.webp', 'normal', NULL, '#fff2f2', NULL, '#7886c7', 'four', 'potrait', 'default', '#2d336b', '#ffffff', 'grid', '#7886c7', '#2d336b', '#ffffff', '#2d336b', '#7886c7', '2025-02-24 22:02:48', '2025-02-25 02:09:43'),
(17, 'eleven', 'eleven.png', 'gradient', NULL, '#cdeef5', '#B1F0F7', '#F29D35', 'one', 'potrait', 'default', '#81BFDA', '#ffffff', 'list', '#F29D35', '#81BFDA', '#ffffff', '#81BFDA', '#F29D35', '2025-02-13 05:11:12', '2025-02-13 05:11:12'),
(18, 'Twelve', 'twelve.png', 'normal', NULL, '#f5f5f5', NULL, '#fa82d8', 'two', 'square', 'default', '#8b5cf6', '#ffffff', 'list', '#fa82d8', '#FCC737', '#ffffff', '#8b5cf6', '#fa82d8', NULL, NULL),
(19, 'thirteen', 'thirteen.png', 'gradient', NULL, '#ffe3c0', '#ffedd5', '#cda476', 'three', 'potrait', 'default', '#cda476', 'white', 'list', '#907658', '#cda476', '#ffffff', '#907658', '#cda476', '2025-02-13 07:29:03', '2025-02-13 07:29:03'),
(20, 'fourteen', 'fourteen.png', 'normal', NULL, '#EEEEEE', NULL, '#8E1616', 'three', 'square', 'default', '#1D1616', '#FFFFFF', 'grid', '#1D1616', '#8E1616', 'white', '#1D1616', '#8E1616', '2025-02-13 07:40:55', '2025-02-13 07:40:55'),
(21, 'fifteen', 'fifteen.png', 'normal', NULL, '#eeeeee', NULL, '#f05a28', 'four', 'square', 'default', '#1D1616', '#ffffff', 'grid', '#1D1616', '#f05a28', '#ffffff', '#1D1616', '#f05a28', '2025-02-13 07:55:56', '2025-02-13 07:55:56'),
(28, 'Ramen Lezat', NULL, 'normal', NULL, '#f7efe5', NULL, '#b12719', 'ramen', 'square', 'ramen', '#b12719', '#ffffff', 'ramen', '#ffffff', '#3ea648', '#1f1915', '#3ea648', '#b12719', '2026-07-22 03:16:22', '2026-07-22 01:22:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `expired` date DEFAULT NULL,
  `premium_type` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `expired`, `premium_type`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'jasawebsite.biz@gmail.com', NULL, '$2y$12$qopl6LsQU80XMYl2f.pX0eGe/BlkXvTMUenU4VAIyWB1Slx0M4yuC', 'admin', NULL, '', 'ZnTd84Jaq4BBYwNJDxt8p4KqQfZbKG3AhkGJNaLdVVmruhiUXH1YdcgidbpR', '2024-11-14 01:37:44', '2025-01-29 02:00:21'),
(3, 'Yugo', 'yugo@byoo.link', NULL, '$2y$12$ypXb04TmgD6KqGAvEnlyFuK/O3Uq55gN8oEJHC.FL6KiV.JwZiKOm', 'premium', NULL, 'lifetime', NULL, '2025-01-15 06:38:54', '2025-02-13 03:34:52'),
(5, 'Wildan', 'wildansuhendar87@gmail.com', NULL, '$2y$12$XtvKxrSaLzO5FwibftDnz.Ef/AhJwYJsvHnN9E7Og/daL023qcQYq', 'premium', NULL, 'lifetime', NULL, '2025-03-05 04:57:13', '2025-04-09 08:29:46'),
(6, 'Kambing Bandung', 'imanedos@gmail.com', NULL, '$2y$12$9a2W1FD0UFQYeaGo2oyX7O.0WGCahv3ZrQPCez1kotQLaCWy4hQMS', 'user', NULL, NULL, NULL, '2025-03-11 08:15:27', '2025-03-11 08:15:27'),
(7, 'Arya', 'arya@byoo.link', NULL, '$2y$12$fevytQoCd0lj98B04ATzUuJcOExufw1P5/F3sQAM4mym8W66LH.ra', 'user', NULL, 'lifetime', NULL, '2025-04-09 01:10:35', '2025-04-09 01:10:35'),
(9, 'adut', 'pgspin55@gmail.com', NULL, '$2y$12$oiosx0YdHd0vXeqUgR8PHuL67t3ZfLO1wlMhrz0d7RgwOFeidF5wy', 'user', NULL, NULL, NULL, '2025-08-31 15:47:56', '2025-08-31 15:47:56'),
(10, 'adminxp', 'adminxp@gmail.com', NULL, '$2y$12$WV3Ibwx5VBLXdpAXAOCwkuYqJYUIzxHeyeU384A1As6Kaihbg5/3G', 'user', NULL, NULL, NULL, '2025-09-09 10:43:12', '2025-09-09 10:43:12'),
(11, 'adminxx', 'adminxx@gmail.com', NULL, '$2y$12$tM1OKkRq11LwKqK33gv9p.VPpRuiWCOOdBfxfFC509N6NwX6s06eu', 'user', NULL, NULL, NULL, '2025-10-07 05:23:23', '2025-10-07 05:23:23'),
(13, 'Kopi Om Adul', 'omadul@rekapaja.webzz.id', NULL, '$2y$12$2YN5.ZKCePryww/xcnPS.eFWHy7BU73/j.ZdNI9Foq6K76u7ENU9q', 'premium', NULL, 'lifetime', 'veCbGo1QzdNkZKKsVSppgD7IzB03XKkl9bErMx5P54pQFjeVTcIVlK0tIs7x', '2026-06-17 06:56:48', '2026-06-22 06:35:50');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `accesses`
--
ALTER TABLE `accesses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accesses_user_id_foreign` (`user_id`),
  ADD KEY `accesses_product_id_foreign` (`product_id`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `highlights`
--
ALTER TABLE `highlights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `highlights_product_id_foreign` (`product_id`);

--
-- Indeks untuk tabel `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoices_invoice_code_unique` (`invoice_code`),
  ADD KEY `invoices_business_id_foreign` (`business_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `no_handphones`
--
ALTER TABLE `no_handphones`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `pivot_product_categories`
--
ALTER TABLE `pivot_product_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pivot_product_categories_product_id_foreign` (`product_id`),
  ADD KEY `pivot_product_categories_category_id_foreign` (`category_id`);

--
-- Indeks untuk tabel `pivot_product_tags`
--
ALTER TABLE `pivot_product_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pivot_product_tags_product_id_foreign` (`product_id`),
  ADD KEY `pivot_product_tags_tag_id_foreign` (`tag_id`);

--
-- Indeks untuk tabel `premium_packages`
--
ALTER TABLE `premium_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `template_id` (`template_id`);

--
-- Indeks untuk tabel `product_galleries`
--
ALTER TABLE `product_galleries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_galleries_product_id_foreign` (`product_id`);

--
-- Indeks untuk tabel `product_tags`
--
ALTER TABLE `product_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `templates_name_unique` (`name`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `accesses`
--
ALTER TABLE `accesses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `highlights`
--
ALTER TABLE `highlights`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;

--
-- AUTO_INCREMENT untuk tabel `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `no_handphones`
--
ALTER TABLE `no_handphones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pivot_product_categories`
--
ALTER TABLE `pivot_product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `pivot_product_tags`
--
ALTER TABLE `pivot_product_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=738;

--
-- AUTO_INCREMENT untuk tabel `premium_packages`
--
ALTER TABLE `premium_packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `product_galleries`
--
ALTER TABLE `product_galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=226;

--
-- AUTO_INCREMENT untuk tabel `product_tags`
--
ALTER TABLE `product_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `templates`
--
ALTER TABLE `templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `accesses`
--
ALTER TABLE `accesses`
  ADD CONSTRAINT `accesses_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `accesses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `highlights`
--
ALTER TABLE `highlights`
  ADD CONSTRAINT `highlights_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pivot_product_categories`
--
ALTER TABLE `pivot_product_categories`
  ADD CONSTRAINT `pivot_product_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pivot_product_categories_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pivot_product_tags`
--
ALTER TABLE `pivot_product_tags`
  ADD CONSTRAINT `pivot_product_tags_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pivot_product_tags_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `product_tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `templates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `product_galleries`
--
ALTER TABLE `product_galleries`
  ADD CONSTRAINT `product_galleries_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
