<?php
//setting header to json
include '../config/config.php';

header('Content-Type: application/json');

//database
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'crimes');

//get connection
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if(!$mysqli){
	die("Connection failed: " . $mysqli->error);
}

// Longitude
if (!empty($_POST["long"])) {
    $longVal = trim((float)$_POST["long"]);
} else {
    $longVal = 0;
}

// Latitude
if (!empty($_POST["lat"])) {
    $latVal = trim((float)$_POST["lat"]);
} else {
    $latVal = 0;
}

// Radius 1
if (!empty($_POST["rad1"])) {
    $radVal1 = trim((float)$_POST["rad1"]);
} else {
    $radVal1 = 0;
}

// Radius 2
if (!empty($_POST["rad2"])) {
    $radVal2 = trim((float)$_POST["rad2"]);
} else {
    $radVal2 = 0;
}

// Immediate
$latLow1    = $latVal - $radVal1;
$latHigh1   = $latVal + $radVal1;
$longLow1   = $longVal - $radVal1;
$longHigh1  = $longVal + $radVal1;

//query to get data from the table
$query = sprintf("SELECT COUNT(id), Crime_Type FROM data
WHERE Longitude > $longLow1 AND Longitude < $longHigh1 AND Latitude > $latLow1 AND Latitude < $latHigh1 AND SQRT(POW(Latitude-'$latVal', 2)+POW(Longitude-'$longVal', 2))<'$radVal1'
GROUP BY Crime_Type
ORDER BY COUNT(id) DESC");

//execute query
$result = $mysqli->query($query);

//loop through the returned data
$myObj = array();
foreach ($result as $row) {
	$myObj[] = $row;
}

//free memory associated with result
$result->close();

//close connection
$mysqli->close();

//now print the data
$myJSON= json_encode($myObj);

// echo $myJSON;

var_dump(json_decode($myJSON));
?>
