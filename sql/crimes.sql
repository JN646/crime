-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 10, 2018 at 01:06 PM
-- Server version: 5.7.23
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crimes`
--

-- --------------------------------------------------------

--
-- Table structure for table `box`
--

CREATE TABLE `box` (
  `id` int(11) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `lat_min` float NOT NULL,
  `lat_max` float NOT NULL,
  `long_min` float NOT NULL,
  `long_max` float NOT NULL,
  `last_update` timestamp NULL DEFAULT NULL,
  `priority` float DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `box_month`
--

CREATE TABLE `box_month` (
  `bm_id` int(11) NOT NULL,
  `bm_month` varchar(20) DEFAULT NULL,
  `bm_boxid` int(11) DEFAULT NULL,
  `bm_antisocial` int(11) DEFAULT NULL,
  `bm_burglary` int(11) DEFAULT NULL,
  `bm_othertheft` int(11) DEFAULT NULL,
  `bm_publicorder` int(11) DEFAULT NULL,
  `bm_violencesex` int(11) DEFAULT NULL,
  `bm_vehiclecrime` int(11) DEFAULT NULL,
  `bm_criminaldamage` int(11) DEFAULT NULL,
  `bm_othercrime` int(11) DEFAULT NULL,
  `bm_robbery` int(11) DEFAULT NULL,
  `bm_bicycletheft` int(11) DEFAULT NULL,
  `bm_drugs` int(11) DEFAULT NULL,
  `bm_shoplifting` int(11) DEFAULT NULL,
  `bm_theftperson` int(11) DEFAULT NULL,
  `bm_weapons` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `id` int(11) NOT NULL,
  `Crime_ID` varchar(255) DEFAULT NULL,
  `Month` varchar(20) DEFAULT NULL,
  `Reported_By` varchar(255) DEFAULT NULL,
  `Falls_Within` varchar(255) DEFAULT NULL,
  `Longitude` decimal(9,6) DEFAULT '0.000000',
  `Latitude` decimal(9,6) DEFAULT '0.000000',
  `Location` varchar(200) DEFAULT NULL,
  `LSOA_Code` varchar(100) DEFAULT NULL,
  `LSOA_Name` varchar(100) DEFAULT NULL,
  `Crime_Type` varchar(250) DEFAULT NULL,
  `Last_Outcome_Category` text,
  `Context` text,
  `import_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date imported.'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stats`
--

CREATE TABLE `stats` (
  `id` int(11) NOT NULL COMMENT 'Statistic ID',
  `stat` varchar(100) DEFAULT NULL COMMENT 'Statistic Name',
  `count` int(11) DEFAULT '0' COMMENT 'Statistic Count',
  `last_run` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Updated'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `box`
--
ALTER TABLE `box`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `box_month`
--
ALTER TABLE `box_month`
  ADD PRIMARY KEY (`bm_id`);

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stats`
--
ALTER TABLE `stats`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `box`
--
ALTER TABLE `box`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `box_month`
--
ALTER TABLE `box_month`
  MODIFY `bm_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data`
--
ALTER TABLE `data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stats`
--
ALTER TABLE `stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Statistic ID';

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
