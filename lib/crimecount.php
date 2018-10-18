<?php
// Initialise the session
session_start();

// Get Database Config
include_once '../config/config.php';
include_once 'functions.php';
include_once 'classes.php';


//############## CRIME COUNTER #################################################
function crimeCounter($latVal, $longVal)
{
	global $mysqli;
    if ($TimeSeries_ExecTimer == TRUE) {
      if ($CrimeCounter_ExecTimer) {
        $time_start = microtime(true); // Start Timer
      }
	
    }

    function writeLog($mysqli, $latVal, $longVal, $radVal1, $radVal2) {
      // Set Session ID to variable.
      if (isset($_SESSION["id"])) {
        // If there is a session ID.
        $userid = $_SESSION["id"];
      } else {
        // If there is no session ID.
        $userid = 0;
      }

      // Insert SQL
      $report_logSQL = "INSERT INTO report_log (report_lat, report_long, report_immediate, report_local, report_user)
      VALUES ($latVal, $longVal, $radVal1, $radVal2, $userid)";

      // Run Query
      $report_logSQLQ = mysqli_query($mysqli, $report_logSQL);

      // If Error
      if (!$report_logSQLQ) {
          die('<p class="SQLError">Could not run query: ' . mysqli_error($mysqli) . '</p>');
      }
    }

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

    //############## PRE CALC TABLE ############################################
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

    //############## CALC RISK #################################################
    function calcRisk($iCount, $lCount, $iRadius, $lRadius)
    {
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
    }
	
	
	
	
	
	// ########### MAIN ################################################
	
	global $IMMEDIATE_RAD;
	global $LOCAL_RAD;
	$loc = ['lat'=>$latVal, 'lng'=>$longVal];
	$latLow1	= computeOffset($loc, $IMMEDIATE_RAD, 180)['lat'];
    $latHigh1   = computeOffset($loc, $IMMEDIATE_RAD, 0)['lat'];
    $longLow1   = computeOffset($loc, $IMMEDIATE_RAD, 270)['lng'];
    $longHigh1  = computeOffset($loc, $IMMEDIATE_RAD, 90)['lng'];
    
	$latLow2	= computeOffset($loc, $LOCAL_RAD, 180)['lat'];
    $latHigh2   = computeOffset($loc, $LOCAL_RAD, 0)['lat'];
    $longLow2   = computeOffset($loc, $LOCAL_RAD, 270)['lng'];
    $longHigh2  = computeOffset($loc, $LOCAL_RAD, 90)['lng'];
	
    // Run Queries
    $resultCount_Immediate  = sqlCrimeArea($mysqli, $latVal, $longVal, $IMMEDIATE_RAD, $latLow1, $latHigh1, $longLow1, $longHigh1);
    $resultCount_Local      = sqlCrimeArea($mysqli, $latVal, $longVal, $LOCAL_RAD, $latLow2, $latHigh2, $longLow2, $longHigh2);

    // Write to Log only if user is logged in.
    if ($require_logon_to_search == TRUE) {
      if(isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == true){
        writeLog($mysqli, $latVal, $longVal, $radVal1, $radVal2);
      }
    }
    
    
	
    // Generate Table of Data
    $table = preCalcTable($resultCount_Immediate, $resultCount_Local, $IMMEDIATE_RAD, $LOCAL_RAD);
	
	// Generate Ordered Colour Array
	$colours = getChartColours($table['Crime Type']);
	
	$d = new ChartData();
	$d->type = 'bar';
	$d->labels = $table['Crime Type'];
	$d->addDataset($table['Risk'], 'Risk', $colours);
	$d->legend = false;
	$d->toolTips = false;
	
    // Display Script End time
    if ($CrimeCounter_ExecTimer) {
      $time_end = microtime(true);

      //dividing with 60 will give the execution time in minutes other wise seconds
      $execution_time = ($time_end - $time_start);

      echo '<b>Total Execution Time:</b> ' . number_format($execution_time, 4) . ' Seconds';
    }
    
    return $d->getData();
}
 ?>
