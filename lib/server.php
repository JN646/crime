<?php
//############## SERVER FILE ###################################################

// Get Database Config
include_once '../config/config.php';
include_once '../lib/functions.php';

// Search Button Press
$longVal    = trim($_POST["long"]);
$latVal     = trim($_POST["lat"]);
$radVal1    = trim($_POST["rad1"]);
$radVal2    = trim($_POST["rad2"]);
$monthVal   = trim($_POST["month"]);
$yearVal    = trim($_POST["year"]);
$crimeVal   = trim($_POST["crime"]);

// Precalculation of ranges
$latLow1    = $latVal - $radVal1;
$latHigh1   = $latVal + $radVal1;
$longLow1   = $longVal - $radVal1;
$longHigh1  = $longVal + $radVal1;

$latLow2    = $latVal - $radVal2;
$latHigh2   = $latVal + $radVal2;
$longLow2   = $longVal - $radVal2;
$longHigh2  = $longVal + $radVal2;

// Run Queries
$resultCount_Immediate  = sqlImmediate($mysqli, $longLow1, $longHigh1, $latLow1, $latHigh1, $latVal, $longVal, $radVal1, $monthVal, $yearVal, $crimeVal);
$resultCount_Local      = sqlLocal($mysqli, $longLow2, $longHigh2, $latLow2, $latHigh2, $latVal, $longVal, $radVal2, $monthVal, $yearVal, $crimeVal);

// Generate Table
tableGen($resultCount_Immediate, $resultCount_Local);

//############## MAKE TABLE ####################################################
function tableGen($resultCount_Immediate, $resultCount_Local)
{
    // Fetch Results
    if (mysqli_num_rows($resultCount_Immediate) > 0 || mysqli_num_rows($resultCount_Local) > 0) {
        ?>

      <!-- Result Table -->
      <h2>Crimes Around You</h2>
      <table class='table-border' width=100%>
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

            <!-- Number of Results -->
            <td class='text-center'>
              <?php $n = 0;
          $row1 = mysqli_fetch_assoc($resultCount_Immediate);
          for ($i=0; $i < count($resultCount_Immediate); $i++) {
              if ($row1["Crime_Type"] == $crime_type) {
                  $n = $row1["COUNT(id)"];
              }
          }
          echo $n; ?>
            </td>

            <!-- Crime Count -->
            <td class='text-center'><?php echo $crime_count; ?></td>

            <!-- Crime Risk -->
            <td class='text-center'><?php echo "<span class='bold risk_" . getRisk($crime_count) ."'>" . getRisk($crime_count) . "</span>"?></td>
          </tr>
        <?php
      } ?>
      </table>
      <?php

      inDanger($crime_count);
    } else {
        // No Results
        echo "<p id='noResults'>0 results</p>";
    }
}

//############## RUN SQL #######################################################
// SQL Immediate
function sqlImmediate($mysqli, $longLow1, $longHigh1, $latLow1, $latHigh1, $latVal, $longVal, $radVal1, $monthVal, $yearVal, $crimeVal)
{
    //immediate area
    $sql_immediate = "SELECT COUNT(id), Longitude, Latitude, Crime_Type, Month, Year FROM data
  WHERE Longitude > $longLow1 AND Longitude < $longHigh1 AND Latitude > $latLow1 AND Latitude < $latHigh1 AND SQRT(POW(Latitude-'$latVal', 2)+POW(Longitude-'$longVal', 2))<'$radVal1'
  AND Month='$monthVal'
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

    return $resultCount_Local;
}
 ?>
