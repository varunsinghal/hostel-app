<?php
require_once("../../../includes/initialize.php");



$query = "SELECT room_no, hostel FROM `available_room`";
$result = mysql_query($query) or die(mysql_error());
while($row = mysql_fetch_array($result)){
  $room_no=$row['room_no'];
  $hostel=$row['hostel'];
//  echo "<br />";
  $query2 = "SELECT COUNT(*) FROM `available_room` WHERE room_no='$room_no' AND hostel='$hostel'";
  $result1 = mysql_query($query2) or die(mysql_error());
  $reset=mysql_fetch_array($result1);
  $number = $reset['COUNT(*)'];
  echo $hostel." ".$room_no."<br />".$number."<br />";
  $sql = "UPDATE `available_room` SET `room_capacity`='$number' WHERE room_no='".$room_no."' AND `hostel`='$hostel'";
  echo $sql;
  $result2 = mysql_query($sql) or die(mysql_error());
  echo "<br />";
}


?>