<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . "/crime/config/config.php");

	// Start Session
	session_start();

	// Check if the user is logged in, if not then redirect to login page
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	    header("location: ../data/login.php");
	    exit;
	}

	// Initialise variables
	$lat = "";
	$long = "";
	$crime_type = "";
	$falls_within = "";
	$month = "";
	$id = 0;
	$update = false;

	// Save
	if (isset($_POST['save'])) {
		$lat = $_POST['Latitude'];
		$long = $_POST['Longitude'];
		$crime_type = $_POST['Crime_Type'];
		$falls_within = $_POST['Falls_Within'];
		$month = $_POST['Month'];

		mysqli_query($myslqi, "INSERT INTO data (Latitude, Longitude, Crime_Type, Falls_Within, Month) VALUES ('$lat', '$long', '$crime_type', '$falls_within', '$month')");

		// If Error.
		if (!$result) {
			$_SESSION['message'] = "<div class='alert alert-danger'>Crime creation not implemented yet</div>";
			header('location: ../crimemanager.php');
		} else {
			$_SESSION['message'] = "<div class='alert alert-success'>Crime saved!</div>";
			header('location: ../crimemanager.php');
		}
	}

	// Update
	if (isset($_POST['update'])) {
		$id = $_POST['id'];
		$lat = $_POST['Latitude'];
		$long = $_POST['Longitude'];
		$crime_type = $_POST['Crime_Type'];
		$falls_within = $_POST['Falls_Within'];
		$month = $_POST['Month'];

	  $result =	mysqli_query($mysqli, "UPDATE data SET Latitude='$lat', Longitude='$long', Crime_Type='$crime_type', Falls_Within='$falls_within', Month='$month' WHERE id=$id");

		// If Error.
		if (!$result) {
			$_SESSION['message'] = "<div class='alert alert-danger'>Crime update failed!</div>";
			header('location: ../crimemanager.php');
		} else {
			$_SESSION['message'] = "<div class='alert alert-success'>Crime updated!</div>";
			header('location: ../crimemanager.php');
		}
	}

	// Delete Records
	if (isset($_GET['del'])) {
		$id = $_GET['del'];
		mysqli_query($mysqli, "DELETE FROM data WHERE id=$id");

		// If Error.
		if (!$result) {
			$_SESSION['message'] = "<div class='alert alert-danger'>Crime delete failed!</div>";
			header('location: ../crimemanager.php');
		} else {
			$_SESSION['message'] = "<div class='alert alert-success'>Crime deleted!</div>";
			header('location: ../crimemanager.php');
		}
	}

	// Get Results
	$results = mysqli_query($mysqli, "SELECT * FROM data LIMIT 25");
?>
