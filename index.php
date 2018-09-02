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
          $resultCount_Immediate = sqlImmediate($mysqli,$longLow1,$longHigh1,$latLow1,$latHigh1,$latVal,$longVal,$radVal1,$monthVal,$yearVal);
          $resultCount_Local = sqlLocal($mysqli,$longLow2,$longHigh2,$latLow2,$latHigh2,$latVal,$longVal,$radVal2,$monthVal,$yearVal);

          // Calculates total time taken
          $duration = microtime(true) - $starttime;

          // Get Map
          getMap($latVal, $longVal);

          // Generate Table
          tableGen($resultCount_Immediate,$resultCount_Local,$duration);
      } ?>
      <?php include 'partials/_footer.php' ?>
  </body>
</html>
