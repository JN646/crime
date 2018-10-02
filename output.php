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
      ?>
      <!-- Toolbar -->
      <div id="crimeCountToolbar">
        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
          <div class="btn-group mr-2" role="group" aria-label="First group">
            <button id='riskSliderToggle' type="button" onclick="toggleRiskSlider()" class="btn btn-secondary">Risk Slider</button>
            <!-- <button type="button" class="btn btn-secondary">2</button>
            <button type="button" class="btn btn-secondary">3</button>
            <button type="button" class="btn btn-secondary">4</button> -->
          </div>
          <div class="btn-group mr-2" role="group" aria-label="Second group">
            <button type="button" onclick="window.print()" class="btn btn-secondary"><i class="fas fa-print"></i></button>
            <!-- <button type="button" class="btn btn-secondary">6</button>
            <button type="button" class="btn btn-secondary">7</button> -->
          </div>
          <div class="btn-group" role="group" aria-label="Third group">
            <!-- <button type="button" class="btn btn-secondary">8</button> -->
          </div>
        </div>
      </div>

      <br>

      <!-- Block Header -->
      <h2>Crime Counter</h2>

        <!-- Table -->
        <table class='table col-md-6'>
          <tbody>
            <tr>
              <td><b>Location:</b></td>
              <td><?php echo $latVal ?>, <?php echo $longVal ?></td>
            </tr>
            <tr>
              <td><b>Generated:</b></td>
              <td><?php echo date("d/m/y") ?></td>
            </tr>
          </tbody>
        </table>
        <?php
        echo crimeCounter($mysqli, $latVal, $longVal, $radVal1, $radVal2); // Crime Count
    }

    if ($mode == 1) {
      ?>
        <h2>Time Series</h2>
        <table class='table col-md-6'>
          <tbody>
            <tr>
              <td><b>Location:</b></td>
              <td><?php echo $latVal ?>, <?php echo $longVal ?></td>
            </tr>
            <tr>
              <td><b>Generated:</b></td>
              <td>01/10/2018</td>
            </tr>
          </tbody>
        </table>
        <?php
        echo timeSeries($mysqli, $latVal, $longVal, $radVal1); // Time Series
    }
    ?>
</div>
    <!-- Footer -->
    <?php include 'partials/_footer.php' ?>
</body>
</html>
