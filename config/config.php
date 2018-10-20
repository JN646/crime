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


// Constants
// in SI units (meters)
$boxHop = 8000; //ideal size is 8-10km.
$boxSize = 10000; //10km
$EARTH_RADIUS = 6371000;
$IMMEDIATE_RAD = 500;
$LOCAL_RAD = 2000;
$IMMEDIATE_AREA = M_PI*$IMMEDIATE_RAD*$IMMEDIATE_RAD;
$LOCAL_AREA = M_PI*$LOCAL_RAD*$LOCAL_RAD;


// Define Crime Colours
$ALPHA = '0.3';
$CRIME_COLOURS = [
		'Anti-social behaviour'=>'rgba(220,20,60, '.$ALPHA.')',
		'Bicycle theft'=>'rgba(255,140,0, '.$ALPHA.')',
		'Burglary'=>'rgba(255,215,0, '.$ALPHA.')',
		'Criminal damage and arson'=>'rgba(154,205,50, '.$ALPHA.')',
		'Drugs'=>'rgba(175,238,238, '.$ALPHA.')',
		'Other crime'=>'rgba(65,105,225, '.$ALPHA.')',
		'Other theft'=>'rgba(138,43,226, '.$ALPHA.')',
		'Possession of weapons'=>'rgba(186,85,211, '.$ALPHA.')',
		'Public order'=>'rgba(165,42,42, '.$ALPHA.')',
		'Robbery'=>'rgba(107,142,35, '.$ALPHA.')',
		'Shoplifting'=>'rgba(30,144,255, '.$ALPHA.')',
		'Theft from the person'=>'rgba(72,61,139, '.$ALPHA.')',
		'Vehicle crime'=>'rgba(199,21,133, '.$ALPHA.')',
		'Violence and sexual offences'=>'rgba(0,0,128, '.$ALPHA.')'
];

// Global Settings
$require_logon_to_search = TRUE;
$welcome_savingEnabled = TRUE;

// Menu Items
$menu_usermanage = TRUE;
$menu_crimemanage = TRUE;

// Time Series
$TimeSeries_ExecTimer = TRUE;

// Crime Counter
$CrimeCounter_ExecTimer = TRUE;
?>
