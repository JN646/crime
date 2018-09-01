<?php
//############## FUNCTION FILE #######################################################
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
  if ($crime_count >= 5) {
    $crime_risk = "High";
  } else {
    $crime_risk = "Low";
  }

  return $crime_risk;
}
?>
