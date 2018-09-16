<?php
//############## FUNCTION FILE #################################################
//############## Version Number ################################################
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

//############## INIT VALUE ####################################################
// Debug
$radVal1 = $radVal2 = $n = $mode = 0;
$JSONEnable = "TRUE";

//############## GET VALUES ####################################################
//############## Get Months ####################################################
function getMonths($mysqli)
{
    // SELECT All
    $query = "SELECT DISTINCT Month FROM data";
    $result = mysqli_query($mysqli, $query);

    // If Error
    if (!$result) {
        die('<p class="SQLError">Could not get month list: ' . mysqli_error($mysqli) . '</p>');
    }

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<option>" . $row['Month'] . "</option>";
        }
    } else {
      echo "<option disabled>No Data</option>";
    }
}

//############## COUNT THINGS ##################################################
//############## Count All Crimes ##############################################
function countAllCrimes($mysqli)
{
    // SELECT All
    $query = "SELECT count FROM stats WHERE stat = 'Crime Count'";
    $result = mysqli_query($mysqli, $query);
    $rows = mysqli_fetch_row($result);

    // If Error
    if (!$result) {
        die('<p class="SQLError">Could not run query: ' . mysqli_error($mysqli) . '</p>');
    }

    // Free Query
    mysqli_free_result($result);

    // Return Value.
    return number_format($rows[0]);
}

//############## Count All Crime Types #########################################
function countAllCrimeTypes($mysqli)
{
    // SELECT All
    $query = "SELECT count FROM stats WHERE stat = 'All Crime Types'";
    $result = mysqli_query($mysqli, $query);
    $rows = mysqli_fetch_row($result);

    // If Error
    if (!$result) {
        die('<p class="SQLError">Could not run query: ' . mysqli_error($mysqli) . '</p>');
    }

    // Free Query
    mysqli_free_result($result);

    // Return Value.
    return $rows[0];
}

//############## Count All Months ##############################################
function countAllMonth($mysqli)
{
    // SELECT All
    $query = "SELECT count FROM stats WHERE stat = 'Months worth of data'";
    $result = mysqli_query($mysqli, $query);
    $rows = mysqli_fetch_row($result);

    // If Error
    if (!$result) {
        die('<p class="SQLError">Could not run query: ' . mysqli_error($mysqli) . '</p>');
    }

    // Free Query
    mysqli_free_result($result);

    // Return Value.
    return $rows[0];
}

//############## Count No Locations ############################################
function countAllNoLocation($mysqli)
{
    // SELECT All
    $query = "SELECT count FROM stats WHERE stat = 'Crimes with no location'";
    $result = mysqli_query($mysqli, $query);
    $rows = mysqli_fetch_row($result);

    // If Error
    if (!$result) {
        die('<p class="SQLError">Could not run query: ' . mysqli_error($mysqli) . '</p>');
    }

    // Free Query
    mysqli_free_result($result);

    // Return Value.
    return $rows[0];
}

//############## Fall Within ###################################################
function countFallsWithin($mysqli)
{
    // SELECT All
    $query = "SELECT count FROM stats WHERE stat = 'Falls Within'";
    $result = mysqli_query($mysqli, $query);
    $rows = mysqli_fetch_row($result);

    // If Error
    if (!$result) {
        die('<p class="SQLError">Could not run query: ' . mysqli_error($mysqli) . '</p>');
    }

    // Free Query
    mysqli_free_result($result);

    // Return Value.
    return $rows[0];
}

//############## Fall Within ###################################################
function countReportedBy($mysqli)
{
    // SELECT All
    $query = "SELECT count FROM stats WHERE stat = 'Reported By'";
    $result = mysqli_query($mysqli, $query);
    $rows = mysqli_fetch_row($result);

    // If Error
    if (!$result) {
        die('<p class="SQLError">Could not run query: ' . mysqli_error($mysqli) . '</p>');
    }

    // Free Query
    mysqli_free_result($result);

    // Return Value.
    return $rows[0];
}

//############## SPLIT DATES ###################################################
function splitDate($crimeDate)
{
    list($crimeYear, $crimeMonth) = explode("-", $crimeDate);

    $crimeMonthYear = array($crimeMonth, $crimeYear);

    return $crimeMonthYear;
}

//############## JSON ##########################################################
//############## Immediate & Local #############################################
function JSONOutput($immediateCal, $radVal1)
{
    // Calculated Values JSON
    $crimeValObj = new \stdClass();
    $crimeValObj->LowLatitude   = $immediateCal[0];
    $crimeValObj->HighLatitude  = $immediateCal[1];
    $crimeValObj->LowLongitude  = $immediateCal[2];
    $crimeValObj->HighLongitude = $immediateCal[3];
    $crimeValObj->Radius1       = $radVal1;

    // JSON Encode
    $crimeImmediate = json_encode($crimeValObj);

    // Return Encoded JSON
    return $crimeImmediate;
}
?>
