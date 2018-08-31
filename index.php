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
    $rad = 0;
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
        <label for="">Radius</label>
        <input type="range" style="vertical-align: middle;" min="0.01" max="1.00" value="0.05" step="0.01" class="slider" id="myRange">
        <input id='radius' size='3' type="text" name="rad" value="0.08">
        <button type="submit" name="btnSearch"><i class="fas fa-search"></i></button>
      </form>

      <?php
      // Search Button Press
      if (isset($_POST["btnSearch"])) {
          $longVal = trim($_POST["long"]);
          $latVal = trim($_POST["lat"]);
          $radVal = trim($_POST["rad"]);

          // Get SQL
          $sql = "SELECT COUNT(id), Longitude, Latitude, Crime_Type FROM data
          WHERE SQRT(POW(Latitude-'$latVal', 2)+POW(Longitude-'$longVal', 2))<'$radVal'
          GROUP BY Crime_Type
          ORDER BY COUNT(id) DESC";

          // Run Result
          $resultCount = mysqli_query($mysqli, $sql);

          // Fetch Results
          if (mysqli_num_rows($resultCount) > 0) {
              ?>
            <div id="map" style="width:100%;height:300px"></div>

            <script>
            function myMap() {
              var myCenter = new google.maps.LatLng(<?php echo $latVal ?>,<?php echo $longVal ?>);
              var mapCanvas = document.getElementById("map");
              var mapOptions = {center: myCenter, zoom: 15};
              var map = new google.maps.Map(mapCanvas, mapOptions);
              var marker = new google.maps.Marker({position:myCenter});
              marker.setMap(map);
            }
            </script>

            <!-- Map API Key -->
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDntrXRGpts74HjwJQbirjHqKW_Cq50lSU&callback=myMap"></script>

              <!-- Result Table -->
              <table class='table-border' width=100%>
				        <tr>
              		<th class='text-center text-bold'>Crime</th>
              		<th class='text-center text-bold'>Count</th>
              		<th class='text-center text-bold'>Risk</th>
              	</tr>
                <?php
              while ($row = mysqli_fetch_assoc($resultCount)) {
                  // Set Variables
                  $crime_type = $row["Crime_Type"];
                  $crime_count = $row["COUNT(id)"]; ?>
                  <tr>
                    <td><?php echo $crime_type; ?></td>
                    <td class='text-center'><?php echo $crime_count; ?></td>
                    <td class='text-center'><?php echo "<span class=risk_" . getRisk($crime_count) .">" . getRisk($crime_count) . "</span>"?></td>
                  </tr>
                  <?php
              }
              echo "</table>"; ?>

              <div id='resultStats'>
                <hr>
                <!-- Count Results -->
                <p>Total: <?php echo mysqli_num_rows($resultCount) ?></p>
              </div>
              <?php
          } else {
              // No Results
              echo "<p id='noResults'>0 results</p>";
          }
      }
       ?>
    </div>
    <script type="text/javascript">
      var slider = document.getElementById("myRange");
      var output = document.getElementById("radius");
      output.innerHTML = slider.value; // Display the default slider value

      // Update the current slider value (each time you drag the slider handle)
      slider.oninput = function() {
        output.value = this.value;
      }
    </script>
  </body>
</html>
