<!-- Count Results -->
<div id='resultStats'>
  <h5 class=''>Statistics.</h5>

  <!-- Stat Container -->
  <div class="statBox">

    <!-- All Crimes -->
    <div class='statBlock'>
      <p class='outputText'><b>All Crimes: </b></p>
      <p><?php echo countAllCrimes($mysqli); ?></p>
    </div>

    <!-- All Crime Types -->
    <div class='statBlock'>
      <p class='outputText'><b>All Crime Types: </b></p>
      <p><?php echo countAllCrimeTypes($mysqli); ?></p>
    </div>

    <!-- Months Worth -->
    <div class='statBlock'>
      <p class='outputText'><b>Months worth of data: </b></p>
      <p><?php echo countAllMonth($mysqli); ?></p>
    </div>

    <!-- Crimes No Location -->
    <div class='statBlock'>
      <p class='outputText'><b>Crimes with no location: </b></p>
      <p><?php echo countAllNoLocation($mysqli); ?></p>
    </div>

    <!-- Falls Within -->
    <div class='statBlock'>
      <p class='outputText'><b>Falls Within: </b></p>
      <p><?php echo countFallsWithin($mysqli); ?></p>
    </div>

    <!-- Reported By -->
    <div class='statBlock'>
      <p class='outputText'><b>Reported By: </b></p>
      <p><?php echo countReportedBy($mysqli); ?></p>
    </div>
  </div>
</div>
