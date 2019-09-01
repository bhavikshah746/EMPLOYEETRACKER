-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 01, 2019 at 05:15 AM
-- Server version: 5.6.40-84.0-log
-- PHP Version: 7.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ictatjcu_emptrack`
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

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`departmentID`, `departmentName`, `teamLeaderID`) VALUES
(7001, 'Sales', 2),
(7002, 'Installation', 3),
(7003, 'Service', 4),
(7004, 'Payments', 6),
(7005, 'STC', 5);

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
  `address 1` varchar(255) NOT NULL,
  `address 2` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `postCode` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` int(11) UNSIGNED NOT NULL,
  `sex` enum('M','F','NS') NOT NULL,
  `dateOfBirth` date NOT NULL,
  `designation` enum('Employee','Team Leader','Admin') NOT NULL,
  `dateOfJoining` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `emergencyContactName1` varchar(50) NOT NULL,
  `emergencyContactNo1` int(11) NOT NULL,
  `emergencyContactName2` varchar(50) DEFAULT NULL,
  `emergencyContactNo2` int(11) DEFAULT NULL,
  `departmentID` int(8) UNSIGNED NOT NULL,
  `teamLeaderID` int(8) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`empID`, `firstName`, `lastName`, `userName`, `password`, `address 1`, `address 2`, `city`, `postCode`, `email`, `mobile`, `sex`, `dateOfBirth`, `designation`, `dateOfJoining`, `emergencyContactName1`, `emergencyContactNo1`, `emergencyContactName2`, `emergencyContactNo2`, `departmentID`, `teamLeaderID`) VALUES
(1, 'Bhavik', 'Shah', 'bhavikshah', 'Bhavik123', 'Lawrence Cl', 'Robertson', 'Brisbane', 4109, 'bhavikshah@yahoo.com', 403890376, 'M', '2015-07-13', 'Admin', '2019-09-01 09:46:42', 'Chintan', 403861483, NULL, NULL, 0, 0),
(2, 'nish', 'Acharya', 'nishacharya', 'Nish123', '32/351 Troughton Road', 'Coopers Plains', 'Brisbane', 4108, 'nishacharya@gmail.com', 405387951, 'M', '1990-08-20', 'Team Leader', '2019-09-01 09:58:36', 'Chintan', 403861483, NULL, NULL, 0, NULL),
(3, 'Perry', 'Surya', 'perrysurya', 'Perry123', '37 Darwin Street', 'North Lakes', 'Brisbane', 4509, 'carmenblakney@gmail.com', 434085061, 'M', '1988-09-05', 'Team Leader', '2019-09-01 09:58:13', 'carmen', 456852235, 'blankey', 456852654, 7002, NULL),
(4, 'glen', 'watson', 'glenwatson', 'glen123', '52/9 falso place', 'doolandella', 'brisbane', 4077, 'glen.watson@gmail.com', 403878789, 'M', '0000-00-00', 'Team Leader', '2019-09-01 09:58:20', 'Joy Dave', 405852654, 'David Williams', 432841369, 7003, NULL),
(5, 'Nash', 'Williams', 'nashwilliams', 'Nash123', '42 Portree Crescent', 'Heathwood', 'Brisbane', 4110, 'nashwilliams@gmail.com', 416120777, 'M', '0000-00-00', 'Team Leader', '2018-08-08 00:29:17', 'Joy Dave', 404585753, 'Nish', 456789321, 7005, NULL),
(6, 'Bruce', 'Pandya', 'brucepandya', 'Bruce123', '53 Woodline Drive', 'Spring Mountain', 'Brisbane', 4300, 'brucepandya@gmail.com', 447950428, 'M', '1989-09-10', 'Team Leader', '2019-07-17 00:41:16', 'David Williams', 40465479, NULL, NULL, 7004, NULL),
(7, 'Carter', 'Lewis', 'carterlewis', 'Carter123', '303 Turton Street', 'Sunnybank', 'Brisbane', 4109, 'carterlewis@gmail.com', 403851526, 'M', '1992-07-13', 'Employee', '2019-08-17 02:10:24', 'Jerry', 466878900, NULL, NULL, 7001, NULL),
(8, 'Dax', 'Darji', 'daxdarji', 'Dax123', '54 Killara blvd', 'Logan Reserve', 'Logan', 4133, 'daxdarji@gmail.com', 410952655, 'M', '1985-04-20', 'Employee', '2019-08-10 02:29:10', 'Joy Dave', 403654123, NULL, NULL, 7005, NULL),
(9, 'Martin', 'darc', 'martindarc', 'Martin123', '38 Leapai Parade', 'Griffin', 'Brisbane', 4503, 'martindarc@gmail.com', 403658045, 'M', '1989-08-13', 'Employee', '2019-08-02 03:15:19', 'carmen', 405852654, 'blankey', 456789741, 7002, NULL),
(10, 'Pat', 'White', 'patwhite', 'Pat123', '26 Margaret Street', 'SilkStone', 'Brisbane', 4304, 'patwhite@gmail.com', 423415315, 'M', '1985-09-09', 'Employee', '2019-08-15 01:18:35', 'David', 456987423, 'Joanna', 423654789, 7003, NULL),
(11, 'Daisy', 'dalwadi', 'daisydalwadi', 'Daisy123', '2 Ransom Court', 'Thornlands', 'Brisbane', 4164, 'daisydalwadi@gmail.com', 428689325, 'F', '1989-12-08', 'Employee', '2019-08-23 02:15:27', 'glen', 456987156, 'carter', 465123985, 7004, NULL),
(12, 'Tony', 'Longe', 'tonylonge', 'Tony123', '52 Ardee place', 'Logan Village', 'Brisbane', 4207, 'tonylonge@gmail.com', 456987156, 'M', '1988-11-05', 'Employee', '2019-08-16 01:12:25', 'cliff', 456789541, 'Nevill', 42354123, 7005, NULL);

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

