<?php
//############## SERVER FILE ###################################################

// Get Database Config
include_once '../config/config.php';
include_once '../lib/functions.php';
?>

<!-- Stylesheet -->
<link rel="stylesheet" href="../css/basic.css">

<?php
// Flags
$failFlag = 0;

// Check Empty.
if (!empty($_POST["long"])) {
  $longVal    = trim($_POST["long"]);;
} else {
  echo "<p>Long is missing.</p>";
  $longVal = 0;
  $failFlag = 1;
}

if (!empty($_POST["lat"])) {
  $latVal     = trim($_POST["lat"]);
} else {
  echo "<p>Lat is missing.</p>";
  $latVal = 0;
  $failFlag = 1;
}

if (!empty($_POST["rad1"])) {
  $radVal1    = trim($_POST["rad1"]);
} else {
  echo "<p>Rad1 is missing.</p>";
  $radVal1 = 0;
  $failFlag = 1;
}

if (!empty($_POST["rad2"])) {
  $radVal2    = trim($_POST["rad2"]);
} else {
  echo "<p>Rad2 is missing.</p>";
  $radVal2 = 0;
  $failFlag = 1;
}

if (!empty($_POST["month"])) {
  $monthVal   = $_POST["month"];

  $monthList = implode(", ",$monthVal);
  $monthSQL = implode(" and ",$monthVal);
} else {
  echo "<p>month is missing.</p>";
  $monthVal = 0;
  $failFlag = 1;
}

if (!empty($_POST["year"])) {
  $yearVal    = trim($_POST["year"]);
} else {
  echo "<p>Year is missing.</p>";
  $yearVal = 0;
  $failFlag = 1;
}

if (!empty($_POST["crime"])) {
  $crimeVal   = trim($_POST["crime"]);
} else {
  echo "<p>Crime Type is missing.</p>";
  $crimeVal = 0;
  $failFlag = 1;
}

// Store in array
$crimeValues = array($longVal,$latVal,$radVal1,$radVal2,$monthList,$yearVal,$crimeVal);

// Output Array
if ($failFlag != 1) {
  echo "<h3>Debug POST Values</h3>";
  for ($i=0; $i < count($crimeValues); $i++) {
    echo "<p>" . $crimeValues[$i] . "</p>";
  }
}

// Precalculation of ranges
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
  // Immediate Array
  echo "<h3>Immediate Values</h3>";
  for ($i=0; $i < count($immediateCal); $i++) {
    echo "<p>" . $immediateCal[$i] . "</p>";
  }

  // Local Array
  echo "<h3>Local Values</h3>";
  for ($i=0; $i < count($localCal); $i++) {
    echo "<p>" . $localCal[$i] . "</p>";
  }

  // Run Queries
  $resultCount_Immediate  = sqlImmediate($mysqli, $longLow1, $longHigh1, $latLow1, $latHigh1, $latVal, $longVal, $radVal1, $monthVal, $yearVal, $crimeVal);
  $resultCount_Local      = sqlLocal($mysqli, $longLow2, $longHigh2, $latLow2, $latHigh2, $latVal, $longVal, $radVal2, $monthVal, $yearVal, $crimeVal);

  // Generate Table
  tableGen($resultCount_Immediate, $resultCount_Local);
}
//############## MAKE TABLE ####################################################
function tableGen($resultCount_Immediate, $resultCount_Local)
{
    // Fetch Results
    if (mysqli_num_rows($resultCount_Immediate) > 0 || mysqli_num_rows($resultCount_Local) > 0) {
        ?>

      <!-- Result Table -->
      <h2>Crimes Around You</h2>
      <table class='table-border' width=500px>
        <tr>
          <th class='text-center text-bold'>Crime</th>
          <th class='text-center text-bold'>Immediate</th>
          <th class='text-center text-bold'>Local</th>
          <th class='text-center text-bold'>Risk</th>
        </tr>
        <?php
      while ($row = mysqli_fetch_assoc($resultCount_Local)) {
          // Set Variables
          $crime_type = $row["Crime_Type"];
          $crime_count = $row["COUNT(id)"]; ?>

          <!-- Rows -->
          <tr>
            <!-- Crime Type -->
            <td><?php echo $crime_type; ?></td>

            <!-- Number of Crimes -->
            <td class='text-center'>
              <?php
                // Init Value
                $n = 0;

                // Get Immediate Count
                $row1 = mysqli_fetch_assoc($resultCount_Immediate);

                // Loop Crime Type
                for ($i=0; $i < count($resultCount_Immediate); $i++) {

                    // If they Match
                    if ($row1["Crime_Type"] == $crime_type) {

                        // Set n as Count
                        $n = $row1["COUNT(id)"];
                    }
                }

                // Print Count
                echo $n;
              ?>
            </td>

            <!-- Local Crime Count -->
            <td class='text-center'><?php echo $crime_count; ?></td>

            <!-- Crime Risk -->
            <td class='text-center'><?php echo "<span class='bold risk_" . getRisk($crime_count) ."'>" . getRisk($crime_count) . "</span>"?></td>
          </tr>
        <?php
      } ?>
      </table>
      <?php

      inDanger($crime_type,$crime_count,getRisk($crime_count));
    } else {
        // No Results
        echo "<p id='noResults'>0 results</p>";
    }
}

//############## RUN SQL #######################################################
// SQL Immediate
function sqlImmediate($mysqli, $longLow1, $longHigh1, $latLow1, $latHigh1, $latVal, $longVal, $radVal1, $monthList, $yearVal, $crimeVal)
{
    //immediate area
    $sql_immediate = "SELECT COUNT(id), Longitude, Latitude, Crime_Type, Month, Year FROM data
  WHERE Longitude > $longLow1 AND Longitude < $longHigh1 AND Latitude > $latLow1 AND Latitude < $latHigh1 AND SQRT(POW(Latitude-'$latVal', 2)+POW(Longitude-'$longVal', 2))<'$radVal1'
  AND Month='$monthList'
  AND Year='$yearVal'
  AND Crime_Type='$crimeVal'
  GROUP BY Crime_Type
  ORDER BY COUNT(id) DESC";

    // Run Query
    $resultCount_Immediate = mysqli_query($mysqli, $sql_immediate);

    // If Error
    if (!$resultCount_Immediate) {
        die('Could not run query: ' . mysqli_error($mysqli));
    }

    // Return
    return $resultCount_Immediate;
}

// SQL Local
function sqlLocal($mysqli, $longLow2, $longHigh2, $latLow2, $latHigh2, $latVal, $longVal, $radVal2, $monthVal, $yearVal, $crimeVal)
{
    //local area
    $sq2_local = "SELECT COUNT(id), Longitude, Latitude, Crime_Type, Month, Year FROM data
  WHERE Longitude > $longLow2 AND Longitude < $longHigh2 AND Latitude > $latLow2 AND Latitude < $latHigh2 AND SQRT(POW(Latitude-'$latVal', 2)+POW(Longitude-'$longVal', 2))<'$radVal2'
  AND Month='$monthVal'
  AND Year='$yearVal'
  AND Crime_Type='$crimeVal'
  GROUP BY Crime_Type
  ORDER BY COUNT(id) DESC";

    // Run Query
    $resultCount_Local = mysqli_query($mysqli, $sq2_local);

    // If Error
    if (!$resultCount_Local) {
        die('Could not run query: ' . mysqli_error($mysqli));
    }

    // Return
    return $resultCount_Local;
}
 ?>
