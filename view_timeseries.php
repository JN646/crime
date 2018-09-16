<!-- Header Form -->
<?php include 'partials/_header.php' ?>
<?php include 'lib/timeseries.php' ?>

  <!-- Container -->
  <div id='bodyContainer' class="container">

    <!-- Render Table -->
    <h2>Time Series</h2>
    <?php echo timeSeries($mysqli); // Run Function ?>

    <!-- Footer -->
    <?php include 'partials/_footer.php' ?>
</body>
</html>
