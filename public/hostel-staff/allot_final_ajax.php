<?php


/*

This file is for ajax use only. This file takes in values and allots room and return data using ajax.
If only student id is passed then it shows the available hostels.
If both student id and hostel name is passed then it shows available room.
Finally submit link allots the room. Is passes all 3 variables required.


*/



// initialization
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }

?>

<?php

// receiving values
$form_no=$_POST['form_no'];
$room_no=$_POST['room_no'];
$hostel=$_POST['hostel'];

// if no value passed then error message shown
if(empty($room_no)|| empty($form_no))
{
	echo '<center><font color="red"><b>The field for room or form no. is empty!</b></font></center>';
	exit;
}


// removed this part. cuz forgot its purpose :P
//if ( preg_match( '/\W/', $room_no ) )
//{
//	echo '<center><font color="red"><b>Error! Refresh and try again.</b></font></center>';
//	exit;
//}


// check if room is already alloted to this student
$query1="SELECT student_id,room_no,hostel FROM available_room";
$check=mysql_query($query1);
while($fetch=mysql_fetch_array($check))
{
	if($form_no==$fetch['student_id'])
	{
		echo '<center><font color="red"><b>Room has already been alloted to this student</b></font></center>';
		exit;
	}
}



// select a room from the pool of available rooms and the input by user
$query1= "SELECT room_id FROM available_room WHERE alloted=0 AND room_no='$room_no' AND hostel='$hostel' LIMIT 1";
$check=mysql_query($query1);
$fetch=mysql_fetch_array($check);

$room_id = $fetch['room_id']; // store id of found room



$query1="SELECT alloted FROM available_room WHERE room_id='$room_id'";
$check=mysql_query($query1);
while($fetch=mysql_fetch_array($check))
{
	if($fetch['alloted']>0)
	{
		echo '<center><font color="red"><b>This room has already been alloted to someone else.</b></font></center>';
		exit;
	}
}
// allotment of room
// change in available_room
$query="UPDATE available_room SET alloted=1, student_id='$form_no' WHERE room_id='$room_id' LIMIT 1";
$push=mysql_query($query);

// log the action
log_action('Student Allotted Room', "Student with form number {$form_no} allotted {$hostel}, {$room_no} by {$session->user_name}.");

if (!$push)
die("Database query failed: " . mysql_error());
else
{
	echo '<center><font color="green"><b>Room alloted successfully. '.$hostel.', '.$room_no.'</b></font></center>';
	exit;
}
?>
