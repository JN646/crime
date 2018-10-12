<!-- Count Results -->
<div id='resultStats'>
  <h3 class=''>Statistics</h3>

  <!-- Stat Container -->
  <div class="statBox">

    <!-- All Crimes -->
    <div class='row'>

      <?php
      $dd=array(
          'All Crimes'=>callStat($mysqli, "'Crime Count'"),
          'All Crime Types'=>callStat($mysqli, "'All Crime Types'"),
          'All Months'=>callStat($mysqli, "'All Months'"), //doesn't exist in stats
          'No Locations'=>callStat($mysqli, "'No Locations'"), //doesn't exist in stats
          'Falls Within'=>callStat($mysqli, "'Falls Within'"),
          'Reported By'=>callStat($mysqli, "'Reported By'"),
          'Boxes'=>callStat($mysqli, "'All Boxes'"),
          'Active Boxes'=>callStat($mysqli, "'Active Boxes'"),
          'NULL Activations'=>callStat($mysqli, "'NULL Boxes'")
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
