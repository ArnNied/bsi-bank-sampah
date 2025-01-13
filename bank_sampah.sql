-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2024 at 01:40 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bank_sampah`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `terakhir_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `terakhir_login`) VALUES
(1, 'admin', '$2y$10$Hma/0jNjc.B3zKbKeONdleJB5Sp.sBCOvVN5uKTsw4cKtUOJQz4e6', '2024-01-04 03:38:32');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `taksiran` int(11) NOT NULL,
  `stok` float NOT NULL,
  `terakhir_diperbarui` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama`, `deskripsi`, `taksiran`, `stok`, `terakhir_diperbarui`) VALUES
(1, 'Kertas', NULL, 9980, 0.24, '2024-01-04 08:09:04'),
(2, 'Plastik', NULL, 5593, 19.99, '2024-01-02 06:01:27'),
(3, 'Kaca', NULL, 2292, 12.47, '2024-01-02 18:57:29'),
(4, 'Kaleng', NULL, 7976, 10.32, '2024-01-01 13:01:43'),
(5, 'Kain', NULL, 2218, 11.42, '2024-01-02 17:19:25'),
(6, 'Karet', NULL, 9124, 6.27, '2024-01-03 04:09:49'),
(7, 'Kayu', NULL, 8153, 0.83, '2024-01-02 12:10:25'),
(8, 'Limbah B3', NULL, 3796, 19.38, '2024-01-01 14:04:01');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2023-06-16-124844', 'App\\Database\\Migrations\\Initial', 'default', 'App', 1704371962, 1);

-- --------------------------------------------------------

--
-- Table structure for table `nasabah`
--

CREATE TABLE `nasabah` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `nomor_telepon` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `saldo` int(11) NOT NULL,
  `tanggal_daftar` datetime DEFAULT NULL,
  `terakhir_login` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `nasabah`
--

INSERT INTO `nasabah` (`id`, `username`, `password`, `nama_lengkap`, `alamat`, `nomor_telepon`, `email`, `saldo`, `tanggal_daftar`, `terakhir_login`, `is_active`) VALUES
(1, 'puwais', '$2y$10$DIn9IS9RDi6wVEL.f.0h5e29v8yeiYx/0idl3wOla/SubhS0.mL/2', 'Utama Hutagalung', 'Kpg. Kiaracondong No. 986, Lhokseumawe 69962, Jatim', '(+62) 536 2782 790', 'karimah.zulaika@prasasta.in', 143, '2024-01-01 07:35:58', '2024-01-01 07:35:58', 1),
(2, 'mila68', '$2y$10$WE0nKE9obecpJdveZsI0JutOv0Wfky4OrP8dvBluXvYOdg5QYx.8q', 'Alika Wastuti', 'Ki. Bak Mandi No. 489, Depok 95825, Sulbar', '0978 1837 2240', 'ppradipta@uwais.co', 90248, '2024-01-01 08:24:43', '2024-01-01 08:24:43', 1),
(3, 'pratiwi.siska', '$2y$10$YOoarIArmzzxm2N7NiQ5DuL.RYT10giwMcquzLlzl9P5ADoAStZA2', 'Among Rajasa', 'Kpg. Basudewo No. 895, Sibolga 47824, Sulut', '(+62) 908 0104 3743', 'kariman20@gmail.co.id', 70061, '2024-01-01 11:24:48', '2024-01-01 11:24:48', 1),
(4, 'nasabah', '$2y$10$mnWOi8ARgFrsiwdk7q6e3.gft6A93xbjcMtx5ftEx5kLFd.hs75gy', 'Nasabah', 'Jr. Mahakam No. 850, Palangka Raya 45282, Sumut', '024 8035 917', 'karja26@irawan.net', 99039, '2024-01-01 16:04:09', '2024-01-01 16:04:09', 1),
(5, 'luthfi.utami', '$2y$10$a.b81QKCFP6Y6kuGKLiRgeH/gMscdgc5RSFCiJc4tS192k/GQY2J6', 'Darijan Najib Natsir M.Pd', 'Kpg. Raden Saleh No. 250, Tebing Tinggi 93764, Banten', '0663 1352 7175', 'zalindra.situmorang@gmail.com', 26339, '2024-01-02 02:01:26', '2024-01-02 02:01:26', 1),
(6, 'suryatmi.eva', '$2y$10$OpfavBJwlarYeXL1nYGFf.FLZXcn7nbwAZuJHPlXv.jUfIzGKa4KG', 'Uli Vicky Wahyuni', 'Psr. Lada No. 49, Pekalongan 54613, NTB', '0389 3703 088', 'dhastuti@yahoo.com', 199782, '2024-01-02 06:59:03', '2024-01-02 06:59:03', 1),
(7, 'wakiman.wulandari', '$2y$10$6Sp/BBCzRbInu6cSVGQdVe59VKDXbQH0ERuFaes1cm.L.L3HOXkmu', 'Wulan Pratiwi S.IP', 'Dk. Salak No. 30, Palu 91140, Pabar', '0667 9540 951', 'jnasyiah@dabukke.biz.id', 29269, '2024-01-02 11:22:09', '2024-01-02 11:22:09', 1),
(8, 'zahra79', '$2y$10$fDeh4ssnETOvxwxlLyJJh.Sesnl394rPF9IksK/mPwL7J4Lg/1WDW', 'Hairyanto Wibowo', 'Kpg. Thamrin No. 318, Bontang 52153, Riau', '0726 8665 0813', 'dhakim@gmail.co.id', 82298, '2024-01-02 11:31:05', '2024-01-02 11:31:05', 1),
(9, 'manullang.mila', '$2y$10$xDAoRYRwjMFo1IK9pc5tgO8nGkege8AwKeJggzawH.DJu3ox4JCtK', 'Among Tamba', 'Ds. Sukajadi No. 773, Tangerang 91752, Jatim', '0465 7769 178', 'nilam91@riyanti.in', 22, '2024-01-02 17:58:11', '2024-01-02 17:58:11', 1),
(10, 'nashiruddin.amalia', '$2y$10$..ubklzK5D74qU5TLISxL.j/.I5v3wkD1IkQr6HcElZsC6UPbQ7ha', 'Ganep Salahudin', 'Dk. Pintu Besar Selatan No. 216, Tanjung Pinang 60756, DIY', '(+62) 608 9909 416', 'jhardiansyah@yulianti.asia', 63430, '2024-01-03 00:20:27', '2024-01-03 00:20:27', 1),
(11, 'mariadi.firmansyah', '$2y$10$l7goMWh3GLK4hqs9Zha2T.4IKFD4VdT/CjjG.Ob..9F7Gy7oYNQNG', 'Farhunnisa Umi Puspasari', 'Jr. Nakula No. 396, Tidore Kepulauan 41716, Kepri', '0810 2869 2349', 'adinata.wibowo@yulianti.desa.id', 293, '2024-01-03 12:51:02', '2024-01-03 12:51:02', 1),
(12, 'oliva36', '$2y$10$jKJvHbhkO6W.htSArhUiiu/ArOKnCwpvMmop1oLLLmvZ/63Znl/u.', 'Jessica Wijayanti', 'Ki. Sadang Serang No. 945, Administrasi Jakarta Pusat 11213, Jabar', '0906 4998 1145', 'bpurnawati@gmail.com', 18541, '2024-01-03 21:24:08', '2024-01-03 21:24:08', 1),
(13, 'jayeng.sihombing', '$2y$10$41qSM6P5vIDggJ9bTzks0O8Ep6S2eN58ZpZZ1zUrmdDGEKG7SzucS', 'Rafi Siregar', 'Kpg. Bacang No. 545, Tarakan 76324, Malut', '0641 8724 810', 'prakasa.najwa@purnawati.co.id', 2658, '2024-01-03 21:54:43', '2024-01-03 21:54:43', 1),
(14, 'darijan.palastri', '$2y$10$JMofuyFRD.8w40kpQm5Mju7fOVX2UkLx.E/2E4wR5RDBVT8Trff0e', 'Maida Pudjiastuti', 'Jln. Bawal No. 703, Balikpapan 65501, DKI', '(+62) 835 2297 149', 'sinaga.violet@prasetya.my.id', 379981, '2024-01-04 02:51:50', '2024-01-04 02:51:50', 1),
(15, 'pradipta.kadir', '$2y$10$ZZxljkuOKlq.Jq.6koWe/ebAbtlpAaNSIWtTytHl0oHBFJP2EdPhG', 'Laila Padmasari', 'Ki. Bawal No. 495, Administrasi Jakarta Pusat 76027, Sulsel', '028 2665 8551', 'bakianto01@kurniawan.net', 71967, '2024-01-04 02:59:33', '2024-01-04 02:59:33', 1),
(16, 'ppurnawati', '$2y$10$d3Yq/pJT42567Z.tVUrqV.PI2h2bGZZAAGTA2Mlyb2mCaJ0575iR.', 'Baktiono Manullang', 'Ds. Samanhudi No. 381, Administrasi Jakarta Selatan 78550, Kaltara', '(+62) 423 6942 968', 'wardi17@gmail.co.id', 94886, '2024-01-04 15:44:46', '2024-01-04 15:44:46', 1);

-- --------------------------------------------------------

--
-- Table structure for table `penarikan`
--

CREATE TABLE `penarikan` (
  `id` int(11) NOT NULL,
  `id_nasabah` int(11) DEFAULT NULL,
  `bank` enum('BRI','BCA','Mandiri','BNI','BTN','CIMB Niaga') NOT NULL,
  `nomor_rekening` varchar(255) NOT NULL,
  `nominal` int(11) NOT NULL,
  `tanggal_pengajuan` datetime DEFAULT NULL,
  `tanggal_diproses` datetime DEFAULT NULL,
  `status` enum('pending','diterima','ditolak') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `penarikan`
--

INSERT INTO `penarikan` (`id`, `id_nasabah`, `bank`, `nomor_rekening`, `nominal`, `tanggal_pengajuan`, `tanggal_diproses`, `status`) VALUES
(1, 5, 'CIMB Niaga', '5749727684417330', 3067, '2024-01-01 08:19:41', '2024-01-01 08:19:41', 'ditolak'),
(2, 1, 'BNI', '9983108408575618', 91646, '2024-01-01 10:01:22', '2024-01-01 10:01:22', 'ditolak'),
(3, 7, 'BCA', '5165667179117525', 30, '2024-01-01 11:52:01', '2024-01-01 11:52:01', 'pending'),
(4, 6, 'BRI', '2053680469495847', 89, '2024-01-01 14:50:10', '2024-01-01 14:50:10', 'pending'),
(5, 4, 'BRI', '3657285446341948', 4495, '2024-01-01 18:47:18', '2024-01-01 18:47:18', 'ditolak'),
(6, 8, 'BNI', '8594001369520993', 255, '2024-01-02 01:40:19', '2024-01-02 01:40:19', 'ditolak'),
(7, 1, 'BTN', '2156710966645583', 50136, '2024-01-02 07:06:46', '2024-01-02 07:06:46', 'pending'),
(8, 4, 'BRI', '2712403826880975', 353, '2024-01-02 10:19:34', '2024-01-02 10:19:34', 'ditolak'),
(9, 1, 'CIMB Niaga', '4657863400511078', 261218, '2024-01-02 10:58:17', '2024-01-02 10:58:17', 'pending'),
(10, 5, 'BTN', '263125780493964', 57846, '2024-01-02 12:00:19', '2024-01-02 12:00:19', 'diterima'),
(11, 3, 'BCA', '4892816793527152', 14532, '2024-01-02 17:03:20', '2024-01-02 17:03:20', 'diterima'),
(12, 2, 'BRI', '7153030876713817', 7, '2024-01-02 17:58:05', '2024-01-02 17:58:05', 'pending'),
(13, 6, 'BRI', '8755138841146568', 482, '2024-01-02 19:16:41', '2024-01-02 19:16:41', 'diterima'),
(14, 1, 'CIMB Niaga', '9941658718757656', 46178, '2024-01-02 20:30:00', '2024-01-02 20:30:00', 'diterima'),
(15, 1, 'Mandiri', '1965227571993327', 117787, '2024-01-02 22:08:47', '2024-01-02 22:08:47', 'pending'),
(16, 2, 'BCA', '3577718846115523', 58358, '2024-01-02 22:29:45', '2024-01-02 22:29:45', 'pending'),
(17, 3, 'BNI', '8413692969203403', 51038, '2024-01-02 23:08:10', '2024-01-02 23:08:10', 'ditolak'),
(18, 3, 'BNI', '9228435384897634', 5893, '2024-01-02 23:43:16', '2024-01-02 23:43:16', 'pending'),
(19, 2, 'CIMB Niaga', '6599669098023127', 24757, '2024-01-03 03:48:17', '2024-01-03 03:48:17', 'pending'),
(20, 2, 'BCA', '8059330804625330', 5215, '2024-01-03 04:19:05', '2024-01-03 04:19:05', 'ditolak'),
(21, 3, 'Mandiri', '4897637975273659', 95889, '2024-01-03 07:00:59', '2024-01-03 07:00:59', 'pending'),
(22, 2, 'BNI', '8145252796031520', 39652, '2024-01-03 10:13:15', '2024-01-03 10:13:15', 'pending'),
(23, 2, 'BRI', '2019586685942896', 23561, '2024-01-03 11:55:53', '2024-01-03 11:55:53', 'pending'),
(24, 1, 'BRI', '1598786508732959', 44667, '2024-01-03 13:12:20', '2024-01-03 13:12:20', 'ditolak'),
(25, 4, 'BRI', '4262047774258992', 151, '2024-01-03 13:12:31', '2024-01-03 13:12:31', 'pending'),
(26, 4, 'BRI', '128529840094171', 19856, '2024-01-03 13:19:32', '2024-01-03 13:19:32', 'diterima'),
(27, 2, 'Mandiri', '5209641227834772', 55766, '2024-01-03 13:55:41', '2024-01-03 13:55:41', 'pending'),
(28, 1, 'BRI', '5913560263605946', 131370, '2024-01-03 14:59:51', '2024-01-03 14:59:51', 'pending'),
(29, 1, 'BNI', '9633796652146418', 209648, '2024-01-03 15:28:32', '2024-01-03 15:28:32', 'diterima'),
(30, 1, 'BRI', '4320156578783509', 138225, '2024-01-03 22:25:58', '2024-01-03 22:25:58', 'pending'),
(31, 1, 'CIMB Niaga', '6746833249280374', 92205, '2024-01-03 22:27:25', '2024-01-03 22:27:25', 'diterima'),
(32, 3, 'BTN', '4860840101552333', 37114, '2024-01-04 01:45:25', '2024-01-04 01:45:25', 'pending'),
(33, 1, 'BNI', '570668510596138', 17346, '2024-01-04 05:34:20', '2024-01-04 05:34:20', 'pending'),
(34, 1, 'Mandiri', '6679128847621251', 26324, '2024-01-04 09:23:39', '2024-01-04 09:23:39', 'diterima'),
(35, 3, 'BCA', '8015298725204261', 4904, '2024-01-04 12:31:59', '2024-01-04 12:31:59', 'pending'),
(36, 2, 'BNI', '5821404949457638', 22185, '2024-01-04 13:16:47', '2024-01-04 13:16:47', 'diterima'),
(37, 5, 'BCA', '5488463406844625', 334, '2024-01-04 14:27:02', '2024-01-04 14:27:02', 'ditolak'),
(38, 7, 'CIMB Niaga', '5531248021711258', 101, '2024-01-04 15:58:53', '2024-01-04 15:58:53', 'ditolak'),
(39, 3, 'BCA', '823915191250576', 489, '2024-01-04 16:40:24', '2024-01-04 16:40:24', 'diterima'),
(40, 4, 'Mandiri', '1314348031408034', 187, '2024-01-04 19:15:51', '2024-01-04 19:15:51', 'diterima');

-- --------------------------------------------------------

--
-- Table structure for table `setoran`
--

CREATE TABLE `setoran` (
  `id` int(11) NOT NULL,
  `id_nasabah` int(11) DEFAULT NULL,
  `id_teller` int(11) DEFAULT NULL,
  `kategori_sampah` varchar(255) NOT NULL,
  `taksiran` int(11) NOT NULL,
  `berat` float NOT NULL,
  `nominal` int(11) NOT NULL,
  `tanggal_setor` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `setoran`
--

INSERT INTO `setoran` (`id`, `id_nasabah`, `id_teller`, `kategori_sampah`, `taksiran`, `berat`, `nominal`, `tanggal_setor`) VALUES
(1, 3, 6, 'Plastik', 5593, 9.67, 54084, '2024-01-01 09:02:54'),
(2, 3, 2, 'Kain', 2218, 1.39, 3083, '2024-01-01 09:37:53'),
(3, 1, 2, 'Kayu', 8153, 2.69, 21931, '2024-01-01 10:59:59'),
(4, 1, 5, 'Kayu', 8153, 3.59, 29269, '2024-01-01 15:23:30'),
(5, 7, 6, 'Karet', 9124, 3.1, 28284, '2024-01-01 19:31:12'),
(6, 1, 2, 'Karet', 9124, 8.88, 81021, '2024-01-01 21:49:49'),
(7, 9, 3, 'Kaca', 2292, 1.11, 2544, '2024-01-02 00:06:48'),
(8, 10, 6, 'Plastik', 5593, 0.23, 1286, '2024-01-02 01:18:56'),
(9, 2, 2, 'Kaleng', 7976, 3.19, 25443, '2024-01-02 05:01:21'),
(10, 1, 5, 'Limbah B3', 3796, 3, 11388, '2024-01-02 05:12:29'),
(11, 4, 5, 'Limbah B3', 3796, 4.87, 18486, '2024-01-02 06:24:35'),
(12, 4, 4, 'Kaca', 2292, 1.39, 3185, '2024-01-02 06:43:34'),
(13, 3, 6, 'Limbah B3', 3796, 4.74, 17993, '2024-01-02 10:01:22'),
(14, 2, 2, 'Kain', 2218, 8.75, 19407, '2024-01-02 12:56:17'),
(15, 8, 5, 'Limbah B3', 3796, 1.22, 4631, '2024-01-02 13:24:56'),
(16, 1, 5, 'Kaleng', 7976, 9.38, 74814, '2024-01-02 14:19:54'),
(17, 3, 5, 'Karet', 9124, 0, 0, '2024-01-02 17:47:03'),
(18, 4, 5, 'Kaleng', 7976, 1.68, 13399, '2024-01-02 19:14:15'),
(19, 2, 3, 'Limbah B3', 3796, 8.31, 31544, '2024-01-02 19:23:26'),
(20, 1, 2, 'Kaleng', 7976, 8.17, 65163, '2024-01-02 19:54:48'),
(21, 6, 1, 'Kayu', 8153, 7.45, 60739, '2024-01-02 19:55:47'),
(22, 2, 5, 'Kaca', 2292, 1.75, 4011, '2024-01-02 20:19:57'),
(23, 4, 2, 'Kaca', 2292, 7.8, 17877, '2024-01-02 20:53:36'),
(24, 4, 2, 'Plastik', 5593, 5, 27965, '2024-01-02 21:43:09'),
(25, 1, 4, 'Kayu', 8153, 8.3, 67669, '2024-01-02 21:47:16'),
(26, 6, 5, 'Kain', 2218, 2.13, 4724, '2024-01-02 23:10:34'),
(27, 3, 6, 'Kaca', 2292, 2.04, 4675, '2024-01-02 23:24:06'),
(28, 4, 5, 'Plastik', 5593, 8.46, 47316, '2024-01-03 02:11:50'),
(29, 3, 6, 'Limbah B3', 3796, 4.43, 16816, '2024-01-03 03:22:45'),
(30, 5, 6, 'Plastik', 5593, 3.97, 22204, '2024-01-03 03:34:42'),
(31, 4, 1, 'Limbah B3', 3796, 5.65, 21447, '2024-01-03 03:38:14'),
(32, 10, 3, 'Karet', 9124, 5.51, 50273, '2024-01-03 04:47:32'),
(33, 3, 4, 'Kaleng', 7976, 8.76, 69869, '2024-01-03 05:15:06'),
(34, 2, 2, 'Kain', 2218, 7.32, 16235, '2024-01-03 06:18:40'),
(35, 5, 6, 'Kaleng', 7976, 9.35, 74575, '2024-01-03 06:27:40'),
(36, 2, 3, 'Kaleng', 7976, 5.57, 44426, '2024-01-03 06:48:03'),
(37, 5, 5, 'Limbah B3', 3796, 5.3, 20118, '2024-01-03 11:45:07'),
(38, 3, 6, 'Limbah B3', 3796, 6.73, 25547, '2024-01-03 13:23:29'),
(39, 1, 4, 'Kain', 2218, 8.64, 19163, '2024-01-03 14:42:14'),
(40, 1, 4, 'Kayu', 8153, 4.02, 32775, '2024-01-03 14:45:13'),
(41, 1, 3, 'Kaleng', 7976, 6.05, 48254, '2024-01-03 16:18:55'),
(42, 4, 5, 'Karet', 9124, 0.5, 4562, '2024-01-03 16:54:30'),
(43, 1, 3, 'Karet', 9124, 8.69, 79287, '2024-01-03 17:31:29'),
(44, 8, 4, 'Kaca', 2292, 9.51, 21796, '2024-01-03 17:42:12'),
(45, 5, 4, 'Plastik', 5593, 7.94, 44408, '2024-01-03 19:09:28'),
(46, 4, 1, 'Limbah B3', 3796, 9.37, 35568, '2024-01-03 19:22:19'),
(47, 2, 6, 'Kaleng', 7976, 3.31, 26400, '2024-01-03 21:13:11'),
(48, 7, 3, 'Kayu', 8153, 2.37, 19322, '2024-01-03 21:51:20'),
(49, 6, 1, 'Kayu', 8153, 8.76, 71420, '2024-01-03 22:03:01'),
(50, 3, 5, 'Limbah B3', 3796, 1.91, 7250, '2024-01-03 23:19:39'),
(51, 5, 4, 'Kain', 2218, 1, 2218, '2024-01-03 23:25:21'),
(52, 6, 5, 'Kaca', 2292, 8.19, 18771, '2024-01-04 01:09:11'),
(53, 1, 6, 'Kayu', 8153, 5.9, 48102, '2024-01-04 01:30:33'),
(54, 1, 3, 'Kain', 2218, 0.88, 1951, '2024-01-04 02:05:05'),
(55, 5, 4, 'Kayu', 8153, 5.3, 43210, '2024-01-04 02:11:01'),
(56, 1, 6, 'Karet', 9124, 9.58, 87407, '2024-01-04 02:15:32'),
(57, 5, 2, 'Kaca', 2292, 5.57, 12766, '2024-01-04 02:24:30'),
(58, 2, 6, 'Kayu', 8153, 4.14, 33753, '2024-01-04 03:40:37'),
(59, 6, 5, 'Plastik', 5593, 8.34, 46645, '2024-01-04 05:52:27'),
(60, 4, 3, 'Kain', 2218, 4.16, 9226, '2024-01-04 06:11:18'),
(61, 2, 3, 'Kayu', 8153, 4.97, 40520, '2024-01-04 07:50:12'),
(62, 8, 3, 'Kaca', 2292, 5.82, 13339, '2024-01-04 08:24:57'),
(63, 2, 6, 'Kayu', 8153, 4.13, 33671, '2024-01-04 09:31:30'),
(64, 1, 5, 'Karet', 9124, 9.02, 82298, '2024-01-04 10:06:53'),
(65, 3, 1, 'Plastik', 5593, 4.98, 27853, '2024-01-04 11:18:35'),
(66, 5, 2, 'Kaleng', 7976, 0, 0, '2024-01-04 11:41:41'),
(67, 7, 4, 'Karet', 9124, 9.51, 86769, '2024-01-04 11:52:18'),
(68, 7, 3, 'Kaca', 2292, 0.32, 733, '2024-01-04 12:37:27'),
(69, 7, 5, 'Kaleng', 7976, 2.65, 21136, '2024-01-04 13:05:27'),
(70, 9, 5, 'Kain', 2218, 3.33, 7385, '2024-01-04 13:23:09'),
(71, 2, 3, 'Plastik', 5593, 0.82, 4586, '2024-01-04 13:47:01'),
(72, 3, 6, 'Limbah B3', 3796, 1.4, 5314, '2024-01-04 13:53:09'),
(73, 3, 2, 'Karet', 9124, 5.93, 54105, '2024-01-04 14:00:17'),
(74, 1, 3, 'Kaca', 2292, 1.71, 3919, '2024-01-04 14:09:11'),
(75, 6, 5, 'Kaleng', 7976, 7, 55832, '2024-01-04 14:37:08'),
(76, 2, 1, 'Plastik', 5593, 3.77, 21085, '2024-01-04 14:59:01'),
(77, 3, 5, 'Plastik', 5593, 3.96, 22148, '2024-01-04 15:27:13'),
(78, 6, 4, 'Kaleng', 7976, 6.77, 53997, '2024-01-04 16:04:51'),
(79, 4, 6, 'Kayu', 8153, 4.01, 32693, '2024-01-04 17:10:40'),
(80, 2, 4, 'Karet', 9124, 7.54, 68794, '2024-01-04 17:20:54'),
(81, 5, 3, 'Limbah B3', 3796, 0.79, 2998, '2024-01-04 19:30:55');

-- --------------------------------------------------------

--
-- Table structure for table `teller`
--

CREATE TABLE `teller` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `nomor_telepon` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tanggal_daftar` datetime DEFAULT NULL,
  `terakhir_login` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `teller`
