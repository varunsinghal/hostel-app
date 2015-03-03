<table>

<?php
$i=1;
ini_set('max_execution_time', 1200); //1200 seconds = 20 minutes
$con=mysql_connect("localhost", "root", "");
$db=mysql_select_db("dce_app",$con);
$query=mysql_query("select * from student");
while($result=mysql_fetch_array($query)){
  $result2=mysql_fetch_array(mysql_query("select * from academic where student_id='$result[student_id]'"));
echo '<tr><td>'.$i.') </td><td>'.$result['name'].'</td><td>'.$result2['branch'].'</td><td>'.$result['personal_phone'].'</td><td>'.$result['email'].'</td></tr>';
$i++;
}


/*
$query=mysql_query("select * from remarks");
while ($result=mysql_fetch_array($query)) {
	$check2=mysql_select_db("dce_app",$con);
	$exist=mysql_fetch_array(mysql_query("select * from remarks where student_id='$result[student_id]' and remarks='$result[remarks]'"));
	if(!$exist){
	$check2=mysql_select_db("dce_app",$con);
	$correct=mysql_query("update remarks set remarks='$result[remarks]' where student_id='$result[student_id]'"); , present_lg_name, present_lg_address, present_lg_phone , '$result[present_lg_name]', '$result[present_lg_address]', '$result[present_lg_phone]'
	$errors[]=$result['student_id'].' missmatch found and corrected';
}
}



$query=mysql_query("select * from student");
while($result=mysql_fetch_array($query)){
	$check2=mysql_select_db("dce_app",$con);
	$exist=mysql_fetch_array(mysql_query("select * from student where student_id='$result[student_id]'"));
    if(!$exist)
    	$errors[]=$result['student_id'].'student_id missmatch found';
$check2=mysql_select_db("dce_app",$con);
$exist=mysql_fetch_array(mysql_query("select * from student where name='$result[name]'"));
if(!$exist)
	$errors[]=$result['student_id'].'name missmatch found';
}


*/

?>
</table>