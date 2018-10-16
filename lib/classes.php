<?php
	
	// Put custom classes in here
	
	
	// For making chart.js data objects
	class ChartData
	{
		private $data; //master variable to return for JS
		public $type = "line";
		public $labels; //for the x axis
		private $datasets; //an array of some [ [label, [numbers, ...]], ... ]
		public $legend = true;
		public $toolTips = false;
		public $autoSkipX = false;
		
		function addDataset($d, $l = NULL, $c = 'rgba(0,0,0,0.1)') {
			// Check the data is a single dimensional array?
			if(is_null($l)) {
				$l = '';
			}
			$this->datasets[] = ["label"=>$l, "data"=>$d, "backgroundColor"=>$c];
		}
		
		function updateData() {
			$this->$data = [
				'type'=>$this->type,
				'data'=>[
					'labels'=>$this->labels,
					'datasets'=>$this->datasets
				],
				'options'=>[
					'legend'=>[
						'display'=>$this->legend
					],
					'tooltips'=>[
						'enabled'=>$this->toolTips
					],
					'scales'=>[
						'xAxes'=>[[
							'stacked'=>false,
							'beginAtZero'=>true,
							'scaleLabel'=>[
 								'labelString'=>'X AXIS LABEL' //doesn't seem to work
							],
							'ticks'=>[
								'stepSize'=>1,
								'min'=>0,
								'autoSkip'=>$this->autoSkipX //this is important
							]
						]],
						'yAxis'=>[[
							
						]]
					]
				]
			];
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