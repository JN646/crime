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
	$password = "";
	$email = "";
	$id = 0;
	$update = false;

	// Save
	if (isset($_POST['save'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$email = $_POST['email'];

		mysqli_query($myslqi, "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')");

		// If Error.
		if (!$result) {
			$_SESSION['message'] = "<div class='alert alert-danger'>User creation not implemented yet</div>";
			header('location: ../usermanager.php');
		} else {
			$_SESSION['message'] = "<div class='alert alert-success'>User saved!</div>";
			header('location: ../usermanager.php');
		}
	}

	// Update
	if (isset($_POST['update'])) {
		$id = $_POST['id'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$email = $_POST['email'];

	  $result =	mysqli_query($mysqli, "UPDATE users SET username='$username', password='$password', email='$email' WHERE id=$id");

		// If Error.
		if (!$result) {
			$_SESSION['message'] = "<div class='alert alert-danger'>User update failed!</div>";
			header('location: ../usermanager.php');
		} else {
			$_SESSION['message'] = "<div class='alert alert-success'>User updated!</div>";
			header('location: ../usermanager.php');
		}
	}

	// Delete Records
	if (isset($_GET['del'])) {
		$id = $_GET['del'];
		mysqli_query($mysqli, "DELETE FROM users WHERE id=$id");

		// If Error.
		if (!$result) {
			$_SESSION['message'] = "<div class='alert alert-danger'>User delete failed!</div>";
			header('location: ../usermanager.php');
		} else {
			$_SESSION['message'] = "<div class='alert alert-success'>User deleted!</div>";
			header('location: ../usermanager.php');
		}
	}

	// Get Results
	$results = mysqli_query($mysqli, "SELECT * FROM users");
?>
