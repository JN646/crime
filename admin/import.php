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
          <div class="row">

            <!-- Block 1 -->
            <div class="col-md-6">
              <div class="col-md-12 border">
                <h3>Import</h3>
                <form class="" action="#" method="post">
                  <div class="form-group">
                    <label for="">File importer</label>
                    <br>
                    <select class="form-control" name="fileFormat">
                      <option value="csv">.csv</option>
                    </select>
                    <br>
                    <button class="btn btn-primary" type="button" name="browseFile">Browse</button>
                  </div>
                </form>
              </div>
            </div>

            <!-- Block 2 -->
            <div class="col-md-6">
              <div class="col-md-12 border">
                <h3>Config.</h3>
              </div>
            </div>
          </div>

          <br>

				</div>
			</div>

      <!-- Import Log -->
			<div class="row">
        <div class="col-md-12">
          <div class="col-md-12 border">
            <h3>Import Log</h3>
            <table class='table table-bordered'>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Imported File</th>
                  <th>Date</th>
                  <th>Upload Date</th>
                  <th colspan="2">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Bedford_March_2015.csv</td>
                  <td>2015-03</td>
                  <td>10/10/2018 21:32</td>
                  <td><a href='#'>View</a></td>
                  <td><a href='#'>Unport</a></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
			</div>
		</div>
	</div>
</div>
	<!-- Footer -->
	<?php include '../partials/_footer.php' ?>
</body>
</html>
