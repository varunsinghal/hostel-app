<?php
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }

?>

<?php

$id=$_POST['form_no'];
$remark = $_POST['remark_rec'];
$remark = mysql_real_escape_string($remark);

if (!get_magic_quotes_gpc())
{
    $remark = addslashes($remark);
}

$query2 = "SELECT * FROM remarks WHERE student_id='$id'";
$result1 = mysql_query($query2) or die(mysql_error());
$reset=mysql_fetch_array($result1);
if(isset($reset['student_id'])){
    if($remark != "")
    {
	$query = "UPDATE remarks SET remarks = '$remark' WHERE student_id = '$id' LIMIT 1 ";
	$result_set = mysql_query($query) or die(mysql_error());
	echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remark.'</span></font> (last added : '.strftime("%Y-%m-%d %H:%M:%S", time()).')';
	log_action('Student Remark Changed', "Student with form number {$id} remarked by {$session->user_name}.");
    }
    else
    {
	$query = "DELETE FROM remarks WHERE student_id = '$id' LIMIT 1 ";
	$result_set = mysql_query($query) or die(mysql_error());
	echo '';
    }
}
else
{
    if($remark != "")
    {
	$query = "INSERT INTO remarks (student_id, remarks) VALUES ('$id', '$remark')";
	$result_set = mysql_query($query) or die(mysql_error());
	echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remark.'</span></font> (last added : '.strftime("%Y-%m-%d %H:%M:%S", time()).')';
	log_action('Student Remark Changed', "Student with form number {$id} remarked by {$session->user_name}.");
    }
    else
    {
	echo '';
    }
}


?>