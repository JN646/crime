<?php
	// Add Database Connection
	require_once '../config/config.php';
	require_once '../lib/functions.php';
	
	
	$countQ = "SELECT COUNT(id) FROM `box`";
	$countR = mysqli_fetch_assoc(mysqli_query($mysqli, $countQ));
	$N = $countR['COUNT(id)'];
	$n = 1;
	
	$nowQ = "SELECT NOW() as now";
	$nowR = mysqli_fetch_assoc(mysqli_query($mysqli, $nowQ)); //now... approximately
	$now = strtotime($nowR['now']);
	
	while($n <= $N) {
		$boxQ = "SELECT * FROM `box` WHERE `id` = $n";
		$boxR = mysqli_fetch_assoc(mysqli_query($mysqli, $boxQ));
		$bID = $boxR['id'];
		if($boxR['active']) { //if box is active
			// Decide Priority.... somehow? requests * time since update?
			$priority = 0;
			if(is_null($boxR['timeseries_updated'])) {
				$priority = ($boxR['requests']);
			} else {
				$priority = ($boxR['requests']) * (1-(strtotime($boxR['timeseries_updated']/$now)));
			}
			
			$updateQ = "UPDATE `box` SET priority = $priority, priority_updated = NOW() WHERE `id` = $bID";
			$updateR = mysqli_fetch_assoc(mysqli_query($mysqli, $updateQ));
		}
		
		$n++;
	}
	

?>