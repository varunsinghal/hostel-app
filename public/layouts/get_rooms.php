<?php

require_once("../../includes/initialize.php");
?>
<?php
if(isset($_GET['hos']))
{
    echo '&nbsp;&nbsp;Select Room : <select name="last_room_no">';
    $query2 = "SELECT DISTINCT room_no FROM available_room WHERE hostel='".$_GET['hos']."' ORDER BY room_no";
    $result1 = mysql_query($query2) or die(mysql_error());
    while($reset=mysql_fetch_array($result1))
    {
	
		echo '<option value="'.$reset['room_no'].'">'.$reset['room_no'].'</option>';
    }
    echo '</select>';
    

}
