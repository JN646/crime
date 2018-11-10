<?php
// Preflight
// Code to run on all pages.


// Output Messages
if ($preflight == TRUE) {
  echo "<p id='preNotification' class='alert alert-success text-center'>PREFLIGHT: Everything is great!</p>";
}

if ($preflight == FALSE) {
  echo "<p id='preNotification' class='alert alert-danger text-center'>PREFLIGHT: Please contact your system administrator.</p>";
}
?>

<script>
// Hide Preflight Message after time.
setTimeout(function() {
    $('#preNotification').fadeOut('slow');
}, 1000); // <-- time in milliseconds
</script>
