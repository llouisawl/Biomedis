-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 08, 2024 at 02:43 PM
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
-- Database: `si_kesehatan`
--

-- --------------------------------------------------------

--
-- Table structure for table `queue`
--

CREATE TABLE `queue` (
  `id` int(11) NOT NULL,
  `poli` varchar(50) NOT NULL,
  `dokter` varchar(50) NOT NULL,
  `nomor_antrian` int(11) NOT NULL,
  `waktu_antrian` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `queue`
--

INSERT INTO `queue` (`id`, `poli`, `dokter`, `nomor_antrian`, `waktu_antrian`) VALUES
(8, 'poli_bedah', 'Dr. David Brown - Spesialis Bedah Ortopedi', 1, '2024-12-04 01:38:46'),
(9, 'poli_bedah', 'Dr. David Brown - Spesialis Bedah Ortopedi', 2, '2024-12-04 01:38:47'),
(10, 'poli_bedah', 'Dr. David Brown - Spesialis Bedah Ortopedi', 3, '2024-12-04 01:38:48'),
(11, 'poli_tht', 'Dr. Sarah Williams - Spesialis THT', 1, '2024-12-04 03:12:31'),
(12, 'poli_tht', 'Dr. Sarah Williams - Spesialis THT', 2, '2024-12-04 03:12:34'),
(13, 'poli_tht', 'Dr. Sarah Williams - Spesialis THT', 3, '2024-12-04 03:12:37'),
(14, 'poli_kulit_dan_kelamin', 'Dr. Linda Davis - Spesialis Dermatologi', 1, '2024-12-04 03:13:35'),
(15, 'poli_kulit_dan_kelamin', 'Dr. Linda Davis - Spesialis Dermatologi', 2, '2024-12-04 03:13:39'),
(16, 'poli_kulit_dan_kelamin', 'Dr. Linda Davis - Spesialis Dermatologi', 3, '2024-12-04 03:13:41'),
(17, 'poli_kulit_dan_kelamin', 'Dr. Linda Davis - Spesialis Dermatologi', 4, '2024-12-04 03:13:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `queue`
--
ALTER TABLE `queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
