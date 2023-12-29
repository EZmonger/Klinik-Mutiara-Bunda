-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2023 at 03:18 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `klinik_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `datapasiens`
--

CREATE TABLE `datapasiens` (
  `id` int(11) NOT NULL,
  `idPasien` int(11) DEFAULT NULL,
  `idNakes` int(11) DEFAULT NULL,
  `keluhan` text NOT NULL,
  `berat` int(11) DEFAULT NULL,
  `tensi` varchar(10) DEFAULT NULL,
  `suhu` int(10) DEFAULT NULL,
  `heartRate` varchar(10) DEFAULT NULL,
  `resRate` varchar(10) DEFAULT NULL,
  `saturasiOx` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `datapasiens`
--

INSERT INTO `datapasiens` (`id`, `idPasien`, `idNakes`, `keluhan`, `berat`, `tensi`, `suhu`, `heartRate`, `resRate`, `saturasiOx`, `updated_at`, `created_at`) VALUES
(4, 1, 1, 'sakit kepala', 25, '111/72', NULL, NULL, NULL, NULL, NULL, '2023-06-16 06:57:09'),
(5, 1, 1, 'tes keluhan', 25, '100/71', NULL, NULL, NULL, NULL, NULL, '2023-06-18 08:46:03'),
(6, 1, 1, 'tes keluhan 2', 25, '100/71', 90, '80-150', '21-31', '80-95', NULL, '2023-06-18 08:48:46'),
(7, 1, 1, 'Sakit Kepala', 25, NULL, 90, '80-150', NULL, NULL, NULL, '2023-06-18 09:05:17'),
(8, 2, 1, 'Melakukan vaksinasi covid', 56, '111/72', 90, NULL, NULL, NULL, NULL, '2023-06-18 13:39:06'),
(9, 1, 3, 'hanya melakukan vaksinasi', 25, '111/72', 80, '80-150', '21-31', '80-95', NULL, '2023-06-19 03:13:30'),
(11, 1, 3, 'vaksin sekali lagi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-06-19 03:24:27'),
(12, 1, 3, 'tes keluhan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-06-19 03:26:00'),
(13, 1, 3, 'tes keluhan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-06-19 03:27:37'),
(16, 1, 6, 'Radang', 25, '111/72', 70, NULL, NULL, NULL, '2023-06-20 16:04:30', '2023-06-20 09:04:30'),
(17, 1, 1, 'radang, sariawan', 25, '111/72', 85, '95-165', '21-31', '80-95', NULL, '2023-06-20 03:14:12'),
(19, 2, 1, 'tes keluhan', 25, '90/70', NULL, NULL, NULL, '87', '2023-06-20 16:04:50', '2023-06-20 09:04:50'),
(21, 2, 3, 'sariawan', NULL, NULL, 78, NULL, NULL, NULL, '2023-06-20 16:06:26', '2023-06-20 09:06:26'),
(24, 1, 3, 'tes keluhan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-06-20 14:11:06'),
(25, 1, 3, 'tes keluhan 2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-06-20 14:11:54'),
(28, 2, 3, 'tes keluhan 30', 99, '110/80', 50, '60-140', '10-30', '60-80', NULL, '2023-06-21 03:31:43'),
(29, 3, 1, 'tes keluhan 20', 45, '140/100', 50, '89-150', '21-31', '90-100', NULL, '2023-06-21 03:33:32'),
(30, 4, 1, 'tes keluhan 99', 30, '180/100', 20, '40-90', '10-30', '80-99', '2023-06-21 10:35:19', '2023-06-21 03:35:19'),
(31, 2, 1, 'tes keluhan 25', 30, NULL, NULL, NULL, NULL, '80-95', NULL, '2023-06-22 02:07:10'),
(32, 1, 1, 'tes keluhan 2', 30, '90/70', NULL, NULL, NULL, NULL, NULL, '2023-06-23 00:37:08');

-- --------------------------------------------------------

--
-- Table structure for table `matrix`
--

CREATE TABLE `matrix` (
  `id` int(11) NOT NULL,
  `koderole` varchar(20) DEFAULT NULL,
  `role` varchar(100) NOT NULL,
  `nakespg` varchar(100) DEFAULT NULL,
  `regpasienpg` varchar(100) DEFAULT NULL,
  `pekerjaanpg` varchar(100) DEFAULT NULL,
  `tindakanpg` varchar(100) DEFAULT NULL,
  `obatpg` varchar(100) DEFAULT NULL,
  `pasienTranspg` varchar(100) DEFAULT NULL,
  `paymentTranspg` varchar(100) DEFAULT NULL,
  `profilepg` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `matrix`
--

INSERT INTO `matrix` (`id`, `koderole`, `role`, `nakespg`, `regpasienpg`, `pekerjaanpg`, `tindakanpg`, `obatpg`, `pasienTranspg`, `paymentTranspg`, `profilepg`, `updated_at`, `created_at`) VALUES
(1, 'ROLE-01', 'owner', 'edit', 'edit', 'view', 'edit', 'editstock', 'edit', 'edit', 'edit', '2023-06-23 08:17:12', '2023-06-23 01:17:12'),
(2, 'ROLE-02', 'nakes', 'none', 'edit', 'none', 'edit', 'edit', 'view', 'view', 'edit', '2023-06-23 07:43:40', '2023-06-23 00:43:40'),
(3, 'ROLE-03', 'admin', 'edit', 'edit', 'edit', 'edit', 'edit', 'edit', 'edit', 'edit', '2023-06-22 15:59:44', '2023-06-22 15:45:05');

-- --------------------------------------------------------

--
-- Table structure for table `nakes`
--

CREATE TABLE `nakes` (
  `id` int(11) NOT NULL,
  `idPekerjaan` int(11) DEFAULT NULL,
  `kodenakes` varchar(20) NOT NULL,
  `idRole` int(11) DEFAULT NULL,
  `nomor` varchar(4) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tgllahir` date NOT NULL,
  `alamat` text DEFAULT NULL,
  `jeniskelamin` varchar(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(20) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nakes`
--

INSERT INTO `nakes` (`id`, `idPekerjaan`, `kodenakes`, `idRole`, `nomor`, `nama`, `tgllahir`, `alamat`, `jeniskelamin`, `username`, `password`, `role`, `updated_at`, `created_at`) VALUES
(1, 3, 'TKS-00', 1, '00', 'Darren A. Leone', '1995-02-02', 'Metro', 'Laki-laki', 'glory', '$2y$10$FvwU3.YxBpaZXfvMc8a.hel4OHFD/TaAoH9itgB6I3r3.R7J3mlOC', 'owner', '2023-06-23 07:40:07', '2023-06-23 00:40:07'),
(3, 2, 'TKS-01', 2, '01', 'William Genesis', '2006-06-12', 'Jl. Surakarta no. 76', 'Laki-laki', 'nakes', '$2y$10$XjO/NRc.Ru3r38Fo6/iQTevw2afdT5//vuwcokC.8W6ohtFfoLro2', 'nakes', '2023-06-23 07:25:11', '2023-06-23 00:25:11'),
(6, NULL, 'TKS-02', 1, '02', 'Ruben Setiawan', '2001-06-13', 'Jl. Balikpapan No. 2', 'Laki-laki', 'bensetiawan', '$2y$10$yMQTKvp0Y5mssJu6ZwI0cO3f14BqyeRa8ZbInSJ7jl31cgCrrKfs.', 'owner', '2023-06-19 16:48:12', '2023-06-22 15:04:29'),
(7, 3, 'TKS-03', 2, '03', 'Kitahara', '2005-02-19', 'jl ketapang no. 54', 'Laki-laki', 'kitahara', '$2y$10$sOtdNR9gWz4WlArWvuyLhOTRGxligTmZFL/ybevZuJ3rk.jgpH.La', 'nakes', '2023-06-22 11:44:55', '2023-06-22 15:04:43'),
(8, NULL, 'TKS-04', 3, '04', 'Admin', '2000-03-02', 'Jl. Balikpapan No. 2', 'Perempuan', 'admin', '$2y$10$Uy4xUaeJYon5VMGwok.DA.k.RwCIsKruJc1eg54i9006LvqSAXRsu', 'admin', '2023-06-22 23:42:51', '2023-06-22 16:42:51');

-- --------------------------------------------------------

--
-- Table structure for table `obats`
--

CREATE TABLE `obats` (
  `id` int(11) NOT NULL,
  `kodeobat` varchar(20) NOT NULL,
  `nomor` varchar(4) NOT NULL,
  `obat` varchar(100) NOT NULL,
  `satuan` varchar(30) NOT NULL,
  `stock` int(11) NOT NULL,
  `harga` varchar(30) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `obats`
--

INSERT INTO `obats` (`id`, `kodeobat`, `nomor`, `obat`, `satuan`, `stock`, `harga`, `updated_at`, `created_at`) VALUES
(1, 'OBT-001', '001', 'Paracetamol', 'sachet', 200, '10000', '2023-06-23 08:17:34', '2023-06-23 01:17:34'),
(2, 'OBT-002', '002', 'Amoxilin', 'sachet', 100, '8000', '2023-06-23 07:42:36', '2023-06-23 00:42:36'),
(3, 'OBT-003', '003', 'Pfizer', 'botol', 269, '50000', '2023-06-21 10:35:43', '2023-06-21 03:35:43'),
(4, 'OBT-004', '004', 'Mixagrip', 'sachet', 330, '10000', '2023-06-21 10:35:43', '2023-06-21 03:35:43');

-- --------------------------------------------------------

--
-- Table structure for table `pasiens`
--

CREATE TABLE `pasiens` (
  `id` int(11) NOT NULL,
  `kodepasien` varchar(20) NOT NULL,
  `nomor` varchar(5) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jeniskelamin` varchar(10) NOT NULL,
  `alamat` text NOT NULL,
  `tgllahir` date NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pasiens`
--

INSERT INTO `pasiens` (`id`, `kodepasien`, `nomor`, `nama`, `jeniskelamin`, `alamat`, `tgllahir`, `updated_at`, `created_at`) VALUES
(1, 'PSN-170623-01', '01', 'Bima Firman', 'Laki-laki', 'jl sudirman no 2', '2000-02-11', '2023-06-19 10:56:31', '2023-06-19 03:56:31'),
(2, 'PSN-180623-01', '01', 'Natasha Abigail', 'Perempuan', 'Jl. Kaji No. 54', '2001-02-06', '2023-06-19 10:56:24', '2023-06-19 03:56:24'),
(3, 'PSN-190623-02', '02', 'Nijika', 'Perempuan', 'Jl. Balikpapan No. 2', '2001-02-03', '2023-06-19 10:58:16', '2023-06-19 03:58:16'),
(4, 'PSN-200623-01', '01', 'Hitori Goto', 'Perempuan', 'Jl Bali no 50', '2000-03-04', '2023-06-20 18:24:40', '2023-06-20 11:24:40'),
(5, 'PSN-230623-01', '01', 'Liandy', 'Laki-laki', 'Jl. Kaji No. 54', '2010-07-09', '2023-06-23 07:39:04', '2023-06-23 00:39:04');

-- --------------------------------------------------------

--
-- Table structure for table `pekerjaans`
--

CREATE TABLE `pekerjaans` (
  `id` int(11) NOT NULL,
  `kodepekerjaan` varchar(20) NOT NULL,
  `nomor` varchar(4) NOT NULL,
  `pekerjaan` varchar(100) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pekerjaans`
--

INSERT INTO `pekerjaans` (`id`, `kodepekerjaan`, `nomor`, `pekerjaan`, `updated_at`, `created_at`) VALUES
(2, 'JOB-01', '01', 'Dokter', '2023-06-22 11:07:47', '2023-06-22 04:07:47'),
(3, 'JOB-02', '02', 'Bidan', '2023-06-22 11:07:56', '2023-06-22 04:07:56');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `koderole` varchar(20) NOT NULL,
  `nomor` varchar(4) NOT NULL,
  `role` varchar(100) NOT NULL,
  `nakespg` varchar(100) DEFAULT NULL,
  `regpasienpg` varchar(100) DEFAULT NULL,
  `pekerjaanpg` varchar(100) DEFAULT NULL,
  `tindakanpg` varchar(100) DEFAULT NULL,
  `obatpg` varchar(100) DEFAULT NULL,
  `pasienTranspg` varchar(100) DEFAULT NULL,
  `paymentTranspg` varchar(100) DEFAULT NULL,
  `profilepg` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `koderole`, `nomor`, `role`, `nakespg`, `regpasienpg`, `pekerjaanpg`, `tindakanpg`, `obatpg`, `pasienTranspg`, `paymentTranspg`, `profilepg`, `updated_at`, `created_at`) VALUES
