<!-- Search Form -->
<form class="form dataForm alert-primary" action="lib/server.php" method="post">
<div class='row'>
  <!-- Latitude -->
  <div class='col form-group'>
    <label for="lat">Latitude</label>
    <input id='latBox' class="form-control" size='8' type="text" name="lat" value="52.1367078">
  </div>

  <!-- Longitude -->
  <div class='col form-group'>
    <label for="long">Longitude</label>
    <input id='longBox' class="form-control" size='8' type="text" name="long" value="-0.4688611">
  </div>

  <!-- Get GPS Locations -->
  <div class='col form-group'>
    <label for="gps">&nbsp</label>
    <button class="form-control btn btn-primary" type="button" onclick="getLocation()" name="gps"><i class="fas fa-location-arrow"></i> GPS</button>
  </div>

  <!-- Immediate Area -->
  <div class='col form-group'>
    <label for="rad1">Immediate</label>
    <input id='radius' class="form-control" size='3' type="text" name="rad1" value="0.005">
  </div>

  <!-- Local Area -->
  <div class='col form-group'>
    <label for="rad2">Local</label>
    <input id='radius2' class="form-control" size='3' type="text" name="rad2" value="0.02">
  </div>

  <!-- Month -->
  <div id='monthBlock' class='col form-group'>
    <label for="month">Month</label>
    <select class="form-control" name="month">
      <?php getMonths($mysqli) ?>
    </select>
  </div>

  <!-- Search Button -->
  <div class='col form-group'>
    <label>&nbsp</label>
    <button class="form-control btn btn-primary" type="submit" name="btnSearch"><i class="fas fa-search"></i> Search</button>
  </div>
</div>
</form>
