-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 21 Des 2025 pada 15.29
-- Versi server: 8.4.3
-- Versi PHP: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `web_laravel`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `berita`
--

CREATE TABLE `berita` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe` enum('berita','rekomendasi') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'berita',
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `berita`
--

INSERT INTO `berita` (`id`, `judul`, `deskripsi`, `tipe`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 'Kampung Warna-Warni', 'Kampung wisata dengan rumah-rumah dicat warna cerah untuk memperindah lingkungan dan menarik wisatawan.', 'rekomendasi', 'images/berita/de514a00-77e0-4888-aac2-d96e57022a71.jpg', '2025-12-17 20:37:43', '2025-12-17 20:37:43'),
(2, 'Kampung Tridi', 'Kampung Tridi (3D) di Malang adalah destinasi wisata tematik yang terkenal dengan lukisan tiga dimensi (3D) dan mural warna-warni.', 'rekomendasi', 'images/berita/7c109f20-be79-48d0-92d4-056fb30e16f6.jpg', '2025-12-17 20:38:30', '2025-12-17 20:42:58'),
(3, 'Kampung Biru Arema', 'Kampung bernuansa biru yang merepresentasikan identitas Arema dan semangat kebersamaan warga Malang.', 'rekomendasi', 'images/berita/d9d2ca6d-2bdf-425c-82c1-6d522749aa6f.jpg', '2025-12-17 20:40:08', '2025-12-17 20:40:08'),
(4, 'Kampung 1000 Topeng', 'Kampung 100 Topeng (Kampung Topeng Malangan) di Tlogowaru, Malang, adalah kampung tematik yang diubah dari kawasan penampungan gepeng menjadi destinasi wisata edukasi berbasis Topeng Malangan, dengan ikon dua topeng raksasa dan ratusan topeng yang dipajang, menawarkan aktivitas membuat topeng, tari topeng, serta spot foto unik, bertujuan memberdayakan ekonomi warga lewat kerajinan dan seni tradisional khas Malang', 'rekomendasi', 'images/berita/8a77927a-7069-4e24-8d29-88e13a260787.jpg', '2025-12-17 20:41:07', '2025-12-17 21:00:38'),
(5, 'topeng', 'topeng', 'berita', 'images/berita/d3469039-7300-4a94-a075-c3b27ef4c082.jpg', '2025-12-18 04:55:01', '2025-12-18 04:55:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visit_code` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `layanan` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visit_date` date NOT NULL,
  `visit_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guests` int UNSIGNED NOT NULL DEFAULT '1',
  `ticket_count` int UNSIGNED NOT NULL DEFAULT '1',
  `price` bigint UNSIGNED NOT NULL DEFAULT '0',
  `admin_fee` bigint UNSIGNED NOT NULL DEFAULT '0',
  `status` enum('pending','process','success','cancel','cancelled') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `total_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bookings`
--

INSERT INTO `bookings` (`id`, `order_id`, `visit_code`, `contact_name`, `contact_email`, `contact_phone`, `package_name`, `layanan`, `visit_date`, `visit_time`, `guests`, `ticket_count`, `price`, `admin_fee`, `status`, `total_amount`, `payment_method`, `payment_status`, `notes`, `created_at`, `updated_at`) VALUES
(68, 'INVKJ6NU0MNN4', NULL, 'Rio Pratama Putra', 'riopratamaputra43@gmail.com', '082118644605', '1000 Topeng', '1000 Topeng', '2025-12-18', '2025-12-19', 1, 1, 10000, 500, 'pending', 10500.00, 'QRIS', 'paid', NULL, '2025-12-17 20:56:59', '2025-12-17 21:01:54'),
(69, 'INVNTDOMRIRVW', 'KPTEMATIKJSRBZ6LR', 'Rio Pratama Putra', 'riopratamaputra43@gmail.com', '082118644605', '1000 Topeng', '1000 Topeng', '2025-12-18', '2025-12-18', 1, 1, 10000, 500, 'success', 10500.00, 'QRIS', 'paid', NULL, '2025-12-18 04:51:06', '2025-12-18 04:51:54'),
(70, 'INVQM62BJSF6E', 'KPTEMATIKKFAP3MKL', 'Rio Pratama Putra', 'sss@gmail.com', '0812312412322', '1000 Topeng', '1000 Topeng', '2025-12-21', '2026-01-03', 1, 1, 10000, 500, 'success', 10500.00, 'DANA', 'paid', NULL, '2025-12-21 15:08:43', '2025-12-21 15:08:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `galeri`
--

CREATE TABLE `galeri` (
  `id_galeri` bigint UNSIGNED NOT NULL,
  `id_kampung` bigint UNSIGNED NOT NULL,
  `jenis` enum('foto','video') COLLATE utf8mb4_unicode_ci NOT NULL,
  `media_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipe` enum('event','galeri') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'event',
  `kategori` enum('kampung-1000-topeng','glintung-go-green','warna-warni-jodipan','biru-arema') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'kampung-1000-topeng',
  `judul` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `tanggal_upload` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `galeri`
--

INSERT INTO `galeri` (`id_galeri`, `id_kampung`, `jenis`, `media_path`, `tipe`, `kategori`, `judul`, `deskripsi`, `tanggal_upload`, `created_at`, `updated_at`) VALUES
(1, 0, 'foto', 'images/galeri/1765986963_6942d2930b86c.png', 'galeri', 'warna-warni-jodipan', NULL, NULL, '2025-12-17', '2025-12-17 15:56:03', '2025-12-17 15:56:03'),
(2, 0, 'foto', 'images/galeri/1765986963_6942d2930b86c.png', 'galeri', 'kampung-1000-topeng', NULL, NULL, '2025-12-17', '2025-12-17 15:56:03', '2025-12-17 15:56:03'),
(3, 0, 'foto', 'images/galeri/1765986963_6942d2930b86c.png', 'galeri', 'kampung-1000-topeng', NULL, NULL, '2025-12-17', '2025-12-17 15:56:03', '2025-12-17 15:56:03'),
(4, 0, 'foto', 'images/galeri/1765986963_6942d2930b86c.png', 'galeri', 'kampung-1000-topeng', NULL, NULL, '2025-12-17', '2025-12-17 15:56:03', '2025-12-17 15:56:03'),
(5, 0, 'foto', 'images/galeri/1765986963_6942d2930b86c.png', 'galeri', 'kampung-1000-topeng', NULL, NULL, '2025-12-17', '2025-12-17 15:56:03', '2025-12-17 15:56:03'),
(6, 0, 'foto', 'images/galeri/1765986963_6942d2930b86c.png', 'galeri', 'kampung-1000-topeng', NULL, NULL, '2025-12-17', '2025-12-17 15:56:03', '2025-12-17 15:56:03'),
(7, 0, 'foto', 'images/galeri/1765986963_6942d2930b86c.png', 'galeri', 'kampung-1000-topeng', NULL, NULL, '2025-12-17', '2025-12-17 15:56:03', '2025-12-17 15:56:03'),
(8, 0, 'foto', 'images/galeri/1765986963_6942d2930b86c.png', 'galeri', 'kampung-1000-topeng', NULL, NULL, '2025-12-17', '2025-12-17 15:56:03', '2025-12-17 15:56:03'),
(9, 0, 'foto', 'images/galeri/1765986963_6942d2930b86c.png', 'galeri', 'kampung-1000-topeng', NULL, NULL, '2025-12-17', '2025-12-17 15:56:03', '2025-12-17 15:56:03'),
(10, 0, 'foto', 'images/galeri/1765986963_6942d2930b86c.png', 'event', 'kampung-1000-topeng', NULL, NULL, '2025-12-17', '2025-12-17 15:56:03', '2025-12-17 16:33:21'),
(11, 0, 'foto', 'images/galeri/1765986963_6942d2930b86c.png', 'galeri', 'kampung-1000-topeng', NULL, NULL, '2025-12-17', '2025-12-17 15:56:03', '2025-12-17 15:56:03'),
(12, 0, 'foto', 'images/galeri/1765986963_6942d2930b86c.png', 'galeri', 'kampung-1000-topeng', NULL, NULL, '2025-12-17', '2025-12-17 15:56:03', '2025-12-17 15:56:03'),
(13, 0, 'foto', 'images/galeri/1765986963_6942d2930b86c.png', 'galeri', 'kampung-1000-topeng', NULL, NULL, '2025-12-17', '2025-12-17 15:56:03', '2025-12-17 15:56:03'),
(23, 0, 'foto', 'images/galeri/1765992851_6942e993d9611.png', 'event', 'kampung-1000-topeng', NULL, NULL, '2025-12-18', '2025-12-17 17:34:11', '2025-12-17 17:34:11'),
(24, 0, 'foto', 'images/galeri/1765992860_6942e99c5dff6.png', 'event', 'glintung-go-green', NULL, NULL, '2025-12-18', '2025-12-17 17:34:20', '2025-12-17 17:34:20'),
(25, 0, 'foto', 'images/galeri/1765992867_6942e9a3dec9d.jpg', 'event', 'warna-warni-jodipan', NULL, NULL, '2025-12-18', '2025-12-17 17:34:27', '2025-12-17 17:34:27'),
(26, 0, 'foto', 'images/galeri/1765992873_6942e9a997ccc.png', 'event', 'biru-arema', NULL, NULL, '2025-12-18', '2025-12-17 17:34:33', '2025-12-17 17:34:33'),
(27, 0, 'foto', 'images/galeri/1765992880_6942e9b01a2f4.webp', 'galeri', 'glintung-go-green', NULL, NULL, '2025-12-18', '2025-12-17 17:34:40', '2025-12-17 17:34:40'),
(28, 0, 'foto', 'images/galeri/1765992887_6942e9b73c231.webp', 'galeri', 'warna-warni-jodipan', NULL, NULL, '2025-12-18', '2025-12-17 17:34:47', '2025-12-17 17:34:47'),
(29, 0, 'foto', 'images/galeri/1765992893_6942e9bd52c09.jpg', 'galeri', 'biru-arema', NULL, NULL, '2025-12-18', '2025-12-17 17:34:53', '2025-12-17 17:34:53'),
(30, 0, 'video', 'images/galeri/1766033818_6943899ae4759.mp4', 'galeri', 'kampung-1000-topeng', NULL, NULL, '2025-12-18', '2025-12-18 04:56:58', '2025-12-18 04:56:58'),
(31, 0, 'foto', 'images/galeri/1766033836_694389ac03823.jpg', 'event', 'kampung-1000-topeng', 'Kampung apakah ini', 'Kampung apakah ini', '2025-12-18', '2025-12-18 04:57:16', '2025-12-18 04:57:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gateway`
--

