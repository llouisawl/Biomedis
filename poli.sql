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
-- Table structure for table `poli`
--

CREATE TABLE `poli` (
  `id` int(11) NOT NULL,
  `nama_poli` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `poli`
--

INSERT INTO `poli` (`id`, `nama_poli`, `description`) VALUES
(1, 'Poli Gigi dan Mulut', 'Poli Gigi dan Mulut menyediakan layanan pemeriksaan, perawatan, dan tindakan gigi, termasuk pencabutan gigi dan perawatan gigi berlubang'),
(2, 'Poli Anak', 'Poli Anak menawarkan pelayanan kesehatan menyeluruh untuk bayi dan anak usia hingga 12 tahun. Dengan tenaga medis berpengalaman serta fasilitas modern, kami berkomitmen untuk menjaga kesehatan buah hati Anda.'),
(3, 'Poli Kandungan', 'Poli Kandungan memberikan layanan konsultasi, pemeriksaan rutin, dan tindakan medis terkait kehamilan dan masalah kesehatan wanita lainnya Anda.'),
(4, 'Poli Bedah', 'Poli Bedah menyediakan layanan konsultasi dan tindakan bedah, termasuk bedah minor dan mayor, yang dilakukan oleh tim dokter berpengalaman.'),
(5, 'Poli Jantung', 'Poli Jantung memberikan pelayanan untuk mendiagnosis dan mengelola berbagai gangguan kardiovaskular, seperti hipertensi, aritmia, penyakit jantung koroner, dan gagal jantung.'),
(6, 'Poli THT', 'Poli THT memberikan pelayanan untuk diagnosis dan perawatan berbagai keluhan serta penyakit pada telinga, hidung, dan tenggorokan, termasuk gangguan pendengaran, sinusitis, serta infeksi tenggorokan.'),
(7, 'Poli Kulit dan Kelamin', 'Poli Kulit dan Kelamin memberikan pelayanan untuk diagnosis dan perawatan penyakit kulit, kelamin, dan keluhan terkait kulit lainnya.'),
(8, 'Poli Penyakit Dalam', 'Poli Penyakit Dalam menyediakan layanan untuk diagnosis, pengobatan, dan pencegahan berbagai penyakit pada organ dalam, seperti gangguan pencernaan, penyakit hati, ginjal, diabetes, dan hipertensi.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `poli`
--
ALTER TABLE `poli`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`nama_poli`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `poli`
--
ALTER TABLE `poli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
