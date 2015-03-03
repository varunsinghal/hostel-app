<?php
ob_start();
require_once("../includes/initialize.php");
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
		if($ext!='jpg' && $ext!='jpeg' && $ext!='gif' && $ext!='png' && $ext!='JPG' && $ext!='JPEG' && $ext!='GIF' && $ext!='PNG'){
			redirect_to('reallot.php?error=fileformat&code='.$ext);
			exit;
		}
		else if($file_size>2097152)
		{
			redirect_to('reallot.php?error=filesize&code='.$filesize);
			exit;
		}
		if($ext=='jpg' || $ext=='jpeg' || $ext=='png' || $ext=='gif' || $ext=='JPG' || $ext=='JPEG' || $ext=='GIF' || $ext=='PNG'){
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
		$h2='/'.$_POST['course'].'/HO/';
	}
	if($_POST['gender']=='MALE'){
		$h3='';
	}
	else{
		$h3='G/';
	}
	$hostel_roll=$h1.$h2.$h3.$_POST['recipt'];

$last_yr_room = $_POST['last_hostel_name']." ".$_POST['last_room_no'];
if(isset($_POST['sub_category_code']))
{
  $_POST['category_code'] = $_POST['category_code'].$_POST['sub_category_code'];
}

?>

<?php

$message = "";

if(isset($_POST['submit'])){

  $student = new Student(); 
  //basic_details
  $student->name                  = $_POST['name'];
  $student->gender                = $_POST['gender'];
  $student->personal_phone        = $_POST['personal_phone'];
  $student->email                 = $_POST['email'];
  $student->recipt                = $hostel_roll;
  $student->category_code         = $_POST['category_code'];
  $student->last_room	          = $last_yr_room; 
  $student->backs                 = $_POST['back_papers'];
  $student->blood_group           = $_POST['blood_group'];
  $student->chronic               = $_POST['chronic'];
  $student->file                  = $filename;
  $student->father_name           = $_POST['father_name'];
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
  $student->bank_code             = $_POST['bank_code'];
  $student->bank_acc              = $_POST['bank_accountno']; 
  $student->bank_acc_name 		  = $_POST['bank_acc_name'];
  $student->bank_ifsc             = $_POST['bank_ifsc'];
  $student->bank_add              = $_POST['bank_add']; 
  //parent_details  
  $student->father_name2          = $_POST['father_name'];
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
  $student->distance              = '0';
  $student->document              = '0';
  $date                           = date('d-m-Y', time());

  if($student->save()){
	  //make form no
         $form_no = $student->year_of_admn;
  if($student->gender == 'MALE')
      {
        $form_no .= 'M';
      }
  else
      {
       $form_no .='F';
      }
  $form_no .= $student->student_id;
  //form no ends
  $attribute = array (
  '{form_no}'=>$form_no,
  '{date}'=>$date,
  '{name}'=>$_POST['name'],
  '{gender}'=>$_POST['gender'],
  '{personal_phone}'=>$_POST['personal_phone'],
  '{email}'=>$_POST['email'],
  '{recipt}'=>$_POST['roll_no'],
  '{hostel_roll}'=>$hostel_roll,
  '{category_code}'=>$_POST['category_code'],
  '{last_room}'=>$last_yr_room, 
  '{backs}'=>$_POST['back_papers'],
  '{school}'=>$_POST['school'],
  '{blood_group}'=>$_POST['blood_group'],
  '{chronic}'=>$_POST['chronic'],
  '{file}'=>$filename,
  '{father_name}'=>$_POST['father_name'],
  '{branch}'=>$_POST['branch'], 
  '{sem}'=>$_POST['sem'],
  '{year_of_admn}'=>$_POST['year_of_admn'],
  '{course}'=>$_POST['course'], 
  '{roll_no}'=>$_POST['roll_no'],
  '{bank_name}'=>$_POST['bank_name'],
  '{bank_code}'=>$_POST['bank_code'],
  '{bank_acc}'=>$_POST['bank_accountno'], 
  '{bank_acc_name}'=>$_POST['bank_acc_name'],
  '{bank_ifsc}'=>$_POST['bank_ifsc'],
  '{bank_add}'=>$_POST['bank_add'], 
  '{father_name2}'=>$_POST['father_name'],
  '{mother_name}'=>$_POST['mother_name'],
  '{father_phone}'=>$_POST['father_phone'],
  '{mother_phone}'=>$_POST['mother_phone'],
  '{father_email}'=>$_POST['father_email'],
  '{father_occupation}'=>$_POST['father_occupation'], 
  '{father_des}'=>$_POST['father_des'], 
  '{father_office_phone}'=>$_POST['father_office_phone'],
  '{mother_email}'=>$_POST['mother_email'],
  '{mother_occupation}'=>$_POST['mother_occupation'],
  '{mother_des}'=>$_POST['mother_des'],  
  '{mother_office_phone}'=>$_POST['mother_office_phone'],
  '{father_office_address}'=>$_POST['father_office_address'], 
  '{mother_office_address}'=>$_POST['mother_office_address'], 
  '{present_add_line}'=>$_POST['present_add_line'],
  '{present_city}'=>$_POST['present_city'],
  '{present_state}'=>$_POST['present_state'],
  '{present_country}'=>$_POST['present_country'],
  '{present_pin}'=>$_POST['present_pin'],
  '{present_res_phone}'=>$_POST['present_res_phone'],
  '{permanent_add_line}'=>$_POST['permanent_add_line'],
  '{permanent_city}'=>$_POST['permanent_city'],
  '{permanent_state}'=>$_POST['permanent_state'],
  '{permanent_country}'=>$_POST['permanent_country'],
  '{permanent_pin}'=>$_POST['permanent_pin'],
  '{permanent_res_phone}'=>$_POST['permanent_res_phone'],
  '{lg_name}'=>$_POST['lg_name'],
  '{lg_address}'=>$_POST['lg_address'],
  '{lg_phone}'=>$_POST['lg_phone'],
  '{lg_occupation}'=>$_POST['lg_occupation'],
  '{lg_office}'=>$_POST['lg_office'],
  '{lg_office_phone}'=>$_POST['lg_office_phone']);
	$html = file_get_contents ('layouts/reallot.inc.php');
	foreach($attribute as $key => $value){
  		$html = str_replace ("{$key}", $value, $html);
	}
	$filename = "html".DS.time().$student->student_id.".html";
	file_put_contents("mpdf".DS.$filename, $html);
	redirect_to('get_reallot.php?input_file=mpdf'.DS.$filename);
    	
    $message = "";
  } else {
    $message = "Form submission Failed. <a href='reallot.php'>Click Here</a> to refill the form.";
  }
   
}
$recieved_msg = output_message($message);
echo $recieved_msg;
echo '2';
?>

<?php
if(isset($database)) { $database->close_connection(); }
ob_end_flush();

?>
