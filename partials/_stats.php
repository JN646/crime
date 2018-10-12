<!-- Count Results -->
<div id='resultStats'>
  <h3 class=''>Statistics</h3>

  <!-- Stat Container -->
  <div class="statBox">

    <!-- All Crimes -->
    <div class='row'>

      <?php
      $dd=array(
          'Crimes'=>callStat($mysqli, "'nCrimes'"),
          'No Locations'=>callStat($mysqli, "'nCrimesNoLoc'"),
          'Crime Types'=>callStat($mysqli, "'nCrimeTypes'"),
          'Months'=>callStat($mysqli, "'nMonths'"),
          //'Falls Within'=>callStat($mysqli, "'FallsWithin'"), // this is a shit stat
          'Reporting Constabularies'=>callStat($mysqli, "'ReportedBy'"),
          'Boxes'=>callStat($mysqli, "'nBoxes'"),
          'Active Boxes'=>callStat($mysqli, "'nBoxesActive'"),
          'NULL Boxes'=>callStat($mysqli, "'nBoxesNull'"),
          'Box Months'=>callStat($mysqli, "'nBoxmonths'"),
          'Users'=>callStat($mysqli, "'nUsers'"),
          'Stats (inclusive)'=>callStat($mysqli, "'nStats'"),
          'Stats Last Update'=>callStat($mysqli, "'statsLastUpdate'")
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
