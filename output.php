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

    <!-- Nav Pills -->
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

      <!-- Crime Counter -->
      <li class="nav-item">
        <a class="nav-link active" id="pills-crimecounter-tab" data-toggle="pill" href="#pills-crimecounter" role="tab" aria-controls="pills-crimecount" aria-selected="true">Crime Counter</a>
      </li>

      <!-- Something Else -->
      <li class="nav-item">
        <a class="nav-link" id="pills-p2-tab" data-toggle="pill" href="#pills-p2" role="tab" aria-controls="pills-p2" aria-selected="false">Pane 2</a>
      </li>

      <!-- Time Series Chart -->
      <li class="nav-item">
        <a class="nav-link" id="pills-timeseries-tab" data-toggle="pill" href="#pills-timeseries" role="tab" aria-controls="pills-timeseries" aria-selected="false">Time Series</a>
      </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">

      <!-- Crime Counter -->
      <div class="tab-pane fade show active" id="pills-crimecounter" role="tabpanel" aria-labelledby="pills-crimecounter-tab">
        <!-- Block Header -->
        <h2>Crime Counter</h2>
        <?php echo reportHeader($latVal, $longVal); ?>
        <?php echo crimeCounter($mysqli, $latVal, $longVal, $radVal1, $radVal2); ?>
      </div>

      <!-- Something Else -->
      <div class="tab-pane fade" id="pills-p2" role="tabpanel" aria-labelledby="pills-p2-tab">
        <!-- Block Header -->
        <h2>Something Else</h2>
        <?php echo reportHeader($latVal, $longVal); ?>
      </div>

      <!-- Time Series Chart -->
      <div class="tab-pane fade" id="pills-timeseries" role="tabpanel" aria-labelledby="pills-timeseries-tab">
        <!-- Block Header -->
        <h2>Time Series Chart</h2>
        <?php echo reportHeader($latVal, $longVal); ?>

        <canvas id="lineChart"></canvas>

    		<script type="text/javascript">
    			// Get array from PHP
    			var myData = <?php echo json_encode($data); ?>;

    			console.log(myData);

    			var ctxL = document.getElementById("lineChart").getContext('2d');
    			var lineChart = new Chart(ctxL, data);
    		</script>
      </div>
    </div>
</div>
    <!-- Footer -->
    <?php include 'partials/_footer.php' ?>
</body>
</html>
