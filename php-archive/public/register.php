<?php

ob_start();

require_once("../includes/initialize.php");
include_layout_template('header.php');

$query = "SELECT * FROM control_variables WHERE control = 'registration' LIMIT 1";
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_array($result);

if(!$session->is_logged_in()){
if($row['flag'] == 0)
{
    redirect_to("error.php?i=2");
}
}
//check terms
if(!$session->terms()){
  redirect_to("terms.php?i=2");
}

if(isset($_GET['error'])){
    if($_GET['error']=='captcha'){
        echo "<font color='red'>".output_message("Wrong captcha code entered. Please re-enter.")."</font>";
    } else {
        echo "<font color='red'>".output_message("Some error occurred. Please re-enter.")."</font>";
    }
}
?>
<script type="text/javascript">
function copy_data_from_present(){
  document.getElementById("f32").value = document.getElementById("f26").value;
  document.getElementById("f33").value = document.getElementById("f27").value;
  document.getElementById("f34").value = document.getElementById("f28").value;
  document.getElementById("f35").value = document.getElementById("f29").value;
  document.getElementById("f36").value = document.getElementById("f30").value;
  document.getElementById("f37").value = document.getElementById("f31").value;
}

function categorylr(course){
  lr(document.getElementById("f1").value);
  //update category
  if(course=='BTECH'){
  	document.reg_form.category.options.length=0
  	 <?php 
  	  $i = 0;
          $query = $db->query("SELECT * from category");
          while($row = $db->fetch_array($query)){
          echo 'document.reg_form.category.options['.$i.']=new Option("'.$row[0].'", "'.$row[0].'", false, false);';
          $i++;
          }
          ?>
  }
  else{
  	document.reg_form.category.options.length=0
  	document.reg_form.category.options[0]=new Option("GEN", "PG-GEN", true, false);
	document.reg_form.category.options[1]=new Option("OBC", "PG-OBC", false, false);
	document.reg_form.category.options[2]=new Option("SC", "PG-SC", false, false);
	document.reg_form.category.options[3]=new Option("ST", "PG-ST", false, false);
  }

}

function lr(sem){
if(sem=='1' && document.getElementById("f51").value == 'BTECH'){
document.getElementById("f45").innerHTML ="JEE MAIN Rank";
document.getElementById("f46").innerHTML ="JEE MAIN Score";
}
else if(document.getElementById("f51").value == 'MTECH'){
document.getElementById("f45").innerHTML ="GATE Score";
document.getElementById("f46").innerHTML ="GATE Rank";
}
else if(document.getElementById("f51").value == 'MBA'){
document.getElementById("f45").innerHTML ="CAT Score";
document.getElementById("f46").innerHTML ="CAT Percentile";
}
else{
document.getElementById("f45").innerHTML ="Last Semester result";
document.getElementById("f46").innerHTML ="2nd Last Semester result";
}

}
function popitup(url) {
	newwindow = window.open(url, 'name', 'height=500,width=600');
	if (window.focus) {
		newwindow.focus();
	}
	return false;
}
</script>

<script type="text/javascript" src="js/livevalidation_standalone.compressed.js"></script>
<link rel="stylesheet" href="stylesheets2/validation.css" />
                                           
<form method="post" action="display.php" enctype="multipart/form-data" name="reg_form" onsubmit="return confirm('Submit the form?');">


<table>
<tr>
 <th>Academic Details</th>
</tr>
<tr>
    <td>
        Course</td><td>
        <select name="course" id="f51" onchange="categorylr(this.value);" >
        <option value="BTECH" id="btech">B.TECH</option>
	<option value="MTECH" id="mtech">M.TECH</option>
	<option value="MBA" id="mba">MBA</option>
	</select>
    </td>
</tr>

<tr>
        <td>Branch</td><td><?php include "layouts/branch.txt"; ?></td>
</tr>

<tr>
    <td>
        Semester on starting of session 2014-15</td>
    <td>
        <input type="text" name="sem" size="50" id="f1" onchange="lr(this.value)"/>
        <script type="text/javascript">
        var f1 = new LiveValidation('f1', { validMessage: "Correct!"});
        f1.add(Validate.Presence);
        f1.add( Validate.Numericality, { onlyInteger: true, minimum: 1 } );
        f1.add( Validate.Length, { is: 1 } );
        </script>
    </td>
