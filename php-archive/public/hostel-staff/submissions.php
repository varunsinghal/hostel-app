<?php
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }
include_layout_template('admin_header.php'); 
require_once('../../includes/config.php');?>
<?php $con = mysql_connect(DB_SERVER,DB_USER,DB_PASS);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db(DB_NAME, $con);
$query = "SELECT * FROM student"; 
$result = mysql_query($query,$con) or die(mysql_error());
echo'<br><br><br>';
echo '<table>
<tr>Form No.</tr>
&nbsp;&nbsp;
<tr>Name of Student</tr>
&nbsp;&nbsp;
<tr>Email of Student</tr>
';
while($row = mysql_fetch_array($result)){
echo '<table width="472">
 <tr>
 <th width="120" >'. $row['student_id'].'</a></th>
 <th width="120" >'. $row['name'].'</a></th>
 <th width="309" >'. $row['email'].'</a></th>
 </tr><br><hr>
  <th width="120" ><a href="view.php?page='. $row['student_id'].'">View Full Details</a></th>
';
}
echo '</table> <br />';


?>