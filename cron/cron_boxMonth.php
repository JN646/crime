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
	
	
	
	// Select a box. never been updated, active, prioritised
	$sqlBoxQ = "SELECT * FROM `box` WHERE timeseries_updated IS NULL AND active = 1 ORDER BY priority DESC LIMIT 1";
	$sqlBoxR = mysqli_query($mysqli, $sqlBoxQ);
	$box = mysqli_fetch_assoc($sqlBoxR);
	// If no un-updated found. find timeseries_update<priorety updated active, prioritised
	if(!$sqlBoxR) {
		$sqlBoxQ = "SELECT * FROM `box` WHERE timeseries_updated < priority_updated AND active = 1 ORDER BY priority DESC LIMIT 1";
		$sqlBoxR = mysqli_query($mysqli, $sqlBoxQ);
		$box = mysqli_fetch_assoc($sqlBoxR);
	}
	
	if(!$sqlBoxR) {
		echo "Error<br>";
		return 0;
	}
	
	$bID = $box['id'];
	$sqlBoxMonthQ = "SELECT bm_id, bm_month FROM box_month WHERE bm_boxid = $bID";
	$sqlBoxMonthR = mysqli_query($mysqli, $sqlBoxMonthQ);
	
	// Find existing boxmonths
	$existingMonths = array();
	while($row = mysqli_fetch_array($sqlBoxMonthR)) {
		$existingMonths[] = $row['bm_month'];
	}
	
	echo "boxID: " . $bID . "<br>";
	
	// Process boxmonths that do not exist
	$M = 6; //Max months - to be determined by data ingestion process or manually set
	for($m=5; $m <= $M; $m++) {
		echo $m.": ";
		//verify that data from all constabularies exist
		//$verifyQ = "SELECT * FROM dataImport WHERE month = $m"; //this table needs to be made
		$verifyMonth = 1; //default verified for now
		
		// If not already processed and data for the month exists
		if(!in_array($m, $existingMonths) && $verifyMonth) {
			// Process timeSeries
			$crimeQ = "SELECT COUNT(data.id), COUNT(data.Latitude), COUNT(data.Longitude), COUNT(box.lat_min), COUNT(box.lat_max), COUNT(box.long_min), COUNT(box.long_max) FROM data, box WHERE box.id = $bID AND data.Month = $m AND data.Latitude > box.lat_min AND data.Latitude > box.lat_max AND data.Longitude > box.long_min AND data.Longitude > box.long_max";
			$crimeR = mysqli_query($mysqli, $crimeQ);
			var_dump($crimeR);
			echo "<br>";
			echo mysqli_fetch_array($crimeR)['COUNT(data.id)'];
		}
		echo "<br>";
	}
	
	
	
	// Header and Return
	//header('Location: ' . $_SERVER['HTTP_REFERER']);
?>