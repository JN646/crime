<?php
// Initialise the session
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
<body>
  <?php include $_SERVER["DOCUMENT_ROOT"] . '/crime/partials/_header.php' ?>
	<!-- Container -->
	<div id='bodyContainer' class="fluid-container">
		<div class="row col-md-12">
		<div class="col-md-2">
			<div class='col-md-12'>
				<!-- Side Bar -->
				<?php include $_SERVER["DOCUMENT_ROOT"] . '/crime/partials/_admin_sidebar.php' ?>
			</div>
		</div>
		<div class="col-md-10">
			<div class="row">
				<div class="col-md-12">

          <?php
          // Arrays
          $result = mysqli_query($mysqli, "SELECT DISTINCT `Month` FROM `data`");
          $mYears = array();
          $monthCount = 12;

          // Add months to
          if (mysqli_num_rows($result) > 0) {
              // output data of each row
              while($row = mysqli_fetch_assoc($result)) {
                $mYears[] = $row["Month"];
              }
          } else {
              echo "No Month Data";
          }

          sort($mYears); // Sort the date array.

          // Free Query
          mysqli_free_result($result);

          // Is the data missing?
          function isMissingIndicator($mysqli) {
            // Data missing
            if (true) {
              return "<i class='fas fa-exclamation' style='color: red'></i>";
            }

            // Data found
            if (false) {
              return "<i class='fas fa-check' style='color: green'></i>";
            }
          }
          ?>

					<!-- Status Block -->
					<?php if (isset($_SESSION['message'])): ?>
							<?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
              ?>
					<?php endif ?>

					<h2>Import Manager</h2>
					<p>This is the data import manager.</p>

          <!-- Table -->
          <table class='table table-bordered'>
            <thead>
              <tr>
                <th class='text-center'>Constabulary</th>
                <th class='text-center'>2015</th>
                <th class='text-center'>2016</th>
                <th class='text-center'>2017</th>
                <th class='text-center'>2018</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = "SELECT * FROM `data_constab`";
              $sqlR = mysqli_query($mysqli, $sql);
              $constab = array();

              // Constab to Array
              if (mysqli_num_rows($sqlR) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($sqlR)) {
                  $constab[] = $row["constab_name"];
                }
              }

              // for ($i=0; $i < count($constab); $i++) {
              //   echo $constab[$i] . "</br>";
              // }

              if (mysqli_num_rows($sqlR) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($sqlR)) {
                  for ($i=0; $i < count($constab); $i++) {
                    echo "<tr>";
                      echo "<td>" . $constab[$i] . "</td>";
                    ?>
                      <td class='text-center'>0 / <?php echo $monthCount ?></td>
                      <td class='text-center'>0 / <?php echo $monthCount ?></td>
                      <td class='text-center'>0 / <?php echo $monthCount ?></td>
                      <td class='text-center'>0 / <?php echo $monthCount ?></td>
                    <?php
                    echo "</tr>";
                  }
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
	<?php include $_SERVER["DOCUMENT_ROOT"] . '/crime/partials/_footer.php' ?>
</body>
</html>
