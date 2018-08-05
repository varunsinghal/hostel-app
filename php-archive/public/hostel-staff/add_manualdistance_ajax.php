<?php
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }

ob_start();

?>

<?php


if(!isset($_POST['form_no']) || !isset($_POST['distance_rec']))
{
  redirect_to("error.php?errno=1");
}


$id=$_POST['form_no'];
$distance_rec = $_POST['distance_rec'];
$distance_rec = mysql_real_escape_string($distance_rec);

if (!get_magic_quotes_gpc())
{
    $distance_rec = addslashes($distance_rec);
}

$query = "UPDATE distance_from_home SET distance = '$distance_rec' WHERE student_id = '$id' LIMIT 1 ";
$result_set = mysql_query($query) or die(mysql_error());
echo '<span id="distancefield_'.$id.'">'.$distance_rec.'</span>&nbsp;Km&nbsp;&nbsp;<a href="javascript:void(0);" onClick="editDistance('.$id.')">Edit</a></td>';
log_action('Student Distance from Home Updated', "Distance from Home of Student with form number {$id} updated by {$session->user_name}.");

ob_end_flush();
if(isset($database)) { $database->close_connection(); }


?>