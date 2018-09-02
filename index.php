<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <!-- Title -->
    <title>CrimeMap App</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!-- Function File -->
    <?php include 'functions.php' ?>
  </head>
  <body>
    <!-- Container -->
    <div class="container">
      <div class="header">
        <h1>The Crimes</h1>
        <p>What is happening around you?</p>
      </div>

      <!-- Search Form -->
      <form class="form-layout" action="" method="post">
        <!-- Latitude -->
        <div class='form-block'>
          <label for="lat">Latitude</label>
          <input id='latBox' size='8' type="text" name="lat" value="52.122123">
        </div>

        <!-- Longitude -->
        <div class='form-block'>
          <label for="long">Longitude</label>
          <input id='longBox' size='8' type="text" name="long" value="-0.586406">
        </div>

        <!-- Get GPS Locations -->
        <div class='form-block'>
          <label for="gps"></label>
          <button type="button" onclick="getLocation()" name="gps"><i class="fas fa-location-arrow"></i></button>
        </div>

        <!-- Immediate Area -->
        <div class='form-block'>
          <label for="rad1">Immediate Area</label>
          <input id='radius' size='3' type="text" name="rad1" value="0.02">
        </div>

        <!-- Local Area -->
        <div class='form-block'>
          <label for="rad2">Local Area</label>
          <input id='radius2' size='3' type="text" name="rad2" value="0.05">
        </div>

        <!-- Month -->
        <div class='form-block'>
          <label for="month">Month</label>
          <select class="" name="month">
            <?php getMonths() ?>
          </select>
        </div>

        <!-- Year -->
        <div class='form-block'>
          <label for="year">Year</label>
          <select class="" name="year">
          <?php getYears() ?>
          </select>
        </div>

        <!-- Search Button -->
        <div class='form-block'>
          <label for="btnSearch"></label>
          <button type="submit" name="btnSearch"><i class="fas fa-search"></i></button>
        </div>
      </form>

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
      <div id='footer' class="">
        <p class='outputText text-center'>Copyright &copy; 2018 Copyright Holder All Rights Reserved. <br> <?php echo 'Version: ' . ApplicationVersion::get(); ?></p>
      </div>
    </div>
    <!-- Global JS File -->
    <script src="js/global.js" charset="utf-8"></script>
  </body>
</html>
