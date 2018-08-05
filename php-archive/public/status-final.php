<?php

// initialization

ob_start();
require_once("../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("error.php?i=5"); }

// initialization ends

?>

<!-- Headings of page -->
<center><h2><u>Hostel Allotment Slip</u></h2></center>
<center><h2>Delhi Technological University</h2><u>Academic Year : <?php echo date("Y", time());
echo "-";
echo date("Y", time())+1; ?></u></center>
<!-- Heading ends -->

<?php




// reading values posted by the form
$stu_id = $_POST['student_id'];
// reading values ends


// search for right student starts
$query="SELECT * FROM student WHERE student_id = '$stu_id'";
$result = $database->query($query);
$row = $database->fetch_array($result);
$count = $database->num_rows($result);

// show error if multiple forms of this student verified
if($count > 1)
{
	redirect_to('error.php?i=4');
}


// show error is invalid entry or unverified document
if($count == 0)
{
	echo '<center><h4>Either invalid entry or your documents were not verified.</h4></center>';
	exit(0);
}


$student_id = $row['student_id'];  // store the value of student id in local variable


// get room number of found student
$query2 = "SELECT * FROM allotment_details WHERE student_id='$student_id'";
$result2 = $database->query($query2);
$count2 = $database->num_rows($result2);


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
echo "H. Roll No. : <u>".$row['recipt']."</u><br />";
echo "Category : <u>".$row['category_code']."</u><br />";
echo "Following room is alloted to you -";
echo "<h3>".$row2['hostel_name'].", ".$row2['room_no']."</h3>";
// echo '<br /><br /><br />';
echo '<table width=100%><tr><td>(Dealing Assistant)</td><td>(O/IC Hostel Office)</td><td>(Hostel Warden)</td></tr></table>';	

echo '<br /><br /><hr />';
// alotment slip ends

?>

<br />



<?php

// pdf printing script

$filename = "tmpallot".DS.$student_id.".html";

file_put_contents("dompdf".DS.$filename, ob_get_contents());

echo '<h1><img src="images/pdf_icon.png"> <a href="dompdf/dompdf.php?input_file='.$filename.'">Click Here</a> to get the pdf version of this slip</h1>';

?>


<?php

// de-initialization

if(isset($database)) { $database->close_connection(); }
ob_end_flush();

?>