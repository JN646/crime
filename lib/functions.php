<?php
//############## FUNCTION FILE #################################################
//############## Version Number ################################################
class ApplicationVersion
{
    // Define version numbering
    const MAJOR = 0;
    const MINOR = 0;
    const PATCH = 0;

    public static function get()
    {
        // Prepare git information to form version number.
        $commitHash = trim(exec('git log --pretty="%h" -n1 HEAD'));

        // Get date and time information.
        $commitDate = new \DateTime(trim(exec('git log -n1 --pretty=%ci HEAD')));
        $commitDate->setTimezone(new \DateTimeZone('UTC'));

        // Format all information into a version identifier.
        return sprintf('v%s.%s.%s-dev.%s (%s)', self::MAJOR, self::MINOR, self::PATCH, $commitHash, $commitDate->format('Y-m-d H:m:s'));
    }

    // Usage: echo 'MyApplication ' . ApplicationVersion::get();
}

//############## INIT VALUE ####################################################
// Debug
$radVal1 = $radVal2 = $n = $mode = 0;
$JSONEnable = "TRUE";

//############## GET VALUES ####################################################
//############## Get Months ####################################################
function getMonths($mysqli)
{
    // SELECT All
    $query = "SELECT DISTINCT Month FROM data WHERE Month <> 0";
    $result = mysqli_query($mysqli, $query);

    // If Error
    if (!$result) {
        die('<p class="SQLError">Could not get month list: ' . mysqli_error($mysqli) . '</p>');
    }

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option>" . $row['Month'] . "</option>";
        }
    } else {
        echo "<option disabled>No Data</option>";
    }
}

//############## COUNT THINGS ##################################################
//############## Count All Crimes ##############################################
function countAllCrimes($mysqli)
{
    // SELECT All
    $query = "SELECT count FROM stats WHERE stat = 'Crime Count'";
    $result = mysqli_query($mysqli, $query);
    $rows = mysqli_fetch_row($result);

    // If Error
    if (!$result) {
        die('<p class="SQLError">Could not run query: ' . mysqli_error($mysqli) . '</p>');
    }

    // Free Query
    mysqli_free_result($result);

    // Return Value.
    return number_format($rows[0]);
}

//############## Count All Crime Types #########################################
function countAllCrimeTypes($mysqli)
{
    // SELECT All
    $query = "SELECT count FROM stats WHERE stat = 'All Crime Types'";
    $result = mysqli_query($mysqli, $query);
    $rows = mysqli_fetch_row($result);

    // If Error
    if (!$result) {
        die('<p class="SQLError">Could not run query: ' . mysqli_error($mysqli) . '</p>');
    }

    // Free Query
    mysqli_free_result($result);

    // Return Value.
    return $rows[0];
}

//############## Count All Months ##############################################
function countAllMonth($mysqli)
{
    // SELECT All
    $query = "SELECT count FROM stats WHERE stat = 'Months worth of data'";
    $result = mysqli_query($mysqli, $query);
    $rows = mysqli_fetch_row($result);

    // If Error
    if (!$result) {
        die('<p class="SQLError">Could not run query: ' . mysqli_error($mysqli) . '</p>');
    }

    // Free Query
    mysqli_free_result($result);

    // Return Value.
    return $rows[0];
}

//############## Count All Crimes By Year ######################################
function countAllYears($mysqli)
{
    // SELECT All
    $years = array("2015","2016","2017","2018");
    for ($i=0; $i < count($years); $i++) {
      $query = "SELECT COUNT(id) FROM data WHERE month LIKE '$years[$i]%'";
      $result = mysqli_query($mysqli, $query);
      $rows[$years[$i]][] = mysqli_fetch_row($result);
    }

    // If Error
    if (!$result) {
        die('<p class="SQLError">Could not run query: ' . mysqli_error($mysqli) . '</p>');
    }

    // Free Query
    mysqli_free_result($result);

    // Return Value.
    return $rows;
}

//############## Count No Locations ############################################
function countAllNoLocation($mysqli)
{
    // SELECT All
    $query = "SELECT count FROM stats WHERE stat = 'Crimes with no location'";
    $result = mysqli_query($mysqli, $query);
    $rows = mysqli_fetch_row($result);

    // If Error
    if (!$result) {
        die('<p class="SQLError">Could not run query: ' . mysqli_error($mysqli) . '</p>');
    }

    // Free Query
    mysqli_free_result($result);

    // Return Value.
    return number_format($rows[0]);
}

