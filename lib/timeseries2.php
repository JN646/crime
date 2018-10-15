<?php
	//timeSeriesRequest(52, 0);
	
	// A request from a device to get timeseries information
	function timeSeriesRequest($lat, $long) {
		global $mysqli;
		
		// Find Nearby Boxes
		$t = 0.2; //threshold in radians
		$boxesQ = "SELECT * FROM `box`
			WHERE `longitude` > ($long-$t)
        	AND `longitude` < ($long+$t)
        	AND `latitude` > ($lat-$t)
        	AND `latitude` < ($lat+$t)
        	AND SQRT(POW(`latitude`-'$lat', 2)+POW(`longitude`-'$long', 2))<'$t'";
		$boxesR = mysqli_query($mysqli, $boxesQ);
		
		// Calculate nearest from nearby boxes
		$distance = []; //from lat long
		while($row = mysqli_fetch_assoc($boxesR)) {
			$distance[$row['id']] = computeArcDistance($lat, $long, $row['latitude'], $row['longitude']);
		}
		$nearestBox = array_keys($distance, min($distance))[0];
		
		// Get the time series data
		$data = getTimeSeriesData($mysqli, $nearestBox);
		
		return $data;
	}
	
?>