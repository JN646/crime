<?php
include_once '../config/config.php';

timeSeries($mysqli);

function timeSeries($mysqli)
{
    $lat = 52.1367078;
    $long = -0.4688611;
    $size = 0.05; //in degrees

    $latMin = $lat-$size;
    $latMax = $lat+$size;
    $longMin = $long-$size;
    $longMax = $long+$size;


    $monthTerm = "SELECT DISTINCT Month FROM data";
    $crimeTypeTerm = "SELECT DISTINCT Crime_Type FROM data";

    $monthQuery = mysqli_query($mysqli, $monthTerm);
    $crimeTypeQuery = mysqli_query($mysqli, $crimeTypeTerm);

    $monthArray = array();
    $crimeTypeArray = array();

    $i = 0;
    while($row = mysqli_fetch_assoc($monthQuery)){
      $monthArray[$i] = $row["Month"];
      $i++;
    }

    $i = 0;
    while($row = mysqli_fetch_assoc($crimeTypeQuery)){
      $crimeTypeArray[$i] = $row["Crime_Type"];
      $i++;
    }


    $table = array(); //of time series data. crimetype x timeseries
    for ($i=0; $i < count($crimeTypeArray); $i++) {
      for ($j=0; $j < count($monthArray); $j++) {
        $table[$i][$j] = "";
      }
    }

        //var_dump($crimeTypeArray);

        // If Error
        if (!$monthQuery) {
            die('<p class="SQLError">Could not get month list: ' . mysqli_error($mysqli) . '</p>');
        }

        // If Error
        if (!$crimeTypeQuery) {
            die('<p class="SQLError">Could not get crime type list: ' . mysqli_error($mysqli) . '</p>');
        }

        // For each month
        for ($m=0; $m < count($monthArray); $m++) {
            //immediate area
            //echo "MONTH: " . $m . "<br>";
            $sql_Month = "SELECT COUNT(id), Longitude, Latitude, Crime_Type, Month
            FROM data
            WHERE Longitude > $longMin AND Longitude < $longMax AND Latitude > $latMin AND Latitude < $latMax AND Month = '$monthArray[$m]'
            GROUP BY Crime_Type
            ORDER BY COUNT(id) DESC";

            // Run Query
            $resultCount_Month = mysqli_query($mysqli, $sql_Month);

            // If Error
            if (!$resultCount_Month) {
                die('<p class="SQLError">Could not run query: ' . mysqli_error($mysqli) . '</p>');
            }

            while($row = mysqli_fetch_assoc($resultCount_Month)) {
            //  echo $row["Crime_Type"] . "<br>";
              for ($i=0; $i < count($crimeTypeArray);  $i++) {
                if($row["Crime_Type"] == $crimeTypeArray[$i]){
                  $table[$i][$m] = $row["COUNT(id)"];
                  //echo "(" . $i . ", " . $m . "): " . $table[$i][$m] . "<br>";
                }
              }
            }


        }

        echo "<table style='width:100%;'>";
        //X header
        echo "<tr><th>Crime Type Over Time</th>";
        for ($i=0; $i < count($crimeTypeArray); $i++) {
          echo "<th>" . $crimeTypeArray[$i] . "</th>";
        }
        echo "</tr>";

        for ($i=0; $i < count($monthArray); $i++) {
          echo "<tr style='font-style:bold;'>";
          echo "<th>" . $monthArray[$i] . "</th>";
          for ($j=0; $j < count($crimeTypeArray); $j++) {
              echo "<td style='text-align:center;'>" . $table[$j][$i] . "</td>";
          }
          echo "</tr>";
        }
        echo "</table>";

        // Search everything in bounding box

  // Each type of crime.
    }
