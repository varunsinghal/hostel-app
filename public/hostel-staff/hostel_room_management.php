<?php
       ob_start();
       require_once("../../includes/initialize.php");
       if(!$session->is_logged_in()){ redirect_to("login.php"); }
       include_layout_template('admin_header.php');
?>

<script type="text/javascript">
       function popitup(url)
       {
	      newwindow=window.open(url,'name','height=500,width=600');
	      if (window.focus) {newwindow.focus()}
	      return false;
       }
       
       function delRoomByname(room,hostel)
       {
	      var r=confirm("Are you sure you want to delete the room?");
	      if(r==true){
		     document.getElementById(hostel+room).innerHTML="<tr><td colspan=5><center><img src='../images/ajax-loader_b.gif' height=24 /></center></td></tr>'";
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
				   document.getElementById(hostel+room).innerHTML=xmlhttp.responseText;
			    }
		     }
		     xmlhttp.open("POST","delete_room_ajax.php",true);
		     xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		     xmlhttp.send("room="+room+"&hostel="+hostel);
	      }
       }


</script>

<?php


echo "<center><h1 style='color:#ccc;'>Hostel Room Management</h1></center><br /><br />";

echo '<table width=100%><tr><td style="text-align:right;"><h3><a href="add_room_details.php" target="_blank" onclick="return popitup(&#39;add_room_details.php&#39;)">+ Add Rooms</a></h3></td></tr></table>';


$sql = "SELECT DISTINCT hostel FROM `available_room`";
$output = mysql_query($sql) or die(mysql_error());
while($row = mysql_fetch_array($output))
{
        $hostel = $row['hostel'];
        $query2 = "SELECT DISTINCT room_no FROM available_room WHERE hostel='$hostel' ORDER BY room_no ASC";
	$result1 = mysql_query($query2) or die(mysql_error());
	echo "<h2 style='color:#8AC4FF;'>".$hostel." | Count - ".mysql_num_rows($result1)."</h2>";
	echo '<table width=100%>
	<tr><th>Room No.</th><th>Hostel</th><th>Room Capacity</th><th>Alloted</th><th>Actions</th></tr>';
	while($row1 = mysql_fetch_array($result1))
	{
          $room_no = $row1['room_no'];
          $query3 = "SELECT * FROM available_room WHERE hostel='$hostel' AND room_no='$room_no' LIMIT 1";
          $result2 = mysql_query($query3) or die(mysql_error());
          $row2 = mysql_fetch_array($result2);
          echo '<tr><td colspan=5><hr /></td></tr>
          <tr id="'.$hostel.$room_no.'">
          <td>'. $row2['room_no'].'</td>
          <td>'. $row2['hostel'].'</td>
          <td>'. $row2['room_capacity'].'</td>
          <td>';
          if($row2['alloted'] == 1)
          {
            echo '<img src="../images/accept.png" alt="verified" name="verified" />';
          }
          else
          {
            echo '<img src="../images/exclamation.png" alt="not verified" name="not verified" />';

          }
          echo'</td>
          <td><a href="edit_room_details.php?room='.$row2['room_no'].'&hostel='.$row2['room_no'].'" target="_blank" onclick="return popitup(&#39;edit_room_details.php?room='. $row2['room_no'].'&hostel='.$row2['hostel'].'&#39;)">Edit Details</a> | <a href="javascript:void(0);" onClick="delRoomByname(&#39;'.$room_no.'&#39;,&#39;'.$hostel.'&#39;);">Delete Room</a></td>
          </tr>
          <tr><td colspan=5 id="'.$hostel.$room_no.'a">';
          if($row2['remarks'] != ""){
            echo '<font color="brown"><img src="../images/information.png" style="vertical-align: middle;" />&nbsp;Remark : '.$row2['remarks'].'</font>';
          }
          echo '</td></tr>
          <tr><td colspan=5 id="'.$hostel.$room_no.'b"></td></tr>';
        }
        echo "</table><br />";
}


?>


<?php include_layout_template('footer.php');
if(isset($database)) { $database->close_connection(); }
ob_end_flush();
?>