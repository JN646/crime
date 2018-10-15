<?php
// Add Database Connection
require_once '../config/config.php';

//############## MAIN ##########################################################
cronCreateStatTable($mysqli);
cronCreateBox($mysqli);
cronCreateBoxMonth($mysqli);
cronCreateUsers($mysqli);
cronReportLog($mysqli);
cronCreateConstabList($mysqli);
cronCreateCrimeTypeList($mysqli);

//############## Create Stat Table #############################################
function cronCreateStatTable($mysqli)
{
    // SELECT All
    $query = "SELECT id FROM stats";
    $result = mysqli_query($mysqli, $query);

    if (empty($result)) {
        // Create table if doesn't exist.
        $query = "CREATE TABLE IF NOT EXISTS `stats` (
      `id` int(11) NOT NULL AUTO_INCREMENT AUTO_INCREMENT COMMENT 'Statistic ID',
      `stat` varchar(100) DEFAULT NULL COMMENT 'Statistic Name',
      `count` varchar(255) DEFAULT '0' COMMENT 'Statistic Count',
      `last_run` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Updated',
      PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1";
        $result = mysqli_query($mysqli, $query);

        // If Error
        if (!$result) {
            die('<p class="SQLError">Could not create stat table: ' . mysqli_error($mysqli) . '</p>');
        }
    }
}



//############## Create Report Log #############################################
function cronReportLog($mysqli)
{
    // SELECT All
    $query = "SELECT id FROM 'report_log'";
    $result = mysqli_query($mysqli, $query);

    if (empty($result)) {
        // Create table if doesn't exist.
        $query = "CREATE TABLE IF NOT EXISTS `report_log` (
          `report_id` int(11) NOT NULL COMMENT 'The report ID number',
          `report_lat` decimal(9,6) DEFAULT NULL COMMENT 'The Latitude for the report.',
          `report_long` decimal(9,6) DEFAULT NULL COMMENT 'The Longitude for the report.',
          `report_immediate` float DEFAULT NULL COMMENT 'Immediate Radius.',
          `report_local` float DEFAULT NULL COMMENT 'Local Radius.',
          `report_user` int(11) DEFAULT '0' COMMENT 'The ID number of the user that has created the report.',
          `report_comment` varchar(255) DEFAULT NULL COMMENT 'Comment about the report.',
          `report_bookmarked` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Has the report been bookmarked?'
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
        $result = mysqli_query($mysqli, $query);

        // If Error
        if (!$result) {
            die('<p class="SQLError">SQL ERROR: Create report_log ' . mysqli_error($mysqli) . '</p>');
        }
    }
}

//############## Create Box ####################################################
function cronCreateBox($mysqli)
{
    // SELECT All
    $query = "SELECT id FROM 'box'";
    $result = mysqli_query($mysqli, $query);

    if (empty($result)) {
        // Create table if doesn't exist.
        $query = "CREATE TABLE IF NOT EXISTS `box` (
          `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
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
        ) ENGINE=MyISAM DEFAULT CHARSET=latin1";
        $result = mysqli_query($mysqli, $query);

        // If Error
        if (!$result) {
            die('<p class="SQLError">SQL ERROR: Create box ' . mysqli_error($mysqli) . '</p>');
        }
    }
}

//############## Create Box Month ##############################################
function cronCreateBoxMonth($mysqli)
{
    // SELECT All
    $query = "SELECT id FROM 'box_month'";
    $result = mysqli_query($mysqli, $query);

    if (empty($result)) {
        // Create table if doesn't exist.
        $query = "CREATE TABLE IF NOT EXISTS `box_month` (
          `bm_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
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
        ) ENGINE=MyISAM DEFAULT CHARSET=latin1";
        $result = mysqli_query($mysqli, $query);

        // If Error
        if (!$result) {
            die('<p class="SQLError">SQL ERROR: Create box_month ' . mysqli_error($mysqli) . '</p>');
        }
    }
}

