<?php

ob_start();
       require_once("../../includes/initialize.php");
       if(!$session->is_logged_in()){ redirect_to("login.php"); }
       include_layout_template('admin_header.php');

       $id = $_GET['id'];
       
       echo '<h2 style="color:#ccc"><center>Edit Details</center></h2>';
?>


<?php

if(isset($_POST['submit'])){
  // on pressing submit button

  $student = new Student(); 
  //basic_details
  $student->name                  = $_POST['name'];
  $student->gender                = $_POST['gender'];
  $student->personal_phone        = $_POST['personal_phone'];
  $student->email                 = $_POST['email'];
  $student->recipt                = $_POST['recipt'];
  $student->category_code         = $_POST['category_code'];
  $student->backs                 = $_POST['backs'];
  $student->school                = $_POST['school'];
  $student->blood_group           = $_POST['blood_group'];
  $student->chronic               = $_POST['chronic'];
  $student->file                  = $_POST['file'];
  $student->father_name           = $_POST['father_name2'];
  $student->reallot               = $_POST['reallot'];
  //last year details
  $student->last_room	          = $_POST['last_room']; 
  $student->last_sr1              = $_POST['last_sr1'];
  $student->last_sr2              = $_POST['last_sr2'];
  //academic_details
  if($_POST['backs'] > 0)
  {
    $student->branch              = "<font color=red>".$_POST['branch']."</font>";
  }
  else
  {
    $student->branch              = $_POST['branch']; 
  }
  $student->branch                = $_POST['branch']; 
  $student->sem                   = $_POST['sem'];
  $student->year_of_admn          = $_POST['year_of_admn'];
  $student->course                = $_POST['course']; 
  $student->roll_no               = $_POST['roll_no'];
  //bank_details
  $student->bank_name 	          = $_POST['bank_name'];
  $student->bank_code             = $_POST['bank_code'];
  $student->bank_acc              = $_POST['bank_acc']; 
  $student->bank_acc_name         = $_POST['bank_acc_name'];
  $student->bank_ifsc             = $_POST['bank_ifsc'];
  $student->bank_add              = $_POST['bank_add']; 
  //parent_details  
  $student->father_name2          = $_POST['father_name2'];
  $student->mother_name           = $_POST['mother_name'];
  $student->father_phone          = $_POST['father_phone'];
  $student->mother_phone          = $_POST['mother_phone'];
  $student->father_email          = $_POST['father_email'];
  $student->father_occupation     = $_POST['father_occupation']; 
  $student->father_des            = $_POST['father_des']; 
  $student->father_office_phone   = $_POST['father_office_phone'];
  $student->mother_email          = $_POST['mother_email'];
  $student->mother_occupation     = $_POST['mother_occupation'];
  $student->mother_des            = $_POST['mother_des'];  
  $student->mother_office_phone   = $_POST['mother_office_phone'];
  $student->father_office_address = $_POST['father_office_address']; 
  $student->mother_office_address = $_POST['mother_office_address']; 
  //present_address
  $student->present_add_line      = $_POST['present_add_line'];
  $student->present_city          = $_POST['present_city'];
  $student->present_state         = $_POST['present_state'];
  $student->present_country       = $_POST['present_country'];
  $student->present_pin           = $_POST['present_pin'];
  $student->present_res_phone     = $_POST['present_res_phone'];
  //permanent_address
  $student->permanent_add_line    = $_POST['permanent_add_line'];
  $student->permanent_city        = $_POST['permanent_city'];
  $student->permanent_state       = $_POST['permanent_state'];
  $student->permanent_country     = $_POST['permanent_country'];
  $student->permanent_pin         = $_POST['permanent_pin'];
  $student->permanent_res_phone   = $_POST['permanent_res_phone'];
  //local_guardian
  $student->lg_name               = $_POST['lg_name'];
  $student->lg_address            = $_POST['lg_address'];
  $student->lg_phone              = $_POST['lg_phone'];
  $student->lg_occupation         = $_POST['lg_occupation'];
  $student->lg_office             = $_POST['lg_office'];
  $student->lg_office_phone       = $_POST['lg_office_phone'];
  //misc
  $student->distance              = $_POST['distance'];
  $student->document              = $_POST['document'];



  if($student->save_by_admin($id)){
    $message = "Details Updated Successfully! Update details are shown here. If still incorrect, you can change them again.";
    log_action('Student Details Updated', "Details of student with form number {$id} updated by {$session->user_name}.");
  } else {
    $message = "Some eerror occoured. Go to home page and come back again.";
  }
  
  echo output_message($message);
}

