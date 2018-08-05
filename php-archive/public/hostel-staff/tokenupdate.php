<?php
ob_start();
       require_once("../../includes/initialize.php");
       if(!$session->is_logged_in()){ redirect_to("login.php"); }
       include_layout_template('admin_header.php');
$tid= $database->escape_value($_POST['tid']);
$tstat= $database->escape_value($_POST['tstat']);
$tmsg= $database->escape_value($_POST['tmsg']);
$tstate= $database->escape_value($_POST['tstate']);

if($tstat!='custom')
{

$database->query("update token set t_status='$tstat', t_msg='$tmsg' where t_id='$tid'");
}
else{
$tstat=$tstat.'-'.$tstate;
$database->query("update token set t_status='$tstat', t_msg='$tmsg' where t_id='$tid'");
}

?>
