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
$safety = "safe";
$monthVal = "January";
$yearVal = "2018";
$radVal1 = $radVal2 = $n = 0;

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
            ?>
          <option><?php echo $row['Month']; ?></option>
        <?php
        }
    } else {
        ?>
      <option disabled>Fail</option>
    <?php
    }
}

//############## COUNT THINGS ##################################################
//############## Count All Crimes ##############################################
function countAllCrimes($mysqli)
{
    // SELECT All
    $query = "SELECT COUNT(*) FROM data";
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
    $query = "SELECT COUNT(DISTINCT(CRIME_Type)) FROM data";
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
    $query = "SELECT COUNT(DISTINCT(Month)) FROM data";
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
    $query = "SELECT COUNT(DISTINCT(ID)) FROM data WHERE Longitude = 0 AND Latitude = 0";
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
    $query = "SELECT COUNT(DISTINCT(Falls_Within)) FROM data";
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
    $query = "SELECT COUNT(DISTINCT(Reported_By)) FROM data";
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

//############## COLOUR RISK ###################################################
function colourRisk($risk) {
  $riskVal = $risk;

  return "rgb(" . GreenYellowRed($riskVal) . ")";
}

function GreenYellowRed($number) {
  $number--; // working with 0-99 will be easier

  if ($number < 50) {
    // green to yellow
    $r = floor(255 * ($number / 50));
    $g = 255;

  } else {
    // yellow to red
    $r = 255;
    $g = floor(255 * ((50-$number%50) / 50));
  }
  $b = 0;

  return "$r,$g,$b";
}

?>
