<?php

ob_start();

require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }


$hostel = $_GET['hostel_name'];

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=export.xls");
header("Pragma: no-cache");
header("Expires: 0");
if($hostel=='all'){
  $query = "SELECT roll_no,recipt,name,hostel,room_no,personal_phone FROM student NATURAL JOIN available_room NATURAL JOIN academic ORDER BY available_room.hostel ASC, available_room.room_no ASC";

}
else{
  $query = "SELECT roll_no,recipt,name,hostel,room_no,personal_phone FROM student NATURAL JOIN available_room  NATURAL JOIN academic WHERE available_room.hostel =  '$hostel' ORDER BY available_room.room_no";
}
//$query = "SELECT hostel,room_no,student_id,name,recipt FROM student NATURAL JOIN available_room WHERE available_room.hostel ='$hostel' ORDER BY available_room.room_no";

$result = mysql_query($query) or die(mysql_error());
while($row = mysql_fetch_row($result))
{
    //print_r($row);
    //echo '<hr /><hr />';
    $id = $row[0];
    $comma_separated = implode("@%", $row);
    //echo $comma_separated;
    //echo '<hr /><hr />';
    $comma_separated = trim($comma_separated);
    //echo $comma_separated;
    //echo '<hr /><hr />';
    $str = str_replace("@%", "\t", $comma_separated);
    $str .= "\t";
    //echo $str."\n";
    //exit;
    echo $str."\n";
}



if(isset($database)) { $database->close_connection(); }
ob_end_flush();

?>
