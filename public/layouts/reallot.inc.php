<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="utf-8" />

<title>Reallotment Form</title>

<link rel="stylesheet" href="stylesheets2/reset.css" />

<link rel="stylesheet" href="stylesheets2/text.css" />

<link rel="stylesheet" href="stylesheets2/960.css" />

<style>

table{

width:100%;

}

tr, td {

border-bottom: 1px solid black;

}

</style>

</head>

<body>

<div class="container_12">

<div class="grid_2">

<img src="images/logo.gif" width="70">

</div>

<div class="grid_5">

<span style="font-size:15px">DELHI TECHNOLOGICAL UNIVERSITY</span><br />

<span>(Formerly Delhi College of Engineering)</span><br/>

<small>Established under Govt. of Delhi Act 6 of 2009</small>

</div>

<div class="grid_5" align="right">

<span style="font-size:15px">HOSTEL <b>REALLOTMENT</b> FORM</span><br />

<span>ACADEMIC YEAR 2015 - 2016</span><br />

<small>SHAHBAD, BAWANA ROAD, DELHI, PH - 27852204</small>

</div>

<div class="clear"><br>&ensp;<br></div>
</div>

<div class="container_12">

<div class="grid_6">

<h3 align="center">Form No: {form_no} <br/> Roll: {hostel_roll}</h3>

</div>

<div class="grid_6">

<img src="photo/{file}" height="100" width="100"></td>

</div>

</div>



<div class="container_12" style="padding-top:20px;">

	<!-- Start personal Details -->

  <div class="grid_6">

    <table>

	<tr><td colspan="2"><b>PERSONAL DETAILS</b></td></tr>

	<tr><td>Name</td><td>{name}</td></tr>

	<tr><td>Gender</td><td>{gender}</td></tr>

	<tr><td>Personal Mobile No.</td><td>{personal_phone}</td></tr>

	<tr><td>E - mail id</td><td>{email}</td></tr>

	<tr><td>Admission category</td><td>{category_code}</td></tr>

	<tr><td>Back Papers<small>(For Senior)</small></td><td>{backs}</td></tr>

	<tr><td>Last Room</td><td><b>{last_room}</b></td></tr>
	
	<tr><td>Hostel Roll No.</td><td>{hostel_roll}</td></tr>

	<tr><td>Blood Group</td><td>{blood_group}</td></tr>

	<tr><td>Chronic Problems</td><td>{chronic}</td></tr>

	</table>

  </div>

  <!-- End personal Details -->

  <!-- Start Bank and academic Details -->

  <div class="grid_6">

    <table>

	<tr><td colspan="2"><b>ACADEMIC DETAILS</b></td></tr>
	
	<tr><td>Course</td><td>{course}</td></tr>

	<tr><td>Reg No. / Roll No.</td><td>{roll_no}</td></tr>

	<tr><td>Branch</td><td>{branch}</td></tr>

	<tr><td>Semester</td><td>{sem}</td></tr>

	<tr><td colspan="2"><b>BANK DETAILS</b></td></tr>

	<tr><td>Account Holder Name</td><td>{bank_acc_name}</td></tr>

	<tr><td>Bank Account No</td><td>{bank_acc}</td></tr>

	<tr><td>Bank Name</td><td>{bank_name}</td></tr>

	<tr><td>Branch Code</td><td>{bank_code}</td></tr>

	<tr><td>Bank IFSC Code</td><td>{bank_ifsc}</td></tr>

	<tr><td>Branch Address</td><td>{bank_add}</td></tr>

	</table>

  </div>

  <!-- End Bank and academic Details -->

  <!-- Start Parent Details -->

  <div class="grid_6">

    <table>

	<tr><td colspan="2"><b>PARENT'S DETAILS</b></td></tr>

	<tr><td>Father's Name</td><td>{father_name}</td></tr>						

	<tr><td>Father's Mobile No.</td><td>{father_phone}</td></tr>		

	<tr><td>Father's E - mail id</td><td>{father_email}</td></tr>			

	<tr><td>Father's occupation</td><td>{father_occupation}</td></tr>		

	<tr><td>Father's Designation</td><td>{father_des}</td></tr>		

	<tr><td>Father's Office Address</td><td>{father_office_address}</td></tr>	

	<tr><td>Father's Office Phone</td><td>{father_office_phone}</td></tr>	

	</table>

  </div>

  <div class="grid_6">

  <table>

  <tr><td colspan="2"><b>&nbsp;</b></td></tr>

  <tr><td>Mother's Name</td><td>{mother_name}</td></tr>

  <tr><td>Mother's Mobile No.</td><td>{mother_phone}</td></tr>

  <tr><td>Mother's E - mail id</td><td>{mother_email}</td></tr>

  <tr><td>Mother's occupation</td><td>{mother_occupation}</td></tr>

  <tr><td>Mother's Designation</td><td>{mother_des}</td></tr>

  <tr><td>Mother's Office Address</td><td>{mother_office_address}</td></tr>

  <tr><td>Mother's Office Phone</td><td>{mother_office_phone}</td></tr>

  </table>

  </div>

  <!--End parent's Details-->

  <!-- Start Address details-->

  <div class="grid_6">

    <table>

	<tr><td colspan=2><b>PRESENT RESIDENTIAL ADDRESS</b></td></tr>

	<tr><td>Address Line</td><td>{present_add_line}</td></tr>

	<tr><td>City</td><td>{present_city}</td></tr>

	<tr><td>State</td><td>{present_state}</td></tr>

	<tr><td>Country</td><td>{present_country}</td></tr>

	<tr><td>Pin</td><td>{present_pin}</td></tr>

	<tr><td>Residential Phone</td><td>{present_res_phone}</td></tr>

	</table>

  </div>

  <div class="grid_6">

    <table>

	<tr><td colspan=2><b>PERMANENT RESIDENTIAL ADDRESS</b></td></tr>

	<tr><td>Address Line</td><td>{permanent_add_line}</td></tr>

	<tr><td>City</td><td>{permanent_city}</td></tr>

	<tr><td>State</td><td>{permanent_state}</td></tr>

	<tr><td>Country</td><td>{permanent_country}</td></tr>

	<tr><td>Pin</td><td>{permanent_pin}</td></tr>

	<tr><td>Residential Phone</td><td>{permanent_res_phone}</td></tr>

	</table>

  </div>

  <!-- End Address Details-->

   <div class="grid_6">

    <table>

	<tr><td colspan="2"><b>LOCAL GUARDIAN DETAILS</b></td></tr>

	<tr><td>Name</td><td>{lg_name}</td></tr>

	<tr><td>Address</td><td>{lg_address}</td></tr>

	<tr><td>Phone</td><td>{lg_phone}</td></tr>

	</table>

  </div>

  <div class="grid_6">

  <table>

  <tr><td colspan="2"><b>&nbsp;</b></td></tr>

  <tr><td>Occupation</td><td>{lg_occupation}</td></tr>

  <tr><td>Office Address</td><td>{lg_office}</td></tr>

  <tr><td>Office Phone (Landline)</td><td>{lg_office_phone}</td></tr>

  </table>

  </div>

  <div class="clear"><br/></div>

