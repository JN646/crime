<?php
// Function
function timeSeries($mysqli, $lat, $long, $radius)
{
    $time_start = microtime(true);
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
    $monthTerm = "SELECT DISTINCT Month FROM data WHERE Month <> 0";
    $crimeTypeTerm = "SELECT DISTINCT Crime_Type FROM data";
    $monthQuery = mysqli_query($mysqli, $monthTerm);
    $crimeTypeQuery = mysqli_query($mysqli, $crimeTypeTerm);

    // If Error
    if (!$monthQuery || !$crimeTypeQuery) {
        die('<p class="SQLError">Could not get run query: ' . mysqli_error($mysqli) . '</p>');
    }

    // Assign to array index.
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

    // Free Query
    mysqli_free_result($monthQuery);
    mysqli_free_result($crimeTypeQuery);

    $table = array(); //of time series data. crimetype x timeseries
    for ($i=0; $i < count($crimeTypeArray); $i++) {
        for ($j=0; $j < count($monthArray); $j++) {
            $table[$i][$j] = "";
        }
    }

    // For each month
    for ($m=0; $m < count($monthArray); $m++) {
        // Get Month Data
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
            for ($i=0; $i < count($crimeTypeArray);  $i++) {
                if ($row["Crime_Type"] == $crimeTypeArray[$i]) {
                    $table[$i][$m] = $row["COUNT(id)"];
                }
            }
        }

        // Free Query
        mysqli_free_result($resultCount_Month);
    }

    function renderTimeSeriesTable($mysqli, $crimeTypeArray, $monthArray, $table)
    {
        // Draw Table
        echo "<table id='timeSeriesTable' class='table table-bordered table-hover'>";
        //X header
        echo "<tr><th id='cornerTableHeader'>Crime Type Over Time</th>";
        for ($i=0; $i < count($crimeTypeArray); $i++) {
            echo "<th><span class='verticalTH'>" . $crimeTypeArray[$i] . "</span></th>";
        }
        echo "</tr>";

        for ($i=0; $i < count($monthArray); $i++) {
            echo "<tr>";
            echo "<th class='text-left text-bold'>" . splitDate($monthArray[$i]) . "</th>";
            for ($j=0; $j < count($crimeTypeArray); $j++) {
                echo "<td class='text-center " . changeDirectionCSS($table, $j, $i) . "'>" . changeDirection($table, $j, $i) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    function changeDirection($table, $j, $i)
    {
        // Get the index of the value before.
        $n = $i - 1;

        // Ensure that the value is positive.
        if ($n >= 0) {
            // If crime going down.
            if ($table[$j][$i] < $table[$j][$n]) {
                return $table[$j][$i] . " <i style='color: green' class='fas fa-arrow-down'></i>";
            }

            // If crime is zero.
            if ($table[$j][$i] == 0) {
                return "";
            }

            // If crime is the same.
            if ($table[$j][$i] == $table[$j][$n]) {
                return $table[$j][$i] . " <i style='color: grey' class='fas fa-equals'></i>";
            }

            // If crime going up.
            if ($table[$j][$i] > $table[$j][$n]) {
                return $table[$j][$i] . " <i style='color: red' class='fas fa-arrow-up'></i>";
            }
        }

        // Return value anyways.
        return $table[$j][$i];
    }

    function changeDirectionCSS($table, $j, $i)
    {
        // Get the index of the value before.
        $n = $i - 1;

        // Ensure that the value is positive.
        if ($n >= 0) {
            // If crime going down.
            if ($table[$j][$i] < $table[$j][$n]) {
                return "alert-success";
            }

            // If crime is zero.
            if ($table[$j][$i] == 0) {
                return "alert-active";
            }

            // If crime is the same.
            if ($table[$j][$i] == $table[$j][$n]) {
                return "alert-warning";
            }

            // If crime going up.
            if ($table[$j][$i] > $table[$j][$n]) {
                return "alert-danger";
            }
        }

        // Return value anyways.
        return $table[$j][$i];
    }

    function splitDate($crimeDate)
    {
        // Split date into variables.
        list($crimeYear, $crimeMonth) = explode("-", $crimeDate);

        // Assign variables to new array.
        $crimeMonthYear = array($crimeMonth, $crimeYear);

        // Array of months.
        $monthOfYear = array(["01","January"],
        ["02","February"],
        ["03","March"],
        ["04","April"],
        ["05","May"],
        ["06","June"],
        ["07","July"],
        ["08","August"],
        ["09","September"],
        ["10","October"],
        ["11","November"],
        ["12","December"]);

        // For each month look for a match.
        if (count($monthOfYear) <= 12) {
            for ($i=0; $i < count($monthOfYear); $i++) {
                if ($crimeMonth == $monthOfYear[$i][0]) {

                  // Return month and year.
                  return $monthOfYear[$i][1] . " " . $crimeMonthYear[1];
                }
            }
        } else {
            die("Fatal Error: Incorrect Month Count");
        }
    }

    // Draw table.
    renderTimeSeriesTable($mysqli, $crimeTypeArray, $monthArray, $table);

    // Display Script End time
    $time_end = microtime(true);

    //dividing with 60 will give the execution time in minutes other wise seconds
    $execution_time = ($time_end - $time_start);

    //execution time of the script
    echo '<b>Total Execution Time:</b> ' . number_format($execution_time,4) . ' Seconds';
}