//############## Fall Within ###################################################
function countFallsWithin($mysqli)
{
    // SELECT All
    $query = "SELECT count FROM stats WHERE stat = 'Falls Within'";
    $result = mysqli_query($mysqli, $query);
    $rows = mysqli_fetch_row($result);

    // If Error
    if (!$result) {
        die('<p class="SQLError">Could not run query: ' . mysqli_error($mysqli) . '</p>');
    }

    // Free Query
    mysqli_free_result($result);

    // Return Value.
    return $rows[0];
}

//############## Fall Within ###################################################
function countReportedBy($mysqli)
{
    // SELECT All
    $query = "SELECT count FROM stats WHERE stat = 'Reported By'";
    $result = mysqli_query($mysqli, $query);
    $rows = mysqli_fetch_row($result);

    // If Error
    if (!$result) {
        die('<p class="SQLError">Could not run query: ' . mysqli_error($mysqli) . '</p>');
    }

    // Free Query
    mysqli_free_result($result);

    // Return Value.
    return $rows[0];
}

//############## BOXES #########################################################
//############## Count Boxes ###################################################

function countBoxes($mysqli, $stat)
{
    // SELECT All
    $query = "SELECT count FROM stats WHERE stat = $stat";
    $result = mysqli_query($mysqli, $query);
    $rows = mysqli_fetch_row($result);

    // If Error
    if (!$result) {
    	//no stat - need to make one?
        die('<p class="SQLError">Could not run query: ' . mysqli_error($mysqli) . '</p>');
    }

    // Free Query
    mysqli_free_result($result);

    // Return Value.
    return number_format($rows[0]);
}


function callStat($mysqli, $stat) {
	// SELECT All
	$query = "SELECT count FROM stats WHERE stat = $stat";
	$result = mysqli_query($mysqli, $query);
	$rows = mysqli_fetch_row($result);
	
	// If Error
	if (!$result) {
		//no stat? - run the cron job?
		die('<p class="SQLError">Could not run query: ' . mysqli_error($mysqli) . '</p>');
	}
	
	// Free Query
	mysqli_free_result($result);
	
	// Return Value.
	return number_format($rows[0]);
}




//############## SPHERICAL GEOMETRY #############################################

function computeOffset($from, $distance, $heading) {
	$distance /= 6371000; //MathUtil::EARTH_RADIUS; //calculates fraction of unit circle. Can we call this constant from somewhere?
	$heading = deg2rad($heading);
	// http://williams.best.vwh.net/avform.htm#LL
	$fromLat = deg2rad($from['lat']);
	$fromLng = deg2rad($from['lng']);
	$cosDistance = cos($distance);
	$sinDistance = sin($distance);
	$sinFromLat = sin($fromLat);
	$cosFromLat = cos($fromLat);
	$sinLat = $cosDistance * $sinFromLat + $sinDistance * $cosFromLat * cos($heading);
	$dLng = atan2($sinDistance * $cosFromLat * sin($heading),
		$cosDistance - $sinFromLat * $sinLat);
	return ['lat' => rad2deg(asin($sinLat)), 'lng' =>rad2deg($fromLng + $dLng)];
}

function computeArcDistance($latitude1, $longitude1, $latitude2, $longitude2) {
	$earth_radius = 6371000;
	
	$dLat = deg2rad($latitude2 - $latitude1);
	$dLon = deg2rad($longitude2 - $longitude1);
	
	$a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);
	$c = 2 * asin(sqrt($a));
	$d = $earth_radius * $c;
	
	return $d;    
}


//############## CONVERT MONTHS #############################################

function dateAsInt($date) {
	$ym = explode("-", $date); //year|month array
	$epoch = 2015; //year 0
	return (($ym[0]-$epoch)*12) + $ym[1];
}

function intAsDate($int) {
	$epoch = 2015; //year 0
	$month = ($int % 12) + 1;
	if($month<=9) {
		$month = "0".$month;
	}
	$year = floor($int/12)+$epoch;
	return $year."-".$month;
}







