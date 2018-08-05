<?php
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

</script>


<?php

echo '<h1 style="color:#ccc">List Of Alloted Rooms</h2><br><br>';

?>

<p align="right"><a href="hostel_list_export_index.php">Export Hostelwise Student List</a></p>

<?php


$query = "SELECT DISTINCT hostel FROM available_room ORDER BY hostel";
$result = mysql_query($query) or die(mysql_error());
while($fetch=mysql_fetch_array($result))
{
    $hostel=$fetch['hostel'];
    echo'<h3 style="color:#668CFF">'.$hostel.'</h3><hr />';
    echo '<table width=100%>';
    echo '<tr>';
    echo '<th>Hostel</th><th>Name</th><th>Action</th>';
    echo '</tr>';
    $query2 = "SELECT * FROM available_room WHERE hostel='$hostel'";
    $result2 = mysql_query($query2) or die(mysql_error());
    while($fetch2=mysql_fetch_array($result2))
    {
        $room_no = $fetch2['room_no'];
        $room_id = $fetch2['room_id'];
        echo '<tr>';
        echo '<td>';
        $query1 = "SELECT * FROM available_room WHERE hostel='$hostel' and room_id='$room_id' ORDER BY room_no";
        $result1 = mysql_query($query1) or die(mysql_error());
        while($rooms=mysql_fetch_array($result1))
        {
            echo $hostel.'&nbsp;&nbsp;'.$room_no;
           /* $query2 = "SELECT * FROM available_room WHERE room_id='$room_id'";
            $result1 = mysql_query($query2) or die(mysql_error());
            while($reset=mysql_fetch_array($result1))
            {  */
                $id = $rooms['student_id'];
                if($id>0){
                $query2 = "SELECT * FROM student WHERE student_id='$id'";
                $result1 = mysql_query($query2) or die(mysql_error());
                $reset=mysql_fetch_array($result1);
                echo '<td>'.$reset['name'].'</td>';
                echo '<td><a href="view.php?page='.$id.'" target="_blank" onclick="return popitup(&#39;view.php?page='.$id.'&#39;)">View Details</a></td>';}
            //}
            echo '</td>';
        }
        echo '</tr>';
        echo '<tr><td><tr>';
    }
    echo '</table>';
}


?>

<?php include_layout_template('admin_footer.php'); ?>
