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
$radVal1 = 0;
$radVal2 = 0;
$n = 0;

//############## GET VALUES ####################################################
// Get Months
function getMonths()
{
    $monthVariables = ["January","Feburary","March","April","May","June","July","August","September","October","November","December"];
    for ($i=0; $i < count($monthVariables) ; $i++) {
        ?>
      <option value="<?php echo $monthVariables[$i] ?>"><?php echo $monthVariables[$i] ?></option>
<?php
    }
}

// Get Years
function getYears()
{
    $yearVariables = ["2018","2017","2016"];
    for ($i=0; $i < count($yearVariables) ; $i++) {
        ?>
      <option value="<?php echo $yearVariables[$i] ?>"><?php echo $yearVariables[$i] ?></option>
<?php
    }
}

// Get Years
function getCrimes()
{
    $crimeVariables = ["Drugs","Burglary","Criminal damage and arson","Anti-social behaviour","Other theft","Violence and sexual offences","Vehicle crime","Bicycle theft","Shoplifting","Public order","Other crime","Theft from the person","Robbery","Possession of weapons"];
    for ($i=0; $i < count($crimeVariables) ; $i++) {
        ?>
      <option value="<?php echo $crimeVariables[$i] ?>"><?php echo $crimeVariables[$i] ?></option>
<?php
    }
}
?>