(1, 'ROLE-01', '01', 'owner', 'edit', 'edit', 'edit', 'edit', 'edit', 'edit', 'edit', 'edit', '2023-06-22 17:18:42', '2023-06-22 15:22:11'),
(2, 'ROLE-02', '02', 'nakes', 'edit', 'edit', 'edit', 'edit', 'edit', 'edit', 'edit', 'edit', '2023-06-22 17:18:42', '2023-06-22 15:22:11'),
(3, 'ROLE-03', '03', 'admin', 'edit', 'edit', 'edit', 'edit', 'edit', 'edit', 'edit', 'edit', '2023-06-22 17:22:21', '2023-06-22 15:22:56');

-- --------------------------------------------------------

--
-- Table structure for table `tindakans`
--

CREATE TABLE `tindakans` (
  `id` int(11) NOT NULL,
  `kodetindakan` varchar(20) DEFAULT NULL,
  `nomor` varchar(3) NOT NULL,
  `tindakan` varchar(200) NOT NULL,
  `tujuan` varchar(200) NOT NULL,
  `harga` varchar(20) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tindakans`
--

INSERT INTO `tindakans` (`id`, `kodetindakan`, `nomor`, `tindakan`, `tujuan`, `harga`, `updated_at`, `created_at`) VALUES
(1, 'TDK-01', '01', 'Cek Suhu', 'Melakukan Pengecekan Suhu Badan', '5000', '2023-06-14 17:49:50', '2023-06-14 10:50:44'),
(2, 'TDK-02', '02', 'Suntik Vitamin', 'Memberikan vitamin', '20000', '2023-06-14 17:50:32', '2023-06-14 10:50:32'),
(3, 'TDK-03', '03', 'Melakukan Vaksinasi', 'Vaksinasi', '60000', '2023-06-14 17:51:36', '2023-06-14 10:51:36');

-- --------------------------------------------------------

--
-- Table structure for table `transactiondetail`
--

CREATE TABLE `transactiondetail` (
  `id` int(11) NOT NULL,
  `idTransactionH` int(11) NOT NULL,
  `idObat` int(11) DEFAULT NULL,
  `idTindakan` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `hargaSubtotal` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactiondetail`
--

INSERT INTO `transactiondetail` (`id`, `idTransactionH`, `idObat`, `idTindakan`, `quantity`, `hargaSubtotal`, `created_at`) VALUES
(42, 20, NULL, 1, NULL, 5000, '2023-06-20 03:14:13'),
(43, 20, 2, NULL, 10, 80000, '2023-06-20 03:14:13'),
(45, 22, NULL, 2, NULL, 20000, '2023-06-20 03:42:37'),
(46, 23, NULL, 1, NULL, 5000, '2023-06-20 05:37:45'),
(47, 23, NULL, 3, NULL, 60000, '2023-06-20 05:37:45'),
(48, 23, 3, NULL, 1, 50000, '2023-06-20 05:37:45'),
(49, 23, 1, NULL, 10, 100000, '2023-06-20 05:37:46'),
(56, 27, NULL, 3, NULL, 60000, '2023-06-20 14:11:54'),
(57, 27, 3, NULL, 10, 500000, '2023-06-20 14:11:54'),
(58, 27, 1, NULL, 10, 100000, '2023-06-20 14:11:54'),
(68, 31, NULL, 3, NULL, 60000, '2023-06-21 03:35:43'),
(69, 31, 4, NULL, 120, 1200000, '2023-06-21 03:35:43'),
(70, 31, 3, NULL, 1, 50000, '2023-06-21 03:35:43'),
(75, 34, NULL, 1, NULL, 5000, '2023-06-22 02:12:09'),
(76, 34, 1, NULL, 10, 100000, '2023-06-22 02:12:09'),
(77, 35, NULL, 2, NULL, 20000, '2023-06-23 00:42:36'),
(78, 35, 2, NULL, 10, 80000, '2023-06-23 00:42:36');

-- --------------------------------------------------------

--
-- Table structure for table `transactionheader`
--

CREATE TABLE `transactionheader` (
  `id` int(11) NOT NULL,
  `kodeTransaction` varchar(20) NOT NULL,
  `no` varchar(4) NOT NULL,
  `idDataPasien` int(11) DEFAULT NULL,
  `hargaTotal` int(11) DEFAULT NULL,
  `status` varchar(8) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactionheader`
--

INSERT INTO `transactionheader` (`id`, `kodeTransaction`, `no`, `idDataPasien`, `hargaTotal`, `status`, `updated_at`, `created_at`) VALUES
(20, 'TRSC-200623-01', '01', 17, 85000, 'Paid', '2023-06-20 21:08:14', '2023-06-20 14:08:14'),
(22, 'TRSC-200623-02', '02', 19, 20000, 'Paid', '2023-06-20 11:33:21', '2023-06-20 04:33:21'),
(23, 'TRSC-200623-03', '03', 21, 0, 'Unpaid', '2023-06-20 21:10:21', '2023-06-20 14:10:21'),
(26, 'TRSC-200623-04', '04', 24, 0, 'Unpaid', '2023-06-20 21:57:48', '2023-06-20 14:57:48'),
(27, 'TRSC-200623-05', '05', 25, 660000, 'Paid', '2023-06-20 21:12:32', '2023-06-20 14:12:32'),
(31, 'TRSC-210623-01', '01', 30, 1310000, 'Paid', '2023-06-21 10:35:59', '2023-06-21 03:35:59'),
(34, 'TRSC-220623-01', '01', 31, 105000, 'Paid', '2023-06-22 23:31:12', '2023-06-22 16:31:12'),
(35, 'TRSC-230623-01', '01', 32, NULL, 'Unpaid', NULL, '2023-06-23 00:42:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `datapasiens`
--
ALTER TABLE `datapasiens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dp_fk_1` (`idNakes`),
  ADD KEY `dp_fk_2` (`idPasien`);

--
-- Indexes for table `matrix`
--
ALTER TABLE `matrix`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nakes`
--
ALTER TABLE `nakes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nakes_fk_1` (`idPekerjaan`);

--
-- Indexes for table `obats`
--
ALTER TABLE `obats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pasiens`
--
ALTER TABLE `pasiens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pekerjaans`
--
ALTER TABLE `pekerjaans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tindakans`
--
ALTER TABLE `tindakans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactiondetail`
--
ALTER TABLE `transactiondetail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `td_fk_3` (`idTransactionH`),
  ADD KEY `td_fk_1` (`idObat`),
  ADD KEY `td_fk_2` (`idTindakan`);

--
-- Indexes for table `transactionheader`
--
ALTER TABLE `transactionheader`
  ADD PRIMARY KEY (`id`),
  ADD KEY `th_fk_1` (`idDataPasien`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `datapasiens`
--
ALTER TABLE `datapasiens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `matrix`
--
ALTER TABLE `matrix`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `nakes`
--
ALTER TABLE `nakes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `obats`
--
ALTER TABLE `obats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pasiens`
--
ALTER TABLE `pasiens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pekerjaans`
--
ALTER TABLE `pekerjaans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tindakans`
--
ALTER TABLE `tindakans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transactiondetail`
--
ALTER TABLE `transactiondetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `transactionheader`
--
ALTER TABLE `transactionheader`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `datapasiens`
--
ALTER TABLE `datapasiens`
  ADD CONSTRAINT `dp_fk_1` FOREIGN KEY (`idNakes`) REFERENCES `nakes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dp_fk_2` FOREIGN KEY (`idPasien`) REFERENCES `pasiens` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nakes`
--
ALTER TABLE `nakes`
  ADD CONSTRAINT `nakes_fk_1` FOREIGN KEY (`idPekerjaan`) REFERENCES `pasiens` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `transactiondetail`
--
ALTER TABLE `transactiondetail`
  ADD CONSTRAINT `td_fk_1` FOREIGN KEY (`idObat`) REFERENCES `obats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `td_fk_2` FOREIGN KEY (`idTindakan`) REFERENCES `tindakans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `td_fk_3` FOREIGN KEY (`idTransactionH`) REFERENCES `transactionheader` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transactionheader`
--
ALTER TABLE `transactionheader`
  ADD CONSTRAINT `th_fk_1` FOREIGN KEY (`idDataPasien`) REFERENCES `datapasiens` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
