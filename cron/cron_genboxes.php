<?php
// Add Database Connection
require_once '../config/config.php';
require_once '../lib/functions.php';


// Run Functions
genBoxes($mysqli, $boxHop);
activateBoxes($mysqli);
//prioritiseBoxes($mysqli);


//############## GENERATE BOXES ################################################
function genBoxes($mysqli, $boxHop)
{
	//############## INSERT BOXES ################################################
	function insertBoxes($mysqli, $ukLatMin, $ukLatMax, $ukLongMin, $ukLongMax, $boxHop) {
		$boxSize = 12000; //why isn't this getting called from config?; It doesn't work.
		$loc = ['lat' => $ukLatMin, 'lng' => $ukLongMin];
		while($loc['lat'] < $ukLatMax) {
			$loc['lng'] = $ukLongMin;
			while($loc['lng'] < $ukLongMax) {
				$a = $loc['lat'];
				$b = $loc['lng'];
	    		$lat_min = computeOffset($loc, $boxSize/2, 180)['lat'];
	    		$lat_max = computeOffset($loc, $boxSize/2, 0)['lat'];
	    		$long_min = computeOffset($loc, $boxSize/2, 270)['lng'];
	    		$long_max = computeOffset($loc, $boxSize/2, 90)['lng'];
				$sql = "INSERT INTO `box` (latitude, longitude, lat_min, lat_max, long_min, long_max) VALUES ($a, $b, $lat_min, $lat_max, $long_min, $long_max)";
				$result = mysqli_query($mysqli, $sql);
				
				// Error check
				if (!$result) {
					die('<p class="SQLError">Could not insert boxes: ' . mysqli_error($mysqli) . '</p>');
				}
				
			$loc = computeOffset($loc, $boxHop,  90);
			}
		$loc = computeOffset($loc, $boxHop,  0);
		//echo round($loc['lat'], 2) . " " . round($loc['lng'], 2) . "<br>";
		}
	}
	
	
	$sql = "TRUNCATE TABLE `box`";
	$result = mysqli_query($mysqli, $sql);

	// UK Dimensions - add to config file?
	$ukLongMin = -10.8544921875;
	$ukLongMax = 2.021484375;
	$ukLatMin = 49.82380908513249;
	$ukLatMax = 56; //55.478568831926395; //cuts off Scotland
	
	// Insert boxes into database.
	insertBoxes($mysqli, $ukLatMin, $ukLatMax, $ukLongMin, $ukLongMax, $boxHop);
}


//############## Activate BOXES #################################################
function activateBoxes($mysqli) {
	$box = 1;
	while($box) { // does this work?
		// Get Random box.
		$sql = "SELECT `id`, latitude, longitude FROM `box` WHERE active IS NULL ORDER BY RAND() LIMIT 1";
		$query = mysqli_query($mysqli, $sql);
		$box = mysqli_fetch_assoc($query);
		//if no box, finish function
		if(!$box) {
			return 0;
		}
		
		// Assign Variables
		$latVal = $box['latitude'];
		$longVal = $box['longitude'];
		$loc = ['lat' => $latVal, 'lng' => $longVal];
		
		// Lat Long search range
		$thresh = 10000; //EACH DIRECTION
		$latLow = computeOffset($loc, $thresh, 180)['lat'];
		$latHigh = computeOffset($loc, $thresh, 0)['lat'];
		$longLow = computeOffset($loc, $thresh, 270)['lng'];
		$longHigh = computeOffset($loc, $thresh, 90)['lng'];
		
		//is there a crime in the area?
		//this is the most inefficient search and destory method I can think of:
		//A long search, followed by a single destroy.
		$searchCrime = "SELECT COUNT(`id`), COUNT(Longitude), COUNT(Latitude) FROM data
		WHERE Longitude > $longLow
   	    	AND Longitude < $longHigh
   	    	AND Latitude > $latLow
   	    	AND Latitude < $latHigh";
		$crimeResult = mysqli_query($mysqli, $searchCrime);
		$crimeResult = mysqli_fetch_assoc($crimeResult);
		
		$active = 1;
		$n++; //interate counter
		//if empty, deactivate, reset counter
		if (!$crimeResult['COUNT(`id`)']) {
			$active = 0;
			$n = 0; //reset counter
		}
		
		$bID = $box['id'];
		$sqlUpdate = "UPDATE `box` SET active = $active WHERE `id` = $bID";
		$updateResult = mysqli_query($mysqli, $sqlUpdate);
		
		/*
		// If Error.
		if (!$crimeResult) {
				die('<p class="SQLError">Could not run query: ' . mysqli_error($mysqli) . '</p>');
		} */
	}
	echo "break<br>";
}


//############## PRIORITISE BOXES ##############################################
function prioritiseBoxes($mysqli) {
	$max = getHighestID($mysqli);

	for ($i=0; $i < $max; $i++) {
		calcPriority($mysqli, $i);
	}
}

//############## CALC PRIORITY #################################################
function calcPriority($mysqli, $id)
{
	//given a db and id, calculate a priority value
	$sql = "SELECT * from `box` WHERE `id` = $id";
	$result = mysqli_query($mysqli, $sql);
	
	// If Error
	if (!$result) {
			return FALSE;
	}
	
	$row = mysqli_fetch_row($result);
	
	$now = (int)strtotime(mysqli_fetch_row(mysqli_query($mysqli, "SELECT CURTIME()"))[0]);
	
	if(!is_null($row[4])) {
		$rowtime = (int)strtotime($row[4]);
		$p = ($now-$rowtime) * ($row[5]+1); //time difference * requests
	} else {
		$p = 999 + $row[5]; //set high priority if no lastupdate
	}
	
	$sql = "UPDATE `box` SET priority = $p WHERE id = $id";
	mysqli_query($mysqli, $sql);
}

// Header and Return
//header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
