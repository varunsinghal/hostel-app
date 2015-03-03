<?php
       require_once("../../includes/initialize.php");
       if(!$session->is_logged_in()){ redirect_to("login.php"); }
?>


<?php

$status = $_POST['status'];
if($status == '1')
{
       $query = "UPDATE control_variables SET flag =1 WHERE control = 'allotment_status' LIMIT 1 ";
       $result_set = mysql_query($query) or die(mysql_error());
       log_action('Allotment Status Changed', "Allotment status of students made live by {$session->user_name}");
}
else
{
       $query = "UPDATE control_variables SET flag =0 WHERE control = 'allotment_status' LIMIT 1 ";
       $result_set = mysql_query($query) or die(mysql_error());
       log_action('Allotment Status Changed', "Allotment status of students made closed by {$session->user_name}");
}

?>