<?php
// Get Database Config
include_once 'functions.php';

// Crime Counter
function crimeCounter($mysqli, $latVal, $longVal, $radVal1, $radVal2)
{
    $time_start = microtime(true); // Start Timer
    function sqlCrimeArea($mysqli, $longLow, $longHigh, $latLow, $latHigh, $latVal, $longVal, $radVal)
    {
        //immediate area
        $sql_immediate = "SELECT COUNT(id), Longitude, Latitude, Crime_Type, Month
        FROM data
        WHERE Longitude > $longLow AND Longitude < $longHigh AND Latitude > $latLow AND Latitude < $latHigh AND SQRT(POW(Latitude-'$latVal', 2)+POW(Longitude-'$longVal', 2))<'$radVal'
        GROUP BY Crime_Type
        ORDER BY COUNT(id) DESC";

        // Run Query
        $resultCount_Immediate = mysqli_query($mysqli, $sql_immediate);

        // If Error
        if (!$resultCount_Immediate) {
            die('<p class="SQLError">Could not run query: ' . mysqli_error($mysqli) . '</p>');
        }

        return $resultCount_Immediate;
    }

    function preCalcTable($resultCount_Immediate, $resultCount_Local, $radVal1, $radVal2)
    {
        $nRows = mysqli_num_rows($resultCount_Local);
        $table = array(array(),array(),array(),array());
        // Fetch Results
        if ($nRows) {
            $j = 0; //table index
            while ($row = mysqli_fetch_assoc($resultCount_Local)) {
                // Set Variables to Rows.
                $crimeID = $row["COUNT(id)"];
                $crimeType = $row["Crime_Type"];
                $crimeDate = $row["Month"];

                // Set Variables
              $table[$j][0] = $crimeType;   //crime type
              $table[$j][1] = 0;            //immediate count
              $table[$j][2] = $crimeID;     //local count
              $table[$j][3] = "N/A";        //risk

              // Get Immediate Count
                $row1 = mysqli_fetch_assoc($resultCount_Immediate);
                for ($i=0; $i < count($resultCount_Immediate); $i++) {
                    if ($row1["Crime_Type"] == $table[$j][0]) {
                        $table[$j][1] = $row1["COUNT(id)"];
                    }
                }
                // Calculate Risk
                $table[$j][3] = calcRisk($table[$j][1], $table[$j][2], $radVal1, $radVal2);
                $j++;
            }
        } else {
            // No Results
            echo "<p id='noResults'>No Results.</p>";
        }
        return $table; // Return the table.
    }

    function calcRisk($n1, $n2, $radius1, $radius2)
    {
        // Get Area
        $area1 = PI()*$radius1*$radius1;
        $area2 = PI()*$radius2*$radius2;

        // Get Radius
        $calcRad1 = $n1/$area1;
        $calcRad2 = $n2/$area2;

        // If no data.
        if ($n1 == 0) {
            // N/A
            $calculation = "<span class='naSign'> - </span>";
        } else {
            // Get Risk
            $calculation = round(log($calcRad1/$calcRad2, 2), 2);
        }

        return $calculation; // Return Calculation
    }

    function renderTable($table)
    {
        // Init Running Total Values
        $runningCountL = $runningCountI = 0; ?>
      <table id="myTable2" class='table table-bordered'>
        <thead>
          <tr>
            <th id="headerCrime" class='text-center text-bold' onclick="sortTable(0)">Crime</th>
            <th id="headerImmediate" class='text-center text-bold' onclick="sortTable(1)">Immediate</th>
            <th id="headerLocal" class='text-center text-bold' onclick="sortTable(2)">Local</th>
            <th id="headerRisk" class='text-center text-bold' onclick="sortTable(3)">Risk</th>
            <th id="headerRiskGraphic" class='text-center text-bold' onclick="sortTable(4)">Risk Graphic</th>
          </tr>
        </thead>
        <tbody>
      <?php for ($i=0; $i < count($table); $i++) {
            ?>
        <tr>
          <td class=''><?php echo $table[$i][0] ?></td>
          <td class='text-center'>
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
          <td class='text-center'><?php echo number_format($table[$i][2]) ?></td>
          <td class='text-center <?php echo colourRisk($table[$i][3]) ?>'><?php echo $table[$i][3] ?></td>
          <td class='text-center'><div><input class="form-control-range" type="range" min="-3" max="3" step="0.01" disabled value="<?php echo $table[$i][3] ?>" class="slider" id="myRange"></div></td>
        </tr>
        <?php
        // Contribute to running count.
        $runningCountL = $runningCountL + $table[$i][2];
        } ?>
        </tbody>
      </table>
      <table class='table table-bordered'>
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

    function colourRisk($risk)
    {
        // Threshold Value
        $thresh = 1.0;

        // Red
        if ($risk > $thresh) {
            $colour = "alert-danger"; // Red
        }

        // Grey
        if ($risk == " - ") {
            $colour = "alert-active"; // Grey
        }

        // Green
        if ($risk < -$thresh) {
            $colour = "alert-success"; // Green
        }

        return $colour;
    }

    // Immediate
    $latLow1    = $latVal - $radVal1;
    $latHigh1   = $latVal + $radVal1;
    $longLow1   = $longVal - $radVal1;
    $longHigh1  = $longVal + $radVal1;
    // Local
    $latLow2    = $latVal - $radVal2;
    $latHigh2   = $latVal + $radVal2;
    $longLow2   = $longVal - $radVal2;
    $longHigh2  = $longVal + $radVal2;

    // Run Queries
    $resultCount_Immediate  = sqlCrimeArea($mysqli, $longLow1, $longHigh1, $latLow1, $latHigh1, $latVal, $longVal, $radVal1);
    $resultCount_Local      = sqlCrimeArea($mysqli, $longLow2, $longHigh2, $latLow2, $latHigh2, $latVal, $longVal, $radVal2);

    // Generate Table of Data
    $table = preCalcTable($resultCount_Immediate, $resultCount_Local, $radVal1, $radVal2);

    // Generate Visual Table
    renderTable($table);

    // Display Script End time
    $time_end = microtime(true);

    //dividing with 60 will give the execution time in minutes other wise seconds
    $execution_time = ($time_end - $time_start);

    //execution time of the script
    echo '<b>Total Execution Time:</b> ' . number_format($execution_time, 4) . ' Seconds';
}
 ?>
