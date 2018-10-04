<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . "/crime/config/config.php");

	// Start Session
	session_start();

	// Check if the user is logged in, if not then redirect to login page
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	    header("location: ../users/login.php");
	    exit;
	}

	// Initialise variables
	$username = "";
	$email = "";
	$id = 0;
	$update = false;

	// Save
	if (isset($_POST['save'])) {
		$username = $_POST['username'];
		$email = $_POST['email'];

		mysqli_query($myslqi, "INSERT INTO users (username, email) VALUES ('$username', '$email')");
		$_SESSION['message'] = "User saved";
		header('location: ../usermanager.php');
	}

	// Update
	if (isset($_POST['update'])) {
		$id = $_POST['id'];
		$username = $_POST['username'];
		$email = $_POST['email'];

	  $result =	mysqli_query($mysqli, "UPDATE users SET username='$username', email='$email' WHERE id=$id");

		// If Error.
		if (!$result) {
			echo "User failed! " . mysqli_error($mysqli);
		} else {
			$_SESSION['message'] = "User updated!";
			header('location: ../usermanager.php');
		}
	}

	// Delete Records
	if (isset($_GET['del'])) {
		$id = $_GET['del'];
		mysqli_query($mysqli, "DELETE FROM users WHERE id=$id");
		$_SESSION['message'] = "User deleted!";
		header('location: ../usermanager.php');
	}

	// Get Results
	$results = mysqli_query($mysqli, "SELECT * FROM users");
?>
