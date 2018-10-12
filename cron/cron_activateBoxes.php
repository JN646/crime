<?php
// Add Database Connection
require_once '../config/config.php';
require_once '../lib/functions.php';


//############## Activate BOXES #################################################
function activateBoxes($mysqli) {
	$box = 1;
	while($box) {
		// Get Random box.
		$sql = "SELECT `id`, latitude, longitude FROM `box` WHERE active IS NULL ORDER BY RAND() LIMIT 1";
		$query = mysqli_query($mysqli, $sql);
		$box = mysqli_fetch_assoc($query);
		//if no box, finish function
		if(!$box) {
			return 0;
		}
		
		// Assign box ID to a php var
		$bID = $box['id'];
		
		// Assign Variables
		$latVal = $box['latitude'];
		$longVal = $box['longitude'];
		$loc = ['lat' => $latVal, 'lng' => $longVal];
		
		// Lat Long search range
		$thresh = 10000; //EACH DIRECTION
		$latLow = computeOffset($loc, $thresh, 180)['lat']; //South
		$latHigh = computeOffset($loc, $thresh, 0)['lat']; //North
		$longLow = computeOffset($loc, $thresh, 270)['lng']; //West
		$longHigh = computeOffset($loc, $thresh, 90)['lng']; //East
		
		//is there a crime in the area?
		//this is the most inefficient search and destory method I can think of:
		//A long search, followed by a single destroy.
		$searchCrime = "SELECT COUNT(`id`), COUNT(Longitude), COUNT(Latitude), Falls_Within FROM data
		WHERE Longitude > $longLow
   	    	AND Longitude < $longHigh
   	    	AND Latitude > $latLow
   	    	AND Latitude < $latHigh
   	    GROUP BY Falls_Within
   	    ORDER BY COUNT(`id`) DESC
   	    LIMIT 1";
		$crimeResult = mysqli_query($mysqli, $searchCrime);
		
		// If Error.
		if (!$crimeResult) {
				die('<p class="SQLError">Could not run query: search for crimes<br>' . mysqli_error($mysqli) . '</p>');
				return 0;
		}
		
		$crimeRow = mysqli_fetch_assoc($crimeResult);
		
		
		$active = 1;
		$c = "NULL";
		//if empty, deactivate, reset counter
		if (!$crimeRow['COUNT(`id`)']) {
			$active = 0;
		} else {
			$c = "'".$crimeRow['Falls_Within']."'";
		}
		
		$sqlUpdate = "UPDATE `box` SET `active` = $active, `constabulary` = $c WHERE `id` = $bID";
		$updateResult = mysqli_query($mysqli, $sqlUpdate);
		// If Error.
		if (!$updateResult) {
				die('<p class="SQLError">Could not run update for box ' . $bID . ':<br>' . mysqli_error($mysqli) . '</p>');
				return 0;
		}
		
		
	}
	echo "break<br>";
}


// Header and Return
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>