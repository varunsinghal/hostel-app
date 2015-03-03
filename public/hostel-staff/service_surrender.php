<?php
       require_once("../../includes/initialize.php");
       if(!$session->is_logged_in()){ redirect_to("login.php"); }
       include_layout_template('admin_header.php');
       ini_set('max_execution_time', 1200); //1200 seconds = 20 minutes
?>
<?php 
$query = mysql_query("select student_id, surrender from available_room where surrender = 1");
$remark = 'Surrender application printed.';
while($row = mysql_fetch_array($query)){
$row2 = mysql_fetch_array(mysql_query("select * from remarks where student_id = '$row[student_id]'"));
if(!$row2){
mysql_query("INSERT INTO remarks (student_id, remarks) VALUES ('$row[student_id]', '$remark')");
}
else{
if(strpos($row2['remark'],'surrender') == true){
//do nothing
}
else{
$old_remark = $row2['remark'];
$new_remark = $old_remark.' - '.$remark;
mysql_query("UPDATE remarks SET remarks = '$new_remark' WHERE student_id = '$id' LIMIT 1 ");
}
}
}

redirect_to('controls.php?q=Remarks updated');
?>
<?php include_layout_template('footer.php'); ?>
