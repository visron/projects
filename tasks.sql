-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 11, 2019 at 12:20 AM
-- Server version: 5.6.35
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tasks`
--

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `P_ID` int(11) NOT NULL,
  `P_NAME` varchar(50) NOT NULL,
  `P_DESC` varchar(100) NOT NULL,
  `P_STATUS` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`P_ID`, `P_NAME`, `P_DESC`, `P_STATUS`) VALUES
(1, 'New Website', 'Coming up with website for our Company', 1);

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
  `T_STATUS` int(11) NOT NULL DEFAULT '1',
  `T_DATE` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `P_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`T_ID`, `T_NAME`, `T_PROGRESS`, `T_STATUS`, `T_DATE`, `P_ID`) VALUES
(1, 'Find Design', '1', 1, '2019-11-10 21:57:20', 1),
(2, 'Do Market Research', '100', 0, '2019-11-10 23:06:16', 1),
(3, 'Do Market Research', '100', 0, '2019-11-10 23:07:03', 1),
(4, 'Market Research', '100', 1, '2019-11-10 23:07:23', 2);

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
  `U_STATUS` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`U_ID`, `U_NAME`, `U_EMAIL`, `U_PHONE`, `U_PASSWORD`, `U_FNAME`, `U_STATUS`) VALUES
(1, 'dav', 'fname@gmail.com', '0778189517', '123456', 'kip', 1),
(2, 'davis', 'fname@gmail.com', '0778189517', '123456', 'kiptoo', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`P_ID`);

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
  MODIFY `P_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `ST_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `T_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `U_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
