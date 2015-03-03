<?php
       require_once("../../includes/initialize.php");
       if(!$session->is_logged_in()){ redirect_to("login.php"); }
       include_layout_template('admin_header.php');
       ini_set('max_execution_time', 1200); //1200 seconds = 20 minutes
?>
<?php 
$query = mysql_query("select student_id, father_name from student");
while($row = mysql_fetch_array($query)){
if($row['father_name'] == '' || $row['father_name'] == null){
	$row2 = mysql_fetch_array(mysql_query("select father_name2 from parent_details where student_id = '$row[student_id]'"));
	mysql_query("update student set father_name = '$row2[father_name2]' where student_id = '$row[student_id]'");
	
	}
}

redirect_to('controls.php?q=Father name corrected');
?>
<?php include_layout_template('footer.php'); ?>
