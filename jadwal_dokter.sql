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
-- Table structure for table `jadwal_dokter`
--

CREATE TABLE `jadwal_dokter` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `hari` varchar(50) NOT NULL,
  `jam` varchar(50) NOT NULL,
  `Lokasi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal_dokter`
--

INSERT INTO `jadwal_dokter` (`id`, `name`, `hari`, `jam`, `Lokasi`) VALUES
(1, 'Dr. David Browner', 'Selasa', '10:00 - 13:00', 'Poli Bedah - Lantai 3'),
(2, 'Dr. David Browner', 'Kamis', '15:00 - 18:00', 'Poli Bedah - Lantai 3'),
(3, 'Dr. David Browner', 'Jumat', '08:30 - 11:30', 'Poli Bedah - Lantai 3'),
(4, 'Dr. Jasmine Cooper', 'Senin', '09:00 - 12:00', 'Poli Anak - Lantai 2'),
(5, 'Dr. Jasmine Cooper', 'Rabu', '13:00 - 16:00', 'Poli Anak - Lantai 2'),
(6, 'Dr. Jasmine Cooper', 'Jumat', '10:00 - 13:00', 'Poli Anak - Lantai 2'),
(7, 'Dr. Jennifer Clark', 'Selasa', '09:30 - 12:30', 'Poli Kandungan - Lantai 4'),
(8, 'Dr. Jennifer Clark', 'Kamis', '14:00 - 17:00', 'Poli Kandungan - Lantai 4'),
(9, 'Dr. Jennifer Clark', 'Minggu', '08:00 - 11:30', 'Poli Kandungan - Lantai 4'),
(10, 'Dr. Linda Davis', 'Senin', '10:00 - 13:00', 'Poli Kulit - Lantai 2'),
(11, 'Dr. Linda Davis', 'Kamis', '14:00 - 17:00', 'Poli Kulit - Lantai 2'),
(12, 'Dr. Linda Davis', 'Sabtu', '09:00 - 11:30', 'Poli Kulit - Lantai 2'),
(13, 'Dr. Michael Lee', 'Senin', '08:00 - 11:00', 'Poli Penyakit Dalam - Lantai 3'),
(14, 'Dr. Michael Lee', 'Rabu', '13:30 - 16:30', 'Poli Penyakit Dalam - Lantai 3'),
(15, 'Dr. Michael Lee', 'Sabtu', '09:00 - 12:00', 'Poli Penyakit Dalam - Lantai 3'),
(16, 'Dr. Sarah Williams', 'Selasa', '09:00 - 12:00', 'Poli THT - Lantai 1'),
(17, 'Dr. Sarah Williams', 'Jumat', '13:00 - 16:00', 'Poli THT - Lantai 1'),
(18, 'Dr. Sarah Williams', 'Minggu', '08:30 - 11:30', 'Poli THT - Lantai 1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jadwal_dokter`
--
ALTER TABLE `jadwal_dokter`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jadwal_dokter`
--
ALTER TABLE `jadwal_dokter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
