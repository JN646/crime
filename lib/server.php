<?php
//############## SERVER FILE ###################################################

// Get Database Config
include_once '../config/config.php';
include_once '../lib/functions.php';
?>

<!-- Head -->
<head>
  <!-- Title -->
  <title>Server Page</title>
  <!-- Stylesheet -->
  <link rel="stylesheet" href="../css/basic.css">
</head>

<?php
// Flags
$failFlag = 0;

//############## CHECK EMPTY ###################################################
// Longitude
if (!empty($_POST["long"])) {
    $longVal = trim((float)$_POST["long"]);
} else {
    echo "<p>Long is missing.</p>";
    $longVal = 0;
    $failFlag = 1;
}

// Latitude
if (!empty($_POST["lat"])) {
    $latVal = trim((float)$_POST["lat"]);
} else {
    echo "<p>Lat is missing.</p>";
    $latVal = 0;
    $failFlag = 1;
}

// Radius 1
if (!empty($_POST["rad1"])) {
    $radVal1 = trim((float)$_POST["rad1"]);
} else {
    echo "<p>Rad1 is missing.</p>";
    $radVal1 = 0;
    $failFlag = 1;
}

// Radius 2
if (!empty($_POST["rad2"])) {
    $radVal2 = trim((float)$_POST["rad2"]);
} else {
    echo "<p>Rad2 is missing.</p>";
    $radVal2 = 0;
    $failFlag = 1;
}

// Store in array
$crimeValues = array($longVal,$latVal,$radVal1,$radVal2,$monthVal,$yearVal);

//############## RANGE CALC ####################################################
if ($failFlag != 1) {
    // Immediate
    $latLow1    = $latVal - $radVal1;
    $latHigh1   = $latVal + $radVal1;
    $longLow1   = $longVal - $radVal1;
    $longHigh1  = $longVal + $radVal1;

    // Map to array
    $immediateCal = array($latLow1,$latHigh1,$longLow1,$longHigh1);

    // Local
    $latLow2    = $latVal - $radVal2;
    $latHigh2   = $latVal + $radVal2;
    $longLow2   = $longVal - $radVal2;
    $longHigh2  = $longVal + $radVal2;

    // Map to array
    $localCal = array($latLow2,$latHigh2,$longLow2,$longHigh2);
}

// Output Array
if ($failFlag != 1) {

    // JSON Output
    echo "<h2>JSON Output</h2>";
    echo "<h3>Immediate Values</h3>";
    echo JSONOutput($immediateCal, $radVal1);

    echo "<h3>Local Values</h3>";
    echo JSONOutput($localCal, $radVal1);

    // Run Queries
    $resultCount_Immediate  = sqlCrimeArea($mysqli, $longLow1, $longHigh1, $latLow1, $latHigh1, $latVal, $longVal, $radVal1, $monthVal, $yearVal);
    $resultCount_Local      = sqlCrimeArea($mysqli, $longLow2, $longHigh2, $latLow2, $latHigh2, $latVal, $longVal, $radVal2, $monthVal, $yearVal);

    // Generate Table
    $table = preCalcTable($resultCount_Immediate, $resultCount_Local, $radVal1, $radVal2);
    renderTable($table);

    // Back
    echo "<p><a href='../index.php'>Back</a></p>";
}

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

    // Return the table.
    return $table;
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
        // N/A
        $c = " - ";
    } else {
        // Get Risk
        $c = round(log($calcRad1/$calcRad2, 2), 2);
    }

    // Return Calculation
    return $c;
}

//############## MAKE TABLE ####################################################
function renderTable($table)
{
    // Init Running Total Values
    $runningCountL = $runningCountI = 0; ?>
    <h2>Crimes Around You</h2>
    <table class='table-border' width=50%>
      <tr>
        <th class='text-center text-bold'>Crime</th>
        <th class='text-center text-bold'>Immediate</th>
        <th class='text-center text-bold'>Local</th>
        <th class='text-center text-bold'>Risk</th>
        <th class='text-center text-bold'>Risk Graphic</th>
      </tr>
    <?php for ($i=0; $i < count($table); $i++) { ?>
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
        <td class='text-center'><?php echo $table[$i][3] ?></td>
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
    <?php
}

//############## RUN SQL #######################################################
// SQL Immediate
function sqlCrimeArea($mysqli, $longLow, $longHigh, $latLow, $latHigh, $latVal, $longVal, $radVal, $monthList)
{
    //immediate area
    $sql_immediate = "SELECT COUNT(id), Longitude, Latitude, Crime_Type, Month FROM data
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
 ?>
