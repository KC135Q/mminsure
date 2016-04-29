-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2016 at 05:54 AM
-- Server version: 5.6.25
-- PHP Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mminsurance`
--

-- --------------------------------------------------------

--
-- Table structure for table `attachment`
--

CREATE TABLE IF NOT EXISTS `attachment` (
  `attachmentID` int(11) NOT NULL,
  `claimID` int(11) NOT NULL,
  `attachmentName` varchar(255) COLLATE utf8_bin NOT NULL,
  `attachmentDescription` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `claim`
--

CREATE TABLE IF NOT EXISTS `claim` (
  `claimID` int(11) NOT NULL COMMENT 'M&M Internal Number',
  `insurerID` int(11) NOT NULL,
  `insuredID` int(11) NOT NULL,
  `status` varchar(6) COLLATE utf8_bin NOT NULL DEFAULT 'Open' COMMENT 'Open or Closed',
  `received` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `policyNumber` varchar(50) COLLATE utf8_bin NOT NULL,
  `insurerClaimNumber` varchar(50) COLLATE utf8_bin NOT NULL,
  `dateOfLoss` date NOT NULL,
  `dateReported` date NOT NULL,
  `timeOfLoss` time NOT NULL DEFAULT '01:30:00',
  `grossLossValue` varchar(25) COLLATE utf8_bin NOT NULL,
  `actualCashValue` varchar(25) COLLATE utf8_bin NOT NULL,
  `replacementCost` varchar(255) COLLATE utf8_bin NOT NULL,
  `lossDescription` text COLLATE utf8_bin NOT NULL,
  `lossLocation` varchar(255) COLLATE utf8_bin NOT NULL,
  `lossCounty` varchar(50) COLLATE utf8_bin NOT NULL,
  `statuteLimitations` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `lossState` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT 'Florida',
  `lossNotes` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=263 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Claim Information';

-- --------------------------------------------------------

--
-- Table structure for table `insured`
--

CREATE TABLE IF NOT EXISTS `insured` (
  `insuredID` int(11) NOT NULL,
  `lastName` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `firstName` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `cell` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `state` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `county` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `postcode` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `notes` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `insurer`
--

CREATE TABLE IF NOT EXISTS `insurer` (
  `insurerID` int(11) NOT NULL,
  `insurerName` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `insurerRep` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `insurerPhone` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `insurerEmail` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `insurerWebsite` varchar(255) COLLATE utf8_bin NOT NULL,
  `insurerAddress` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `insurerCity` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `insurerState` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `insurerCountry` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `insurerPostcode` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `insurerNotes` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `timesheet`
--

CREATE TABLE IF NOT EXISTS `timesheet` (
  `timesheetID` int(11) NOT NULL,
  `claimID` int(11) NOT NULL,
  `timeSpent` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT '0.1',
  `timeActivity` varchar(50) COLLATE utf8_bin NOT NULL,
  `timeDisbursementAmount` varchar(25) COLLATE utf8_bin NOT NULL,
  `timeTaxable` varchar(10) COLLATE utf8_bin NOT NULL,
  `timeDisbursementType` varchar(50) COLLATE utf8_bin NOT NULL,
  `timeNotes` text COLLATE utf8_bin NOT NULL,
  `timeBillable` varchar(10) COLLATE utf8_bin NOT NULL,
  `timeStamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attachment`
--
ALTER TABLE `attachment`
  ADD PRIMARY KEY (`attachmentID`);

--
-- Indexes for table `claim`
--
ALTER TABLE `claim`
  ADD PRIMARY KEY (`claimID`);

--
-- Indexes for table `insured`
--
ALTER TABLE `insured`
  ADD PRIMARY KEY (`insuredID`);

--
-- Indexes for table `insurer`
--
ALTER TABLE `insurer`
  ADD PRIMARY KEY (`insurerID`);

--
-- Indexes for table `timesheet`
--
ALTER TABLE `timesheet`
  ADD PRIMARY KEY (`timesheetID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attachment`
--
ALTER TABLE `attachment`
  MODIFY `attachmentID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `claim`
--
ALTER TABLE `claim`
  MODIFY `claimID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'M&M Internal Number',AUTO_INCREMENT=263;
--
-- AUTO_INCREMENT for table `insured`
--
ALTER TABLE `insured`
  MODIFY `insuredID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `insurer`
--
ALTER TABLE `insurer`
  MODIFY `insurerID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `timesheet`
--
ALTER TABLE `timesheet`
  MODIFY `timesheetID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
