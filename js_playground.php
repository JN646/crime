<?php
	require_once 'config/config.php';
	
	class chartData
	{
		private $data; //master variable to return for JS
		private $type = "line";
		private $labels; //for the x axis
		private $datasets; //an array of some [ [label, [numbers, ...]], ... ]
		private $america = true;
		
		function addDataset($d, $l = NULL) {
			// Add a new line to the chart
			// Check the data is a single dimensional array?
			if(is_null($l)) {
				$l = '';
			}
			$this->datasets[] = ["label"=>$l, "data"=>$d];
		}
		
		function setLabels($l) {
			$this->labels = $l;
		}
		
		function setType($t) {
			$this->type = $t;
		}
		
		function updateData() {
			$this->$data = ['type'=>$this->type, 'data'=>['labels'=>$this->labels, 'datasets'=>$this->datasets]];
		}
		
		function getData() {
			$this->updateData();
			return $this->$data;
		}
		
		function screenDump() {
			$this->updateData();
			echo "TYPE: ".$this->$data['type']."<br>";
			
			echo "LABELS: ";
			foreach($this->$data['data']['labels'] as $l) {
				echo $l." ";
			}
			echo "<br>";
			
			echo "DATA: <br>";
			foreach($this->$data['data']['datasets'] as $d) {
				echo "-  ".$d['label'].": ";
				foreach($d['data'] as $n) {
					echo round($n)." ";
				}
				echo "<br>";
			}
		}
	}
	
	$xLabels = ["one", "two", "three", "four", "aubergine"];
	$d1 = [3,2,3,2,1];
	$d2 = [1,2,4,8,4];
	$d3 = [3,7,5,6,8];
	
	$d = new chartData();
	$d->setLabels($xLabels);
	$d->addDataset($d1, "Cars");
	$d->addDataset($d2, "Bikes");
	$d->addDataset($d3);
	$d->setType("pie");
	
	// This Structure now works being passed into JS through JSON. Now turn it into a class?
	//$data = [ "type"=>"line", "data"=>["labels"=>$labels, "datasets"=>[ ["label"=>"L1", "data"=>$d1], ["label"=>"L2", "data"=>$d2]] ] ];
	$data = $d->getData();
	
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8"/>
		<title>Playground!</title>
		<script src="js/Chart.min.js" charset="utf-8"></script>
	</head>
	<body>
		
		<canvas id="myChart"></canvas>
		
		<script type="text/javascript">
			
			// This works passed as a single object. Now try make it come to js from php like this!
			
			var myData = { 
				type:'line', 
				data:{
					labels:["one", "two", "three"], 
					datasets:[ {
						label:"L1", 
						data:[0,3,1]
					}, {
						label:"L2", 
						data:[1,0,2]
					} ] 
			} };
			console.log(myData)
			
			
			// Get array from PHP
			var myData = <?php echo json_encode($data); ?>;
			console.log(myData);
			
			var ctx = document.getElementById("myChart").getContext('2d');
			var lineChart = new Chart(ctx, myData);
		</script>
	</body>
</html>