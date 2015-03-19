<?php
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }
include_layout_template('admin_header.php');
ob_start();

?>


<center><h2 style="color:#ccc">Export Hostel List</h2></center>
<br />

<form action="export_hostel_list.php" method="get" name="main">
       Hostel Name :
       <select name="hostel_name">
         <option value="all">All</option>
       <?php
       
       $query2 = "SELECT DISTINCT hostel FROM available_room";
       $result1 = mysql_query($query2) or die(mysql_error());
       while($reset=mysql_fetch_array($result1))
       {
       		echo '<option value='.$reset['hostel'].'>'.$reset['hostel'].'</option>';
       }
       
       ?>
	   
       <input type="submit" value="Export" />
</form>


<?php include_layout_template('footer.php');
if(isset($database)) { $database->close_connection(); }
ob_end_flush();

?>