?>

<?php

$query1 = "SELECT * FROM student WHERE student_id='$id'";
$result1 = mysql_query($query1) or die(mysql_error());
$reset1=mysql_fetch_array($result1);

$query2 = "SELECT * FROM present_address WHERE student_id='$id'";
$result2 = mysql_query($query2) or die(mysql_error());
$reset2=mysql_fetch_array($result2);

$query3 = "SELECT * FROM permanent_address WHERE student_id='$id'";
$result3 = mysql_query($query3) or die(mysql_error());
$reset3=mysql_fetch_array($result3);

$query4 = "SELECT * FROM academic WHERE student_id='$id'";
$result4 = mysql_query($query4) or die(mysql_error());
$reset4=mysql_fetch_array($result4);

$query5 = "SELECT * FROM distance_from_home WHERE student_id='$id'";
$result5 = mysql_query($query5) or die(mysql_error());
$reset5=mysql_fetch_array($result5);

$query6 = "SELECT * FROM docu_submission WHERE student_id='$id'";
$result6 = mysql_query($query6) or die(mysql_error());
$reset6=mysql_fetch_array($result6);

$query7 = "SELECT * FROM available_room WHERE student_id='$id'";
$result7 = mysql_query($query7) or die(mysql_error());
$reset7=mysql_fetch_array($result7);

$query8 = "SELECT * FROM parent_details WHERE student_id='$id'";
$result8 = mysql_query($query8) or die(mysql_error());
$reset8=mysql_fetch_array($result8);

$query9 = "SELECT * FROM local_guardian WHERE student_id='$id'";
$result9 = mysql_query($query9) or die(mysql_error());
$reset9=mysql_fetch_array($result9);

$query10 = "SELECT * FROM bank_details WHERE student_id='$id'";
$result10 = mysql_query($query10) or die(mysql_error());
$reset10=mysql_fetch_array($result10);

$query11 = "SELECT * FROM last_yr_details WHERE student_id='$id'";
$result11 = mysql_query($query11) or die(mysql_error());
$reset11=mysql_fetch_array($result11);

if($reset1['reallot']==0)
$reallot = '<input type="radio" name="reallot" value="1"> Reallotment <input type="radio" name="reallot" value="0" checked> Registration ';
else
$reallot = '<input type="radio" name="reallot" value="1" checked> Reallotment <input type="radio" name="reallot" value="0"> Registration ';

if($reset6['document']==0)
$documents = '<input type="radio" name="document" value="1">Verified <input type="radio" name="document" value="0" checked>Un-verified ';
else
$documents = '<input type="radio" name="document" value="1" checked>Verified <input type="radio" name="document" value="0">Un-verified ';