CREATE TABLE `gateway` (
  `id` bigint UNSIGNED NOT NULL,
  `merchant_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `server_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `gateway`
--

INSERT INTO `gateway` (`id`, `merchant_id`, `client_key`, `server_key`, `created_at`, `updated_at`) VALUES
(1, 'G822677235', 'Mid-client-uAb6aKjvGTpXA_L4', 'Mid-server-fbR16F2LUjgdQh27TypATm-Z', '2025-12-17 18:09:38', '2025-12-17 18:09:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `methodpayment`
--

CREATE TABLE `methodpayment` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('qris','e-wallet','transfer-bank','virtual-account','convenience-store') COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `methodpayment`
--

INSERT INTO `methodpayment` (`id`, `name`, `code`, `description`, `type`, `image_path`, `created_at`, `updated_at`) VALUES
(1, 'QRIS1', 'QRISPAYMENT', 'Dicek Otomatis', 'qris', 'images/payment/qris.webp', '2025-12-17 10:06:09', '2025-12-18 04:55:55'),
(2, 'LinkAja', 'LinkAja', 'Dicek Otomatis', 'e-wallet', 'images/payment/linkaja-payment.webp', '2025-12-17 10:06:09', '2025-12-17 10:06:09'),
(3, 'DANA', 'DANA', 'Dicek Otomatis', 'e-wallet', 'images/payment/dana.webp', '2025-12-17 10:06:09', '2025-12-17 10:06:09'),
(4, 'OVO', 'OVO', 'Dicek Otomatis', 'e-wallet', 'images/payment/ovo.webp', '2025-12-17 10:06:09', '2025-12-17 10:06:09'),
(5, 'Gopay', 'Gopay', 'Dicek Otomatis', 'e-wallet', 'images/payment/Gopay.webp', '2025-12-17 10:06:09', '2025-12-17 10:06:09'),
(6, 'BSI Transfer', 'BSI Transfer', 'Dicek Otomatis', 'transfer-bank', 'images/payment/bsi.webp', '2025-12-17 10:06:09', '2025-12-17 10:06:09'),
(7, 'CIMB Niaga Transfer', 'CIMB Niaga Transfer', 'Dicek Otomatis', 'transfer-bank', 'images/payment/cimb.webp', '2025-12-17 10:06:09', '2025-12-17 10:06:09'),
(8, 'BNI Transfer', 'BNI Transfer', 'Dicek Otomatis', 'transfer-bank', 'images/payment/bni.webp', '2025-12-17 10:06:09', '2025-12-17 10:06:09'),
(9, 'Mandiri Transfer', 'Mandiri Transfer', 'Dicek Otomatis', 'transfer-bank', 'images/payment/mandiri.webp', '2025-12-17 10:06:09', '2025-12-17 10:06:09'),
(10, 'Permata Transfer', 'Permata Transfer', 'Dicek Otomatis', 'transfer-bank', 'images/payment/permata.webp', '2025-12-17 10:06:09', '2025-12-17 10:06:09'),
(11, 'BCA Transfer', 'BCA Transfer', 'Dicek Otomatis', 'transfer-bank', 'images/payment/bca.webp', '2025-12-17 10:06:09', '2025-12-17 10:06:09'),
(12, 'Mandiri VA', 'Mandiri VA', 'Dicek Otomatis', 'virtual-account', 'images/payment/mandiri.webp', '2025-12-17 10:06:09', '2025-12-17 10:06:09'),
(13, 'Permata VA', 'Permata VA', 'Dicek Otomatis', 'virtual-account', 'images/payment/permata.webp', '2025-12-17 10:06:09', '2025-12-17 10:06:09'),
(14, 'CIMB VA', 'CIMB VA', 'Dicek Otomatis', 'virtual-account', 'images/payment/cimb.webp', '2025-12-17 10:06:09', '2025-12-17 10:06:09'),
(15, 'BNI VA', 'BNI VA', 'Dicek Otomatis', 'virtual-account', 'images/payment/bni.webp', '2025-12-17 10:06:09', '2025-12-17 10:06:09'),
(16, 'BSI VA', 'BSI VA', 'Dicek Otomatis', 'virtual-account', 'images/payment/bsi.webp', '2025-12-17 10:06:09', '2025-12-17 10:06:09'),
(17, 'BCA VA', 'BCA VA', 'Dicek Otomatis', 'virtual-account', 'images/payment/bca.webp', '2025-12-17 10:06:09', '2025-12-17 10:06:09'),
(18, 'Alfamart', 'Alfamart', 'Dicek Otomatis', 'convenience-store', 'images/payment/alfamart.webp', '2025-12-17 10:06:09', '2025-12-17 10:06:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(8, '2025_03_01_000000_create_users_table', 1),
(9, '2025_03_01_000100_create_bookings_table', 1),
(10, '2025_03_01_000300_create_sessions_table', 1),
(11, '2025_12_11_000400_create_galeri_table', 1),
(12, '2025_12_14_000500_create_payments_table', 1),
(13, '2025_12_14_010000_create_berita_table', 1),
(14, '2025_12_15_000600_update_tipe_enum_on_berita_table', 1),
(15, '2025_12_16_010700_update_payments_with_booking_relation', 2),
(16, '2025_12_16_010800_update_bookings_add_contact_fields', 2),
(17, '2025_12_16_020900_ensure_bookings_table_exists', 2),
(18, '2025_12_16_041500_update_booking_status_enum', 2),
(19, '2025_12_17_000000_add_visit_code_to_bookings_table', 2),
(20, '2025_12_17_020000_rename_user_id_to_order_id_on_bookings_table', 2),
(21, '2025_12_17_030000_create_methodpayments_table', 2),
(22, '2025_12_17_050000_drop_is_active_from_methodpayment_table', 2),
(23, '2025_12_21_000000_update_bookings_order_id_and_drop_code', 3),
(24, '2025_12_22_000000_add_layanan_to_bookings_table', 4),
(25, '2025_12_18_000000_remove_balance_from_users_table', 5),
(26, '2025_12_19_000000_drop_email_verified_and_remember_from_users', 6),
(27, '2025_12_20_000000_update_galeri_add_fields', 7),
(28, '2025_12_21_000000_make_judul_deskripsi_nullable_on_galeri', 8),
(29, '2025_12_22_000000_add_kategori_to_galeri_table', 9),
(30, '2025_12_23_000000_change_kategori_to_enum_on_galeri', 10),
(31, '2025_12_19_000001_add_credentials_to_methodpayment_table', 11),
(32, '2025_12_19_000002_create_gateway_table', 12),
(33, '2025_12_19_000003_drop_methodpayment_id_from_gateway_table', 13),
(34, '2025_12_23_010000_add_snap_token_to_payments_table', 14),
(35, '2025_12_23_020000_add_visit_code_to_payments_table', 15),
(36, '2025_12_23_030100_add_foreign_keys_constraints', 16);

-- --------------------------------------------------------

--
-- Struktur dari tabel `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `booking_id` bigint UNSIGNED DEFAULT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga` bigint UNSIGNED NOT NULL,
  `fee` bigint UNSIGNED NOT NULL DEFAULT '0',
  `total_harga` bigint UNSIGNED NOT NULL,
  `no_pembayaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_pembeli` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `metode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metode_tipe` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visit_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `log` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `payments`
--

INSERT INTO `payments` (`id`, `booking_id`, `order_id`, `pid`, `harga`, `fee`, `total_harga`, `no_pembayaran`, `no_pembeli`, `status`, `metode`, `metode_tipe`, `snap_token`, `visit_code`, `reference`, `type`, `log`, `created_at`, `updated_at`) VALUES
(68, 68, 'INVKJ6NU0MNN4', NULL, 10000, 500, 10500, 'INVKJ6NU0MNN4', '082118644605', 'paid', 'QRIS', NULL, 'cad5eede-a010-47e4-9c5c-cb563be22f4b', NULL, 'cad5eede-a010-47e4-9c5c-cb563be22f4b', 'booking', '{\"snap\": {\"action\": \"back\", \"order_id\": \"INVKJ6NU0MNN4\", \"status_code\": \"201\", \"transaction_status\": \"pending\"}, \"last_checked_at\": \"2025-12-18 03:57:05\", \"sandbox_auto_paid\": {\"at\": \"2025-12-18 03:57:05\", \"reason\": \"snap_token tersimpan di mode sandbox\"}}', '2025-12-17 20:56:59', '2025-12-17 21:01:54'),
(69, 69, 'INVNTDOMRIRVW', NULL, 10000, 500, 10500, 'INVNTDOMRIRVW', '082118644605', 'paid', 'QRIS', NULL, '11653568-823a-4a89-a3ae-665871ed6bc1', 'KPTEMATIKJSRBZ6LR', '11653568-823a-4a89-a3ae-665871ed6bc1', 'booking', '{\"snap\": {\"action\": \"back\", \"order_id\": \"INVNTDOMRIRVW\", \"status_code\": \"201\", \"transaction_status\": \"pending\"}, \"last_checked_at\": \"2025-12-18 11:51:54\", \"sandbox_auto_paid\": {\"at\": \"2025-12-18 11:51:54\", \"reason\": \"snap_token tersimpan di mode sandbox\"}}', '2025-12-18 04:51:06', '2025-12-18 04:51:54'),
(70, 70, 'INVQM62BJSF6E', NULL, 10000, 500, 10500, 'INVQM62BJSF6E', '0812312412322', 'paid', 'DANA', NULL, '64c74f7b-76a4-41ed-9ffa-eadf7b0ae889', 'KPTEMATIKKFAP3MKL', '64c74f7b-76a4-41ed-9ffa-eadf7b0ae889', 'booking', '{\"snap\": {\"token\": \"64c74f7b-76a4-41ed-9ffa-eadf7b0ae889\", \"redirect_url\": \"https://app.sandbox.midtrans.com/snap/v4/redirection/64c74f7b-76a4-41ed-9ffa-eadf7b0ae889\"}, \"sandbox_auto_paid\": {\"at\": \"2025-12-21 22:08:44\", \"reason\": \"snap_token tersimpan di mode sandbox\"}}', '2025-12-21 15:08:43', '2025-12-21 15:08:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3ptGDt4bTNpgsmnL8FhRKU7qHxaSSKeEDxmuyQ1v', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib0tBREEyTVNndEZ2MVRlVzQ5bjNPY0Y1NXdRWTdjZkpHbEt0cXlSSiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9nYWxlcmkiO3M6NToicm91dGUiO3M6MTg6ImFkbWluLmdhbGVyaS5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6ODoiYWRtaW5faWQiO2k6OTt9', 1766329879);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `registered_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `phone`, `email`, `password`, `pin`, `role`, `registered_at`, `created_at`, `updated_at`) VALUES
(9, 'regan@gmail.com', '08312421321312', 'regan@gmail.com', '$2y$12$.DCK/6IOhS0.bmFnsmz07u6a0pdbldosfKswXMdTerSRDyKjlq.qu', '$2y$12$yYCsV/JdcQJac0qzJDvxrOmGAN3Lbm25GoRGqQSa5JpDgqjgR4v6y', 'admin', '2025-12-17 15:22:33', '2025-12-17 15:22:33', '2025-12-21 15:09:59'),
(10, 'Rio Pratama Putra', '0812341234124', 'riopratamaputra@gmail.com', '$2y$12$YZJUxftLljw5kqbrx.KtbOd86Eue25hobFM8TD5SHIb0o5VFF/OOC', NULL, 'admin', '2025-12-21 15:11:01', '2025-12-21 15:11:01', '2025-12-21 15:11:01');

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bookings_order_id_unique` (`order_id`);

--
-- Indeks untuk tabel `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id_galeri`);

--
-- Indeks untuk tabel `gateway`
--
ALTER TABLE `gateway`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `methodpayment`
--
ALTER TABLE `methodpayment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `methodpayment_code_unique` (`code`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_order_id_unique` (`order_id`),
  ADD UNIQUE KEY `payments_no_pembayaran_unique` (`no_pembayaran`),
  ADD UNIQUE KEY `payments_snap_token_unique` (`snap_token`),
  ADD UNIQUE KEY `payments_visit_code_unique` (`visit_code`),
  ADD KEY `payments_status_metode_index` (`status`,`metode`),
  ADD KEY `payments_booking_id_foreign` (`booking_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT untuk tabel `berita`
--
ALTER TABLE `berita`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT untuk tabel `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id_galeri` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `gateway`
--
ALTER TABLE `gateway`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `methodpayment`
--
ALTER TABLE `methodpayment`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
