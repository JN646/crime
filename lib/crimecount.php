<?php
// DO NOT USE - BEING REMODELLED.
//############## SERVER FILE ###################################################

// Get Database Config
include_once 'functions.php';

//############## MAKE ARRAY ####################################################
function preCalcTable($resultCount_Immediate, $resultCount_Local, $radVal1, $radVal2)
{
    $nRows = mysqli_num_rows($resultCount_Local);
    $table = array(array(),array(),array(),array());
    // Fetch Results
    if ($nRows) {
        $j = 0; //table index
        while ($row = mysqli_fetch_assoc($resultCount_Local)) {
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
            //calculate risk here...?
            $table[$j][3] = calcRisk($table[$j][1], $table[$j][2], $radVal1, $radVal2);
            $j++;
        }
    } else {
        // No Results
        echo "<p id='noResults'>No Results.</p>";
    }
    return $table; // Return the table.
}

//############## CALC RISK #####################################################
function calcRisk($n1, $n2, $r1, $r2)
{
    // Get Area
    $area1 = PI()*$r1*$r1;
    $area2 = PI()*$r2*$r2;

    // Get Radius
    $calcRad1 = $n1/$area1;
    $calcRad2 = $n2/$area2;

    // If no data.
    if ($n1 == 0) {
        $c = "<span class='naSign'> - </span>"; // N/A
    } else {
        $c = round(log($calcRad1/$calcRad2, 2), 2); // Get Risk
    }

    return $c; // Return Calculation
}

//############## MAKE TABLE ####################################################
function renderTable($table)
{
    // Init Running Total Values
    $runningCountL = $runningCountI = 0; ?>
    <table id="myTable2" class='table table-bordered'>
      <tr>
        <th id="headerCrime" class='text-center text-bold' onclick="sortTable(0)">Crime</th>
        <th id="headerImmediate" class='text-center text-bold' onclick="sortTable(1)">Immediate</th>
        <th id="headerLocal" class='text-center text-bold' onclick="sortTable(2)">Local</th>
        <th id="headerRisk" class='text-center text-bold' onclick="sortTable(3)">Risk</th>
        <th id="headerRiskGraphic" class='text-center text-bold' onclick="sortTable(4)">Risk Graphic</th>
      </tr>
    <?php for ($i=0; $i < count($table); $i++) {
        ?>
      <tr>
        <td class=''><?php echo $table[$i][0] ?></td>
        <td class='text-center'>
          <?php
          // IMMEDIATE
          if ($table[$i][1] == 0) {
              echo "-";
          } else {
              echo number_format($table[$i][1]);
              $runningCountI = $runningCountI + $table[$i][1];
          } ?>
       </td>
        <td class='text-center'><?php echo number_format($table[$i][2]) ?></td>
        <td class='text-center' style='background-color:<?php echo colourRisk($table[$i][3]) ?>'><?php echo $table[$i][3] ?></td>
        <td class='text-center'><div><input class="form-control-range" type="range" min="-3" max="3" step="0.01" disabled value="<?php echo $table[$i][3] ?>" class="slider" id="myRange"></div></td>
      </tr>
      <?php $runningCountL = $runningCountL + $table[$i][2]; ?>
<?php } ?>
      <tr>
        <td class='outputText text-bold'>Total Reported Crimes</td>
        <td class='outputText text-center text-bold'><?php echo number_format($runningCountI) ?></td>
        <td class='outputText text-center text-bold'><?php echo number_format($runningCountL) ?></td>
      </tr>
    </table>
    <?php
}

//############## RUN SQL #######################################################
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

//############## COLOUR RISK ###################################################
//############## Risk to Colour ################################################
function colourRisk($risk)
{
    $thresh = 1.0;
    $colour = "rgba(255, 235, 59, 0.7)"; // Default to yellow

    if($risk > $thresh) {
      $colour = "#dd2c00"; // Red
    }

    if($risk > $thresh/2 && $risk < $thresh) {
      $colour = "rgba(255, 152, 0, 0.7) "; // Orange
    }

    if($risk == " - ") {
      $colour = "rgba(158, 158, 158, 0.3)"; // Grey
    }

    if($risk < -$thresh/2 && $risk < -$thresh) {
      $colour = "rgba(205, 220, 57, 0.7)"; // Light Green
    }

    if($risk < -$thresh) {
      $colour = "rgba(76, 175, 80, 0.7)"; // Green
    }

    return $colour;
}

//############## Colour Gradient ###############################################
function GreenYellowRed($number)
{
    $number = $number * (255/100);
    $number--; // working with 0-99 will be easier.

    // Check if colour is less than half the range.
    if ($number < 50) {
        // green to yellow
        $r = floor(255 * ($number / 50));
        $g = 255;
    } else {
        // yellow to red.
        $r = 255;
        $g = floor(255 * ((50-$number%50) / 50));
    }
    $b = 0;

    // Return colour value.
    return "$r,$g,$b";
}
 ?>