?>
<form method="post" action="edit_student_info.php?id=<?php echo $id; ?>">
<img src="../photo/<?php echo $reset1['file']; ?>" height = "150">
<input type="hidden" value="<?php echo $reset1['file']; ?>" name="file"><br/><br/>
<table>
<tr><td colspan="3"><strong>Basic Details</strong></td></tr>
<tr><td>Name</td><td>&ensp; : &ensp;</td><td><input type="text" name= "name" value="<?php echo $reset1['name']; ?>"></td></tr>
<tr><td>Gender</td><td>&ensp; : &ensp;</td><td><input type="text" name= "gender" value="<?php echo $reset1['gender']; ?>"></td></tr>
<tr><td>Personal Phone</td><td>&ensp; : &ensp;</td><td><input type="text" name= "personal_phone" value="<?php echo $reset1['personal_phone']; ?>"></td></tr>
<tr><td>Email</td><td>&ensp; : &ensp;</td><td><input type="text" name= "email" value="<?php echo $reset1['email']; ?>"></td></tr>
<tr><td>Category Code</td><td>&ensp; : &ensp;</td><td><input type="text" name= "category_code" value="<?php echo $reset1['category_code']; ?>"></td></tr>
<tr><td>Hostel Roll No.</td><td>&ensp; : &ensp;</td><td><input type="text" name= "recipt" value="<?php echo $reset1['recipt']; ?>"></td></tr>
<tr><td>Backs</td><td>&ensp; : &ensp;</td><td><input type="text" name= "backs" value="<?php echo $reset1['backs']; ?>"></td></tr>
<tr><td>Form Type</td><td>&ensp; : &ensp;</td><td><?php echo $reallot; ?> </td></tr>
<tr><td>Blood Group</td><td>&ensp; : &ensp;</td><td><input type="text" name= "blood_group" value="<?php echo $reset1['blood_group']; ?>"></td></tr>
<tr><td>Chronic Problem</td><td>&ensp; : &ensp;</td><td><input type="text" name= "chronic" value="<?php echo $reset1['chronic']; ?>"></td></tr>
<tr><td>Distance from Home</td><td>&ensp; : &ensp;</td><td><input type="text" name= "distance" value="<?php echo $reset5['distance']; ?>"></td></tr>
<tr><td>School</td><td>&ensp; : &ensp;</td><td><input type="text" name= "school" value="<?php echo $reset1['school']; ?>"></td></tr>
<tr><td>Date of Submission</td><td>&ensp; : &ensp;</td><td><input type="text" name= "date_of_submisssion" value="<?php echo $reset1['date_of_submisssion']; ?>"></td></tr>
<tr><td>Documents</td><td>&ensp; : &ensp;</td><td><?php echo $documents; ?></td></tr>

<tr><td colspan="3"><strong>Academic Details</strong></td></tr>
<tr><td>Course</td><td>&ensp; : &ensp;</td><td><input type="text" name= "course" value="<?php echo $reset4['course']; ?>"></td></tr>
<tr><td>Roll No.</td><td>&ensp; : &ensp;</td><td><input type="text" name= "roll_no" value="<?php echo $reset4['roll_no']; ?>"></td></tr>
<tr><td>Branch</td><td>&ensp; : &ensp;</td><td><input type="text" name= "branch" value="<?php echo $reset4['branch']; ?>"></td></tr>
<tr><td>Semester</td><td>&ensp; : &ensp;</td><td><input type="text" name= "sem" value="<?php echo $reset4['sem']; ?>"></td></tr>
<tr><td>Year of Admission</td><td>&ensp; : &ensp;</td><td><input type="text" name= "year_of_admn" value="<?php echo $reset4['year_of_admn']; ?>"></td></tr>

<tr><td colspan="3"><strong>Bank Details</strong></td></tr>
<tr><td>Account Holder</td><td>&ensp; : &ensp;</td><td><input type="text" name= "bank_acc_name" value="<?php echo $reset10['bank_acc_name']; ?>"></td></tr>
<tr><td>Bank Name</td><td>&ensp; : &ensp;</td><td><input type="text" name= "bank_name" value="<?php echo $reset10['bank_name']; ?>"></td></tr>
<tr><td>Account No.</td><td>&ensp; : &ensp;</td><td><input type="text" name= "bank_acc" value="<?php echo $reset10['bank_acc']; ?>"></td></tr>
<tr><td>IFSC</td><td>&ensp; : &ensp;</td><td><input type="text" name= "bank_ifsc" value="<?php echo $reset10['bank_ifsc']; ?>"></td></tr>
<tr><td>Branch Code</td><td>&ensp; : &ensp;</td><td><input type="text" name= "bank_code" value="<?php echo $reset10['bank_code']; ?>"></td></tr>
<tr><td>Address</td><td>&ensp; : &ensp;</td><td><input type="text" name= "bank_add" value="<?php echo $reset10['bank_add']; ?>"></td></tr>

