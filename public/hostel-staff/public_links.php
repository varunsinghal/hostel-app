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
<li><a href="../reallot.php" target="_blank">Re-allotment form</a></li>
<li><a href="../register.php">Registration form</a></li>
<li><a href="../surrender.php">Surrender form</a></li>
<li><a href="../feedback.php">Feedback form</a></li>
<li><a href="../checkstatus.php" target="_blank">Allotment Status</a></li>
</ul>

<?php

include_layout_template('footer.php');
if(isset($database)) { $database->close_connection(); }
ob_end_flush();

?>
