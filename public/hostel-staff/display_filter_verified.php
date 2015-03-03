<?php
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }
?>


<?php
$q=$_GET["q"];
require_once('../../includes/config.php');
 $con = mysql_connect(DB_SERVER,DB_USER,DB_PASS);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db(DB_NAME, $con);



if($q=='showall')  //-------------------------------- filter showall ---------------------------------------
{
	echo'<h2 style="color:#ccc">Students - Distancewise Descending Order</h2>';
	echo '<table width=100%>
	<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
	$query = "SELECT * FROM student NATURAL JOIN distance_from_home NATURAL JOIN docu_submission WHERE student.student_id = distance_from_home.student_id AND docu_submission.document=1 ORDER BY distance_from_home.distance DESC";
	$result = mysql_query($query,$con) or die(mysql_error());
	
	while($row = mysql_fetch_array($result)){
		$id=$row['student_id'];
		$query2 = "SELECT * FROM student WHERE student_id='$id'";
		$result1 = mysql_query($query2,$con) or die(mysql_error());
		$reset=mysql_fetch_array($result1);
		$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
		$setaddress=mysql_query($query3,$con) or die(mysql_error());
		$address=mysql_fetch_array($setaddress);
		$query4 = "SELECT * FROM academic WHERE student_id='$id'";
		$resultof4 = mysql_query($query4,$con) or die(mysql_error());
		$academic_data = mysql_fetch_array($resultof4);
		$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
		$resultof5=mysql_query($query5) or die(mysql_error());
		$roomdetails=mysql_fetch_array($resultof5);
		$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
		$resultof6=mysql_query($query6) or die(mysql_error());
		$remarksdata=mysql_fetch_array($resultof6);
		$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
		$resultof7=mysql_query($query7) or die(mysql_error());
		$distancedata=mysql_fetch_array($resultof7);
		$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
		$resultof8=mysql_query($query8) or die(mysql_error());
		$verifydata=mysql_fetch_array($resultof8);
		echo '<tr><td colspan=9><hr /></td></tr>
		<tr id="'.$row['student_id'].'">
		<td>'. $row['student_id'].'</td>
		<td>'. $academic_data['year_of_admn'].', '.$academic_data['sem'].' Sem, '.$academic_data['branch'].', '.$academic_data['course'].'</td>
		<td>'. $reset['name'].'</td>
		<td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
		<td>'. $distancedata['distance'].'&nbsp;Km</td>
		<td>'. $reset['category_code'].', '.$reset['gender'].'</td>
		<td>';
		if($verifydata['document'] == 1)
		{
		      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
		}
		else
		{
		      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
		}
		echo'</td>
		<td>';
		if(isset($roomdetails['room_no']))
		{
		      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
		}
		else
		{
		      echo '<font color="red"><b>Nil</b></font>';
		}
		echo '</td>
		<td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
		</tr>
		<tr><td colspan=9 id="'.$row['student_id'].'a">';
		if(isset($remarksdata['student_id'])){
		      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
		}
		echo '</td></tr>
		<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
		}
		echo '</table> <br />';
}
// ---------------------------------- filter showall ends -----------------------------------------------






// ---------------------------------------- filter by semester  /*starts from here/ --------------------------------- //


if($q=='semester')
{
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN docu_submission  WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time()))." AND academic.student_id = distance_from_home.student_id ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<h2 style="color:#ccc">List is Generated Yearwise</h2>';
echo '<br /><br />';
echo'<h3 style="color:#ccc">First Year</h3><hr />';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN docu_submission  WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-1)." AND academic.student_id = distance_from_home.student_id ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());
echo '<br /><br />';
echo'<h3 style="color:#ccc">Second Year</h3><hr />';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN docu_submission  WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-2)." AND academic.student_id = distance_from_home.student_id ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());
echo '<br /><br />';
echo'<h3 style="color:#ccc">Third Year</h3><hr />';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-3)." AND academic.student_id = distance_from_home.student_id ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query) or die(mysql_error());
echo '<br /><br />';
echo'<h3 style="color:#ccc">Fourth Year</h3><hr />';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
}
	
// -------------------------------------- filter by semester ends here ------------------------------------------------------------- //





