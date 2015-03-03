<?php

// initialization

ob_start();
require_once("../../includes/initialize.php");

// initialization ends

if(!$session->is_logged_in()){ redirect_to("login.php"); }

?>
<style>
html, table{ 
font-family: verdana, sans-serif;
font-size:10px;
}
</style>

<!-- Headings of page -->
<h2 style="text-align:center"><u>Hostel Allotment Slip</u></h2>
<h2 style="text-align:center">Delhi Technological University</h2>
<p style="text-align:center;text-decoration:underline;">Academic Year : <?php echo date("Y", time());
echo "-";
echo date("Y", time())+1; ?></p>
<!-- Heading ends -->



<?php


// check if the page is not accessed directly
if(!isset($_GET['id']))
{
	redirect_to('error.php?i=1');
}
// check ends


// reading values posted by the form
$student_id = $database->escape_value($_GET['id']);
// reading values ends



// search for right student starts
$query="SELECT * FROM student NATURAL JOIN docu_submission WHERE student.student_id = docu_submission.student_id AND docu_submission.document = 1 AND student.student_id='$student_id'";
$result = $database->query($query);
$row = $database->fetch_array($result);
$count = $database->num_rows($result);


// show error is invalid entry or unverified document
if($count == 0)
{
	echo '<h4 text-align="center">Either invalid entry or your documents were not verified.</h4>';
	exit(0);
}


// get room number of found student
$query2 = "SELECT * FROM available_room WHERE student_id='$student_id'";
$result2 = $database->query($query2);
$count2 = $database->num_rows($result2);

// show error if multiple room alloted to same student
if($count2 >1)
{
	redirect_to('error.php?i=5');
}

// if no room alloted
if($count2 == 0)
{
	echo '<center><h4>Sorry no room alloted to you.</h4></center>';
	exit(0);
}

$row2 = $database->fetch_array($result2); // retrieve data from database is the student is clean


// retrieval of academic and address details
$query3 = "SELECT * FROM academic WHERE student_id='$student_id'";
$result3 = $database->query($query3);
$academicdata = $database->fetch_array($result3);

// $query4 = "SELECT * FROM present_address WHERE student_id='$student_id'";
// $result4 = $database->query($query4);
// $preaddrdata = $database->fetch_array($result4);


// allotment slip
echo '<p align="right">Date ____________________________<br /></p>';
echo "Name : <u>".$row['name']."</u><br />";
echo "Form No. : ".$row['student_id']."<br />";
echo "Category : <u>".$row['category_code']."</u><br />";
echo "Following Hostel,room is alloted to you -";
echo "<h3>".$row2['hostel'].", ".$row2['room_no']."</h3>";
 echo '<br /><br /><br />';
echo '<table width=100%>
<tr style="border: none !important;">
<td style="border: none !important;">(Dealing Assistant)</td>
<td style="border: none !important;">(O/IC Hostel Office)</td>
<td style="border: none !important;">(Hostel Warden)</td>
</tr></table>';	

echo '<br /><br /><hr />';
// alotment slip ends

?>


<?php

echo '<h1><img src="../images/pdf_icon.png"> <a href="#" onClick="window.print()">Click Here</a> to get the pdf version of this slip</h1>';
?>


<?php

// de-initialization

if(isset($database)) { $database->close_connection(); }
ob_end_flush();

?>
