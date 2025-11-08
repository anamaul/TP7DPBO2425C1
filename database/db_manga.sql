-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2025 at 03:10 AM
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
-- Database: `db_manga`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `author_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`author_id`, `name`, `bio`) VALUES
(1, 'Eiichiro Oda', 'Mangaka asal Jepang yang terkenal dengan karya One Piece.'),
(2, 'Masashi Kishimoto', 'Pencipta manga populer Naruto dan Samurai 8.'),
(3, 'Hajime Isayama', 'Penulis dan ilustrator Attack on Titan.'),
(4, 'Kohei Horikoshi', 'Mangaka di balik My Hero Academia.'),
(5, 'Tite Kubo', 'Dikenal sebagai pencipta Bleach.'),
(7, 'Haruichi Furudate', 'Seorang author dari manga Haikyuu');

-- --------------------------------------------------------

--
-- Table structure for table `chapter`
--

CREATE TABLE `chapter` (
  `chapter_id` int(11) NOT NULL,
  `manga_id` int(11) NOT NULL,
  `chapter_number` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chapter`
--

INSERT INTO `chapter` (`chapter_id`, `manga_id`, `chapter_number`, `title`) VALUES
(1, 1, 1, 'Romance Dawn'),
(2, 1, 2, 'They Call Him Straw Hat Luffy'),
(3, 1, 3, 'Enter Zoro: Pirate Hunter'),
(4, 2, 1, 'Uzumaki Naruto!!'),
(5, 2, 2, 'Konohamaru!!'),
(6, 2, 3, 'Uchiha Sasuke!!'),
(7, 3, 1, 'To You, 2000 Years From Now'),
(8, 3, 2, 'That Day'),
(9, 3, 3, 'Night of the Disbanding Ceremony'),
(10, 4, 1, 'Izuku Midoriya: Origin'),
(11, 4, 2, 'Roaring Muscles'),
(12, 4, 3, 'Start Line'),
(13, 5, 1, 'Death and Strawberry'),
(14, 5, 2, 'Starter'),
(15, 5, 3, 'Headhittin’');

-- --------------------------------------------------------

--
-- Table structure for table `manga`
--

CREATE TABLE `manga` (
  `manga_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `genre` varchar(255) DEFAULT NULL,
  `year` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manga`
--

INSERT INTO `manga` (`manga_id`, `title`, `author_id`, `genre`, `year`) VALUES
(1, 'One Piece', 1, 'Action, Adventure, Fantasy', '1997'),
(2, 'Naruto', 2, 'Action, Adventure, Martial Arts', '1999'),
(3, 'Attack on Titan', 3, 'Action, Drama, Fantasy', '2009'),
(4, 'My Hero Academia', 4, 'Action, Superhero, School Life', '2014'),
(5, 'Bleach', 5, 'Action, Supernatural, Adventure', '2001'),
(7, 'Haikyuu', 7, 'Sports', '2000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`author_id`);

--
-- Indexes for table `chapter`
--
ALTER TABLE `chapter`
  ADD PRIMARY KEY (`chapter_id`),
  ADD KEY `manga_id` (`manga_id`);

--
-- Indexes for table `manga`
--
ALTER TABLE `manga`
  ADD PRIMARY KEY (`manga_id`),
  ADD KEY `author_id` (`author_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `author_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `chapter`
--
ALTER TABLE `chapter`
  MODIFY `chapter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `manga`
--
ALTER TABLE `manga`
  MODIFY `manga_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chapter`
--
ALTER TABLE `chapter`
  ADD CONSTRAINT `chapter_ibfk_1` FOREIGN KEY (`manga_id`) REFERENCES `manga` (`manga_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `manga`
--
ALTER TABLE `manga`
  ADD CONSTRAINT `manga_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `author` (`author_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
