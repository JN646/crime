-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 31, 2018 at 03:08 PM
-- Server version: 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
-- Table structure for table `data`
--

DROP TABLE IF EXISTS `data`;
CREATE TABLE IF NOT EXISTS `data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Crime_ID` varchar(255) DEFAULT NULL,
  `Month` date DEFAULT NULL,
  `Reported_By` varchar(255) DEFAULT NULL,
  `Falls_Within` varchar(255) DEFAULT NULL,
  `Longitude` decimal(9,6) DEFAULT NULL,
  `Latitude` decimal(9,6) DEFAULT NULL,
  `Location` varchar(200) DEFAULT NULL,
  `LSOA_Code` varchar(100) DEFAULT NULL,
  `LSOA_Name` varchar(100) DEFAULT NULL,
  `Crime_Type` varchar(250) DEFAULT NULL,
  `Last_Outcome_Category` text,
  `Context` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=158 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`id`, `Crime_ID`, `Month`, `Reported_By`, `Falls_Within`, `Longitude`, `Latitude`, `Location`, `LSOA_Code`, `LSOA_Name`, `Crime_Type`, `Last_Outcome_Category`, `Context`) VALUES
(1, '2136d6ce0898d4f59d29b0925d776bc0254dc16b1a1d66dfe10f10be56497e60', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.690498', '51.887907', 'On or near Manor Farm Lane', 'E01017734', 'Aylesbury Vale 007E', 'Burglary', 'Investigation complete; no suspect identified', ''),
(2, '0e573005226395358a39d058dea8d20df02b83474dbc66c39b4a02d6268ff8bc', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.618543', '51.873624', 'On or near Chapel Lane', 'E01017658', 'Aylesbury Vale 009D', 'Criminal damage and arson', 'Investigation complete; no suspect identified', ''),
(3, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.413541', '52.226687', 'On or near Park/Open Space', 'E01017540', 'Bedford 001A', 'Anti-social behaviour', '', ''),
(4, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.415263', '52.268771', 'On or near B660', 'E01017540', 'Bedford 001A', 'Anti-social behaviour', '', ''),
(5, '7de547c9bf796a28da09b0bd641dd976798911eae2a20a303711704a9f93aa0e', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.454885', '52.279896', 'On or near Green Lane', 'E01017540', 'Bedford 001A', 'Criminal damage and arson', 'Status update unavailable', ''),
(6, '35d0ffa702ac55b2a70bacbcf464637050fa5135d5a37b2926a31ff5a9526c49', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.415247', '52.216604', 'On or near Thurleigh Road', 'E01017540', 'Bedford 001A', 'Other theft', 'Investigation complete; no suspect identified', ''),
(7, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.480710', '52.254724', 'On or near Kings Close', 'E01017541', 'Bedford 001B', 'Anti-social behaviour', '', ''),
(8, '6f24f40bba92a8500193e8db287b92938ae7bf23235d68936b53602adeb4b854', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.480870', '52.253044', 'On or near Gold Street', 'E01017541', 'Bedford 001B', 'Burglary', 'Investigation complete; no suspect identified', ''),
(9, '7c0f900e799cf18d3d31ea1ee35ea16a1cc2b7965afbbfa19f190a056a111f2e', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.473746', '52.253177', 'On or near Graham\'S Gardens', 'E01017541', 'Bedford 001B', 'Violence and sexual offences', 'Unable to prosecute suspect', ''),
(10, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.544827', '52.226355', 'On or near High Street', 'E01017544', 'Bedford 001C', 'Anti-social behaviour', '', ''),
(11, '6910e58e27880914bdeab15b4c2659341044def5647b0768527569014aff3f52', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.525972', '52.222264', 'On or near Mill Road', 'E01017544', 'Bedford 001C', 'Burglary', 'Investigation complete; no suspect identified', ''),
(12, '69bb94cd348ada65d750e3491e05b6fb85568bd66c9c45268b5f31f9f7a0714c', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.547329', '52.226845', 'On or near Towns End Road', 'E01017544', 'Bedford 001C', 'Other theft', 'Local resolution', ''),
(13, 'e0fbc4b5367c8a6354e11ca8e9aac72fa79fbd37e994fecc34d368897f68bcb3', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.537081', '52.229919', 'On or near Park Lane', 'E01017545', 'Bedford 001D', 'Burglary', 'Investigation complete; no suspect identified', ''),
(14, '4d80b2b573580ff39cd637f8105f589930751e6718d53a0d8af136a754836289', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.552834', '52.227290', 'On or near Loring Road', 'E01017545', 'Bedford 001D', 'Criminal damage and arson', 'Investigation complete; no suspect identified', ''),
(15, '96dba31a74627ee0c395ef624cdc01a8bd3261cb0d130fce47d7e29375e4da9c', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.556254', '52.222072', 'On or near Dolcey Way', 'E01017545', 'Bedford 001D', 'Violence and sexual offences', 'Action to be taken by another organisation', ''),
(16, '61be40658b3e4f2b82487305c29a3a51b0afab4e791d66d524eb279128ba59fc', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.556254', '52.222072', 'On or near Dolcey Way', 'E01017545', 'Bedford 001D', 'Violence and sexual offences', 'Action to be taken by another organisation', ''),
(17, '5c1b1647eca18918073b6c02f38192cc5da2a2b418fc522804ec5d564e8001fa', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.556254', '52.222072', 'On or near Dolcey Way', 'E01017545', 'Bedford 001D', 'Violence and sexual offences', 'Action to be taken by another organisation', ''),
(18, '1cacbecc098dc17dc76f17ca8a7cbf9a3d664f540b6eab5bbc89fa5ca938993b', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.553242', '52.207542', 'On or near Town Lot Lane', 'E01017464', 'Bedford 002A', 'Burglary', 'Investigation complete; no suspect identified', ''),
(19, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.601876', '52.192564', 'On or near Bridgend', 'E01017465', 'Bedford 002B', 'Anti-social behaviour', '', ''),
(20, '64afcdc24645f4b501196ec5774d81535cbb51791408d7b3a4612489f5923afd', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.553213', '52.167873', 'On or near Farley Way', 'E01017465', 'Bedford 002B', 'Burglary', 'Unable to prosecute suspect', ''),
(21, '418a1a31596bec182f265189fdc5bb37ed4ae4d181058524ff6047de546d4f72', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.562769', '52.151751', 'On or near Parking Area', 'E01017465', 'Bedford 002B', 'Vehicle crime', 'Investigation complete; no suspect identified', ''),
(22, '571447d14e31f520d78afa8996ef667d3058d1d2d6c5beb9f57b940c2226e8cf', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.553213', '52.167873', 'On or near Farley Way', 'E01017465', 'Bedford 002B', 'Violence and sexual offences', 'Unable to prosecute suspect', ''),
(23, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.599663', '52.269474', 'On or near Church Close', 'E01017503', 'Bedford 002C', 'Anti-social behaviour', '', ''),
(24, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.608879', '52.236272', 'On or near Sports/Recreation Area', 'E01017503', 'Bedford 002C', 'Anti-social behaviour', '', ''),
(25, '68ac165744d9e78077b3dfa546ec4d3040a60e5bb915a7a1a2ba56fdc888565a', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.608879', '52.236272', 'On or near Sports/Recreation Area', 'E01017503', 'Bedford 002C', 'Burglary', 'Investigation complete; no suspect identified', ''),
(26, '7637d779271781d919b476caa43f7be4c6d36ca97000e43bc92649e956c55d7d', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.602609', '52.273168', 'On or near Rushden Road', 'E01017503', 'Bedford 002C', 'Criminal damage and arson', 'Investigation complete; no suspect identified', ''),
(27, 'badcb574acfeebaa05ec5e8546652e4034769d25e932bc9a45abe1e7896c67de', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.601110', '52.270525', 'On or near Sports/Recreation Area', 'E01017503', 'Bedford 002C', 'Criminal damage and arson', 'Defendant found not guilty', ''),
(28, '7287a4d875225f9b594f11cbf74b4636837d938949a0ad4b30c9fa1837b91c78', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.601847', '52.268529', 'On or near Brook Farm Close', 'E01017503', 'Bedford 002C', 'Criminal damage and arson', 'Investigation complete; no suspect identified', ''),
(29, '0d95c3e83045d1705541f038b97029ba4b1f3883697688b73e511df2d8237fea', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.602618', '52.270103', 'On or near Manor Lane', 'E01017503', 'Bedford 002C', 'Criminal damage and arson', 'Investigation complete; no suspect identified', ''),
(30, '3482422b1fe5860f309f4917e8f09b7968a9f74bc54b8bc41e7e3d4d416e0df1', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.601110', '52.270525', 'On or near Sports/Recreation Area', 'E01017503', 'Bedford 002C', 'Criminal damage and arson', 'Unable to prosecute suspect', ''),
(31, 'e7966922abf141b6216a6c6cf86292e23b9694aeb83d50bc20b4793993f82365', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.627906', '52.249459', 'On or near Hinwick Road', 'E01017503', 'Bedford 002C', 'Criminal damage and arson', 'Investigation complete; no suspect identified', ''),
(32, '4ba447fe4c4227e6a901441a4b16e10071ebe5355fe226a134d17a0657a6441f', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.602609', '52.273168', 'On or near Rushden Road', 'E01017503', 'Bedford 002C', 'Criminal damage and arson', 'Unable to prosecute suspect', ''),
(33, 'c505bea28c609ef1508eecbd69a53463f4f09933896c5a541b1c424058516890', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.602609', '52.273168', 'On or near Rushden Road', 'E01017503', 'Bedford 002C', 'Criminal damage and arson', 'Investigation complete; no suspect identified', ''),
(34, '41823d7b92ea506001046eae1e171f2f0ab5e4236ec34481274dacfab6cfb219', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.612406', '52.261722', 'On or near Podington Road', 'E01017503', 'Bedford 002C', 'Vehicle crime', 'Investigation complete; no suspect identified', ''),
(35, 'd034db1a0173fa5f32646e4c7905214e165ac9907aafe07fc5f7f62fe13e8b3a', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.602609', '52.273168', 'On or near Rushden Road', 'E01017503', 'Bedford 002C', 'Vehicle crime', 'Status update unavailable', ''),
(36, '37ea522ddd0c0f9a05156b022617c3946a90676556dff5d122e75806998467f6', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.612406', '52.261722', 'On or near Podington Road', 'E01017503', 'Bedford 002C', 'Vehicle crime', 'Investigation complete; no suspect identified', ''),
(37, '386a0bee4cad646896a7954ca392b8f476df0fbb6fb4963d83152868b58af25d', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.601110', '52.270525', 'On or near Sports/Recreation Area', 'E01017503', 'Bedford 002C', 'Violence and sexual offences', 'Awaiting court outcome', ''),
(38, 'c8fd068d4b8301366b8298cb40c1e26fa4ad765ecd98f7dac03e4dba0f70f7e3', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.599663', '52.269474', 'On or near Church Close', 'E01017503', 'Bedford 002C', 'Violence and sexual offences', 'Unable to prosecute suspect', ''),
(39, 'f17711f830158a8530d0b600b7933e616d24277a8cd27e32eb3d04ca3c3b8437', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.601110', '52.270525', 'On or near Sports/Recreation Area', 'E01017503', 'Bedford 002C', 'Violence and sexual offences', 'Unable to prosecute suspect', ''),
(40, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.604298', '52.199768', 'On or near Hall Close', 'E01017504', 'Bedford 002D', 'Anti-social behaviour', '', ''),
(41, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.612982', '52.200014', 'On or near Mowhills', 'E01017504', 'Bedford 002D', 'Anti-social behaviour', '', ''),
(42, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.610352', '52.201305', 'On or near High Street', 'E01017504', 'Bedford 002D', 'Anti-social behaviour', '', ''),
(43, '0e1c3cb275277847578143a47416c8fae447679701c16fdc3ff23a645a9f41b8', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.613166', '52.202579', 'On or near Dickens Close', 'E01017504', 'Bedford 002D', 'Burglary', 'Status update unavailable', ''),
(44, '3fffafdf1eba4c0d0ed929c2898802e79f04f11552b406496413705c7105a072', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.609408', '52.202481', 'On or near Roman Paddock', 'E01017504', 'Bedford 002D', 'Criminal damage and arson', 'Investigation complete; no suspect identified', ''),
(45, '5ece6ce28246ef4158021e2ab949a5166bbca347a9148301cda2382711a16c54', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.626929', '52.160527', 'On or near Tandys Close', 'E01017546', 'Bedford 002E', 'Violence and sexual offences', 'Status update unavailable', ''),
(46, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.586406', '52.122123', 'On or near Parking Area', 'E01017547', 'Bedford 002F', 'Anti-social behaviour', '', ''),
(47, 'cf0b705acc4e2a37a3aa465bc7ae47c43481cab5ba9442040fbf3a9d5300df27', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.540624', '52.124488', 'On or near West End Road', 'E01017547', 'Bedford 002F', 'Burglary', 'Investigation complete; no suspect identified', ''),
(48, '17e63378d435e2fb285acb957af77d700486f7e9a4292ac5c6eaed0565505ecf', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.524562', '52.110136', 'On or near The Chase', 'E01017547', 'Bedford 002F', 'Burglary', 'Status update unavailable', ''),
(49, '4fecc6612ed5261a458f7a86065f32afbe320133b15d8f13c9603a22893ca7a0', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.520094', '52.119808', 'On or near Church End', 'E01017547', 'Bedford 002F', 'Burglary', 'Investigation complete; no suspect identified', ''),
(50, 'fb55f0ae2d1c7701b100b2cb8c7bd6511810523a29e261e1e94886e3dbc0c4ab', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.524562', '52.110136', 'On or near The Chase', 'E01017547', 'Bedford 002F', 'Vehicle crime', 'Investigation complete; no suspect identified', ''),
(51, '58803044894b10e0bc7b85e2ccb46001cbc02f2458ee4f5c6e922c25bb645cce', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.542137', '52.108107', 'On or near Wood End Road', 'E01017547', 'Bedford 002F', 'Violence and sexual offences', 'Awaiting court outcome', ''),
(52, 'c3ed497a92b26c9c52a5ce8677ae7fda9a7734fd6b8f06abc58c8aeaa58f1d5e', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.527719', '52.130891', 'On or near Box End Road', 'E01017547', 'Bedford 002F', 'Violence and sexual offences', 'Action to be taken by another organisation', ''),
(53, '542b5653b7e96ac7ef47565b9e12228c84cf334109e3256d3ba9ae7018238833', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.520875', '52.126678', 'On or near Park/Open Space', 'E01017547', 'Bedford 002F', 'Violence and sexual offences', 'Unable to prosecute suspect', ''),
(54, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.512139', '52.192861', 'On or near Parkside', 'E01017478', 'Bedford 003A', 'Anti-social behaviour', '', ''),
(55, '57efc47ec31f9764585304112ded830faf18e7d305e4ec9aba3a643a033f5ba8', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.471261', '52.219339', 'On or near Park/Open Space', 'E01017478', 'Bedford 003A', 'Violence and sexual offences', 'Local resolution', ''),
(56, '9d296070e3b10c73c6fb34b3a01594349e2233a7ce1d96b29a1075298919e7c5', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.486421', '52.194970', 'On or near Prison', 'E01017478', 'Bedford 003A', 'Violence and sexual offences', 'Investigation complete; no suspect identified', ''),
(57, 'e1eced774cd2df36c8765a888ac3c014a0377850ce50397f5d5470ece37cc8d0', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.516150', '52.195869', 'On or near Butterfield Court', 'E01017478', 'Bedford 003A', 'Violence and sexual offences', 'Local resolution', ''),
(58, 'cbcd24d0effd0a6ae6bf1237f80e83232d9b8329475e8a9e288554a880958644', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.504089', '52.163762', 'On or near Hunter\'S Close', 'E01017479', 'Bedford 003B', 'Bicycle theft', 'Investigation complete; no suspect identified', ''),
(59, '92fdeab05d3b2fbe4cc44ff2bfd6fd3785de464b59811dbcfd1d17e377edf8be', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.489993', '52.159923', 'On or near Ursula Taylor Walk', 'E01017479', 'Bedford 003B', 'Burglary', 'Awaiting court outcome', ''),
(60, '2acacb2ebd015332d333d8d5410825e910b7f2644a33d42afbccbc3c002b3103', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.494457', '52.160646', 'On or near High Street (Service Road)', 'E01017479', 'Bedford 003B', 'Shoplifting', 'Awaiting court outcome', ''),
(61, '0231171f0e8cdab5297e4f27d71ada53c21b37611a6ac341f5acfaa6812f1190', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.494457', '52.160646', 'On or near High Street (Service Road)', 'E01017479', 'Bedford 003B', 'Shoplifting', 'Investigation complete; no suspect identified', ''),
(62, 'e37ecbcc157b7f43d2ed1c573d3baecf99f14cb23d5df19fe743aea1abaeb8d4', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.496421', '52.160931', 'On or near High Street', 'E01017479', 'Bedford 003B', 'Vehicle crime', 'Investigation complete; no suspect identified', ''),
(63, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.506118', '52.165595', 'On or near Prior Close', 'E01017480', 'Bedford 003C', 'Anti-social behaviour', '', ''),
(64, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.500503', '52.165191', 'On or near Mount Pleasant Road', 'E01017480', 'Bedford 003C', 'Anti-social behaviour', '', ''),
(65, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.502979', '52.167659', 'On or near Saddle Close', 'E01017480', 'Bedford 003C', 'Anti-social behaviour', '', ''),
(66, '97c1ac999283149b91233646e004bf499e654d661900da13e998c503c7e508d8', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.506842', '52.168437', 'On or near Fox Close', 'E01017480', 'Bedford 003C', 'Burglary', 'Investigation complete; no suspect identified', ''),
(67, '04a5126ee1a9b093e470e4d6c4231cc9be635a5804d95ea740efb14175948685', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.504320', '52.169079', 'On or near Shire Road', 'E01017480', 'Bedford 003C', 'Public order', 'Unable to prosecute suspect', ''),
(68, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.501963', '52.164805', 'On or near George Street', 'E01017481', 'Bedford 003D', 'Anti-social behaviour', '', ''),
(69, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.501963', '52.164805', 'On or near George Street', 'E01017481', 'Bedford 003D', 'Anti-social behaviour', '', ''),
(70, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.501963', '52.164805', 'On or near George Street', 'E01017481', 'Bedford 003D', 'Anti-social behaviour', '', ''),
(71, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.501963', '52.164805', 'On or near George Street', 'E01017481', 'Bedford 003D', 'Anti-social behaviour', '', ''),
(72, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.501963', '52.164805', 'On or near George Street', 'E01017481', 'Bedford 003D', 'Anti-social behaviour', '', ''),
(73, '060451ad09279ff845b3c067b2fc2324b4977d107a81aa172f3f4dcb6dbb4fe7', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.495005', '52.164771', 'On or near Lanchester Close', 'E01017481', 'Bedford 003D', 'Bicycle theft', 'Investigation complete; no suspect identified', ''),
(74, '61aa52edb000d300ee049cb676e1a108c89ceb40e3ac52d65076124da43f91b2', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.493944', '52.163283', 'On or near Highbury Grove', 'E01017481', 'Bedford 003D', 'Criminal damage and arson', 'Investigation complete; no suspect identified', ''),
(75, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.521413', '52.167343', 'On or near Parsonage Close', 'E01017528', 'Bedford 003E', 'Anti-social behaviour', '', ''),
(76, '141dc5a800994241a373d27dd073e9468a7b13ec69afa8f01d6e32439ffe75c7', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.525319', '52.171249', 'On or near Grenidge Way', 'E01017528', 'Bedford 003E', 'Burglary', 'Status update unavailable', ''),
(77, 'ac888579bb188e44f79cc3acf225f345de464c3203a2f53930a4f445b0b62952', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.521367', '52.171802', 'On or near Hunts Path', 'E01017528', 'Bedford 003E', 'Burglary', 'Investigation complete; no suspect identified', ''),
(78, 'daebecec8203622a59cf790d618b8a04fbe9d5dba2b83b3bd168502f1ad731ae', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.521413', '52.167343', 'On or near Parsonage Close', 'E01017528', 'Bedford 003E', 'Criminal damage and arson', 'Investigation complete; no suspect identified', ''),
(79, '7516e15cf1cf498958b819a1a4d93acae52ed9b5720c75c3046ff98b2548d700', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.520705', '52.172361', 'On or near Grange Close', 'E01017528', 'Bedford 003E', 'Criminal damage and arson', 'Investigation complete; no suspect identified', ''),
(80, 'b946c1fa88f85231fbd571d36a843e76da1fba5fe5b017b2c6a3d563ba6d8594', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.521413', '52.167343', 'On or near Parsonage Close', 'E01017528', 'Bedford 003E', 'Public order', 'Unable to prosecute suspect', ''),
(81, '1ab91e604060c83d1e55683970fd71f73b3dc5528f414f262f589cf9e8bdf3e7', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.523783', '52.171707', 'On or near Burleigh Place', 'E01017528', 'Bedford 003E', 'Vehicle crime', 'Investigation complete; no suspect identified', ''),
(82, '8a9ccfadbaaa126ac74f280cf6d0f84540a63c3c75cb2c5334e469db08300a3d', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.521413', '52.167343', 'On or near Parsonage Close', 'E01017528', 'Bedford 003E', 'Violence and sexual offences', 'Local resolution', ''),
(83, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.349700', '52.159204', 'On or near Fair Way', 'E01017495', 'Bedford 004B', 'Anti-social behaviour', '', ''),
(84, '99aba6204a22244c7a047b338cdaa04257466deab7df84694b0da10410481049', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.344476', '52.153835', 'On or near Woodpecker Close', 'E01017495', 'Bedford 004B', 'Burglary', 'Investigation complete; no suspect identified', ''),
(85, 'f2d39895bac402bd85b9209719476e2cc7af4d6f5f1bf6adeba9e6371c8074b7', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.350707', '52.158481', 'On or near Willoughby Close', 'E01017495', 'Bedford 004B', 'Burglary', 'Investigation complete; no suspect identified', ''),
(86, '3a58427e49d13600ed53b89a0f37d832728fb73dfc191598460232b23e7cb2aa', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.344698', '52.152579', 'On or near Churchgate', 'E01017495', 'Bedford 004B', 'Burglary', 'Investigation complete; no suspect identified', ''),
(87, '574ad5a95b989742ee8312658672ae53413de237518671d63c077983e94aa33b', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.352594', '52.157257', 'On or near Hunts Field', 'E01017495', 'Bedford 004B', 'Criminal damage and arson', 'Investigation complete; no suspect identified', ''),
(88, 'ae15aa934af1ba755a3d1ab6aa12facbc713c1f6163282fdfa996062ca096517', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.349147', '52.158764', 'On or near Brookside', 'E01017495', 'Bedford 004B', 'Other theft', 'Investigation complete; no suspect identified', ''),
(89, 'cb6084562dd6324775a466ddad399dc4c7dff9971ada6f090a1a84c8021ca0c8', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.352594', '52.157257', 'On or near Hunts Field', 'E01017495', 'Bedford 004B', 'Shoplifting', 'Investigation complete; no suspect identified', ''),
(90, '6d8f47c21aded27e3c197911fe1fe23548ff3acd17906bd9ee92fe4fcda7e5d1', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.352594', '52.157257', 'On or near Hunts Field', 'E01017495', 'Bedford 004B', 'Violence and sexual offences', 'Status update unavailable', ''),
(91, '632cfc08689a7d8c59d90475d153ecb60ae9de1a7ca426b17b60634271bb2d55', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.352594', '52.157257', 'On or near Hunts Field', 'E01017495', 'Bedford 004B', 'Violence and sexual offences', 'Status update unavailable', ''),
(92, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.389137', '52.129017', 'On or near All Saints Road', 'E01017496', 'Bedford 004C', 'Anti-social behaviour', '', ''),
(93, 'eb1b3a8bed0a7c8585a8030d2b5145143db06298fe56a1070d8568d926b3886d', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.372210', '52.134080', 'On or near Bedford Road', 'E01017496', 'Bedford 004C', 'Criminal damage and arson', 'Investigation complete; no suspect identified', ''),
(94, 'a7f5f5e00bb59ad7d046b5ad237d081caf0dc2ea330a433279d943dd452f4f6a', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.385362', '52.137246', 'On or near Church End', 'E01017496', 'Bedford 004C', 'Other theft', 'Investigation complete; no suspect identified', ''),
(95, '3c8cc002a8a2df3e1a01ebc28314aa77bf6146f67107911a009f2802c6ad277a', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.373826', '52.138238', 'On or near Chapel Lane', 'E01017496', 'Bedford 004C', 'Other theft', 'Investigation complete; no suspect identified', ''),
(96, 'c085719517160f2b576e5971c369501bb259d6a7f2a529a6872f020fa305f3eb', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.385362', '52.137246', 'On or near Church End', 'E01017496', 'Bedford 004C', 'Other theft', 'Investigation complete; no suspect identified', ''),
(97, 'b82b2ef3f028e6a3a480c8ed9322826531916bc4845a4681a393b09226b0503d', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.385362', '52.137246', 'On or near Church End', 'E01017496', 'Bedford 004C', 'Other theft', 'Investigation complete; no suspect identified', ''),
(98, '624c2c303ce1f18538eaba726d08671110480a6c42d29ce295c1daeb9c5c26f4', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.372210', '52.134080', 'On or near Bedford Road', 'E01017496', 'Bedford 004C', 'Shoplifting', 'Suspect charged as part of another case', ''),
(99, '7d70f35754facfae72b9fa533ab113f51fa5fb17b6d73847447412ca9e8b1db7', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.372210', '52.134080', 'On or near Bedford Road', 'E01017496', 'Bedford 004C', 'Shoplifting', 'Suspect charged as part of another case', ''),
(100, '0670816c26ad8ac32b8c50359261e589436a944910b32648f430e02807fface8', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.372210', '52.134080', 'On or near Bedford Road', 'E01017496', 'Bedford 004C', 'Shoplifting', 'Awaiting court outcome', ''),
(101, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.318021', '52.178169', 'On or near Park Road', 'E01017542', 'Bedford 004D', 'Anti-social behaviour', '', ''),
(102, '928ac2eb8ee46a303c232ea4aac804f3a98b45dda665ef6d8d1df55170e5432c', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.317794', '52.188461', 'On or near Spinney Road', 'E01017542', 'Bedford 004D', 'Burglary', 'Investigation complete; no suspect identified', ''),
(103, 'cec585bb83351026468eac95e009e90a776ccae60d4ef2faa84397dda459ef97', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.413805', '52.184324', 'On or near Ravensden Road', 'E01017542', 'Bedford 004D', 'Burglary', 'Investigation complete; no suspect identified', ''),
(104, '9b990bacc7a967c6f1355decbaafb1792f964b487f6031a5ab49283f26653cc8', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.300026', '52.192513', 'On or near Nagshead Lane', 'E01017542', 'Bedford 004D', 'Other theft', 'Investigation complete; no suspect identified', ''),
(105, '2d761b4866a488a0045bff1e58b7f667e925d3bc46d693f0ceb1e63b36335b75', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.300026', '52.192513', 'On or near Nagshead Lane', 'E01017542', 'Bedford 004D', 'Other theft', 'Investigation complete; no suspect identified', ''),
(106, '267cf39afdc96721e184b527fdfe115f11c7fec8f65732a9d91b6bd4eab56715', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.300026', '52.192513', 'On or near Nagshead Lane', 'E01017542', 'Bedford 004D', 'Other theft', 'Investigation complete; no suspect identified', ''),
(107, '3fe083d19e5b3f85cf1c51aec6802140f45f8e50586240c50caf0c72451b8774', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.300026', '52.192513', 'On or near Nagshead Lane', 'E01017542', 'Bedford 004D', 'Other theft', 'Investigation complete; no suspect identified', ''),
(108, '653db198f2606932f15c07aa0c32b208ea4c4ccafbf8fc92b4840f3871e68ab4', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.300026', '52.192513', 'On or near Nagshead Lane', 'E01017542', 'Bedford 004D', 'Shoplifting', 'Investigation complete; no suspect identified', ''),
(109, '45ac0512386abe4b49093ac9cb9fc0300838c6bf8206db19edd2b01bc646f4b0', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.307394', '52.191495', 'On or near Chawston Lane', 'E01017542', 'Bedford 004D', 'Vehicle crime', 'Investigation complete; no suspect identified', ''),
(110, '3951cb9e71decc7358973fa5588e4daa04c0452c65cac5178253d0554dfae9e3', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.318021', '52.178169', 'On or near Park Road', 'E01017542', 'Bedford 004D', 'Vehicle crime', 'Investigation complete; no suspect identified', ''),
(111, '17c4b6b37f78a0f12da6a153f6a91b7d72a67158245ccc7c9cfc857fb1ee7499', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.293218', '52.197225', 'On or near Park/Open Space', 'E01017542', 'Bedford 004D', 'Vehicle crime', 'Investigation complete; no suspect identified', ''),
(112, 'a477811bf3f4fb80358a681a2fde0637aaddbd826bdc5162b2cbb3743c52b1ab', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.316064', '52.177323', 'On or near High Street', 'E01017542', 'Bedford 004D', 'Vehicle crime', 'Investigation complete; no suspect identified', ''),
(113, '8054df80ac5219095004ede9f395c005921041c133554ae060afc86eaca77ffe', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.413805', '52.184324', 'On or near Ravensden Road', 'E01017542', 'Bedford 004D', 'Violence and sexual offences', 'Investigation complete; no suspect identified', ''),
(114, 'df3fccd09d004484ec15e9c86b65f226aea6331daddf853d44860472ad2a4480', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.379603', '52.217378', 'On or near Queens Road', 'E01017543', 'Bedford 004E', 'Burglary', 'Investigation complete; no suspect identified', ''),
(115, '1bf54b956254d8f4808cd379781a40b08eb45d538e41464a5e565bb1e16041bd', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.387163', '52.211161', 'On or near Chapel Lane', 'E01017543', 'Bedford 004E', 'Burglary', 'Investigation complete; no suspect identified', ''),
(116, 'fedf55e9ca165525866b305ce3c7bc659ec330a726f7819ed239ed3681856f96', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.308462', '52.198065', 'On or near The Lane', 'E01017543', 'Bedford 004E', 'Criminal damage and arson', 'Action to be taken by another organisation', ''),
(117, 'e16144f2974a97db44f84fea03d7393bdc4685700e155b5dbcc6d5caf0002e69', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.308462', '52.198065', 'On or near The Lane', 'E01017543', 'Bedford 004E', 'Criminal damage and arson', 'Unable to prosecute suspect', ''),
(118, '550daf75ea41204d9eca3b10474be2cd5daed809dc65b1fdace1a3c1fdaa8ce7', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.308462', '52.198065', 'On or near The Lane', 'E01017543', 'Bedford 004E', 'Criminal damage and arson', 'Unable to prosecute suspect', ''),
(119, '5002155633c3679678c7e46d762d0604887b2f2f3564296563978c3acc251806', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.308462', '52.198065', 'On or near The Lane', 'E01017543', 'Bedford 004E', 'Public order', 'Action to be taken by another organisation', ''),
(120, 'fd6f208a69b4dc6c9236f76aa1f62bac1e836f1d955d5fbffb75a2e7d266120a', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.308462', '52.198065', 'On or near The Lane', 'E01017543', 'Bedford 004E', 'Violence and sexual offences', 'Unable to prosecute suspect', ''),
(121, '09aee702a5dc548670b07acbc97f311d656a87b0f5e0148c91a2b4c12c8508e4', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.308462', '52.198065', 'On or near The Lane', 'E01017543', 'Bedford 004E', 'Violence and sexual offences', 'Unable to prosecute suspect', ''),
(122, '092459d6bed7ed4a288787a72ddc5b30cb73771b649f800970d524cf407fc6a2', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.308462', '52.198065', 'On or near The Lane', 'E01017543', 'Bedford 004E', 'Violence and sexual offences', 'Unable to prosecute suspect', ''),
(123, 'e2e28cd3245d7a018c196488ceca2d6b4181ecafa219f70b52d6e2e05972a0ae', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.308462', '52.198065', 'On or near The Lane', 'E01017543', 'Bedford 004E', 'Violence and sexual offences', 'Unable to prosecute suspect', ''),
(124, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.462491', '52.168910', 'On or near Bramley Way', 'E01033431', 'Bedford 004F', 'Anti-social behaviour', '', ''),
(125, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.421531', '52.155736', 'On or near Silverburn Close', 'E01033432', 'Bedford 004G', 'Anti-social behaviour', '', ''),
(126, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.432299', '52.172136', 'On or near Ravensden Road', 'E01033432', 'Bedford 004G', 'Anti-social behaviour', '', ''),
(127, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.422485', '52.164327', 'On or near Green Lane', 'E01033432', 'Bedford 004G', 'Anti-social behaviour', '', ''),
(128, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.420465', '52.156531', 'On or near Pedley Way', 'E01033432', 'Bedford 004G', 'Anti-social behaviour', '', ''),
(129, '40081c40f9d622ca836d94343e07ac14feb68feb1c267e2ff7eb803a934f05f0', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.434411', '52.184878', 'On or near Sunderland Hill', 'E01033432', 'Bedford 004G', 'Burglary', 'Investigation complete; no suspect identified', ''),
(130, '8ea0302dfeca981bf8beabaeaf36966e6930d7d306fae7bd9878fbd1959b883a', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.418996', '52.156332', 'On or near Kenwyn Close', 'E01033432', 'Bedford 004G', 'Vehicle crime', 'Investigation complete; no suspect identified', ''),
(131, 'ce5498935a68cc26385418f161589a3c22163a5cd0d43446aaa5605339a06730', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.432299', '52.172136', 'On or near Ravensden Road', 'E01033432', 'Bedford 004G', 'Violence and sexual offences', 'Unable to prosecute suspect', ''),
(132, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.458199', '52.158118', 'On or near Parking Area', 'E01017453', 'Bedford 005A', 'Anti-social behaviour', '', ''),
(133, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.461111', '52.162292', 'On or near Rede Close', 'E01017453', 'Bedford 005A', 'Anti-social behaviour', '', ''),
(134, '562cf3202e4875805856af2149ec3f3cc41cee0f888d2a4dd0e9ed7446d4d7e6', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.461421', '52.160507', 'On or near Frome Close', 'E01017453', 'Bedford 005A', 'Criminal damage and arson', 'Investigation complete; no suspect identified', ''),
(135, 'e28e9be4a926418b2656739912ec78cb9c943da3cba8db512e623748a75767dc', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.459972', '52.158438', 'On or near Severn Way', 'E01017453', 'Bedford 005A', 'Other theft', 'Investigation complete; no suspect identified', ''),
(136, '5d30fc31df776fecb20f0907331b6f0f8d5d04571dc7d3057c339d56720d7591', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.458199', '52.158118', 'On or near Parking Area', 'E01017453', 'Bedford 005A', 'Shoplifting', 'Investigation complete; no suspect identified', ''),
(137, '322ee57cf1f62e1e315f22366609b2e528d098e8bf405b95872a99caef131491', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.461421', '52.160507', 'On or near Frome Close', 'E01017453', 'Bedford 005A', 'Vehicle crime', 'Unable to prosecute suspect', ''),
(138, '430d9e7584242292d565bb61327dcf2be69861f62762ce5b21c23f28b76a8411', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.459972', '52.158438', 'On or near Severn Way', 'E01017453', 'Bedford 005A', 'Violence and sexual offences', 'Unable to prosecute suspect', ''),
(139, '541d531c0776bf70f85282ddb1caa5c8979c31b5f512f56e77f1a71138832713', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.459972', '52.158438', 'On or near Severn Way', 'E01017453', 'Bedford 005A', 'Violence and sexual offences', 'Unable to prosecute suspect', ''),
(140, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.458532', '52.160344', 'On or near Clyde Crescent', 'E01017454', 'Bedford 005B', 'Anti-social behaviour', '', ''),
(141, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.456594', '52.163951', 'On or near Connaught Way', 'E01017454', 'Bedford 005B', 'Anti-social behaviour', '', ''),
(142, 'a5d741928c33280fb200fa674c56e0a05a7a390f91713d564d4df24e6e3d338a', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.458532', '52.160344', 'On or near Clyde Crescent', 'E01017454', 'Bedford 005B', 'Other theft', 'Investigation complete; no suspect identified', ''),
(143, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.462205', '52.159375', 'On or near Torridge Rise', 'E01017455', 'Bedford 005C', 'Anti-social behaviour', '', ''),
(144, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.465331', '52.158625', 'On or near Hawk Drive', 'E01017455', 'Bedford 005C', 'Anti-social behaviour', '', ''),
(145, 'b2759cb2b06d891647b0a8ced812b766041b5b3a3d8484a5a6d9cfee30b67227', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.463137', '52.159918', 'On or near Cherwell Road', 'E01017455', 'Bedford 005C', 'Burglary', 'Investigation complete; no suspect identified', ''),
(146, 'bb70ab5f845de2c1f8f1458d64d0948c0b1cfab39e4894e186adc17ff1dc90d9', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.462205', '52.159375', 'On or near Torridge Rise', 'E01017455', 'Bedford 005C', 'Other theft', 'Unable to prosecute suspect', ''),
(147, '97bdb0892c143f0d5e061cb355e01fb2e26e486bc8b388fd3caf19110916ab2b', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.465331', '52.158625', 'On or near Hawk Drive', 'E01017455', 'Bedford 005C', 'Public order', 'Awaiting court outcome', ''),
(148, 'bdcb7659d07142e21213978bcaef049c0039a02b00d654596c3fd3f27689d7ed', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.462205', '52.159375', 'On or near Torridge Rise', 'E01017455', 'Bedford 005C', 'Violence and sexual offences', 'Unable to prosecute suspect', ''),
(149, '8ef2b492b754bdae2796674586995b5463862d9b5844af52e7e228a3f94eb838', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.465331', '52.158625', 'On or near Hawk Drive', 'E01017455', 'Bedford 005C', 'Violence and sexual offences', 'Awaiting court outcome', ''),
(150, '3ec5e9f80aaeaa251924aae08147d25015dda1d62b37d3b55c8e4ef85cd2cb20', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.465331', '52.158625', 'On or near Hawk Drive', 'E01017455', 'Bedford 005C', 'Violence and sexual offences', 'Awaiting court outcome', ''),
(151, '11c1c51cfcf629f1d18a257feaa46159f7ce2c5dc315b1ff5fe5b8c442d0be90', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.457802', '52.155650', 'On or near Francis Groves Close', 'E01017455', 'Bedford 005C', 'Other crime', 'Status update unavailable', ''),
(152, '76357c25a83514dfafe9603d0b5f0cc14faa3a81596f55909616003094022593', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.457278', '52.153053', 'On or near Fulmar Road', 'E01017456', 'Bedford 005D', 'Public order', 'Local resolution', ''),
(153, '88d25b5adceebbf0addc01417e2163d4d87d0510fe92184bed48ac8c5854f4e0', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.459008', '52.152051', 'On or near Pipit Rise', 'E01017456', 'Bedford 005D', 'Violence and sexual offences', 'Unable to prosecute suspect', ''),
(154, '713ccc879c936c1d08851768154936cb4ecb4abafd3d09bb3ae9129f99ac8c3c', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.459008', '52.152051', 'On or near Pipit Rise', 'E01017456', 'Bedford 005D', 'Violence and sexual offences', 'Unable to prosecute suspect', ''),
(155, '5336a48376639a728ddd36a8c0fd5777f25d8306b32a3fb106d8dc3692577686', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.459008', '52.152051', 'On or near Pipit Rise', 'E01017456', 'Bedford 005D', 'Other crime', 'Unable to prosecute suspect', ''),
(156, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.470037', '52.151412', 'On or near Eagle Gardens', 'E01017457', 'Bedford 005E', 'Anti-social behaviour', '', ''),
(157, '', NULL, 'Bedfordshire Police', 'Bedfordshire Police', '-0.465181', '52.154046', 'On or near Parking Area', 'E01017457', 'Bedford 005E', 'Anti-social behaviour', '', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
