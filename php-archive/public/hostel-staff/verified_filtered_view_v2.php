<?php
       ob_start();
       require_once("../../includes/initialize.php");
       if(!$session->is_logged_in()){ redirect_to("login.php"); }
       include_layout_template('admin_header.php');
       ini_set('max_execution_time', 1200); //1200 seconds = 20 minutes
?>


<style type="text/css">
#table_index tr td { text-align : center; }
</style>


<script type="text/javascript" src="side_functions.js">

</script>


<h1><span style="color:#FF3D3D;">Verified Applications</span><span style="color: #CCC;"> - Apply Filter V.2</span></h1>
<br />

<div id="form-div">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

<table width="100%">
<tr>
	<td>
	Category <br />
	<select name="category" id="form-category">
		<option value="none">Show all</option>
		<?php
			$query = "SELECT student_id,category_code FROM student NATURAL JOIN docu_submission WHERE student.student_id = docu_submission.student_id AND docu_submission.document = 1 GROUP BY student.category_code";
			$result = mysql_query($query);
			while($data = mysql_fetch_array($result))
			{
				echo "<option value='".$data['category_code']."' id='".$data['category_code']."' ";
				if(isset($_POST['submit']))
				{
					if($data['category_code'] == $_REQUEST['category'] )
					{
						echo "selected='true'";
					}
				}				
				echo ">".$data['category_code']."</option>";
			} 
		?>s
	</select>
	</td>
	<td>
	Backs <small>(Enter number)</small><br />
	<input type="text" name="backs" size="3" value="<?php
	if(isset($_POST['submit']))
	{
		echo $_REQUEST['backs'];
	}	
	?>" />
	</td>
	<td>
	Year of Admission<br />
	<select name="yr_admission" id="form-yr-admn">
		<option value="none">Show all</option>
		<?php
			$query = "SELECT student_id,year_of_admn FROM academic NATURAL JOIN docu_submission WHERE academic.student_id = docu_submission.student_id AND docu_submission.document = 1 GROUP BY academic.year_of_admn";
			$result = mysql_query($query);
			while($data = mysql_fetch_array($result))
			{
				echo "<option value='".$data['year_of_admn']."' id='".$data['year_of_admn']."' ";
				if(isset($_POST['submit']))
				{
					if($data['year_of_admn'] == $_REQUEST['yr_admission'] )
					{
						echo "selected='true'";
					}
				}				
				echo ">".$data['year_of_admn']."</option>";
			} 
		?>
	</select>
	</td>
	<td>
	Gender<br />
	<select name="gender" id="form-gender">
		<option value="none" id="none" <?php
		if(isset($_POST['submit']))
		{
			if($_REQUEST['gender'] == 'none')
			{
				echo "selected=true";
			}
		}
		?>>Show all</option>
		<option value="male" id="male" <?php
		if(isset($_POST['submit']))
		{
			if($_REQUEST['gender'] == 'male')
			{
				echo "selected=true";
			}
		}
		?>>Male</option>
		<option value="female" id="female" <?php
		if(isset($_POST['submit']))
		{
			if($_REQUEST['gender'] == 'female')
			{
				echo "selected=true";
			}
		}
		?>>Female</option>
	</select>
	</td>
	<td>
	Course<br />
	<select name="course" id="form-course">
		<option value="none">Show all</option>
		<?php
			$query = "SELECT student_id,course FROM academic NATURAL JOIN docu_submission WHERE academic.student_id = docu_submission.student_id AND docu_submission.document = 1 GROUP BY academic.course";
			$result = mysql_query($query);
			while($data = mysql_fetch_array($result))
			{
				echo "<option value='".$data['course']."' id='".$data['course']."' ";
				if(isset($_POST['submit']))
				{
					if($data['course'] == $_REQUEST['course'] )
					{
						echo "selected='true'";
					}
				}
				echo ">".$data['course']."</option>";
			} 
		?>
	</select>
	</td>
	<td>
	Allotted<br />
	<select name="allotted" id="form-allotted">
		<option value="none" id="none" <?php
		if(isset($_POST['submit']))
		{
			if($_REQUEST['allotted'] == 'none')
			{
				echo "selected=true";
			}
		}
		?>>Show all</option>
		<option value="allotted" id="allotted" <?php
		if(isset($_POST['submit']))
		{
			if($_REQUEST['allotted'] == 'allotted')
			{
				echo "selected=true";
			}
		}
		?>>Allotted</option>
		<option value="nonallotted" id="nonallotted" <?php
		if(isset($_POST['submit']))
		{
			if($_REQUEST['allotted'] == 'nonallotted')
			{
				echo "selected=true";
			}
		}
		?>>Not Allotted</option>
	</select>
	</td>
	<td>
	Order<br />
	<select name="order">
		<option value="distance" id="distance" <?php
		if(isset($_POST['submit']))
		{
			if($_REQUEST['order'] == 'distance')
			{
				echo "selected=true";
			}
		}
		?>>Distanse Descending</option>
		<option value="name" id="name" <?php
		if(isset($_POST['submit']))
		{
			if($_REQUEST['order'] == 'name')
			{
				echo "selected=true";
			}
		}
		?>>Name Alphabetical</option>
		<option value="timestamp" id="timestamp" <?php
		if(isset($_POST['submit']))
		{
			if($_REQUEST['order'] == 'timestamp')
			{
				echo "selected=true";
			}
		}
		?>>Timestamp</option>
		<option value="hrollno" id="hrollno" <?php
		if(isset($_POST['submit']))
		{
			if($_REQUEST['order'] == 'hrollno')
			{
				echo "selected=true";
			}
		}
		?>>Hostel Roll Number(Only for re-allotment)</option>
	</select>
	</td>
	<td>Type:<br>
	<select name="typeofreg">
	   <option value="none" id="none" <?php
		if(isset($_POST['submit']))
		{
			if($_REQUEST['typeofreg'] == 'none')
			{
				echo "selected=true";
			}
		}
		?>>Show all</option>
		<option value="regis" id="regis" <?php
		if(isset($_POST['submit']))
		{
			if($_REQUEST['typeofreg'] == 'regis')
			{
				echo "selected=true";
			}
		}
		?>>Registration</option>
		<option value="reallotment" id="reallotment" <?php
		if(isset($_POST['submit']))
		{
			if($_REQUEST['typeofreg'] == 'reallotment')
			{
				echo "selected=true";
			}
		}
		?>>Reallotment</option>
		
	</select>
	</td>
	<td>
	<input type="submit" name="submit">
	</td>