if($q=='region')  // -------------------------------------------- filter by region starts here --------------------------------- //
{
echo'<h2 style="color:#ccc">Students From Delhi Region</h2>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
$query1 = "SELECT * FROM student NATURAL JOIN distance_from_home NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND SUBSTRING(category_code, 1 , 1)='d' AND student.student_id = distance_from_home.student_id ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query1,$con) or die(mysql_error());
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query4 = "SELECT * FROM academic WHERE student_id='$id'";
	$resultof4 = mysql_query($query4,$con) or die(mysql_error());
	$academic_data = mysql_fetch_array($resultof4);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
	<tr id="'.$row['student_id'].'">
	<td>'. $row['student_id'].'</td>
	<td>'. $academic_data['year_of_admn'].', '.$academic_data['sem'].' Sem, '.$academic_data['branch'].', '.$academic_data['course'].'</td>
	<td>'. $reset['name'].'</td>
	<td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
	<td>'. $distancedata['distance'].'&nbsp;Km</td>
	<td>'. $reset['category_code'].', '.$reset['gender'].'</td>
	<td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
	<td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
	<td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
}
echo '</table> <br />';
echo'<h2 style="color:#ccc">Students From Outside Delhi Region</h2>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
$query1 = "SELECT * FROM student NATURAL JOIN distance_from_home NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND SUBSTRING(category_code, 1 , 1)='o' AND student.student_id = distance_from_home.student_id ORDER BY distance_from_home.distance DESC"; 
$result = mysql_query($query1,$con) or die(mysql_error());
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query4 = "SELECT * FROM academic WHERE student_id='$id'";
	$resultof4 = mysql_query($query4,$con) or die(mysql_error());
	$academic_data = mysql_fetch_array($resultof4);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
	<tr id="'.$row['student_id'].'">
	<td>'. $row['student_id'].'</td>
	<td>'. $academic_data['year_of_admn'].', '.$academic_data['sem'].' Sem, '.$academic_data['branch'].', '.$academic_data['course'].'</td>
	<td>'. $reset['name'].'</td>
	<td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
	<td>'. $distancedata['distance'].'&nbsp;Km</td>
	<td>'. $reset['category_code'].', '.$reset['gender'].'</td>
	<td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
	<td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
	<td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
}
}

//filter by region ends here//

