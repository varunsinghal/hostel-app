<?php
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=allstudent.xls");
header("Pragma: no-cache");
header("Expires: 0");


$sql = "SELECT * FROM student";
$result = mysql_query($sql) or die(mysql_error());
$num_fields = mysql_num_fields($result);
$header = "";
for($i = 0; $i<$num_fields; ++$i)
{
    $header .= mysql_field_name($result, $i)."\t";
}

$sql = "SELECT * FROM academic";
$result = mysql_query($sql) or die(mysql_error());
$num_fields = mysql_num_fields($result);
for($i = 0; $i<$num_fields; ++$i)
{
    $header .= mysql_field_name($result, $i)."\t";
}

$sql = "SELECT * FROM present_address";
$result = mysql_query($sql) or die(mysql_error());
$num_fields = mysql_num_fields($result);
for($i = 0; $i<$num_fields; ++$i)
{
    $header .= mysql_field_name($result, $i)."\t";
}

$sql = "SELECT * FROM permanent_address";
$result = mysql_query($sql) or die(mysql_error());
$num_fields = mysql_num_fields($result);
for($i = 0; $i<$num_fields; ++$i)
{
    $header .= mysql_field_name($result, $i)."\t";
}

$sql = "SELECT * FROM distance_from_home";
$result = mysql_query($sql) or die(mysql_error());
$num_fields = mysql_num_fields($result);
for($i = 0; $i<$num_fields; ++$i)
{
    $header .= mysql_field_name($result, $i)."\t";
}

$sql = "SELECT * FROM docu_submission";
$result = mysql_query($sql) or die(mysql_error());
$num_fields = mysql_num_fields($result);
for($i = 0; $i<$num_fields; ++$i)
{
    $header .= mysql_field_name($result, $i)."\t";
}

echo $header;
echo "\n";



$sql = "SELECT * FROM student ORDER BY student_id";
$rec = mysql_query($sql) or die (mysql_error());
while($row = mysql_fetch_row($rec))
{
    //print_r($row);
    //echo '<hr /><hr />';
    $id = $row[0];
    $comma_separated = implode("@%", $row);
    //echo $comma_separated;
    //echo '<hr /><hr />';
    $comma_separated = trim($comma_separated);
    //echo $comma_separated;
    //echo '<hr /><hr />';
    $str = str_replace("@%", "\t", $comma_separated);
    $str .= "\t";
    //echo $str."\n";
    //exit;
    $query2 = "SELECT * FROM academic WHERE student_id='$id'";
    $result1 = mysql_query($query2) or die(mysql_error());
    $row=mysql_fetch_row($result1);
    $comma_separated = implode("@%", $row);
    $comma_separated = trim($comma_separated);
    $str .= str_replace("@%", "\t", $comma_separated);
    $str .= "\t";
    //echo $str."\n";
    $query2 = "SELECT * FROM present_address WHERE student_id='$id'";
    $result1 = mysql_query($query2) or die(mysql_error());
    $row=mysql_fetch_row($result1);
    $comma_separated = implode("@%", $row);
    $comma_separated = trim($comma_separated);
    $str .= str_replace("@%", "\t", $comma_separated);
    $str .= "\t";
    
    $query2 = "SELECT * FROM permanent_address WHERE student_id='$id'";
    $result1 = mysql_query($query2) or die(mysql_error());
    $row=mysql_fetch_row($result1);
    $comma_separated = implode("@%", $row);
    $comma_separated = trim($comma_separated);
    $str .= str_replace("@%", "\t", $comma_separated);
    $str .= "\t";

    $query2 = "SELECT * FROM distance_from_home WHERE student_id='$id'";
    $result1 = mysql_query($query2) or die(mysql_error());
    $row=mysql_fetch_row($result1);
    $comma_separated = implode("@%", $row);
    $comma_separated = trim($comma_separated);
    $str .= str_replace("@%", "\t", $comma_separated);
    $str .= "\t";
    
    $query2 = "SELECT * FROM docu_submission WHERE student_id='$id'";
    $result1 = mysql_query($query2) or die(mysql_error());
    $row=mysql_fetch_row($result1);
    $comma_separated = implode("@%", $row);
    $comma_separated = trim($comma_separated);
    $str .= str_replace("@%", "\t", $comma_separated);
    $str .= "\t";
    echo $str."\n";
}
    

?>