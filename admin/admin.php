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

<?php include '../partials/_header.php' ?>

  <!-- Container -->
  <div id='bodyContainer' class="fluid-container">
    <div class="row col-md-12">

      <!-- Sidebar -->
      <div class="col-md-2">
        <div class='col-md-12'>
          <!-- Side Bar -->
          <?php include '../partials/_admin_sidebar.php' ?>
        </div>
      </div>

      <!-- Body Wrapper -->
      <div class="col-md-10">
        <div class="row">
          <div class="col-md-12">
            <!-- Page Header -->
            <div class="page-header">
                <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our admin site.</h1>
            </div>
            <p>This is the admin area of the site. Currently not functioning and not serving a purpose.</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <hr>
            <!-- Stats -->
            <?php include '../partials/_stats.php' ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer -->
  <?php include '../partials/_footer.php' ?>
</body>
</html>
