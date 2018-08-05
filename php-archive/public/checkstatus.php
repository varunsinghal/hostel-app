<?php

// initialization on every page

ob_start();
require_once("../includes/initialize.php");
include_layout_template('header.php');
if(!$session->is_logged_in()){ redirect_to("error.php?i=5"); }

?>


<!-- Input form starts -->


<form action="status-final.php" method="post">
<h2 align="center" style="color:#999">Check Allotment Status</h2>
<label for="name">Student's form number : </label>
<br />
<input type="text" name="student_id">
<Br /><br />
<input type="submit" align="absmiddle">
</form>


<!-- input form ends -->


<?php

// de initilization at the end of every file

include_layout_template('admin_footer.php');
if(isset($database)) { $database->close_connection(); }
ob_end_flush();

?>