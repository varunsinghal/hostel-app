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
//terms
if(isset($_POST['continue']) && isset($_POST['terms'])){
 $terms = trim($_POST['terms']);
 if($session->set_terms($terms)){
   redirect_to("register.php");
 }
}
//message
if(isset($_GET['i'])){
    if($_GET['i']=='2'){
        echo "<font color='red'>".output_message("Please accept the terms before filling the form.")."</font>";
    } 
}
?>
<script type="text/javascript" src="js/livevalidation_standalone.compressed.js"></script>
<link rel="stylesheet" href="stylesheets2/validation.css" />
<div>
    <b>Terms & Conditions :</b>
    <ol>
<li>No hostel resident is allowed to keep any motorized vehicle in the University, However, bicycles are permitted for local/internal transport within DTU campus. Disciplinary action including fine and expulsion will be imposed on the defaulters. In this regard an affidavit shall be submitted duly signed by student and his/her parents on a non-judicial stamp of Rs. 10/-</li>
<li>Once the hostel allotment is made no further request for change of room or hostel will be considered, if any such request is placed by candidate then the candidature of that student will be treated as withdrawn and his/her allotment will stand cancelled.</li>
<li>The students who have been admitted in the University under Outside Delhi category, but residing in Delhi, NCR will be considered as Delhi Category student for the purpose of hostel allotment.</li>
<li>After the allotment of the room the allottee will be held responsible for any damage in his/her room, and the allottee shall bear the cost of damage as decided by the warden and Officer Incharge, Hostel.</li>
<li>The day scholar has to take prior permission from the Warden & have to submit the fees before staying with someone in the hostel and such permission shall be approved by Officer Incharge, Hostel Office atleast two days before the requested date of stay.</li>
<li>The accommodation in the hostels will be provided as per the academic calendar declared by the DTU administration/Dean Academics. Every student shall have to vacate the hostel within 3 days of his/her last end semester examination every year. Each year a new allotement applicaion is to be submitted.</li>
<li>If any student tries to influence the DTU hostel administration through any means his/her candidature will stand cancelled and the decision of the hostel office in such matters will be final.</li>
<li>Day scholars are not allowed to stay with any hosteller without prior permission, if any day scholar is found staying with the hosteller in his/her room without prior permission of warden & Officer Incharge, Hostels, the allotment of such hosteller will be immediately cancelled without any notice and such candidates will not be considered for future hostel allotment.</li>
<li>Hostel office reserves all the rights for allotment, cancellation & rejection of hostel allotment applications. In this regard the authority of Hostel Office/administration is final.</li>
</ol>		
<br />
<b>I certify :</b>
<ol> 
<li>That I shall vacate my room within 3 days of last examination in each year.</li>
<li>That I shall abide the rules and regulations of University Hostels and the University and shall conduct in a manner worthy of being a student of DTU and shall never indulge in indiscipline/voilence.</li>
<li>That the information furnished by me is true to the best of my knowledge and belief. If any information found wrong my admission may be cancelled.</li>
</ol>	
</div>
<form method="post" action="terms.php?i=2" >
<input type="checkbox" value="1" name="terms"/> I agree to the above mentioned terms and conditions.
<br/><br/><input type="submit" name="continue" value="Continue">
</form>

<?php  include_layout_template('footer.php');
if(isset($database)) { $database->close_connection(); }
ob_end_flush()

?>
