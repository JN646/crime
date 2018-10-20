<!-- Header Form -->
<?php include 'partials/_header.php'; ?>
<script src="<?php echo $environment; ?>js/Chart.min.js" charset="utf-8"></script>

<!-- Include Reporting Options -->
<?php include 'lib/crimecount.php'; ?>
<?php include 'lib/timeseries2.php'; ?>
<?php include 'lib/Compare.php'; ?>

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

			<!-- Time Series Chart -->
			<li class="nav-item">
				<a class="nav-link" id="pills-timeseries-tab" data-toggle="pill" href="#pills-timeseries" role="tab" aria-controls="pills-timeseries" aria-selected="false">Time Series</a>
			</li>

			<!-- Compare Areas -->
			<li class="nav-item">
				<a class="nav-link" id="pills-compare-tab" data-toggle="pill" href="#pills-compare" role="tab" aria-controls="pills-compare" aria-selected="false">Compare</a>
			</li>

			<!-- Something Else -->
			<li class="nav-item">
				<a class="nav-link" id="pills-p2-tab" data-toggle="pill" href="#pills-p2" role="tab" aria-controls="pills-p2" aria-selected="false">Panel 4</a>
			</li>
		</ul>
		<div class="tab-content" id="pills-tabContent">

			<!-- Crime Counter -->
			<div class="tab-pane fade show active" id="pills-crimecounter" role="tabpanel" aria-labelledby="pills-crimecounter-tab">
				<!-- Block Header -->
				<h2>Crime Counter</h2>
				<?php
					echo reportHeader($latVal, $longVal);
			$crimeCountData = crimeCounter($latVal, $longVal);
					if(is_null($crimeCountData)) {
						echo "ChartData class has no datasets assigned, therefore returned NULL.";
					}
				?>
				<canvas id="crimeCountChart"></canvas>

				<script type="text/javascript">
					// Get array from PHP
					var ccData = <?php echo json_encode($crimeCountData); ?>;
					console.log(ccData);

					var ctx = document.getElementById("crimeCountChart").getContext('2d');
					var ccChart = new Chart(ctx, ccData);
				</script>
			</div>

			<!-- Time Series Chart -->
			<div class="tab-pane fade" id="pills-timeseries" role="tabpanel" aria-labelledby="pills-timeseries-tab">
				<!-- Block Header -->
				<h2>Time Series Chart</h2>
				<?php
					// Report Header
					echo reportHeader($latVal, $longVal);

					// Get Time Series
					$timeSeriesData = timeSeriesRequest($latVal, $longVal);

					// If NULL
					if(is_null($timeSeriesData)) {
						echo "ChartData class has no datasets assigned, therefore returned NULL.";
					}
				?>
				<canvas id="timeSeriesChart"></canvas>
				<script type="text/javascript">
					// Get array from PHP
					var TSData = <?php echo json_encode($timeSeriesData); ?>;
					console.log(TSData);

					var ctx = document.getElementById("timeSeriesChart").getContext('2d');
					var tsChart = new Chart(ctx, TSData);
				</script>
			</div>

			<!-- Compare Area -->
			<div class="tab-pane fade" id="pills-compare" role="tabpanel" aria-labelledby="pills-compare-tab">
				<!-- Block Header -->
				<h2>Go Compare</h2>
				<?php
					// Report Header
					echo reportHeader($latVal, $longVal);

					// Get Compare
					$compareData = compareRequest($latVal, $longVal, 52.13, -0.46); // variables currently set as static here
					echo "This comparison is with a static lat/long of: 52.13, -0.46<br>";
				?>
				<canvas id="compareChart"></canvas>
				<script type="text/javascript">
					// Get array from PHP
					var cData = <?php echo json_encode($compareData); ?>;
					console.log(cData);

					var ctx = document.getElementById("compareChart").getContext('2d');
					var cChart = new Chart(ctx, cData);
				</script>
			</div>

			<!-- Something Else -->
			<div class="tab-pane fade" id="pills-p2" role="tabpanel" aria-labelledby="pills-p2-tab">
				<!-- Block Header -->
				<h2>Something Else</h2>
				<?php echo reportHeader($latVal, $longVal); ?>
			</div>
		</div>
</div>
		<!-- Footer -->
		<?php include 'partials/_footer.php' ?>
</body>
</html>
