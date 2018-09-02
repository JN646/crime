<?php
//############## FUNCTION FILE #######################################################
//############## Version Number ######################################################
class ApplicationVersion
{
    // Define version numbering
    const MAJOR = 0;
    const MINOR = 0;
    const PATCH = 0;

    public static function get()
    {
        // Prepare git information to form version number.
        $commitHash = trim(exec('git log --pretty="%h" -n1 HEAD'));

        // Get date and time information.
        $commitDate = new \DateTime(trim(exec('git log -n1 --pretty=%ci HEAD')));
        $commitDate->setTimezone(new \DateTimeZone('UTC'));

        // Format all information into a version identifier.
        return sprintf('v%s.%s.%s-dev.%s (%s)', self::MAJOR, self::MINOR, self::PATCH, $commitHash, $commitDate->format('Y-m-d H:m:s'));
    }

    // Usage: echo 'MyApplication ' . ApplicationVersion::get();
}

//############## INIT VALUE ##########################################################
// Debug
$safety = "safe";
$monthVal = "January";
$yearVal = "2018";
$radVal1 = 0;
$radVal2 = 0;
$n = 0;

//############## SQL Connection ######################################################
//MySQL connection
$mysqli = new mysqli('localhost', 'root', '', 'crimes');

 //If connection fail
