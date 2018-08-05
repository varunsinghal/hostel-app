<?php
ob_start();
require_once("../includes/initialize.php");
include_layout_template('header.php');
?>
<script type="text/javascript" src="js/livevalidation_standalone.compressed.js"></script>
<link rel="stylesheet" href="stylesheets2/validation.css" />
<form method="post" action="feedback_submit.php">
<h1 align="center"><b><u>HOSTEL FEEDBACK FORM</u></b></h1>
Name :<br><input type="text" name="name" id="name1">
		   <script type="text/javascript">
		   var name1 = new LiveValidation('name1',{ validMessage: " " } );
		   name1.add(Validate.Presence);
		   </script><br><br>
Father Name :<br><input type="text" name="fathername" id="father1" >
				 <script type="text/javascript">
				 var father1=new LiveValidation ('father1',{ validMessage : ' ' } );
				 father1.add(Validate.Presence);
				 </script><br><br>
Father phone number :<br><input type="text" name="fatherphone" id="phone1" >
                     <script type="text/javascript">
					 var phone1= new LiveValidation('phone1',{ validMessage:' ' } );
					 phone1.add(Validate.Presence);
					 phone1.add(Validate.Numericality ,{ onlyinteger: true } );
					 phone1.add(Validate.Length, {is:10} );
					 </script><br><br>
Hostel roll number :<br><input type="text" name="hostelrollno" id="h1">
						<script type="text/javascript">
						var h1 = new LiveValidation('h1',{ validMessage :'Correct' } );
						h1.add(Validate.Presence);
						</script><br><br>
Feedback:<br><br><textarea name="textarea" rows='15' cols='35' id="f1"></textarea>
			     <script type="text/javascript">
						var f1 = new LiveValidation('f1');
						f1.add(Validate.Presence);
						f1.add(Validate.Length,{minimum:4});
						</script><br><br>
<table>						
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
	  </table>
<input type="submit" name="submit" value="SUBMIT">
</form>
<?php
include_layout_template('footer.php');
if(isset($database))
{ $database->close_connection();}
ob_end_flush()
?>