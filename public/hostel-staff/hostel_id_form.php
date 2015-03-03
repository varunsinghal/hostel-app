<?php
       require_once("../../includes/initialize.php");
       if(!$session->is_logged_in()){ redirect_to("login.php"); }
       include_layout_template('admin_header.php');
?>



<h2 style="color:#ccc;">Generate Hostel ID Card</h2>
<br />

<form method="GET" action="generate_hostel_id.php">
<label for="id">Form Number :</label>
<input type="text" name="id" />
<input type="Submit" name="submit">
</form>

<?php include_layout_template('footer.php'); ?>
