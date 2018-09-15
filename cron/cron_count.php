<?php
// Add Database Connection
require_once '../config/config.php';

//############## MAIN ##########################################################
cronCountCrimes($mysqli);
cronCountCrimeTypes($mysqli);
cronCountMonths($mysqli);
cronCountNoLocation($mysqli);
cronCountFallsWithin($mysqli);
cronCountReportedBy($mysqli);

//############## Count All Crimes ##############################################
function cronCountCrimes($mysqli) {
  // SELECT All
  $query = "SELECT COUNT(*) FROM data";
  $result = mysqli_query($mysqli, $query);
  $rows = mysqli_fetch_row($result);

  mysqli_free_result($result); // Free Query

  $count = $rows[0]; // Return Value.

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

  $count = $rows[0]; // Return Value.

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

  $count = $rows[0]; // Return Value.

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
