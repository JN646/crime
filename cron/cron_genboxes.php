<?php
// Add Database Connection
require_once '../config/config.php';
require_once '../lib/functions.php';



// Run Functions
genBoxes($mysqli, $boxHop);
//destroyBoxes($mysqli, $boxHop, $boxSize);
//prioritiseBoxes($mysqli);


//############## GENERATE BOXES ################################################
function genBoxes($mysqli, $boxHop)
{
	//echo $boxHop . "<br>";
	//############## INSERT BOXES ################################################
	function insertBoxes($mysqli, $ukLatMin, $ukLatMax, $ukLongMin, $ukLongMax, $boxHop) {
		$loc = ['lat' => $ukLatMin, 'lng' => $ukLongMin];
		while($loc['lat'] < $ukLatMax) {
			echo round($loc['lat'], 2) . "<br>";
			$loc['lng'] = $ukLongMin;
			while($loc['lng'] < $ukLongMax) {
	    		echo "__" . round($loc['lng'], 2) . "<br>";
	    		$a = $loc['lat'];
	    		$b = $loc['lng'];
				$sql = "INSERT INTO `box` (latitude, longitude) VALUES ($a, $b)";
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
	$ukLongMin = number_format(-10.8544921875,6);
	$ukLongMax = number_format(2.021484375,6);
	$ukLatMin = number_format(49.82380908513249,6);
	$ukLatMax = number_format(59.478568831926395,6);
	
	// Insert boxes into database.
	insertBoxes($mysqli, $ukLatMin, $ukLatMax, $ukLongMin, $ukLongMax, $boxHop);
}

//############## DESTORY BOXES #################################################
/*
function destroyBoxes($mysqli, $boxHop, $boxSize) {
	// Get Random box.
	$sql = "SELECT * FROM `box` ORDER BY RAND() LIMIT 1";
	$result = mysqli_query($mysqli, $sql);
	$row = mysqli_fetch_assoc($result);
	
	// Threshold
	$thresh = 0.1;
	
	// Assign Variables
	$longVal = $row['longitude'];
	$latVal = $row['latitude'];
	
	// Lat Long of box.
	echo $latVal . "  " . $longVal . "<br>";
	
	$searchCrime = "SELECT COUNT(id)=0, Longitude, Latitude FROM data
	WHERE SQRT(POW(Latitude-'$latVal', 2)+POW(Longitude-'$longVal', 2)) < $thresh";
	
	$crimeResult = mysqli_query($mysqli, $searchCrime);
	
	// If Error.
	if (!$crimeResult) {
			die('<p class="SQLError">Could not run query: ' . mysqli_error($mysqli) . '</p>');
	}
}
*/
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
