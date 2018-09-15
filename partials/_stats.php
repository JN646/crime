<!-- Count Results -->
<div id='resultStats'>
  <h3 class=''>Statistics</h3>

  <!-- Stat Container -->
  <div class="statBox">

    <!-- All Crimes -->
    <div class='row'>
      <div class='col-md-3 statBox'>
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-center">All Crimes</h5>
            <h6 class="card-subtitle text-center mb-2 text-muted"><?php echo countAllCrimes($mysqli); ?></h6>
          </div>
        </div>
      </div>

      <!-- All Crime Types -->
      <div class='col-md-3 statBox'>
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-center">All Crime Types</h5>
            <h6 class="card-subtitle text-center mb-2 text-muted"><?php echo countAllCrimeTypes($mysqli); ?></h6>
          </div>
        </div>
      </div>

      <!-- Months Worth -->
      <div class='col-md-3 statBox'>
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-center">Months worth of data</h5>
            <h6 class="card-subtitle text-center mb-2 text-muted"><?php echo countAllMonth($mysqli); ?></h6>
          </div>
        </div>
      </div>

      <!-- Crimes No Location -->
      <div class='col-md-3 statBox'>
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-center">Crimes with no location</h5>
            <h6 class="card-subtitle text-center mb-2 text-muted"><?php echo countAllNoLocation($mysqli); ?></h6>
          </div>
        </div>
      </div>

      <!-- Falls Within -->
      <div class='col-md-3 statBox'>
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-center">Falls Within</h5>
            <h6 class="card-subtitle text-center mb-2 text-muted"><?php echo countFallsWithin($mysqli); ?></h6>
          </div>
        </div>
      </div>

      <!-- Reported By -->
      <div class='col-md-3 statBox'>
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-center">Reported By</h5>
            <h6 class="card-subtitle text-center mb-2 text-muted"><?php echo countReportedBy($mysqli); ?></h6>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
