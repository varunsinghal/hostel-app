<?php
require_once ("../../includes/initialize.php");
if (!$session->is_logged_in()) {redirect_to ("login.php");}
include_layout_template ('admin_header.php');

?>
<style type="text/css">
#table_index tr td { text-align : center; }
</style>
<script>
function delFeedback(fid) {
	var r = confirm("Are you sure you want to delete the feedback of this student from database?");
	if (r == true) {
		document.getElementById(fid).innerHTML = "<tr><td colspan=5><center><img src='../images/ajax-loader_b.gif' height=24 /></center></td></tr>'";
		if (fid == "") {
			document.getElementById(fid).innerHTML = "error";
			return;
		}
		if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		} else { // code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById(fid).innerHTML = xmlhttp.responseText;
				document.getElementById(fid + 'a').innerHTML = "";
			}
		}
		xmlhttp.open("POST", "delete_feedback.php", true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send("q=" + fid);
	}
}
// function to add remark field within table
function addRemark(fid) {
	if (document.getElementById('remarks_' + fid) != null) {
		var temp = '<font color="blue">Edit Remark :</font> <input type="text" id="remarkfield_' + fid + '" value="' + document.getElementById('remarks_' + fid).innerHTML + '" size="100" /> <a href="javascript:void(0);" onClick="submitRemark(' + fid + ')">Submit</a>';
		document.getElementById(fid + 'a').innerHTML = temp;
	} else {
		var temp = '<font color="blue">Edit Remark :</font> <input type="text" id="remarkfield_' + fid + '" value="" size="100" /> <a href="javascript:void(0);" onClick="submitRemark(' + fid + ')">Submit</a>';
		document.getElementById(fid + 'a').innerHTML = temp;
	}
}
// function to add remark field ends
// function to submit remark 
function submitRemark(fid) {
	var remark_rec = document.getElementById('remarkfield_' + fid).value;

	document.getElementById(fid + 'a').innerHTML = "<center><img src='../images/ajax-loader_b.gif' height=24 /></center>";
	if (fid == "") {
		document.getElementById(fid + 'a').innerHTML = "error";
		return;
	}
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else { // code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById(fid + 'a').innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("POST", "add_feedback_remark.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("feedback_no=" + fid + "&remark_rec=" + remark_rec);
}
// function to submit remark ends

</script>
<script type="text/javascript">
function popitup(url)
{
    newwindow=window.open(url,'name','height=500,width=600');
    if (window.focus) {newwindow.focus()}
    return false;
}

</script>
<h1><span style="color:#FF3D3D;">Feedback System</span><span style="color: #CCC;"> </span></h1>
<br />
<table>
<?php
//validate authentication 
$username = $session->user_name;
$query = mysql_query("select forbid from users where username ='$username'");
$result = mysql_fetch_array($query);
if($result['forbid'] == 2){
	$i = 1;
	echo '<table width=100% id="gTable"><tr><th>S.No</th><th>Academic</th><th>Name</th><th>Roll No.</th><th>Type</th><th>Room No</th><th>Feedback</th><th width=180px>Actions</th></tr>
	';
	$query2 = mysql_query("select available_room.hostel, available_room.room_no, student.student_id, student.name, student.reallot, student.recipt, feedback.message, feedback.submission_time, feedback.remark_time, feedback.feedback_id, feedback.remarks, academic.year_of_admn, academic.sem, academic.branch, academic.course from available_room , student, academic, feedback where student.student_id = feedback.student_id and available_room.student_id = feedback.student_id and academic.student_id = feedback.student_id order by feedback.feedback_id desc");
	while($row = mysql_fetch_array($query2)){
		if($row['reallot']==0)
		$reallot='<img height="20" src="../images/fresh.png">';
		else
		$reallot='<img height="20" src="../images/reallot.png">';
		echo '<tr><td colspan=8><hr /></td></tr>
			<tr id="'.$row['feedback_id'].'">
			<td>'.$i.'.</td>
			<td>'. $row['year_of_admn'].', '.$row['sem'].' Sem, '.$row['branch'].', '.$row['course'].'</td>
			<td>'. $row['name'].'</td>
			<td>'.$row['recipt'].'</td>
			<td>'.$reallot.'</td>
			<td>'.$row['hostel'].', '.$row['room_no'].'</td>
			<td>'.$row['message'].'</td>
			<td><a href="javascript:void(0);" onClick="addRemark('.$row['feedback_id'].')">Add Remark</a> | <a href="javascript:void(0);" onClick="addRemark('.$row['feedback_id'].')">Edit Remark</a> | <br><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a> | <a href="javascript:void(0)" onClick="delFeedback('.$row['feedback_id'].');">Delete Feedback</a></td>
			</tr>
			<tr><td colspan=8 id="'.$row['feedback_id'].'a">';
			if($row['remarks'] != ''){
			      echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : <span id="remarks_'.$row['feedback_id'].'">'.$row['remarks'].'</span></font> (last added : '.$row['remark_time'].')';
			}
			echo '</td></tr>
			<tr><td colspan=8 id="'.$row['feedback_id'].'b"></td></tr>';
			$i++;
	
	}
	
}
else{
	echo 'Authentication failed. You do not have required permission to view this page.';
	exit;
}

?>
</table>
<?php include_layout_template('footer.php');
if (isset ($database)) { $database->close_connection(); }
ob_end_flush();

?>
