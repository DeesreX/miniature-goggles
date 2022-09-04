-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 28, 2022 at 08:02 PM
-- Server version: 10.6.7-MariaDB-2ubuntu1.1
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `RextopiA`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(6) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$5sdhdF3clbNmp5KnvGr4p.HE6jFE1FxB6.Yy98UYbI0gb6QsiFdEO'),
(2, 'DeesreX', '$2y$10$obRf0HoXunTo2JpcTlcZ5uTEcjfqNL8b2oA7FhOSK5uSq2.xYSMpy'),
(3, 'Rex_Warrior', '$2y$10$hW4RrQLaG99.LMOsxjUb8.O0ZxoJL6or4HueybPD60dbEsgzkDlCq'),
(5, 'Rex_Archer', '$2y$10$21kGJ2fUklARZGPSOOuAr.njmWmrhUj5vDPdBDakkaNBHHOdjQzgu'),
(8, 'Rex_Mage', '$2y$10$D1hbsRDldLyOaNIl7SjzJuSC7bpm2Xokl9s0Kw0NqtrMh91Vt0TrW'),
(18, 'DeesreX2', '$2y$10$UDCdVG.LjL/XrPu6S5RII.DNccpJZagbybutzmTfDG9sk0hwnRE9e');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `constraint_name` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
