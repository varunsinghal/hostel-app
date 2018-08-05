<?php
       ob_start();
       require_once("../../../includes/initialize.php");
error_reporting(E_ALL);
echo '<pre>';


$sql2 = "SELECT * FROM  `dtuac_hostel-app2`.`available_room` ORDER BY `dtuac_hostel-app2`.`available_room`.`id` ASC";

$result2 = mysql_query($sql2) or die(mysql_error());

while ($row2 = mysql_fetch_array($result2))
{
		$id = $row2['id'];
		$sql1 = "SELECT * FROM  `dtuac_hostel-app`.`available_room` WHERE `dtuac_hostel-app`.`available_room`.`id`='$id'";
		$result1 = mysql_query($sql1) or die(mysql_error());
		$row1 = mysql_fetch_array($result1);
		if(($row2['alloted'] == $row1['alloted']) && ($row2['alloted'] !=0)) {
      echo $row2['id'].' . '.$row2['room_no'].' '.$row2['hostel'].' | '.$row1['id'].' . '.$row1['room_no'].' '.$row1['hostel'].'<br />';
      }

}