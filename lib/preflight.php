<?php
// Preflight
// Code to run on all pages.

if ($preflight == TRUE) {
  echo "Everything is great!";
}

if ($preflight == FALSE) {
  echo 'Please contact your system administrator';
}
?>
