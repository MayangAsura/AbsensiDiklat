-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2019 at 10:16 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absensi_diklat`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `diklat_id` int(11) NOT NULL,
  `pegawai_id` int(11) NOT NULL,
  `tgl` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `keterangan` varchar(45) NOT NULL DEFAULT 'TIDAK_HADIR'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `diklat`
--

CREATE TABLE `diklat` (
  `id` int(11) NOT NULL,
  `kode_diklat` varchar(45) NOT NULL,
  `nama_diklat` text NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_berakhir` date NOT NULL,
  `tempat` varchar(50) NOT NULL,
  `jam_mulai` varchar(10) DEFAULT NULL,
  `jam_selesai` varchar(10) DEFAULT NULL,
  `dc` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `diklat`
--

INSERT INTO `diklat` (`id`, `kode_diklat`, `nama_diklat`, `tgl_mulai`, `tgl_berakhir`, `tempat`, `jam_mulai`, `jam_selesai`, `dc`) VALUES
(4, '123', 'Belajar Bareng', '2019-11-20', '2019-11-23', 'Jakarta', '08:00', '16:00', 'Baju Putih Celana Hitam');

-- --------------------------------------------------------

--
-- Table structure for table `icon`
--

CREATE TABLE `icon` (
  `id_icon` int(11) NOT NULL,
  `icon` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `icon`
--

INSERT INTO `icon` (`id_icon`, `icon`) VALUES
(1, 'mdi mdi-plus'),
(2, 'mdi mdi-home'),
(3, 'mdi mdi-pencil'),
(4, 'mdi mdi-delete'),
(5, 'mdi mdi-upload'),
(6, 'mdi mdi-download'),
(7, 'mdi mdi-refresh'),
(9, 'mdi mdi-archive'),
(11, 'mdi  mdi-camera'),
(12, 'mdi mdi-printer'),
(13, 'mdi mdi-file');

-- --------------------------------------------------------

--
-- Table structure for table `keikutsertaan`
--

CREATE TABLE `keikutsertaan` (
  `id` int(11) NOT NULL,
  `diklat_id` int(11) NOT NULL,
  `pegawai_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `keikutsertaan`
--

INSERT INTO `keikutsertaan` (`id`, `diklat_id`, `pegawai_id`) VALUES
(4, 4, 67),
(5, 4, 68);

-- --------------------------------------------------------

--
-- Table structure for table `konfig`
--

CREATE TABLE `konfig` (
  `id_konfig` int(11) NOT NULL,
  `nama_aplikasi` varchar(50) NOT NULL,
  `tgl` date DEFAULT NULL,
  `klien` text,
  `created_by` varchar(45) DEFAULT NULL,
  `footer` text NOT NULL,
  `logo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `konfig`
--

INSERT INTO `konfig` (`id_konfig`, `nama_aplikasi`, `tgl`, `klien`, `created_by`, `footer`, `logo`) VALUES
(41, 'Sistem Absensi Pegawai Diklat', '2019-08-22', 'PLN Persero', 'Alfajri Hulvi', 'Copyrigth 2019 ', 'e5b12b19e902fc8563b95bb57498860b.png');

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id_level` int(11) NOT NULL,
  `level` varchar(50) NOT NULL,
  `direct_link` varchar(45) NOT NULL,
  `keterangan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id_level`, `level`, `direct_link`, `keterangan`) VALUES
(1, 'administrator', 'dashboard', 'Hanya Untuk Admin'),
(2, 'user', 'dashboard', 'Hanya Untuk User Biasa');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id_log` int(11) NOT NULL,
  `time_log` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_log` varchar(255) DEFAULT NULL,
  `tipe_log` int(11) DEFAULT NULL,
  `desc_log` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id_log`, `time_log`, `user_log`, `tipe_log`, `desc_log`) VALUES
(17, '2019-11-12 07:58:36', 'admin', 2, 'Menambahkan data menu'),
(18, '2019-11-12 07:59:10', 'admin', 2, 'Menambahkan data menu'),
(19, '2019-11-12 12:26:59', 'admin', 4, 'Menghapus data menu'),
(20, '2019-11-12 12:27:47', 'admin', 2, 'Menambahkan data menu'),
(21, '2019-11-12 12:28:03', 'admin', 4, 'Menghapus data menu'),
(22, '2019-11-12 12:28:21', 'admin', 2, 'Menambahkan data menu'),
(23, '2019-11-12 12:28:33', 'admin', 4, 'Menghapus data menu'),
(24, '2019-11-12 12:28:37', 'admin', 4, 'Menghapus data menu'),
(25, '2019-11-13 00:40:10', 'admin', 4, 'Menghapus data menu'),
(26, '2019-11-13 00:40:14', 'admin', 4, 'Menghapus data menu'),
(27, '2019-11-13 00:40:21', 'admin', 4, 'Menghapus data menu'),
(28, '2019-11-13 00:40:24', 'admin', 4, 'Menghapus data menu'),
(29, '2019-11-13 00:43:54', 'admin', 2, 'Menambahkan data menu'),
(30, '2019-11-13 00:44:11', 'admin', 2, 'Menambahkan data menu'),
(31, '2019-11-13 00:54:47', 'admin', 2, 'Menambahkan data menu'),
(32, '2019-11-13 00:55:53', 'admin', 2, 'Menambahkan data menu'),
(33, '2019-11-13 04:48:36', 'admin', 2, 'Menambahkan data menu'),
(34, '2019-11-13 04:48:53', 'admin', 2, 'Menambahkan data menu'),
(35, '2019-11-13 05:20:23', 'admin', 3, 'Mengubah data menu'),
(36, '2019-11-13 08:11:52', 'admin', 2, 'Menambahkan data menu'),
(37, '2019-11-13 08:12:17', 'admin', 2, 'Menambahkan data menu'),
(38, '2019-11-14 02:09:03', 'admin', 4, 'Menghapus data menu'),
(39, '2019-11-14 02:09:07', 'admin', 4, 'Menghapus data menu'),
(40, '2019-11-15 00:44:46', 'admin', 4, 'Menghapus data user');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `menu` varchar(45) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `icon` int(11) DEFAULT NULL,
  `link` varchar(45) DEFAULT NULL,
  `id_parents` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `menu`, `level`, `icon`, `link`, `id_parents`) VALUES
