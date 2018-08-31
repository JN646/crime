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
      <form class="" action="" method="post">
        <label for="">Latitude</label>
        <input size='15' type="text" name="lat" value="52.122123">
        <label for="">Longitude</label>
        <input size='15' type="text" name="long" value="-0.586406">
        <label for="">Radius (degrees)</label>
        <input size='10' type="text" name="rad" value="0.03">
        <button type="submit" name="btnSearch"><i class="fas fa-search"></i></button>
      </form>

      <?php
      // Search Button Press
      if (isset($_POST["btnSearch"])) {
          $longVal = trim($_POST["long"]);
          $latVal = trim($_POST["lat"]);
          $radVal = trim($_POST["rad"]);

          // Get SQL
          $sql = "SELECT id, Longitude, Latitude, Crime_Type FROM data
          WHERE SQRT(POW(Latitude-'$latVal', 2)+POW(Longitude-'$longVal', 2))<'$radVal'
          ORDER BY Crime_Type ASC";

          // Run Result
          $result = mysqli_query($mysqli, $sql);

          // Fetch Results
          if (mysqli_num_rows($result) > 0) {
              // Danger notification
              $safety = "danger"; ?>

              <!-- Risk Notification -->
              <?php if ($safety == "safe") {
                  ?>
                <p class="safe">You might be safe!</p>
              <?php
              } elseif ($safety == "danger") {
                  ?>
                <p class="danger">You are at risk!</p>
              <?php
              } ?>

              <?php
              // output data of each row
              while ($row = mysqli_fetch_assoc($result)) {
                  // Set Variables
                  $id = $row["id"];
                  $long = $row["Longitude"];
                  $lat = $row["Latitude"];
                  $crime_type = $row["Crime_Type"];

                  // Output Results
                  echo "<p class='outputText'><b>Lat:</b> " . $lat . " <b> Long:</b> " . $long . " <b>Crime Type:</b> " . $crime_type . "</p>";
              }
              ?>
              <div id='resultStats'>
                <hr>
                <!-- Count Results -->
                <p>Total: <?php echo mysqli_num_rows($result) ?></p>
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
