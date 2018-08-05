<?php
// initialization

ob_start();
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("error.php?i=5"); }
// initialization ends

?>

<html>
<head>
<title>Hostel ID Card</title>
<style>
html, table{ 
font-family: verdana, sans-serif;
font-size:10px;
}
</style>
</head>
<body>

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
	echo '<center><h4>Either invalid entry or your documents were not verified.</h4></center>';
	exit(0);
}


// get room number of found student
$query2 = "SELECT * FROM available_room WHERE student_id='$student_id'";
$result2 = $database->query($query2);
$count2 = $database->num_rows($result2);

// show error if multiple room alloted to same student
if($count2 >1)
{
	echo '<center><h4>Some error in database entry of this student. Please verify. [Reports multiple room allotted]</h4></center>';	
	exit(0);
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

$query4 = "SELECT * FROM present_address WHERE student_id='$student_id'";
$result4 = $database->query($query4);
$preaddrdata = $database->fetch_array($result4);

?>



<!-- hostel id starts -->
<table width="100%" style="padding-left: 25px; padding-right: 25px; border: 1px solid;">
<tr><td style="border-right: 1px solid;">

<!-- front side of hostel id -->
<p>
<p style="text-align:center">Delhi Technological University</p>
<p style="text-align:center"><strong>Hostel ID Card (Session : <?php echo date("Y", time());
echo "-";
echo date("Y", time())+1; ?>)</strong></p>
<table style="border:0px;" border=0px;>
<tr>
<td><img src="../photo/<?php echo $row['file'];?>" style="width:75px;height:100px;background:url(../photo/<?php echo $row['file'];?>);border:1px solid;background-size:cover;"></td>
<td>
<table style="padding-left:10px;">
<tr><td>Name</td><td>&ensp;:&ensp;</td><td><u><?php echo $row['name']; ?></u></td></tr>
<tr><td>H. Roll No.</td><td>&ensp;:&ensp;</td><td><u><?php echo $row['recipt']; ?></u></td></tr>
<tr><td>Year of Admn</td><td>&ensp;:&ensp;</td><td><u><?php echo $academicdata['year_of_admn']; ?></u></td></tr>
<tr><td>Course</td><td>&ensp;:&ensp;</td><td><u><?php echo $academicdata['course']; ?></u></td></tr>
<tr><td>Room</td><td>&ensp;:&ensp;</td><td><u><?php echo $row2['hostel'].", ".$row2['room_no']; ?></u></td></tr>
</table>
</td>
</tr>
</table>
<?php 
$recipt = explode('/',$row['recipt']);
$recipt = implode(' ',$recipt);
?>
<img src="barcode.php?text=<?php echo $recipt;?>" style="width:85px">
</p>
</td>
<!-- front side of hostel id ends -->

<!-- back side of hostel id starts -->
<td width="50%" style="padding-left:25px;">
<br/>
<table style="border:0px;">
<tr><td>Phone</td><td>&ensp;:&ensp;</td><td><u><?php echo $row['personal_phone']; ?></u></td></tr>
<tr><td>U. Roll No.</td><td>&ensp;:&ensp;</td><td><u><?php echo $academicdata['roll_no']; ?></u></td></tr>
</table>
<?php // echo $preaddrdata['present_add_line'].", ".$preaddrdata['present_city'].", ".$preaddrdata['present_state'].", ".$preaddrdata['present_country'] ?>

<b>Instructions -</b>
<ol>
<li>The ID card must be displayed by holder upon entering hostel premises.</li>
<li>In case of loss, duplicate card will be issued on payment of Rs 200/-.</li>
<li>Please ensure safe custody of ID card and in case of loss report immediately to hostel office.</li>
</ol>
<p align="right">Student's Sign<br />Validity : May <?php echo date("Y", time())+1; ?></p>
<br/>
<!-- back side of hostel id ends -->
</td></tr>
</table>
<?php

// pdf printing script

echo '<h1><img src="../images/pdf_icon.png"> <a href="#" onClick="window.print()">Click Here</a> to get the pdf version of this slip</h1>';
?>

<?php

// de-initialization

if(isset($database)) { $database->close_connection(); }
ob_end_flush();
?>

</body>
</html>
