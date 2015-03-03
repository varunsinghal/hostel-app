<?php

ob_start();

require_once("../includes/initialize.php");
include_layout_template('header.php');

//terms
if(isset($_POST['continue']) && isset($_POST['terms'])){
 $terms = trim($_POST['terms']);
 if($session->set_terms($terms)){
   redirect_to("reallot.php");
 }
}
//message
if(isset($_GET['i'])){
    if($_GET['i']=='2'){
        echo "<font color='red'>".output_message("Please accept the terms before filling the form.")."</font>";
    } 
}
?>
<div>
    <b>Terms & Conditions :</b><br />
      <br/>
        <ol>
        <li>No hostel resident is allowed to keep any motorized vehicle in the University, However, bicycles are permitted for

local/internal transport within DTU campus. Disciplinary action including fine and expulsion will be imposed on the

defaulters. In this regard an affidavit shall be submitted duly signed by student and his/her parents on a non-judicial stamp

of Rs. 10/-</li>

<li> The day scholar has to take prior permission from the Warden & have to submit the fees before staying with someone

in the hostel and such permission shall be approved by Officer Incharge, Hostel Office atleast two days before the

requested date of stay.</li>

<li> The accommodation in the hostels will be provided as per the academic calendar declared by the DTU

administration/Dean Academics. Every student shall have to vacate the hostel within 3 days of his/her last end semester

examination every year. Each year a new allotement applicaion is to be submitted.</li>

<li> If any student tries to influence the DTU hostel administration through any means his/her candidature will stand

cancelled and the decision of the hostel office in such matters will be final.</li>

<li> Day scholars are not allowed to stay with any hosteller without prior permission, if any day scholar is found staying

with the hosteller in his/her room without prior permission of warden & Officer Incharge, Hostels, the allotment of such

hosteller will be immediately cancelled without any notice and such candidates will not be considered for future hostel

allotment.</li>

<li> Hostel office reserves all the rights for allotment, cancellation & rejection of hostel allotment applications. In this

regard the authority of Hostel Office/administration is final.</li>
        </ol>
	</div>
<form method="post" action="terms1.php?i=2" >
<input type="checkbox" value="1" name="terms"/> I agree to the above mentioned terms and conditions.
<br/><br/><input type="submit" name="continue" value="Continue">
</form>

<?php  include_layout_template('footer.php');
if(isset($database)) { $database->close_connection(); }
ob_end_flush()

?>