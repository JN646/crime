<?php
// Function
function timeSeries($mysqli,$lat,$long,$radius)
{
    // Hardcoded Values
    // $lat = 52.1367078;
    // $long = -0.4688611;
    // $radius = 0.05; //in degrees
    $monthArray = $crimeTypeArray = array();

    // Calculate
    $latMin   = $lat - $radius;
    $latMax   = $lat + $radius;
    $longMin  = $long - $radius;
    $longMax  = $long + $radius;

    // SQL Terms
    $monthTerm = "SELECT DISTINCT Month FROM data";
    $crimeTypeTerm = "SELECT DISTINCT Crime_Type FROM data";
    $monthQuery = mysqli_query($mysqli, $monthTerm);
    $crimeTypeQuery = mysqli_query($mysqli, $crimeTypeTerm);

    $i = 0;
    while ($row = mysqli_fetch_assoc($monthQuery)) {
        $monthArray[$i] = $row["Month"];
        $i++;
    }

    $i = 0;
    while ($row = mysqli_fetch_assoc($crimeTypeQuery)) {
        $crimeTypeArray[$i] = $row["Crime_Type"];
        $i++;
    }

    $table = array(); //of time series data. crimetype x timeseries
    for ($i=0; $i < count($crimeTypeArray); $i++) {
        for ($j=0; $j < count($monthArray); $j++) {
            $table[$i][$j] = "";
        }
    }

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

        while ($row = mysqli_fetch_assoc($resultCount_Month)) {
            //  echo $row["Crime_Type"] . "<br>";
            for ($i=0; $i < count($crimeTypeArray);  $i++) {
                if ($row["Crime_Type"] == $crimeTypeArray[$i]) {
                    $table[$i][$m] = $row["COUNT(id)"];
                }
            }
        }
    }

    function renderTimeSeriesTable($mysqli, $crimeTypeArray, $monthArray, $table)
    {
        // Draw Table
        echo "<table class='table table-bordered'>";
        //X header
        echo "<tr><th id='cornerTableHeader'>Crime Type Over Time</th>";
        for ($i=0; $i < count($crimeTypeArray); $i++) {
            echo "<th><span class='verticalTH'>" . $crimeTypeArray[$i] . "</span></th>";
        }
        echo "</tr>";

        for ($i=0; $i < count($monthArray); $i++) {
            echo "<tr>";
            echo "<th class='text-center text-bold'>" . $monthArray[$i] . "</th>";
            for ($j=0; $j < count($crimeTypeArray); $j++) {
                echo "<td class='text-center'>" . $table[$j][$i] . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    renderTimeSeriesTable($mysqli, $crimeTypeArray, $monthArray, $table);
}
?>
