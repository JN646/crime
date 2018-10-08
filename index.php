<?php
// Initialize the session
session_start();
 ?>

  <!-- Header Form -->
<?php include 'partials/_header.php' ?>
    <!-- Container -->
    <div id='bodyContainer' class="container">

      <!-- Intro -->
      <h2>Welcome</h2>
      <p>This application will all you to see what crimes have happened around you and provide you with some risk statistics. This is a work in progress and most elements will change over time. This is currently only supported in the UK.</p>

      <!-- Form Partial -->
      <?php
      // Check if the user is logged in, if not then redirect to login page
      if(isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == true){
          include 'partials/_form.php';
      } else {
        echo "Log in to start a search...";
      }
       ?>

      <hr>

      <!-- Stats Partial -->
      <?php include 'partials/_stats.php' ?>

    </div>

      <!-- Footer -->
      <?php include 'partials/_footer.php' ?>
  </body>
</html>
