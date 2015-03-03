<?php
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }


//checking if form no. exists
$form_no=$_GET['q'];


$query = "SELECT student_id FROM student WHERE student_id = '{$form_no}'";
$result_set = mysql_query($query);	

if (mysql_num_rows($result_set) == 1) 
{
 
			  
	//form no matched
	//and only one match

	$found_form_no = mysql_fetch_array($result_set);
		$id=$found_form_no['student_id'];
		
		$query1 = "SELECT* FROM student WHERE student_id = '{$id}'";
$result_set1 = mysql_query($query1);

$query2 = "SELECT* FROM academic WHERE student_id = '{$id}'";
$result_set2 = mysql_query($query2);	

if (mysql_num_rows($result_set1) == 1)
{	
	//display student info	
	 $found_form_no1 = mysql_fetch_array($result_set1);
	 $found_form_no2 = mysql_fetch_array($result_set2);
	 echo $found_form_no1['name'];
	 echo "<br>";
	 echo $found_form_no2['roll_no'];
	 echo "<br>";
	 echo $found_form_no2['branch'];
	 echo "<br>";
	 echo $found_form_no2['year_of_admn'];
}
		exit;
					
					
}

else
{
		echo "FORM NO. NOT MATCHED";
}



?>
