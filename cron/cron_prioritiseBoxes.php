<?php
	// Add Database Connection
	require_once '../config/config.php';
	require_once '../lib/functions.php';
	
	echo "top<br>";
	
	$countQ = "SELECT COUNT(id) FROM `box`";
	$countR = mysqli_fetch_assoc(mysqli_query($mysqli, $countQ));
	$N = $countR['COUNT(id)'];
	echo "N: " . $N . "<br>";
	$n = 0;
	
	echo "loop<br>";
	while($n < $N) {
		echo $n . ": ";
		$boxQ = "SELECT * FROM `box` WHERE `id` = $n";
		$boxR = mysqli_fetch_assoc(mysqli_query($mysqli, $boxQ));
		$bID = $boxR['id'];
		if($boxR['active']) { //if box is active
			$priority = 0;
			echo "prority " . $priority . "<br>";
			$sqlUpdate = "UPDATE `box` SET priority = $priority, priority_updated = NOW() WHERE `id` = $bID";
			$updateResult = mysqli_fetch_assoc(mysqli_query($mysqli, $sqlUpdate));
		} else {
			echo "not active<br>";
		}
		
		
		$n++;
	}
	echo "end<br>";

?>