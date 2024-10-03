-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2024 at 05:28 AM
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
-- Database: `mrbs2`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_ID` int(11) NOT NULL,
  `booking_Title` varchar(50) NOT NULL,
  `booking_AllDay` int(1) NOT NULL,
  `booking_Date` varchar(30) NOT NULL,
  `booking_Time` varchar(100) DEFAULT NULL,
  `booking_Status` int(1) NOT NULL,
  `room_ID` int(11) NOT NULL,
  `staff_ID` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_ID`, `booking_Title`, `booking_AllDay`, `booking_Date`, `booking_Time`, `booking_Status`, `room_ID`, `staff_ID`) VALUES
(1, 'Event 1', 0, '2024-08-17', '09:30-10:00', 1, 1, 'HL00176'),
(2, 'All Day Event', 1, '2024-08-18', '', 1, 2, 'HL00176'),
(3, 'Event 3', 0, '2024-08-17', '10:30-12:30', 1, 1, 'HL00176'),
(4, 'Event 4', 0, '2024-08-17', '12:30-13:00', 1, 1, 'HL00176'),
(5, 'Event 5', 0, '2024-08-17', '14:00-15:00', 1, 1, 'HL00176'),
(6, 'Event 6', 0, '2024-08-17', '15:30-16:00', 1, 2, 'HL00176'),
(7, 'Event 7', 0, '2024-08-19', '09:00-12:00', 1, 2, 'HL00176'),
(8, 'Event 8', 0, '2024-08-19', '13:00-14:00', 1, 1, 'HL00176'),
(9, 'Long event', 1, '2024-08-20', '', 1, 1, 'HL00176'),
(10, 'Event 9', 0, '2024-08-21', '08:00-08:30', 1, 1, 'HL00176'),
(11, 'Event 10', 0, '2024-08-21', '08:00-08:30', 1, 2, 'HL00176'),
(12, 'Event 11', 0, '2024-08-15', '12:00-13:00', 1, 1, 'HL00176'),
(13, 'Event 12', 0, '2024-08-15', '12:00-13:00', 1, 2, 'HL00176'),
(14, 'Event 13', 0, '2024-08-14', '07:30-08:30', 1, 2, 'HL00176'),
(15, 'Event 14', 0, '2024-08-14', '08:30-09:30', 1, 1, 'HL00176'),
(16, 'Event 15', 1, '2024-08-16', '', 1, 1, 'HL00176'),
(17, 'Event 16', 1, '2024-08-20', '', 1, 2, 'HL00176'),
(18, '1', 0, '2024-08-22', '07:00-07:30', 1, 1, 'HL00176'),
(19, '2', 0, '2024-08-22', '07:30-08:00', 1, 1, 'HL00176'),
(20, '3', 0, '2024-08-22', '08:30-09:00', 1, 2, 'HL00176'),
(21, '4', 0, '2024-08-22', '09:00-09:30', 1, 2, 'HL00176'),
(22, 'test 2', 0, '2024-08-22', '08:00-09:30', 1, 1, 'HL00176'),
(23, 'test 2', 0, '2024-08-22', '08:00-09:30', 1, 1, 'HL00176'),
(24, '55', 0, '2024-08-22', '09:30-10:00', 1, 1, 'HL00176'),
(25, '66', 0, '2024-08-22', '09:30-10:00', 1, 2, 'HL00176'),
(26, '66', 0, '2024-08-22', '10:00-10:30', 1, 1, 'HL00176'),
(27, '34', 0, '2024-08-22', '10:30-11:00', 1, 1, 'HL00176'),
(28, '788', 0, '2024-08-22', '10:30-11:00', 1, 2, 'HL00176');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_ID` int(11) NOT NULL,
  `room_Name` varchar(50) NOT NULL,
  `room_Capacity` int(11) NOT NULL,
  `room_Area` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_ID`, `room_Name`, `room_Capacity`, `room_Area`) VALUES
(1, 'Room 1', 10, 'Admin Office'),
(2, 'Room 2', 8, 'Rest Area');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_ID` varchar(10) NOT NULL,
  `staff_Name` varchar(50) NOT NULL,
  `staff_Email` varchar(50) NOT NULL,
  `staff_Password` varchar(200) NOT NULL,
  `staff_Department` varchar(50) NOT NULL,
  `admin_Access` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_ID`, `staff_Name`, `staff_Email`, `staff_Password`, `staff_Department`, `admin_Access`) VALUES
('', '', '', '$2y$10$iALY6SZFE9YD/BRizev2peYHA97Aw2w4DiGZfK0FYdNvl2SaFVyFq', '', 0),
('HL00176', 'DIN', 'izzudin.zakri@hlma.com.my', '$2y$10$NNAsXHu7oHcbZ5XIo5e41Ovp5W5u0yxteDBXTJobpNWHjyhEqmBGW', 'IT', 1),
('test1', 'test1', 'test1@gmail.com', '$2y$10$/1.M.r5VsiieWlA3HMWsV.GH/z/en3bdF.1bF.5x63NHDyEiicezK', 'HRGA', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_ID`),
  ADD KEY `room_ID` (`room_ID`,`staff_ID`),
  ADD KEY `staff_ID` (`staff_ID`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_ID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`staff_ID`) REFERENCES `staff` (`staff_ID`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`room_ID`) REFERENCES `room` (`room_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
