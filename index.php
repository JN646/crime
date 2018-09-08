  <!-- Header Form -->
<?php include 'partials/_header.php' ?>
    <!-- Container -->
    <div class="container">

      <!-- Intro -->
      <h2>Welcome</h2>
      <p>This application will all you to see what crimes have happened around you and provide you with some risk statistics. This is a work in progress and most elements will change over time.</p>

      <!-- Form Partial -->
      <?php include 'partials/_form.php' ?>

      <!-- Link to Server page -->
      <p class='outputText'><a href='lib/server.php'>Hack the Mainframe</a></p>

      <hr>
      <!-- Count Results -->
      <div id='resultStats'>
        <h5 class=''>Statistics.</h5>
        <p class='outputText'><b>All Crimes: </b><?php echo countAllCrimes($mysqli); ?></p>
        <p class='outputText'><b>All Crime Types: </b><?php echo countAllCrimeTypes($mysqli); ?></p>
        <p class='outputText'><b>Months worth of data: </b><?php echo countAllMonth($mysqli); ?></p>
      </div>

      <!-- Footer -->
      <?php include 'partials/_footer.php' ?>
  </body>
</html>
