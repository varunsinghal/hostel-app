<?php
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }
?>


<?php
$q=$_GET["q"];
require_once('../../includes/config.php');
 $con = mysql_connect(DB_SERVER,DB_USER,DB_PASS);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db(DB_NAME, $con);


$query1 = "SELECT * FROM student WHERE student_id = '$q'";
$result_set1 = mysql_query($query1);

$query2 = "SELECT * FROM academic WHERE student_id = '".$q."'";
$result_set2 = mysql_query($query2);	
$query3 = "SELECT * FROM permanent_address WHERE student_id = '".$q."'";
$result_set3 = mysql_query($query3);
if(!$result_set2)
{
	die("wrong");
}
	//display student info	
	 $found_form_no1 = mysql_fetch_array($result_set1);
	 $found_form_no2 = mysql_fetch_array($result_set2);
	 $found_form_no3 = mysql_fetch_array($result_set3);
	 echo '<b>Name</b><br>'.$found_form_no1['name'];
	 echo "<br>";
	 echo '<b>Roll no.</b><br>'.$found_form_no2['roll_no'];
	 echo "<br>";
	 echo '<b>Branch</b><br>'.$found_form_no2['branch'];
	 echo "<br>";
	 echo '<b>Address</b><br>'.$found_form_no3['permanent_add_line'];
	  echo "<br>";
	  echo $found_form_no3['permanent_city'];
	  echo "<br>";
	 echo '<b>Year of admission</b><br>'.$found_form_no2['year_of_admn'];


?>