if ($mysqli->connect_error) {
  die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

//############## RUN MAP #############################################################
function getMap($latVal, $longVal) {
  ?>
  <div id="map" style="width:100%;height:300px"></div>

  <script>
  function myMap() {
    var myCenter = new google.maps.LatLng(<?php echo $latVal ?>,<?php echo $longVal ?>);
    var mapCanvas = document.getElementById("map");
    var mapOptions = {center: myCenter, zoom: 14, streetViewControl: false, mapTypeControl: false};
    var map = new google.maps.Map(mapCanvas, mapOptions);
    var marker = new google.maps.Marker({position:myCenter});
    marker.setMap(map);

    google.maps.event.addListener(map, "click", function (e) {
      latBoxVal.value =  e.latLng.lat().toFixed(6);
      longBoxVal.value =  e.latLng.lng().toFixed(6);
    });

    // Add circle overlay and bind to marker
    var circleImmediate = new google.maps.Circle({
      map: map,
      radius: 100,
      fillColor: '#AA0000',
      strokeWeight: 1
    });
    circleImmediate.bindTo('center', marker, 'position');

    var circleLocal = new google.maps.Circle({
      map: map,
      radius: 1000,
      fillColor: '#EE0000',
      strokeWeight: 1
    });
    circleLocal.bindTo('center', marker, 'position');
  }
  </script>

  <!-- Map API Key -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDntrXRGpts74HjwJQbirjHqKW_Cq50lSU&callback=myMap"></script>
  <?php
}

//############## RISK MATRIX #########################################################
function getRisk($crime_count) {
  // High
  if ($crime_count >= 50) {
    $crime_risk = "High";
  }

  // Medium
  if ($crime_count >= 11 && $crime_count <= 49) {
    $crime_risk = "Medium";
  }

  // Low
  if ($crime_count <= 10) {
    $crime_risk = "Low";
  }

  return $crime_risk;
}

//############## MAKE TABLE ########################################################
function tableGen($resultCount_Immediate,$resultCount_Local,$duration) {
  // Fetch Results
  if (mysqli_num_rows($resultCount_Immediate) > 0 || mysqli_num_rows($resultCount_Local) > 0) {
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
      while ($row = mysqli_fetch_assoc($resultCount_Local)) {
          // Set Variables
          $crime_type = $row["Crime_Type"];
          $crime_count = $row["COUNT(id)"]; ?>

          <!-- Rows -->
          <tr>
            <!-- Crime Type -->
            <td><?php echo $crime_type; ?></td>

            <!-- Number of Results -->
            <td class='text-center'>
              <?php $n = 0;
              $row1 = mysqli_fetch_assoc($resultCount_Immediate);
              for ($i=0; $i < count($resultCount_Immediate); $i++) {
                if ($row1["Crime_Type"] == $crime_type) {
                  $n = $row1["COUNT(id)"];
                }
              }
              if ($n == 0) {
                echo "-";
              } else {
                echo $n;
              } ?>
            </td>

            <!-- Crime Count -->
            <td class='text-center'><?php echo $crime_count; ?></td>

            <!-- Crime Risk -->
            <td class='text-center'><?php echo "<span class='bold risk_" . getRisk($crime_count) ."'>" . getRisk($crime_count) . "</span>"?></td>
          </tr>
        <?php } ?>
      </table>

      <hr>
      <!-- Count Results -->
      <div id='resultStats'>
        <p class='outputText'><b>Immediate:</b> <?php echo mysqli_num_rows($resultCount_Immediate) ?></p>
        <p class='outputText'><b>Local:</b> <?php echo mysqli_num_rows($resultCount_Local) ?></p>
        <p class='outputText'><b>Exec Time:</b> <?php echo round($duration, 4) ?></p>
      </div>
      <?php
  } else {
      // No Results
      echo "<p id='noResults'>0 results</p>";
  }
}

//############## RUN SQL #########################################################
// SQL Immediate
function sqlImmediate($mysqli,$longLow1,$longHigh1,$latLow1,$latHigh1,$latVal,$longVal,$radVal1,$monthVal,$yearVal) {
  //immediate area
  $sql_immediate = "SELECT COUNT(id), Longitude, Latitude, Crime_Type, Month, Year FROM data
  WHERE Longitude > $longLow1 AND Longitude < $longHigh1 and Latitude > $latLow1 AND Latitude < $latHigh1 AND SQRT(POW(Latitude-'$latVal', 2)+POW(Longitude-'$longVal', 2))<'$radVal1'
  AND Month='$monthVal'
  AND Year='$yearVal'
  GROUP BY Crime_Type
  ORDER BY COUNT(id) DESC";

  // Run Query
  $resultCount_Immediate = mysqli_query($mysqli, $sql_immediate);

  // If Error
  if (!$resultCount_Immediate) {
      die('Could not run query: ' . mysqli_error($mysqli));
  }

  return $resultCount_Immediate;
}

// SQL Local
function sqlLocal($mysqli,$longLow2,$longHigh2,$latLow2,$latHigh2,$latVal,$longVal,$radVal2,$monthVal,$yearVal) {
  //local area
  $sq2_local = "SELECT COUNT(id), Longitude, Latitude, Crime_Type, Month, Year FROM data
  WHERE Longitude > $longLow2 AND Longitude < $longHigh2 and Latitude > $latLow2 AND Latitude < $latHigh2 AND SQRT(POW(Latitude-'$latVal', 2)+POW(Longitude-'$longVal', 2))<'$radVal2'
  AND Month='$monthVal'
  AND Year='$yearVal'
  GROUP BY Crime_Type
  ORDER BY COUNT(id) DESC";

  // Run Query
  $resultCount_Local = mysqli_query($mysqli, $sq2_local);

  // If Error
  if (!$resultCount_Local) {
      die('Could not run query: ' . mysqli_error($mysqli));
  }

  return $resultCount_Local;
}

//############## GET VALUES #####################################################
// Get Months
function getMonths() {
  $monthVariables = ["January","Feburary","March","April","May","June","July","August","September","October","November","December"];
    for ($i=0; $i < count($monthVariables) ; $i++) { ?>
      <option value="<?php echo $monthVariables[$i] ?>"><?php echo $monthVariables[$i] ?></option>
<?php }
}

// Get Years
function getYears() {
  $yearVariables = ["2018","2017","2016"];
    for ($i=0; $i < count($yearVariables) ; $i++) { ?>
      <option value="<?php echo $yearVariables[$i] ?>"><?php echo $yearVariables[$i] ?></option>
<?php }
}
?>
