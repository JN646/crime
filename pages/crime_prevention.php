<?php
// Initialise the session
session_start();
 ?>

  <!-- Header Form -->
<?php include_once $_SERVER["DOCUMENT_ROOT"] . '/crime/partials/_header.php' ?>
    <!-- Container -->
    <div id='bodyContainer' class="container">
      <div class="col-md-12">
        <?php include_once $_SERVER["DOCUMENT_ROOT"] . '/crime/pages/crime_prevention.html' ?>
      </div>
    </div>

      <!-- Footer -->
      <?php include_once $_SERVER["DOCUMENT_ROOT"] . '/crime/partials/_footer.php' ?>
  </body>
</html>
