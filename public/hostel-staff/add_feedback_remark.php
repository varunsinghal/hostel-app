<?php
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }

?>

<?php

$id=$_POST['feedback_no'];
$time = strftime("%Y-%m-%d %H:%M:%S", time());
$remark = $_POST['remark_rec'];
$remark = mysql_real_escape_string($remark);

if (!get_magic_quotes_gpc())
{
    $remark = addslashes($remark);
}

$query2 = "SELECT * FROM feedback WHERE feedback_id='$id'";
$result1 = mysql_query($query2) or die(mysql_error());
$reset=mysql_fetch_array($result1);
if(isset($reset['feedback_id'])){
	if($remark != "")
    {
	$query = "UPDATE feedback SET remarks = '$remark', remark_time = '$time'  WHERE feedback_id = '$id' LIMIT 1 ";
	$result_set = mysql_query($query) or die(mysql_error());
	echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remark.'</span></font> (last added : '.strftime("%Y-%m-%d %H:%M:%S", time()).')';
	log_action('Feedback System: Remark Changed', "Feedback with form number {$id} remarked by {$session->user_name}.");
	}
	else{
		$query = "UPDATE feedback SET remarks = '$remark', remark_time = '$time'  WHERE feedback_id = '$id' LIMIT 1 ";
		$result_set = mysql_query($query) or die(mysql_error());
		echo '';
		log_action('Feedback System: Remark deleted', "Feedback with form number {$id} remarked by {$session->user_name}.");
	}
}

?>