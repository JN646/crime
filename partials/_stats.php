<!-- Display Stats -->
<html>
<div id='resultStats'>
  <h3 class=''>Crime</h3>
  <!-- Stat Container -->
  <div class="statBox">
    <div class='row'>
      <?php
      $crime=array(
          'Crimes'=>callStat($mysqli, "'nCrimes'"),
          'No Locations'=>callStat($mysqli, "'nCrimesNoLoc'"),
          'Crime Types'=>callStat($mysqli, "'nCrimeTypes'"),
          'Months'=>callStat($mysqli, "'nMonths'"),
          //'Falls Within'=>callStat($mysqli, "'FallsWithin'"), // this is a shit stat
          'Reporting Constabularies'=>callStat($mysqli, "'ReportedBy'")
      );

      foreach ($crime as $key=>$value) {
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


  <h3 class=''>Boxes</h3>
  <!-- Stat Container -->
  <div class="statBox">
    <div class='row'>
      <?php
      $boxes=array(
          'Boxes'=>callStat($mysqli, "'nBoxes'"),
          'Active Boxes'=>callStat($mysqli, "'nBoxesActive'"),
          'NULL Boxes'=>callStat($mysqli, "'nBoxesNull'"),
          'Box Months'=>callStat($mysqli, "'nBoxmonths'")
      );

      foreach ($boxes as $key=>$value) {
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


  <h3 class=''>Other</h3>
  <!-- Stat Container -->
  <div class="statBox">
    <div class='row'>
      <?php
      $other=array(
          'Users'=>callStat($mysqli, "'nUsers'"),
          'Stats (inclusive)'=>callStat($mysqli, "'nStats'"),
          'Stats Last Update'=>callStat($mysqli, "'statsLastUpdate'")
      );

      foreach ($other as $key=>$value) {
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
</html>