</tr>
<tr>
        <td>Year of Admission</td>
        <td>
            <input type="text" name="year_of_admn" id="f2" size="50" />
            <script type="text/javascript">
		var f2 = new LiveValidation('f2', { validMessage: "Correct!"});
		f2.add(Validate.Presence);
                f2.add( Validate.Numericality, { onlyInteger: true, minimum: <?php  echo date("Y", time())-5; ?>, maximum: <?php  echo date("Y", time())+5; ?> } );
                f2.add( Validate.Length, { is: 4 } );
	    </script>
        </td>
</tr>

<tr>
    <td id="f50">University Registration No.<br/>
	<small>(1st year students enter JEE Mains Roll No.)</small>
	</td>
        <td>
            <input type="text" name="roll_no" id="f3" size="50" />
            <script type="text/javascript">
		var f3 = new LiveValidation('f3', { validMessage: "Correct!"});
		f3.add(Validate.Presence);
		f3.add(Validate.Length, { minimum: 2 } );
	    </script>
        </td>
      </tr>
<tr><td>&ensp;</td></tr>
<tr><td>&ensp;</td></tr>
<tr><th>Basic Details</th></tr>
      <tr>
        <td><label for="name">Name</label></td>
        <td>
            <input type="text" name="name" size="50" id="f4" />
            <script type="text/javascript">
		var f4 = new LiveValidation('f4', { validMessage: "Correct!"});
		f4.add(Validate.Presence);
	    </script>
        </td>
      </tr>

      <tr>
        <td>Gender</td>
        <td>
          <input type="radio" name="gender" value="MALE" checked="checked"  id="f48"/><label for="f48">Male</label><input type="radio" name="gender" value="FEMALE" id="f49"/><label for="f49">Female</label>
        </td>
      </tr>
      <tr>
        <td>Personal Mobile No.</td>
        <td>
            <input type="text" name="personal_phone" maxlength="10" size="50" id="f5" />
            <script type="text/javascript">
		var f5 = new LiveValidation('f5', { validMessage: "Correct!"});
		f5.add(Validate.Presence);
		f5.add( Validate.Length, { is: 10 } );
		f5.add( Validate.Numericality, { onlyInteger: true, minimum: 1000000000, maximum: 9999999999 } );
	    </script>
        </td>
      </tr>
      <tr>
        <td>E - mail id</td>
        <td>
            <input type="text" name="email" id="f6" size="50" />
	    <script type="text/javascript">
		var f6 = new LiveValidation('f6', { validMessage: "Correct!"});
		f6.add(Validate.Presence);
		f6.add( Validate.Email );
	    </script>
        </td>
      </tr>
      <tr>
        <td>Admission Category</td>
        <td>
          <select name="category_code" id="category"> 
          <?php 
          $query = $db->query("SELECT * from category");
          while($row = $db->fetch_array($query)){
          echo '<option value = "'.$row[0].'">'.$row[0].'</option>';
          }
          ?>
          </select>
          &ensp;&ensp;
          <small>(In case of SC/ST/OBC attach the certificate)</small>
        </td>
      </tr>
      <tr>
        <td>Admission Sub-Category</td>
        <td>
            <select name="sub_category_code" id="sub_category_option">
                    <option value="" id="sub_none">None</option>
                    <option value="PH" id="PH">PH</option>
                    <option value="CW" id="CW">CW</option>
					<option value="KM" id="KM">KM</option>
					<option value="SG" id="SG">SG</option>
					<option value="TP" id="TP">TP</option>
            </select>
        </td>
      </tr>
      <tr>
        <td><span id="f45"></span></td>
        <td>
           <input type="text" name="lr1" id="f7" size="50" />
            <script>
            var f7 = new LiveValidation('f7', { validMessage: "Correct!"});
		    f7.add(Validate.Presence);
            </script>
        </td>
      </tr>
      <tr>
        <td><span id="f46"></span></td>
        <td>
           <input type="text" name="lr2" id="f47" size="50" />
            <script>
            var f47 = new LiveValidation('f47', { validMessage: "Correct!"});
		    f47.add(Validate.Presence);
            </script>
        </td>
      </tr>
      <tr>
        <td>Number of Back Papers <small>(0 in case of no backs)</small></td>
        <td>
            <input type="text" name="back_papers" maxlength="1" id="f8" size="50" />
	    <script type="text/javascript">
		var f8 = new LiveValidation('f8', { validMessage: "Correct!"});
		f8.add(Validate.Presence);
		f8.add( Validate.Numericality, { onlyInteger: true, minimum: 0, maximum: 9 } );
	    </script>
        </td>
      </tr>
      <tr>
        <td>Last School Attended</td>
        <td>
            <input type="text" name="school" id="f52" size="50" />
	    <script type="text/javascript">
		var f52 = new LiveValidation('f52', { validMessage: "Correct!"});
		f52.add(Validate.Presence);
	    </script>
        </td>
      </tr>
      <tr>
        <td>Blood Group</td>
        <td>
            <input type="text" name="blood_group" id="f9" size="50" />
            <script type="text/javascript">
		var f9 = new LiveValidation('f9', { validMessage: "Thank You"});
		f9.add(Validate.Presence);
	    </script>
        </td>
      </tr>
      <tr>
        <td>Chronic Problems </td>
        <td>
            <input type="text" name="chronic" id="f10" size="50" value="nil" />
	    <script type="text/javascript">
		var f10 = new LiveValidation('f10', { validMessage: "Correct!"});
		f10.add(Validate.Presence);
	    </script>
        </td>
      </tr>
      <tr>
      <td>Passport Size Photograph (<a href="instructions.php" onclick="return popitup(&#39;instructions.php&#39;)">Instructions</a>)</td>
      <td>
        <input type="file" name="file" id="f53"> &ensp;
        <script type="text/javascript">
        document.getElementById('f53').addEventListener('change', checkFile, false);
              function checkFile(e) {
                var file_list = e.target.files;

           for (var i = 0, file; file = file_list[i]; i++) {
        var file_name = file.name;
        var file_ext = file_name.split('.')[file_name.split('.').length - 1].toLowerCase();
        var file_size = file.size;
        if ((file_ext == "png" || file_ext == "jpg" || file_ext == "jpeg" || file_ext== "gif" || file_ext=="PNG" || file_ext == "JPG" || file_ext == "JPEG" || file_ext== "GIF") && file_size < 2097152) {
            //display image before upload to user
            var reader = new FileReader();
            reader.onload = function (e) {
            document.getElementById('f54').innerHTML ="<img  height='200' width='200' src='"+e.target.result+"'/>";
            }
            reader.readAsDataURL(file);
        }
           else{
           if(file_size > 2097152){
             document.getElementById("f53").value ="";
             document.getElementById("f54").innerHTML ="";
             alert("File size exceeded");
           }
           else{
             document.getElementById("f53").value ="";
             document.getElementById("f54").innerHTML ="";
             alert("File format not supported.");
           }
        }
    }
   }
     var f53 = new LiveValidation('f53', { validMessage: "Correct!"});
		f53.add(Validate.Presence);
       </script>
      </td>
      </tr>

