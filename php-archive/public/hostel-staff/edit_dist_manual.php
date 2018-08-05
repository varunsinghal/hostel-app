<?php

ob_start();
require_once("../../includes/initialize.php");


if(!$session->is_logged_in()){ redirect_to("login.php");}
?>

<?php include_layout_template('admin_header.php'); ?>
<center><h2 style="color:#ccc;">Enter Distance Manually</h2>
<br />
</center>
<a href="distance_calculator_index.php">&larr; Go back</a>
<br /><br />

<br />


<?php

if(!isset($_GET['id'])){
//  redirect_to("error.php");
}

?>


<script type='text/javascript'>

function editDistance(stuid){
  var temp = '<input type="text" id="distancefield_'+stuid+'" value="'+document.getElementById('distancefield_'+stuid).innerHTML+'" />km &nbsp; <a href="javascript:void(0);" onClick="submitDistance('+stuid+')">Submit</a>';
  document.getElementById(stuid+'b').innerHTML = temp;
}

function submitDistance(stuid){
  var distance_rec = document.getElementById('distancefield_'+stuid).value;
  document.getElementById(stuid+'b').innerHTML="<center><img src='../images/ajax-loader_b.gif' height=24 /></center>";
  if (stuid=="")
  {
    document.getElementById(stuid+'b').innerHTML="error";
    return;
  }
  if (window.XMLHttpRequest)
  { 
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  }
  else
  {
    // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      document.getElementById(stuid+'b').innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("POST","add_manualdistance_ajax.php",true);
  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp.send("form_no="+stuid+"&distance_rec="+distance_rec);
}


function popitup(url)
       {
	      newwindow=window.open(url,'name','height=500,width=600');
	      if (window.focus) {newwindow.focus()}
	      return false;
       }


</script>


<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" name="main">
       
       Search By:<br><br>
       <select name="condition">
              <option value="presentaddr">Present Adderess</option>
	      <option value="formno">Form Number</option>
	      <option value="name">Name</option>
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
		$sql = "SELECT allotment_details.*,".$table_name.".* FROM allotment_details,".$table_name." WHERE ".$table_name.".".$search_field." = '$search_query' AND allotment_details.student_id = ".$table_name.".student_id";
	    }
	    break;
	}
	case 'name' : {
	    $table_name = 'student';
	    $search_field = 'name';
	    if(isset($_GET['allotted']))
	    {
		$sql = "SELECT allotment_details.*,distance_from_home.*,".$table_name.".* FROM allotment_details,distance_from_home,".$table_name." WHERE ".$search_field." LIKE '%$search_query%' AND allotment_details.student_id = ".$table_name.".student_id AND ".$table_name.".student_id = distance_from_home.student_id ORDER BY distance_from_home.distance DESC";
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
		$sql = "SELECT allotment_details.*,".$table_name.".* FROM allotment_details,".$table_name." WHERE present_add_line LIKE '%$search_query%' AND allotment_details.student_id = ".$table_name.".student_id UNION SELECT allotment_details.*,".$table_name.".* FROM allotment_details,".$table_name." WHERE present_city LIKE '%$search_query%' AND allotment_details.student_id = ".$table_name.".student_id UNION SELECT allotment_details.*,".$table_name.".* FROM allotment_details,".$table_name." WHERE present_state LIKE '%$search_query%' AND allotment_details.student_id = ".$table_name.".student_id UNION SELECT allotment_details.*,".$table_name.".* FROM allotment_details,".$table_name." WHERE present_country LIKE '%$search_query%' AND allotment_details.student_id = ".$table_name.".student_id UNION SELECT allotment_details.*,".$table_name.".* FROM allotment_details,".$table_name." WHERE present_pin LIKE '%$search_query%' AND allotment_details.student_id = ".$table_name.".student_id UNION SELECT allotment_details.*,".$table_name.".* FROM allotment_details,".$table_name." WHERE present_res_phone LIKE '%$search_query%' AND allotment_details.student_id = ".$table_name.".student_id ";
	    }
	    else
	    {
		$sql = "SELECT ".$table_name.".* FROM ".$table_name." WHERE present_add_line LIKE '%$search_query%' UNION SELECT ".$table_name.".* FROM ".$table_name." WHERE present_city LIKE '%$search_query%' UNION SELECT ".$table_name.".* FROM ".$table_name." WHERE present_state LIKE '%$search_query%' UNION SELECT ".$table_name.".* FROM ".$table_name." WHERE present_country LIKE '%$search_query%' UNION SELECT ".$table_name.".* FROM ".$table_name." WHERE present_pin LIKE '%$search_query%' UNION SELECT ".$table_name.".* FROM ".$table_name." WHERE present_res_phone LIKE '%$search_query%'";
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
    <tr><th>Form No.</th><th>Name</th><th>Present Address</th><th>Distance</th></tr>';

    $result = mysql_query($sql) or die(mysql_error());
    
    
    while($row = mysql_fetch_array($result))
    {
	$id=$row['student_id'];
	$query2 = "SELECT * FROM student WHERE student_id='$id'";
	$result1 = mysql_query($query2) or die(mysql_error());
	$reset=mysql_fetch_array($result1);
	$query3="SELECT * FROM present_address WHERE student_id='$id'";
	$setaddress=mysql_query($query3) or die(mysql_error());
	$address=mysql_fetch_array($setaddress);
	$query7="SELECT * FROM distance_from_home WHERE student_id = '".$id."' LIMIT 1";
	$resultof7=mysql_query($query7) or die(mysql_error());
	$distancedata=mysql_fetch_array($resultof7);
	echo '<tr><td colspan=9><hr /></td></tr>
	<tr id="'.$row['student_id'].'">
	<td>'. $row['student_id'].'</td>
	<td>'. $reset['name'].'</td>
	<td>'. $address['present_add_line'].',&nbsp;'.$address['present_city'].',&nbsp;'.$address['present_state'].'</td>
	<td id="'.$row['student_id'].'b"><span id="distancefield_'.$row['student_id'].'" />'. $distancedata['distance'].'</span>&nbsp;Km&nbsp;&nbsp;<a href="javascript:void(0);" onClick="editDistance('.$row['student_id'].')">Edit</a> | <a href="view.php?page='. $row['student_id'].'" target="_blank" onclick="return popitup(&#39;view.php?page='. $row['student_id'].'&#39;)">View Full Details</a></td>';
    }
    echo '</table> <br />';
}

?>




<?php include_layout_template('admin_footer.php');
if(isset($database)) { $database->close_connection(); }
ob_end_flush();
?>