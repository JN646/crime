<?php
	/*
	*	Generates a new row entry in table "box_month" for each month for each box.
	*	Each row contains a number for each type of crime in that box-month.
	*	
	* 	Process:
	*	- [Potential pre-process] calculate priority.
	*	- Select a box (could be random, iterative, or priority based)
	*	- Pull all months for that box
	*	- Decide which months need processing (this could be ones that need re-
	*	  processing, or have not been processed yet. This is why we could do with an
	*	  upload manager.)
	*	- Total the types of crimes inside the box & insert to box_month!
	*	- Repeat indefinately
	*/
	
	// Add Database Connection
	require_once '../config/config.php';
	require_once '../lib/functions.php';
	
	// Select a box
	$sqlBoxQ = "SELECT * FROM `box` WHERE timeseries_updated IS NULL ORDER BY priority DESC LIMIT 1";
	$sqlBoxR = mysqli_query($mysqli, $sqlBoxQ);
	$box = mysqli_fetch_assoc($sqlBoxR);
	// If no NULL timeseries_updated, pick highest priority
	if(!$sqlBoxR) {
		$sqlBoxQ = "SELECT * FROM `box` WHERE timeseries_updated < priority_updated ORDER BY priority DESC LIMIT 1";
		$sqlBoxR = mysqli_query($mysqli, $sqlBoxQ);
		$box = mysqli_fetch_assoc($sqlBoxR);
	}
	
	if(!$sqlBoxR) {
		echo "Error<br>";
		return 0;
	}
	
	$bID = $box['id'];
	echo $bID . "<br>";
	$sqlBoxMonthQ = "SELECT * FROM box_month WHERE bm_boxid = $bID";
	$sqlBoxMonthR = mysqli_query($mysqli, $sqlBoxMonthQ);
	$boxmonth = mysqli_fetch_array($sqlBoxMonthR);
	// If no boxmonth's exist for the chosen box
	if(is_null($boxmonth)) {
		// Calc all available timeseries data
	} else {
		// Review what is there, and fill in the gaps
	}
	var_dump($boxmonth);
	echo "<br>";
	echo $boxmonth[0] . "<br>";
	echo $boxmonth[1] . "<br>";
	
	// Header and Return
	//header('Location: ' . $_SERVER['HTTP_REFERER']);
?>