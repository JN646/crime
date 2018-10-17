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

// Crime Server
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
            $month = $n['Month'];
        }
    }
?>

<?php $results = mysqli_query($mysqli, "SELECT * FROM data LIMIT 25"); ?>
<!-- Header -->
<?php include '../partials/_header.php' ?>
<body>
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

					<!-- Status Block -->
					<?php if (isset($_SESSION['message'])): ?>
							<?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                      ?>
					<?php endif ?>

					<h2>Crime Manager</h2>
					<p>Manage crimes on this system. This feature is only partially implemented. Need AJAX Implementation for Modals to work.</p>
				</div>
			</div>
      <!-- Row 1 -->
			<div class="row">
				<div class="col-md-12">

				<!-- Display data -->
        <div class="row">
          <div class="col-md-12">

            <div class="accordion" id="accordionExample">
              <div class="card">
                <div class="card-header" id="headingOne">
                  <h5 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      Create/Edit
                    </button>
                  </h5>
                </div>

                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                  <div class="card-body">
                    <form class='col-md-12' method="post" action="lib/crimeserver.php" >
          						<div class='form-group'>
          							<input type="hidden" name="id" value="<?php echo $id; ?>">
          						</div>

          							<!-- Latitude -->
                        <div class="row">
                          <div class="col-md-2 form-group">
                            <label class=''>Latitude</label>
                            <input class='form-control' type="text" name="Latitude" value="<?php echo $lat; ?>">
                          </div>

                          <!-- Longitude -->
                          <div class="col-md-2 form-group">
                            <label class=''>Longitude</label>
                            <input class='form-control' type="text" name="Longitude" value="<?php echo $long; ?>">
                          </div>

                          <!-- Crime Type -->
                          <div class="col-md-4 form-group">
                            <label class=''>Crime Type</label>
                            <input class='form-control' type="text" name="Crime_Type" value="<?php echo $crime_type; ?>">
                          </div>

                          <!-- Falls Within -->
                          <div class="col-md-4 form-group">
                            <label class=''>Falls Within</label>
                            <input class='form-control' type="text" name="Falls_Within" value="<?php echo $falls_within; ?>">
                          </div>
                        </div>

                        <!-- Row 2 -->
                        <div class="row">

                          <!-- Date -->
                          <div class="col-md-2 form-group">
                            <label class=''>Date</label>
                            <input class='form-control' type="text" name="Month" value="<?php echo $month; ?>">
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
          					</form>
                  </div>
                </div>
              </div>
            </div>

            <br>

            <table class='table table-bordered table-sm'>
              <?php
              // find out how many rows are in the table
              $sql = "SELECT COUNT(*) FROM data";
              $result = mysqli_query($mysqli, $sql) or trigger_error("SQL", E_USER_ERROR);
              $r = mysqli_fetch_row($result);
              $numrows = $r[0];

              // number of rows to show per page
              $rowsperpage = 20;
              // find out total pages
              $totalpages = ceil($numrows / $rowsperpage);

              // get the current page or set a default
              if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
                 // cast var as int
                 $currentpage = (int) $_GET['currentpage'];
              } else {
                 // default page num
                 $currentpage = 1;
              } // end if

              // if current page is greater than total pages...
              if ($currentpage > $totalpages) {
                 // set current page to last page
                 $currentpage = $totalpages;
              } // end if
              // if current page is less than first page...
              if ($currentpage < 1) {
                 // set current page to first page
                 $currentpage = 1;
              } // end if

              // the offset of the list, based on current page
              $offset = ($currentpage - 1) * $rowsperpage;

              // get the info from the db
              $sql = "SELECT `id`, `Latitude`, `Longitude`, `Crime_Type`, `Falls_Within` FROM `data` LIMIT $offset, $rowsperpage";
              $result = mysqli_query($mysqli, $sql) or trigger_error("SQL", E_USER_ERROR);

              ?>
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
                <?php
              // while there are rows to be fetched...
              while ($row = mysqli_fetch_assoc($result)) {
                 ?>
                 <tr>
                   <td class='text-center'><?php echo $row['id']; ?></td>
                   <td><?php echo $row['Crime_Type']; ?></td>
                   <td><?php echo $row['Latitude']; ?></td>
                   <td><?php echo $row['Longitude']; ?></td>
                   <td><?php echo $row['Falls_Within']; ?></td>
                   <td class='text-center'>
                     <a href="crimemanager.php?edit=<?php echo $row['id']; ?>" data-toggle="" data-target="" class="btn btn-link"><i class="far fa-edit"></i></a>
                   </td>
                   <td class='text-center'>
                     <a href="lib/crimeserver.php?del=<?php echo $row['id']; ?>" class="btn btn-link"><i class="far fa-trash-alt"></i></a>
                   </td>
                 </tr>
                 <?php
              } // end while

              /******  build the pagination links ******/
              echo '<nav aria-label="Page navigation"><ul class="pagination pagination-sm justify-content-center">';
              // range of num links to show
              $range = 3;

              // if not on page 1, don't show back links
              if ($currentpage > 1) {
                 // show << link to go back to page 1
                 echo " <li class='page-item'><a class='page-link' href='{$_SERVER['PHP_SELF']}?currentpage=1'><<</a></li> ";
                 // get previous page num
                 $prevpage = $currentpage - 1;
                 // show < link to go back to 1 page
                 echo " <li class='page-item'><a class='page-link' href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'><</a></li> ";
              } // end if

              // loop to show links to range of pages around current page
              for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
                 // if it's a valid page number...
                 if (($x > 0) && ($x <= $totalpages)) {
                    // if we're on current page...
                    if ($x == $currentpage) {
                       // 'highlight' it but don't make a link
                       echo " <li class='page-item active'><span class='page-link'> $x </span></li> ";
                    // if not current page...
                    } else {
                       // make it a link
                       echo " <li class='page-item'><a class='page-link' href='{$_SERVER['PHP_SELF']}?currentpage=$x'>$x</a></li> ";
                    } // end else
                 } // end if
              } // end for

              // if not on last page, show forward and last page links
              if ($currentpage != $totalpages) {
                 // get next page
                 $nextpage = $currentpage + 1;
                  // echo forward link for next page
                 echo " <li class='page-item'><a class='page-link' href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage'>></a></li> ";
                 // echo forward link for lastpage
                 echo " <li class='page-item'><a class='page-link' href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages'>>></a></li> ";
              } // end if
              /****** end build pagination links ******/
              echo "</ul></nav>";
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
