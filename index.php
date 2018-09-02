<!-- Header Form -->
<?php include 'partials/_header.php' ?>
    <!-- Container -->
    <div class="container">

      <!-- Form Partial -->
      <?php include 'partials/_form.php' ?>

      <?php
      // Search Button Press
      if (isset($_POST["btnSearch"])) {
          $longVal    = trim($_POST["long"]);
          $latVal     = trim($_POST["lat"]);
          $radVal1    = trim($_POST["rad1"]);
          $radVal2    = trim($_POST["rad2"]);
          $monthVal   = trim($_POST["month"]);
          $yearVal    = trim($_POST["year"]);

          // Get SQL
          // Precalculation of ranges
          $latLow1    = $latVal - $radVal1;
          $latHigh1   = $latVal + $radVal1;
          $longLow1   = $longVal - $radVal1;
          $longHigh1  = $longVal + $radVal1;

          $latLow2    = $latVal - $radVal2;
          $latHigh2   = $latVal + $radVal2;
          $longLow2   = $longVal - $radVal2;
          $longHigh2  = $longVal + $radVal2;

          // Start Timer
          $starttime = microtime(true);

          // Run Queries
          $resultCount_Immediate  = sqlImmediate($mysqli,$longLow1,$longHigh1,$latLow1,$latHigh1,$latVal,$longVal,$radVal1,$monthVal,$yearVal);
          $resultCount_Local      = sqlLocal($mysqli,$longLow2,$longHigh2,$latLow2,$latHigh2,$latVal,$longVal,$radVal2,$monthVal,$yearVal);

          // Calculates total time taken
          $duration = microtime(true) - $starttime;

          // Get Map
          if ($enableMap == "True") {
            getMap($latVal, $longVal);
          }

          // Generate Table
          tableGen($resultCount_Immediate,$resultCount_Local,$duration);

          // Counters
      } ?>

      <hr>
      <!-- Count Results -->
      <div id='resultStats'>
        <p class='outputText'><b>Immediate:</b> <?php echo mysqli_num_rows($resultCount_Immediate) ?></p>
        <p class='outputText'><b>Local:</b> <?php echo mysqli_num_rows($resultCount_Local) ?></p>
        <p class='outputText'><b># Counties:</b> <?php countCounties($mysqli) ?></p>
        <p class='outputText'><b># Reports:</b> <?php countCrimes($mysqli) ?></p>
        <p class='outputText'><b># Crime Types:</b> <?php countCrimeTypes($mysqli) ?></p>
        <p class='outputText'><b>Exec Time:</b> <?php echo round($duration, 4) ?></p>
      </div>

      <!-- Footer -->
      <?php include 'partials/_footer.php' ?>
  </body>
</html>