if($q=='category')   //filter by category starts here//
{
	
	echo'<h2 style="color:#ccc">Students From DOP category</h2>';
	echo '<table width=100%>
	<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
	$query1 = "SELECT * FROM student NATURAL JOIN distance_from_home NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND category_code='DOP' AND student.student_id = distance_from_home.student_id ORDER BY distance_from_home.distance DESC"; 
	$result = mysql_query($query1,$con) or die(mysql_error());
	while($row = mysql_fetch_array($result)){
		$id=$row['student_id'];
		$query2 = "SELECT * FROM student WHERE student_id='$id'";
		$result1 = mysql_query($query2,$con) or die(mysql_error());
		$reset=mysql_fetch_array($result1);
		$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
		$setaddress=mysql_query($query3,$con) or die(mysql_error());
		$address=mysql_fetch_array($setaddress);
		$query4 = "SELECT * FROM academic WHERE student_id='$id'";
		$resultof4 = mysql_query($query4,$con) or die(mysql_error());
		$academic_data = mysql_fetch_array($resultof4);
		$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
		$resultof5=mysql_query($query5) or die(mysql_error());
		$roomdetails=mysql_fetch_array($resultof5);
		$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
		$resultof6=mysql_query($query6) or die(mysql_error());
		$remarksdata=mysql_fetch_array($resultof6);
		$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
		$resultof7=mysql_query($query7) or die(mysql_error());
		$distancedata=mysql_fetch_array($resultof7);
		$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
		$resultof8=mysql_query($query8) or die(mysql_error());
		$verifydata=mysql_fetch_array($resultof8);
		echo '<tr><td colspan=9><hr /></td></tr>
		<tr id="'.$row['student_id'].'">
		<td>'. $row['student_id'].'</td>
		<td>'. $academic_data['year_of_admn'].', '.$academic_data['sem'].' Sem, '.$academic_data['branch'].', '.$academic_data['course'].'</td>
		<td>'. $reset['name'].'</td>
		<td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
		<td>'. $distancedata['distance'].'&nbsp;Km</td>
		<td>'. $reset['category_code'].', '.$reset['gender'].'</td>
		<td>';
		if($verifydata['document'] == 1)
		{
		      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
		}
		else
		{
		      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
		}
		echo'</td>
		<td>';
		if(isset($roomdetails['room_no']))
		{
		      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
		}
		else
		{
		      echo '<font color="red"><b>Nil</b></font>';
		}
		echo '</td>
		<td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
		</tr>
		<tr><td colspan=9 id="'.$row['student_id'].'a">';
		if(isset($remarksdata['student_id'])){
		      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
		}
		echo '</td></tr>
		<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
	}
	echo '</table> <br />';
	echo'<h2 style="color:#ccc">Students From DOB category</h2>';
	echo '<table width=100%>
	<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
	$query1 = "SELECT * FROM student NATURAL JOIN distance_from_home NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND category_code='DOB' AND student.student_id = distance_from_home.student_id ORDER BY distance_from_home.distance DESC";
	$result = mysql_query($query1,$con) or die(mysql_error());
	while($row = mysql_fetch_array($result)){
		$id=$row['student_id'];
		$query2 = "SELECT * FROM student WHERE student_id='$id'";
		$result1 = mysql_query($query2,$con) or die(mysql_error());
		$reset=mysql_fetch_array($result1);
		$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
		$setaddress=mysql_query($query3,$con) or die(mysql_error());
		$address=mysql_fetch_array($setaddress);
		$query4 = "SELECT * FROM academic WHERE student_id='$id'";
		$resultof4 = mysql_query($query4,$con) or die(mysql_error());
		$academic_data = mysql_fetch_array($resultof4);
		$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
		$resultof5=mysql_query($query5) or die(mysql_error());
		$roomdetails=mysql_fetch_array($resultof5);
		$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
		$resultof6=mysql_query($query6) or die(mysql_error());
		$remarksdata=mysql_fetch_array($resultof6);
		$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
		$resultof7=mysql_query($query7) or die(mysql_error());
		$distancedata=mysql_fetch_array($resultof7);
		$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
		$resultof8=mysql_query($query8) or die(mysql_error());
		$verifydata=mysql_fetch_array($resultof8);
		echo '<tr><td colspan=9><hr /></td></tr>
		<tr id="'.$row['student_id'].'">
		<td>'. $row['student_id'].'</td>
		<td>'. $academic_data['year_of_admn'].', '.$academic_data['sem'].' Sem, '.$academic_data['branch'].', '.$academic_data['course'].'</td>
		<td>'. $reset['name'].'</td>
		<td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
		<td>'. $distancedata['distance'].'&nbsp;Km</td>
		<td>'. $reset['category_code'].', '.$reset['gender'].'</td>
		<td>';
		if($verifydata['document'] == 1)
		{
		      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
		}
		else
		{
		      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
		}
		echo'</td>
		<td>';
		if(isset($roomdetails['room_no']))
		{
		      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
		}
		else
		{
		      echo '<font color="red"><b>Nil</b></font>';
		}
		echo '</td>
		<td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
		</tr>
		<tr><td colspan=9 id="'.$row['student_id'].'a">';
		if(isset($remarksdata['student_id'])){
		      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
		}
		echo '</td></tr>
		<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
	}
	echo '</table> <br />';
	echo'<h2 style="color:#ccc">Students From DSC Category</h2>';
	echo '<table width=100%>
	<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
	$query1 = "SELECT * FROM student NATURAL JOIN distance_from_home NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND category_code='DSC' AND student.student_id = distance_from_home.student_id ORDER BY distance_from_home.distance DESC";
	$result = mysql_query($query1,$con) or die(mysql_error());
	while($row = mysql_fetch_array($result)){
		$id=$row['student_id'];
		$query2 = "SELECT * FROM student WHERE student_id='$id'";
		$result1 = mysql_query($query2,$con) or die(mysql_error());
		$reset=mysql_fetch_array($result1);
		$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
		$setaddress=mysql_query($query3,$con) or die(mysql_error());
		$address=mysql_fetch_array($setaddress);
		$query4 = "SELECT * FROM academic WHERE student_id='$id'";
		$resultof4 = mysql_query($query4,$con) or die(mysql_error());
		$academic_data = mysql_fetch_array($resultof4);
		$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
		$resultof5=mysql_query($query5) or die(mysql_error());
		$roomdetails=mysql_fetch_array($resultof5);
		$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
		$resultof6=mysql_query($query6) or die(mysql_error());
		$remarksdata=mysql_fetch_array($resultof6);
		$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
		$resultof7=mysql_query($query7) or die(mysql_error());
		$distancedata=mysql_fetch_array($resultof7);
		$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
		$resultof8=mysql_query($query8) or die(mysql_error());
		$verifydata=mysql_fetch_array($resultof8);
		echo '<tr><td colspan=9><hr /></td></tr>
		<tr id="'.$row['student_id'].'">
		<td>'. $row['student_id'].'</td>
		<td>'. $academic_data['year_of_admn'].', '.$academic_data['sem'].' Sem, '.$academic_data['branch'].', '.$academic_data['course'].'</td>
		<td>'. $reset['name'].'</td>
		<td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
		<td>'. $distancedata['distance'].'&nbsp;Km</td>
		<td>'. $reset['category_code'].', '.$reset['gender'].'</td>
		<td>';
		if($verifydata['document'] == 1)
		{
		      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
		}
		else
		{
		      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
		}
		echo'</td>
		<td>';
		if(isset($roomdetails['room_no']))
		{
		      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
		}
		else
		{
		      echo '<font color="red"><b>Nil</b></font>';
		}
		echo '</td>
		<td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
		</tr>
		<tr><td colspan=9 id="'.$row['student_id'].'a">';
		if(isset($remarksdata['student_id'])){
		      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
		}
		echo '</td></tr>
		<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
	}
	echo '</table> <br />';
	echo'<h2 style="color:#ccc">Students From DST Category</h2>';
	echo '<table width=100%>
	<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
	$query1 = "SELECT * FROM student NATURAL JOIN distance_from_home NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND category_code='DST' AND student.student_id = distance_from_home.student_id ORDER BY distance_from_home.distance DESC";
	$result = mysql_query($query1,$con) or die(mysql_error());
	while($row = mysql_fetch_array($result)){
		$id=$row['student_id'];
		$query2 = "SELECT * FROM student WHERE student_id='$id'";
		$result1 = mysql_query($query2,$con) or die(mysql_error());
		$reset=mysql_fetch_array($result1);
		$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
		$setaddress=mysql_query($query3,$con) or die(mysql_error());
		$address=mysql_fetch_array($setaddress);
		$query4 = "SELECT * FROM academic WHERE student_id='$id'";
		$resultof4 = mysql_query($query4,$con) or die(mysql_error());
		$academic_data = mysql_fetch_array($resultof4);
		$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
		$resultof5=mysql_query($query5) or die(mysql_error());
		$roomdetails=mysql_fetch_array($resultof5);
		$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
		$resultof6=mysql_query($query6) or die(mysql_error());
		$remarksdata=mysql_fetch_array($resultof6);
		$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
		$resultof7=mysql_query($query7) or die(mysql_error());
		$distancedata=mysql_fetch_array($resultof7);
		$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
		$resultof8=mysql_query($query8) or die(mysql_error());
		$verifydata=mysql_fetch_array($resultof8);
		echo '<tr><td colspan=9><hr /></td></tr>
		<tr id="'.$row['student_id'].'">
		<td>'. $row['student_id'].'</td>
		<td>'. $academic_data['year_of_admn'].', '.$academic_data['sem'].' Sem, '.$academic_data['branch'].', '.$academic_data['course'].'</td>
		<td>'. $reset['name'].'</td>
		<td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
		<td>'. $distancedata['distance'].'&nbsp;Km</td>
		<td>'. $reset['category_code'].', '.$reset['gender'].'</td>
		<td>';
		if($verifydata['document'] == 1)
		{
		      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
		}
		else
		{
		      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
		}
		echo'</td>
		<td>';
		if(isset($roomdetails['room_no']))
		{
		      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
		}
		else
		{
		      echo '<font color="red"><b>Nil</b></font>';
		}
		echo '</td>
		<td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
		</tr>
		<tr><td colspan=9 id="'.$row['student_id'].'a">';
		if(isset($remarksdata['student_id'])){
		      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
		}
		echo '</td></tr>
		<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
	}
	echo '</table> <br />';
	echo'<h2 style="color:#ccc">Students From OOP category</h2>';
	echo '<table width=100%>
	<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
	$query1 = "SELECT * FROM student NATURAL JOIN distance_from_home NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND category_code='OOP' AND student.student_id = distance_from_home.student_id ORDER BY distance_from_home.distance DESC";
	$result = mysql_query($query1,$con) or die(mysql_error());
	while($row = mysql_fetch_array($result)){
		$id=$row['student_id'];
		$query2 = "SELECT * FROM student WHERE student_id='$id'";
		$result1 = mysql_query($query2,$con) or die(mysql_error());
		$reset=mysql_fetch_array($result1);
		$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
		$setaddress=mysql_query($query3,$con) or die(mysql_error());
		$address=mysql_fetch_array($setaddress);
		$query4 = "SELECT * FROM academic WHERE student_id='$id'";
		$resultof4 = mysql_query($query4,$con) or die(mysql_error());
		$academic_data = mysql_fetch_array($resultof4);
		$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
		$resultof5=mysql_query($query5) or die(mysql_error());
		$roomdetails=mysql_fetch_array($resultof5);
		$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
		$resultof6=mysql_query($query6) or die(mysql_error());
		$remarksdata=mysql_fetch_array($resultof6);
		$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
		$resultof7=mysql_query($query7) or die(mysql_error());
		$distancedata=mysql_fetch_array($resultof7);
		$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
		$resultof8=mysql_query($query8) or die(mysql_error());
		$verifydata=mysql_fetch_array($resultof8);
		echo '<tr><td colspan=9><hr /></td></tr>
		<tr id="'.$row['student_id'].'">
		<td>'. $row['student_id'].'</td>
		<td>'. $academic_data['year_of_admn'].', '.$academic_data['sem'].' Sem, '.$academic_data['branch'].', '.$academic_data['course'].'</td>
		<td>'. $reset['name'].'</td>
		<td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
		<td>'. $distancedata['distance'].'&nbsp;Km</td>
		<td>'. $reset['category_code'].', '.$reset['gender'].'</td>
		<td>';
		if($verifydata['document'] == 1)
		{
		      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
		}
		else
		{
		      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
		}
		echo'</td>
		<td>';
		if(isset($roomdetails['room_no']))
		{
		      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
		}
		else
		{
		      echo '<font color="red"><b>Nil</b></font>';
		}
		echo '</td>
		<td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
		</tr>
		<tr><td colspan=9 id="'.$row['student_id'].'a">';
		if(isset($remarksdata['student_id'])){
		      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
		}
		echo '</td></tr>
		<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
	}
	echo '</table> <br />';
}


 // ------------------------------ filter by category ends here -----------------------------------------------//




