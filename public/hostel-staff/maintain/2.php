<?php
       ob_start();
       require_once("../../../includes/initialize.php");
       if(!$session->is_logged_in()){ redirect_to("login.php"); }



$sql = "SELECT *
FROM  `available_room`
WHERE  `room_no` LIKE  '%.'";

$result1 = mysql_query($sql) or die(mysql_error());

while ($row1 = mysql_fetch_array($result1))
{

      print_r($row1);
  echo "<hr />";

}