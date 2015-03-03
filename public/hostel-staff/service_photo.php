<?php
       require_once("../../includes/initialize.php");
       if(!$session->is_logged_in()){ redirect_to("login.php"); }
       include_layout_template('admin_header.php');
       ini_set('max_execution_time', 1200); //1200 seconds = 20 minutes
?>
<?php 
$query = mysql_query("select student_id, file from student");
while($row = mysql_fetch_array($query)){
if($row['file'] == '' || $row['file'] == null){
	mysql_query("update student set file = '0.jpg' where student_id = '$row[student_id]'");
	}
}

redirect_to('controls.php?q=Photographs corrected');
?>
<?php include_layout_template('footer.php'); ?>
