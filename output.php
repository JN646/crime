<!-- Header Form -->
<?php include_once 'partials/_header.php'; ?>
<script src="<?php echo $environment; ?>js/Chart.min.js" charset="utf-8"></script>

<!-- Include Reporting Options -->
<?php include_once 'lib/crimecount.php'; ?>
<?php include_once 'lib/timeseries2.php'; ?>
<?php include_once 'lib/Compare.php'; ?>

<?php
//############## SERVER FILE ###################################################
//############## CHECK VALUES ##################################################
if(isset($_POST['btnQuickGPS'])) {
	echo "Quick GPS Button";

	$latVal = $_GET["lat"];
	$longVal = $_GET["long"];
}
?>

	<!-- Container -->
	<div id='bodyContainer' class="container">

		<?php
			if(isset($_GET['btnSearch'])) {
				// Missing Value Check
				if (!empty($_GET["long"]) || !empty($_GET["lat"]) || !empty($_POST["rad1"]) || !empty($_POST["rad2"]) || !empty($_POST["month"])) {
						$latVal = trim((float)$_GET["lat"]);
						$longVal = trim((float)$_GET["long"]);
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
			}
		?>

		<?php if ($app_enabled == TRUE): ?>
			<!-- Nav Pills -->
			<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

				<!-- Crime Counter -->
				<?php
				if ($app_crimecounter == TRUE) {
				?>
					<li class="nav-item">
						<a class="nav-link active" id="pills-crimecounter-tab" data-toggle="pill" href="#pills-crimecounter" role="tab" aria-controls="pills-crimecount" aria-selected="true">Crime Counter</a>
					</li>
				<?php
				}
				?>

				<!-- Time Series Chart -->
				<?php
				if ($app_timeseries == TRUE) {
				?>
					<li class="nav-item">
						<a class="nav-link" id="pills-timeseries-tab" data-toggle="pill" href="#pills-timeseries" role="tab" aria-controls="pills-timeseries" aria-selected="false">Time Series</a>
					</li>
				<?php
				}
				?>

				<!-- Compare Areas -->
				<?php
				if ($app_compare == TRUE) {
				?>
					<li class="nav-item">
						<a class="nav-link" id="pills-compare-tab" data-toggle="pill" href="#pills-compare" role="tab" aria-controls="pills-compare" aria-selected="false">Compare</a>
					</li>
				<?php
				}
				?>

				<!-- Something Else -->
				<?php
				if ($app_something == TRUE) {
				?>
					<li class="nav-item">
						<a class="nav-link" id="pills-p2-tab" data-toggle="pill" href="#pills-p2" role="tab" aria-controls="pills-p2" aria-selected="false">Panel 4</a>
					</li>
				<?php
				}
				?>
			</ul>
			<div class="tab-content" id="pills-tabContent">

				<!-- Crime Counter -->
				<?php
				if ($app_crimecounter == TRUE) {
				?>
					<div class="tab-pane fade show active" id="pills-crimecounter" role="tabpanel" aria-labelledby="pills-crimecounter-tab">
						<!-- Block Header -->
						<h2>Crime Counter</h2>
						<p>The chart below shows your current risk level of each specific crime group based on the location you have provided. The higher the risk factor the higher the probability of being exposed to crime.</p>
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

							// Draw Chart
							if (document.getElementById("crimeCountChart")) {
								var ctx = document.getElementById("crimeCountChart").getContext('2d');
								var ccChart = new Chart(ctx, ccData);
							} else {
								console.log('ERROR: crimeCountChart not found.');
							}
						</script>
					</div>
				<?php
				}
				?>

				<!-- Time Series Chart -->
				<?php
				if ($app_timeseries == TRUE) {
				?>
					<div class="tab-pane fade" id="pills-timeseries" role="tabpanel" aria-labelledby="pills-timeseries-tab">
						<!-- Block Header -->
						<h2>Time Series Chart</h2>
						<p>The chart below shows how the levels of specific crime times have changed over time.</p>
						<?php
							// Report Header
							echo reportHeader($latVal, $longVal);

							// Get Time Series
							$timeSeriesData = timeSeriesRequest($latVal, $longVal);

							// If NULL
							if(is_null($timeSeriesData)) {
								echo "<p class='alert alert-danger text-center'>ChartData class has no datasets assigned, therefore returned NULL.</p>";
							}
						?>
						<canvas id="timeSeriesChart"></canvas>
						<script type="text/javascript">
							// Get array from PHP
							var TSData = <?php echo json_encode($timeSeriesData); ?>;

							// Draw Chart
							if (document.getElementById("crimeCountChart")) {
								var ctx = document.getElementById("timeSeriesChart").getContext('2d');
								var tsChart = new Chart(ctx, TSData);
							} else {
								console.log('ERROR: crimeCountChart not found.');
							}
						</script>
					</div>
				<?php
				}
				?>

				<!-- Compare Area -->
				<?php
				if ($app_compare == TRUE) {
				?>
					<div class="tab-pane fade" id="pills-compare" role="tabpanel" aria-labelledby="pills-compare-tab">
						<!-- Block Header -->
						<h2>Go Compare</h2>
						<p>This chart shows how crime in your area compares to another location.</p>
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

							var ctx = document.getElementById("compareChart").getContext('2d');
							var cChart = new Chart(ctx, cData);
						</script>
					</div>
				<?php
				}
				?>

				<!-- Something Else -->
				<?php
				if ($app_something == TRUE) {
				?>
					<div class="tab-pane fade" id="pills-p2" role="tabpanel" aria-labelledby="pills-p2-tab">
						<!-- Block Header -->
						<h2>Something Else</h2>
						<?php echo reportHeader($latVal, $longVal); ?>
					</div>
				<?php
				}
				?>
			</div>
		<?php endif; ?>

	</div>
	<!-- Footer -->
	<?php include 'partials/_footer.php' ?>
</body>
</html>
