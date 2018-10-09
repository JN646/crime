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
                  <input class='form-control' type="text" name="password" value="<?php echo $password; ?>">
                </div>

                <!-- Email -->
                <div class="col-md-4 form-group">
                  <label class=''>Email</label>
                  <input class='form-control' type="text" name="email" value="<?php echo $email; ?>">
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
                <?php while ($row = mysqli_fetch_array($results)) {
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