</div>

<div class="container_12">

<div class="grid_8">

&nbsp; 

</div>

<div class="grid_4" style="text-align:right"><br/>

____________________________<br/>

Signature of Applicant

</div>

<div class="grid_12">

<b>Terms & Conditions :</b>

<ol style="text-align:justify">

<li>No hostel resident is allowed to keep any motorized vehicle in the University. However, bicycles are permitted for local/internal transport within DTU campus. Disciplinary action including fine and expulsion will be imposed on the defaulters.</li>

<li>Once the hostel allotment is made no further request for change of room or hostel will be considered, if any such request is placed by candidate then the candidature of that student will be treated as withdrawn and his/her allotment will stand cancelled.</li>

<li>The students who have been admitted in the University under Outside Delhi category, but residing in Delhi, NCR will be considered as Delhi Category student for the purpose of hostel allotment.</li>

<li>After the allotment of the room the allottee will be held responsible for any damage in his/her room, and the allottee shall bear the cost of damage as decided by the warden and Officer Incharge, Hostel.</li>

<li>The day scholar has to take prior permission from the Warden & have to submit the fees before staying with someone in the hostel and such permission shall be approved by Officer Incharge, Hostel Office atleast two days before the requested date of stay.</li>

<li>The accommodation in the hostels will be provided as per the academic calendar declared by the DTU administration/Dean Academics. Every student shall have to vacate the hostel within 3 days of his/her last end semester examination every year. Each year a new allotement applicaion is to be submitted.</li>

<li>If any student tries to influence the DTU hostel administration through any means his/her candidature will stand cancelled and the decision of the hostel office in such matters will be final.</li>

<li>Day scholars are not allowed to stay with any hosteller without prior permission, if any day scholar is found staying with the hosteller in his/her room without prior permission of warden & Officer Incharge, Hostels, the allotment of such hosteller will be immediately cancelled without any notice and such candidates will not be considered for future hostel allotment.</li>

<li>Hostel office reserves all the rights for allotment, cancellation & rejection of hostel allotment applications. In this regard the authority of Hostel Office/administration is final.</li>

</ol>

</div>

<div class="grid_8">

 &nbsp; 

</div>


<div class="grid_4" style="text-align:right">

____________________________<br/>

Signature of Applicant

</div>

<div class="grid_12">

<b>I certify :</b>

<ol style="text-align:justify">

<li>That I shall vacate my room within 3 days of last examination in each year.</li>

<li>That I shall abide the rules and regulations of University Hostels and the University and shall conduct in a manner worthy of being a student of DTU and shall never indulge in indiscipline/voilence.</li>

<li>That the information furnished by me is true to the best of my knowledge and belief. If any information found wrong my admission may be cancelled.</li>

</ol>

</div>

<div class="grid_8">

 &nbsp; 

</div>


<div class="grid_4" style="text-align:right"><br/>

____________________________<br/>

Signature of Applicant

</div>
<div class="grid_12">
<b>Remarks by Warden:</b>
</div>

<div class="grid_8">

 &nbsp; 

</div>

<div class="grid_4" style="text-align:right"><br/>

____________________________<br/>

Signature of Warden

</div>

<div class="grid_12">

Following Documents will be required duly attested -

<ol>

<li>Latest proof of parent's residence. (Latest electricity/water bill/gas connection bill/land line telephone bill/Aadhar card)</li>

<li>Result of last semesters</li>

<li>Room Surrender Application</li>

<li>No dues clearance from Mess and hostel office.</li>

<li>Current hostel-id card (original).</li>

<li>Photocopy of bank's passbook.</li>

</ol>

</div>

<div class="grid_12" style="color:grey;text-align:center">

Powered By DWD-DTU, Copyright 2015.

</div>

<!-- end .container_16 -->

</body>

</html>

