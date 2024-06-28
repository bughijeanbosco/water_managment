-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2024 at 08:16 PM
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
-- Table structure for table `alerts`
--

CREATE TABLE `alerts` (
  `alert_id` int(11) NOT NULL,
  `tank_id` int(11) NOT NULL,
  `alert_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `alert_type` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `alerts`
--

INSERT INTO `alerts` (`alert_id`, `tank_id`, `alert_time`, `alert_type`, `status`) VALUES
(1, 3, '2024-06-27 17:13:43', 'Low Level Alert', 'Active'),
(2, 7, '2024-06-27 17:04:43', 'Critical Alert', 'Cleared'),
(3, 5, '2024-06-27 17:14:43', 'Low Level Alert', 'Active'),
(4, 9, '2024-06-27 17:33:43', 'Critical Alert', 'Cleared'),
(5, 6, '2024-06-27 17:32:43', 'High Level Alert', 'Cleared'),
(6, 4, '2024-06-27 17:29:43', 'Critical Alert', 'Cleared'),
(7, 2, '2024-06-27 17:20:43', 'Low Level Alert', 'Cleared'),
(8, 1, '2024-06-27 17:23:43', 'Critical Alert', 'Cleared'),
(9, 8, '2024-06-27 17:06:43', 'Critical Alert', 'Cleared');

-- --------------------------------------------------------

--
-- Table structure for table `sensors`
--

CREATE TABLE `sensors` (
  `sensor_id` int(11) NOT NULL,
  `tank_id` int(11) NOT NULL,
  `sensor_type` varchar(50) NOT NULL,
  `install_date` date NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sensors`
--

INSERT INTO `sensors` (`sensor_id`, `tank_id`, `sensor_type`, `install_date`, `status`) VALUES
(1, 3, 'ultrasonic', '2024-06-04', 'FULL'),
(2, 1, 'ultrasonic', '2024-06-04', 'not full'),
(3, 8, 'Temperature', '2024-06-08', 'Active'),
(4, 5, 'Temperature', '2024-06-09', 'Active'),
(5, 1, 'Temperature', '2024-04-20', 'Inactive'),
(6, 6, 'Pressure', '2023-07-19', 'Active'),
(7, 9, 'Flow', '2024-06-22', 'Inactive'),
(8, 2, 'Pressure', '2024-03-05', 'Inactive'),
(9, 3, 'Pressure', '2024-06-18', 'Active'),
(10, 7, 'Flow', '2024-05-02', 'Inactive'),
(11, 4, 'Flow', '2023-08-28', 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `tanks`
--

CREATE TABLE `tanks` (
  `tank_id` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `capacity` int(11) NOT NULL,
  `install_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tanks`
--

INSERT INTO `tanks` (`tank_id`, `location`, `capacity`, `install_date`) VALUES
(1, 'kimihurura', 250, '2024-06-04'),
(2, 'kimironko', 250, '2024-06-27'),
(3, 'kabuga', 250, '2024-06-27'),
(4, 'kicukiro', 3000, '2024-06-26'),
(5, 'Location 1', 661, '2023-10-30'),
(6, 'Location 2', 329, '2023-10-31'),
(7, 'Location 3', 301, '2023-12-15'),
(8, 'Location 4', 768, '2024-04-01'),
(9, 'Location 5', 889, '2023-10-05');

-- --------------------------------------------------------

--
-- Table structure for table `usagelogs`
--

CREATE TABLE `usagelogs` (
  `log_id` int(11) NOT NULL,
  `tank_id` int(11) NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `usage_amount` int(11) NOT NULL,
  `remaining_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usagelogs`
--

INSERT INTO `usagelogs` (`log_id`, `tank_id`, `log_time`, `usage_amount`, `remaining_level`) VALUES
(1, 8, '2024-06-23 17:34:24', 83, 230),
(2, 4, '2024-06-22 17:34:24', 13, 211),
(3, 7, '2024-06-25 17:34:24', 27, 84),
(4, 1, '2024-06-26 17:34:24', 74, 494),
(5, 3, '2024-06-26 17:34:24', 62, 206),
(6, 2, '2024-06-24 17:34:24', 46, 389),
(7, 5, '2024-06-25 17:34:24', 59, 456),
(8, 6, '2024-06-26 17:34:24', 48, 471),
(9, 9, '2024-06-24 17:34:24', 46, 305);

-- --------------------------------------------------------

--
-- Table structure for table `waterlevels`
--

CREATE TABLE `waterlevels` (
  `reading_id` int(11) NOT NULL,
  `sensor_id` int(11) NOT NULL,
  `reading_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `water_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `waterlevels`
--

INSERT INTO `waterlevels` (`reading_id`, `sensor_id`, `reading_time`, `water_level`) VALUES
(1, 2, '2024-06-27 17:07:54', 1),
(2, 2, '2024-06-26 17:08:26', 2),
(3, 4, '2024-06-24 17:32:33', 75),
(4, 6, '2024-06-27 17:32:33', 7),
(5, 8, '2024-06-27 17:32:33', 29),
(6, 9, '2024-06-24 17:32:33', 45),
(7, 1, '2024-06-27 17:32:33', 64),
(8, 10, '2024-06-21 17:32:33', 69),
(9, 7, '2024-06-22 17:32:33', 21),
(10, 5, '2024-06-22 17:32:33', 7),
(11, 11, '2024-06-22 17:32:33', 84),
(12, 3, '2024-06-26 17:32:33', 66),
(13, 2, '2024-06-23 17:32:33', 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`alert_id`),
  ADD KEY `tank_id` (`tank_id`);

--
-- Indexes for table `sensors`
--
ALTER TABLE `sensors`
  ADD PRIMARY KEY (`sensor_id`),
  ADD KEY `tank_id` (`tank_id`);

--
-- Indexes for table `tanks`
--
ALTER TABLE `tanks`
  ADD PRIMARY KEY (`tank_id`);

--
-- Indexes for table `usagelogs`
--
ALTER TABLE `usagelogs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `tank_id` (`tank_id`);

--
-- Indexes for table `waterlevels`
--
ALTER TABLE `waterlevels`
  ADD PRIMARY KEY (`reading_id`),
  ADD KEY `sensor_id` (`sensor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `alert_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sensors`
--
ALTER TABLE `sensors`
  MODIFY `sensor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tanks`
--
ALTER TABLE `tanks`
  MODIFY `tank_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `usagelogs`
--
ALTER TABLE `usagelogs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `waterlevels`
--
ALTER TABLE `waterlevels`
  MODIFY `reading_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alerts`
--
ALTER TABLE `alerts`
  ADD CONSTRAINT `alerts_ibfk_1` FOREIGN KEY (`tank_id`) REFERENCES `tanks` (`tank_id`);

--
-- Constraints for table `sensors`
--
ALTER TABLE `sensors`
  ADD CONSTRAINT `sensors_ibfk_1` FOREIGN KEY (`tank_id`) REFERENCES `tanks` (`tank_id`);

--
-- Constraints for table `usagelogs`
--
ALTER TABLE `usagelogs`
  ADD CONSTRAINT `usagelogs_ibfk_1` FOREIGN KEY (`tank_id`) REFERENCES `tanks` (`tank_id`);

--
-- Constraints for table `waterlevels`
--
ALTER TABLE `waterlevels`
  ADD CONSTRAINT `waterlevels_ibfk_1` FOREIGN KEY (`sensor_id`) REFERENCES `sensors` (`sensor_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
