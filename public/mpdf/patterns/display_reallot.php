<?php
ob_start();
require_once("../includes/initialize.php");
if(isset($_POST['submit'])){
    include_layout_template('form_header.php');
    }
    else {
    include_layout_template('display_header.php');
    include_once 'securimage/securimage.php';
    $securimage = new Securimage();
    if ($securimage->check($_POST['captcha_code']) == false) {
        echo '<script>history.go(-1)</script>';
        exit;
    }
    //upload photograph
	if( !empty($_FILES)){
		$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
		$file_size=$_FILES['file']['size'];
		if($ext!='jpg' && $ext!='jpeg' && $ext!='gif' && $ext!='png'){
			redirect_to('reallot.php?error=fileformat&code='.$ext);
			exit;
		}
		else if($file_size>2097152)
		{
			redirect_to('reallot.php?error=filesize&code='.$filesize);
			exit;
		}
		if($ext=='jpg' || $ext=='jpeg' || $ext=='png' || $ext=='gif'){
			$filename=time().'.'.$ext;
			$tempFile = $_FILES['file']['tmp_name'];
			$filename=time().'.'.$ext;
		if(move_uploaded_file($tempFile,'photo/'.$filename));
		//copy('photo/'.$filename, 'dompdf/tmp/photo/'.$filename);	
		}
	}
	//evaluate hostel roll no.
	$h1=str_split($_POST['year_of_admn']);
	$h1[1]='K';
	$h1=implode($h1);
	if($_POST['course']=='BTECH'){
		$h2='/HO/';
	}
	else{
		$h2=$_POST['course'].'/HO/';
	}
	if($_POST['gender']=='MALE'){
		$h3='';
	}
	else{
		$h3='G/';
	}
	$hostel_roll=$h1.$h2.$h3.$_POST['recipt'];
}

if(isset($_POST['sub_category_code']))
{
  $_POST['category_code'] = $_POST['category_code'].$_POST['sub_category_code'];
  $last_yr_room = $_POST['last_hostel_name']." ".$_POST['last_room_no'];
}

?>

<?php

$message = "";

if(isset($_POST['submit'])){
  // on pressing submit button

  $student = new Student(); 
  //basic_details
  $student->name                  = $_POST['name'];
  $student->gender                = $_POST['gender'];
  $student->personal_phone        = $_POST['personal_phone'];
  $student->email                 = $_POST['email'];
  $student->recipt                = $_POST['hostel_roll'];
  $student->category_code         = $_POST['category_code'];
  $student->last_room			  = $_POST['last_yr_room']; 
  $student->backs                 = $_POST['back_papers'];
  $student->blood_group           = $_POST['blood_group'];
  $student->chronic               = $_POST['chronic'];
  $student->file                  = $_POST['file'];
  $student->reallot               = 1;
  //academic_details
  if($_POST['back_papers'] > 0)
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
  $student->bank_name 			  = $_POST['bank_name'];
  $student->bank_ifsc             = $_POST['bank_code'];
  $student->bank_acc              = $_POST['bank_accountno']; 
  //parent_details  
  $student->father_name           = $_POST['father_name'];
  $student->mother_name           = $_POST['mother_name'];
  $student->father_phone          = $_POST['father_phone'];
  $student->mother_phone          = $_POST['mother_phone'];
  $student->father_email          = $_POST['father_email'];
  $student->father_occupation     = $_POST['father_occupation']; 
  $student->father_office_phone   = $_POST['father_office_phone'];
  $student->mother_email          = $_POST['mother_email'];
  $student->mother_occupation     = $_POST['mother_occupation'];   
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
  $student->distance              = '0';
  $student->document              = '0';

  if($student->save()){
    $message = "Form Submitted Successfully! Get <strong>pdf version</strong> of application form at the bottom of this page | <strong>Don't forget to save this file. Press Ctrl + S to save.</strong>";
  } else {
    $message = "Form submission Failed. <a href='reallot.php'>Click Here</a> to refill the form.";
  }
} else {
    $message = "Note : If there is some error in the form <a href='#' onclick='history.go(-1);return false;'>Click Here</a> to refill the form. Only Submit the form when you are completely sure about the correctness of data.";
}

$recieved_msg = output_message($message);
echo $recieved_msg;


?>
<style>
table{
width:100%;
}
tr,td{
border: 1px solid black;
word-break: break-word
}
table,tr,td{
border-collapse: collapse;
vertical-align: middle;
text-align: left;
font: 13px Verdana, Geneva, sans-serif;
padding: 2px;
}
#photo{

}
*/
</style>


