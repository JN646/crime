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

          <table class='table table-bordered'>
            <thead>
              <tr>
                <th class='text-center'>Forces</th>
                <?php
                $mYears = array('2015-08',
                '2015-09',
                '2015-10',
                '2015-11',
                '2015-12',
                '2016-01',
                '2016-02',
                '2016-03',
                '2016-04',
                '2016-05',
                '2016-06',
                '2016-07',
                '2016-08',
                '2016-09',
                '2016-10',
                '2016-11',
                '2016-12',
                '2017-01',
                '2017-02',
                '2017-03',
                '2017-04',
                '2017-05',
                '2017-06',
                '2017-07',
                '2017-08',
                '2017-09',
                '2017-10',
                '2017-11',
                '2017-12');

                for ($i=0; $i < count($mYears); $i++) {
                  echo "<th class='text-center'>" . $mYears[$i] . "</th>";
                }
                ?>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = "SELECT * FROM data_constab";
              $sqlR = mysqli_query($mysqli, $sql);

              // If Error
              if (!$sqlR) {
                die('<p class="SQLError">Could not run query: ' . mysqli_error($mysqli) . '</p>');
              }

              if (mysqli_num_rows($sqlR) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($sqlR)) {
                  ?>
                <tr>
                  <td><?php echo $row['constab_name'] ?></td>
                  <?php
                  for ($i=0; $i < count($mYears); $i++) {
                    echo "<td class='text-center'>M</td>";
                  }
                  ?>
                </tr>
                  <?php
                }
              } else {
                  echo "0 results";
              }
              ?>
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
