<?php
// Initialise the session
session_start();
 ?>

  <!-- Header Form -->
<?php include_once $_SERVER["DOCUMENT_ROOT"] . '/crime/partials/_header.php' ?>
    <!-- Container -->
    <div id='bodyContainer' class="container">

      <!-- Intro -->
      <h2>Welcome</h2>
      <p>This application will all you to see what crimes have happened around you and provide you with some risk statistics. This is a work in progress and most elements will change over time. This is currently only supported in the UK.</p>

      <!-- Form Partial -->
      <?php
      // Check if the user is logged in, if not then redirect to login page
      if ($require_logon_to_search == FALSE) {
        if(isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == true){
            include 'partials/_form.php';
        } else {
          ?>
          <div class="alert alert-info">
            <p class='text-center'><a href='users/login.php'>Login to run a personalised search.</a></p>
          </div>
          <?php
        }
      } else {
        include 'partials/_form.php';
      }
      ?>

      <!-- Link to create tables -->
      <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link" href="cron/cron_createTables.php"><i class="fas fa-table"></i> Create Tables</a></li>
      </ul>

      <hr>

      <!-- Stats Partial -->
      <?php include 'partials/_stats.php' ?>

    </div>

      <!-- Footer -->
      <?php include 'partials/_footer.php' ?>
  </body>
</html>
