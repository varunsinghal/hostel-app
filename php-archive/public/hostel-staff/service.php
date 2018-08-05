<?php
       require_once("../../includes/initialize.php");
       if(!$session->is_logged_in()){ redirect_to("login.php"); }
       include_layout_template('admin_header.php');
       ini_set('max_execution_time', 1200); //1200 seconds = 20 minutes
?>

<script type="text/javascript">
function delStudent(stuid)
       {
	      var r=confirm("Are you sure you want to delete the details of this student from database?");
	      if(r==true){
		     document.getElementById('a'+stuid).innerHTML="<table><tr><td colspan=7><center><img src='../images/ajax-loader_b.gif' height=24 /></center></td></tr></table>'";
		     if (stuid=="")
		     {
			    document.getElementById('a'+stuid).innerHTML="error";
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
				   document.getElementById('a'+stuid).innerHTML='<table>'+xmlhttp.responseText+'</table>';
			    }
		     }
		     xmlhttp.open("POST","delete_student.php",true);
		     xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		     xmlhttp.send("q="+stuid);
	      }
       }
       
       function delAllotment(stuid)
       {
	      var r=confirm("Are you sure you want to cancel the allotment of this student?");
	      if(r==true){
		     document.getElementById('b'+stuid).innerHTML="<tr><td colspan=7><center><img src='../images/ajax-loader_b.gif' height=24 /></center></td></tr>'";
		     if (stuid=="")
		     {
			    document.getElementById('b'+stuid).innerHTML="error";
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
				   document.getElementById('b'+stuid).innerHTML=xmlhttp.responseText;
			    }
		     }
		     xmlhttp.open("POST","cancel_allot_ajax.php",true);
		     xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		     xmlhttp.send("form_no="+stuid);
	      }
       }
       
       function delRoom(stuid)
       {
	      var r=confirm("Are you sure you want to delete the room?");
	      if(r==true){
		     document.getElementById('c'+stuid).innerHTML="<tr><td colspan=7><center><img src='../images/ajax-loader_b.gif' height=24 /></center></td></tr>'";
		     if (stuid=="")
		     {
			    document.getElementById('c'+stuid).innerHTML="error";
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
				   document.getElementById('c'+stuid).innerHTML=xmlhttp.responseText;
			    }
		     }
		     xmlhttp.open("POST","delete_room_ajax.php",true);
		     xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		     xmlhttp.send("room_id="+stuid);
	      }
       }
       
       
       function deallotRoomMarked(stuid)
       {
	      var r=confirm("Confirm?");
	      if(r==true){
		     document.getElementById('d'+stuid).innerHTML="<center><img src='../images/ajax-loader_b.gif' height=24 /></center>'";
		     if (stuid=="")
		     {
			    document.getElementById('d'+stuid).innerHTML="error";
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
				   document.getElementById('d'+stuid).innerHTML=xmlhttp.responseText;
			    }
		     }
		     xmlhttp.open("POST","allot_deallot_flag_ajax.php",true);
		     xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		     xmlhttp.send("room_id="+stuid+"&to_do=1");
	      }
       }
       
       function allotRoomMarked(stuid)
       {
	      var r=confirm("Confirm?");
	      if(r==true){
		     document.getElementById('d'+stuid).innerHTML="<tr><td colspan=7><center><img src='../images/ajax-loader_b.gif' height=24 /></center></td></tr>'";
		     if (stuid=="")
		     {
			    document.getElementById('d'+stuid).innerHTML="error";
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
				   document.getElementById('d'+stuid).innerHTML=xmlhttp.responseText;
			    }
		     }
		     xmlhttp.open("POST","allot_deallot_flag_ajax.php",true);
		     xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		     xmlhttp.send("room_id="+stuid+"&to_do=2");
	      }
       }
       
       function popitup(url)
       {
	      newwindow=window.open(url,'name','height=500,width=600');
	      if (window.focus) {newwindow.focus()}
	      return false;
       }
</script>

<?php
$stu_table_names = array("student", "academic", "distance_from_home", "docu_submission", "permanent_address", "present_address");
$hos_table_names = array("student", "academic", "distance_from_home", "docu_submission", "permanent_address", "present_address");
$stu_id_array = array();
$hos_id_array = array();
$flag = 0;

echo '<center><h2 style="color:#ccc">Servicing Report</h2></center><br /><br />';

