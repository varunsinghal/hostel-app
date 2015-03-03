<?php
       ob_start();
       require_once("../../includes/initialize.php");
       if(!$session->is_logged_in()){ redirect_to("login.php"); }
       include_layout_template('admin_header.php');
?>

<br/>
<br/>

<?php
if(!isset($_GET['page'])){
echo output_message("Nothing found.");
exit;
}

$id=$_GET['page'];
?>

<?php
$query="SELECT * FROM student WHERE student_id='$id'";
$res=mysql_query($query);
if(!$res)
die(mysql_error());
else
{
$row=mysql_fetch_array($res);
if($row['file'] == null)
$file = '0.jpg';
else
$file = $row['file'];
if($row['reallot']==0)
$reallot = 'Registration';
else
$reallot = 'Reallotment';
echo '
<img src="../photo/'.$file.'" height = "150"><br/><br/>
<table>
<tr><td colspan="3"><strong>Basic Details</strong></td></tr>
<tr><td>Name</td><td>&ensp; : &ensp;</td><td>'.$row['name'].'</td></tr>
<tr><td>Gender</td><td>&ensp; : &ensp;</td><td>'.$row['gender'].'</td></tr>
<tr><td>Personal Phone</td><td>&ensp; : &ensp;</td><td>'.$row['personal_phone'].'</td></tr>
<tr><td>Email</td><td>&ensp; : &ensp;</td><td>'.$row['email'].'</td></tr>
<tr><td>Category Code</td><td>&ensp; : &ensp;</td><td>'.$row['category_code'].'</td></tr>
<tr><td>School</td><td>&ensp; : &ensp;</td><td>'.$row['school'].'</td></tr>
<tr><td>Hostel Roll No.</td><td>&ensp; : &ensp;</td><td>'.$row['recipt'].'</td></tr>
<tr><td>Backs</td><td>&ensp; : &ensp;</td><td>'.$row['backs'].'</td></tr>
<tr><td>Form Type</td><td>&ensp; : &ensp;</td><td>'.$reallot.'</td></tr>
<tr><td>Blood Group</td><td>&ensp; : &ensp;</td><td>'.$row['blood_group'].'</td></tr>
<tr><td>Chronic Problem</td><td>&ensp; : &ensp;</td><td>'.$row['chronic'].'</td></tr>
<tr><td>Date of Submission</td><td>&ensp; : &ensp;</td><td>'.$row['date_of_submisssion'].'</td></tr>
';
}

$query="SELECT * FROM available_room WHERE student_id='$id'";
$res=mysql_query($query);
if(!$res)
die(mysql_error());
else
{
$row=mysql_fetch_array($res);
if($row){
echo '<tr><td>Room Alloted</td><td>&ensp; : &ensp;</td><td> '.$row['hostel'].' '.$row['room_no'].'</td></tr>';
}
else{
echo '<tr><td>Room Alloted</td><td>&ensp; : &ensp;</td><td>NIL</td></tr>';
}

}

$query2="SELECT * FROM academic WHERE student_id='$id'";
$res=mysql_query($query2);
if(!$res)
die(mysql_error());
else
{
$row=mysql_fetch_array($res);
echo '
<tr><td colspan="3"><strong>Academic Details</strong></td></tr>
<tr><td>Course</td><td>&ensp; : &ensp;</td><td>'.$row['course'].'</td></tr>
<tr><td>Roll No.</td><td>&ensp; : &ensp;</td><td>'.$row['roll_no'].'</td></tr>
<tr><td>Branch</td><td>&ensp; : &ensp;</td><td>'.$row['branch'].'</td></tr>
<tr><td>Semester</td><td>&ensp; : &ensp;</td><td>'.$row['sem'].'</td></tr>
<tr><td>Year of Admission</td><td>&ensp; : &ensp;</td><td>'.$row['year_of_admn'].'</td></tr>
';
}

$query="SELECT * FROM bank_details WHERE student_id='$id'";
$res=mysql_query($query);
if(!$res)
die(mysql_error());
else
{
$row=mysql_fetch_array($res);
echo '
<tr><td colspan="3"><strong>Bank Details</strong></td></tr>
<tr><td>Account Holder</td><td>&ensp; : &ensp;</td><td>'.$row['bank_acc_name'].'</td></tr>
<tr><td>Bank Name</td><td>&ensp; : &ensp;</td><td>'.$row['bank_name'].'</td></tr>
<tr><td>Account No.</td><td>&ensp; : &ensp;</td><td>'.$row['bank_acc'].'</td></tr>
<tr><td>IFSC</td><td>&ensp; : &ensp;</td><td>'.$row['bank_ifsc'].'</td></tr>
<tr><td>Branch Code</td><td>&ensp; : &ensp;</td><td>'.$row['bank_code'].'</td></tr>
<tr><td>Address</td><td>&ensp; : &ensp;</td><td>'.$row['bank_add'].'</td></tr>
';
}


$query="SELECT * FROM last_yr_details WHERE student_id='$id'";
$res=mysql_query($query);
if(!$res)
die(mysql_error());
else
{
$row=mysql_fetch_array($res);
echo '
<tr><td colspan="3"><strong>Last Year Details</strong></td></tr>
<tr><td>Last Room</td><td>&ensp; : &ensp;</td><td>'.$row['last_room'].'</td></tr>
<tr><td>Record 1</td><td>&ensp; : &ensp;</td><td>'.$row['last_sr1'].'</td></tr>
<tr><td>Record 2</td><td>&ensp; : &ensp;</td><td>'.$row['last_sr2'].'</td></tr>
';
}


