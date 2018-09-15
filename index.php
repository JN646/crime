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

      <!-- Manual Cron Jobs -->
      <p class='outputText'><a href='cron/cron_count.php'>Cron Count</a></p>

      <hr>

      <!-- Stats Partial -->
      <?php include 'partials/_stats.php' ?>

      <!-- Footer -->
      <?php include 'partials/_footer.php' ?>
  </body>
</html>
