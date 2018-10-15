<?php
	require_once '../config/config.php';
	require_once '../lib/functions.php';
	
	// ($mysqli, [box-id], [month-start], [month-end])
	$data = getTimeSeries($mysqli, 3391);
	
	
	//timeSeriesRequest(52, 0);
	
	// A request from a device to get timeseries information
	function timeSeriesRequest($lat, $long) {
		global $mysqli;
		
		// Find nearby boxes
		$t = 0.2; //threshold in radians
		$boxesQ = "SELECT * FROM `box` WHERE SQRT(POW(`latitude`-'$lat', 2)+POW(`longitude`-'$long', 2))<'$t'";
		$boxesR = mysqli_query($mysqli, $boxesQ);
		
		// Calculate nearest from nearby boxes
		$distance = []; //from lat long
		while($row = mysqli_fetch_assoc($boxesR)) {
			//echo $row['id']."<br>";
			$distance[$row['id']] = computeArcDistance($lat, $long, $row['latitude'], $row['longitude']);
			echo $row['id'].": ".round($distance[$row['id']])." meters<br>";
			//var_dump($distance);
		}
		$nearest = array_keys($distance, min($distance))[0];
		
		$data = getTimeSeries($mysqli, $nearest);
		
		return $data;
	}
	
	
	
?>