<?php
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }
include_layout_template('admin_header.php');
ob_start();
?>

<script type='text/javascript' src="side_functions.js">
</script>
<script type='text/javascript'>
function get_columns(table_name){
document.getElementById('f1').innerHTML = "<img src='../images/ajax-loader_b.gif' height=24>'";
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else { // code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById('f1').innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET", "get_columns.php?table_name=" + table_name, true);
	xmlhttp.send();
}
</script>
<center><h2 style="color:#ccc">Search</h2></center>
<br />

<form action="search.php" method="get" name="main">
       
       Search By:<br><br>

<select name="table_name" onchange="get_columns(this.value)">
<option value="" disabled selected>Select Domain</option>
<?php 
$sql = "show tables";
$query = $database->query($sql);
while($tables = $database->fetch_array($query)){
echo '<option value="'.$tables[0].'">'.refine($tables[0]).'</option>';
}
?>
</select>
<span id="f1"></span>
       &nbsp;&nbsp;&nbsp;
       Enter Query: <input type="text" name="query" />
       &nbsp;&nbsp;&nbsp;
       <input type="checkbox" name="allotted" />&nbsp;&nbsp;Search only among allotted students
       &nbsp;&nbsp;&nbsp;
       <input type="submit" value="Search" />
</form>


<?php

if(isset($_GET['query']))
{
    $search_query = $_GET['query'];
    if (!get_magic_quotes_gpc())
    {
	$search_query = addslashes($search_query);
    }
    $table_name = $_GET['table_name'];
    $search_field = $_GET['column_name'];
    switch ($search_field)
    {
	case 'student_id' : {
	    $table_name = 'student';
	    $search_field = 'student_id';
	    if(!isset($_GET['allotted']))
	    {
		$sql = "SELECT * FROM ".$table_name." WHERE ".$search_field." = '$search_query' ";
	    }
	    else
	    {
		$sql = "SELECT available_room.*,".$table_name.".* FROM available_room,".$table_name." WHERE ".$table_name.".".$search_field." = '$search_query' AND available_room.student_id = ".$table_name.".student_id";
	    }
	    break;
	}
	default : {
	    if(isset($_GET['allotted']))
	    {
		$sql = "SELECT available_room.*,distance_from_home.*,".$table_name.".* FROM available_room,distance_from_home,".$table_name." WHERE ".$search_field." LIKE '%$search_query%' AND available_room.student_id = ".$table_name.".student_id AND ".$table_name.".student_id = distance_from_home.student_id ORDER BY distance_from_home.distance DESC";
	    }
	    else
	    {
		$sql = "SELECT DISTINCT distance_from_home.*,".$table_name.".* FROM distance_from_home,".$table_name." WHERE ".$search_field." LIKE '%$search_query%' AND ".$table_name.".student_id = distance_from_home.student_id ORDER BY distance_from_home.distance DESC";
	    }
	    break;
	}
    }

    $result = mysql_query($sql) or die(mysql_error());
    $count_all = mysql_num_rows($result);
    echo '<table width=100% style="background-color: #CCFFD9;border: solid;border-width: 1px;"><tr><td style="padding: 10px;">
	<p><b><span style="color:#CC0000;">Search Results</span></b><br />
	Query: '.$table_name.', '.$search_field.' = '.$_GET['query'];
    echo '<br />Total Search Result : '.$count_all.'</p></td></tr></table><br/><br/>';
    echo '<table width=100%>
    <tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Type</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';

    
    
    while($row = mysql_fetch_array($result))
    {
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
	if($reset['reallot']==1)
	$reallot='<img height="20" src="../images/reallot.png">';
	else
	$reallot='<img height="20" src="../images/fresh.png">';
	echo '<tr><td colspan=10><hr /></td></tr>
	<tr id="'.$row['student_id'].'">
	<td>'. $row['student_id'].'</td>
	<td>'. $academic_data['year_of_admn'].', '.$academic_data['sem'].' Sem, '.$academic_data['branch'].', '.$academic_data['course'].'</td>
	<td>'. $reset['name'].'</td>
	<td>'.$reallot.'&ensp;</td>
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
	      echo '<font color="green"><b>'.$roomdetails['hostel'].', '.$roomdetails['room_no'].'</b></font>';
	}
	else
	{
	      echo '<font color="red"><b>Nil</b></font>';
	}
	echo '</td>
	<td><a href="edit_student_info.php?id='.$row['student_id'].'">Edit Details</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a><br /><a href="javascript:void(0);" onClick="getAlotData('.$row['student_id'].');">Allot</a> | <a href="javascript:void(0);" onClick="delAllotment('.$row['student_id'].');">Cancel Allotment</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delStudent('.$row['student_id'].');">Delete</a></td>
	</tr>
	<tr><td colspan=10 id="'.$row['student_id'].'a">';
	if(isset($remarksdata['student_id'])){
	      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$id.'">'.$remarksdata['remarks'].'</span></font> (last added : '.$remarksdata['last_added'].')';
	}
	echo '</td></tr>
	<tr><td colspan=10 id="'.$row['student_id'].'b"></td></tr>';
    }
    echo '</table> <br />';
}

?>

<?php include_layout_template('footer.php');
if(isset($database)) { $database->close_connection(); }
ob_end_flush();

?>
