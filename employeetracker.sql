-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2019 at 06:08 PM
-- Server version: 10.1.39-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `employeetracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `departmentID` int(8) UNSIGNED NOT NULL,
  `departmentName` varchar(50) NOT NULL,
  `teamLeaderID` int(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `empID` int(8) UNSIGNED NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `userName` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `addressLine1` varchar(255) NOT NULL,
  `addressLine2` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `postCode` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` int(11) UNSIGNED NOT NULL,
  `sex` enum('M','F','NS') NOT NULL,
  `dateOfBirth` date NOT NULL,
  `designation` enum('Employee','Teamleader') NOT NULL,
  `dateOfEntry` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `emergencyContactName1` varchar(50) NOT NULL,
  `emergencyContactNo1` int(11) NOT NULL,
  `emergencyContactName2` varchar(50) DEFAULT NULL,
  `emergencyContactNo2` int(11) DEFAULT NULL,
  `departmentID` int(8) UNSIGNED NOT NULL,
  `teamLeaderID` int(8) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sitedetail`
--

CREATE TABLE `sitedetail` (
  `siteID` int(8) UNSIGNED NOT NULL,
  `siteName` varchar(100) NOT NULL,
  `siteSuburb` varchar(255) NOT NULL,
  `siteCity` varchar(30) NOT NULL,
  `siteState` varchar(30) NOT NULL,
  `siteLongitude` varchar(50) NOT NULL,
  `siteLatitude` varchar(50) NOT NULL,
  `siteContactPersonName` varchar(30) NOT NULL,
  `siteContactPersonNo` int(11) UNSIGNED NOT NULL,
  `siteCityPostcode` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `taskID` int(8) UNSIGNED NOT NULL,
  `taskName` varchar(50) NOT NULL,
  `taskDetail` varchar(255) NOT NULL,
  `empID` int(8) UNSIGNED NOT NULL,
  `teamLeaderID` int(8) UNSIGNED NOT NULL,
  `completionFlag` int(1) NOT NULL DEFAULT '0',
  `taskCreated` datetime NOT NULL,
  `taskCompleted` datetime DEFAULT NULL,
  `siteID` int(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`departmentID`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`empID`),
  ADD UNIQUE KEY `username` (`userName`),
  ADD KEY `dId_employee_department` (`departmentID`);

--
-- Indexes for table `sitedetail`
--
ALTER TABLE `sitedetail`
  ADD PRIMARY KEY (`siteID`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`taskID`),
  ADD KEY `siteId_task_sitedetail` (`siteID`),
  ADD KEY `empID_emp_task` (`empID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `departmentID` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `empID` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sitedetail`
--
ALTER TABLE `sitedetail`
  MODIFY `siteID` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `empId_tlId` FOREIGN KEY (`teamLeaderID`) REFERENCES `employee` (`empId`);

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `dId_employee_department` FOREIGN KEY (`departmentID`) REFERENCES `department` (`departmentID`),
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`empID`) REFERENCES `task` (`empID`),
  ADD CONSTRAINT `tlId_employee_teamLeader` FOREIGN KEY (`teamLeaderID`) REFERENCES `teamleader` (`teamLeaderID`);

--
-- Constraints for table `sitedetail`
--
ALTER TABLE `sitedetail`
  ADD CONSTRAINT `sitedetail_ibfk_1` FOREIGN KEY (`siteID`) REFERENCES `task` (`siteID`);

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `empID_emp_task` FOREIGN KEY (`empID`) REFERENCES `employee` (`empId`),
  ADD CONSTRAINT `siteId_task_sitedetail` FOREIGN KEY (`siteID`) REFERENCES `sitedetail` (`siteId`),
  ADD CONSTRAINT `teamLeaderID_task_teamLeader` FOREIGN KEY (`teamLeaderID`) REFERENCES `teamleader` (`teamLeaderID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
