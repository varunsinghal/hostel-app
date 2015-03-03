<?php
       require_once("../../includes/initialize.php");
       if(!$session->is_logged_in()){ redirect_to("login.php"); }
       include_layout_template('admin_header.php');
       ini_set('max_execution_time', 1200); //1200 seconds = 20 minutes
?>
<?php 
$query = mysql_query("select student_id, branch, sem from academic");
while($row = mysql_fetch_array($query)){
$array = explode(',', $row['branch']);
if(sizeof($array) == 2){
	$branch = $array[0];
	$sem = $array[1];
	mysql_query("update academic set branch = '$branch', sem = '$sem' where student_id = '$row[student_id]'");	
}
}
redirect_to('controls.php?q=Semester corrected');
?>
<?php include_layout_template('footer.php'); ?>