//############## Create Users ##################################################
function cronCreateUsers($mysqli)
{
    // SELECT All
    $query = "SELECT id FROM 'users'";
    $result = mysqli_query($mysqli, $query);

    if (empty($result)) {
        // Create table if doesn't exist.
        $query = "CREATE TABLE IF NOT EXISTS `users` (
        `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        `username` VARCHAR(50) NOT NULL UNIQUE,
        `email` VARCHAR(50) NULL,
        `password` VARCHAR(255) NOT NULL,
        `admin` BOOLEAN NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $result = mysqli_query($mysqli, $query);

        // If Error
        if (!$result) {
            die('<p class="SQLError">SQL ERROR: Create users ' . mysqli_error($mysqli) . '</p>');
        }
    }
}

//############## Create Constab List ##################################################
function cronCreateConstabList($mysqli)
{
    // SELECT All
    $query = "SELECT constab_id FROM 'data_constab'";
    $result = mysqli_query($mysqli, $query);

    if (empty($result)) {
        // Create table if doesn't exist.
        $query = "CREATE TABLE IF NOT EXISTS `data_constab` (
          `constab_id` int(11) PRIMARY KEY NOT NULL,
          `constab_name` varchar(255) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
        $result = mysqli_query($mysqli, $query);

        // If Error
        if (!$result) {
            die('<p class="SQLError">SQL ERROR: Create Constabulary List ' . mysqli_error($mysqli) . '</p>');
        }

        // Insert Data.
        $query = "INSERT INTO `data_constab` (`constab_id`, `constab_name`) VALUES
        (2, 'Avon and Somerset Constabulary'),
        (3, 'Bedfordshire Police'),
        (4, 'Cambridgeshire Constabulary'),
        (5, 'Cheshire Constabulary'),
        (6, 'City of London Police'),
        (7, 'Cleveland Police'),
        (8, 'Cumbria Constabulary'),
        (9, 'Derbyshire Constabulary'),
        (10, 'Devon & Cornwall Police'),
        (11, 'Dorset Police'),
        (12, 'Durham Constabulary'),
        (13, 'Essex Police'),
        (14, 'Gloucestershire Constabulary'),
        (15, 'Greater Manchester Police'),
        (16, 'Hampshire Constabulary'),
        (17, 'Hertfordshire Constabulary'),
        (18, 'Humberside Police'),
        (19, 'Kent Police'),
        (20, 'Lancashire Constabulary'),
        (21, 'Leicestershire Police'),
        (22, 'Lincolnshire Police'),
        (23, 'Merseyside Police'),
        (24, 'Metropolitan Police Service'),
        (25, 'Norfolk Constabulary'),
        (26, 'North Yorkshire Police'),
        (27, 'Northamptonshire Police'),
        (28, 'Northumbria Police'),
        (29, 'Nottinghamshire Police'),
        (30, 'South Yorkshire Police'),
        (31, 'Staffordshire Police'),
        (32, 'Suffolk Constabulary'),
        (33, 'Surrey Police'),
        (34, 'Sussex Police'),
        (35, 'Thames Valley Police'),
        (36, 'Warwickshire Police'),
        (37, 'West Mercia Police'),
        (38, 'West Midlands Police'),
        (39, 'West Yorkshire Police'),
        (40, 'Wiltshire Police')";
        $result = mysqli_query($mysqli, $query);
    }
}

//############## Create Crime Type List ##################################################
function cronCreateCrimeTypeList($mysqli)
{
    // SELECT All
    $query = "SELECT `id` FROM `data_crimes`";
    $result = mysqli_query($mysqli, $query);
	
    if (empty($result)) {
        // Create table if doesn't exist.
        $query = "CREATE TABLE IF NOT EXISTS `data_crimes` (
          `id` int(11) PRIMARY KEY NOT NULL,
          `crime_type` varchar(255) DEFAULT NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
        $result = mysqli_query($mysqli, $query);
		
        // If Error
        if (!$result) {
            die('<p class="SQLError">SQL ERROR: Create Crime Type List ' . mysqli_error($mysqli) . '</p>');
        }
    }
}

// Header and Return
header('Location: ' . $_SERVER['HTTP_REFERER']);
