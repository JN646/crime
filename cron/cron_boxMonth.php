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
	
	
	for($i=0; $i<100; $i++) {
		processABox($mysqli);
	}
	
	
	function processABox($mysqli) {
		// Select a box. never been updated, active, prioritised
		$sqlBoxQ = "SELECT * FROM `box` WHERE timeseries_updated IS NULL AND active = 1 ORDER BY priority DESC LIMIT 1";
		$sqlBoxR = mysqli_query($mysqli, $sqlBoxQ);
		$box = mysqli_fetch_assoc($sqlBoxR);
		// If no un-updated found. find timeseries_update<priorety_updated, active, prioritised
		if(!$sqlBoxR) {
			$sqlBoxQ = "SELECT * FROM `box` WHERE timeseries_updated < priority_updated AND active = 1 ORDER BY priority DESC LIMIT 1";
			$sqlBoxR = mysqli_query($mysqli, $sqlBoxQ);
			$box = mysqli_fetch_assoc($sqlBoxR);
		}
	
		if(!$sqlBoxR) {
			// In this instance (in theory), all active boxes have been processed since updating their priority.
			// Suggest updating priority and starting procesing for time series again.
			echo '<p class="SQLError">Could not run query: ' . mysqli_error($mysqli) . '</p>';
			return 0;
		}
			
		// Final boxID
		$bID = $box['id'];
		
		// Find all the boxmonths that exist for this box
		$sqlBoxMonthQ = "SELECT bm_id, bm_month FROM box_month WHERE bm_boxid = $bID";
		$sqlBoxMonthR = mysqli_query($mysqli, $sqlBoxMonthQ);
		
		$existingMonths = array();
		while($row = mysqli_fetch_array($sqlBoxMonthR)) {
			$existingMonths[] = $row['bm_month'];
		}
		
	
		// Process boxmonths that do not exist
		$M = 48; //Max months - to be determined by data ingestion process or manually set
		for($m=0; $m<=$M; $m++) {
			$date = intAsDate($m); //$m as a date like "2018-10"
			$dateS = '"'.$date.'"'; //$date as 'string'?
			
			
			//verify that data from all constabularies exist
			//$verifyQ = "SELECT * FROM dataImport WHERE month = $m"; //this table needs to be made
			$verifyMonth = 1; //default verified for now
			
			// If not already processed and data for the month exists
			if(!in_array(intAsDate($m), $existingMonths) && $verifyMonth) {
				// Process timeSeries
				
				$crimeQ = "SELECT COUNT(data.id) AS count, data.Crime_Type AS type, data.Month, COUNT(data.Latitude), COUNT(data.Longitude), COUNT(box.lat_min), COUNT(box.lat_max), COUNT(box.long_min), COUNT(box.long_max) FROM data, box
				WHERE box.id = $bID AND data.Month = $dateS AND data.Latitude > box.lat_min AND data.Latitude > box.lat_max AND data.Longitude > box.long_min AND data.Longitude > box.long_max
				GROUP BY data.Crime_Type";
				
				$crimeR = mysqli_query($mysqli, $crimeQ);
				//echo "RESULT: " . $crimeR . " <br>"; //THIS BREAKS SHIT. I DON'T KNOW WHY.
				if(!$crimeR) {
					echo '<p class="SQLError">Could not run query: ' . mysqli_error($mysqli) . '</p>';
					return 0;
				}
				
				$types = array();
				$counts = array();
				while($row = mysqli_fetch_array($crimeR)) {
					//echo $row["type"] . ": " . $row['count'] . "<br>";
					$types[] =  "`".$row["type"]."`";
					$counts[] = $row["count"];
				}
				
				$columns = "bm_month, bm_boxid";
				$values =  "'" . $date . "', " . $bID;
					
				// This means if returned no crimes of any type. This could mean error & don't insert.
				// Behaviour must be defined further.
					if(count($types) > 0) {
					//append $types and $counts to $columns and $values
					$columns = $columns . ", " . implode(", ", $types);
					$values = $values . ", " . implode(", ", $counts);
					}
				$insertQ = "INSERT INTO box_month ($columns) VALUES ($values)";
				$insertR = mysqli_query($mysqli, $insertQ);
	
				// If insert success, update box
				if($insertR) {
					$updateQ = "UPDATE box SET timeseries_updated = NOW() WHERE `id` = $bID";
					$updateR = mysqli_query($mysqli, $updateQ);
					if(!$updateR) {
						echo "Error updating timeseries_updated of box<br>";
					}
				}
			}
		}
	}


	// Header and Return
	//header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
