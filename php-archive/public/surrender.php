<?php
ob_start();
require_once("../includes/initialize.php");
include_layout_template('header.php');

$query = "SELECT * FROM control_variables WHERE control = 'surrender' LIMIT 1";
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_array($result);

if(!$session->is_logged_in()){
if($row['flag'] == 0)
{
    redirect_to("error.php?i=2");
    exit;
}
}

if(isset($_POST['submit'])){
//print starts
$recipt = $database->escape_value($_POST['recipt']);
$sql = "select student_id, name from student natural join docu_submission where document = 1 and recipt = '$recipt'";
$query = $database->query($sql);
$count = $database->num_rows($query);
$student = ($count ==1) ? ($database->fetch_array($query)) : false;
if($student !=false){
$student_id = $student['student_id'];
$sql2 = "SELECT * FROM available_room WHERE student_id='$student_id'";
$query2 = $database->query($sql2);
$room = $database->fetch_array($query2);
if(isset($room)){
$sql3 = "UPDATE available_room SET surrender = 1 WHERE student_id = '$student_id'";
$database->query($sql3);  
$sql4 = "SELECT course, roll_no FROM academic WHERE student_id='$student_id'";
$query4 = $database->query($sql4);
$academic = $database->fetch_array($query4);
//start list of items
$string = '<ol>';
foreach($_POST['items'] as $item){
$string = $string.'<li>'.$item.'</li>';
}
$string = $string.'</ol>';
//end list of items
$attribute = array ('{name}'=>$student['name'], '{roll_no}'=>$academic['roll_no'], '{course}'=>$academic['course'], '{room_no}'=>$room['room_no'], '{hostel}'=>$room['hostel'],'{date}'=>date("d/m/y"), '{recipt}'=>$recipt, '{string}'=>$string);
$html = file_get_contents ('layouts/surrender.inc.php');
foreach ($attribute as $key => $value){
  $html = str_replace ("{$key}", $value, $html);
}
$filename = "html".DS."surrender".DS.$student_id.".html";
file_put_contents("mpdf".DS.$filename, $html);
redirect_to('get_pdf.php?input_file=mpdf'.DS.$filename);
}
else{
echo "<h2>Room not found</h2>";
exit;
}
}

}
?>
<form action="surrender.php" method="post">
Enter the hostel roll no: <input type="text" name="recipt"><br/><br/>
Tick the items to surrender:<br/>
<input type="checkbox" name="items[]" value="Bed">Bed<br/> 
<input type="checkbox" name="items[]" value="Table">Table<br/>
<input type="checkbox" name="items[]" value="Tube-Light">Tube-Light<br/> 
<input type="checkbox" name="items[]" value="Chair">Chair<br/>
<input type="checkbox" name="items[]" value="Fan">Fan<br/>
<input type="checkbox" name="items[]" value="Curtains">Curtains<br/>
<input type="checkbox" name="items[]" value="Curtain-Rod">Curtain Rod<br/> 
<input type="checkbox" name="items[]" value="Rooom-Number-Plate">Room Number Plate<br/>
<input type="checkbox" name="items[]" value="Dustbin">Dustbin<br/>
<input type="checkbox" name="items[]" value="Book-Rack">Book Rack<br/>
<input type="checkbox" name="items[]" value="Looking-Mirror">Looking Mirror<br/>
<input type="checkbox" name="items[]" value="Gyser">Gyser<br/>
<input type="checkbox" name="items[]" value="Washbasin">Washbasin<br/>
<input type="submit" name="submit" value="submit"/>
</form>

<?php
include_layout_template('footer.php');
if(isset($database)) { $database->close_connection(); }
ob_end_flush()
?>
