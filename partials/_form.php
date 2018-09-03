<!-- Search Form -->
<form class="form-layout" action="lib/server.php" method="post">
  <!-- Latitude -->
  <div class='form-block'>
    <label for="lat">Latitude</label>
    <input id='latBox' size='8' type="text" name="lat" value="52.122123">
  </div>

  <!-- Longitude -->
  <div class='form-block'>
    <label for="long">Longitude</label>
    <input id='longBox' size='8' type="text" name="long" value="-0.586406">
  </div>

  <!-- Get GPS Locations -->
  <div class='form-block'>
    <label for="gps"></label>
    <button type="button" onclick="getLocation()" name="gps"><i class="fas fa-location-arrow"></i></button>
  </div>

  <!-- Immediate Area -->
  <div class='form-block'>
    <label for="rad1">Immediate Area</label>
    <input id='radius' size='3' type="text" name="rad1" value="0.02">
  </div>

  <!-- Local Area -->
  <div class='form-block'>
    <label for="rad2">Local Area</label>
    <input id='radius2' size='3' type="text" name="rad2" value="0.05">
  </div>

  <!-- Month -->
  <div class='form-block'>
    <label for="month">Month</label>
    <select class="" name="month">
      <?php getMonths() ?>
    </select>
  </div>

  <!-- Year -->
  <div class='form-block'>
    <label for="year">Year</label>
    <select class="" name="year">
    <?php getYears() ?>
    </select>
  </div>

  <!-- Year -->
  <div class='form-block'>
    <label for="crime">Crime</label>
    <select class="" name="crime">
    <?php getCrimes() ?>
    </select>
  </div>

  <!-- Search Button -->
  <div class='form-block'>
    <label for="btnSearch"></label>
    <button type="submit" name="btnSearch"><i class="fas fa-search"></i></button>
  </div>
</form>
