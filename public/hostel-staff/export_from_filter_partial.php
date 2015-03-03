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
		$conditions .= ' AND student.last_year_details LIKE "%Backs : '.$_REQUEST['backs'].'%"';
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
			$conditions .= ' AND student.student_id NOT IN ( SELECT student_id FROM allotment_details )';
		}
		if($_REQUEST['allotted'] == 'allotted')
		{
			$natural_joins .= ' NATURAL JOIN allotment_details';
			$heading .= ' Allotted = Allotted |';
			$conditions .= ' AND student.student_id = allotment_details.student_id';
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



echo "\nS.No\tForm No.\tName\tCategory\tHostel Roll\tMob No\tGender\tAcademic\tUniversity Roll\tAddress\tDistance\tRemarks\n";

$i = 1;

function display_after_filtering($heading, $natural_joins, $conditions, $order)
{

$query = "SELECT * FROM student ".$natural_joins." WHERE ".$conditions." ".$order;

$result = mysql_query($query) or die(mysql_error());
while($row = mysql_fetch_array($result))
{
	error_reporting(E_ALL);
	global $i;
    $id = $row['student_id'];
    echo $i."\t".$id."\t".$row['name']."\t".$row['category_code']."\t".$row['recipt']."\t".$row['personal_phone']."\t".$row['gender'];
    echo "\t";
    $query2 = "SELECT * FROM academic WHERE student_id='$id'";
    $result1 = mysql_query($query2) or die(mysql_error());
    $row=mysql_fetch_array($result1);
    echo $row['year_of_admn'].", ".$row['course']."\t".$row['roll_no']."\t";
    $query2 = "SELECT * FROM present_address WHERE student_id='$id'";
    $result1 = mysql_query($query2) or die(mysql_error());
    $row=mysql_fetch_array($result1);
    echo $row['present_add_line'].", ".$row['present_city'].", ".$row['present_state'].", ".$row['present_pin']."\t";

    $query2 = "SELECT * FROM distance_from_home WHERE student_id='$id'";
    $result1 = mysql_query($query2) or die(mysql_error());
    $row=mysql_fetch_array($result1);
    echo $row['distance']."\t";
    
    $query3 = "SELECT * FROM remarks WHERE student_id='$id'";
    $result1 = mysql_query($query3) or die(mysql_error());
    $row=mysql_fetch_array($result1);
    if(isset($row['remarks']))
    {
    	echo $row['remarks'];
    }
    else echo "";
    
    echo "\n";
    $i++;
}


}


display_after_filtering($heading, $natural_joins, $conditions, $order);


if(isset($database)) { $database->close_connection(); }
ob_end_flush();

?>