<?php
       ob_start();
       require_once("../../includes/initialize.php");
       if(!$session->is_logged_in()){ redirect_to("login.php"); }
?>

<?php

$filter = $_REQUEST['mode'];

$heading = '';
$natural_joins = '';
$conditions = '';

switch($filter)
{
  case 'seeall' : {
    $heading = 'All Student - Distance Wise';
    $natural_joins = 'NATURAL JOIN distance_from_home NATURAL JOIN docu_submission';
    $conditions = 'student.student_id = distance_from_home.student_id AND docu_submission.document=1';
    display_after_filtering($heading, $natural_joins, $conditions);
    break;
  }
  case 'ug' : {
    $heading = 'All Under Graduate Students - Distance Wise';
    $natural_joins = 'NATURAL JOIN distance_from_home NATURAL JOIN docu_submission NATURAL JOIN academic';
    $conditions = 'student.student_id = distance_from_home.student_id AND docu_submission.document=1 AND academic.course="UG"';
    display_after_filtering($heading, $natural_joins, $conditions);
    break;
  }
  case 'pg' : {
    $heading = 'All Post Graduate Students - Distance Wise';
    $natural_joins = 'NATURAL JOIN distance_from_home NATURAL JOIN docu_submission NATURAL JOIN academic';
    $conditions = 'student.student_id = distance_from_home.student_id AND docu_submission.document=1 AND academic.course="PG"';
    display_after_filtering($heading, $natural_joins, $conditions);
    break;
  }
  case 'ugboys' : {
    $heading = 'All Under Graduate Boys - Distance Wise';
    $natural_joins = 'NATURAL JOIN distance_from_home NATURAL JOIN docu_submission NATURAL JOIN academic';
    $conditions = 'student.student_id = distance_from_home.student_id AND docu_submission.document=1 AND academic.course="UG" AND student.gender = "male"';
    display_after_filtering($heading, $natural_joins, $conditions);
    break;
  }
  case 'uggirls' : {
    $heading = 'All Under Graduate Girls - Distance Wise';
    $natural_joins = 'NATURAL JOIN distance_from_home NATURAL JOIN docu_submission NATURAL JOIN academic';
    $conditions = 'student.student_id = distance_from_home.student_id AND docu_submission.document=1 AND academic.course="UG" AND student.gender = "female"';
    display_after_filtering($heading, $natural_joins, $conditions);
    break;
  }
  case 'pgboys' : {
    $heading = 'All Post Graduate Boys - Distance Wise';
    $natural_joins = 'NATURAL JOIN distance_from_home NATURAL JOIN docu_submission NATURAL JOIN academic';
    $conditions = 'student.student_id = distance_from_home.student_id AND docu_submission.document=1 AND academic.course="PG" AND student.gender = "male"';
    display_after_filtering($heading, $natural_joins, $conditions);
    break;
  }
  case 'pggirls' : {
    $heading = 'All Post Graduate Girls - Distance Wise';
    $natural_joins = 'NATURAL JOIN distance_from_home NATURAL JOIN docu_submission NATURAL JOIN academic';
    $conditions = 'student.student_id = distance_from_home.student_id AND docu_submission.document=1 AND academic.course="PG" AND student.gender = "female"';
    display_after_filtering($heading, $natural_joins, $conditions);
    break;
  }
  case 'ugboysyear' : {
    for($i = date("Y", time())-5;$i< date("Y", time())+1; ++$i)
    {
      $heading = 'All Under Graduate Boys - Year of Admission : '.$i;
      $natural_joins = 'NATURAL JOIN distance_from_home NATURAL JOIN docu_submission NATURAL JOIN academic';
      $conditions = 'student.student_id = distance_from_home.student_id AND docu_submission.document=1 AND academic.course="UG" AND student.gender = "male" AND academic.year_of_admn ='.$i;
      display_after_filtering($heading, $natural_joins, $conditions);
    }
    break;
  }
  case 'uggirlsyear' : {
    for($i = date("Y", time())-5;$i< date("Y", time())+1; ++$i)
    {
      $heading = 'All Under Graduate Girls - Year of Admission : '.$i;
      $natural_joins = 'NATURAL JOIN distance_from_home NATURAL JOIN docu_submission NATURAL JOIN academic';
      $conditions = 'student.student_id = distance_from_home.student_id AND docu_submission.document=1 AND academic.course="UG" AND student.gender = "female" AND academic.year_of_admn ='.$i;
      display_after_filtering($heading, $natural_joins, $conditions);
    }
    break;
  }
  case 'pgboysyear' : {
    for($i = date("Y", time())-5;$i< date("Y", time())+1; ++$i)
    {
      $heading = 'All Post Graduate Boys - Year of Admission : '.$i;
      $natural_joins = 'NATURAL JOIN distance_from_home NATURAL JOIN docu_submission NATURAL JOIN academic';
      $conditions = 'student.student_id = distance_from_home.student_id AND docu_submission.document=1 AND academic.course="PG" AND student.gender = "male" AND academic.year_of_admn ='.$i;
      display_after_filtering($heading, $natural_joins, $conditions);
    }
    break;
  }
  case 'pggirlsyear' : {
    for($i = date("Y", time())-5;$i< date("Y", time())+1; ++$i)
    {
      $heading = 'All Post Graduate Girls - Year of Admission : '.$i;
      $natural_joins = 'NATURAL JOIN distance_from_home NATURAL JOIN docu_submission NATURAL JOIN academic';
      $conditions = 'student.student_id = distance_from_home.student_id AND docu_submission.document=1 AND academic.course="PG" AND student.gender = "female" AND academic.year_of_admn ='.$i;
      display_after_filtering($heading, $natural_joins, $conditions);
    }
    break;
  }
  case 'ugboysyearcateg' : {
    for($i = date("Y", time())-5;$i< date("Y", time())+1; ++$i)
    {
      echo '<h2 style="color:#8AC4FF">Under Graduate Boys Year of Admission - '.$i.'</h2>';
      $sql_query = "SELECT * FROM category ORDER BY category ASC";
      $result = mysql_query($sql_query) or die(mysql_error());
      while($categ = mysql_fetch_array($result)){
        $current_category = $categ['category'];
        $heading = 'Category - '.$current_category;
        $natural_joins = 'NATURAL JOIN distance_from_home NATURAL JOIN docu_submission NATURAL JOIN academic';
        $conditions = 'student.student_id = distance_from_home.student_id AND docu_submission.document=1 AND academic.course="UG" AND student.gender = "male" AND academic.year_of_admn ='.$i.' AND student.category_code="'.$current_category.'"';
        display_after_filtering($heading, $natural_joins, $conditions);
      }
      echo '<br /><br />';
    }
    break;
  }
  case 'uggirlsyearcateg' : {
    for($i = date("Y", time())-5;$i< date("Y", time())+1; ++$i)
    {
      echo '<h2 style="color:#8AC4FF">Under Graduate Girls Year of Admission - '.$i.'</h2>';
      $sql_query = "SELECT * FROM category ORDER BY category ASC";
      $result = mysql_query($sql_query) or die(mysql_error());
      while($categ = mysql_fetch_array($result)){
        $current_category = $categ['category'];
        $heading = 'Category - '.$current_category;
        $natural_joins = 'NATURAL JOIN distance_from_home NATURAL JOIN docu_submission NATURAL JOIN academic';
        $conditions = 'student.student_id = distance_from_home.student_id AND docu_submission.document=1 AND academic.course="UG" AND student.gender = "female" AND academic.year_of_admn ='.$i.' AND student.category_code="'.$current_category.'"';
        display_after_filtering($heading, $natural_joins, $conditions);
      }
      echo '<br /><br />';
    }
    break;
  }
  case 'pgboysyearcateg' : {
    for($i = date("Y", time())-5;$i< date("Y", time())+1; ++$i)
    {
      echo '<h2 style="color:#8AC4FF">Post Graduate Boys Year of Admission - '.$i.'</h2>';
      $sql_query = "SELECT * FROM category ORDER BY category ASC";
      $result = mysql_query($sql_query) or die(mysql_error());
      while($categ = mysql_fetch_array($result)){
        $current_category = $categ['category'];
        $heading = 'Category - '.$current_category;
        $natural_joins = 'NATURAL JOIN distance_from_home NATURAL JOIN docu_submission NATURAL JOIN academic';
        $conditions = 'student.student_id = distance_from_home.student_id AND docu_submission.document=1 AND academic.course="PG" AND student.gender = "male" AND academic.year_of_admn ='.$i.' AND student.category_code="'.$current_category.'"';
        display_after_filtering($heading, $natural_joins, $conditions);
      }
      echo '<br /><br />';
    }
    break;
  }
  case 'pggirlsyearcateg' : {
    for($i = date("Y", time())-5;$i< date("Y", time())+1; ++$i)
    {
      echo '<h2 style="color:#8AC4FF">Post Graduate Girls Year of Admission - '.$i.'</h2>';
      $sql_query = "SELECT * FROM category ORDER BY category ASC";
      $result = mysql_query($sql_query) or die(mysql_error());
      while($categ = mysql_fetch_array($result)){
        $current_category = $categ['category'];
        $heading = 'Category - '.$current_category;
        $natural_joins = 'NATURAL JOIN distance_from_home NATURAL JOIN docu_submission NATURAL JOIN academic';
        $conditions = 'student.student_id = distance_from_home.student_id AND docu_submission.document=1 AND academic.course="PG" AND student.gender = "female" AND academic.year_of_admn ='.$i.' AND student.category_code="'.$current_category.'"';
        display_after_filtering($heading, $natural_joins, $conditions);
      }
      echo '<br /><br />';
    }
    break;
  }
  case 'ugboysyearcategback' : {
    for($i = date("Y", time())-5;$i< date("Y", time())+1; ++$i)
    {
      echo '<h2 style="color:#8AC4FF">Under Graduate Boys Year of Admission - '.$i.'</h2>';
      $sql_query = "SELECT * FROM category ORDER BY category ASC";
      $result = mysql_query($sql_query) or die(mysql_error());
      while($categ = mysql_fetch_array($result)){
        $current_category = $categ['category'];
        if(!isset($_REQUEST['i']))
        {
          echo "Improper Request of data. Please try again.";
          break;
        }
        $no_of_back = $_REQUEST['i'];
        $heading = 'Category - '.$current_category.' Backs - '.$no_of_back;
        $natural_joins = 'NATURAL JOIN distance_from_home NATURAL JOIN docu_submission NATURAL JOIN academic';
        $conditions = 'student.student_id = distance_from_home.student_id AND docu_submission.document=1 AND academic.course="UG" AND student.gender = "male" AND academic.year_of_admn ='.$i.' AND student.category_code="'.$current_category.'" AND student.last_year_details LIKE "%Backs : '.$no_of_back.'%"';
        display_after_filtering($heading, $natural_joins, $conditions);
      }
    }
    break;
  }
  case 'uggirlsyearcategback' : {
    for($i = date("Y", time())-5;$i< date("Y", time())+1; ++$i)
    {
      echo '<h2 style="color:#8AC4FF">Under Graduate Girls Year of Admission - '.$i.'</h2>';
      $sql_query = "SELECT * FROM category ORDER BY category ASC";
      $result = mysql_query($sql_query) or die(mysql_error());
      while($categ = mysql_fetch_array($result)){
        $current_category = $categ['category'];
        if(!isset($_REQUEST['i']))
        {
          echo "Improper Request of data. Tlease try again.";
          break;
        }
        $no_of_back = $_REQUEST['i'];
        $heading = 'Category - '.$current_category.' Backs - '.$no_of_back;
        $natural_joins = 'NATURAL JOIN distance_from_home NATURAL JOIN docu_submission NATURAL JOIN academic';
        $conditions = 'student.student_id = distance_from_home.student_id AND docu_submission.document=1 AND academic.course="UG" AND student.gender = "female" AND academic.year_of_admn ='.$i.' AND student.category_code="'.$current_category.'" AND student.last_year_details LIKE "%Backs : '.$no_of_back.'%"';
        display_after_filtering($heading, $natural_joins, $conditions);
      }
    }
    break;
  }
  case 'pgboysyearcategback' : {
    for($i = date("Y", time())-5;$i< date("Y", time())+1; ++$i)
    {
      echo '<h2 style="color:#8AC4FF">Post Graduate Boys Year of Admission - '.$i.'</h2>';
      $sql_query = "SELECT * FROM category ORDER BY category ASC";
      $result = mysql_query($sql_query) or die(mysql_error());
      while($categ = mysql_fetch_array($result)){
        $current_category = $categ['category'];
        if(!isset($_REQUEST['i']))
        {
          echo "Improper Request of data. Tlease try again.";
          break;
        }
        $no_of_back = $_REQUEST['i'];
        $heading = 'Category - '.$current_category.' Backs - '.$no_of_back;
        $natural_joins = 'NATURAL JOIN distance_from_home NATURAL JOIN docu_submission NATURAL JOIN academic';
        $conditions = 'student.student_id = distance_from_home.student_id AND docu_submission.document=1 AND academic.course="PG" AND student.gender = "male" AND academic.year_of_admn ='.$i.' AND student.category_code="'.$current_category.'" AND student.last_year_details LIKE "%Backs : '.$no_of_back.'%"';
        display_after_filtering($heading, $natural_joins, $conditions);
      }
    }
    break;
  }
  case 'pggirlsyearcategback' : {
    for($i = date("Y", time())-5;$i< date("Y", time())+1; ++$i)
    {
      echo '<h2 style="color:#8AC4FF">Post Graduate Girls Year of Admission - '.$i.'</h2>';
      $sql_query = "SELECT * FROM category ORDER BY category ASC";
      $result = mysql_query($sql_query) or die(mysql_error());
      while($categ = mysql_fetch_array($result)){
        $current_category = $categ['category'];
        if(!isset($_REQUEST['i']))
        {
          echo "Improper Request of data. Tlease try again.";
          break;
        }
        $no_of_back = $_REQUEST['i'];
        $heading = 'Category - '.$current_category.' Backs - '.$no_of_back;
        $natural_joins = 'NATURAL JOIN distance_from_home NATURAL JOIN docu_submission NATURAL JOIN academic';
        $conditions = 'student.student_id = distance_from_home.student_id AND docu_submission.document=1 AND academic.course="PG" AND student.gender = "female" AND academic.year_of_admn ='.$i.' AND student.category_code="'.$current_category.'" AND student.last_year_details LIKE "%Backs : '.$no_of_back.'%"';
        display_after_filtering($heading, $natural_joins, $conditions);
      }
    }
    break;
  }
  default : {
    echo "some error occoured";
  }
}

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