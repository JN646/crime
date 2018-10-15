<?php
	// Put custom classes here
	
	
	// For making chart.js data objects
	class chartData
	{
		private $data; //master variable to return for JS
		private $type = "line";
		private $labels; //for the x axis
		private $datasets; //an array of some [ [label, [numbers, ...]], ... ]
		
		function addDataset($d, $l = NULL) {
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


?>