</tr>
</table>
</form>
</div>

<br /><br />

<?php


if(isset($_POST['submit']))
{

	$heading = '	';
	$natural_joins = 'NATURAL JOIN distance_from_home NATURAL JOIN docu_submission ';
	$conditions = 'student.student_id = distance_from_home.student_id AND docu_submission.document=1 ';
	$order = '';
	
	echo '<font color=blue><b>*</b></font> marked names have a duplicate entry';
	echo "<div id='filter-info' style='display: none;'>";
	echo "<span id='filter-category'>";
	echo $_REQUEST['category'];
	echo "</span>";
	echo "<span id='filter-backs'>";
	echo $_REQUEST['backs'];
	echo "</span>";
	echo "<span id='filter-gender'>";
	echo $_REQUEST['gender'];
	echo "</span>";
	echo "<span id='filter-course'>";
	echo $_REQUEST['course'];
	echo "</span>";
	echo "<span id='filter-yr-admn'>";
	echo $_REQUEST['yr_admission'];
	echo "</span>";
	echo "<span id='filter-allotted'>";
	echo $_REQUEST['allotted'];
	echo "</span>";
	echo "<span id='filter-verified'>";
	echo "verified</span>";
	echo "<span id='filter-order'>";
	echo $_REQUEST['order'];
	echo "</span>";
	echo "<span id='filter-typeofreg'>";
	echo $_REQUEST['typeofreg'];
	echo "</span>";
	echo "</div>";
	
	if($_REQUEST['category'] != 'none')
	{
		$heading .= ' Category = '.$_REQUEST['category'].', ';
		$conditions .= ' AND student.category_code="'.$_REQUEST['category'].'"';
		echo '';
	}
	if($_REQUEST['backs'] != '')
	{
		$heading .= ' Backs = '.$_REQUEST['backs'].', ';
		$conditions .= ' AND student.backs="'.$_REQUEST['backs'].'"';
	}
	if($_REQUEST['gender'] != 'none')
	{
		$heading .= ' Gender = '.$_REQUEST['gender'].', ';	
		$conditions .= ' AND student.gender = "'.$_REQUEST['gender'].'"';
	}
	if($_REQUEST['course'] != 'none' || $_REQUEST['yr_admission'] != 'none')
	{
		$natural_joins .= ' NATURAL JOIN academic';
		$conditions .= ' AND student.student_id = academic.student_id';
	}
	if($_REQUEST['course'] != 'none')
	{
		$heading .= ' Course = '.$_REQUEST['course'].', ';
		$conditions .= ' AND academic.course="'.$_REQUEST['course'].'"';
	}
	if($_REQUEST['yr_admission'] != 'none')
	{
		$heading .= ' Year of Admission = '.$_REQUEST['yr_admission'].', ';
		$conditions .= ' AND academic.year_of_admn="'.$_REQUEST['yr_admission'].'"';
	}
	if($_REQUEST['allotted'] != 'none')
	{
		if($_REQUEST['allotted'] == 'nonallotted')
		{
			$heading .= ' Allotted = Not - Allotted, ';
			$conditions .= ' AND student.student_id NOT IN ( SELECT student_id FROM available_room )';
		}
		if($_REQUEST['allotted'] == 'allotted')
		{
			$natural_joins .= ' NATURAL JOIN available_room';
			$heading .= ' Allotted = Allotted, ';
			$conditions .= ' AND student.student_id = available_room.student_id';
		}
	}
	if($_REQUEST['order'] == 'name')
	{
		$order = ' ORDER BY student.name ASC';
	}
	if($_REQUEST['order'] == 'distance')
	{
		$order = ' ORDER BY distance_from_home.distance DESC';
	}
	if($_REQUEST['order'] == 'timestamp')
	{
		$order = ' ORDER BY student.date_of_submisssion DESC';
	}
	if($_REQUEST['order'] == 'hrollno')
	{
		$order = ' ORDER BY student.recipt ASC';
	}
	if($_REQUEST['typeofreg'] != 'none')
	{   
	    if($_REQUEST['typeofreg']=='regis')
		{
		    $heading .= ' Type = Registered, ';	
		    $conditions .= ' AND student.reallot = "0"';
		}
		if($_REQUEST['typeofreg']=='reallotment')
		{
		    $heading .= ' Type = Reallotment, ';	
		    $conditions .= ' AND student.reallot = "1"';
		}
        		
	}
	
	function color_dist($distance)
	{
		if($distance <25)
		{
			return '<font color=red>'.$distance.'</font>';
		}
		else
		{
			return $distance;
		}
	}
	function similar_detection($id)
	{
		$similarquery1 = "SELECT name,father_name,reallot FROM student WHERE student_id='$id' LIMIT 1";
		$resultsim1 = mysql_query($similarquery1);
		$simdata1 = mysql_fetch_array($resultsim1);
		$name = $simdata1['name'];
		$father_name = $simdata1['father_name'];
		$similarquery2 = "SELECT *,count(*) FROM student NATURAL JOIN docu_submission WHERE `docu_submission`.`student_id`=`student`.`student_id` AND `docu_submission`.`document`=1 AND name='$name' AND father_name='$father_name'";
		$resultsim2 = mysql_query($similarquery2);
		$simdata2 = mysql_fetch_array($resultsim2);
		$count = $simdata2['count(*)'];
		if($count > 1)
		{
			return $name.'<font color=blue><b>*</b></font>';
		}
		else
		{
			return $name;
		}
	}
	function display_filter_stat($heading, $natural_joins, $conditions)
	{
		echo '<table width=100% style="background-color: #CCFFD9;border: solid;border-width: 1px;"><tr><td style="padding: 10px;">';
		$query_stats_all = "SELECT * FROM student ".$natural_joins." WHERE ".$conditions;
		$result_stats = mysql_query($query_stats_all) or die(mysql_error());
		$count_all = mysql_num_rows($result_stats);
		echo '<p>';
		echo '<b><span style="color:#CC0000;">Result Stats</span></b><br />';
		echo 'Requested Filters : '.$heading;
		echo '<br />Total Result : '.$count_all;
		$query_stats_all = "SELECT DISTINCT `father_name`, `name` FROM student ".$natural_joins." WHERE ".$conditions;
		$result_stats = mysql_query($query_stats_all) or die(mysql_error());
		$count_all = mysql_num_rows($result_stats);
		echo '<br />Total Distinct Entries : '.$count_all;
		$query_stats_all = "SELECT * FROM student ".$natural_joins." WHERE ".$conditions." AND `distance_from_home`.`distance` < 25";
		$result_stats = mysql_query($query_stats_all) or die(mysql_error());
		$count_all = mysql_num_rows($result_stats);
		echo '<br />Distance Less than 25Km : '.$count_all;
		echo '</p>';
		echo '</td><td style="text-align:right;padding: 10px;"><b><a href="#" onClick="export_excel_link()"><img src="../images/excel_icon.png" /><br />Export to Excel</a></b></td></tr></table>';
	}
	function display_after_filtering($heading, $natural_joins, $conditions, $order)
	{
		display_filter_stat($heading, $natural_joins, $conditions);
		$query = "SELECT * FROM student ".$natural_joins." WHERE ".$conditions." ".$order;
		$result = mysql_query($query) or die(mysql_error());
		
		// if no values found then dont display the headings of the table.
		if(mysql_num_rows($result))
		{
			echo '<h2 style="color:#FF6633">'.$heading.'| Count = '.mysql_num_rows($result).'</h2>';
			echo '<table width=100% id="gTable"><tr><th>S.No | F. No</th><th>Academics</th><th>Name</th><th>Type</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Room No</th><th width=180px>Actions</th></tr>';
		}
		else {
			echo '<h2 style="color:#FF6633">No entries found!!</h2>';
		}		
		$i = 1;
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
			$query5="SELECT * FROM available_room WHERE student_id = '".$id."'";
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
			if($reset['reallot']==0)
			$reallot='<img height="20" src="../images/fresh.png">';
			else
			$reallot='<img height="20" src="../images/reallot.png">';
			echo '<tr><td colspan=9><hr /></td></tr>
			<tr id="'.$row['student_id'].'">
			<td>'.$i.' | '.$row['student_id'].'<br />'.$row['recipt'].'</td>
			<td>'. $academic_data['year_of_admn'].', '.$academic_data['sem'].' Sem, '.$academic_data['branch'].', '.$academic_data['course'].'</td>
			<td>'. similar_detection($id).'</td>
			<td>'.$reallot.'&ensp;</td>
			<td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].'</td>
			<td>'.color_dist($distancedata['distance'].'&nbsp;Km').'</td>
			<td>'. $reset['category_code'].', '.$reset['gender'].'</td>
			<td>';
			if(isset($roomdetails['room_no']))
			{
			      echo '<font color="green"><b>'.$roomdetails['hostel'].', '.$roomdetails['room_no'].'</b></font>';
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
			$i++;
		}
		
		// since table does not start if no value is found so it does not end too
		if(mysql_num_rows($result))
	        {
	          echo '</table> <br />';
	        }
	}
	
	
	display_after_filtering($heading, $natural_joins, $conditions, $order);
	

}

?>



<?php include_layout_template('footer.php');
if(isset($database)) { $database->close_connection(); }
ob_end_flush();

?>
