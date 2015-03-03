<?php
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }

?>

<?php

$to_do = $_POST['to_do'];
$room_id = $_POST['room_id'];

if($to_do == 1) // set de-allot
{
    $query = "UPDATE available_room SET alloted = '0' WHERE id = '$room_id' LIMIT 1 ";
    $result_set = mysql_query($query) or die(mysql_error());
    echo '<span style="color:green;">SUCCESS</span>';
    log_action('Post Service Correction', "Room ID - {$room_id} set un - alloted by {$session->user_name}.");
}

if($to_do == 2) // set allot
{
    $query = "UPDATE available_room SET alloted = '1' WHERE id = '$room_id' LIMIT 1 ";
    $result_set = mysql_query($query) or die(mysql_error());
    echo '<span style="color:green;">SUCCESS</span>';
    log_action('Post Service Correction', "Room ID - {$room_id} set alloted by {$session->user_name}.");
}

?>