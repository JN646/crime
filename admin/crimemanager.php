<?php
// User Server
include('lib/crimeserver.php');
    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $update = true;
        $record = mysqli_query($mysqli, "SELECT * FROM data WHERE id=$id");

        if (count($record) == 1) {
            $n = mysqli_fetch_array($record);
            $id = $n['id'];
            $lat = $n['Latitude'];
            $long = $n['Longitude'];
            $crime_type = $n['Crime_Type'];
            $falls_within = $n['Falls_Within'];
        }
    }
?>

<?php $results = mysqli_query($mysqli, "SELECT * FROM data LIMIT 25"); ?>
<!-- Header -->
<?php include '../partials/_header.php' ?>
<body>
	<!-- Container -->
	<div id='bodyContainer' class="container">
		<div class="row">
		<div class="col-md-3">
			<div class='col-md-12'>
				<!-- Side Bar -->
				<?php include '../partials/_admin_sidebar.php' ?>
			</div>
		</div>
		<div class="col-md-9">
			<div class="row">
				<div class="col-md-12">

					<!-- Status Block -->
					<?php if (isset($_SESSION['message'])): ?>
							<?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                      ?>
					<?php endif ?>

					<h2>Crime Manager</h2>
					<p>Manage crimes on this system.</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
          <!-- Create Update Block -->
					<form class='border col-md-12' method="post" action="lib/crimeserver.php" >
						<div class='form-group'>
							<input type="hidden" name="id" value="<?php echo $id; ?>">
						</div>

							<!-- Username -->
              <div class="row">
                <div class="col-md-4 form-group">
                  <label class=''>Latitude</label>
                  <input class='form-control' type="text" name="Latitude" value="<?php echo $lat; ?>">
                </div>

                <div class="col-md-4 form-group">
                  <label class=''>Longitude</label>
                  <input class='form-control' type="text" name="Longitude" value="<?php echo $long; ?>">
                </div>

                <div class="col-md-4 form-group">
                  <label class=''>Crime Type</label>
                  <input class='form-control' type="text" name="Crime_Type" value="<?php echo $crime_type; ?>">
                </div>
              </div>

              <div class="row">
                <div class="col-md-4 form-group">
                  <label class=''>Falls Within</label>
                  <input class='form-control' type="text" name="Falls_Within" value="<?php echo $falls_within; ?>">
                </div>
              </div>

      					<!-- Function Buttons -->
      					<div class="form-group">
      						<?php if ($update == true): ?>
      							<button class="btn btn-success" type="submit" name="update">Update</button>
      						<?php else: ?>
      							<button class="btn btn-success" type="submit" name="save">Save</button>
      						<?php endif ?>
      					</div>
					    </div>
					</form>
        </div>

        <br>

				<!-- Display data -->
        <div class="row">
          <div class="col-md-12">
            <table class='table table-bordered'>
              <thead>
                <tr>
                  <th class='text-center'>#</th>
                  <th class='text-center'>Crime Type</th>
                  <th class='text-center'>Latitude</th>
                  <th class='text-center'>Longitude</th>
                  <th class='text-center'>Falls Within</th>
                  <th class='text-center' colspan="2">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = mysqli_fetch_array($results)) {
                          ?>
                  <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['Crime_Type']; ?></td>
                    <td><?php echo $row['Latitude']; ?></td>
                    <td><?php echo $row['Longitude']; ?></td>
                    <td><?php echo $row['Falls_Within']; ?></td>
                    <td class='text-center'>
                      <a href="crimemanager.php?edit=<?php echo $row['id']; ?>" class="btn btn-link" ><i class="far fa-edit"></i></a>
                    </td>
                    <td class='text-center'>
                      <a href="lib/crimeserver.php?del=<?php echo $row['id']; ?>" class="btn btn-link"><i class="far fa-trash-alt"></i></a>
                    </td>
                  </tr>
                <?php
                      } ?>
              </tbody>
            </table>
          </div>
			  </div>
			</div>
		</div>
	</div>
	<!-- Footer -->
	<?php include '../partials/_footer.php' ?>
</body>
</html>
