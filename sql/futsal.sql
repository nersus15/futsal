-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 14, 2022 at 08:05 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `futsal`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` varchar(15) NOT NULL,
  `tanggal` date NOT NULL,
  `jadwal` varchar(8) NOT NULL,
  `status` enum('baru','aktif','selesai','terverifikasi','batal') NOT NULL,
  `penanggung_jawab` varchar(100) NOT NULL,
  `tim` varchar(100) NOT NULL,
  `dibuat` datetime NOT NULL,
  `member` varchar(8) DEFAULT NULL,
  `lapangan` varchar(8) NOT NULL,
  `bukti_bayar` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `tanggal`, `jadwal`, `status`, `penanggung_jawab`, `tim`, `dibuat`, `member`, `lapangan`, `bukti_bayar`) VALUES
('BOOK2022071401', '2022-07-21', 'v8BBbX8d', 'baru', 'Rizal', 'Ntah', '2022-07-14 09:36:42', NULL, 'LPN01', 'LzqLT8EklVnm8PL'),
('BOOK2022071402', '2022-07-30', 'v8BBbX8d', 'baru', 'Rizal', '', '2022-07-14 13:24:52', NULL, 'LPN01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `file_upload`
--

CREATE TABLE `file_upload` (
  `id` varchar(15) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `uuid` varchar(46) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `file_upload`
--

INSERT INTO `file_upload` (`id`, `nama`, `uuid`) VALUES
('LzqLT8EklVnm8PL', '862cfa524ea454.JPG', 'd5f5692b-2af5-487a-ae98-fb9fa35157bd'),
('Pa6WT9DQNVyV7kV', '862cfa258c5743.jpg', 'ddc43a8a-74a1-42d1-b010-2a618de60b2a');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id` varchar(8) NOT NULL,
  `mulai` time NOT NULL,
  `selesai` time NOT NULL,
  `lapangan` varchar(8) NOT NULL,
  `tarif` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id`, `mulai`, `selesai`, `lapangan`, `tarif`) VALUES
('v8BBbX8d', '11:00:00', '12:00:00', 'LPN01', 200000);

-- --------------------------------------------------------

--
-- Table structure for table `lapangan`
--

CREATE TABLE `lapangan` (
  `id` varchar(8) NOT NULL,
  `jenis` varchar(46) NOT NULL,
  `tempat` varchar(100) NOT NULL,
  `koordinat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lapangan`
--

INSERT INTO `lapangan` (`id`, `jenis`, `tempat`, `koordinat`) VALUES
('LPN01', 'Vinyl', 'sekarbela ini bos', '');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` varchar(8) NOT NULL,
  `tim` varchar(100) NOT NULL,
  `penanggung_jawab` varchar(50) NOT NULL,
  `asal` varchar(100) NOT NULL,
  `dibuat` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `tim`, `penanggung_jawab`, `asal`, `dibuat`) VALUES
('MBR01', 'Kambing FC', 'Rizal Ahmadi', 'Loker wah', '2022-07-11 14:57:28');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` varchar(8) NOT NULL,
  `username` varchar(46) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `hp` varchar(15) DEFAULT NULL,
  `email` varchar(46) DEFAULT NULL,
  `password` varchar(150) NOT NULL,
  `role` enum('admin','member') NOT NULL,
  `member` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `nama`, `hp`, `email`, `password`, `role`, `member`) VALUES
('aklnjga3', 'dev', NULL, NULL, NULL, '$2y$10$TOML6YsljL0FpHea.rBqwO6Q4CW1d/A5uRlUrY4IIguaQ5r1qx8ea', 'admin', NULL),
('cNzTfnL1', 'rizal_ahmad', 'Rizal Ahmadi', '0831428908123', 'rizal@m.com', '$2y$10$XN.kJHckufF/uyjp72xgresT9mKWfTbMwqqC.IqlrY6AT.wDlVice', 'member', 'MBR01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member` (`member`),
  ADD KEY `jadwal` (`jadwal`),
  ADD KEY `lapangan` (`lapangan`),
  ADD KEY `bukti_bayar` (`bukti_bayar`);

--
-- Indexes for table `file_upload`
--
ALTER TABLE `file_upload`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lapangan` (`lapangan`);

--
-- Indexes for table `lapangan`
--
ALTER TABLE `lapangan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member` (`member`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`member`) REFERENCES `member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`jadwal`) REFERENCES `jadwal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_ibfk_3` FOREIGN KEY (`lapangan`) REFERENCES `lapangan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_ibfk_4` FOREIGN KEY (`bukti_bayar`) REFERENCES `file_upload` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`lapangan`) REFERENCES `lapangan` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`member`) REFERENCES `member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
