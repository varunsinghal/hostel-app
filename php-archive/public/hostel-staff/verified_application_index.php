<?php
       ob_start();
       require_once("../../includes/initialize.php");
       if(!$session->is_logged_in()){ redirect_to("login.php"); }
       include_layout_template('admin_header.php');
?>

<h1 style="color: #ccc;">Verified Applications</h1>
<br />

<ul>
<li><a href="verified_filtered_view_v2.php">See all verified Applications</a></li>
<br />
<li><a href="duplicate_verified_finder.php">See verified applications with duplicate name</a></li>
<br />
<li><a href="allotment_slip_form.php">Generate allotment slip</a></li>
<br />
<li><a href="hostel_id_form.php">Generate Hostel ID Card</a></li>
<br />
<li><a href="hostel_dual_id_form.php">Generate Dual Hostel ID Card</a></li>
<br />
<li><a href="rollnumbermanager.php">Hostel Roll Number Manager</a></li>
<br />
<li><a href="rollnumberallot.php">Hostel Roll Number Assignment</a></li>
<br />
<li><a href="unverified_filtered_view_v2.php">See all un-verified Applications</a></li>
</ul>
<br><br>
<strong>
Note:
</strong>
Uncheck headers & footers while printing allotment slips and hostel id cards in browser.
<?php include_layout_template('footer.php');
if(isset($database)) { $database->close_connection(); }
ob_end_flush();

?>