echo '<hr />';
echo '<center><h2>Service Report - Online Hostel Management Software</h2>Delhi Technological University, Shahbad Daulatpur, Main Bawana Road, Delhi - 42, India</center><hr />';
echo '<br />Date of Servicing : <span style="color: #DB3700;">'.date("d.m.Y").'</span>';
echo '<br />';
echo '<br />Servicing Request by User: <span style="color: #DB3700;">'.$session->user_name.'</span>';
echo '<br /><br /><h3>Modules Checked</h3>';
echo '1. Student Information Synchronization<br /><br />';
echo '2. Hostel Room Synchronisation<br /><br />';
echo '3. Student - Hostel Synchronisation<br /><br />';
echo '<h3>Errors</h3>';

foreach($stu_table_names as $table_name)

{
       $query = "SELECT * FROM ".$table_name;
       $result = mysql_query($query) or die(mysql_error());
       while($reset=mysql_fetch_array($result))
       { 
	      $id = $reset['student_id'];
	      $query2 = "SELECT * FROM student WHERE student_id='$id'";
	      $result1 = mysql_query($query2) or die(mysql_error());
	      $reset=mysql_fetch_array($result1);
	      if(!$reset)
	      {
		     $flag = 1;
		     if(!in_array($id, $stu_id_array))
		     {
			    $stu_id_array[] = $id;
		     }
		     break;
	      }
	      $query3="SELECT * FROM present_address WHERE student_id='$id'";
	      $setaddress=mysql_query($query3) or die(mysql_error());
	      $address=mysql_fetch_array($setaddress);
	      if(!$address)
	      {
		     $flag = 1;
		     if(!in_array($id, $stu_id_array))
		     {
			    $stu_id_array[] = $id;
		     }
		     break;
		     
	      }
	      $query3="SELECT * FROM permanent_address WHERE student_id='$id'";
	      $setaddress=mysql_query($query3) or die(mysql_error());
	      $address=mysql_fetch_array($setaddress);
	      if(!$address)
	      {
		     $flag = 1;
		     if(!in_array($id, $stu_id_array))
		     {
			    $stu_id_array[] = $id;
		     }
		     break;
	      }
	      $query4 = "SELECT * FROM academic WHERE student_id='$id'";
	      $resultof4 = mysql_query($query4) or die(mysql_error());
	      $academic_data = mysql_fetch_array($resultof4);
	      if(!$academic_data)
	      {
		     $flag = 1;
		     if(!in_array($id, $stu_id_array))
		     {
			    $stu_id_array[] = $id;
		     }
		     break;
	      }
	      $query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	      $resultof7=mysql_query($query7) or die(mysql_error());
	      $distancedata=mysql_fetch_array($resultof7);
	      if(!$distancedata)
	      {
		     $flag = 1;
		     if(!in_array($id, $stu_id_array))
		     {
			    $stu_id_array[] = $id;
		     }
		     break;
	      }
	      $query8="SELECT * FROM docu_submission WHERE student_id = '".$id."' LIMIT 1";
	      $resultof8=mysql_query($query8) or die(mysql_error());
	      $verifydata=mysql_fetch_array($resultof8);
	      if(!$verifydata)
	      {
		     $flag = 1;
		     if(!in_array($id, $stu_id_array))
		     {
			    $stu_id_array[] = $id;
		     }
		     break;
	      }
       }

}



echo '<small style="color: #0033CC;">Entry of students with following form numbers are creating serious mis match in database and needs to be deleted soon</small><br /><br />';

if($flag == 1)
{
       foreach($stu_id_array as $node)
       {
	      echo '<div id="a'.$node.'">Form ID - '.$node.' | <a href="view.php?page='.$node.'" onClick="return popitup(&#39;view.php?page='.$node.'&#39;)">View Details</a> | <a href="javascript:void(0);" onClick="delStudent('.$node.');">Delete</a></div>';
       }
}
else
{
       echo '<span style="color: green;"><b>No Error Reported</b></span><br /><br />';
}

echo '<small style="color: #0033CC;">Entry of following hostel rooms are creating serious mis match in database and needs to be attended soon</small><br /><br />';


unset($stu_id_array);

