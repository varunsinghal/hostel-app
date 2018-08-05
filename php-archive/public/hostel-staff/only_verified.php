<?php
       require_once("../../includes/initialize.php");
       if(!$session->is_logged_in()){ redirect_to("login.php"); }
       include_layout_template('admin_header.php');
?>
<script type='text/javascript'>
       function showUser(str)
       {
	      document.getElementById("txtHint").innerHTML="<center><img src='../images/ajax-loader_b.gif' height=24 /></center>";
	      if (str==""){
		     document.getElementById("txtHint").innerHTML="";
		     return;
	      }
       	      if (window.XMLHttpRequest){
		     // code for IE7+, Firefox, Chrome, Opera, Safari
		     xmlhttp=new XMLHttpRequest();
              }
	      else {
		     // code for IE6, IE5
		     xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	      }
	      xmlhttp.onreadystatechange=function()
	      {
		     if (xmlhttp.readyState==4 && xmlhttp.status==200)
		     {
			    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
		     }
	      }
	      xmlhttp.open("GET","display_filter_verified.php?q="+str,true);
	      xmlhttp.send();
       }
       
       function delStudent(stuid)
       {
	      var r=confirm("Are you sure you want to delete the details of this student from database?");
	      if(r==true){
		     document.getElementById(stuid).innerHTML="<tr><td colspan=7><center><img src='../images/ajax-loader_b.gif' height=24 /></center></td></tr>'";
		     if (stuid=="")
		     {
			    document.getElementById(stuid).innerHTML="error";
			    return;
		     }
		     if (window.XMLHttpRequest)
		     {// code for IE7+, Firefox, Chrome, Opera, Safari
			    xmlhttp=new XMLHttpRequest();
		     }
		     else
		     {// code for IE6, IE5
			    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		     }
		     xmlhttp.onreadystatechange=function()
		     {
			    if (xmlhttp.readyState==4 && xmlhttp.status==200)
			    {
				   document.getElementById(stuid).innerHTML=xmlhttp.responseText;
				   document.getElementById(stuid+'a').innerHTML="";
			    }
		     }
		     xmlhttp.open("POST","delete_student.php",true);
		     xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		     xmlhttp.send("q="+stuid);
	      }
       }
       
       function getAlotData(stuid)
       {
	      document.getElementById(stuid+'b').innerHTML="<center><img src='../images/ajax-loader_b.gif' height=24 /></center>'";
	      if (stuid=="")
	      {
		     document.getElementById(stuid+'b').innerHTML="error";
		     return;
	      }
	      if (window.XMLHttpRequest)
	      {// code for IE7+, Firefox, Chrome, Opera, Safari
		     xmlhttp=new XMLHttpRequest();
	      }
	      else
	      {// code for IE6, IE5
		     xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	      }
	      xmlhttp.onreadystatechange=function()
	      {
		     if (xmlhttp.readyState==4 && xmlhttp.status==200)
		     {
			    document.getElementById(stuid+'b').innerHTML=xmlhttp.responseText;
		     }
	      }
	      xmlhttp.open("GET","get_rooms_available.php?id="+stuid,true);
	      xmlhttp.send();
       }
       
       function getAlotRooms(stuid, hos)
       {
	      document.getElementById(stuid+'b').innerHTML="<center><img src='../images/ajax-loader_b.gif' height=24 /></center>'";
	      if (stuid=="")
	      {
		     document.getElementById(stuid+'b').innerHTML="error";
		     return;
	      }
	      if (window.XMLHttpRequest)
	      {// code for IE7+, Firefox, Chrome, Opera, Safari
		     xmlhttp=new XMLHttpRequest();
	      }
	      else
	      {// code for IE6, IE5
		     xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	      }
	      xmlhttp.onreadystatechange=function()
	      {
		     if (xmlhttp.readyState==4 && xmlhttp.status==200)
		     {
			    document.getElementById(stuid+'b').innerHTML=xmlhttp.responseText;
		     }
	      }
	      xmlhttp.open("GET","get_rooms_available.php?id="+stuid+"&hos="+hos,true);
	      xmlhttp.send();
       }
       
       function finalAllotRoom(stuid, hos, room_no)
       {
	      document.getElementById(stuid+'b').innerHTML="<center><img src='../images/ajax-loader_b.gif' height=24 /></center>'";
	      if (stuid=="")
	      {
		     document.getElementById(stuid+'b').innerHTML="error";
		     return;
	      }
	      if (window.XMLHttpRequest)
	      {// code for IE7+, Firefox, Chrome, Opera, Safari
		     xmlhttp=new XMLHttpRequest();
	      }
	      else
	      {// code for IE6, IE5
		     xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	      }
	      xmlhttp.onreadystatechange=function()
	      {
		     if (xmlhttp.readyState==4 && xmlhttp.status==200)
		     {
			    document.getElementById(stuid+'b').innerHTML=xmlhttp.responseText;
		     }
	      }
	      xmlhttp.open("POST","allot_final_ajax.php",true);
	      xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	      xmlhttp.send("form_no="+stuid+"&room_no="+room_no+"&hostel="+hos);
       }
       
       function delAllotment(stuid)
       {
	      var r=confirm("Are you sure you want to cancel the allotment of this student?");
	      if(r==true){
		     document.getElementById(stuid+'b').innerHTML="<tr><td colspan=7><center><img src='../images/ajax-loader_b.gif' height=24 /></center></td></tr>'";
		     if (stuid=="")
		     {
			    document.getElementById(stuid+'b').innerHTML="error";
			    return;
		     }
		     if (window.XMLHttpRequest)
		     {// code for IE7+, Firefox, Chrome, Opera, Safari
			    xmlhttp=new XMLHttpRequest();
		     }
		     else
		     {// code for IE6, IE5
			    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		     }
		     xmlhttp.onreadystatechange=function()
		     {
			    if (xmlhttp.readyState==4 && xmlhttp.status==200)
			    {
				   document.getElementById(stuid+'b').innerHTML=xmlhttp.responseText;
			    }
		     }
		     xmlhttp.open("POST","cancel_allot_ajax.php",true);
		     xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		     xmlhttp.send("form_no="+stuid);
	      }
       }
       
       function addRemark(stuid)
       {
	      if(document.getElementById('remarks_'+stuid) != null)
	      {
		     var temp = '<font color="blue">Edit Remark :</font> <input type="text" id="remarkfield_'+stuid+'" value="'+document.getElementById('remarks_'+stuid).innerHTML+'" size="100" /> <a href="javascript:void(0);" onClick="submitRemark('+stuid+')">Submit</a>';
		     document.getElementById(stuid+'a').innerHTML=temp;
	      }
	      else
	      {
		     var temp = '<font color="blue">Edit Remark :</font> <input type="text" id="remarkfield_'+stuid+'" value="" size="100" /> <a href="javascript:void(0);" onClick="submitRemark('+stuid+')">Submit</a>';
		     document.getElementById(stuid+'a').innerHTML=temp;
	      }
       }
       
       function submitRemark(stuid)
       {
	      var remark_rec = document.getElementById('remarkfield_'+stuid).value;
	      
	      document.getElementById(stuid+'a').innerHTML="<center><img src='../images/ajax-loader_b.gif' height=24 /></center>'";
	      if (stuid=="")
	      {
		     document.getElementById(stuid+'a').innerHTML="error";
		     return;
	      }
	      if (window.XMLHttpRequest)
	      {// code for IE7+, Firefox, Chrome, Opera, Safari
		     xmlhttp=new XMLHttpRequest();
	      }
	      else
	      {// code for IE6, IE5
		     xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	      }
	      xmlhttp.onreadystatechange=function()
	      {
		     if (xmlhttp.readyState==4 && xmlhttp.status==200)
		     {
			    document.getElementById(stuid+'a').innerHTML=xmlhttp.responseText;
		     }
	      }
	      xmlhttp.open("POST","add_remark.php",true);
	      xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	      xmlhttp.send("form_no="+stuid+"&remark_rec="+remark_rec);
       }
       
       function popitup(url)
       {
	      newwindow=window.open(url,'name','height=500,width=600');
	      if (window.focus) {newwindow.focus()}
	      return false;
       }

