<?php
// Add Database Connection
require_once '../config/config.php';
require_once '../lib/functions.php';


// Run Function
genBoxes($mysqli, $boxHop);


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


// Header and Return
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
