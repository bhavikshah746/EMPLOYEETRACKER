-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 03, 2019 at 01:02 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

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

DROP TABLE IF EXISTS `department`;
CREATE TABLE IF NOT EXISTS `department` (
  `departmentID` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `departmentName` varchar(50) NOT NULL,
  `teamLeaderID` int(8) UNSIGNED NOT NULL,
  PRIMARY KEY (`departmentID`),
  KEY `empId_tlId` (`teamLeaderID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE IF NOT EXISTS `employee` (
  `empID` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
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
  `teamLeaderID` int(8) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`empID`),
  UNIQUE KEY `username` (`userName`),
  KEY `dId_employee_department` (`departmentID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sitedetail`
--

DROP TABLE IF EXISTS `sitedetail`;
CREATE TABLE IF NOT EXISTS `sitedetail` (
  `siteID` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `siteName` varchar(100) NOT NULL,
  `siteSuburb` varchar(255) NOT NULL,
  `siteCity` varchar(30) NOT NULL,
  `siteState` varchar(30) NOT NULL,
  `siteLongitude` varchar(50) NOT NULL,
  `siteLatitude` varchar(50) NOT NULL,
  `siteContactPersonName` varchar(30) NOT NULL,
  `siteContactPersonNo` int(11) UNSIGNED NOT NULL,
  `siteCityPostcode` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`siteID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

DROP TABLE IF EXISTS `task`;
CREATE TABLE IF NOT EXISTS `task` (
  `taskID` int(8) UNSIGNED NOT NULL,
  `taskName` varchar(50) NOT NULL,
  `taskDetail` varchar(255) NOT NULL,
  `empID` int(8) UNSIGNED NOT NULL,
  `teamLeaderID` int(8) UNSIGNED NOT NULL,
  `completionFlag` int(1) NOT NULL DEFAULT '0',
  `taskCreated` datetime NOT NULL,
  `taskCompleted` datetime DEFAULT NULL,
  `taskStarted` datetime NOT NULL,
  `siteID` int(8) UNSIGNED NOT NULL,
  PRIMARY KEY (`taskID`),
  KEY `siteId_task_sitedetail` (`siteID`),
  KEY `empID_emp_task` (`empID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `empId_tlId` FOREIGN KEY (`teamLeaderID`) REFERENCES `employee` (`empID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
