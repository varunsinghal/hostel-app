<?php
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }
include_layout_template('admin_header.php');
?>

<script type='text/javascript'>
       
       
       function verifyStudent(stuid)
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
	      xmlhttp.open("POST","verify_student_ajax.php",true);
	      xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	      xmlhttp.send("formno="+stuid+"&status=0");
       }
       
       function unVerifyStudent(stuid)
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
	      xmlhttp.open("POST","verify_student_ajax.php",true);
	      xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	      xmlhttp.send("formno="+stuid+"&status=1");
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

<center><h2 style="color:#ccc">Verify Students</h2></center>
<br />

<form action="verify_student.php" method="get" name="main">
       
       Search the student to verify:<br><br>
       <select name="condition">
	      <option value="formno">Form Number</option>
	      <option value="name">Name</option>
	      <option value="presentaddr">Present Adderess</option>
	      <option value="roomno">Room No</option>
	      <option value="phone">Personal Phone of Student</option>
	      <option value="school">School</option>
	      <option value="fathername">Father's Name</option>
       </select>
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
    $search_query2 = $_GET['condition'];
    switch ($search_query2)
    {
	case 'formno' : {
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
	case 'name' : {
	    $table_name = 'student';
	    $search_field = 'name';
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
	case 'presentaddr' : {
	    $table_name = 'present_address';
	    if(isset($_GET['allotted']))
	    {
		$sql = "SELECT available_room.*,".$table_name.".* FROM available_room,".$table_name." WHERE present_add_line LIKE '%$search_query%' AND available_room.student_id = ".$table_name.".student_id UNION SELECT available_room.*,".$table_name.".* FROM available_room,".$table_name." WHERE present_city LIKE '%$search_query%' AND available_room.student_id = ".$table_name.".student_id UNION SELECT available_room.*,".$table_name.".* FROM available_room,".$table_name." WHERE present_state LIKE '%$search_query%' AND available_room.student_id = ".$table_name.".student_id UNION SELECT available_room.*,".$table_name.".* FROM available_room,".$table_name." WHERE present_country LIKE '%$search_query%' AND available_room.student_id = ".$table_name.".student_id UNION SELECT available_room.*,".$table_name.".* FROM available_room,".$table_name." WHERE present_pin LIKE '%$search_query%' AND available_room.student_id = ".$table_name.".student_id UNION SELECT available_room.*,".$table_name.".* FROM available_room,".$table_name." WHERE present_res_phone LIKE '%$search_query%' AND available_room.student_id = ".$table_name.".student_id ";
	    }
	    else
	    {
		$sql = "SELECT ".$table_name.".* FROM ".$table_name." WHERE present_add_line LIKE '%$search_query%' UNION SELECT ".$table_name.".* FROM ".$table_name." WHERE present_city LIKE '%$search_query%' UNION SELECT ".$table_name.".* FROM ".$table_name." WHERE present_state LIKE '%$search_query%' UNION SELECT ".$table_name.".* FROM ".$table_name." WHERE present_country LIKE '%$search_query%' UNION SELECT ".$table_name.".* FROM ".$table_name." WHERE present_pin LIKE '%$search_query%' UNION SELECT ".$table_name.".* FROM ".$table_name." WHERE present_res_phone LIKE '%$search_query%'";
	    }
	    break;
	}
	case 'roomno' : {
	    $table_name = 'available_room';
	    $search_field = 'room_no';
	    if(isset($_GET['allotted']))
	    {
		$sql = "SELECT available_room.*,distance_from_home.*,".$table_name.".* FROM available_room,distance_from_home,".$table_name." WHERE ".$search_field." = '$search_query' AND available_room.student_id = ".$table_name.".student_id AND ".$table_name.".student_id = distance_from_home.student_id ORDER BY distance_from_home.distance DESC";
	    }
	    else
	    {
		$sql = "SELECT distance_from_home.*,".$table_name.".* FROM distance_from_home,".$table_name." WHERE ".$search_field." = '$search_query' AND ".$table_name.".student_id = distance_from_home.student_id ORDER BY distance_from_home.distance DESC";
	    }
	    break;
	}
	case 'phone' : {
	    $table_name = 'student';
	    $search_field = 'personal_phone';
	    if(isset($_GET['allotted']))
	    {
		$sql = "SELECT available_room.*,distance_from_home.*,".$table_name.".* FROM available_room,distance_from_home,".$table_name." WHERE ".$search_field." LIKE '%$search_query%' AND available_room.student_id = ".$table_name.".student_id AND ".$table_name.".student_id = distance_from_home.student_id ORDER BY distance_from_home.distance DESC";
	    }
	    else
	    {
		$sql = "SELECT distance_from_home.*,".$table_name.".* FROM distance_from_home,".$table_name." WHERE ".$search_field." LIKE '%$search_query%' AND ".$table_name.".student_id = distance_from_home.student_id ORDER BY distance_from_home.distance DESC";
	    }
	    break;
	}
	case 'school' : {
	    $table_name = 'student';
	    $search_field = 'school';
	    if(isset($_GET['allotted']))
	    {
		$sql = "SELECT available_room.*,distance_from_home.*,".$table_name.".* FROM available_room,distance_from_home,".$table_name." WHERE ".$search_field." LIKE '%$search_query%' AND available_room.student_id = ".$table_name.".student_id AND ".$table_name.".student_id = distance_from_home.student_id ORDER BY distance_from_home.distance DESC";
	    }
	    else
	    {
		$sql = "SELECT distance_from_home.*,".$table_name.".* FROM distance_from_home,".$table_name." WHERE ".$search_field." LIKE '%$search_query%' AND ".$table_name.".student_id = distance_from_home.student_id ORDER BY distance_from_home.distance DESC";
	    }
	    break;
	}
	case 'fathername' : {
	    $table_name = 'student';
	    $search_field = 'father_name';
	    if(isset($_GET['allotted']))
	    {
		$sql = "SELECT available_room.*,distance_from_home.*,".$table_name.".* FROM available_room,distance_from_home,".$table_name." WHERE ".$search_field." LIKE '%$search_query%' AND available_room.student_id = ".$table_name.".student_id AND ".$table_name.".student_id = distance_from_home.student_id ORDER BY distance_from_home.distance DESC";
	    }
	    else
	    {
		$sql = "SELECT distance_from_home.*,".$table_name.".* FROM distance_from_home,".$table_name." WHERE ".$search_field." LIKE '%$search_query%' AND ".$table_name.".student_id = distance_from_home.student_id ORDER BY distance_from_home.distance DESC";
	    }
	    break;
	}
	default : {
	    echo output_message("Some Error Occoured. Go to home and Try again.");
	    exit;
	}
    }
    echo "Search results for: <b>".$_GET['query']."</b><br /><br />";
    echo '<table width=100%>
    <tr><th>Form No.</th><th>Academics</th><th>Name</th><th>Present Address</th><th>Distance</th><th>Category</th><th>Verified</th><th>Room No</th><th>Actions</th></tr>';

    $result = mysql_query($sql) or die(mysql_error());
    
    
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
	if($reset['reallot']==0)
	$reallot='<img height="20" src="../images/fresh.png">';
	else
	$reallot='<img height="20" src="../images/reallot.png">';
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
	<td><a href="javascript:void(0);" onClick="verifyStudent('.$row['student_id'].')">Verify</a> | <a href="javascript:void(0);" onClick="unVerifyStudent('.$row['student_id'].')">Un-verify</a><br /><a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a><br /><a href="javascript:void(0);" onClick="addRemark('.$row['student_id'].')">Add Remark</a></td>
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

<?php include_layout_template('footer.php'); ?>
