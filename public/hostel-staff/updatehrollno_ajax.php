<?php
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }

?>

<?php

$id=$_POST['form_no'];
$rollno = $_POST['rollno_rec'];
$rollno = mysql_real_escape_string($rollno);

if (!get_magic_quotes_gpc())
{
    $rollno = addslashes($rollno);
}

$query2 = "SELECT * FROM student WHERE student_id='$id'";
$result1 = mysql_query($query2) or die(mysql_error());
$reset=mysql_fetch_array($result1);
$query = "UPDATE student SET recipt = '$rollno' WHERE student_id = '$id' LIMIT 1 ";
$result_set = mysql_query($query) or die(mysql_error());
echo '<center><font color="green"><b>Hostel Roll Number Updated Successfully</b></font></center>';
log_action('Student Hostel Roll No Updated', "Hostel roll number of student with form number {$id} updated by {$session->user_name}.");


?>