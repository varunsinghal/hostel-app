<?php
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }



if(isset($session->user_level)){
  if($session->user_level != 1)
  {
    if(!access_check($session->user_level, $_SERVER['PHP_SELF']))  // false is recieved from access_check if access is not grandet
    {
      redirect_to("access_denied.php");
    }
  }
}
else {
  redirect_to("login.php");
}



?>
<?php include_layout_template('admin_header.php'); ?>

<style type="text/css">
#content ul {
float: left;
display: inline-block;
margin-bottom: 20px;
list-style-type: none;
}

#content ul li {
float: left;
display: inline;
margin: 0 15px 15px 0;
}

#content ul li a {
display: block;
width: 106px;
height: 102px;
text-decoration: none;
color: #555;
background: url(../images/largebut.png) 0 0 no-repeat;
}

#content ul li a:hover {
background: url(../images/largebut_hover.png) 0 0 no-repeat;
}


#content ul li a img {
display: inline;
width: 48px;
margin-left: 29px;
margin-top: 15px;
}

#content ul li a span {
display: block;
width: 100%;
text-align: center;
margin-top: 10px;
font-size: 11px;
}

#content img {
border: 0;
}
</style>


<h2>Welcome <?php echo $session->user_name; ?>,</h2>
<hr />
<br />
Actions -<br /><br />

<div id="content" style="display:inline-block;">
<ul>
<li><a href="allotedrooms.php"><img src="../images/alloted-rooms.png" alt="" /><span>Alloted Rooms</span></a></li>
<li><a href="verify_student.php"><img src="../images/verify-docu_icon.png" alt="" /><span>Verify<br />Documents</span></a></li>
<li><a href="distance_calculator_index.php"><img src="../images/calcu-dist.png" alt="" /><span>Calculate<br />Distance</span></a></li>
<li><a href="search.php"><img src="../images/search.png" alt="" /><span>Search</span></a></li>
<li><a href="verified_application_index.php"><img src="../images/verified_ico.png" alt="" /><span>Verified Applications</span></a></li>
<li><a href="all_filtered_view.php"><img src="../images/recieved_application.png" alt="" /><span>Recieved Applications</span></a></li>
<li><a href="status.php"><img src="../images/stats.png" alt="" /><span>Status</span></a></li>
<li><a href="hostel_room_management.php"><img src="../images/manage-hostel.png" alt="" /><span>Manage Rooms</span></a></li>
<li><a href="viewfeedback.php"><img src="../images/terms.jpg" alt="" /><span>Feedback System</span></a></li>
<li><a href="search.php?table_name=remarks&column_name=remarks&query=surrender"><img src="../images/surrender.jpg" alt="" /><span>Surrendered Rooms</span></a></li>
<li><a href="public_links.php"><img src="../images/public-links.png" alt="" /><span>Public Links</span></a></li>
<li><a href="viewuser.php"><img src="../images/admins.png" alt="" /><span>Users</span></a></li>
<li><a href="gmaps" target="_blank"><img src="../images/gmaps.png" alt="" /><span>Google Map Tool</span></a></li>
<li><a href="export_view.php"><img src="../images/backup.png" alt="" /><span>Export & Backup</span></a></li>
<li><a href="controls.php"><img src="../images/control.png" alt="" /><span>Controls</span></a></li>
<li><a href="logfile.php"><img src="../images/log.png" alt="" /><span>View Log</span></a></li>
<li><a href="logout.php"><img src="../images/logout.png" alt="" /><span>Logout</span></a></li>

</ul>

</div>

<hr />
<h3>Info</h3><br />
Registrations :
<?php

$query2 = "SELECT * FROM control_variables WHERE control='registration'";
$result1 = mysql_query($query2) or die(mysql_error());
$reset=mysql_fetch_array($result1);
if($reset['flag'] == 1)
{
       echo '<span style="color:green;">LIVE</span>';
}
else
{
       echo '<span style="color:red;">CLOSED</span>';
}

?>
<br />
Re-Allotment :
<?php

$query2 = "SELECT * FROM control_variables WHERE control='reallotment'";
$result1 = mysql_query($query2) or die(mysql_error());
$reset=mysql_fetch_array($result1);
if($reset['flag'] == 1)
{
       echo '<span style="color:green;">LIVE</span>';
}
else
{
       echo '<span style="color:red;">CLOSED</span>';
}

?>
<br />
Allotment Status :
<?php

$query2 = "SELECT * FROM control_variables WHERE control='allotment_status'";
$result1 = mysql_query($query2) or die(mysql_error());
$reset=mysql_fetch_array($result1);
if($reset['flag'] == 1)
{
       echo '<span style="color:green;">LIVE</span>';
}
else
{
       echo '<span style="color:red;">CLOSED</span>';
}

?>
<br />
Total Recieved Application :
<?php

$query2 = "SELECT COUNT(*) FROM student";
$result1 = mysql_query($query2) or die(mysql_error());
$reset=mysql_fetch_array($result1);
echo '<span style="color:blue;"><strong>'.$reset['COUNT(*)'].'</strong></span>';
?>
<?php include_layout_template('admin_footer.php'); ?>