// ------------------------------ filter by gender start here -----------------------------------------------//

if($q=='gender')
{
	echo'<h2 style="color:#ccc">Boy Applicants</h2>';
	echo '<table width=100%>
	<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
	$query1 = "SELECT * FROM student NATURAL JOIN distance_from_home NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND gender='male' AND student.student_id = distance_from_home.student_id ORDER BY distance_from_home.distance DESC";
	$result = mysql_query($query1,$con) or die(mysql_error());
	while($row = mysql_fetch_array($result)){
		$id=$row['student_id'];
		$query2 = "SELECT * FROM student WHERE student_id='$id'";
		$result1 = mysql_query($query2,$con) or die(mysql_error());
		$reset=mysql_fetch_array($result1);
		$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
		$setaddress=mysql_query($query3,$con) or die(mysql_error());
		$address=mysql_fetch_array($setaddress);
		$query4 = "SELECT * FROM academic WHERE student_id='$id'";
		$resultof4 = mysql_query($query4,$con) or die(mysql_error());
		$academic_data = mysql_fetch_array($resultof4);
		$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
		$resultof5=mysql_query($query5) or die(mysql_error());
		$roomdetails=mysql_fetch_array($resultof5);
		$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
		$resultof6=mysql_query($query6) or die(mysql_error());
		$remarksdata=mysql_fetch_array($resultof6);
		$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
		$resultof7=mysql_query($query7) or die(mysql_error());
		$distancedata=mysql_fetch_array($resultof7);
		$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
		$resultof8=mysql_query($query8) or die(mysql_error());
		$verifydata=mysql_fetch_array($resultof8);
		echo '<tr><td colspan=9><hr /></td></tr>
		<tr id="'.$row['student_id'].'">
		<td>'. $row['student_id'].'</td>
		<td>'. $academic_data['year_of_admn'].', '.$academic_data['sem'].' Sem, '.$academic_data['branch'].', '.$academic_data['course'].'</td>
		<td>'. $reset['name'].'</td>
		<td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
		<td>'. $distancedata['distance'].'&nbsp;Km</td>
		<td>'. $reset['category_code'].', '.$reset['gender'].'</td>
		<td>';
		if($verifydata['document'] == 1)
		{
		      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
		}
		else
		{
		      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
		}
		echo'</td>
		<td>';
		if(isset($roomdetails['room_no']))
		{
		      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
		}
		else
		{
		      echo '<font color="red"><b>Nil</b></font>';
		}
		echo '</td>
		<td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
		</tr>
		<tr><td colspan=9 id="'.$row['student_id'].'a">';
		if(isset($remarksdata['student_id'])){
		      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
		}
		echo '</td></tr>
		<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
	}
	echo '</table> <br />';
	echo'<h2 style="color:#ccc">Girl Applicants</h2>';
	echo '<table width=100%>
	<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
	$query1 = "SELECT * FROM student NATURAL JOIN distance_from_home NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND gender='female' AND student.student_id = distance_from_home.student_id ORDER BY distance_from_home.distance DESC";
	$result = mysql_query($query1,$con) or die(mysql_error());
	while($row = mysql_fetch_array($result)){
		$id=$row['student_id'];
		$query2 = "SELECT * FROM student WHERE student_id='$id'";
		$result1 = mysql_query($query2,$con) or die(mysql_error());
		$reset=mysql_fetch_array($result1);
		$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
		$setaddress=mysql_query($query3,$con) or die(mysql_error());
		$address=mysql_fetch_array($setaddress);
		$query4 = "SELECT * FROM academic WHERE student_id='$id'";
		$resultof4 = mysql_query($query4,$con) or die(mysql_error());
		$academic_data = mysql_fetch_array($resultof4);
		$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
		$resultof5=mysql_query($query5) or die(mysql_error());
		$roomdetails=mysql_fetch_array($resultof5);
		$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
		$resultof6=mysql_query($query6) or die(mysql_error());
		$remarksdata=mysql_fetch_array($resultof6);
		$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
		$resultof7=mysql_query($query7) or die(mysql_error());
		$distancedata=mysql_fetch_array($resultof7);
		$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
		$resultof8=mysql_query($query8) or die(mysql_error());
		$verifydata=mysql_fetch_array($resultof8);
		echo '<tr><td colspan=9><hr /></td></tr>
		<tr id="'.$row['student_id'].'">
		<td>'. $row['student_id'].'</td>
		<td>'. $academic_data['year_of_admn'].', '.$academic_data['sem'].' Sem, '.$academic_data['branch'].', '.$academic_data['course'].'</td>
		<td>'. $reset['name'].'</td>
		<td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
		<td>'. $distancedata['distance'].'&nbsp;Km</td>
		<td>'. $reset['category_code'].', '.$reset['gender'].'</td>
		<td>';
		if($verifydata['document'] == 1)
		{
		      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
		}
		else
		{
		      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
		}
		echo'</td>
		<td>';
		if(isset($roomdetails['room_no']))
		{
		      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
		}
		else
		{
		      echo '<font color="red"><b>Nil</b></font>';
		}
		echo '</td>
		<td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
		</tr>
		<tr><td colspan=9 id="'.$row['student_id'].'a">';
		if(isset($remarksdata['student_id'])){
		      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
		}
		echo '</td></tr>
		<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
	}
echo '</table> <br />';
}