--
-- Dumping data for table `sitedetail`
--

INSERT INTO `sitedetail` (`siteID`, `siteName`, `siteSuburb`, `siteCity`, `siteState`, `siteLongitude`, `siteLatitude`, `siteContactPersonName`, `siteContactPersonNo`, `siteCityPostcode`) VALUES
(1, 'SouthSide leads', 'Coopers Plains', 'Brisbane', 'QLD', '-27.567325', '153.034662', 'Suraj Shah', 403890376, 4108),
(2, 'Robertson Leads', 'Robertson', 'Brisbane', 'QLD', '-27.563847', '153.052446', 'Bhavik Shah', 403890376, 4109);

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
  `taskStarted` datetime DEFAULT NULL,
  `taskCompleted` datetime DEFAULT NULL,
  `siteID` int(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`taskID`, `taskName`, `taskDetail`, `empID`, `teamLeaderID`, `completionFlag`, `taskCreated`, `taskStarted`, `taskCompleted`, `siteID`) VALUES
(0, 'Task 1 getting leads', 'begins at 10 am\r\nends at 5 pm', 1, 1, 0, '2019-06-04 00:00:00', '0000-00-00 00:00:00', NULL, 1),
(1, 'Task 2 - Appointment', 'Start at 9 am, ends 4 pm', 1, 1, 0, '2019-06-04 00:00:00', '0000-00-00 00:00:00', NULL, 1),
(2, 'Task 3 - Installation', 'Two installation on the same site for today', 1, 1, 0, '2019-06-04 00:00:00', '0000-00-00 00:00:00', NULL, 1),
(3, 'Task 3 - Service', 'One Service Call at Ipswich', 1, 1, 0, '2019-06-04 00:00:00', '0000-00-00 00:00:00', NULL, 1),
(4, 'Task 5 Gather Leads', 'Please collect about 50 leads in upcoming week. You are strongly insistead to use office resourceas. ', 1, 1, 0, '2019-09-02 00:00:00', NULL, NULL, 0),
(5, 'Task 6 Gather Leads', 'Please collect about 50 leads in upcoming week. You are strongly insistead to use office resourceas. ', 2, 1, 0, '2019-08-15 00:00:00', NULL, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`departmentID`),
  ADD KEY `empId_tlId` (`teamLeaderID`);

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
  MODIFY `departmentID` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7006;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `empID` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `sitedetail`
--
ALTER TABLE `sitedetail`
  MODIFY `siteID` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