--

INSERT INTO `teller` (`id`, `username`, `password`, `nama_lengkap`, `alamat`, `nomor_telepon`, `email`, `tanggal_daftar`, `terakhir_login`, `is_active`) VALUES
(1, 'wulandari.silvia', '$2y$10$T7q2KxhQGXUDU5zRDnD5hOocWBOaLqy8CASu.yXvrEuN8LFbdv3la', 'Hilda Fathonah Maryati', 'Psr. Soekarno Hatta No. 906, Singkawang 56193, Gorontalo', '(+62) 970 4155 3038', 'rsuryatmi@mansur.co', '2024-01-01 12:45:50', '2024-01-01 12:45:50', 1),
(2, 'astuti.siska', '$2y$10$F46fQrnsSJ8B46ydIQrXouejBfPt2Ny0pjRHLqg1qIuYw2f5mBGjq', 'Zizi Namaga', 'Psr. Pintu Besar Selatan No. 690, Tegal 95836, NTT', '(+62) 416 8657 337', 'wibisono.enteng@gmail.com', '2024-01-01 16:04:09', '2024-01-01 16:04:09', 1),
(3, 'prabawa20', '$2y$10$J/6PCwyvsuKyPDN6DUVf9.LBIP2xf9jOfiavu3KszP11RLg9dcCNK', 'Karja Najmudin S.T.', 'Jr. Achmad No. 802, Batu 57042, Kaltara', '0777 5713 4806', 'cmelani@yahoo.co.id', '2024-01-02 21:19:41', '2024-01-02 21:19:41', 1),
(4, 'galuh28', '$2y$10$GqFFsZ3HtDlgx4/OWRjnCujREZeONntAVKw88xkR/SAHwJgfi8zne', 'Lukita Gunarto', 'Jr. Hang No. 14, Bogor 71226, Kalsel', '(+62) 961 5396 171', 'mangunsong.amelia@gmail.co.id', '2024-01-03 00:56:46', '2024-01-03 00:56:46', 1),
(5, 'teller', '$2y$10$RdLd.55t1VEvNd7UNJvVleuT9M8cHVD8Ju81wBcT5iz5fRhFsVAOy', 'Teller', 'Jr. Moch. Toha No. 217, Sibolga 27319, Sulsel', '(+62) 220 2401 4158', 'qhardiansyah@gmail.com', '2024-01-03 01:07:56', '2024-01-03 01:07:56', 1),
(6, 'yaryani', '$2y$10$e3mIPUNhkU1cyAxObgUVbOLqgideZyqQoQkHdgbVJ7PY5IPMuzpLm', 'Bajragin Marbun M.Ak', 'Psr. Basudewo No. 442, Gunungsitoli 44934, Maluku', '(+62) 660 7193 7012', 'jwacana@farida.sch.id', '2024-01-04 19:14:00', '2024-01-04 19:14:00', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nasabah`
--
ALTER TABLE `nasabah`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `penarikan`
--
ALTER TABLE `penarikan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penarikan_id_nasabah_foreign` (`id_nasabah`);

--
-- Indexes for table `setoran`
--
ALTER TABLE `setoran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `setoran_id_nasabah_foreign` (`id_nasabah`),
  ADD KEY `setoran_id_teller_foreign` (`id_teller`);

--
-- Indexes for table `teller`
--
ALTER TABLE `teller`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `nasabah`
--
ALTER TABLE `nasabah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `penarikan`
--
ALTER TABLE `penarikan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `setoran`
--
ALTER TABLE `setoran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `teller`
--
ALTER TABLE `teller`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `penarikan`
--
ALTER TABLE `penarikan`
  ADD CONSTRAINT `penarikan_id_nasabah_foreign` FOREIGN KEY (`id_nasabah`) REFERENCES `nasabah` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `setoran`
--
ALTER TABLE `setoran`
  ADD CONSTRAINT `setoran_id_nasabah_foreign` FOREIGN KEY (`id_nasabah`) REFERENCES `nasabah` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `setoran_id_teller_foreign` FOREIGN KEY (`id_teller`) REFERENCES `teller` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
