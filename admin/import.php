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
  <?php include '../partials/_header.php' ?>
	<!-- Container -->
	<div id='bodyContainer' class="fluid-container">
		<div class="row col-md-12">
		<div class="col-md-2">
			<div class='col-md-12'>
				<!-- Side Bar -->
				<?php include '../partials/_admin_sidebar.php' ?>
			</div>
		</div>
		<div class="col-md-10">
			<div class="row">
				<div class="col-md-12">

          <?php
          // Arrays
          $sql = "SELECT DISTINCT Month FROM data";
          $result = mysqli_query($mysqli, $sql);

          $mYears = array();

          if (mysqli_num_rows($result) > 0) {
              // output data of each row
              while($row = mysqli_fetch_assoc($result)) {
                $mYears[] = $row["Month"];
              }
          } else {
              echo "No Month Data";
          }

          sort($mYears);

          // Free Query
          mysqli_free_result($result);

          // Is the data missing?
          function isMissingIndicator() {
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

          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link" id="y2015-tab" data-toggle="tab" href="#y2015" role="tab" aria-controls="y2015" aria-selected="false">2015</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="y2016-tab" data-toggle="tab" href="#y2016" role="tab" aria-controls="y2016" aria-selected="false">2016</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="y2017-tab" data-toggle="tab" href="#y2017" role="tab" aria-controls="y2017" aria-selected="false">2017</a>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="y2015" role="tabpanel" aria-labelledby="y2015-tab">
              <!-- 2015 -->
              <table class='table table-bordered'>
                <thead>
                  <tr>
                    <th class='text-center'>Forces</th>
                    <?php
                    for ($i=0; $i < count($mYears); $i++) {
                      if (strpos($mYears[$i], '2015') !== false) {
                        echo "<th class='text-center'>" . $mYears[$i] . "</th>";
                      }
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
                        if (strpos($mYears[$i], '2015') !== false) {
                          echo "<td class='text-center'>" . isMissingIndicator() . "</td>";
                        }
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
            <div class="tab-pane fade" id="y2016" role="tabpanel" aria-labelledby="y2016-tab">
              <!-- 2016 -->
              <table class='table table-bordered'>
                <thead>
                  <tr>
                    <th class='text-center'>Forces</th>
                    <?php
                    for ($i=0; $i < count($mYears); $i++) {
                      if (strpos($mYears[$i], '2016') !== false) {
                        echo "<th class='text-center'>" . $mYears[$i] . "</th>";
                      }
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
                      // Get the correct year.
                      for ($i=0; $i < count($mYears); $i++) {
                        if (strpos($mYears[$i], '2016') !== false) {
                          echo "<td class='text-center'>" . isMissingIndicator() . "</td>";
                        }
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
            <div class="tab-pane fade" id="y2017" role="tabpanel" aria-labelledby="y2017-tab">
              <!-- 2017 -->
              <table class='table table-bordered'>
                <thead>
                  <tr>
                    <th class='text-center'>Forces</th>
                    <?php
                    // Get the correct year.
                    for ($i=0; $i < count($mYears); $i++) {
                      if (strpos($mYears[$i], '2017') !== false) {
                        echo "<th class='text-center'>" . $mYears[$i] . "</th>";
                      }
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
                      // Get the correct year.
                      for ($i=0; $i < count($mYears); $i++) {
                        if (strpos($mYears[$i], '2017') !== false) {
                          echo "<td class='text-center'>" . isMissingIndicator() . "</td>";
                        }
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
	</div>
</div>
	<!-- Footer -->
	<?php include '../partials/_footer.php' ?>
</body>
</html>
