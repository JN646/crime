//############## GLOBAL JS #####################################################
//############## Debug #########################################################
console.log('Global JS Loaded.');

//############## Location GPS ##################################################
// Get Boxes to put coordinates in.
var latBoxVal = document.getElementById("latBox");
var longBoxVal = document.getElementById("longBox");

// Get location
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition, showError);
  } else {
    alert("Geolocation is not supported by this browser.");
  }
}

// Put information in lat/Long boxes.
function showPosition(position) {
  latBoxVal.value = position.coords.latitude;
  longBoxVal.value = position.coords.longitude;
}

// Get location
function getLocationGPS() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPositionGPS, showError);
  } else {
    alert("Geolocation is not supported by this browser.");
  }
}

// Put information in lat/Long boxes.
function showPositionGPS(position) {
  latBoxVal.value = position.coords.latitude;
  longBoxVal.value = position.coords.longitude;
}

// Handle Errors
function showError(error) {
  switch (error.code) {
    case error.PERMISSION_DENIED:
      alert("User denied the request for Geolocation.")
      break;
    case error.POSITION_UNAVAILABLE:
      alert("Location information is unavailable.")
      break;
    case error.TIMEOUT:
      alert("The request to get user location timed out.")
      break;
    case error.UNKNOWN_ERROR:
      alert("An unknown error occurred.")
      break;
  }
}

//############## TOGGLE RISK SLIDER ############################################
function toggleRiskSlider() {
  // Toggle Column
  $('.riskGraphicCol').toggle();
}

//############## TOGGLE RISK SLIDER ############################################
function toggleRiskFactor() {
  // Toggle Column
  $('.riskCol').toggle();
}

//############## TABLE SORT ####################################################
function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTable2");
  switching = true;
  // Set the sorting direction to ascending:
  dir = "asc";
  /* Make a loop that will continue until no switching has been done: */
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /* Loop through all table rows (except the first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare, one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /* Check if the two rows should switch place, based on the direction, asc or desc: */
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      // Each time a switch is done, increase this count by 1:
      switchcount++;
    } else {
      /* If no switching has been done AND the direction is "asc", set the direction to "desc" and run the while loop again. */
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}

// Check if form values are empty.
if (document.getElementById('inputForm')) {
  // Basic Validation.
  var notification = document.getElementById('notificationSearch');
  var btnSearch = document.getElementById('btnSearch');
  var inputLat = document.getElementById('latBox');
  var inputLong = document.getElementById('longBox');
  var inputRadius = document.getElementById('radius');
  var inputRadius2 = document.getElementById('radius2');
}

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
