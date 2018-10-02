<?php
// Add Database Connection
require_once '../config/config.php';
require_once '../lib/functions.php';

genBoxes($mysqli);
prioritiseBoxes($mysqli);
//calcPriority($mysqli, 1);

function genBoxes($mysqli)
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

	$ukLatMin = -10.8544921875; //truncate these numbers? just to beautify?
	$ukLatMax = 2.021484375;
	$ukLongMin = 49.82380908513249;
	$ukLongMax = 59.478568831926395;

	$hop = 0.5; //in radians - size to be confirmed

	$x = $ukLatMin;
	while($x < $ukLatMax) {
		$y = $ukLongMin;
		while($y < $ukLongMax) {
			$sql = "INSERT INTO box (latitude, longitude) VALUES ($x, $y)";
			$result = mysqli_query($mysqli, $sql);

			$y += $hop;
		}
		$x += $hop;
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
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