$query = "SELECT * FROM allotment_details";
$result = mysql_query($query) or die(mysql_error());
while($reset=mysql_fetch_array($result))
{
       $id = $reset['student_id'];
       $room_id = $reset['room_id'];
       $query2 = "SELECT * FROM student WHERE student_id='$id'";
       $result1 = mysql_query($query2) or die(mysql_error());
       $reset1=mysql_fetch_array($result1);
       if(!$reset1)
       {
	      echo '<div id="b'.$id.'">Student Form ID - '.$id.', Details : '.$reset['hostel_name'].' '.$reset['room_no'].' | <a href="javascript:void(0);" onClick="delAllotment('.$id.');">Cancel Allotment</a> (Error : Student does not exist)</div>';
	      $flag = '2';
       }
       $query2 = "SELECT * FROM available_room WHERE id='$room_id'";
       $result1 = mysql_query($query2) or die(mysql_error());
       $reset1=mysql_fetch_array($result1);
       if(!$reset1)
       {
	      echo '<div id="c'.$room_id.'">Room ID - '.$room_id.', Details : '.$reset['hostel_name'].' '.$reset['room_no'].' | <a href="javascript:void(0);" onClick="delRoom('.$room_id.');">Delete Room</a> (Error : Room entry mismatch)</div>';
	      $flag = '2';
       }
       else if (($reset['room_no'] != $reset1['room_no']) || ($reset['hostel_name'] != $reset1['hostel']))
       {
	      echo '<div id="c'.$room_id.'">Room ID - '.$room_id.', Details : '.$reset['hostel_name'].' '.$reset['room_no'].' | <a href="javascript:void(0);" onClick="delRoom('.$room_id.');">Delete Room</a> (Error : Room entry mismatch)</div>';
	      $flag = '2';
       }
       else if ($reset1['alloted'] != 1)
       {
	      echo '<div id="c'.$room_id.'">Room ID - '.$room_id.', Details : '.$reset['hostel_name'].' '.$reset['room_no'].' | <a href="javascript:void(0);" onClick="allotRoomMarked('.$room_id.');">Mark as Alloted</a> (Error : Alloted room marked as Unalloted)</div>';
	      $flag = '2';
       }
}


$query = "SELECT * FROM available_room";
$result = mysql_query($query) or die(mysql_error());
while($reset=mysql_fetch_array($result))
{
       $id = $reset['id'];
       $query2 = "SELECT * FROM allotment_details WHERE room_id='$id'";
       $result1 = mysql_query($query2) or die(mysql_error());
       $reset1=mysql_fetch_array($result1);
       if(!$reset1)
       {
	      if($reset['alloted'] != 0)
	      {
		     echo '<div id="d'.$id.'">Room ID - '.$id.', Details : '.$reset['hostel'].' '.$reset['room_no'].' | <a href="javascript:void(0);" onClick="deallotRoomMarked('.$id.');">De-Allot Room</a> (Error : Unalloted room marked as alloted)</div>';
		     $flag = '2';
	      }
       }
}

$query = "SELECT * FROM available_room";
$result = mysql_query($query) or die(mysql_error());
while($reset=mysql_fetch_array($result))
{
       $id = $reset['id'];
       $room_no = $reset['room_no'];
       $hostel_name = $reset['hostel'];
       $query2 = "SELECT COUNT(*) FROM available_room WHERE room_no='$room_no' AND hostel='$hostel_name'";
       $result1 = mysql_query($query2) or die(mysql_error());
       while($reset1=mysql_fetch_array($result1))
       {
	      if($reset1['COUNT(*)'] != $reset['room_capacity'])
	      {
		     echo '<div id="c'.$id.'">Room ID - '.$id.', Details : '.$reset['hostel'].' '.$reset['room_no'].' | <a href="javascript:void(0);" onClick="delRoom('.$id.');">Delete Room</a> (Error : Room entry mismatch)</div>';
		     $flag = '2';
	      }
       }
}




if($flag == 0)
{
      echo '<span style="color: green;"><b>No Error Reported</b></span>';
      echo '<br /><br /><h3>Final Status</h3>';
      echo '<span style="color: green;"><b>Software is Healthy</b></span>';
      echo '<br /><br /><hr />';
}


if($flag != 0)
{
      echo '<br /><h3>Final Status</h3>';
      echo '<span style="color: red;"><b>Needs Attention!</b></span>';
      echo '<br /><br /><hr />';
}

?>

<?php include_layout_template('footer.php'); ?>
