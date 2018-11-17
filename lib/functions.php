<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/crime/lib/classes.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/crime/config/config.php");

//############## FUNCTION FILE #################################################
//############## Version Number ################################################
class ApplicationVersion
{
	// Define version numbering
	const MAJOR = 0;
	const MINOR = 0;
	const PATCH = 1;

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

//############## CRIME COUNT ###################################################
function sqlCrimeArea($mysqli, $latVal, $longVal, $radius, $latLow, $latHigh, $longLow, $longHigh)
{
	// Use a rounded shape? Otherwise, it's square.
	$useEllipse = true;

	$sql = "SELECT COUNT(*) Count, `Crime_Type`
		FROM `data`
		WHERE `Latitude` > $latLow
			AND `Latitude` < $latHigh
			AND `Longitude` > $longLow
			AND `Longitude` < $longHigh";

		if($useEllipse) {
			// Calc Average lat/long Radius
			$rLat = (abs($latVal-$latLow)+abs($latVal-$latHigh))/2;
			$rLong = (abs($longVal-$longLow)+abs($longVal-$longHigh))/2;
			$sql = $sql." AND (POW(`Latitude`-'$latVal', 2)*($rLong*$rLong)) + (POW(`Longitude`-'$longVal',2)*($rLat*$rLat)) < ($rLat*$rLat)*($rLong*$rLong)";
		}

	// Append grouping and ordering
	$sql = $sql." GROUP BY `Crime_Type` ORDER BY `Count` DESC";

	// Run Query
	$resultCount = mysqli_query($mysqli, $sql);

	// If Error
	if (!$resultCount) {
		die('<p class="SQLError">Could not run query: ' . mysqli_error($mysqli) . '</p>');
	}

	// It may be possible here to infer whether no returns means 0 or NULL.
	// Perhaps by using st-dev and seeing if it can reliably tell us if 0 falls within a range.

	return $resultCount;
}

//############## PRE CALC TABLE ################################################
function preCalcTable($resultCount_Immediate, $resultCount_Local, $radVal_Immediate, $radVal_Local)
{
	$nRows = mysqli_num_rows($resultCount_Local);
	$table = array('Crime Type'=>array(),'Immediate Area'=>array(),'Local Area'=>array(),'Risk'=>array());
	// Fetch Results
	if($nRows) {
		while($localRow = mysqli_fetch_assoc($resultCount_Local)) {
			// Set Variables
			$table['Crime Type'][] = $localRow["Crime_Type"]; //crime type
			$crimeIndex = array_search($localRow['Crime_Type'], $table['Crime Type']);
			$table['Local Area'][$crimeIndex] = $localRow["Count"]; //local count
		}

		// Match immediate counts to corresponding indecies
		while($immediateRow = mysqli_fetch_assoc($resultCount_Immediate)) {
			$table['Immediate Area'][array_search($immediateRow['Crime_Type'], $table['Crime Type'])] = $immediateRow['Count'];
		}

		foreach($table['Crime Type'] as $index => $crime) {
			$table['Risk'][$index] = calcRisk($table['Immediate Area'][$index], $table['Local Area'][$index], $radVal_Immediate, $radVal_Local);
		}
	}
	return $table; // Return the table.
}

//############## CALC RISK #####################################################
function calcRisk($iCount, $lCount, $iRadius, $lRadius)
{
	if ($iRadius > 0.0 && $lRadius > 0.0) {
		// Get Area
		$iArea = M_PI*$iRadius*$iRadius;
		$lArea = M_PI*$lRadius*$lRadius;

		// Get Radius
		$iCrimeP = $iCount/$iArea; //p (rho) is used to notate density in physics; crimeP means crime density.
		$lCrimeP = $lCount/$lArea;

		// If no data.
		if(is_null($iCount) or is_null($lCount)) {
			// N/A
			$risk = NULL;
		} else {
			// Get Risk
			$risk = log($iCrimeP/$lCrimeP, 2);
		}
		//echo $iCount." ".$lCount.": ".$risk."<br>";
		return $risk; // Return Calculation
	} else {
		// Return error on failure.
		return FALSE;
	}
}

//############## CALL STATS ####################################################
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

//############## Get Colours for Charts ########################################
function getChartColours($crimes) {
		// Fetch Global Array
		global $CRIME_COLOURS;

		// If not array, make it so
		if(!is_array($crimes)) {
			$crimes = [$crimes];
		}

		$orderedColours = array();
		foreach($crimes as $key => $crime) {
			// Should search to see if key exists first?
			$orderedColours[] = $CRIME_COLOURS[$crime];
		}

		return $orderedColours;
}

//############## GET NEAREST BOX ###############################################
function getBoxByLoc($lat, $long) {
	global $mysqli;
	// Find Some Nearby Boxes
	$t = 0.2; //threshold in radians
	$boxesQ = "SELECT * FROM `box`
		WHERE `longitude` > ($long-$t)
			AND `longitude` < ($long+$t)
			AND `latitude` > ($lat-$t)
			AND `latitude` < ($lat+$t)";
	$boxesR = mysqli_query($mysqli, $boxesQ);

	if(!mysqli_fetch_assoc($boxesR)) {
		echo "Error: No nearby regions (boxes) found. Please make your way towards the UK (barr Soctland).<br>";
		return NULL;
	}

	// Calculate Nearest From Nearby Boxes
	$distance = [];
	while($row = mysqli_fetch_assoc($boxesR)) {
		$distance[$row['id']] = computeArcDistance($lat, $long, $row['latitude'], $row['longitude']);
	}
	$nearestBox = array_keys($distance, min($distance))[0];
	return $nearestBox;
}

//############## SPHERICAL GEOMETRY ############################################
function computeOffset($from, $distance, $heading) {

	global $EARTH_RADIUS;
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
	global $EARTH_RADIUS;
	$earth_radius = 6371000;

	$dLat = deg2rad($latitude2 - $latitude1);
	$dLon = deg2rad($longitude2 - $longitude1);

	$a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);
	$c = 2 * asin(sqrt($a));
	$d = $earth_radius * $c;

	return $d;
}

//############## CONVERT MONTHS ################################################
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

//############## REPORT HEADER #################################################
function reportHeader($latVal, $longVal) {
	$link = "https://www.google.com/maps/@".$latVal.",".$longVal.",15z";
	?>
	<!-- Table -->
	<table class='table col-md-6'>
		<tbody>
			<tr>
				<td><b>Location:</b></td>
				<td><a href="<?php echo $link ?>" target="_blank" title="Box #: <?php echo getBoxByLoc($latVal, $longVal); ?>"><?php echo round($latVal, 4) ?>, <?php echo round($longVal, 4); ?></a></td>
			</tr>
			<tr>
				<td><b>Generated:</b></td>
				<td><?php echo date("Y-m-d H:i:s"); ?></td>
			</tr>
		</tbody>
	</table>
	<?php
}
