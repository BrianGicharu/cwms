-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2023 at 02:39 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cwmsdb`
--
CREATE DATABASE IF NOT EXISTS `cwmsdb`;
-- --------------------------------------------------------
USE `cwmsdb`;
--
-- Table structure for table `admin`
--
CREATE TABLE IF NOT EXISTS `businessinfo`(
  `id` INT(3) ZEROFILL AUTO_INCREMENT PRIMARY KEY,
  `businessName` VARCHAR(64),
  `email` VARCHAR(32),
  `address` VARCHAR(64),
  `logo` VARCHAR(128)
);
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL,
  `UserName` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `updationDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `UserName`, `Password`, `updationDate`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '2020-12-10 11:18:49'),
(2, 'tester', '21232f297a57a5a743894a0e4a801fc3', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblcarwashbooking`
--

CREATE TABLE IF NOT EXISTS `tblcarwashbooking` (
  `id` int(11) NOT NULL,
  `bookingId` bigint(10) DEFAULT NULL,
  `packageType` int(11) DEFAULT NULL,
  `vehicleType` int(11) NOT NULL,
  `carWashPoint` int(11) DEFAULT NULL,
  `fullName` varchar(150) DEFAULT NULL,
  `mobileNumber` bigint(12) DEFAULT NULL,
  `washDate` date DEFAULT NULL,
  `washTime` time DEFAULT NULL,
  `message` mediumtext DEFAULT NULL,
  `status` varchar(120) DEFAULT NULL,
  `adminRemark` mediumtext DEFAULT NULL,
  `paymentMode` varchar(120) DEFAULT NULL,
  `txnNumber` varchar(120) DEFAULT NULL,
  `paidAmount` decimal(10,2) DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT current_timestamp(),
  `lastUpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblcarwashbooking`
--

INSERT INTO `tblcarwashbooking` (`id`, `bookingId`, `packageType`, `vehicleType`, `carWashPoint`, `fullName`, `mobileNumber`, `washDate`, `washTime`, `message`, `status`, `adminRemark`, `paymentMode`, `txnNumber`, `paidAmount`, `postingDate`, `lastUpdationDate`) VALUES
(8, 531916072, 1, 1, 2, 'Leonard DaVinci', 725200738, '2023-05-06', '10:00:00', 'Vaccum wash the seats as also', 'Completed', 'Paid', '000006', '', '2000.00', '2023-05-06 04:39:15', '2023-05-09 23:30:50'),
(9, 944057863, 5, 2, 3, 'Lillian', 758412325, '2023-05-07', '10:00:00', '', 'Completed', 'N/A', '000006', '', '2000.00', '2023-05-06 04:48:38', '2023-05-10 00:32:06'),
(13, 367313204, 1, 2, 3, 'David', 758412325, '2023-05-12', '22:10:00', '', 'New', NULL, NULL, NULL, NULL, '2023-05-06 07:11:24', '2023-05-09 21:21:21'),
(18, 718018104, 5, 1, 1, 'Daniel', 758412325, '2023-05-11', '16:33:00', '', 'New', NULL, NULL, NULL, NULL, '2023-05-10 10:33:39', NULL),
(19, 260343910, 5, 1, 3, 'Denise', 758412325, '2023-05-11', '15:36:00', '', 'New', NULL, NULL, NULL, NULL, '2023-05-10 10:36:28', NULL),
(20, 517548476, 5, 1, 3, 'Hagrid', 758412328, '2023-05-12', '16:37:00', '', 'Completed', 'MPESA', '000006', 'HG98TN66', '2800.00', '2023-05-10 10:37:43', '2023-05-10 11:39:35'),
(21, 520195724, 6, 1, 2, 'Daniel', 725200739, '2023-05-12', '17:38:00', '', 'New', NULL, NULL, NULL, NULL, '2023-05-10 10:39:01', NULL),
(22, 775202362, 5, 1, 1, 'Bryant', 758412325, '2023-05-10', '12:20:00', '', 'New', NULL, NULL, NULL, NULL, '2023-05-10 11:34:17', NULL),
(23, 719722442, 1, 1, 1, 'Jamal Musiala', 723456773, '2023-05-10', '14:08:00', 'full', 'Completed', 'Paid in full', '000001', 'JHG787678GDS', '6000.00', '2023-05-11 18:08:26', '2023-05-11 18:13:26'),
(24, 332702888, 1, 1, 2, 'Ahmed Mahmoud', 721456773, '2023-05-18', '12:10:00', 'rew', 'New', NULL, NULL, NULL, NULL, '2023-05-11 18:10:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblcustomers`
--

CREATE TABLE IF NOT EXISTS `tblcustomers` (
  `customerId` int(6) UNSIGNED ZEROFILL NOT NULL,
  `customerName` varchar(64) NOT NULL,
  `customerEmail` varchar(20) DEFAULT NULL,
  `customerPhone` varchar(10) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `cardNo` varchar(19) DEFAULT NULL,
  `cvv` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblenquiry`
--

CREATE TABLE IF NOT EXISTS `tblenquiry` (
  `id` int(11) NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `EmailId` varchar(100) DEFAULT NULL,
  `Subject` varchar(100) DEFAULT NULL,
  `Description` mediumtext DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp(),
  `Status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblenquiry`
--

INSERT INTO `tblenquiry` (`id`, `FullName`, `EmailId`, `Subject`, `Description`, `PostingDate`, `Status`) VALUES
(4, 'Carl Njoroge', 'carlnjoroge@gmail.com', 'General Enquiry', 'I want to know the price of car wash', '2023-02-13 18:27:53', 1),
(5, 'Andrew kibe', 'kibe@gmail.com', 'Service Enquiry', 'What is the average waiting time for cleaning an SUV like the Audi Q7 at any washing point?', '2023-01-14 19:14:22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblpages`
--

CREATE TABLE IF NOT EXISTS `tblpages` (
  `id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT '',
  `detail` longtext DEFAULT NULL,
  `openignHrs` varchar(255) DEFAULT NULL,
  `phoneNumber` bigint(20) DEFAULT NULL,
  `emailId` varchar(120) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblpages`
--

INSERT INTO `tblpages` (`id`, `type`, `detail`, `openignHrs`, `phoneNumber`, `emailId`) VALUES
(3, 'aboutus', '																														<div style=\"text-align: justify;\"><span style=\"color: rgb(0, 0, 0); font-family: Georgia; font-size: 15px;\">Car Wash Management System is a brand which is literally going to change the way people think about car cleaning. It is a unique mechanized car cleaning concept where cars are getting pampered by the latest equipments including high pressure cleaning machines, spray injection and extraction machines, high powered vacuum cleaners, steam cleaners and so on.</span></div><div style=\"text-align: justify;\"><span style=\"color: rgb(0, 0, 0); font-family: Georgia; font-size: 15px;\"><br></span></div><div style=\"text-align: justify;\"><span style=\"color: rgb(0, 0, 0); font-family: Georgia; font-size: 15px;\">Car Wash&nbsp; Management System is a brand that is literally going to change the way people think about car cleaning. It is a unique mechanized car cleaning concept where cars are getting pampered by the latest equipments including high pressure cleaning machines, spray injection and extraction machines, high powered vacuum cleaners, steam cleaners and so on.&nbsp;</span><br></div><div></div>\r\n										\r\n										\r\n										', NULL, NULL, NULL),
(11, 'contact', 'Cottage Street, Nanyuki, Kenya', 'Mon - Fri, 8:00 AM - 9:00 PM', 1234567890, 'mycarwash@info.com');

-- --------------------------------------------------------

--
-- Table structure for table `tblpaidcarwashbooking`
--

CREATE TABLE IF NOT EXISTS `tblpaidcarwashbooking` (
  `id` int(11) UNSIGNED ZEROFILL NOT NULL DEFAULT 00000000000,
  `bookingId` bigint(10) DEFAULT NULL,
  `packageType` int(11) DEFAULT NULL,
  `vehicleType` int(11) NOT NULL,
  `carWashPoint` int(11) DEFAULT NULL,
  `fullName` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `mobileNumber` bigint(12) DEFAULT NULL,
  `washDate` date DEFAULT NULL,
  `washTime` time DEFAULT NULL,
  `message` mediumtext CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `status` varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `adminRemark` mediumtext CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `paymentMode` varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `txnNumber` varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `paidAmount` decimal(10,2) DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT current_timestamp(),
  `lastUpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblpaymenttypes`
--

CREATE TABLE IF NOT EXISTS `tblpaymenttypes` (
  `id` int(6) UNSIGNED ZEROFILL NOT NULL,
  `paymentType` varchar(32) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblpaymenttypes`
--

INSERT INTO `tblpaymenttypes` (`id`, `paymentType`, `description`) VALUES
(000001, 'MPESA', 'Mpesa mobile money payment service by safaricom PLC\r\n'),
(000004, 'UPI', 'UPI'),
(000005, 'Debit/ Credit Card', 'Debit/ Credit Card'),
(000006, 'Cash', 'Hard Cash');

-- --------------------------------------------------------

--
-- Table structure for table `tblvehicletypes`
--

CREATE TABLE IF NOT EXISTS `tblvehicletypes` (
  `id` int(11) NOT NULL,
  `vehicle_name` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblvehicletypes`
--

INSERT INTO `tblvehicletypes` (`id`, `vehicle_name`) VALUES
(1, 'SUV'),
(2, 'SALOON');

-- --------------------------------------------------------

--
-- Table structure for table `tblwashingpoints`
--

CREATE TABLE IF NOT EXISTS `tblwashingpoints` (
  `id` int(11) NOT NULL,
  `washingPointName` varchar(255) DEFAULT NULL,
  `washingPointAddress` varchar(255) DEFAULT NULL,
  `contactNumber` bigint(20) DEFAULT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblwashingpoints`
--

INSERT INTO `tblwashingpoints` (`id`, `washingPointName`, `washingPointAddress`, `contactNumber`, `creationDate`) VALUES
(1, 'Car Washing Point-1', 'Cottage, Nanyuki 201301', 1236547890, '2023-04-13 09:21:20'),
(2, 'Car Washing Point-2', 'Cottage, Nanyuki 201301', 787654321, '2023-01-02 13:22:38'),
(3, 'Car Washing Point-3', 'Cottage, Nanyuki 201301', 4582365419, '2023-02-13 13:24:28');

-- --------------------------------------------------------

--
-- Table structure for table `tblwashservice`
--

CREATE TABLE IF NOT EXISTS `tblwashservice` (
  `id` int(11) NOT NULL,
  `service` varchar(64) DEFAULT NULL,
  `saloon` float DEFAULT NULL,
  `suv` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblwashservice`
--

INSERT INTO `tblwashservice` (`id`, `service`, `saloon`, `suv`) VALUES
(1, 'Full body wash', 300, 400),
(2, 'Rim cleaning', 2000, 2000),
(3, 'Watermark removal', 2000, 2000),
(4, 'Vacuum cleaning', 200, 200),
(5, 'Engine steam wash', 2000, 2000),
(6, 'Under wash', 700, 1000);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `paymentId` int(6) UNSIGNED ZEROFILL NOT NULL,
  `paymentTypeId` int(6) UNSIGNED ZEROFILL DEFAULT NULL,
  `customerId` int(6) UNSIGNED ZEROFILL DEFAULT NULL,
  `serviceType` varchar(64) DEFAULT NULL,
  `customerName` varchar(64) DEFAULT NULL,
  `customerEmail` varchar(20) DEFAULT NULL,
  `customerPhone` varchar(10) DEFAULT NULL,
  `paymentType` varchar(32) DEFAULT NULL,
  `cardNo` varchar(19) DEFAULT NULL,
  `cvv` int(3) UNSIGNED ZEROFILL DEFAULT NULL,
  `transactionResponse` varchar(999) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `currency` varchar(3) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`paymentId`, `paymentTypeId`, `customerId`, `serviceType`, `customerName`, `customerEmail`, `customerPhone`, `paymentType`, `cardNo`, `cvv`, `transactionResponse`, `amount`, `date`, `currency`, `status`, `description`, `address`) VALUES
(000011, 000001, 000001, 'Rim cleaning', 'Newton', 'newton@gmail.com', '0745874123', 'Visa', '1212212121215454', 001, 'Success', '2000.00', '2023-05-09 05:33:19', 'KES', 'paid', 'Paid order', 'Cottage St. Nanyuki'),
(000016, NULL, NULL, '5', 'Daniel', NULL, '758412325', NULL, NULL, NULL, NULL, NULL, '2023-05-10 13:33:39', NULL, 'New', '', NULL),
(000017, NULL, NULL, '5', 'Dankeen', NULL, '758412325', NULL, NULL, NULL, NULL, NULL, '2023-05-10 13:36:28', NULL, 'New', '', NULL),
(000018, NULL, NULL, '5', 'Hagrid', NULL, '758412328', NULL, NULL, NULL, NULL, NULL, '2023-05-10 13:37:43', NULL, 'New', '', NULL),
(000019, NULL, NULL, '6', 'Daniel', NULL, '725200739', NULL, NULL, NULL, NULL, NULL, '2023-05-10 13:39:01', NULL, 'New', '', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcarwashbooking`
--
ALTER TABLE `tblcarwashbooking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carWashPoint` (`carWashPoint`),
  ADD KEY `fk_packageType` (`packageType`),
  ADD KEY `fk_vehicleType` (`vehicleType`);

--
-- Indexes for table `tblcustomers`
--
ALTER TABLE `tblcustomers`
  ADD PRIMARY KEY (`customerId`),
  ADD UNIQUE KEY `customerEmail` (`customerEmail`),
  ADD UNIQUE KEY `customerPhone` (`customerPhone`),
  ADD UNIQUE KEY `cardNo` (`cardNo`);

--
-- Indexes for table `tblenquiry`
--
ALTER TABLE `tblenquiry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblpages`
--
ALTER TABLE `tblpages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblpaymenttypes`
--
ALTER TABLE `tblpaymenttypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblvehicletypes`
--
ALTER TABLE `tblvehicletypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblwashingpoints`
--
ALTER TABLE `tblwashingpoints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblwashservice`
--
ALTER TABLE `tblwashservice`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_service` (`service`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`paymentId`),
  ADD KEY `fk_paymentInfo` (`paymentTypeId`),
  ADD KEY `fk_cardDetails` (`cardNo`),
  ADD KEY `fk_customerInfo` (`customerId`),
  ADD KEY `fk_service` (`serviceType`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblcarwashbooking`
--
ALTER TABLE `tblcarwashbooking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tblcustomers`
--
ALTER TABLE `tblcustomers`
  MODIFY `customerId` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblenquiry`
--
ALTER TABLE `tblenquiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblpages`
--
ALTER TABLE `tblpages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tblpaymenttypes`
--
ALTER TABLE `tblpaymenttypes`
  MODIFY `id` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblvehicletypes`
--
ALTER TABLE `tblvehicletypes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblwashingpoints`
--
ALTER TABLE `tblwashingpoints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblwashservice`
--
ALTER TABLE `tblwashservice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `paymentId` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblcarwashbooking`
--
ALTER TABLE `tblcarwashbooking`
  ADD CONSTRAINT `fk_packageType` FOREIGN KEY (`packageType`) REFERENCES `tblwashservice` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_vehicleType` FOREIGN KEY (`vehicleType`) REFERENCES `tblvehicletypes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `washingpointid` FOREIGN KEY (`carWashPoint`) REFERENCES `tblwashingpoints` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