// ------------------------------ filter by gender ends here -----------------------------------------------//


// ---------------------------------------- filter by semester and year  /*starts from here/ --------------------------------- //


if($q=='yearandcategory')
{

$categ = 'OOP';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time()))." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<h2 style="color:#ccc">List is Generated Yearwise</h2>';
echo '<br /><br />';
echo'<h3 style="color:#668CFF">First Year</h3><hr />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 $categ = 'OSC';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time()))." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 $categ = 'OST';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time()))." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 $categ = 'OOB';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time()))." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 $categ = 'DOP';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time()))." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 $categ = 'DSC';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time()))." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 
 $categ = 'DST';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time()))." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 
 $categ = 'DOB';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time()))." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 
 $categ = 'KM';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time()))." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 
 $categ = 'NRI';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time()))." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 
 
$categ = 'OOP';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-1)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#668CFF">Second Year</h3><hr />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 $categ = 'OSC';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-1)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 $categ = 'OST';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-1)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 $categ = 'OOB';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-1)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 $categ = 'DOP';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-1)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 $categ = 'DSC';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-1)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 
 $categ = 'DST';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-1)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 
 $categ = 'DOB';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-1)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 
 $categ = 'KM';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-1)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 
 $categ = 'NRI';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-1)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 



$categ = 'OOP';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-2)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<h2 style="color:#ccc">List is Generated Yearwise</h2>';
echo '<br /><br />';
echo'<h3 style="color:#668CFF">Third Year</h3><hr />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 $categ = 'OSC';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-2)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 $categ = 'OST';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-2)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 $categ = 'OOB';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-2)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 $categ = 'DOP';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-2)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 $categ = 'DSC';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-2)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 
 $categ = 'DST';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-2)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 
 $categ = 'DOB';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-2)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 
 $categ = 'KM';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-2)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 
 $categ = 'NRI';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-2)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 
 $categ = 'OOP';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-3)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<h2 style="color:#ccc">List is Generated Yearwise</h2>';
