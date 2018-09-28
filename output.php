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
        die("Only Supperted in the UK.");
    }
} else {
    die("Longitude needs to be between -180 and 180 degrees.");
}

// Check that Radius values are in the right range.
if ($radVal2 <= $radVal1) {
    die("Local area is smaller than your Immediate area.");
}
 ?>
  <!-- Container -->
  <div id='bodyContainer' class="container">

    <!-- Render Table -->
    <?php
    if ($mode == 0) {
        echo "<h2>Crime Counter</h2>";
        echo crimeCounter($mysqli, $latVal, $longVal, $radVal1, $radVal2); // Crime Count
    }

    if ($mode == 1) {
        echo "<h2>Time Series</h2>";
        echo timeSeries($mysqli, $latVal, $longVal, $radVal1); // Time Series
    }
    ?>
</div>
    <!-- Footer -->
    <?php include 'partials/_footer.php' ?>
</body>
</html>
