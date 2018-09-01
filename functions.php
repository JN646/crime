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
    var mapOptions = {center: myCenter, zoom: 15};
    var map = new google.maps.Map(mapCanvas, mapOptions);
    var marker = new google.maps.Marker({position:myCenter});
    marker.setMap(map);
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
  if ($crime_count > 11 && $crime_count < 49) {
    $crime_risk = "Medium";
  }

  // Low
  if ($crime_count < 10) {
    $crime_risk = "Low";
  }

  return $crime_risk;
}
?>
