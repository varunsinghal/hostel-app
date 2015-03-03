<?php
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }
?>


<?php


$id = $_POST['q'];
$query2 = "DELETE FROM academic WHERE student_id=".$id." LIMIT 1";
$result1 = mysql_query($query2);
$query2 = "DELETE FROM docu_submission WHERE student_id=".$id." LIMIT 1";
$result1 = mysql_query($query2);
$query2 = "DELETE FROM permanent_address WHERE student_id=".$id." LIMIT 1";
$result1 = mysql_query($query2);
$query2 = "DELETE FROM present_address WHERE student_id=".$id." LIMIT 1";
$result1 = mysql_query($query2);
$query2 = "DELETE FROM remarks WHERE student_id=".$id." LIMIT 1";
$result1 = mysql_query($query2);
$query2 = "DELETE FROM distance_from_home WHERE student_id=".$id." LIMIT 1";
$result1 = mysql_query($query2);
$query2 = "SELECT * FROM available_room WHERE student_id=".$id;
$result1 = mysql_query($query2);
$fetch1 = mysql_fetch_array($result1);
$query2 = "UPDATE available_room SET alloted=0 WHERE id='".$fetch1['room_id']."' LIMIT 1";
$result1 = mysql_query($query2);
$query2 = "DELETE FROM student WHERE student_id=".$id." LIMIT 1";
$result1 = mysql_query($query2);

if($result1){
    echo "<tr><td colspan=7><center><b><font color='red'>DELETED</font></b></center></td></tr>";
    log_action('Student Details Deleted', "Student with form number {$id} deleted by {$session->user_name}.");
}
else {
    echo "<center><b><font color='red'>Some error occoured. Please refrest the page ang start all over again.</font></b></center>";
}

?>
