<?php
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }
?>

<?php
  $r=var_dump($_POST['someinput']);
echo $r;
?>