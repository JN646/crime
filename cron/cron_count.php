<?php
// Add Database Connection
include_once '../config/config.php';

//############## COUNT THINGS ##################################################
cronCountCrimes($mysqli);
cronCountCrimeTypes($mysqli);
cronCountMonths($mysqli);

//############## Count All Crimes ##############################################
function cronCountCrimes($mysqli) {
  // SELECT All
  $query = "SELECT COUNT(*) FROM data";
  $result = mysqli_query($mysqli, $query);
  $rows = mysqli_fetch_row($result);

  // Free Query
  mysqli_free_result($result);

  // Return Value.
  $count = $rows[0];

  // Run Query
  $sqlCrimeCount = "UPDATE stats SET count = $count WHERE stat = 'Crime Count'";

  $writeCrimeCount = mysqli_query($mysqli, $sqlCrimeCount);
  $sqlCrimeCountOutput = mysqli_fetch_row($writeCrimeCount);

  // Free Query
  mysqli_free_result($writeCrimeCount);
}

//############## Count All Crime Types #########################################
function cronCountCrimeTypes($mysqli) {
  // SELECT CRIME TYPES
  $query = "SELECT COUNT(DISTINCT(CRIME_Type)) FROM data";
  $result = mysqli_query($mysqli, $query);
  $rows = mysqli_fetch_row($result);

  // Free Query
  mysqli_free_result($result);

  // Return Value.
  $count = $rows[0];

  // Run Query
  $sqlCrimeCount = "UPDATE stats SET count = $count WHERE stat = 'All Crime Types'";

  $writeCrimeCount = mysqli_query($mysqli, $sqlCrimeCount);
  $sqlCrimeCountOutput = mysqli_fetch_row($writeCrimeCount);

  // Free Query
  mysqli_free_result($writeCrimeCount);
}

//############## Count Months ##################################################
function cronCountMonths($mysqli) {
  // SELECT CRIME TYPES
  $query = "SELECT COUNT(DISTINCT(Month)) FROM data";
  $result = mysqli_query($mysqli, $query);
  $rows = mysqli_fetch_row($result);

  // Free Query
  mysqli_free_result($result);

  // Return Value.
  $count = $rows[0];

  // Run Query
  $sqlCrimeCount = "UPDATE stats SET count = $count WHERE stat = 'Months worth of data'";

  $writeCrimeCount = mysqli_query($mysqli, $sqlCrimeCount);
  $sqlCrimeCountOutput = mysqli_fetch_row($writeCrimeCount);

  // Free Query
  mysqli_free_result($writeCrimeCount);
}

// Header and Return
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
