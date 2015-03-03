<?php

$id = $_GET['stuid'];
$distane_recieved = $_GET['distance_recieved'];

$query = "UPDATE distance_from_home SET distance=$distane_recieved ";
$result_set = mysql_query($query) or die(mysql_error());

header("Location: request_distance.php");

?>