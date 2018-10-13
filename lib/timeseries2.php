<?php
	require_once '../config/config.php';
	
	
	$data = getTimeSeries($mysqli, 3391);
	
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8"/>
		<title>Time Series</title>
		<script src="../js/Chart.min.js" charset="utf-8"></script>
	</head>
	<body>
		
		<canvas id="myChart"></canvas>
		
		<script type="text/javascript">
			// Get arrays from PHP
			var myData = <?php echo json_encode($data); ?>;
			
			var ctx = document.getElementById("myChart").getContext('2d');
			var theChart = new Chart(ctx, {
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
						}, 	{
							label: myData.datasets.label[13], 
							data: myData.datasets.data['Theft from the person'],
							fill: false,
							borderColor: 'rgba(0, 0, 0, 0.5)'
						}
					]
        		}
			});
		</script>
		
		<div class='chart'>
			<div id="theChart"></div>
		</div>
	</body>
	
	<?php
		function getTimeSeries($mysqli, $bID)
		{
			// Returns the boxmonths for a given box ID, and +1 to requests
			$out = [ 'labels'=>[''], 'datasets'=>[
					'label'=>["Anti-social behaviour",
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
						"Theft from the person",
						"Theft from the person"
					], 'data'=>[]
				]
			];
			
			// Add 1 to Requests
			$addQ = "UPDATE box SET requests = requests + 1 WHERE `id` = $bID";
			$addR = mysqli_query($mysqli, $addQ);
			
			// Return Time Series
			$TSQ = "SELECT * FROM box_month WHERE `bm_boxid` = $bID";
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