<tr><td colspan="3"><strong>Last Year Details</strong></td></tr>
<tr><td>Last Room</td><td>&ensp; : &ensp;</td><td><input type="text" name= "last_room" value="<?php echo $reset11['last_room']; ?>"></td></tr>
<tr><td>Record 1</td><td>&ensp; : &ensp;</td><td><input type="text" name= "last_sr1" value="<?php echo $reset11['last_sr1']; ?>"></td></tr>
<tr><td>Record 2</td><td>&ensp; : &ensp;</td><td><input type="text" name= "last_sr2" value="<?php echo $reset11['last_sr2']; ?>"></td></tr>

<tr><td colspan="3"><strong>Parent Details</strong></td></tr>
<tr><td>Father Name</td><td>&ensp; : &ensp;</td><td><input type="text" name= "father_name2" value="<?php echo $reset8['father_name2']; ?>"></td></tr>
<tr><td>Father Phone</td><td>&ensp; : &ensp;</td><td><input type="text" name= "father_phone" value="<?php echo $reset8['father_phone']; ?>"></td></tr>
<tr><td>Father Email</td><td>&ensp; : &ensp;</td><td><input type="text" name= "father_email" value="<?php echo $reset8['father_email']; ?>"></td></tr>
<tr><td>Father Occupation</td><td>&ensp; : &ensp;</td><td><input type="text" name= "father_occupation" value="<?php echo $reset8['father_occupation']; ?>"></td></tr>
<tr><td>Father Designation</td><td>&ensp; : &ensp;</td><td><input type="text" name= " father_des" value="<?php echo $reset8['father_des']; ?>"></td></tr>
<tr><td>Father Office Phone</td><td>&ensp; : &ensp;</td><td><input type="text" name= "father_office_phone" value="<?php echo $reset8['father_office_phone']; ?>"></td></tr>
<tr><td>Father Office Address</td><td>&ensp; : &ensp;</td><td><input type="text" name= "father_office_address" value="<?php echo $reset8['father_office_address']; ?>"></td></tr>
<tr><td>Mother Name</td><td>&ensp; : &ensp;</td><td><input type="text" name= "mother_name" value="<?php echo $reset8['mother_name']; ?>"></td></tr>
<tr><td>Mother Phone</td><td>&ensp; : &ensp;</td><td><input type="text" name= "mother_phone" value="<?php echo $reset8['mother_phone']; ?>"></td></tr>
<tr><td>Mother Email</td><td>&ensp; : &ensp;</td><td><input type="text" name= "mother_email" value="<?php echo $reset8['mother_email']; ?>"></td></tr>
<tr><td>Mother Occupation</td><td>&ensp; : &ensp;</td><td><input type="text" name= "mother_occupation" value="<?php echo $reset8['mother_occupation']; ?>"></td></tr>
<tr><td>Mother Designation</td><td>&ensp; : &ensp;</td><td><input type="text" name= "mother_des" value="<?php echo $reset8['mother_des']; ?>"></td></tr>
<tr><td>Mother Office Phone</td><td>&ensp; : &ensp;</td><td><input type="text" name= "mother_office_phone" value="<?php echo $reset8['mother_office_phone']; ?>"></td></tr>
<tr><td>Mother Office Address</td><td>&ensp; : &ensp;</td><td><input type="text" name= "mother_office_address" value="<?php echo $reset8['mother_office_address']; ?>"></td></tr>