<tr><td>&ensp;</td><td><span id="f54"></span></td></tr>
<tr><td>&ensp;</td></tr>
<tr><th>Bank Details</th></tr>
<tr>
		 <td>Bank Account No.</td>
        <td>
            <input type="text" name="bank_accountno" id="f11" size="50" />
				<script type="text/javascript">
					var f11 = new LiveValidation('f11', { validMessage: "Correct!"});
					f11.add(Validate.Presence);
					f11.add( Validate.Numericality, { onlyInteger: true } );
				</script>
        </td>
	  </tr>
	  <tr>
		 <td>Account Holder Name</td>
        <td>
            <input type="text" name="bank_acc_name" id="f57" size="50" />
				<script type="text/javascript">
					var f57 = new LiveValidation('f57', { validMessage: "Correct!"});
					f57.add(Validate.Presence);
				</script>
        </td>
	  </tr>
	  <tr>
		 <td>Bank Name</td>
        <td>
            <input type="text" name="bank_name" id="f12" size="50" />
				<script type="text/javascript">
					var f12 = new LiveValidation('f12', { validMessage: "Correct!"});
					f12.add(Validate.Presence);
				</script>
        </td>
	  </tr>
	  <tr>
		 <td>Bank IFSC Code</td>
        <td>
            <input type="text" name="bank_ifsc" id="f13" size="50" />
				<script type="text/javascript">
					var f13 = new LiveValidation('f13', { validMessage: "Correct!"});
					f13.add(Validate.Presence);
				</script>
        </td>
