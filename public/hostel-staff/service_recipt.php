<?php
       require_once("../../includes/initialize.php");
       if(!$session->is_logged_in()){ redirect_to("login.php"); }
       include_layout_template('admin_header.php');
       ini_set('max_execution_time', 1200); //1200 seconds = 20 minutes
?>
<?php 
$query = $db->query("select student_id, recipt from student");
while($row = $db->fetch_array($query)){
$array = explode('/', $row['recipt']);
$h = str_split($array[0]);
$h2 = "";
$length = sizeof($h);
if($length > 4){
	$h1 = $h[0].$h[1].$h[2].$h[3];
	for ($i = 4; $i < $length;$i++){
	$h2 .=$h[$i];
	}
	$array[0] = $h1.'/'.$h2;
	$recipt = implode('/', $array);
}
else{
	$recipt = $row['recipt'];
}
	$db->query("update student set recipt = '$recipt' where student_id = '$row[student_id]'");	
}

redirect_to('controls.php?q=Recipt corrected');
?>
<?php include_layout_template('footer.php'); ?>
