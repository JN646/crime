-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 12, 2018 at 07:52 PM
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
  `constabulary` varchar(255) DEFAULT NULL,
  `timeseries_updated` timestamp NULL DEFAULT NULL,
  `priority` float DEFAULT NULL,
  `priority_updated` timestamp NULL DEFAULT NULL,
  `requests` int(11) NOT NULL DEFAULT '0',
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
  `Anti-social behaviour` int(11) DEFAULT NULL,
  `Burglary` int(11) DEFAULT NULL,
  `Other theft` int(11) DEFAULT NULL,
  `Public order` int(11) DEFAULT NULL,
  `Violence and sexual offences` int(11) DEFAULT NULL,
  `Vehicle crime` int(11) DEFAULT NULL,
  `Criminal damage and arson` int(11) DEFAULT NULL,
  `Other crime` int(11) DEFAULT NULL,
  `Robbery` int(11) DEFAULT NULL,
  `Bicycle theft` int(11) DEFAULT NULL,
  `Drugs` int(11) DEFAULT NULL,
  `Shoplifting` int(11) DEFAULT NULL,
  `Theft from the person` int(11) DEFAULT NULL,
  `Possession of weapons` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `report_log`
--

CREATE TABLE `report_log` (
  `report_id` int(11) NOT NULL COMMENT 'The report ID number',
  `report_lat` decimal(9,6) DEFAULT NULL COMMENT 'The Latitude for the report.',
  `report_long` decimal(9,6) DEFAULT NULL COMMENT 'The Longitude for the report.',
  `report_immediate` float DEFAULT NULL COMMENT 'Immediate Radius.',
  `report_local` float DEFAULT NULL COMMENT 'Local Radius.',
  `report_user` int(11) DEFAULT '0' COMMENT 'The ID number of the user that has created the report.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stats`
--

CREATE TABLE `stats` (
  `id` int(11) NOT NULL COMMENT 'Statistic ID',
  `stat` varchar(255) DEFAULT NULL COMMENT 'Statistic Name',
  `count` varchar(255) DEFAULT NULL COMMENT 'Statistic Count',
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
