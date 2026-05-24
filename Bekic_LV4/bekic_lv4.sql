-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2026 at 05:24 PM
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
-- Database: `bekic_lv4`
--

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id` int(11) NOT NULL,
  `korisnicko_ime` varchar(100) NOT NULL,
  `lozinka` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `korisnicko_ime`, `lozinka`) VALUES
(1, 'ana', '$2y$10$ToAwLZEdGF1bciUnkdmPDuF/LpPUZv1UnYeh8tb6iGm5ZnAX7/EPq'),
(2, 'Marinela', '$2y$10$qWji.Or/saB/BB1rutZDQ.piG1I.IesYNXZhrW/Ne8ymLJ4Agfsxu'),
(3, 'XD', '$2y$10$7pEKP2.cYQoQaLhH7ypEtOHmDzJgAIEmTijhA4f4/D6ZYb5NBmi3u'),
(4, 'a', '$2y$10$HB238.Da/We74FnR.DAm3.EfMNnSdehuhqHsY6xjFCsgP13jLbAhK'),
(5, 's', '$2y$10$m9vTlHrsj5VgIzT4CqhJu.Vt66R8SBRYyl2g.XBXG.7oJK4wq9.Iu');

-- --------------------------------------------------------

--
-- Table structure for table `ocjene`
--

CREATE TABLE `ocjene` (
  `id` int(11) NOT NULL,
  `korisnik_id` int(11) NOT NULL,
  `slika_id` int(11) NOT NULL,
  `ocjena` int(11) NOT NULL,
  `vrijeme_ocjene` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ocjene`
--

INSERT INTO `ocjene` (`id`, `korisnik_id`, `slika_id`, `ocjena`, `vrijeme_ocjene`) VALUES
(1, 1, 1, 4, '2026-05-24 14:23:15'),
(2, 1, 2, 5, '2026-05-24 14:23:53'),
(3, 2, 1, 3, '2026-05-24 15:13:13'),
(4, 2, 2, 4, '2026-05-24 15:13:15'),
(5, 2, 3, 5, '2026-05-24 15:13:17');

-- --------------------------------------------------------

--
-- Table structure for table `pjesme`
--

CREATE TABLE `pjesme` (
  `id` int(11) NOT NULL,
  `naziv` varchar(150) NOT NULL,
  `izvodac` varchar(150) NOT NULL,
  `zanr` varchar(100) NOT NULL,
  `bpm` int(11) DEFAULT NULL,
  `godina` int(11) DEFAULT NULL,
  `popularnost` int(11) DEFAULT NULL,
  `raspolozenje` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pjesme`
--

INSERT INTO `pjesme` (`id`, `naziv`, `izvodac`, `zanr`, `bpm`, `godina`, `popularnost`, `raspolozenje`) VALUES
(1, 'Believer', 'Imagine Dragons', 'Rock', 125, 2017, 90, 'Energično'),
(2, 'I Was Made for Lovin’ You', 'Kiss', 'Rock', 125, 1979, 95, 'Sretno');

-- --------------------------------------------------------

--
-- Table structure for table `playlista`
--

CREATE TABLE `playlista` (
  `id` int(11) NOT NULL,
  `korisnik_id` int(11) NOT NULL,
  `pjesma_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `slike`
--

CREATE TABLE `slike` (
  `id` int(11) NOT NULL,
  `naziv_datoteke` varchar(255) NOT NULL,
  `putanja` varchar(255) NOT NULL,
  `opis` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slike`
--

INSERT INTO `slike` (`id`, `naziv_datoteke`, `putanja`, `opis`) VALUES
(1, 'img1.jpg', 'images/img1.jpg', 'Prva slika'),
(2, 'img2.jpg', 'images/img2.jpg', 'Druga slika'),
(3, 'img3.jpg', 'images/img3.jpg', 'Treća slika');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `korisnicko_ime` (`korisnicko_ime`);

--
-- Indexes for table `ocjene`
--
ALTER TABLE `ocjene`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `korisnik_id` (`korisnik_id`,`slika_id`),
  ADD KEY `slika_id` (`slika_id`);

--
-- Indexes for table `pjesme`
--
ALTER TABLE `pjesme`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playlista`
--
ALTER TABLE `playlista`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `korisnik_id` (`korisnik_id`,`pjesma_id`),
  ADD KEY `pjesma_id` (`pjesma_id`);

--
-- Indexes for table `slike`
--
ALTER TABLE `slike`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ocjene`
--
ALTER TABLE `ocjene`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pjesme`
--
ALTER TABLE `pjesme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `playlista`
--
ALTER TABLE `playlista`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `slike`
--
ALTER TABLE `slike`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ocjene`
--
ALTER TABLE `ocjene`
  ADD CONSTRAINT `ocjene_ibfk_1` FOREIGN KEY (`korisnik_id`) REFERENCES `korisnici` (`id`),
  ADD CONSTRAINT `ocjene_ibfk_2` FOREIGN KEY (`slika_id`) REFERENCES `slike` (`id`);

--
-- Constraints for table `playlista`
--
ALTER TABLE `playlista`
  ADD CONSTRAINT `playlista_ibfk_1` FOREIGN KEY (`korisnik_id`) REFERENCES `korisnici` (`id`),
  ADD CONSTRAINT `playlista_ibfk_2` FOREIGN KEY (`pjesma_id`) REFERENCES `pjesme` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