</tr>
<tr>
		 <td>Branch Code</td>
        <td>
            <input type="text" name="bank_code" id="f55" size="50" />
				<script type="text/javascript">
					var f55 = new LiveValidation('f55', { validMessage: "Correct!"});
					f55.add(Validate.Presence);
				</script>
        </td>
</tr>
<tr>
		 <td>Bank Address</td>
        <td>
            <input type="text" name="bank_add" id="f56" size="50" />
				<script type="text/javascript">
					var f56 = new LiveValidation('f56', { validMessage: "Correct!"});
					f56.add(Validate.Presence);
				</script>
        </td>
</tr>

<tr><td>&ensp;</td></tr>
<tr><td>&ensp;</td></tr>
<tr><th>Parents Details</th></tr>
      <tr>
        <td>Father's Name</td>
        <td>
            <input type="text" name="father_name" id="f14" size="50" />
	    <script type="text/javascript">
		var f14 = new LiveValidation('f14', { validMessage: "Correct!"});
		f14.add(Validate.Presence);
	    </script>
        </td>
      </tr>
      <tr>
        <td>Father's Phone No.</td>
        <td>
            <input type="text" name="father_phone" maxlength="15" id="f15" size="50" />
	    <script type="text/javascript">
		var f15 = new LiveValidation('f15', { validMessage: "Correct!"});
		f15.add(Validate.Presence);
		f15.add( Validate.Numericality, { onlyInteger: true } );
	    </script>
        </td>
      </tr>
      <tr>
      <tr>
		 <td>Father's E - mail id</td>
        <td>
            <input type="text" name="father_email" id="f16" size="50" />
				<script type="text/javascript">
					var f16 = new LiveValidation('f16', { validMessage: "Correct!"});
					f16.add(Validate.Presence);
					f16.add( Validate.Email );
				</script>
        </td>
    </tr>
    <tr>
      	<td>Father's Occupation</td>
      	<td>
      		<input type="text" name="father_occupation" size="50" id="f17"></textarea>
      		<script type="text/javascript">
					var f17 = new LiveValidation('f17', { validMessage: "Correct!"});
					f17.add(Validate.Presence);
				</script>
      	</td>
      </tr>
	  <tr>
      	<td>Father's Designation</td>
      	<td>
      		<input type="text" name="father_des" size="50" id="f58"></textarea>
      		<script type="text/javascript">
					var f58 = new LiveValidation('f58', { validMessage: "Correct!"});
					f58.add(Validate.Presence);
				</script>
      	</td>
      </tr>
      <tr>
      	<td>Father's Office Address</td>
      	<td>
      		<input type="text" name="father_office_address" size="50" id="f18"></textarea>
      		<script type="text/javascript">
					var f18 = new LiveValidation('f18', { validMessage: "Correct!"});
					f18.add(Validate.Presence);
				</script>
      	</td>
      </tr>
      <tr>
      	<td>Father's Office Phone No. (Landline)</td>
      	<td>
      		<input type="text" name="father_office_phone" size="50" id="f19"></textarea>
      		<script type="text/javascript">
					var f19 = new LiveValidation('f19', { validMessage: "Correct!"});
					f19.add(Validate.Presence);
					f19.add( Validate.Numericality, { onlyInteger: true } );
				</script>
      	</td>
      </tr>
        <td>Mother's Name</td>
        <td>
            <input type="text" name="mother_name" id="f20" size="50" />
	    <script type="text/javascript">
		var f20 = new LiveValidation('f20', { validMessage: "Correct!"});
		f20.add(Validate.Presence);
	    </script>
        </td>
      </tr>
      <tr>
        <td>Mother's Phone No.</td>
        <td>
            <input type="text" name="mother_phone" id="f21" maxlength="15" size="50" />
	    <script type="text/javascript">
		var f21 = new LiveValidation('f21', { validMessage: "Correct!"});
		f21.add(Validate.Presence);
		f21.add( Validate.Numericality, { onlyInteger: true } );
	    </script>
        </td>
      </tr>
      <tr>
		 <td>Mother's E - mail id <small>(Optional)</small></td>
        <td>
            <input type="text" name="mother_email" id="f22" size="50" />
        </td>
	  </tr>
	  <tr>
			<td>Mother's Occupation </td>
			<td>
				<input type="text" name="mother_occupation" size="50" id="f23"></textarea>
				<script type="text/javascript">
					var f23 = new LiveValidation('f23', { validMessage: "Correct!"});
					f23.add(Validate.Presence);
				</script>
			</td>
      </tr>
	  <tr>
      	<td>Mother's Designation <small>(Optional)</small></td>
      	<td>
      		<input type="text" name="mother_des" size="50" id="f58"></textarea>
      	</td>
      </tr>
       <tr>
      	<td>Mother's Office Address <small>(Optional)</small></td>
      	<td>
      		<input type="text" name="mother_office_address" size="50" id="f24"></textarea>
      	</td>
      </tr>
      <tr>
      	<td>Mother's Office Phone No. <small>(Optional)</small></td>
      	<td>
      		<input type="text" name="mother_office_phone" size="50" id="f25">
      	</td>
      </tr>
      