<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <table id="header">
	<tr>
	  <td style="text-align:center">
	  <?php 
	  if(isset($_POST['submit'])){
      echo "<font size='+4'>";
      echo date("Y") - $student->year_of_admn;
      if($student->gender == 'MALE')
      {
        echo 'M';
      }
      else
      {
      echo 'F';
      }
     echo $student->student_id;
     echo "</font><br />Hostel Roll Number : ";
     echo $_POST['hostel_roll'];
	 }
	 else{
		echo '<b>Photograph final Instructions</b><br/>';
		echo 'Face should cover 75% of the photograph.';
	 }
	 ?>
	 </td>
	 <td>
	 <?php
	 if(isset($_POST['submit'])){
	 echo '<img src="photo/'.$_POST['file'].'" height="150" width="150" id="photo" >';
	 }
	 else{
	 echo '<img src="photo/'.$filename.'" height="150" width="150" id="photo" >';
	 echo '<input type="hidden" value="'.$filename.'" name="file">';
	 }
	 ?>
	 </td>
	  </tr>
	  </table>
	  <table>
      <tr>
        <td>Name</td><td><?php echo isset($_POST['submit']) ? $_POST['name'] : '<input type="text" name="name" value="'.strtoupper($_POST['name']).'" readonly="readonly" />'; ?></td>
		<td colspan="2"><b>ACADEMIC DETAILS</b></td>
	  </tr>
      <tr>
        <td>Gender</td><td><?php echo isset($_POST['submit']) ? $_POST['gender'] : '<input type="text" name="gender" value="'.$_POST['gender'].'" readonly="readonly"  />'; ?></td>
		<td>Roll No. / Reg No.</td><td><?php echo isset($_POST['submit']) ? $_POST['roll_no'] : '<input type="text" name="roll_no" value="'.$_POST['roll_no'].'" readonly="readonly" />'; ?></td>
	 </tr>
	  <tr>
        <td>Personal Mobile No.</td><td><?php echo isset($_POST['submit']) ? $_POST['personal_phone'] : '<input type="text" name="personal_phone" value="'.$_POST['personal_phone'].'" readonly="readonly" />'; ?></td>
		<td>Course</td><td><?php echo isset($_POST['submit']) ? $_POST['course'] : '<input type="text" name="course" value="'.$_POST['course'].'" readonly="readonly"  />'; ?></td>
	  </tr>
      <tr>
        <td>E - mail id</td><td><?php echo isset($_POST['submit']) ? $_POST['email'] : '<input type="text" name="email" value="'.$_POST['email'].'" readonly="readonly"  />'; ?></td>
        <td>Branch</td><td><?php echo isset($_POST['submit']) ? $_POST['branch'] : '<input type="text" name="branch" value="'.$_POST['branch'].'" readonly="readonly"   />'; ?></td>
		</tr>
	  <tr>
        <td>Hostel Roll Number</td><td><?php echo isset($_POST['submit']) ? $_POST['hostel_roll'] : '<input type="text" name="hostel_roll" value="'.$hostel_roll.'" readonly="readonly" />'; ?></td>
		<td>Semester</td><td><?php echo isset($_POST['submit']) ? $_POST['sem'] : '<input type="text" name="sem" value="'.$_POST['sem'].'" readonly="readonly"   />'; ?></td>
	  </tr>
	   <tr>
        <td>Admission category</td><td><?php echo isset($_POST['submit']) ? $_POST['category_code'] : '<input type="text" name="category_code" value="'.$_POST['category_code'].'" readonly="readonly"  />'; ?></td>
		<td>Year of Admission</td><td><?php echo isset($_POST['submit']) ? $_POST['year_of_admn'] : '<input type="text" name="year_of_admn" value="'.$_POST['year_of_admn'].'" readonly="readonly"   />'; ?></td>
	  </tr>
	  <tr>
        <td>Last Room</td><td><?php echo isset($_POST['submit']) ? $_POST['last_yr_room'] : '<input type="text" name="last_yr_room" value="'.$last_yr_room.'" readonly="readonly"  />'; ?></td>
        <td colspan="2"><b>BANK DETAILS</b></td>
	  </tr>
	  <tr>
        <td>Back Papers</td><td><?php echo isset($_POST['submit']) ? $_POST['back_papers'] : '<input type="text" name="back_papers" value="'.$_POST['back_papers'].'" readonly="readonly"  />'; ?></td>
        <td>Bank Name</td><td><?php echo isset($_POST['submit']) ? $_POST['bank_name'] : '<input type="text" name="bank_name" value="'.$_POST['bank_name'].'" readonly="readonly"   />'; ?></td>
	  </tr>
	   <tr>
        <td>Blood Group</td><td><?php echo isset($_POST['submit']) ? $_POST['blood_group'] : '<input type="text" name="blood_group" value="'.$_POST['blood_group'].'" readonly="readonly"  />'; ?></td>
		<td>Bank IFSC Code</td><td><?php echo isset($_POST['submit']) ? $_POST['bank_code'] : '<input type="text" name="bank_code" value="'.$_POST['bank_code'].'" readonly="readonly"   />'; ?></td>
	  </tr>
      <tr>
        <td>Chronic Problems if Any</td><td><?php echo isset($_POST['submit']) ? $_POST['chronic'] : '<input type="text" name="chronic" value="'.$_POST['chronic'].'" readonly="readonly"/>'; ?></td>
		<td>Bank Account No</td><td><?php echo isset($_POST['submit']) ? $_POST['bank_accountno'] : '<input type="text" name="bank_accountno" value="'.$_POST['bank_accountno'].'" readonly="readonly"   />'; ?></td>
	  </tr>
	  </table>
	  <table>
	  <tr>
	  <td colspan="4"><b>PARENTS DETAILS</b></td>
	  </tr>
	  <tr>
		<td>Fathers Name</td><td><?php echo isset($_POST['submit']) ? $_POST['father_name'] : '<input type="text" name="father_name" value="'.strtoupper($_POST['father_name']).'" readonly="readonly" />'; ?></td>
		<td>Mothers Name</td><td><?php echo isset($_POST['submit']) ? $_POST['mother_name'] : '<input type="text" name="mother_name" value="'.strtoupper($_POST['mother_name']).'" readonly="readonly" />'; ?></td>
	  </tr>
      <tr>
        <td>Fathers Phone No.</td><td><?php echo isset($_POST['submit']) ? $_POST['father_phone'] : '<input type="text" name="father_phone" value="'.$_POST['father_phone'].'" readonly="readonly" />'; ?></td>
        <td>Mothers Phone No.</td><td><?php echo isset($_POST['submit']) ? $_POST['mother_phone'] : '<input type="text" name="mother_phone" value="'.$_POST['mother_phone'].'" readonly="readonly"/>'; ?></td>
	  </tr>
	  <tr>
        <td>Fathers E-mail ID</td><td><?php echo isset($_POST['submit']) ? $_POST['father_email'] : '<input type="text" name="father_email" value="'.$_POST['father_email'].'" readonly="readonly" />'; ?></td>
        <td>Mothers E-mail ID</td><td><?php echo isset($_POST['submit']) ? $_POST['mother_email'] : '<input type="text" name="mother_email" value="'.$_POST['mother_email'].'" readonly="readonly" />'; ?></td>
	  </tr>
	  <tr>
        <td>Fathers Occupation</td><td><?php echo isset($_POST['submit']) ? $_POST['father_occupation'] : '<input type="text" name="father_occupation" value="'.$_POST['father_occupation'].'" readonly="readonly" />'; ?></td>
        <td>Mothers Occupation</td><td><?php echo isset($_POST['submit']) ? $_POST['mother_occupation'] : '<input type="text" name="mother_occupation" value="'.$_POST['mother_occupation'].'" readonly="readonly" />'; ?></td>
	  </tr>
	  <tr>
        <td>Fathers Office Address</td><td><?php echo isset($_POST['submit']) ? $_POST['father_office_address'] : '<input type="text" name="father_office_address" value="'.$_POST['father_office_address'].'" readonly="readonly" />'; ?></td>
        <td>Mothers Office Address</td><td><?php echo isset($_POST['submit']) ? $_POST['mother_office_address'] : '<input type="text" name="mother_office_address" value="'.$_POST['mother_office_address'].'" readonly="readonly" />'; ?></td>
	  </tr>
	  <tr>
        <td>Fathers Office Phone (Landline)</td><td><?php echo isset($_POST['submit']) ? $_POST['father_office_phone'] : '<input type="text" name="father_office_phone" value="'.$_POST['father_office_phone'].'" readonly="readonly" />'; ?></td>
	    <td>Mothers Office Phone (Landline)</td><td><?php echo isset($_POST['submit']) ? $_POST['mother_office_phone'] : '<input type="text" name="mother_office_phone" value="'.$_POST['mother_office_phone'].'" readonly="readonly" />'; ?></td>
     </tr>
	  </table>
	  <table>
	 <tr>
	 <td colspan="2"><b>PRESENT RESIDENTIAL ADDRESS</b></td>
	 <td colspan="2"><b>PERMANENT RESIDENTIAL ADDRESS</b></td>
	 </tr>
      <tr>
        <td>Address Line</td><td><?php echo isset($_POST['submit']) ? $_POST['present_add_line'] : '<input type="text" name="present_add_line" value="'.$_POST['present_add_line'].'" readonly="readonly"   />'; ?></td>
        <td>Address Line</td><td><?php echo isset($_POST['submit']) ? $_POST['permanent_add_line'] : '<input type="text" name="permanent_add_line" value="'.$_POST['permanent_add_line'].'" readonly="readonly"   />'; ?></td>
		</tr>
      <tr>
        <td>City</td><td><?php echo isset($_POST['submit']) ? $_POST['present_city'] : '<input type="text" name="present_city" value="'.$_POST['present_city'].'" readonly="readonly"   />'; ?></td>
        <td>City</td><td><?php echo isset($_POST['submit']) ? $_POST['permanent_city'] : '<input type="text" name="permanent_city" value="'.$_POST['permanent_city'].'" readonly="readonly"   />'; ?></td>
	  </tr>
      <tr>
        <td>State</td><td><?php echo isset($_POST['submit']) ? $_POST['present_state'] : '<input type="text" name="present_state" value="'.$_POST['present_state'].'" readonly="readonly"   />'; ?></td>
        <td>State</td><td><?php echo isset($_POST['submit']) ? $_POST['permanent_state'] : '<input type="text" name="permanent_state" value="'.$_POST['permanent_state'].'" readonly="readonly"   />'; ?></td>
	  </tr>
      <tr>
        <td>Country</td><td><?php echo isset($_POST['submit']) ? $_POST['present_country'] : '<input type="text" name="present_country" value="'.$_POST['present_country'].'" readonly="readonly"   />'; ?></td>
        <td>Country</td><td><?php echo isset($_POST['submit']) ? $_POST['permanent_country'] : '<input type="text" name="permanent_country" value="'.$_POST['permanent_country'].'" readonly="readonly"   />'; ?></td>
     </tr>
      <tr>
        <td>Pin</td><td><?php echo isset($_POST['submit']) ? $_POST['present_pin'] : '<input type="text" name="present_pin" value="'.$_POST['present_pin'].'" readonly="readonly"   />'; ?></td>
        <td>Pin</td><td><?php echo isset($_POST['submit']) ? $_POST['permanent_pin'] : '<input type="text" name="permanent_pin" value="'.$_POST['permanent_pin'].'" readonly="readonly"   />'; ?></td>
    </tr>
      <tr>
        <td>Residential Phone</td><td><?php echo isset($_POST['submit']) ? $_POST['present_res_phone'] : '<input type="text" name="present_res_phone" value="'.$_POST['present_res_phone'].'" readonly="readonly"   />'; ?></td>
        <td>Residential Phone</td><td><?php echo isset($_POST['submit']) ? $_POST['permanent_res_phone'] : '<input type="text" name="permanent_res_phone" value="'.$_POST['permanent_res_phone'].'" readonly="readonly"   />'; ?></td>
     </tr>
	 </table>
	 <table>
	  <tr>
	  <td colspan="4"><b>LOCAL GUARDIAN DETAILS</b></td>
	  </tr>
      <tr>
        <td>Name</td><td><?php echo isset($_POST['submit']) ? $_POST['lg_name'] : '<input type="text" name="lg_name" value="'.$_POST['lg_name'].'" readonly="readonly"   />'; ?></td>
        <td>Occupation</td><td><?php echo isset($_POST['submit']) ? $_POST['lg_occupation'] : '<input type="text" name="lg_occupation" value="'.$_POST['lg_occupation'].'" readonly="readonly"   />'; ?></td>
      </tr>
      <tr>
        <td>Address</td><td><?php echo isset($_POST['submit']) ? $_POST['lg_address'] : '<input type="text" name="lg_address" value="'.$_POST['lg_address'].'" readonly="readonly"   />'; ?></td>
        <td>Office Address</td><td><?php echo isset($_POST['submit']) ? $_POST['lg_office'] : '<input type="text" name="lg_office" value="'.$_POST['lg_office'].'" readonly="readonly"   />'; ?></td>
      </tr>
      <tr>
        <td>Phone</td><td><?php echo isset($_POST['submit']) ? $_POST['lg_phone'] : '<input type="text" name="lg_phone" value="'.$_POST['lg_phone'].'" readonly="readonly"   />'; ?></td>
		<td>Office Phone(Landline)</td><td><?php echo isset($_POST['submit']) ? $_POST['lg_office_phone'] : '<input type="text" name="lg_office_phone" value="'.$_POST['lg_office_phone'].'" readonly="readonly"   />'; ?></td>
	  </tr>
	  
	  </table>
	  
	
	
	  
    
	<br/>
	<?php if(!isset($_POST['submit'])){echo "<center><input type='submit' value='CONFIRM' name='submit' style='background-color:#D4E6F4; border:2px solid;'/></center>";} ?>
</form>


<?php

if(isset($_POST['submit'])){
    include_layout_template('form_footer_reallot.php');

    $filename = "html".DS.$student->student_id.".html";

    file_put_contents("mpdf".DS.$filename, ob_get_contents());

    echo '<h1><img src="images/pdf_icon.png"> <a href="get_pdf.php?input_file='.$filename.'">Click Here</a> to get the pdf version of this form</h1>';

} else {
    include_layout_template('footer.php');
}
if(isset($database)) { $database->close_connection(); }
ob_end_flush();

?>