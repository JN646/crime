  <!-- Header Form -->
<?php include 'partials/_header.php' ?>
    <!-- Container -->
    <div id='bodyContainer' class="container">

      <!-- Intro -->
      <h2>Welcome</h2>
      <p>This application will all you to see what crimes have happened around you and provide you with some risk statistics. This is a work in progress and most elements will change over time.</p>

      <!-- Form Partial -->
      <?php include 'partials/_form.php' ?>

      <ul class="nav">
        <li class="nav-item">
          <a class="nav-link active" href="lib/server.php">Hack the Mainframe</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cron/cron_count.php">Cron Count</a>
        </li>
      </ul>

      <hr>

      <!-- Stats Partial -->
      <?php include 'partials/_stats.php' ?>

      <!-- Footer -->
      <?php include 'partials/_footer.php' ?>
  </body>
</html>
