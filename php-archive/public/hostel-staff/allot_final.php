<?php
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }
include_layout_template('admin_header.php'); ?>

<?php

//final allotment of rooms
$form_no=$_POST['form_no'];
$room_no=$_POST['room_no'];
$hostel_name=$_POST['hostel'];
if(empty($room_no)||empty($form_no))
{
	echo '<center><font color="red"><b>The field for room or form no. is empty!</b></font></center>';
	exit;
}
if ( preg_match( '/\W/', $room_no ) )
{
	echo '<center><font color="red"><b>Error! Refresh and try again.</b></font></center>';
	exit;
}
$query1="SELECT student_id,room_no,hostel_name FROM allotment_details";
$check=mysql_query($query1);
while($fetch=mysql_fetch_array($check))
{
	if($form_no==$fetch['student_id'])
	{
		echo '<center><font color="red"><b>Room has already been alloted to this student</b></font></center>';
		exit;
	}
	
	if(($hostel_name==$fetch['hostel_name'])&&($room_no==$fetch['room_no']))
	{
		echo '<center><font color="red"><b>Room is Already Alloted to some one else.</b></font></center>';
		exit;
	}
}

$query="UPDATE available_room SET alloted=1 WHERE room_no='$room_no' AND hostel='$hostel_name' AND alloted=0 LIMIT 1";
$push=mysql_query($query);
$query = "INSERT INTO allotment_details (student_id,room_no,hostel_name) VALUES ('$form_no','$room_no','$hostel_name') ";
$result_set = mysql_query($query);
log_action('Student Allotted Room', "Student with form number {$form_no} allotted {$hostel_name}, {$room_no} by {$session->user_name}.");

if (!$result_set)
die("Database query failed: " . mysql_error());
else
{
	echo '<center><font color="green"><b>Room alloted successfully</b></font></center>';
	exit;
}
?>

<?php include_layout_template('admin_footer.php'); ?>