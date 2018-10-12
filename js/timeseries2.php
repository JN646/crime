<html>
<head>
	<meta charset="utf-8"/>
	<script src="Chart.min.js"></script>
</head>
<body>
	<?php
		$data = array(1,5,6,2,4);
		echo "foo";
	?>
	
	<canvas id="theChart" width="400" height="400"></canvas>
	
	<script>
		var myData = "<?php echo json_encode($data) ?>"; //this gets the array from php
		
		//this doens't seem to do anything
		var ctx = "myChart";
		var myLineChart = new Chart(ctx, {
			type: 'line',
			data: myData
		});
	</script>
	
	<div class='chart'>
		<div id="theChart"></div>
	</div>
	
	<?php
		echo "bar";
	?>
</body>
</html>