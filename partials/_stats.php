<!-- Display Stats -->
<html>
<div id='resultStats'>
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

  <div id="carouselStatControls" class="carousel slide" data-ride="carousel" data-interval="5000">
    <ol class="carousel-indicators">
      <li data-target="#carouselStatControls" data-slide-to="0" class="active"></li>
      <li data-target="#carouselStatControls" data-slide-to="1"></li>
      <li data-target="#carouselStatControls" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <h3>Crimes</h3>
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
      </div>
      <div class="carousel-item">
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
      </div>
      <div class="carousel-item">
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
    </div>
    <a class="carousel-control-prev" href="#carouselStatControls" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" style='color: black;' aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselStatControls" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>

</div>
</html>
