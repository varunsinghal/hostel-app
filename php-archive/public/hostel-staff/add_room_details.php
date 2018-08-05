<?php
       ob_start();
       require_once("../../includes/initialize.php");
       if(!$session->is_logged_in()){ redirect_to("login.php"); }
       include_layout_template('admin_header.php');
?>


<br /><br /><br />
<h1 style="color:#ccc;">Add Room</h1>


<?php

if(isset($_POST['submit']))
{
  $room_capacity = $_POST['room_capacity'];
  for($i=0; $i < $room_capacity; ++$i)
  {
    $room_no = $_POST['room_no'];
    $hostel = $_POST['hostel'];
    $gender = $_POST['gender'];
    $remarks = $_POST['remarks'];
    $sql = "INSERT INTO available_room (room_no,room_capacity,hostel,gender,remarks) VALUES ('$room_no', '$room_capacity', '$hostel', '$gender', '$remarks')";
    $result1 = mysql_query($sql) or die(mysql_error());
  }

  echo output_message("Room Added Successfully.");

}




?>
<br /><Br />
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
<table>
<tr><td>Room Number</td><td><input type="text" name="room_no"></td></tr>
<tr><td>Hostel</td><td>
<select name="hostel">
<?php

$sql1 = "SELECT DISTINCT hostel FROM available_room";
$result2 = mysql_query($sql1) or die(mysql_error());
while($reset1=mysql_fetch_array($result2))
{
  echo "<option value=".$reset1['hostel'].">".$reset1['hostel']."</option>";
}

?>
</select></td></tr>
<tr><td>Gender</td><td><input type="radio" name="gender" value="male" > : Male <input type="radio" name="gender" value="female" > : Female</td></tr>
<tr><td>Room Capacity</td><td><input type="text" name="room_capacity" ></td></tr>
<tr><td>Remarks</td><td><input type="text" name="remarks" ></td></tr>
<tr><td></td><td><input type="submit" name="submit"></td></tr>
</table>
</form>




<?php include_layout_template('footer.php');
if(isset($database)) { $database->close_connection(); }
ob_end_flush();
?>