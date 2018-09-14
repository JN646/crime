<?php
// Add Database Connection
include_once '../config/config.php';

//############## COUNT THINGS ##################################################
cronCreateStatTable($mysqli);
cronCountCrimes($mysqli);
cronCountCrimeTypes($mysqli);
cronCountMonths($mysqli);
cronCountNoLocation($mysqli);
cronCountFallsWithin($mysqli);
cronCountReportedBy($mysqli);

//############## Count All Crimes ##############################################
function cronCreateStatTable($mysqli) {
  // SELECT All
  $query = "SELECT id FROM stats";
  $result = mysqli_query($mysqli, $query);

  if(empty($result)) {
    // Create table if doesn't exist.
    $query = "CREATE TABLE IF NOT EXISTS `stats` (
      `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Statistic ID',
      `stat` varchar(100) DEFAULT NULL COMMENT 'Statistic Name',
      `count` int(11) DEFAULT '0' COMMENT 'Statistic Count',
      `last_run` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Updated',
      PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1";
    $result = mysqli_query($mysqli, $query);

    // Insert Data.
    $query = "INSERT INTO `stats` (`id`, `stat`, `count`, `last_run`) VALUES
    (1, 'Crime Count', 0, '2018-09-13 22:44:57'),
    (2, 'All Crime Types', 0, '2018-09-13 22:48:15'),
    (3, 'Months worth of data', 0, '2018-09-13 23:01:54'),
    (4, 'Crimes with no location', 0, '2018-09-14 15:52:26'),
    (5, 'Falls Within', 0, '2018-09-14 15:52:27'),
    (6, 'Reported By', 0, '2018-09-14 15:45:42')";
    $result = mysqli_query($mysqli, $query);
  }

  mysqli_free_result($result); // Free Query
}

//############## Count All Crimes ##############################################
function cronCountCrimes($mysqli) {
  // SELECT All
  $query = "SELECT COUNT(*) FROM data";
  $result = mysqli_query($mysqli, $query);
  $rows = mysqli_fetch_row($result);

  mysqli_free_result($result); // Free Query

  // Return Value.
  $count = $rows[0];

  // Run Query
  $sqlCrimeCount = "UPDATE stats SET count = $count WHERE stat = 'Crime Count'";

  $writeCrimeCount = mysqli_query($mysqli, $sqlCrimeCount);
  $sqlCrimeCountOutput = mysqli_fetch_row($writeCrimeCount);

  mysqli_free_result($writeCrimeCount); // Free Query
}

//############## Count All Crime Types #########################################
function cronCountCrimeTypes($mysqli) {
  // SELECT CRIME TYPES
  $query = "SELECT COUNT(DISTINCT(CRIME_Type)) FROM data";
  $result = mysqli_query($mysqli, $query);
  $rows = mysqli_fetch_row($result);
  mysqli_free_result($result); // Free Query

  // Return Value.
  $count = $rows[0];

  // Run Query
  $sqlCrimeCount = "UPDATE stats SET count = $count WHERE stat = 'All Crime Types'";

  $writeCrimeCount = mysqli_query($mysqli, $sqlCrimeCount);
  $sqlCrimeCountOutput = mysqli_fetch_row($writeCrimeCount);

  mysqli_free_result($writeCrimeCount); // Free Query
}

//############## Count Months ##################################################
function cronCountMonths($mysqli) {
  // SELECT CRIME TYPES
  $query = "SELECT COUNT(DISTINCT(Month)) FROM data";
  $result = mysqli_query($mysqli, $query);
  $rows = mysqli_fetch_row($result);
  mysqli_free_result($result); // Free Query

  // Return Value.
  $count = $rows[0];

  // Run Query
  $sqlCrimeCount = "UPDATE stats SET count = $count WHERE stat = 'Months worth of data'";

  $writeCrimeCount = mysqli_query($mysqli, $sqlCrimeCount);
  $sqlCrimeCountOutput = mysqli_fetch_row($writeCrimeCount);

  mysqli_free_result($writeCrimeCount); // Free Query
}

// Header and Return
header('Location: ' . $_SERVER['HTTP_REFERER']);

//############## Count No Location #############################################
function cronCountNoLocation($mysqli) {
  // SELECT CRIME TYPES
  $query = "SELECT COUNT(DISTINCT(ID)) FROM data WHERE Longitude = 0 AND Latitude = 0";
  $result = mysqli_query($mysqli, $query);
  $rows = mysqli_fetch_row($result);

  mysqli_free_result($result); // Free Query

  // Run Query
  $sqlCrimeCount = "UPDATE stats SET count = $count WHERE stat = 'Crimes with no location'";

  $writeCrimeCount = mysqli_query($mysqli, $sqlCrimeCount);
  $sqlCrimeCountOutput = mysqli_fetch_row($writeCrimeCount);

  mysqli_free_result($writeCrimeCount); // Free Query
}

//############## Count Falls Within ############################################
function cronCountFallsWithin($mysqli) {
  // SELECT CRIME TYPES
  $query = "SELECT COUNT(DISTINCT(Falls_Within)) FROM data";
  $result = mysqli_query($mysqli, $query);
  $rows = mysqli_fetch_row($result);
  mysqli_free_result($result); // Free Query

  // Return Value.
  $count = $rows[0];

  // Run Query
  $sqlCrimeCount = "UPDATE stats SET count = $count WHERE stat = 'Falls Within'";

  $writeCrimeCount = mysqli_query($mysqli, $sqlCrimeCount);
  $sqlCrimeCountOutput = mysqli_fetch_row($writeCrimeCount);

  mysqli_free_result($writeCrimeCount); // Free Query
}

//############## Count Reported By #############################################
function cronCountReportedBy($mysqli) {
  // SELECT CRIME TYPES
  $query = "SELECT COUNT(DISTINCT(Falls_Within)) FROM data";
  $result = mysqli_query($mysqli, $query);
  $rows = mysqli_fetch_row($result);
  mysqli_free_result($result); // Free Query

  // Return Value.
  $count = $rows[0];

  // Run Query
  $sqlCrimeCount = "UPDATE stats SET count = $count WHERE stat = 'Reported By'";

  $writeCrimeCount = mysqli_query($mysqli, $sqlCrimeCount);
  $sqlCrimeCountOutput = mysqli_fetch_row($writeCrimeCount);

  mysqli_free_result($writeCrimeCount); // Free Query
}

// Header and Return
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
