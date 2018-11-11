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

// User Server
include('lib/userserver.php');
  if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $record = mysqli_query($mysqli, "SELECT * FROM users WHERE id=$id");

    if (count($record) == 1) {
      $n = mysqli_fetch_array($record);
      $username = $n['username'];
      $password = $n['password'];
      $email = $n['email'];
    }
  }
?>

<?php $results = mysqli_query($mysqli, "SELECT * FROM users"); ?>
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

					<h2>User Manager</h2>
					<p>Manage user accounts on this system.</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
          <!-- Create Update Block -->
					<form class='border col-md-12' method="post" action="lib/userserver.php" >
						<div class='form-group'>
							<input type="hidden" name="id" value="<?php echo $id; ?>">
						</div>

							<!-- Username -->
              <div class="row">
                <div class="col-md-4 form-group">
                  <label class=''>Username</label>
                  <input class='form-control' type="text" name="username" value="<?php echo $username; ?>">
                </div>

                <!-- Password -->
                <div class="col-md-4 form-group">
                  <label class=''>Password</label>
                  <input class='form-control' type="password" name="password" value="<?php echo $password; ?>">
                </div>

                <!-- Email -->
                <div class="col-md-4 form-group">
                  <label class=''>Email</label>
                  <input class='form-control' type="text" id='email' name="email" value="<?php echo $email; ?>">
                </div>
              </div>

							<!-- Function Buttons -->
							<div class="form-group">
								<?php if ($update == true): ?>
									<button class="btn btn-success" type="submit" name="update" id='validate'>Update</button>
								<?php else: ?>
									<button class="btn btn-success" type="submit" name="save" id='validate'>Save</button>
								<?php endif ?>
							</div>

						</div>
					</form>
        </div>

        <br>

				<!-- Display Users -->
        <div class="row">
          <div class="col-md-12">
            <table class='table table-bordered'>
              <thead>
                <tr>
                  <th class='text-center'>Username</th>
                  <th class='text-center'>Password</th>
                  <th class='text-center'>Email</th>
                  <th class='text-center' colspan="2">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
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

                while ($row = mysqli_fetch_array($results)) {
                ?>
                  <tr>
                    <td><?php echo $row['username']; ?></td>
                    <td class='text-center'><i class="fas fa-key" title="<?php echo $row['password']; ?>"></i></td>
                    <td><?php echo $row['email']; ?></td>
                    <td class='text-center'>
                      <a href="usermanager.php?edit=<?php echo $row['id']; ?>" class="btn btn-link" ><i class="far fa-edit"></i></a>
                    </td>
                    <td class='text-center'>
                      <a href="lib/userserver.php?del=<?php echo $row['id']; ?>" class="btn btn-link"><i class="far fa-trash-alt"></i></a>
                    </td>
                  </tr>
                <?php
                }

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

  <script type="text/javascript">
    function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
    }

    function validate() {
    var $result = $("#result");
    var email = $("#email").val();
    $result.text("");

    if (validateEmail(email)) {
      $result.text(email + " is valid :)");
      $result.css("color", "green");
    } else {
      $result.text(email + " is not valid :(");
      $result.css("color", "red");
    }
    return false;
    }

    $("#validate").bind("click", validate);
  </script>

	<!-- Footer -->
	<?php include '../partials/_footer.php' ?>
</body>
</html>
