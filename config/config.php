<?php
//############## SQL Connection ################################################
// Database
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'crimes');

// Get Connection
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

 // If Connection Fail
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Global Variables.
define("LOCAL", "http://localhost/crime/"); //local URL
define("WEB", "http://192.168.1.72:80/crime/"); //website URL
$environment = LOCAL; //change to WEB if you're live


// IN METERS NOW
$boxHop = 10000; //10km???
$boxSize = 120000; //120km

// Global Settings
$require_logon_to_search = TRUE;

// Time Series
$TimeSeries_ExecTimer == TRUE;

// Crime Counter
$CrimeCounter_ExecTimer == TRUE;
?>
