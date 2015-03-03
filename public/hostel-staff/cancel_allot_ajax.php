<?php
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }

?>

<?php

//final allotment of rooms
$form_no=$_POST['form_no'];

$query1="SELECT * FROM available_room WHERE student_id = '".$form_no."'";
$resultof1=mysql_query($query1) or die(mysql_error());
$cancelcheck=mysql_fetch_array($resultof1);
if(isset($cancelcheck['student_id']))
{
	$query2 = "UPDATE available_room SET alloted=0, student_id = 0 WHERE room_no='".$cancelcheck['room_no']."' AND hostel='".$cancelcheck['hostel']."' AND alloted=1 AND room_id='$cancelcheck[room_id]' LIMIT 1";
	$result_set = mysql_query($query2);
	echo '<center><font color="green"><b>Allotment Cancelled Successfully</b></font></center>';
	log_action('Student Allotment Cancelled', "Allotment of student (form number {$form_no}) cancelled  by {$session->user_name}. Room : {$cancelcheck['hostel']}, {$cancelcheck['room_no']}.");
}
else
{
      echo '<font color="red"><b><center>No room to cancel</center></b></font>';
}

?>
