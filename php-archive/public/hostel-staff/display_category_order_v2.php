<?php
       ob_start();
       require_once("../../includes/initialize.php");
       if(!$session->is_logged_in()){ redirect_to("login.php"); }
?>

<?php

$heading = 'Filters Applied -';
$natural_joins = 'NATURAL JOIN distance_from_home NATURAL JOIN docu_submission';
$conditions = 'student.student_id = distance_from_home.student_id AND docu_submission.document=1';

if($_REQUEST['category'] != 'none')
{
}
if($_REQUEST['backs'] != 'none')
{
}
if($_REQUEST['gender'] != 'none')
{
}
if($_REQUEST['course'] != 'none')
{
}

display_after_filtering($heading, $natural_joins, $conditions);

function display_after_filtering($heading, $natural_joins, $conditions)
{
	$query = "SELECT * FROM student ".$natural_joins." WHERE ".$conditions." ORDER BY distance_from_home.distance DESC";
	$result = mysql_query($query) or die(mysql_error());
        if(mysql_num_rows($result))
        {
          echo '<h2 style="color:#ccc">'.$heading.' | Count = '.mysql_num_rows($result).'</h2>';
          echo '<table width=100%>
	  <tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Room No</th><th>Actions</th></tr>';
        }
	while($row = mysql_fetch_array($result)){
		$id=$row['student_id'];
		$query2 = "SELECT * FROM student WHERE student_id='$id'";
		$result1 = mysql_query($query2) or die(mysql_error());
		$reset=mysql_fetch_array($result1);
		$query3="SELECT present_add_line, present_city FROM present_address WHERE student_id='$id'";
		$setaddress=mysql_query($query3) or die(mysql_error());
		$address=mysql_fetch_array($setaddress);
		$query4 = "SELECT * FROM academic WHERE student_id='$id'";
		$resultof4 = mysql_query($query4) or die(mysql_error());
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
	if(mysql_num_rows($result))
        {
          echo '</table> <br />';
        }
}


?>


<?php
if(isset($database)) { $database->close_connection(); }
ob_end_flush();

?>