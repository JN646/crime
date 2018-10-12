<?php
// Add Database Connection
require_once '../config/config.php';

//############## MAIN ##########################################################

// New Function: use ($mysqli, [stat-name], [query])

//Crimes
runQuery($mysqli, "'nCrimes'", "SELECT COUNT(*) FROM data");
runQuery($mysqli, "'nCrimesNoLoc'", "SELECT COUNT(DISTINCT(ID)) FROM data WHERE Longitude IS NULL AND Latitude IS NULL");
runQuery($mysqli, "'nCrimeTypes'", "SELECT COUNT(DISTINCT(CRIME_Type)) FROM data");
runQuery($mysqli, "'FallsWithin'", "SELECT COUNT(DISTINCT(Falls_Within)) FROM data");
runQuery($mysqli, "'ReportedBy'", "SELECT COUNT(DISTINCT(Reported_By)) FROM data");
runQuery($mysqli, "'nMonths'", "SELECT COUNT(DISTINCT(Month)) FROM data");

//Boxes
runQuery($mysqli, "'nBoxes'", "SELECT COUNT(*) FROM box");
runQuery($mysqli, "'nBoxesActive'", "SELECT CONCAT(ROUND(CAST((SELECT COUNT(*) FROM box WHERE active=1) AS DECIMAL)/CAST(COUNT(*) AS DECIMAL)*100, 2), '%') FROM box");
runQuery($mysqli, "'nBoxesNull'", "SELECT CONCAT(ROUND(CAST((SELECT COUNT(*) FROM box WHERE active IS NULL) AS DECIMAL)/CAST(COUNT(*) AS DECIMAL)*100, 2), '%') FROM box");
runQuery($mysqli, "'nBoxmonths'", "SELECT COUNT(*) FROM box_month");

//Other
runQuery($mysqli, "'nUsers'", "SELECT COUNT(*) FROM users");
runQuery($mysqli, "'nStats'", "SELECT COUNT(*) FROM stats");

 // Always Last
runQuery($mysqli, "'statsLastUpdate'", "SELECT NOW()");

function runQuery($mysqli, $name, $query) //for generic queries returning one value (like COUNT(), MIN(), MAX(), etc)
{
    $result = mysqli_query($mysqli, $query);
    $rows = mysqli_fetch_row($result);
    mysqli_free_result($result); // Free Query
	
    // Return Value, format for SQL string
    $output = '"'.$rows[0].'"';
    $sqlStatExists = mysqli_query($mysqli, "SELECT COUNT(*) FROM stats WHERE stat = $name");
    $exists = mysqli_fetch_row($sqlStatExists)[0];
    $writeCrimeCount; //initialise variable
    if($exists) { // Update
    	$sqlCrimeCount = "UPDATE stats SET count=$output, last_run=NOW() WHERE stat = $name";
    } else { // Insert
		$sqlCrimeCount = "INSERT INTO stats (stat, count) VALUES ($name, $output)";
    }
    
    $writeCrimeCount = mysqli_query($mysqli, $sqlCrimeCount);
    if (!$writeCrimeCount) {
		die('<p class="SQLError">Could not run query '.($exists?"UPDATE ":"INSERT ").$name.': ' . mysqli_error($mysqli) . '</p>');
	}
    
    mysqli_free_result($writeCrimeCount); // Free Query
}



// Header and Return
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>