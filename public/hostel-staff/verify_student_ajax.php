<?php
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }

?>

<?php

$status = $_POST['status'];
$id = $_POST['formno'];

if($status == 0)
{
    $query = "UPDATE docu_submission SET document=1 WHERE student_id='$id' LIMIT 1";
    $result_set = mysql_query($query);
    echo '<center><font color="green"><b>Student Verified Successfully</b></font></center>';
    log_action('Student Details Verified', "Details of student with form number {$id} verified by {$session->user_name}.");
}

if($status == 1)
{
    $query = "UPDATE docu_submission SET document=0 WHERE student_id='$id' LIMIT 1";
    $result_set = mysql_query($query);
    echo '<center><font color="green"><b>Student</font> <font color="red">Un-Verified <font color="green">Successfully</b></font></center>';
    log_action('Student Details Un-Verified', "Details of student with form number {$id} un-verified by {$session->user_name}.");
}

?>