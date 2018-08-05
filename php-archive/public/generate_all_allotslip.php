<?php
// initialization

require_once("../includes/initialize.php");

if(!$session->is_logged_in()){ redirect_to("error.php?i=5"); }
if(!isset($_GET["year"]) || !isset($_GET["course"]) || !isset($_GET["gender"]))
die("Sorry Invalid request.");


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
ob_start();

//$sqltoperform = 'SELECT * FROM student NATURAL JOIN distance_from_home NATURAL JOIN docu_submission NATURAL JOIN academic NATURAL JOIN allotment_details WHERE student.student_id = distance_from_home.student_id AND docu_submission.document=1 AND student.gender = "female" AND student.student_id = academic.student_id AND academic.course="btech" AND academic.year_of_admn="2012" AND student.student_id = allotment_details.student_id ORDER BY distance_from_home.distance DESC';
$sqltoperform = 'SELECT * FROM student NATURAL JOIN distance_from_home NATURAL JOIN docu_submission NATURAL JOIN academic NATURAL JOIN available_room WHERE student.student_id = distance_from_home.student_id AND docu_submission.document=1 AND student.gender = "'.$_GET["gender"].'" AND academic.course = "'.$_GET["course"].'" AND academic.year_of_admn="'.$_GET["year"].'" AND student.student_id = academic.student_id  ORDER BY distance_from_home.distance DESC';
$queryperformed = mysql_query($sqltoperform);
$pagebreak = 0;
while($recievedid = mysql_fetch_array($queryperformed))
{




?>

<!-- Headings of page -->
<h2 style="text-align:center"><u>Hostel Allotment Slip</u></h2>
<h2 style="text-align:center">Delhi Technological University</h2>
<p style="text-align:center;text-decoration:underline;">Academic Year : <?php echo date("Y", time());
echo "-";
echo date("Y", time())+1; ?></p>
<!-- Heading ends -->

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

echo '<br /><br /><hr /><br /><br/>';
// alotment slip ends
$pagebreak++;
if ($pagebreak%2 == 0)
    {
        echo "<div class='page-break'></div>";
    }



}
// pdf printing script


echo '<h1><img src="images/pdf_icon.png"> <a href="#" onClick="window.print()">Click Here</a> to get the pdf version of this slip</h1>';

?>
