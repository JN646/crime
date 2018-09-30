<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>

<!-- Header -->
<?php include '../partials/_header.php' ?>
<body>
  <div id="bodyContainer" class="container">
    <div class='col-md-12'>

      <!-- Page Header -->
        <div class="page-header">
            <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
        </div>

        <!-- Intro Text -->
        <p>This is your dashboard. This feature is coming soon. Does not serve a purpose yet, but only to act as a landing page for a successful login of a non-admin account.</p>

        <!-- Buttons -->
        <p>
            <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
            <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
        </p>

        <hr>

        <h2>Your Reports</h2>
        <p class='text-center'><b>You do not have any reports.</b></p>

        <table class='table table-bordered'>
          <thead>
            <th class='text-center'>Location</th>
            <th class='text-center'>Date</th>
            <th class='text-center'>Open</th>
          </thead>
          <tbody>

            <!-- Test Cells -->
            <td>Location</td>
            <td>30/09/2018</td>
            <td class='text-center'><button class='btn btn-primary'>Open Report</button></td>

          </tbody>
        </table>
    </div>
  </div>
</body>
<!-- Footer -->
<?php include '../partials/_footer.php' ?>
</html>
