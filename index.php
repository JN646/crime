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
    <?php
    // Debug
    $safety = "safe";
    $monthVal = "January";
    $yearVal = "2018";
    $radVal1 = 0;
    $radVal2 = 0;
    $n = 0;
     ?>
    <!-- Container -->
    <div class="container">
      <h1>The Crimes</h1>
      <p>Are you at risk of attack?</p>

      <!-- Search Form -->
      <form class="form-layout" action="" method="post">
        <label for="">Latitude</label>
        <input size='8' type="text" name="lat" value="52.122123">
        <label for="">Longitude</label>
        <input size='8' type="text" name="long" value="-0.586406">
        <label for="">immediate area</label>
        <input id='radius' size='3' type="text" name="rad1" value="0.1">
        <label for="">local area</label>
        <input id='radius2' size='3' type="text" name="rad2" value="0.4">
        <label for="">Month</label>
        <select class="" name="month">
          <?php $monthVariables = ["January","Feburary","March","April","May","June","July","August","September","October","November","December"];
            for ($i=0; $i < count($monthVariables) ; $i++) {
                ?>
              <option value="<?php echo $monthVariables[$i] ?>"><?php echo $monthVariables[$i] ?></option>
          <?php
            } ?>
         </select>
        <label for="">Year</label>
        <select class="" name="year">
          <option value='2016'>2016</option>
          <option value="2017">2017</option>
          <option selected='selected' value="2018">2018</option>
        </select>
        <label for="">Case</label>
        <select class="" name="case">
          <?php for ($i=0; $i < 3; $i++) {
                echo "<option value='" . $i . "'>" . $i . "</option>";
            } ?>
        </select>

        <!-- Search Button -->
        <button type="submit" name="btnSearch"><i class="fas fa-search"></i></button>
      </form>

      <?php
      // Search Button Press
      if (isset($_POST["btnSearch"])) {
          $longVal = trim($_POST["long"]);
          $latVal = trim($_POST["lat"]);
          $radVal1 = trim($_POST["rad1"]);
          $radVal2 = trim($_POST["rad2"]);
          $monthVal = trim($_POST["month"]);
          $yearVal = trim($_POST["year"]);
          $searchCase = trim($_POST["case"]);

          // Get SQL
          //precalculation of ranges
          $latLow1 = $latVal - $radVal1;
          $latHigh1 = $latVal + $radVal1;
          $longLow1 = $longVal - $radVal1;
          $longHigh1 = $longVal + $radVal1;

          $latLow2 = $latVal - $radVal2;
          $latHigh2 = $latVal + $radVal2;
          $longLow2 = $longVal - $radVal2;
          $longHigh2 = $longVal + $radVal2;

          $starttime = microtime(true); // Start Timer

          //immediate area
          $sql1 = "SELECT COUNT(id), Longitude, Latitude, Crime_Type, Month, Year FROM data
          WHERE Longitude > $longLow1 AND Longitude < $longHigh1 and Latitude > $latLow1 AND Latitude < $latHigh1 AND SQRT(POW(Latitude-'$latVal', 2)+POW(Longitude-'$longVal', 2))<'$radVal1'
          AND Month='$monthVal'
          AND Year='$yearVal'
          GROUP BY Crime_Type
          ORDER BY COUNT(id) DESC";

          //local area
          $sql2 = "SELECT COUNT(id), Longitude, Latitude, Crime_Type, Month, Year FROM data
          WHERE Longitude > $longLow2 AND Longitude < $longHigh2 and Latitude > $latLow2 AND Latitude < $latHigh2 AND SQRT(POW(Latitude-'$latVal', 2)+POW(Longitude-'$longVal', 2))<'$radVal2'
          AND Month='$monthVal'
          AND Year='$yearVal'
          GROUP BY Crime_Type
          ORDER BY COUNT(id) DESC";

          // Run Results
          $resultCount1 = mysqli_query($mysqli, $sql1);
          $resultCount2 = mysqli_query($mysqli, $sql2);

          // If Error
          if (!$resultCount1 || !$resultCount2) {
              die('Could not run query: ' . mysqli_error($mysqli));
          }

          $duration = microtime(true) - $starttime; // Calculates total time taken

          // Get Map
          getMap($latVal, $longVal);

          // Fetch Results
          if (mysqli_num_rows($resultCount1) > 0 || mysql_num_rows($resultCount2) > 0) {
              ?>

              <!-- Result Table -->
              <h2>Crimes Around You</h2>
              <table class='table-border' width=100%>
                <tr>
                  <th class='text-center text-bold'>Crime</th>
                  <th class='text-center text-bold'>Immediate</th>
                  <th class='text-center text-bold'>Local</th>
                  <th class='text-center text-bold'>Risk</th>
                </tr>
                <?php

              while ($row = mysqli_fetch_assoc($resultCount2)) {
                  // Set Variables
                  $crime_type = $row["Crime_Type"];
                  $crime_count = $row["COUNT(id)"]; ?>
                  <tr>
                    <td><?php echo $crime_type; ?></td>
                    <td class='text-center'>
                    <?php
                    $n = 0;
                    $row1 = mysqli_fetch_assoc($resultCount1);
                    for ($i=0; $i < count($resultCount1); $i++) {
                      if ($row1["Crime_Type"] == $crime_type) {
                        $n = $row1["COUNT(id)"];
                      }
                    }
                    echo $n;
                     ?></td>
                     <td class='text-center'><?php echo $crime_count; ?></td>
                    <td class='text-center'><?php echo "<span class=risk_" . getRisk($crime_count) .">" . getRisk($crime_count) . "</span>"?></td>
                  </tr>
                <?php } ?>
              </table>

              <hr>
              <!-- Count Results -->
              <div id='resultStats'>
                <p>Total1: <?php echo mysqli_num_rows($resultCount1) ?></p>
                <p>Total2: <?php echo mysqli_num_rows($resultCount2) ?></p>
                <p>Exec Time: <?php echo round($duration, 4) ?></p>
              </div>
              <?php
          } else {
              // No Results
              echo "<p id='noResults'>0 results</p>";
          }
      } ?>
    </div>
  </body>
</html>