<tr><td colspan="3"><strong>Present Address Details</strong></td></tr>
<tr><td>Address Line</td><td>&ensp; : &ensp;</td><td><input type="text" name= "present_add_line" value="<?php echo $reset2['present_add_line']; ?>"></td></tr>
<tr><td>City</td><td>&ensp; : &ensp;</td><td><input type="text" name= "present_city" value="<?php echo $reset2['present_city']; ?>"></td></tr>
<tr><td>State</td><td>&ensp; : &ensp;</td><td><input type="text" name= "present_state" value="<?php echo $reset2['present_state']; ?>"></td></tr>
<tr><td>Country</td><td>&ensp; : &ensp;</td><td><input type="text" name= "present_country" value="<?php echo $reset2['present_country']; ?>"></td></tr>
<tr><td>PIN</td><td>&ensp; : &ensp;</td><td><input type="text" name= "present_pin" value="<?php echo $reset2['present_pin']; ?>"></td></tr>
<tr><td>Residential Phone</td><td>&ensp; : &ensp;</td><td><input type="text" name= "present_res_phone" value="<?php echo $reset2['present_res_phone']; ?>"></td></tr>

<tr><td colspan="3"><strong>Present Address Details</strong></td></tr>
<tr><td>Address Line</td><td>&ensp; : &ensp;</td><td><input type="text" name= "permanent_add_line" value="<?php echo $reset3['permanent_add_line']; ?>"></td></tr>
<tr><td>City</td><td>&ensp; : &ensp;</td><td><input type="text" name= "permanent_city" value="<?php echo $reset3['permanent_city']; ?>"></td></tr>
<tr><td>State</td><td>&ensp; : &ensp;</td><td><input type="text" name= "permanent_state" value="<?php echo $reset3['permanent_state']; ?>"></td></tr>
<tr><td>Country</td><td>&ensp; : &ensp;</td><td><input type="text" name= "permanent_country" value="<?php echo $reset3['permanent_country']; ?>"></td></tr>
<tr><td>PIN</td><td>&ensp; : &ensp;</td><td><input type="text" name= "permanent_pin" value="<?php echo $reset3['permanent_pin']; ?>"></td></tr>
<tr><td>Residential Phone</td><td>&ensp; : &ensp;</td><td><input type="text" name= "permanent_res_phone" value="<?php echo $reset3['permanent_res_phone']; ?>"></td></tr>

<tr><td colspan="3"><strong>Local Guardian Details</strong></td></tr>
<tr><td>Name</td><td>&ensp; : &ensp;</td><td><input type="text" name= "lg_name" value="<?php echo $reset9['lg_name']; ?>"></td></tr>
<tr><td>Address</td><td>&ensp; : &ensp;</td><td><input type="text" name= "lg_address" value="<?php echo $reset9['lg_address']; ?>"></td></tr>
<tr><td>Phone No.</td><td>&ensp; : &ensp;</td><td><input type="text" name= "lg_phone" value="<?php echo $reset9['lg_phone']; ?>"></td></tr>
<tr><td>Occupation</td><td>&ensp; : &ensp;</td><td><input type="text" name= "lg_occupation" value="<?php echo $reset9['lg_occupation']; ?>"></td></tr>
<tr><td>Office</td><td>&ensp; : &ensp;</td><td><input type="text" name= "lg_office" value="<?php echo $reset9['lg_office']; ?>"></td></tr>
<tr><td>Office Phone No.</td><td>&ensp; : &ensp;</td><td><input type="text" name= "lg_office_phone" value="<?php echo $reset9['lg_office_phone']; ?>"></td></tr>
</table>
<input type='submit' value='UPDATE' name='submit' style='background-color:#D4E6F4; border:2px solid;'/>
</form>


<?php

include_layout_template('footer.php');
if(isset($database)) { $database->close_connection(); }
ob_end_flush();

?>