$query1="SELECT * FROM parent_details WHERE student_id='$id'";
$res=mysql_query($query1);
if(!$res)
die(mysql_error());
else
{
$row=mysql_fetch_array($res);
echo '
<tr><td colspan="3"><strong>Parent Details</strong></td></tr>
<tr><td>Father Name</td><td>&ensp; : &ensp;</td><td>'.$row['father_name2'].'</td></tr>
<tr><td>Father Phone</td><td>&ensp; : &ensp;</td><td>'.$row['father_phone'].'</td></tr>
<tr><td>Father Email</td><td>&ensp; : &ensp;</td><td>'.$row['father_email'].'</td></tr>
<tr><td>Father Occupation</td><td>&ensp; : &ensp;</td><td>'.$row['father_occupation'].'</td></tr>
<tr><td>Father Designation</td><td>&ensp; : &ensp;</td><td>'.$row['father_des'].'</td></tr>
<tr><td>Father Office Phone</td><td>&ensp; : &ensp;</td><td>'.$row['father_office_phone'].'</td></tr>
<tr><td>Father Office Address</td><td>&ensp; : &ensp;</td><td>'.$row['father_office_address'].'</td></tr>
<tr><td>Mother Name</td><td>&ensp; : &ensp;</td><td>'.$row['mother_name'].'</td></tr>
<tr><td>Mother Phone</td><td>&ensp; : &ensp;</td><td>'.$row['mother_phone'].'</td></tr>
<tr><td>Mother Email</td><td>&ensp; : &ensp;</td><td>'.$row['mother_email'].'</td></tr>
<tr><td>Mother Occupation</td><td>&ensp; : &ensp;</td><td>'.$row['mother_occupation'].'</td></tr>
<tr><td>Mother Designation</td><td>&ensp; : &ensp;</td><td>'.$row['mother_des'].'</td></tr>
<tr><td>Mother Office Address</td><td>&ensp; : &ensp;</td><td>'.$row['mother_office_address'].'</td></tr>
';
}





$query1="SELECT * FROM present_address WHERE student_id='$id'";
$res=mysql_query($query1);
if(!$res)
die(mysql_error());
else
{
$row=mysql_fetch_array($res);
echo '
<tr><td colspan="3"><strong>Present Address Details</strong></td></tr>
<tr><td>Address Line</td><td>&ensp; : &ensp;</td><td>'.$row['present_add_line'].'</td></tr>
<tr><td>City</td><td>&ensp; : &ensp;</td><td>'.$row['present_city'].'</td></tr>
<tr><td>State</td><td>&ensp; : &ensp;</td><td>'.$row['present_state'].'</td></tr>
<tr><td>Country</td><td>&ensp; : &ensp;</td><td>'.$row['present_country'].'</td></tr>
<tr><td>PIN</td><td>&ensp; : &ensp;</td><td>'.$row['present_pin'].'</td></tr>
<tr><td>Residential Phone</td><td>&ensp; : &ensp;</td><td>'.$row['present_res_phone'].'</td></tr>
';

}

$query2="SELECT * FROM permanent_address WHERE student_id='$id'";
$res=mysql_query($query2);
if(!$res)
die(mysql_error());
else
{
$row=mysql_fetch_array($res);
echo '
<tr><td colspan="3"><strong>Present Address Details</strong></td></tr>
<tr><td>Address Line</td><td>&ensp; : &ensp;</td><td>'.$row['permanent_add_line'].'</td></tr>
<tr><td>City</td><td>&ensp; : &ensp;</td><td>'.$row['permanent_city'].'</td></tr>
<tr><td>State</td><td>&ensp; : &ensp;</td><td>'.$row['permanent_state'].'</td></tr>
<tr><td>Country</td><td>&ensp; : &ensp;</td><td>'.$row['permanent_country'].'</td></tr>
<tr><td>PIN</td><td>&ensp; : &ensp;</td><td>'.$row['permanent_pin'].'</td></tr>
<tr><td>Residential Phone</td><td>&ensp; : &ensp;</td><td>'.$row['permanent_res_phone'].'</td></tr>
';
}

$query="SELECT * FROM local_guardian WHERE student_id='$id'";
$res=mysql_query($query);
if(!$res)
die(mysql_error());
else
{
$row=mysql_fetch_array($res);
echo '
<tr><td colspan="3"><strong>Local Guardian Details</strong></td></tr>
<tr><td>Name</td><td>&ensp; : &ensp;</td><td>'.$row['lg_name'].'</td></tr>
<tr><td>Address</td><td>&ensp; : &ensp;</td><td>'.$row['lg_address'].'</td></tr>
<tr><td>Phone No.</td><td>&ensp; : &ensp;</td><td>'.$row['lg_phone'].'</td></tr>
<tr><td>Occupation</td><td>&ensp; : &ensp;</td><td>'.$row['lg_occupation'].'</td></tr>
<tr><td>Office</td><td>&ensp; : &ensp;</td><td>'.$row['lg_office'].'</td></tr>
<tr><td>Office Phone No.</td><td>&ensp; : &ensp;</td><td>'.$row['lg_office_phone'].'</td></tr>
</table>';
}

?>

<?php include_layout_template('admin_footer.php'); ?>
