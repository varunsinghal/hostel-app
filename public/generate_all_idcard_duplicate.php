<?php

// initialization

require_once("../includes/initialize.php");

if(!$session->is_logged_in()){ redirect_to("error.php?i=5"); }
if(!isset($_GET["year"]) || !isset($_GET["course"]) || !isset($_GET["gender"]))
die("Sorry Invalid request.");

// initialization ends

?>
<style>
html, table{ 
font-family: verdana, sans-serif;
font-size:10px;
}
@media all {
	.page-break	{ display: none; }
}

@media print {
	.page-break	{ display: block; page-break-before: always; }
}
</style>

<?php

function downloadFile ($url, $path) {
echo $url;echo $path;
  $newfname = $path;
  $file = fopen ($url, "rb");
  var_dump($file);
  if ($file) {
    $newf = fopen ($newfname, "wb");

    if ($newf)
    while(!feof($file)) {
      fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
    }
  }

  if ($file) {
    fclose($file);
  }

  if ($newf) {
    fclose($newf);
  }
 }

$sqltoperform = 'SELECT * FROM student NATURAL JOIN distance_from_home NATURAL JOIN docu_submission NATURAL JOIN academic NATURAL JOIN available_room WHERE student.student_id = distance_from_home.student_id AND docu_submission.document=1 AND student.gender = "'.$_GET["gender"].'" AND academic.course = "'.$_GET["course"].'" AND academic.year_of_admn="'.$_GET["year"].'" AND student.student_id = academic.student_id AND student.student_id = available_room.student_id ORDER BY distance_from_home.distance DESC';
$queryperformed = mysql_query($sqltoperform) or die(mysql_error());
while($recievedid = mysql_fetch_array($queryperformed))
{


?>

<?php
// reading values posted by the form
$stu_id = $recievedid['student_id'];
// reading values ends


// search for right student starts
$query="SELECT * FROM student WHERE student.student_id ='$stu_id' ";
$result = $database->query($query);
$row = $database->fetch_array($result);

$student_id = $row['student_id'];  // store the value of student id in local variable


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

$query4 = "SELECT * FROM present_address WHERE student_id='$student_id'";
$result4 = $database->query($query4);
$preaddrdata = $database->fetch_array($result4);

?>
<!-- Headings of page -->
<h2 style="text-align:center"><u>Hostel Allotment Slip</u></h2>
<h2 style="text-align:center">Delhi Technological University</h2>
<p style="text-align:center;text-decoration:underline;">Academic Year : <?php echo date("Y", time());
echo "-";
echo date("Y", time())+1; ?>
</p>
<!-- Heading ends -->
<?php
// allotment slip
echo '<p align="right">Date ____________________________<br /></p>';
echo "Name : <u>".$row['name']."</u><br />";
echo "Form No. : ".$row['student_id']."<br />";
echo "Hostel Roll no. : ".$row['recipt']."<br />";
echo "Category : <u>".$row['category_code']."</u><br />";
echo "Following Hostel, room number is alloted to you -";
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
<br/>
<br/>
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
<td><img src="photo/<?php echo $row['file'];?>" style="width:75px;height:100px;background:url(../photo/<?php echo $row['file'];?>);border:1px solid;background-size:cover;"></td>
<td>
<table style="padding-left:10px;">
<tr><td>Name</td><td>&ensp;:&ensp;</td><td><u><?php echo $row['name']; ?></u></td></tr>
<tr><td>H. Roll No.</td><td>&ensp;:&ensp;</td><td><u><?php echo $row['recipt']; ?></u></td></tr>
<tr><td>Year of Admn</td><td>&ensp;:&ensp;</td><td><u><?php echo $academicdata['year_of_admn']; ?></u></td></tr>
<tr><td>Course</td><td>&ensp;:&ensp;</td><td><u><?php echo $academicdata['course']; ?></u></td></tr>
<tr><td>Hostel, Room</td><td>&ensp;:&ensp;</td><td><u><?php echo $row2['hostel'].", ".$row2['room_no']; ?></u></td></tr>
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
<br/>
<br/>


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
<td><img src="photo/<?php echo $row['file'];?>" style="width:75px;height:100px;background:url(../photo/<?php echo $row['file'];?>);border:1px solid;background-size:cover;"></td>
<td>
<table style="padding-left:10px;">
<tr><td>Name</td><td>&ensp;:&ensp;</td><td><u><?php echo $row['name']; ?></u></td></tr>
<tr><td>H. Roll No.</td><td>&ensp;:&ensp;</td><td><u><?php echo $row['recipt']; ?></u></td></tr>
<tr><td>Year of Admn</td><td>&ensp;:&ensp;</td><td><u><?php echo $academicdata['year_of_admn']; ?></u></td></tr>
<tr><td>Course</td><td>&ensp;:&ensp;</td><td><u><?php echo $academicdata['course']; ?></u></td></tr>
<tr><td>Hostel, Room</td><td>&ensp;:&ensp;</td><td><u><?php echo $row2['hostel'].", ".$row2['room_no']; ?></u></td></tr>
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
<div class="page-break"></div>
<?php
}
//printing link

echo '<h1><img src="images/pdf_icon.png"> <a href="#" onClick="window.print()">Click Here</a> to get the pdf version of this slip</h1>';

?>
