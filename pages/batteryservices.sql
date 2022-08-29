-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2022 at 07:18 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u791252924_meeca`
--

-- --------------------------------------------------------

--
-- Table structure for table `batteryservices`
--

CREATE TABLE `batteryservices` (
  `BatteryServiceID` bigint(20) NOT NULL,
  `BatteryServiceTitle` varchar(219) COLLATE utf8mb4_unicode_ci NOT NULL,
  `BatteryServicePrice` int(11) NOT NULL,
  `BatteryServiceDescription` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `LastEditedon` datetime NOT NULL,
  `BatteryServiceStatus` int(11) NOT NULL DEFAULT 1,
  `DeletedOn` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `batteryservices`
--

INSERT INTO `batteryservices` (`BatteryServiceID`, `BatteryServiceTitle`, `BatteryServicePrice`, `BatteryServiceDescription`, `CreatedOn`, `LastEditedon`, `BatteryServiceStatus`, `DeletedOn`) VALUES
(1, 'demo1', 33, '0', '2022-08-12 19:52:59', '0000-00-00 00:00:00', 1, '2022-08-13 05:04:43'),
(2, 'demo124', 6754, 'demodesc224', '2022-08-13 04:47:08', '2022-08-13 10:23:49', 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `batteryservices`
--
ALTER TABLE `batteryservices`
  ADD PRIMARY KEY (`BatteryServiceID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `batteryservices`
--
ALTER TABLE `batteryservices`
  MODIFY `BatteryServiceID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
