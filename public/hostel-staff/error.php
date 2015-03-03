<?php
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }
include_layout_template('admin_header.php');
ob_start();

?>

<?php

if(isset($_GET['errno']))
{

  switch($_GET['errno'])
  {
    case 1: {
      echo "<font color='red'>".output_message("Illegal Operation. Please return to home page. <a href='index.php'>Home</a>")."</font>";
      break;
    }
    default : {
      echo "<font color='red'>".output_message("Illegal Operation. Please return to home page. <a href='index.php'>Home</a>")."</font>";
    }
  }
}

else
{
  redirect_to("index.php");
}

?>


<?php include_layout_template('footer.php');
if(isset($database)) { $database->close_connection(); }
ob_end_flush();

?>