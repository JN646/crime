<?php
// Initialise the session
session_start();

// Get Database Config
include_once '../config/config.php';
include_once 'functions.php';
include_once 'classes.php';


//############## CRIME COUNTER #################################################
function crimeCounter($latVal, $longVal)
{
	global $mysqli;

	// Enable time counter
	if ($TimeSeries_ExecTimer == TRUE) {
	  if ($CrimeCounter_ExecTimer) {
		$time_start = microtime(true); // Start Timer
	  }
	}

	function writeLog($mysqli, $latVal, $longVal, $radVal1, $radVal2) {
	  // Set Session ID to variable.
	  if (isset($_SESSION["id"])) {
		// If there is a session ID.
		$userid = $_SESSION["id"];
	  } else {
		// If there is no session ID.
		$userid = 0;
	  }

	  // Insert SQL
	  $report_logSQL = "INSERT INTO report_log (report_lat, report_long, report_immediate, report_local, report_user)
	  VALUES ($latVal, $longVal, $radVal1, $radVal2, $userid)";

	  // Run Query
	  $report_logSQLQ = mysqli_query($mysqli, $report_logSQL);

	  // If Error
	  if (!$report_logSQLQ) {
		  die('<p class="SQLError">Could not run query: ' . mysqli_error($mysqli) . '</p>');
	  }
	}

	

	// ########### MAIN ##########################################################
	global $IMMEDIATE_RAD;
	global $LOCAL_RAD;
	$loc = ['lat'=>$latVal, 'lng'=>$longVal];
	$latLow1	= computeOffset($loc, $IMMEDIATE_RAD, 180)['lat'];
	$latHigh1   = computeOffset($loc, $IMMEDIATE_RAD, 0)['lat'];
	$longLow1   = computeOffset($loc, $IMMEDIATE_RAD, 270)['lng'];
	$longHigh1  = computeOffset($loc, $IMMEDIATE_RAD, 90)['lng'];

	$latLow2	= computeOffset($loc, $LOCAL_RAD, 180)['lat'];
	$latHigh2   = computeOffset($loc, $LOCAL_RAD, 0)['lat'];
	$longLow2   = computeOffset($loc, $LOCAL_RAD, 270)['lng'];
	$longHigh2  = computeOffset($loc, $LOCAL_RAD, 90)['lng'];

	// Run Queries
	$resultCount_Immediate  = sqlCrimeArea($mysqli, $latVal, $longVal, $IMMEDIATE_RAD, $latLow1, $latHigh1, $longLow1, $longHigh1);
	$resultCount_Local	  = sqlCrimeArea($mysqli, $latVal, $longVal, $LOCAL_RAD, $latLow2, $latHigh2, $longLow2, $longHigh2);
	
	// Write to Log only if user is logged in.
	if ($require_logon_to_search == TRUE) {
		if(isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == true){
			writeLog($mysqli, $latVal, $longVal, $radVal1, $radVal2);
		}
	}

	// Generate Table of Data
	$table = preCalcTable($resultCount_Immediate, $resultCount_Local, $IMMEDIATE_RAD, $LOCAL_RAD);

	// Generate Ordered Colour Array
	$colours = getChartColours($table['Crime Type']);

	$d = new ChartData();
	$d->type = 'bar';
	$d->labels = $table['Crime Type'];
	$d->addDataset($table['Risk'], 'Risk', $colours);
	$d->legend = false;
	$d->toolTips = false;

	// Display Script End time
	if ($CrimeCounter_ExecTimer) {
		$time_end = microtime(true);
		
		//dividing with 60 will give the execution time in minutes other wise seconds
		$execution_time = ($time_end - $time_start);
		
		echo '<b>Total Execution Time:</b> ' . number_format($execution_time, 4) . ' Seconds';
	}

	return $d->getData();
}
?>
