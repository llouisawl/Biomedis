-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 03, 2024 at 08:15 PM
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
USE si_kesehatan;
--

-- --------------------------------------------------------

--
-- Table structure for table `medical_records`
--

CREATE TABLE `medical_records` (
  `id` int(11) NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `complaints` text NOT NULL,
  `diagnosis` text NOT NULL,
  `treatment` text NOT NULL,
  `doctor` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical_records`
--

INSERT INTO `medical_records` (`id`, `patient_name`, `dob`, `complaints`, `diagnosis`, `treatment`, `doctor`, `created_at`) VALUES
(1, 'Ahmad Santoso', '1985-04-15', 'Batuk berkepanjangan dan sesak nafas', 'Pneumonia', 'Antibiotik dan perawatan suportif', 'Dr. Sarah Williams', '2024-12-03 18:36:27'),
(2, 'Rina Pratiwi', '1992-07-20', 'Sakit kepala dan demam tinggi', 'Migrain dan demam virus', 'Obat pereda nyeri dan cairan elektrolit', 'Dr. Michael Lee', '2024-12-03 18:36:27'),
(3, 'Dewi Lestari', '1989-10-30', 'Nyeri sendi pada lutut dan punggung', 'Osteoarthritis', 'Penggunaan obat antiinflamasi non-steroid (NSAID) dan fisioterapi', 'Dr. David Brown', '2024-12-03 18:36:27'),
(4, 'Siti Mariani', '1978-03-22', 'Mual dan muntah terus-menerus', 'Gastritis', 'Penggunaan antasid dan diet khusus', 'Dr. Linda Davis', '2024-12-03 18:36:27'),
(5, 'Budi Setiawan', '2001-12-05', 'Sakit perut dan diare', 'Gastroenteritis', 'Obat antidiare dan hidrasi', 'Dr. Jennifer Clark', '2024-12-03 18:36:27'),
(6, 'Maya Sari', '1985-06-15', 'Batuk dan demam tinggi', 'Pneumonia', 'Obat antibiotik dan perawatan suportif', 'Dr. Indra', '2024-12-03 18:43:15'),
(7, 'Budi Santoso', '1990-04-22', 'Nyeri perut hebat', 'Apendisitis', 'Operasi pengangkatan usus buntu', 'Dr. Rina', '2024-12-03 18:43:15'),
(8, 'Siti Aminah', '1982-11-09', 'Mual dan muntah', 'Gastritis', 'Antasid dan diet khusus', 'Dr. Andri', '2024-12-03 18:43:15'),
(9, 'Ahmad Zulkarnain', '1978-02-17', 'Sakit kepala dan penglihatan kabur', 'Migrain', 'Obat pereda nyeri dan istirahat cukup', 'Dr. Fadil', '2024-12-03 18:43:15'),
(10, 'Rina Apriani', '1995-03-03', 'Nyeri punggung', 'Spondilosis', 'Fisioterapi dan obat anti-inflamasi', 'Dr. Zainal', '2024-12-03 18:43:15'),
(11, 'Eko Prasetyo', '2000-12-29', 'Sesak napas', 'Asthma', 'Inhaler dan kontrol rutin', 'Dr. Linda', '2024-12-03 18:43:15'),
(12, 'Lina Sofiana', '1992-08-14', 'Flu dan batuk', 'Flu biasa', 'Istirahat dan banyak minum air putih', 'Dr. Deni', '2024-12-03 18:43:15'),
(13, 'Joko Widodo', '1988-01-30', 'Kesemutan di tangan', 'Carpal Tunnel Syndrome', 'Fisioterapi dan obat pereda nyeri', 'Dr. Eka', '2024-12-03 18:43:15'),
(14, 'Fitri Lestari', '1998-07-12', 'Sakit gigi', 'Karies gigi', 'Perawatan gigi dan tambal gigi', 'Dr. Titi', '2024-12-03 18:43:15'),
(15, 'Agus Salim', '1975-05-20', 'Sesak napas berat', 'Emfisema', 'Obat bronkodilator dan oksigen terapi', 'Dr. Hendra', '2024-12-03 18:43:15'),
(16, 'Tina Amelia', '1993-10-05', 'Cegukan terus-menerus', 'Refluks asam lambung', 'Antasid dan perubahan pola makan', 'Dr. Arif', '2024-12-03 18:43:15'),
(17, 'Siska Kartika', '1989-09-18', 'Perut kembung dan nyeri', 'IBS (Irritable Bowel Syndrome)', 'Obat penenang perut dan diet rendah serat', 'Dr. Fina', '2024-12-03 18:43:15'),
(18, 'Anton Santosa', '1980-06-22', 'Sakit dada kiri', 'Angina', 'Obat pengencer darah dan perubahan gaya hidup', 'Dr. Ricky', '2024-12-03 18:43:15'),
(19, 'Hendrianto', '1979-11-30', 'Penurunan nafsu makan', 'Kanker Lambung', 'Kemoterapi dan pembedahan', 'Dr. Alex', '2024-12-03 18:43:15'),
(20, 'Tina Susanti', '1983-04-09', 'Kesemutan di kaki', 'Diabetes Mellitus', 'Insulin dan kontrol kadar gula darah', 'Dr. Jaya', '2024-12-03 18:43:15'),
(21, 'Martha Sari', '1996-02-02', 'Nyeri sendi', 'Osteoarthritis', 'Obat antiinflamasi non-steroid dan fisioterapi', 'Dr. Susilo', '2024-12-03 18:43:15'),
(22, 'Gilang Pratama', '2001-09-15', 'Demam tinggi', 'Influenza', 'Antivirus dan banyak istirahat', 'Dr. Wahyu', '2024-12-03 18:43:15'),
(23, 'Indah Wulandari', '1987-07-28', 'Pusing dan penglihatan kabur', 'Hipertensi', 'Obat penurun tekanan darah', 'Dr. Joko', '2024-12-03 18:43:15'),
(24, 'Nurul Fadhilah', '1994-01-16', 'Sakit tenggorokan', 'Tonsilitis', 'Obat pereda nyeri dan antibiotik', 'Dr. Hani', '2024-12-03 18:43:15'),
(25, 'Fajar Prabowo', '1981-10-22', 'Batuk berdarah', 'Tuberkulosis', 'Obat anti-TB dan perawatan rumah sakit', 'Dr. Kevin', '2024-12-03 18:43:15'),
(26, 'Desi Novita', '1991-03-28', 'Sakit kepala dan leher kaku', 'Leher kaku dan tegang', 'Obat penenang otot dan fisioterapi', 'Dr. Adit', '2024-12-03 18:43:15'),
(27, 'Dini Nurul', '1992-05-12', 'Demam dan ruam kulit', 'Campak', 'Perawatan suportif dan isolasi', 'Dr. Fawzi', '2024-12-03 18:43:15'),
(28, 'Beni Utama', '1990-07-20', 'Mual dan kehilangan nafsu makan', 'Hepatitis A', 'Rehidrasi dan perawatan suportif', 'Dr. Maya', '2024-12-03 18:43:15'),
(29, 'Ria Rahma', '1994-02-25', 'Sakit kepala migrain', 'Migrain kronis', 'Obat penghilang rasa sakit dan tidur cukup', 'Dr. Tito', '2024-12-03 18:43:15'),
(30, 'Reza Hermawan', '1988-09-10', 'Rasa lemas dan pusing', 'Anemia', 'Suplementasi zat besi dan makanan bergizi', 'Dr. Guntur', '2024-12-03 18:43:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `medical_records`
--
ALTER TABLE `medical_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
