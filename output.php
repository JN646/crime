<!-- Header Form -->
<?php include 'partials/_header.php' ?>

<!-- Include Reporting Options -->
<?php include 'lib/crimecount.php' ?>
<?php include 'lib/timeseries.php' ?>

<?php
//############## SERVER FILE ###################################################
//############## CHECK VALUES ##################################################
// Missing Value Check
if (!empty($_POST["long"]) || !empty($_POST["lat"]) || !empty($_POST["rad1"]) || !empty($_POST["rad2"]) || !empty($_POST["month"])) {
    $latVal = trim((float)$_POST["lat"]);
    $longVal = trim((float)$_POST["long"]);
    $month = trim((float)$_POST["month"]);
    $radVal1 = trim((float)$_POST["rad1"]);
    $radVal2 = trim((float)$_POST["rad2"]);
    $mode = $_POST["mode"];
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
 ?>
  <!-- Container -->
  <div id='bodyContainer' class="container">

    <!-- Render Table -->
    <h2>Time Series</h2>
    <?php
    if ($mode == 0) {
      echo renderTable($table); // Crime Count
    }

    if ($mode == 1) {
      echo timeSeries($mysqli,$latVal,$longVal,$radVal1); // Time Series
    }
    ?>
</div>
    <!-- Footer -->
    <?php include 'partials/_footer.php' ?>
</body>
</html>
