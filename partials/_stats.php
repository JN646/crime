<!-- Count Results -->
<div id='resultStats'>
  <h3 class=''>Statistics</h3>

  <!-- Stat Container -->
  <div class="statBox">

    <!-- All Crimes -->
    <div class='row'>

      <?php
      $dd=array(
          'All Crimes'=>callStat($mysqli, "'nCrimes'"),
          'All Crime Types'=>callStat($mysqli, "'nCrimeTypes'"),
          'All Months'=>callStat($mysqli, "'nMonths'"),
          'No Locations'=>callStat($mysqli, "'nCrimesNoLoc'"),
          'Falls Within'=>callStat($mysqli, "'FallsWithin'"),
          'Reported By'=>callStat($mysqli, "'ReportedBy'"),
          'Boxes'=>callStat($mysqli, "'nBoxes'"),
          'Active Boxes'=>callStat($mysqli, "'nBoxesActive'"),
          'NULL Activations'=>callStat($mysqli, "'nBoxesNull'")
      );

      foreach ($dd as $key=>$value) {
          ?>
          <div class='col-md-3 statBox'>
            <div class="card">
              <div class="card-body">
                <h5 class="card-title text-center"><?php echo $key?></h5>
                <h6 class="card-subtitle text-center mb-2 text-muted"><?php echo $value?></h6>
              </div>
            </div>
          </div>
      <?php
      } ?>
    </div>
  </div>
</div>
