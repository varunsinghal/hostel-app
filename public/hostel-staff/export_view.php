<?php
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }
?>


<?php
include_layout_template('admin_header.php');
?>


<br />
<center><h2 style="color:#ccc">Export Data</h2></center>
<br /><br />


<h3 style="color:#668CFF">For User End Purposes</h3><small>These data are according to the various requirements</small><hr />
<ul>
<li><a href="export_all_student.php">Export : List of All Students (Full Database)</a></li>
<li><a href="export_users.php">Export : List of Admins</a></li>
<li><a href="export_verified_student.php">Export : List of All Verified Students</a></li>
<li><a href="export_alloted_student.php">Export : List of All Alloted Students</a></li>
<li><a href="export_docu_submission.php">Export : List of all Students whose Documents have been Verified</a></li>
<li><a href="#">Export : List of All Rooms and Occupants</a></li>
</ul>
<br /><br/>
<?php include_layout_template('admin_footer.php'); ?>