<tr><td>&ensp;</td></tr>
<tr><td>&ensp;</td></tr>
<tr><th>Present Address Details (Parents)</th></tr>

        <tr>
        <td>Address Line</td>
        <td>
            <input type="text" name="present_add_line" id="f26" size="50" />
	    <script type="text/javascript">
		var f26 = new LiveValidation('f26', { validMessage: "Correct!"});
		f26.add(Validate.Presence);
	    </script>
        </td>
      </tr>
      <tr>
        <td>City</td>
        <td>
            <input type="text" name="present_city" id="f27" size="50" />
	    <script type="text/javascript">
		var f27 = new LiveValidation('f27', { validMessage: "Correct!"});
		f27.add(Validate.Presence);
	    </script>
        </td>
      </tr>
      <tr>
        <td>State</td>
        <td>
            <input type="text" name="present_state" id="f28" size="50" />
	    <script type="text/javascript">
		var f28 = new LiveValidation('f28', { validMessage: "Correct!"});
		f28.add(Validate.Presence);
	    </script>
        </td>
      </tr>
      <tr>
        <td>Country</td>
        <td>
            <input type="text" name="present_country" id="f29" size="50" />
	    <script type="text/javascript">
		var f29 = new LiveValidation('f29', { validMessage: "Correct!"});
		f29.add(Validate.Presence);
	    </script>
        </td>
      </tr>
      <tr>
        <td>Pin</td>
        <td>
            <input type="text" name="present_pin" id="f30" size="50" />
	    <script type="text/javascript">
		var f30 = new LiveValidation('f30', { validMessage: "Correct!"});
		f30.add(Validate.Presence);
	    </script>
        </td>
      </tr>
      <tr>
        <td>Residential Phone</td>
        <td>
            <input type="text" name="present_res_phone" id="f31" size="50" />
	    <script type="text/javascript">
		var f31 = new LiveValidation('f31', { validMessage: "Correct!"});
		f31.add(Validate.Presence);
		f31.add( Validate.Numericality, { onlyInteger: true } );
	    </script>
        </td>
      </tr>
      

