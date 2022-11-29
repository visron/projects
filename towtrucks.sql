-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2022 at 05:02 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `towtrucks`
--
CREATE DATABASE IF NOT EXISTS `towtrucks` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `towtrucks`;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `P_ID` int(11) NOT NULL,
  `P_NAME` varchar(50) NOT NULL,
  `P_DESC` varchar(100) NOT NULL,
  `P_STATUS` int(11) NOT NULL DEFAULT 1,
  `P_INITIATE_TIME` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`P_ID`, `P_NAME`, `P_DESC`, `P_STATUS`, `P_INITIATE_TIME`) VALUES
(1, 'KBZ 242A', 'Flatbed', 1, '2022-11-26 13:59:40'),
(2, 'KBA 122Q', 'Green Tow Truck', 1, '2022-11-26 14:09:17');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `ID` int(50) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Number` varchar(100) NOT NULL,
  `Pickup` varchar(50) NOT NULL,
  `Destination` varchar(50) NOT NULL,
  `Timestamp` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `Status` varchar(50) DEFAULT 'Pending',
  `is_active` int(11) DEFAULT 1,
  `customer_id` varchar(50) DEFAULT NULL,
  `admin_id` varchar(50) DEFAULT NULL,
  `admin_action_time` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`ID`, `Name`, `Number`, `Pickup`, `Destination`, `Timestamp`, `Status`, `is_active`, `customer_id`, `admin_id`, `admin_action_time`) VALUES
(1, 'Ken', '69', 'karen', 'jkuat', '2022-11-28 21:22:07.000000', 'Pending', 1, NULL, NULL, NULL),
(2, 'Ken', '69', 'juja - kikuyu', 'jkuat', '2022-11-28 21:22:34.000000', 'Pending', 1, NULL, NULL, NULL),
(3, 'Ken', '93', 'Tre', '/A', '2022-11-28 21:24:02.000000', 'Pending', 1, NULL, NULL, NULL),
(4, 'Ken', '93', 'Tre', '/A', '2022-11-28 21:28:39.000000', 'Pending', 1, NULL, NULL, NULL),
(5, 'System Testing', '012121212', 'Karen Jkuat rd', 'Rongai MMU rd', '2022-11-29 14:25:36.000000', 'Started', 1, NULL, NULL, NULL),
(6, 'System Test ', '0212122121', 'Karen 1', 'Destination 2', '2022-11-29 14:35:34.000000', 'Pending', 1, NULL, NULL, NULL),
(7, 'Rejected order', '03239023', 'Here', 'There', '2022-11-29 14:37:31.000000', 'Pending', 1, NULL, NULL, NULL),
(8, 'Testing 3', '93030392', 'karen2', 'Destination12', '2022-11-29 15:56:04.000000', 'Pending', 1, '13', NULL, NULL),
(9, 'Tesjn', '3923920309', 'Test Site 1', 'Test Site 2', '2022-11-29 15:59:28.000000', 'Pending', 1, '13', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `ST_ID` int(11) NOT NULL,
  `ST_NAME` varchar(11) NOT NULL,
  `ST_PROGRESS` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`ST_ID`, `ST_NAME`, `ST_PROGRESS`) VALUES
(1, 'Start', 25),
(2, 'Approved', 50),
(3, 'On Going', 75),
(4, 'Completed', 100);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `T_ID` int(11) NOT NULL,
  `T_NAME` varchar(70) NOT NULL,
  `T_PROGRESS` varchar(70) NOT NULL,
  `T_STATUS` int(11) DEFAULT 1,
  `T_DATE` timestamp NULL DEFAULT current_timestamp(),
  `P_ID` int(11) NOT NULL,
  `US_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`T_ID`, `T_NAME`, `T_PROGRESS`, `T_STATUS`, `T_DATE`, `P_ID`, `US_ID`) VALUES
(1, 'Ken', '69', 0, '2022-11-26 14:00:21', 1, 2),
(2, '312', '100', 3, '2022-11-26 14:11:48', 2, 1),
(3, 'AP', '100', 2, '2022-11-26 14:14:40', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `U_ID` int(11) NOT NULL,
  `U_NAME` varchar(70) NOT NULL,
  `U_EMAIL` varchar(70) NOT NULL,
  `U_PHONE` varchar(70) NOT NULL,
  `U_PASSWORD` varchar(70) DEFAULT '123456',
  `U_FNAME` varchar(70) NOT NULL,
  `U_STATUS` int(11) NOT NULL DEFAULT 1,
  `U_TYPE` varchar(20) NOT NULL DEFAULT 'CUSTOMER'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`U_ID`, `U_NAME`, `U_EMAIL`, `U_PHONE`, `U_PASSWORD`, `U_FNAME`, `U_STATUS`, `U_TYPE`) VALUES
(1, 'dav', 'fname@gmail.com', '0778189517', '123456', 'kip', 1, 'CUSTOMER'),
(2, 'davis', 'fname@gmail.com', '0778189517', '123456', 'kiptoo', 1, 'CUSTOMER'),
(3, 'Kiptoo', 'fname@gmail.com', '0778189517', '123456', 'Ronoh', 1, 'CUSTOMER'),
(4, 'king', 'fname@gmail.com', '0778189517', '123456', 'Davis', 1, 'CUSTOMER'),
(5, 'emporer', 'fname@gmail.com', '0778189517', '123456', 'Davis', 1, 'CUSTOMER'),
(6, 'itadmin', 'fname@gmail.com', '0778189517', '0ef35d4cd2027a1e54dac7c588f62792', 'itadmin', 1, 'customer'),
(7, 'Hr', 'fname@gmail.com', '0778189517', '123456', 'officer', 1, 'CUSTOMER'),
(8, 'procurement', 'fname@gmail.com', '0778189517', '123456', 'officer', 1, 'CUSTOMER'),
(11, '', '', '', '123456', '', 1, 'CUSTOMER'),
(12, 'admin', 'admin', '01212', '21232f297a57a5a743894a0e4a801fc3', 'admin', 1, 'admin'),
(13, 'customer', 'customer', '932320323', '91ec1f9324753048c0096d036a694f86', 'customer', 1, 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`P_ID`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`ST_ID`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`T_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`U_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `P_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `ID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `ST_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `T_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `U_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
