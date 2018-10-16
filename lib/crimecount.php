<?php
// Initialise the session
session_start();

// Get Database Config
include_once '../config/config.php';
include_once 'functions.php';
include_once 'classes.php';


//############## CRIME COUNTER #################################################
function crimeCounter($mysqli, $latVal, $longVal, $radVal1, $radVal2)
{
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
		// Pythag can be re-implemented more accurately (although still not mathematically correct) using ellipse version:
		// https://math.stackexchange.com/questions/76457/check-if-a-point-is-within-an-ellipse
        $sql = "SELECT COUNT(*) Count, `Crime_Type`
        FROM `data`
        WHERE `Latitude` > $latLow
        	AND `Latitude` < $latHigh
        	AND `Longitude` > $longLow
        	AND `Longitude` < $longHigh
        	/* !!!  AND SQRT(POW(`Latitude`-'$latVal', 2)+POW(`Longitude`-'$longVal', 2))<'$radius'  !!! */
        GROUP BY `Crime_Type`
        ORDER BY `Count` DESC";
		
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
    function preCalcTable($resultCount_Immediate, $resultCount_Local, $radVal1, $radVal2)
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
				$table['Risk'][$index] = calcRisk($table['Immediate Area'][$index], $table['Local Area'][$index], $radVal1, $radVal2);
			}
			
        } else {
            // No Results
            echo "<p id='noResults'>No Results. function preCalcTable()</p>";
        }
        return $table; // Return the table.
    }

    //############## CALC RISK #################################################
    function calcRisk($iCount, $lCount, $iRadius, $lRadius2)
    {
    	// Soft limit between -1 & 1 (also controls scaling)
    	$limit = False;
    	// Scale coefficient (before limiting)
    	$Scale = 0.2;
    	// Number of decimal points (0 for no round)
    	$round = 2;
		
        // Get Area
        $iArea = M_PI*$iRadius*$iRadius;
        $lArea = M_PI*$lRadius2*$lRadius2;
		
        // Get Radius
        $iCrimeP = $iCount/$iArea; //p (rho) is used to notate density in physics; crimeP means crime density.
        $lCrimeP = $lCount/$lArea;
		
        // If no data.
        if (!$iCount) {
            // N/A
            $result = "<span class='naSign'> NULL </span>";
        } else {
            // Get Risk
            $result = log($iCrimeP/$lCrimeP, 2);
            if($limit) {
            	$result = tanh($result * $scale);
            }
            if($round != 0) {
            	$result = round($result, $round);
            }
        }
		
        return $result; // Return Calculation
    }

    //############## RENDER TABLE ##############################################
    function renderTable($table) {

        // Init Running Total Values
        $runningCountL = $runningCountI = 0; ?>
      <table id="myTable2" class='table table-bordered'>
        <thead>
          <tr>
            <th id="headerCrime" class='text-center text-bold crimeCol' onclick="sortTable(0)">Crime</th>
            <th id="headerImmediate" class='text-center text-bold immediateCol' onclick="sortTable(1)">Immediate</th>
            <th id="headerLocal" class='text-center text-bold localCol' onclick="sortTable(2)">Local</th>
            <th id="headerRisk" class='text-center text-bold riskCol' onclick="sortTable(3)">Risk</th>
            <th id="headerRiskGraphic" class='text-center text-bold riskGraphicCol' onclick="sortTable(4)">Risk Graphic</th>
          </tr>
        </thead>
        <tbody>
      <?php for ($i=0; $i < count($table); $i++) { ?>
        <tr>
          <td class='crimeCol'><?php echo $table[$i][0] ?></td>
          <td class='text-center immediateCol'>
            <?php
            // IMMEDIATE
            // Check to see if zero.
            if ($table[$i][1] == 0) {
                echo "-"; // Add a Dash
            } else {
                // Set number format.
                echo number_format($table[$i][1]);

                // Contribute to running count.
                $runningCountI = $runningCountI + $table[$i][1];
            } ?>
         </td>
          <td class='text-center localCol'><?php echo number_format($table[$i][2]) ?></td>
          <td class='text-center riskCol <?php echo colourRisk($table[$i][3]) ?>'><?php echo $table[$i][3] ?></td>
          <td class='text-center riskGraphicCol'><div id='riskslider'><input class="form-control-range" type="range" min="-4" max="4" step="0.01" disabled value="<?php echo $table[$i][3] ?>" class="slider" id="myRange"></div></td>
        </tr>
        <?php
        // Contribute to running count.
        $runningCountL = $runningCountL + $table[$i][2];
        } ?>
        </tbody>
      </table>
      <table class='table'>
        <thead>
          <tr>
            <th class='outputText text-center text-bold'></th>
            <th class='outputText text-center text-bold'>Immediate</th>
            <th class='outputText text-center text-bold'>Local</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class='outputText text-bold'>Total Reported Crimes</td>
            <td class='outputText text-center text-bold'><?php echo number_format($runningCountI) ?></td>
            <td class='outputText text-center text-bold'><?php echo number_format($runningCountL) ?></td>
          </tr>
        </tbody>
      </table>
      <?php
    }

    //############## COLOUR RISK ###############################################
    function colourRisk($risk) {
        // Threshold Value
        $thresh = 1.0;
        $colour = "";

        // Red
        if ($risk > $thresh) {
            $colour = "alert-danger"; // Red
        }

        // Green
        if ($risk < $thresh) {
            $colour = "alert-success"; // Green
        }

        // Grey
        if ($risk == 0) {
            $colour = "alert-active"; // Grey
        }

        return $colour;
    }
	
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

    // Generate Visual Table
    //renderTable($table); //shouldn't this render be in output.php? doesn't work any more anyway
	
	$d = new ChartData();
	$d->setType('bar');
	$d->setLabels($table['Crime Type']);
	$d->addDataset($table['Risk'], 'Risk');
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
