<?php
	require_once '../config/config.php';
	
	
	$now = "'".date("Y-m")."'";
	// ($mysqli, [box-id], [month-start], [month-end])
	$data = getTimeSeries($mysqli, 3391, NULL, $now);
	
	
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8"/>
		<title>Time Series</title>
		<script src="../js/Chart.min.js" charset="utf-8"></script>
	</head>
	<body>
		
		<canvas id="lineChart"></canvas>
		
		<script type="text/javascript">
			// Get array from PHP
			var myData = <?php echo json_encode($data); ?>;
			
			console.log(myData);
			
			var ctxL = document.getElementById("lineChart").getContext('2d');
			var lineChart = new Chart(ctxL, {
				type: 'line',
				data: {
					labels: myData.labels,
					datasets: [
						{
							label: myData.datasets.label[0],
							data: myData.datasets.data['Anti-social behaviour'],
							fill: false,
							borderColor: 'rgba(255, 0, 0, 0.5)'
						}, {
							label: myData.datasets.label[1], 
							data: myData.datasets.data['Burglary'],
							fill: false,
							borderColor: 'rgba(0, 255, 0, 0.5)'
						}, {
							label: myData.datasets.label[2], 
							data: myData.datasets.data['Other theft'],
							fill: false,
							borderColor: 'rgba(0, 0, 255, 0.5)'
						}, {
							label: myData.datasets.label[3], 
							data: myData.datasets.data['Public order'],
							fill: false,
							borderColor: 'rgba(255, 255, 0, 0.5)'
						}, {
							label: myData.datasets.label[4], 
							data: myData.datasets.data['Violence and sexual offences'],
							fill: false,
							borderColor: 'rgba(255, 0, 255, 0.5)'
						}, {
							label: myData.datasets.label[5], 
							data: myData.datasets.data['Vehicle crime'],
							fill: false,
							borderColor: 'rgba(0, 255, 255, 0.5)'
						}, {
							label: myData.datasets.label[6], 
							data: myData.datasets.data['Criminal damage and arson'],
							fill: false,
							borderColor: 'rgba(0, 0, 0, 0.5)'
						}, {
							label: myData.datasets.label[7], 
							data: myData.datasets.data['Other crime'],
							fill: false,
							borderColor: 'rgba(255, 0, 0, 0.5)'
						}, {
							label: myData.datasets.label[8], 
							data: myData.datasets.data['Robbery'],
							fill: false,
							borderColor: 'rgba(0, 255, 0, 0.5)'
						}, {
							label: myData.datasets.label[9], 
							data: myData.datasets.data['Bicycle theft'],
							fill: false,
							borderColor: 'rgba(0, 0, 255, 0.5)'
						}, {
							label: myData.datasets.label[10], 
							data: myData.datasets.data['Drugs'],
							fill: false,
							borderColor: 'rgba(255, 255, 0, 0.5)'
						}, {
							label: myData.datasets.label[11], 
							data: myData.datasets.data['Shoplifting'],
							fill: false,
							borderColor: 'rgba(255, 0, 255, 0.5)'
						}, {
							label: myData.datasets.label[12], 
							data: myData.datasets.data['Theft from the person'],
							fill: false,
							borderColor: 'rgba(0, 255, 255, 0.5)'
						}
					]
        		}
			});
		</script>
	</body>
	
	<?php
		function getTimeSeries($mysqli, $bID, $mStart = NULL, $mEnd = NULL)
		{
			// Error Check Start and End
			if(!is_null($mStart) && !is_null($mEnd) && $mStart>=$mEnd) {
				//could just swap them around if not equal?
				echo "Start date cannot be after or the same as end date<br>";
				return 0;
			}
			
			// Returns the boxmonths for a given box ID, and +1 to requests
			$out = [ 'labels'=>[], 'datasets'=>[
					'label'=>[
						//this array can be passed to the function as a variable to select what is returned
						"Anti-social behaviour",
						"Burglary",
						"Other theft",
						"Public order",
						"Violence and sexual offences",
						"Vehicle crime",
						"Criminal damage and arson",
						"Other crime",
						"Robbery",
						"Bicycle theft",
						"Drugs",
						"Shoplifting",
						"Theft from the person"
					], 'data'=>[]
				]
			];
			
			// Add 1 to Requests
			$addQ = "UPDATE `box` SET `requests` = `requests` + 1 WHERE `id` = $bID";
			$addR = mysqli_query($mysqli, $addQ);
			
			// Build a Smart Query
			$TSQ = "SELECT * FROM `box_month` WHERE `bm_boxid` = $bID";
			if(!is_null($mStart)) {
				$TSQ = $TSQ." AND `bm_month` > $mStart";
			}
			if(!is_null($mEnd)) {
				$TSQ = $TSQ." AND `bm_month` <= $mEnd";
			}
			
			// Return Time Series
			$TSR = mysqli_query($mysqli, $TSQ);
			
			while($row = mysqli_fetch_assoc($TSR)) {
				$out['labels'][] = $row['bm_month'];
				//echo $row['bm_month']."<br>";
				foreach(array_keys($row) as $name) {
					$out['datasets']['data'][$name][] = $row[$name];
				}
			}
			var_dump();
			return $out;
		}
	?>
</html>






