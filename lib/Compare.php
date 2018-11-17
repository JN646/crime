<?php
// Initialise the session
session_start();

// Get Database Config
include_once '../config/config.php';
include_once 'functions.php';
include_once 'classes.php';


//############## CRIME COUNTER #################################################
function compareRequest($latVal1, $longVal1, $latVal2, $longVal2)
{
	global $mysqli;
	global $IMMEDIATE_RAD;
	global $LOCAL_RAD;

	// Location 1
	$loc1 = ['lat'=>$latVal1, 'lng'=>$longVal1];
	$latLow1	= computeOffset($loc1, $IMMEDIATE_RAD, 180)['lat'];
	$latHigh1   = computeOffset($loc1, $IMMEDIATE_RAD, 0)['lat'];
	$longLow1   = computeOffset($loc1, $IMMEDIATE_RAD, 270)['lng'];
	$longHigh1  = computeOffset($loc1, $IMMEDIATE_RAD, 90)['lng'];

	// Location 2
	$loc2 = ['lat'=>$latVal2, 'lng'=>$longVal2];
	$latLow2	= computeOffset($loc2, $LOCAL_RAD, 180)['lat'];
	$latHigh2   = computeOffset($loc2, $LOCAL_RAD, 0)['lat'];
	$longLow2   = computeOffset($loc2, $LOCAL_RAD, 270)['lng'];
	$longHigh2  = computeOffset($loc2, $LOCAL_RAD, 90)['lng'];

	// Run Queries
	$resultCount1  = sqlCrimeArea($mysqli, $latVal1, $longVal1, $LOCAL_RAD, $latLow1, $latHigh1, $longLow1, $longHigh1);
	$resultCount2  = sqlCrimeArea($mysqli, $latVal2, $longVal2, $LOCAL_RAD, $latLow2, $latHigh2, $longLow2, $longHigh2);

	// Generate Table of Data
	$table = preCalcTable($resultCount1, $resultCount2, $LOCAL_RAD, $LOCAL_RAD);

	// Generate Ordered Colour Array
	$colours = getChartColours($table['Crime Type']);

	// Generate Chart Data
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

		// Display Execution Time.
		if ($exectime_compare == TRUE) {
			echo '<b>Total Execution Time:</b> ' . number_format($execution_time, 4) . ' Seconds';
		}
	}

	return $d->getData();
}
?>
