<!-- Search Form -->
<form id='inputForm' class="form dataForm alert-primary" action="output.php" method="post">
  <p id='notificationSearch' class='alert alert-danger' style='display: none;'>All fields must have a value.</p>
<div class='row'>
  <!-- Latitude -->
  <div class='col form-group'>
    <label for="lat">Latitude</label>
    <input id='latBox' class="form-control" onkeydown="checkEmpty()" size='8' type="number" step="0.0000001" name="lat" value="52.1367078">
  </div>

  <!-- Longitude -->
  <div class='col form-group'>
    <label for="long">Longitude</label>
    <input id='longBox' class="form-control" onkeydown="checkEmpty()" size='8' type="number" step="0.0000001" name="long" value="-0.4688611">
  </div>

  <!-- Get GPS Locations -->
  <div class='col form-group'>
    <label for="gps">&nbsp</label>
    <button class="form-control btn btn-primary" type="button" onclick="getLocation()" name="gps"><i class="fas fa-location-arrow"></i> GPS</button>
  </div>

  <!-- Immediate Area -->
  <div class='col form-group'>
    <label for="rad1">Immediate</label>
    <input id='radius' class="form-control" onkeydown="checkEmpty()" size='3' type="number" step="0.0000001" name="rad1" value="0.005">
  </div>

  <!-- Local Area -->
  <div class='col form-group'>
    <label for="rad2">Local</label>
    <input id='radius2' class="form-control" onkeydown="checkEmpty()" size='3' type="number" step="0.0000001" name="rad2" value="0.02">
  </div>

  <!-- Mode -->
  <div id='modeBlock' class='col form-group'>
    <label for="mode">Mode</label>
    <select class="form-control" name="mode">
      <option value="0">Crime Counter</option>
      <option value="1">Time Series</option>
    </select>
  </div>

  <!-- Search Button -->
  <div class='col form-group'>
    <label>&nbsp</label>
    <button id="btnSearch" class="form-control btn btn-primary" type="submit" name="btnSearch"><i class="fas fa-search"></i> Search</button>
  </div>
</div>
</form>

<!-- Basic Validation -->
<script type="text/javascript">
  // Basic Validation.
  var notification = document.getElementById('notificationSearch');
  var btnSearch = document.getElementById('btnSearch');
  var inputLat = document.getElementById('latBox');
  var inputLong = document.getElementById('longBox');
  var inputRadius = document.getElementById('radius');
  var inputRadius2 = document.getElementById('radius2');

  // Check if empty.
  function checkEmpty() {
    if (inputLat.value == "" || inputLong.value == "" || inputRadius.value == "" || inputRadius2.value == "") {
      // Hide button.
      btnSearch.style.display = "none";
      // Show error message.
      notificationSearch.style.display = "";
    } else {
      // Show button.
      btnSearch.style.display = "";
      // Hide error message.
      notificationSearch.style.display = "none";
    }
  }
</script>