</script>

<form action="#" method="post" name="main">
       <center><h2 style="color:#ccc">See All Verified Applications</h2></center>
       <br />
       Choose the filter Below:<br><br>
       <select name="form_no" onchange="showUser(this.value)">
	      <option value="showall">Show All - Distance Wise</option>
	      <option value="semester">Filter By Year</option>
	      <option value="region">Filter By Region(Delhi or Outside)</option>
	      <option value="category">Filter By Category</option>
	      <option value="gender">Filter By Gender(girls or boys)</option>
	      <option value="yearandcategory">Filter By Year and Category</option>
       </select>
</form>
<br><br>
<div id="txtHint">
<?php

$con = mysql_connect(DB_SERVER,DB_USER,DB_PASS);
if (!$con)
{
       die('Could not connect: ' . mysql_error());
}
mysql_select_db(DB_NAME, $con);

echo'<h2 style="color:#ccc">Students - Distancewise Descending Order</h2>';
echo '<table width=100%>
<tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';
$query = "SELECT * FROM student NATURAL JOIN distance_from_home NATURAL JOIN docu_submission WHERE student.student_id = distance_from_home.student_id AND docu_submission.document=1 ORDER BY distance_from_home.distance DESC";
$result = mysql_query($query,$con) or die(mysql_error());

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
echo "</table>";
?>
</div>

<?php include_layout_template('footer.php'); ?>