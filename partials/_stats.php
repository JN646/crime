<!-- Display Stats -->
<html>
<div id='resultStats'>
  <h3 class=''>Crime</h3>
  <?php
  // Crime Array
  $crime=array(
      'Crimes'=>callStat($mysqli, "'nCrimes'"),
      'No Locations'=>callStat($mysqli, "'nCrimesNoLoc'"),
      'Crime Types'=>callStat($mysqli, "'nCrimeTypes'"),
      'Months'=>callStat($mysqli, "'nMonths'"),
      //'Falls Within'=>callStat($mysqli, "'FallsWithin'"), // this is a shit stat
      'Reporting Constabularies'=>callStat($mysqli, "'ReportedBy'")
  );

  // Box Array
  $boxes=array(
      'Boxes'=>callStat($mysqli, "'nBoxes'"),
      'Active Boxes'=>callStat($mysqli, "'nBoxesActive'"),
      'NULL Boxes'=>callStat($mysqli, "'nBoxesNull'"),
      'Box Months'=>callStat($mysqli, "'nBoxmonths'")
  );

  // Other Array
  $other=array(
      'Users'=>callStat($mysqli, "'nUsers'"),
      'Stats (inclusive)'=>callStat($mysqli, "'nStats'"),
      'Stats Last Update'=>callStat($mysqli, "'statsLastUpdate'")
  );
  ?>

  <!-- Stat Container -->
  <div class="statBox">
    <div class='row'>
      <?php
      foreach ($crime as $key=>$value) {
          ?>
          <div class='col-md-3 statBox'>
            <div class="card">
              <h5 class="card-header text-center"><?php echo $key?></h5>
              <div class="card-body">
                <h3 class="card-subtitle text-center mb-2 text-muted"><?php echo $value?></h3>
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
      foreach ($boxes as $key=>$value) {
          ?>
          <div class='col-md-3 statBox'>
            <div class="card">
              <h5 class="card-header text-center"><?php echo $key?></h5>
              <div class="card-body">
                <h3 class="card-subtitle text-center mb-2 text-muted"><?php echo $value?></h3>
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
      foreach ($other as $key=>$value) {
          ?>
          <div class='col-md-3 statBox'>
            <div class="card">
              <h5 class="card-header text-center"><?php echo $key?></h5>
              <div class="card-body">
                <h3 class="card-subtitle text-center mb-2 text-muted"><?php echo $value?></h3>
              </div>
            </div>
          </div>
      <?php
      } ?>
    </div>
  </div>

</div>
</html>
