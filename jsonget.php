<?php
$json = file_get_contents('lib/data.php');
$obj = json_decode($json);
echo $obj->Crime_Type;
?>
