<?php
       require_once("../../includes/initialize.php");
       if(!$session->is_logged_in()){ redirect_to("login.php"); }
?>


<?php

$status = $_POST['status'];
if($status == '1')
{
       $query = "UPDATE control_variables SET flag =1 WHERE control = 'reallotment' LIMIT 1 ";
       $result_set = mysql_query($query) or die(mysql_error());
       log_action('Re-allotment Status Changed', "Online Re-allotment of students started by {$session->user_name}");
}
else
{
       $query = "UPDATE control_variables SET flag =0 WHERE control = 'reallotment' LIMIT 1 ";
       $result_set = mysql_query($query) or die(mysql_error());
       log_action('Re-allotment Status Changed', "Online Re-allotment of students closed by {$session->user_name}");
}

?>