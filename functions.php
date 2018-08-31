<?php
//############## FUNCTION FILE #################################################
//MySQL connection
$mysqli = new mysqli('localhost', 'root', '', 'crimes');

 //If connection fail
if ($mysqli->connect_error) {
  die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

//############## RISK MATRIX ###################################################
function getRisk($crime_count) {
  if ($crime_count >= 5) {
    $crime_risk = "High";
  } else {
    $crime_risk = "Low";
  }

  return $crime_risk;
}
?>
