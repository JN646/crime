<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../users/login.php");
    exit;
}

// Check if the user is an admin.
if($_SESSION["admin"] !== 1){
    header("location: ../users/login.php");
}
?>
<!-- Header -->
<?php include '../partials/_header.php' ?>
<body>
	<!-- Container -->
	<div id='bodyContainer' class="fluid-container">
		<div class="row">
		<div class="col-md-2">
			<div class='col-md-12'>
				<!-- Side Bar -->
				<?php include '../partials/_admin_sidebar.php' ?>
			</div>
		</div>
		<div class="col-md-10">
			<div class="row">
				<div class="col-md-12">

					<!-- Status Block -->
					<?php if (isset($_SESSION['message'])): ?>
							<?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                      ?>
					<?php endif ?>

					<h2>Import Manager</h2>
					<p>This is the data import manager.</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">

        </div>
			</div>
		</div>
	</div>
</div>
	<!-- Footer -->
	<?php include '../partials/_footer.php' ?>
</body>
</html>
