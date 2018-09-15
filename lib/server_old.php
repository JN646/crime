<?php
// DO NOT USE - BEING REMODELLED.
//############## SERVER FILE ###################################################

// Get Database Config
include_once '../config/config.php';
include_once '../lib/functions.php';

//############## CHECK VALUES ##################################################
// Missing Value Check
if (!empty($_POST["long"]) || !empty($_POST["lat"]) || !empty($_POST["rad1"]) || !empty($_POST["rad2"]) || !empty($_POST["month"])) {
    $longVal = trim((float)$_POST["long"]);
    $latVal = trim((float)$_POST["lat"]);
    $month = trim((float)$_POST["month"]);
    $radVal1 = trim((float)$_POST["rad1"]);
    $radVal2 = trim((float)$_POST["rad2"]);
} else {
    die("Error Missing Values Found.");
}

// Check that Lat/Long values are in the right range.
if ((-90.00 <= $latVal) && ($latVal <= 90.00)) {
    // Needs Condensing
    if ((-49.00 <= $latVal) && ($latVal <= 60.00)) {
        // Needs Condensing
    } else {
      die("Only UK Supported.");
    }
} else {
  die("Latitude needs to be between -90 and 90 degrees.");
}

// Check that Lat/Long values are in the right range.
if ((-180.00 <= $longVal) && ($longVal <= 180.00)) {
    // Needs Condensing
    if ((-11.00 <= $longVal) && ($longVal <= 1.00)) {
        // Needs Condensing
        } else {
      die("Longitude needs to be between -180 and 180 degrees.");
    }
} else {
  die("Longitude needs to be between -180 and 180 degrees.");
}

// Check that Radius values are in the right range.
if ($radVal2 <= $radVal1) {
    die("Local area is smaller than your Immediate area.");
}

// Store in array
$crimeValues = array($longVal,$latVal,$radVal1,$radVal2);

//############## RANGE CALC ####################################################
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

// Map to array
$immediateCal = array($latLow1,$latHigh1,$longLow1,$longHigh1);
$localCal = array($latLow2,$latHigh2,$longLow2,$longHigh2);

// Run Queries
$resultCount_Immediate  = sqlCrimeArea($mysqli, $longLow1, $longHigh1, $latLow1, $latHigh1, $latVal, $longVal, $radVal1);
$resultCount_Local      = sqlCrimeArea($mysqli, $longLow2, $longHigh2, $latLow2, $latHigh2, $latVal, $longVal, $radVal2);

// Generate Table
$table = preCalcTable($resultCount_Immediate, $resultCount_Local, $radVal1, $radVal2);
echo renderTable($table);

// JSON Output
if ($JSONEnable == "TRUE") {
  echo "<h2>JSON Output</h2><h3>Immediate Values</h3>";
  echo sqlCrimeAreaJSON($mysqli, $longLow1, $longHigh1, $latLow1, $latHigh1, $latVal, $longVal, $radVal1);

  echo "<h3>Local Values</h3>";
  echo sqlCrimeAreaJSON($mysqli, $longLow2, $longHigh2, $latLow2, $latHigh2, $latVal, $longVal, $radVal2);
}
?>
<p><a href='../index.php'>Back</a></p>
</div>
<?php
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
        echo "<p id='noResults'>preCalcTable: No Results.</p>";
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
    <h2>Crimes Around You</h2>
    <table id="myTable2" class='table-border' width=50%>
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
          // Replace 0 with -
          if ($table[$i][1] == 0) {
              echo "-";
          } else {
              // Echo Output
              echo number_format($table[$i][1]);

              // Running Total
              $runningCountI = $runningCountI + $table[$i][1];
          } ?>
       </td>
        <td class='text-center'><?php echo number_format($table[$i][2]) ?></td>
        <td class='text-center' style='background-color:<?php echo colourRisk($table[$i][3]) ?>'><?php echo $table[$i][3] ?></td>
        <td class='text-center'><div class="slidecontainer"><input type="range" min="-3" max="3" step="0.01" disabled value="<?php echo $table[$i][3] ?>" class="slider" id="myRange"></div></td>
      </tr>
      <?php
      $runningCountL = $runningCountL + $table[$i][2];
    } ?>
    <tr>
      <td class='outputText text-bold'>Total Reported Crimes</td>
      <td class='outputText text-center text-bold'><?php echo number_format($runningCountI) ?></td>
      <td class='outputText text-center text-bold'><?php echo number_format($runningCountL) ?></td>
    </tr>
    </table>
    <script src='../js/global.js'></script>
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

    // Return
    return $resultCount_Immediate;
}

//############## JSON OUTPUT ###################################################
function sqlCrimeAreaJSON($mysqli, $longLow, $longHigh, $latLow, $latHigh, $latVal, $longVal, $radVal)
{
    //immediate area
    $sql_immediate = "SELECT COUNT(id), Longitude, Latitude, Crime_Type FROM data
    WHERE Longitude > $longLow AND Longitude < $longHigh AND Latitude > $latLow AND Latitude < $latHigh AND SQRT(POW(Latitude-'$latVal', 2)+POW(Longitude-'$longVal', 2))<'$radVal'
    GROUP BY Crime_Type
    ORDER BY COUNT(id) DESC";

    // Run Query
    $resultCount_Immediate = mysqli_query($mysqli, $sql_immediate);

    // If Error
    if (!$resultCount_Immediate) {
        die('<p class="SQLError">Could not run query: ' . mysqli_error($mysqli) . '</p>');
    }

    //loop through the returned data
    $myObj = array();
    foreach ($resultCount_Immediate as $row) {
        $myObj[] = $row;
    }

    //now print the data
    $myJSON= json_encode($myObj);
    echo $myJSON;
}
 ?>
