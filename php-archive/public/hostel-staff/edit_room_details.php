<?php
       ob_start();
       require_once("../../includes/initialize.php");
       if(!$session->is_logged_in()){ redirect_to("login.php"); }
       include_layout_template('admin_header.php');
?>


<br /><br /><br />
<h1 style="color:#ccc;">Edit Room Details</h1>


<?php

$room_no = $_REQUEST['room'];
$hostel = $_REQUEST['hostel'];

if(isset($_POST['submit']))
{
  $gender = $_POST['gender'];
  $new_capacity = $_POST['room_capacity'];
  $remarks = $_POST['remarks'];
  $sql = "UPDATE available_room SET room_capacity='$new_capacity', gender='$gender', remarks='$remarks' WHERE room_no='$room_no' AND hostel='$hostel'";
  $result1 = mysql_query($sql) or die(mysql_error());


  function change_room_capacity($room_no, $hostel)
  {
    global $new_capacity;
    global $gender;
    global $remarks;
    $sql1 = "SELECT COUNT(*) FROM available_room WHERE room_no='$room_no' AND hostel='$hostel'";
    $result2 = mysql_query($sql1) or die(mysql_error());
    $reset1=mysql_fetch_array($result2);
    $old_capacity = $reset1['COUNT(*)'];


    if($old_capacity > $new_capacity)
    {
      $sql = "DELETE FROM available_room WHERE room_no='$room_no' AND hostel='$hostel' LIMIT 1";
      $result1 = mysql_query($sql) or die(mysql_error());
      change_room_capacity($room_no, $hostel);
    }
    if($old_capacity < $new_capacity)
    {
      $sql = "INSERT INTO available_room (room_no, hostel, room_capacity, gender, alloted, remarks) VALUES ('$room_no','$hostel', '$new_capacity', '$gender', '0', '$remarks')";
      $result1 = mysql_query($sql) or die(mysql_error());
      change_room_capacity($room_no, $hostel);
    }
  }


  change_room_capacity($room_no, $hostel);

  log_action('Room Details Updated', "Details of {$hostel} - {$room_no} updated  by {$session->user_name}.");

  echo output_message("Room Details Updated Successfully.");

}


$query2 = "SELECT * FROM available_room WHERE room_no='$room_no' AND hostel='$hostel' LIMIT 1";
$result1 = mysql_query($query2) or die(mysql_error());
$reset=mysql_fetch_array($result1);




?>
<br /><Br />
<form action="<?php echo $_SERVER['PHP_SELF'].'?room='.$room_no.'&hostel='.$hostel; ?>" method="POST">
<table>
<tr><td>Room Number</td><td><?php echo $reset['room_no']; ?></td></tr>
<tr><td>Hostel</td><td><?php echo $reset['hostel']; ?></td></tr>
<tr><td>Gender</td><td><input type="text" name="gender" value="<?php echo $reset['gender']; ?>"></td></tr>
<tr><td>Room Capacity</td><td><input type="text" name="room_capacity" value="<?php echo $reset['room_capacity']; ?>"></td></tr>
<tr><td>Remarks</td><td><input type="text" name="remarks" value="<?php echo $reset['remarks']; ?>"></td></tr>
<tr><td></td><td><input type="submit" name="submit"></td></tr>
</table>
</form>




<?php include_layout_template('footer.php');
if(isset($database)) { $database->close_connection(); }
ob_end_flush();
?>