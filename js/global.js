//############## GLOBAL JS #####################################################
//############## Location GPS ##################################################
// Get Boxes to put coordinates in.
var latBoxVal = document.getElementById("latBox");
var longBoxVal = document.getElementById("longBox");

// Get location
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition,showError);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

// Put information in lat/Long boxes.
function showPosition(position) {
    latBoxVal.value = position.coords.latitude;
    longBoxVal.value = position.coords.longitude;
}

// Handle Errors
function showError(error) {
    switch(error.code) {
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
