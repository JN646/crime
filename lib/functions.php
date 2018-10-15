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

//############## CALL STATS #########################################################

function callStat($mysqli, $stat) {
	// SELECT All
	$query = "SELECT count FROM stats WHERE stat = $stat";
	$result = mysqli_query($mysqli, $query);
	$rows = mysqli_fetch_row($result);
	
	// If Error
	if (!$rows) {
		//no stat?
		// it could be that the stat hasn't been defined, or the name is wrong, or the cron job hasn't been run yet
		//die('<p class="SQLError">Could not run query: ' . mysqli_error($mysqli) . '</p>');
		return "Stat does not exist:<br>Contact your system administrator";
	}
	
	// Free Query
	mysqli_free_result($result);
	
	// Return Value.
	return $rows[0];
}




//############## GET TIME SERIES #############################################

function getTimeSeries($mysqli, $bID, $mStart = NULL, $mEnd = NULL)
{
	// Error Check Start and End
	if(!is_null($mStart) && !is_null($mEnd) && $mStart>=$mEnd) {
		//could just swap them around if not equal?
		echo "Start date cannot be after or the same as end date<br>";
		return 0;
	}
	
	// Returns the boxmonths for a given box ID, and +1 to requests
	$out = [ 'labels'=>[], 'datasets'=>[
			'label'=>[
				//this array can be passed to the function as a variable to select what is returned
				"Anti-social behaviour",
				"Burglary",
				"Other theft",
				"Public order",
				"Violence and sexual offences",
				"Vehicle crime",
				"Criminal damage and arson",
				"Other crime",
				"Robbery",
				"Bicycle theft",
				"Drugs",
				"Shoplifting",
				"Theft from the person"
			], 'data'=>[]
		]
	];

	// Add 1 to Requests
	$addQ = "UPDATE `box` SET `requests` = `requests` + 1 WHERE `id` = $bID";
	$addR = mysqli_query($mysqli, $addQ);

	// Build a Smart Query
	$TSQ = "SELECT * FROM `box_month` WHERE `bm_boxid` = $bID";
	if(!is_null($mStart)) {
		$TSQ = $TSQ." AND `bm_month` > $mStart";
	}
	if(!is_null($mEnd)) {
		$TSQ = $TSQ." AND `bm_month` <= $mEnd";
	}
	
	// Return Time Series
	$TSR = mysqli_query($mysqli, $TSQ);
	
	while($row = mysqli_fetch_assoc($TSR)) {
		$out['labels'][] = $row['bm_month'];
		//echo $row['bm_month']."<br>";
		foreach(array_keys($row) as $name) {
			$out['datasets']['data'][$name][] = $row[$name];
		}
	}
	
	return $out;
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




