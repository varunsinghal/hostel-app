<?php

ob_start();

require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }


header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=export.xls");
header("Pragma: no-cache");
header("Expires: 0");


	$heading = 'Filters Applied -<br /><br />';
	$natural_joins = 'NATURAL JOIN distance_from_home NATURAL JOIN docu_submission ';
	$conditions = 'student.student_id = distance_from_home.student_id ';
	
	if($_REQUEST['verified'] != 'none')
	{
		$conditions .= ' AND docu_submission.document=1 ';
	}
	if($_REQUEST['category'] != 'none')
	{
		$heading .= ' Category = '.$_REQUEST['category'].' |';
		$conditions .= ' AND student.category_code="'.$_REQUEST['category'].'"';
	}
	if($_REQUEST['backs'] != '')
	{
		$heading .= ' Backs = '.$_REQUEST['backs'].' |';
		$conditions .= ' AND student.backs = "'.$_REQUEST['backs'].'"';
	}
	if($_REQUEST['gender'] != 'none')
	{
		$heading .= ' Gender = '.$_REQUEST['gender'].' |';	
		$conditions .= ' AND student.gender = "'.$_REQUEST['gender'].'"';
	}
	if($_REQUEST['course'] != 'none')
	{
		$heading .= ' Course = '.$_REQUEST['course'].' |';
		$natural_joins .= ' NATURAL JOIN academic';
		$conditions .= ' AND student.student_id = academic.student_id AND academic.course="'.$_REQUEST['course'].'"';
	}
	if($_REQUEST['yr_admission'] != 'none')
	{
		$heading .= ' Year of Admission = '.$_REQUEST['yr_admission'].' |';
		if($_REQUEST['course'] == 'none')
		{
			$natural_joins .= ' NATURAL JOIN academic';
			$conditions .= ' AND student.student_id = academic.student_id';
		}
		$conditions .= ' AND academic.year_of_admn="'.$_REQUEST['yr_admission'].'"';
	}
	if($_REQUEST['allotted'] != 'none')
	{
		if($_REQUEST['allotted'] == 'nonallotted')
		{
			$heading .= ' Allotted = Not - Allotted |';
			$conditions .= ' AND student.student_id NOT IN ( SELECT student_id FROM available_room )';
		}
		if($_REQUEST['allotted'] == 'allotted')
		{
			$natural_joins .= ' NATURAL JOIN available_room';
			$heading .= ' Allotted = Allotted |';
			$conditions .= ' AND student.student_id = available_room.student_id';
		}
	}
	if($_REQUEST['order'] == 'name')
	{
		$order = ' ORDER BY student.name ASC';
	}
	if($_REQUEST['order'] == 'distance')
	{
		$order = ' ORDER BY distance_from_home.distance DESC';
	}
	if($_REQUEST['order'] == 'timestamp')
	{
		$order = ' ORDER BY student.date_of_submisssion DESC';
	}
	if($_REQUEST['type_reg'] != 'none')
	{
                	if($_REQUEST['type_reg'] == 'regis')
	                {
                              	$heading .= ' Type  = Registration |';
	                       	$conditions .= ' AND student.reallot="0"';
                       	}
                       	if($_REQUEST['type_reg'] == 'reallotment')
	                {
                                $heading .= ' Type  = Reallotment |';
	                       	$conditions .= ' AND student.reallot="1"';
                       	}
	}

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


	

function display_after_filtering($heading, $natural_joins, $conditions, $order)
{

$query = "SELECT * FROM student ".$natural_joins." WHERE ".$conditions." ".$order;

$result = mysql_query($query) or die(mysql_error());
while($row = mysql_fetch_row($result))
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


}


display_after_filtering($heading, $natural_joins, $conditions, $order);


if(isset($database)) { $database->close_connection(); }
ob_end_flush();

?>
