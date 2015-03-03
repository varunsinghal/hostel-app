<?php
ob_start();
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }

?>

<?php



if(!isset($_POST['room_id']) && !isset($_POST['room']) && !isset($_POST['hostel']))
{
  redirect_to("error.php?errno=1");
}



if(isset($_POST['room_id']))
{
  $room_id=$_POST['room_id'];
  $query2="DELETE FROM allotment_details WHERE room_id = '".$room_id."'";
  $resultof2=mysql_query($query2);
  $query3="DELETE FROM available_room WHERE id = '".$room_id."'";
  $resultof3=mysql_query($query3);
  echo '<center><font color="green"><b>Room Deleted Successfully</b></font></center>';
  log_action('Room Deleted', "Room with ID {$room_id} deleted  by {$session->user_name}.");
}

if(isset($_POST['room']) && isset($_POST['hostel']))
{
  $room_no=$_POST['room'];
  $hostel=$_POST['hostel'];

  $query2="DELETE FROM allotment_details WHERE room_no = '".$room_no."' AND hostel_name = '".$hostel."'";
  $resultof2=mysql_query($query2);
  $query3="DELETE FROM available_room WHERE room_no = '".$room_no."' AND hostel = '".$hostel."'";
  $resultof3=mysql_query($query3);
  echo '<center><font color="green"><b>Room Deleted Successfully</b></font></center>';
  log_action('Room Deleted', "{$hostel} - {$room_no} deleted  by {$session->user_name}.");
}




if(isset($database)) { $database->close_connection(); }
ob_end_flush();

?>