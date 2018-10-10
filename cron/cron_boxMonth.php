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
	
	//Select a box
	$sqlBoxQ = "SELECT * FROM `box` WHERE timeseries_updated IS NULL ORDER BY priority DESC LIMIT 1";
	$sqlBoxR = mysqli_query($mysqli, $sqlBoxQ);
	$box = mysqli_fetch_assoc($sqlBoxR);
	var_dump($box);
	if(!$sqlBoxR) { //if no NULL results, pick highest priority
		$sqlBoxQ = "SELECT * FROM `box` WHERE timeseries_updated < priority_updated ORDER BY priority DESC LIMIT 1";
		$sqlBoxR = mysqli_query($mysqli, $sqlBoxQ);
	}
	if(!$sqlBoxR) {
		echo "Error<br>";
		return 0;
	}
	
	
	
	// Header and Return
	//header('Location: ' . $_SERVER['HTTP_REFERER']);
?>