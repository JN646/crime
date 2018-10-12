<?php
// Add Database Connection
require_once '../config/config.php';

//############## MAIN ##########################################################

// New Function: use ($mysqli, [statName], [query])
runQuery($mysqli, "'nBoxes'", "SELECT COUNT(*) FROM box");
runQuery($mysqli, "'nBoxesActive'", "SELECT COUNT(*) FROM box WHERE active = 1");
runQuery($mysqli, "'nBoxesNull'", "SELECT COUNT(*) FROM box WHERE active IS NULL");
runQuery($mysqli, "'FallsWithin'", "SELECT COUNT(DISTINCT(Falls_Within)) FROM data");
runQuery($mysqli, "'ReportedBy'", "SELECT COUNT(DISTINCT(Reported_By)) FROM data");
runQuery($mysqli, "'nCrimesNoLoc'", "SELECT COUNT(DISTINCT(ID)) FROM data WHERE Longitude IS NULL AND Latitude IS NULL");
runQuery($mysqli, "'nMonths'", "SELECT COUNT(DISTINCT(Month)) FROM data");
runQuery($mysqli, "'nCrimes'", "SELECT COUNT(*) FROM data");
runQuery($mysqli, "'nCrimeTypes'", "SELECT COUNT(DISTINCT(CRIME_Type)) FROM data");

function runQuery($mysqli, $name, $query) //for generic queries returning one value (like COUNT(), MIN(), MAX, etc)
{
    $result = mysqli_query($mysqli, $query);
    $rows = mysqli_fetch_row($result);
    mysqli_free_result($result); // Free Query
	
    // Return Value.
    $output = $rows[0];
    
    $sqlStatExists = mysqli_query($mysqli, "SELECT COUNT(*) FROM stats WHERE stat = $name");
    $exists = mysqli_fetch_row($sqlStatExists)[0];
    $writeCrimeCount; //init var
    if($exists) { // Update
    	$sqlCrimeCount = "UPDATE stats SET count = $output WHERE stat = $name";
    	$writeCrimeCount = mysqli_query($mysqli, $sqlCrimeCount);
    } else { // Insert
		$sqlCrimeCount = "INSERT INTO stats (stat, count) VALUES ($name, $output)";
    	$writeCrimeCount = mysqli_query($mysqli, $sqlCrimeCount);
    }
    
    if (!$writeCrimeCount) {
		die('<p class="SQLError">Could not run query: ' . mysqli_error($mysqli) . '</p>');
	}
    
    //$sqlCrimeCountOutput = mysqli_fetch_row($writeCrimeCount); //is this needed?
    mysqli_free_result($writeCrimeCount); // Free Query
}



// Header and Return
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>