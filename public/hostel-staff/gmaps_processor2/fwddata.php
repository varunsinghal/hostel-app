<?php
ob_start();
require_once("../../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }

$id = $_GET['i'];
$distane_recieved = $_GET['d'];

$query = "UPDATE distance_from_home SET distance=$distane_recieved WHERE student_id='$id' LIMIT 1 ";
$result_set = mysql_query($query) or die(mysql_error());

header("Location: ../request_distance_unprecise.php");
ob_end_flush();
?>