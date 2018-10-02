<?php
// Add Database Connection
require_once '../config/config.php';
require_once '../lib/functions.php';

genBoxes($mysqli, $boxHop);
destroyBoxes($mysqli, $boxHop, $boxSize);
prioritiseBoxes($mysqli);
//calcPriority($mysqli, 1);

//############## GENERATE BOXES ################################################
function genBoxes($mysqli, $boxHop)
{
	// $sql = "INSERT INTO `box` (latitude, longitude) VALUES ($x, $y)";
	$sql = "TRUNCATE TABLE `box`";

	$result = mysqli_query($mysqli, $sql);
	/*
	** This function is intended to only ever be used once.
	** It will generate the centrepoints of boxes with a defined
	** spacing; and write these points to the db.
	** This spacing is designed to be a constant (along with
	** box size) over the lifetime of the product.
	** If these constants were to be changed, an entire recalculation
	** of boxes and the data they relate to must be performed.
	**
	** However, this list of boxes does not need to be static;
	** New boxes can be created or detoryed procedurally or manually.
	*/

	$ukLongMin = -10.8544921875; //truncate these numbers? just to beautify?
	$ukLongMax = 2.021484375;
	$ukLatMin = 49.82380908513249;
	$ukLatMax = 59.478568831926395;

	$x = $ukLatMin;
	while($x < $ukLatMax) {
		$y = $ukLongMin;
		while($y < $ukLongMax) {
			$sql = "INSERT INTO `box` (latitude, longitude) VALUES ($x, $y)";
			$result = mysqli_query($mysqli, $sql);

			$y += $boxHop;
		}
		$x += $boxHop;
	}
}

//############## DESTORY BOXES #################################################
function destroyBoxes($mysqli, $boxHop, $boxSize) {
	// Get Random Lat Long.
	$sql = "SELECT * FROM `box` ORDER BY RAND() LIMIT 1";
	$result = mysqli_query($mysqli, $sql);
	$row = mysqli_fetch_assoc($result);

	// Threshold
	$threshold = 0.1;

	// Assign Variables
	$longVal = $row['longitude'];
	$latVal = $row['latitude'];

	// Random Lat Long.
	echo $latVal . "  " . $longVal . "<br>";

	// Calculate Boundaries
	$longHigh = $longVal + $threshold;
	$longLow  = $longVal - $threshold;
	$latHigh = $latVal + $threshold;
	$latLow = $latVal - $threshold;

	$searchCrime = "SELECT id, Longitude, Latitude, SQRT(POW(Latitude-'$latVal', 2)+POW(Longitude-'$longVal', 2)) FROM data
	WHERE Latitude > $latLow AND Latitude < $latHigh AND Longitude > $longLow AND Longitude < $longHigh";

	$crimeResult = mysqli_query($mysqli, $searchCrime);

	// If Error.
	if (!$crimeResult) {
			die('<p class="SQLError">Could not run query: ' . mysqli_error($mysqli) . '</p>');
	}

	// Print all Lat Long.
	while ($crimes = mysqli_fetch_assoc($crimeResult)) {
		echo "Lat: " . $crimes["Latitude"] . " Long: " . $crimes["Longitude"] . "</br>";
	}
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
