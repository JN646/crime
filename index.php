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
        <input size='15' type="text" name="lat" value="52.122123">
        <label for="">Longitude</label>
        <input size='15' type="text" name="long" value="-0.586406">
        <label for="">Radius (degrees)</label>
        <input size='10' type="text" name="rad" value="0.08">
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
              // output data of each row
              ?>
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
                  $crime_count = $row["COUNT(id)"];

                  // Output Results
                  ?>
                  <tr>
                    <td><?php echo $crime_type; ?></td>
                    <td class='text-center'><?php echo $crime_count; ?></td>
                    <td class='text-center'><?php echo "<span class=risk_" . getRisk($crime_count) .">" . getRisk($crime_count) . "</span>"?></td>
                  </tr>
                  <?php
              }
              echo "</table>";
              ?>

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
  </body>
</html>
