<?php

ob_start();
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }
include_layout_template('admin_header.php');

?>

<center><h1 style="color: #ccc;">Public Links</h1></center>

<br />
These links can be accessed by general public and their visiblity can be controlled by admin -
<ul>
<li>Re-allotment form:<br>
<a href="../reallot.php" target="_blank">Visit Form</a> | 
<a href="../preview.php?form=layouts/reallot.inc.php" target="_blank">Preview Form</a> |
<a href="edit.php?form=../layouts/reallot.inc.php"  target="_blank">Edit Form</a> | 
<a href="../terms1.php" target="_blank">Preview Terms</a> |
<a href="edit.php?form=../terms1.php" target="_blank">Edit Terms</a>
</li>
<li>Registration form:<br>
<a href="../register.php" target="_blank">Visit Form</a> | 
<a href="../preview.php?form=layouts/register.inc.php" target="_blank">Preview Form</a> |
<a href="edit.php?form=layouts/register.inc.php" target="_blank">Edit Form</a> | 
<a href="../terms.php" target="_blank">Preview Terms</a> |
<a href="edit.php?form=layouts/register.inc.php" target="_blank">Edit Terms</a> 
</li>
<li>Surrender form:<br>
<a href="../surrender.php" target="_blank">Visit Form</a> | 
<a href="../preview.php?form=layouts/surrender.inc.php" target="_blank">Preview Form</a> |
<a href="edit.php?form=../layouts/surrender.inc.php" target="_blank">Edit Form</a>
</li>
<li><a href="../feedback.php">Feedback form</a></li>
<li><a href="../checkstatus.php" target="_blank">Allotment Status</a></li>
</ul>

<?php

include_layout_template('footer.php');
if(isset($database)) { $database->close_connection(); }
ob_end_flush();

?>
