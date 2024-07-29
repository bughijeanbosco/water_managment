-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2024 at 01:40 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smartwatermanagement2`
--

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expiry` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `expiry`) VALUES
(1, 'bugiruwendaj@gmail.com', 'f91fae363a120c4565517f7a79a8bc11c1343167768741191cdaee599160025f2611086466e5ec674cb43f03018dbb1cd4ec', '2024-07-24 13:40:08'),
(2, 'bugiruwendaj@gmail.com', '526bf85568ad173a51890a4d1871cbd9c9e4b7f9e0bf8e003d2b3985fbc0f6c4da71006970e1398da0edb8ed11dc1c6fce50', '2024-07-24 14:15:40'),
(3, 'bugiruwendaj@gmail.com', 'd9872762910f4c8f4145ae18e0029c259f019523805da33ccf1dda6e74d083410e6f705f875126478a0847d263c7fced8182', '2024-07-24 14:51:59'),
(4, 'bugiruwendaj@gmail.com', '1de1348f1c4fd31f3a8b61c1c6824ea6f011af69f0c28524766729792debb53f55130bfca27e9ac5e5f02aaf7974fb194070', '2024-07-24 15:10:32'),
(5, 'bugiruwendaj@gmail.com', 'fa9853d4221b595af1dfa09a24fd1212d64e017981b36a73e362f0b4e76f69fc524f665752b9b6f9ab3f42b6ef11f230a343', '2024-07-24 15:35:57'),
(6, 'bugiruwendaj@gmail.com', '19eb433197236936e4c472de6b193eb871c0978d191eee9bd09abffa35cde20ef22334130cf8e6812a28719d14a9356e8199', '2024-07-24 15:45:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `first_name`, `last_name`, `phone_number`, `reset_token`, `reset_expires_at`) VALUES
(1, 'bughi123', 'Bughi@123', 'bugiruwendaj@gmail.com', 'Jean Bosco', 'BUGHI', '0785765091', NULL, NULL),
(2, '123', '123', 'bugiruwendaj@gmail.com', 'Jean Bosco', 'BUGIRUWENDA', '0785765091', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `water_level`
--

CREATE TABLE `water_level` (
  `id` int(20) NOT NULL,
  `tank_id` int(11) NOT NULL,
  `location` varchar(250) NOT NULL,
  `water_level` int(11) NOT NULL,
  `reading_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `water_level`
--
ALTER TABLE `water_level`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `water_level`
--
ALTER TABLE `water_level`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
