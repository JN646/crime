<?php
//############## SQL Connection ################################################
//database
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'crimes');

//get connection
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

 //If connection fail
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Global Variables.
define("LOCAL", "http://localhost/crime/"); //local URL
define("WEB", "http://192.168.1.72:80/crime/"); //website URL
$environment = LOCAL; //change to WEB if you're live

$boxHop = 0.5;
$boxSize = 0.7;
?>
