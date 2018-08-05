<?php

require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }
?>


<?php

$id = $_GET['id'];

$query2 = "SELECT * FROM student WHERE student_id='$id'";
$result1 = mysql_query($query2) or die(mysql_error());
$reset=mysql_fetch_array($result1);

$gender = $reset['gender'];

echo '<center>';
echo '<form method=POST>';
if(!isset($_GET['hos']))
{
    echo 'Select Hostel : <select name="hostel_name" onchange="getAlotRooms('.$id.', this.value)">';
    echo '<option>Select Hostel</option>';
    $query2 = "SELECT DISTINCT hostel FROM available_room WHERE alloted=0 AND gender='$gender'";
    $result1 = mysql_query($query2) or die(mysql_error());
    while($reset=mysql_fetch_array($result1))
    {
	echo '<option value='.$reset['hostel'].'>'.$reset['hostel'].'</option>';
    }
    echo '</select>';
}

if(isset($_GET['hos']))
{
    echo 'Select Hostel : <select name="hostel_name" onchange="getAlotRooms('.$id.', this.value)">';
    $query2 = "SELECT DISTINCT hostel FROM available_room WHERE alloted=0  AND gender='$gender'";
    $result1 = mysql_query($query2) or die(mysql_error());
    while($reset=mysql_fetch_array($result1))
    {
	if($reset['hostel'] == $_GET['hos'])
	{
	    echo '<option value='.$reset['hostel'].' selected="selected">'.$reset['hostel'].'</option>';
	}
	else
	{
	    echo '<option value='.$reset['hostel'].'>'.$reset['hostel'].'</option>';
	}
    }
    echo '</select>';
    echo '&nbsp;&nbsp;Select Room : <select name="room_no" id="room_no_'.$id.'">';
    $query2 = "SELECT * FROM available_room WHERE alloted=0 AND hostel='".$_GET['hos']."' ORDER BY room_no";
    $result1 = mysql_query($query2) or die(mysql_error());
    while($reset=mysql_fetch_array($result1))
    {
	
		echo '<option value="'.$reset['room_no'].'">'.$reset['room_no'].'</option>';
    }
    echo '</select>';
    
    echo '&nbsp;&nbsp;<a href="javascript:void(0);" onClick="finalAllotRoom('.$id.', &#39;'.$_GET['hos'].'&#39;, document.getElementById(&#39;room_no_'.$id.'&#39;).value);">Submit</a>';
}

echo '</form>';
echo '</center>';

?>
