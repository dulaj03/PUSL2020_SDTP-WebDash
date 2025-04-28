-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2025 at 08:03 PM
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
-- Database: `air_quality_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `aqi_data`
--

CREATE TABLE `aqi_data` (
  `id` int(11) NOT NULL,
  `sensor_id` int(11) DEFAULT NULL,
  `aqi_value` int(11) DEFAULT NULL,
  `recorded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sensors`
--

CREATE TABLE `sensors` (
  `id` int(11) NOT NULL,
  `location_name` varchar(50) DEFAULT NULL,
  `latitude` decimal(10,6) DEFAULT NULL,
  `longitude` decimal(10,6) DEFAULT NULL,
  `aqi` int(11) DEFAULT NULL,
  `pm25` float DEFAULT NULL,
  `pm10` float DEFAULT NULL,
  `co` float DEFAULT NULL,
  `no2` float DEFAULT NULL,
  `so2` float DEFAULT NULL,
  `o3` float DEFAULT NULL,
  `temperature` float DEFAULT NULL,
  `humidity` float DEFAULT NULL,
  `status` varchar(10) DEFAULT 'active',
  `last_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sensors`
--

INSERT INTO `sensors` (`id`, `location_name`, `latitude`, `longitude`, `aqi`, `pm25`, `pm10`, `co`, `no2`, `so2`, `o3`, `temperature`, `humidity`, `status`, `last_updated`) VALUES
(1, 'Colombo', 6.913047, 79.848070, 82, 82, 0, 0, 0, 0, 0, 35, 49, 'active', '2025-04-27 15:06:22'),
(29, 'India', 30.735567, 76.775714, 68, 68, 43, 7, 6, 5, 67, 27.7, 16, 'active', '2025-04-27 15:06:22'),
(34, 'Chennai', 13.103600, 80.290900, 42, 42, 25, 3, 4, 4, 8, 33.5667, 69, 'active', '2025-04-27 15:06:23'),
(38, 'Tokyo', 35.641463, 139.698171, 65, 1, 18, 3, 6, 1, 64, 20.3, 47.9, 'active', '2025-04-27 15:06:25'),
(239, 'London', 51.507351, -0.127758, 104, 104, 37, 4, 20, 0, 8, 13.4, 77.2, 'active', '2025-04-27 15:06:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'Admin', '$2y$10$xfNjxqLKj6pf5oECpH8fA.zLBC/39qIGbyaMLOF205M.a9rlX10OG'),
(5, 'Dulaj', '$2y$10$7EU/01.xeGxWu21Om802JO5u8goEu7SLb1krZyG/NmsjeN/EDPW0q'),
(8, 'ddhewage', '$2y$10$pohO11itaRd2SjqijNV6s.Y1yEfJEEpJI6MixNDivwLoSm.LXWita');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aqi_data`
--
ALTER TABLE `aqi_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sensor_id` (`sensor_id`);

--
-- Indexes for table `sensors`
--
ALTER TABLE `sensors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `location_name` (`location_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aqi_data`
--
ALTER TABLE `aqi_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sensors`
--
ALTER TABLE `sensors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=450;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aqi_data`
--
ALTER TABLE `aqi_data`
  ADD CONSTRAINT `aqi_data_ibfk_1` FOREIGN KEY (`sensor_id`) REFERENCES `sensors` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