echo '<br /><br />';
echo'<h3 style="color:#668CFF">Fourth Year</h3><hr />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 $categ = 'OSC';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-3)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 $categ = 'OST';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-3)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 $categ = 'OOB';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-3)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 $categ = 'DOP';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-3)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 $categ = 'DSC';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-3)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 
 $categ = 'DST';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-3)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 
 $categ = 'DOB';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-3)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 
 $categ = 'KM';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-3)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 
 
 
 
 $categ = 'NRI';
$query = "SELECT * FROM academic NATURAL JOIN distance_from_home NATURAL JOIN student NATURAL JOIN docu_submission WHERE docu_submission.document=1 AND academic.year_of_admn = ".(date("Y", time())-3)." AND academic.student_id = distance_from_home.student_id AND student.category_code = '".$categ."' ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

echo '<br /><br />';
echo'<h3 style="color:#ccc">Category : '.$categ.'</h3>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
while($row = mysql_fetch_array($result)){
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2,$con) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3,$con) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query5="SELECT * FROM allotment_details WHERE student_id = '".$id."'";
	$resultof5=mysql_query($query5) or die(mysql_error());
	$roomdetails=mysql_fetch_array($resultof5);
	$query6="SELECT * FROM remarks WHERE student_id = '".$id."' LIMIT 1";
	$resultof6=mysql_query($query6) or die(mysql_error());
	$remarksdata=mysql_fetch_array($resultof6);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	$query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	$resultof8=mysql_query($query8) or die(mysql_error());
	$verifydata=mysql_fetch_array($resultof8);
	echo '<tr><td colspan=9><hr /></td></tr>
  <tr id="'.$row['student_id'].'">
  <td>'. $row['student_id'].'</td>
  <td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
  <td>'. $reset['name'].'</td>
  <td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
  <td>'. $distancedata['distance'].'&nbsp;Km</td>
  <td>'. $reset['category_code'].', '.$reset['gender'].'</td>
  <td>';
	if($verifydata['document'] == 1)
	{
	      echo '<img src="../images/accept.png" alt="verified" name="verified" />';
	}
	else
	{
	      echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';
	}
	echo'</td>
  <td>';
	if(isset($roomdetails['room_no']))
	{
	      echo '<font color="green"><b>'.$roomdetails['hostel_name'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
  <td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=9 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=9 id="'.$row['student_id'].'b"></td></tr>';
 }
 echo '</table>';
 

}

?>
