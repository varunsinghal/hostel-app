<?php
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }
include_layout_template('admin_header.php');
ob_start();

?>

<center><h2 style="color:#ccc">Distance Calculator</h2></center>
<br /><br />
<ul>
<li>Calculate Distance : Precise Mode <small>(For first time calculation of distance)</small> - <a href='request_distance_precise.php'>Start</a></li>
<li>Calculate Distance : Less Precise Mode <small>(For final try)</small> - <a href='request_distance_precise.php?less_precise'>Start</a></li>
<li>Enter Distance Manually - <a href='edit_dist_manual.php'>Go</a></li>
<li>Google Maps Tool - <a href='gmaps/'>Go</a></li>
</ul>


<?php include_layout_template('footer.php');
if(isset($database)) { $database->close_connection(); }
ob_end_flush();

?>