<tr><td>&ensp;</td></tr>
<tr><td>&ensp;</td></tr>
<tr><th>Permanent Address Details (Parents)</th><td>(<a href="javascript:void(0)" onClick="copy_data_from_present()">Copy From Present address</a>)</td></tr>
      <tr>
        <td>Address Line</td>
        <td>
            <input type="text" name="permanent_add_line" id="f32" size="50" />
	    <script type="text/javascript">
		var f32 = new LiveValidation('f32', { validMessage: "Correct!"});
		f32.add(Validate.Presence);
	    </script>
        </td>
      </tr>
      <tr>
        <td>City</td>
        <td>
            <input type="text" name="permanent_city" id="f33" size="50" />
	    <script type="text/javascript">
		var f33 = new LiveValidation('f33', { validMessage: "Correct!"});
		f33.add(Validate.Presence);
	    </script>
        </td>
      </tr>
      <tr>
        <td>State</td>
        <td>
            <input type="text" name="permanent_state" id="f34" size="50" />
	    <script type="text/javascript">
		var f34 = new LiveValidation('f34', { validMessage: "Correct!"});
		f34.add(Validate.Presence);
	    </script>
        </td>
      </tr>
      <tr>
        <td>Country</td>
        <td>
            <input type="text" name="permanent_country" id="f35" size="50" />
	    <script type="text/javascript">
		var f35 = new LiveValidation('f35', { validMessage: "Correct!"});
		f35.add(Validate.Presence);
	    </script>
        </td>
      </tr>
      <tr>
        <td>Pin</td>
        <td>
            <input type="text" name="permanent_pin" id="f36" size="50" />
	    <script type="text/javascript">
		var f36 = new LiveValidation('f36', { validMessage: "Correct!"});
		f36.add(Validate.Presence);
	    </script>
        </td>
      </tr>
      <tr>
        <td>Residential Phone</td>
        <td>
            <input type="text" name="permanent_res_phone" id="f37" size="50" />
	    <script type="text/javascript">
		var f37 = new LiveValidation('f37', { validMessage: "Correct!"});
		f37.add(Validate.Presence);
	    </script>
        </td>
      </tr>
<tr><td>&ensp;</td></tr>
<tr><td>&ensp;</td></tr>
<tr><th>Local Guardian Details:</th></tr>
      <tr>
        <td>Name</td>
        <td>
            <input type="text" name="lg_name" id="f38" size="50" />
	    <script type="text/javascript">
		var f38 = new LiveValidation('f38', { validMessage: "Correct!"});
		f38.add(Validate.Presence);
	    </script>
        </td>
      </tr>
      <tr>
        <td>Address</td>
        <td>
            <input type="text" name="lg_address" id="f39" size="50" />
	    <script type="text/javascript">
		var f39 = new LiveValidation('f39', { validMessage: "Correct!"});
		f39.add(Validate.Presence);
	    </script>
        </td>
      </tr>
      <tr>
        <td>Phone</td>
        <td>
            <input type="text" name="lg_phone" id="f40" size="50" />
	    <script type="text/javascript">
		var f40 = new LiveValidation('f40', { validMessage: "Correct!"});
		f40.add(Validate.Presence);
	    </script>
        </td>
      </tr>
      <tr>
        <td>Occupation</td>
        <td>
            <input type="text" name="lg_occupation" id="f41" size="50" />
	    <script type="text/javascript">
		var f41 = new LiveValidation('f41', { validMessage: "Correct!"});
		f41.add(Validate.Presence);
	    </script>
        </td>
      </tr>
	  <tr>
        <td>Office Address</td>
        <td>
            <input type="text" name="lg_office" id="f42" size="50" />
	    <script type="text/javascript">
		var f42 = new LiveValidation('f42', { validMessage: "Correct!"});
		f42.add(Validate.Presence);
	    </script>
        </td>
      </tr>
	  <tr>
        <td>Office Phone No. (Landline)</td>
        <td>
            <input type="text" name="lg_office_phone" id="f43" size="50" />
	    <script type="text/javascript">
		var f43 = new LiveValidation('f43', { validMessage: "Correct!"});
		f43.add(Validate.Presence);
	    </script>
        </td>
      </tr>
<tr><td>&ensp;</td></tr>
<tr><td>&ensp;</td></tr>
<tr><th>Enter the Captcha</th></tr>
      <tr>
        <td>
            <img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image" />
        </td>
        <td>
            <input type="text" name="captcha_code" size="50" maxlength="6" id="f44"/> <br/>
            <a href="#" onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false">[ Different Image ]</a>
            <script type="text/javascript">
		var f44 = new LiveValidation('f44', { validMessage: " "});
		f44.add(Validate.Presence);
	    </script>
        </td>
      </tr>
      <tr>
        <td></td><td><input type="submit" value="Submit" id="continue_btn" disabled="disabled" name="submit" size="50" style="visibility: hidden;" /><noscript><font size="+6" color="red">Enable Javascript to see complete form</font></noscript></td>
      </tr>
    </table>
</form>


<?php  include_layout_template('footer.php');
if(isset($database)) { $database->close_connection(); }
ob_end_flush()

?>
