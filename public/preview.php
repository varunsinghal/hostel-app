<?php

ob_start();

require_once("../includes/initialize.php");
//include_layout_template('header.php');

if(!$session->is_logged_in()){
    redirect_to("error.php?i=2");
}

?>
<br/><br/>
<?php
$form_location=$_GET['form'];
  //form no ends
  $attribute = array (
  '{form_no}'=>'2011M12',
  '{date}'=>date('d-m-Y', time()),
  '{name}'=>'VARUN SINGHAL',
  '{gender}'=>'MALE',
  '{personal_phone}'=>'9717972811',
  '{email}'=>'varunsinghal15@gmail.com',
  '{hostel_roll}'=>'2K11/HO/282',
  '{category_code}'=>'OOP',
  '{last_room}'=>'CVR 320', 
  '{backs}'=>'0',
  '{school}'=>'St. Joseph Convent School',
  '{blood_group}'=>'B+',
  '{chronic}'=>'nil',
  '{file}'=>'sample-user.png',
  '{father_name}'=>'ABCD',
  '{last_sr1}'=>'Last Sem: 73.30',
  '{last_sr2}'=>'2nd Last Sem: 82.29',
  '{branch}'=>'ECE', 
  '{sem}'=>'7',
  '{year_of_admn}'=>'2011',
  '{course}'=>'B.Tech', 
  '{roll_no}'=>'2K11/EC/163',
  '{bank_name}'=>'State Bank of India',
  '{bank_code}'=>'10446',
  '{bank_acc}'=>'00000000087', 
  '{bank_acc_name}'=>'Varun Singhal',
  '{bank_ifsc}'=>'SBIN0010446',
  '{bank_add}'=>'Delhi College of Engineering, Bawana Road', 
  '{father_name2}'=>'ABCD',
  '{mother_name}'=>'XYZ',
  '{father_phone}'=>'9876543210',
  '{mother_phone}'=>'0123456789',
  '{father_email}'=>'father@email.com',
  '{father_occupation}'=>'Service', 
  '{father_des}'=>'abcd', 
  '{father_office_phone}'=>'01291234567',
  '{mother_email}'=>'mother@email.com',
  '{mother_occupation}'=>'Housewife',
  '{mother_des}'=>'xyz',  
  '{mother_office_phone}'=>'01291234567',
  '{father_office_address}'=>'Delhi', 
  '{mother_office_address}'=>'None', 
  '{present_add_line}'=>'House no. 2450, ground floor, sainik colony, sector 49,',
  '{present_city}'=>'Faridabad',
  '{present_state}'=>'Haryana',
  '{present_country}'=>'India',
  '{present_pin}'=>'121001',
  '{present_res_phone}'=>'01292222222',
  '{permanent_add_line}'=>'House no. 2450, ground floor, sainik colony, sector 49,',
  '{permanent_city}'=>'Faridabad',
  '{permanent_state}'=>'Haryana',
  '{permanent_country}'=>'India',
  '{permanent_pin}'=>'121001',
  '{permanent_res_phone}'=>'01292222222',
  '{lg_name}'=>'Nil',
  '{lg_address}'=>'-',
  '{lg_phone}'=>'-',
  '{lg_occupation}'=>'-',
  '{lg_office}'=>'-',
  '{lg_office_phone}'=>'-');
	$html = file_get_contents ($form_location);
	foreach($attribute as $key => $value){
  		$html = str_replace ("{$key}", $value, $html);
	}
	echo $html;
?>
<?php
if(isset($database)) { $database->close_connection(); }
ob_end_flush();

?>
