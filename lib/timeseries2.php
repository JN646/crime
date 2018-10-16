<?php
	//timeSeriesRequest(52, 0);
	
	// A request from a device to get timeseries information
	function timeSeriesRequest($lat, $long) {
		global $mysqli;
		
		$nearestBox = getBoxByLoc($mysqli, $lat, $long);
		
		// Get the time series data
		$data = getTimeSeriesData($mysqli, $nearestBox);
		
		return $data;
	}
	
?>