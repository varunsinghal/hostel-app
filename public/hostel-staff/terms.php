<?php
ob_start();
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }
include_layout_template('admin_header.php');
?>

Content goes here....
<?php include_layout_template('footer.php');
if(isset($database)) { $database->close_connection(); }
ob_end_flush();

?>