(1, 'Pegawai', 1, 9, '', 0),
(6, 'Kelola Data', 1, 9, 'pegawai', 1),
(13, 'Diklat', 1, 9, '', 0),
(14, 'Kelola Data', 1, 13, 'data_diklat', 13),
(15, 'Keikutsertaan Pegawai', 1, 9, '', 0),
(16, 'Kelola Data', 1, 13, 'keikutsertaan', 15),
(17, 'Absensi', 1, 13, '', 0),
(18, 'Kelola Data', 1, 13, 'data_absensi', 17);

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id` int(11) NOT NULL,
  `nip` varchar(45) NOT NULL,
  `nama_lengkap` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `unit` varchar(100) NOT NULL,
  `qrcode` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id`, `nip`, `nama_lengkap`, `email`, `unit`, `qrcode`) VALUES
(67, '123456', 'FAJRI HIDAYATULLAH', 'fajrih25@gmail.com', 'UPDL Jakarta', '123456.png'),
(68, '789012', 'IBNU FATAH', 'alfajrihulvi14@gmail.com', 'UP3 Jakarta', '789012.png');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL,
  `confirm_password` varchar(100) NOT NULL,
  `f_name` varchar(50) NOT NULL,
  `l_name` varchar(50) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `level` int(11) NOT NULL,
  `token` varchar(45) DEFAULT NULL,
  `token_expired` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_loginIP` varchar(45) DEFAULT NULL,
  `created_user` datetime DEFAULT NULL,
  `created_IP` varchar(45) DEFAULT NULL,
  `hint` varchar(200) DEFAULT NULL,
  `status` enum('0','1') DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `confirm_password`, `f_name`, `l_name`, `email`, `no_hp`, `level`, `token`, `token_expired`, `last_login`, `last_loginIP`, `created_user`, `created_IP`, `hint`, `status`, `foto`) VALUES
(1, 'admin', 'fcea920f7412b5da7be0cf42b8c93759', 'fcea920f7412b5da7be0cf42b8c93759', 'Super', 'Admin', 'admin123@gmail.com', '081287881363', 1, '898989', '2019-03-31 10:26:27', '2019-11-18 15:36:01', '::1', '2019-03-01 11:29:33', '::1', NULL, '1', 'no_img.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_absensi_diklat1_idx` (`diklat_id`),
  ADD KEY `fk_absensi_pegawai1_idx` (`pegawai_id`);

--
-- Indexes for table `diklat`
--
ALTER TABLE `diklat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `icon`
--
ALTER TABLE `icon`
  ADD PRIMARY KEY (`id_icon`);

--
-- Indexes for table `keikutsertaan`
--
ALTER TABLE `keikutsertaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_diklat_has_pegawai_pegawai1_idx` (`pegawai_id`),
  ADD KEY `fk_diklat_has_pegawai_diklat1_idx` (`diklat_id`);

--
-- Indexes for table `konfig`
--
ALTER TABLE `konfig`
  ADD PRIMARY KEY (`id_konfig`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id_level`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `fk_menu_menu1_idx` (`id_parents`),
  ADD KEY `fk_menu_level1_idx` (`level`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD KEY `fk_user_level_idx` (`level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `diklat`
--
ALTER TABLE `diklat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `icon`
--
ALTER TABLE `icon`
  MODIFY `id_icon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `keikutsertaan`
--
ALTER TABLE `keikutsertaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `konfig`
--
ALTER TABLE `konfig`
  MODIFY `id_konfig` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id_level` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `fk_absensi_diklat1` FOREIGN KEY (`diklat_id`) REFERENCES `diklat` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_absensi_pegawai1` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `keikutsertaan`
--
ALTER TABLE `keikutsertaan`
  ADD CONSTRAINT `fk_diklat_has_pegawai_diklat1` FOREIGN KEY (`diklat_id`) REFERENCES `diklat` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_diklat_has_pegawai_pegawai1` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
