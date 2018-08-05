<?php

require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }
include_layout_template('admin_header.php');
?>

<?php

echo'<center><h2 style="color:#ccc">Status</h2></center>';


echo '<table width="100%">';
echo '<tr>';
echo '<td>';

echo '<fieldset>';
echo '<legend>Total Data</legend>';
echo '<center>';
echo '<table>';
$query="SELECT COUNT(DISTINCT room_no) FROM available_room";
$fetch=mysql_query($query) or die(mysql_error());
$data=mysql_fetch_array($fetch);

echo "<tr><td>Total Available Rooms&nbsp;&nbsp;</td><td>&nbsp;:&nbsp;</td> <td><span style='color:#0505FF;'>&nbsp;&nbsp;".$data['COUNT(DISTINCT room_no)']."</span></td>";


$query="SELECT COUNT(DISTINCT room_no) FROM available_room WHERE alloted=1";
$fetch=mysql_query($query) or die(mysql_error());
$data=mysql_fetch_array($fetch);

echo "<tr><td>Total Alloted Rooms&nbsp;&nbsp;</td><td>&nbsp;:&nbsp;</td> <td><span style='color:#0505FF;'>&nbsp;&nbsp;".$data['COUNT(DISTINCT room_no)']."</span></td>";


$query="SELECT COUNT(room_no) FROM available_room";
$fetch=mysql_query($query) or die(mysql_error());
$data=mysql_fetch_array($fetch);

echo "<tr><td>Total Seats&nbsp;&nbsp;</td><td>&nbsp;:&nbsp;</td> <td><span style='color:#0505FF;'>&nbsp;&nbsp;".$data['COUNT(room_no)']."</span></td>";


$query="SELECT COUNT(DISTINCT student_id) FROM available_room";
$fetch=mysql_query($query) or die(mysql_error());
$data=mysql_fetch_array($fetch);

echo "<tr><td>Total Alloted Students&nbsp;&nbsp;</td><td>&nbsp;:&nbsp;</td> <td><span style='color:#0505FF;'>&nbsp;&nbsp;".$data['COUNT(DISTINCT student_id)']."</span></td>";

echo '</table>';
echo '</center>';

echo '</fieldset>';

echo '</td>';
echo '<td>';


// --------------------------------------------- genderwise starts -------------------------------------------------------- //

echo '<fieldset>';
echo '<legend>Gender-wise</legend>';
echo '<center>';
echo '<table>';
$query="SELECT COUNT(room_no) FROM available_room WHERE gender='male'";
$fetch=mysql_query($query) or die(mysql_error());
$data=mysql_fetch_array($fetch);

echo "<tr><td>Total Seats for Boys&nbsp;&nbsp;</td><td>&nbsp;:&nbsp;</td> <td><span style='color:#0505FF;'>&nbsp;&nbsp;".$data['COUNT(room_no)']."</span></td>";


$query="SELECT COUNT(room_no) FROM available_room WHERE gender='male' AND alloted=1";
$fetch=mysql_query($query) or die(mysql_error());
$data=mysql_fetch_array($fetch);

echo "<tr><td>Total Boys Alloted&nbsp;&nbsp;</td><td>&nbsp;:&nbsp;</td> <td><span style='color:#0505FF;'>&nbsp;&nbsp;".$data['COUNT(room_no)']."</span></td>";


$query="SELECT COUNT(room_no) FROM available_room WHERE gender='female'";
$fetch=mysql_query($query) or die(mysql_error());
$data=mysql_fetch_array($fetch);

echo "<tr><td>Total Seats for Girls&nbsp;&nbsp;</td><td>&nbsp;:&nbsp;</td> <td><span style='color:#0505FF;'>&nbsp;&nbsp;".$data['COUNT(room_no)']."</span></td>";

$query="SELECT COUNT(room_no) FROM available_room WHERE gender='female' AND alloted=1";
$fetch=mysql_query($query) or die(mysql_error());
$data=mysql_fetch_array($fetch);

echo "<tr><td>Total Girls Alloted&nbsp;&nbsp;</td><td>&nbsp;:&nbsp;</td> <td><span style='color:#0505FF;'>&nbsp;&nbsp;".$data['COUNT(room_no)']."</span></td>";

echo '</table>';
echo '</center>';

echo '</fieldset>';

// --------------------------------------------------genderwise ends ----------------------------------------------------------- //


echo '</td>';
echo '<td>';


// --------------------------------------------- yearwise starts -------------------------------------------------------- //


echo '<fieldset>';
echo '<legend>Year-wise</legend>';
echo '<center>';
echo '<table>';
$query="SELECT COUNT(room_no) FROM available_room";
$fetch=mysql_query($query) or die(mysql_error());
$data=mysql_fetch_array($fetch);

echo "<tr><td>Total Seats Available&nbsp;&nbsp;</td><td>&nbsp;:&nbsp;</td> <td><span style='color:#0505FF;'>&nbsp;&nbsp;".$data['COUNT(room_no)']."</span></td>";


$query="SELECT COUNT(room_no) FROM `available_room` NATURAL JOIN academic WHERE available_room.student_id = academic.student_id AND academic.year_of_admn = ".(date("Y", time()));
$fetch=mysql_query($query) or die(mysql_error());
$data=mysql_fetch_array($fetch);

echo "<tr><td>Total First Years&nbsp;&nbsp;</td><td>&nbsp;:&nbsp;</td> <td><span style='color:#0505FF;'>&nbsp;&nbsp;".$data['COUNT(room_no)']."</span></td>";


$query="SELECT COUNT(room_no) FROM `available_room` NATURAL JOIN academic WHERE available_room.student_id = academic.student_id AND academic.year_of_admn = ".(date("Y", time())-1);
$fetch=mysql_query($query) or die(mysql_error());
$data=mysql_fetch_array($fetch);

echo "<tr><td>Total Second Years&nbsp;&nbsp;</td><td>&nbsp;:&nbsp;</td> <td><span style='color:#0505FF;'>&nbsp;&nbsp;".$data['COUNT(room_no)']."</span></td>";

$query="SELECT COUNT(room_no) FROM `available_room` NATURAL JOIN academic WHERE available_room.student_id = academic.student_id AND academic.year_of_admn = ".(date("Y", time())-2);
$fetch=mysql_query($query) or die(mysql_error());
$data=mysql_fetch_array($fetch);

echo "<tr><td>Total Third Years&nbsp;&nbsp;</td><td>&nbsp;:&nbsp;</td> <td><span style='color:#0505FF;'>&nbsp;&nbsp;".$data['COUNT(room_no)']."</span></td>";

$query="SELECT COUNT(room_no) FROM `available_room` NATURAL JOIN academic WHERE available_room.student_id = academic.student_id AND academic.year_of_admn = ".(date("Y", time())-3);
$fetch=mysql_query($query) or die(mysql_error());
$data=mysql_fetch_array($fetch);

echo "<tr><td>Total Fourth Years&nbsp;&nbsp;</td><td>&nbsp;:&nbsp;</td> <td><span style='color:#0505FF;'>&nbsp;&nbsp;".$data['COUNT(room_no)']."</span></td>";

echo '</table>';
echo '</center>';

echo '</fieldset>';

echo '</td>';

echo '</tr>';

echo '<tr>';


echo '<td>';


// --------------------------------------------- category wise boys starts -------------------------------------------------------- //

echo '<fieldset>';
echo '<legend>Category-Wise-Boys</legend>';
echo '<center>';
echo '<table>';
$sql = "SELECT DISTINCT `category_code` FROM `student` WHERE 1";
$result = mysql_query($sql) or die(mysql_error());

while($row = mysql_fetch_array($result)){


    $query="SELECT COUNT(room_no) FROM available_room NATURAL JOIN student WHERE available_room.student_id = student.student_id AND student.category_code='".$row['category_code']."' AND student.gender='male' ";
    $fetch=mysql_query($query) or die(mysq_codel_error());
    $data=mysql_fetch_array($fetch);

    echo "<tr><td>Total Alloted to ".$row['category_code']."&nbsp;&nbsp;</td><td>&nbsp;:&nbsp;</td> <td><span style='color:#0505FF;'>&nbsp;&nbsp;".$data['COUNT(room_no)']."</span></td>";


}

echo '</table>';
echo '</center>';

echo '</fieldset>';

// -------------------------------------------------- category wise boys ends ----------------------------------------------------------- //


echo '</td>';


echo '<td>';


// --------------------------------------------- category wise girls starts -------------------------------------------------------- //

echo '<fieldset>';
echo '<legend>Category-Wise-Girls</legend>';
echo '<center>';
echo '<table>';

$sql = "SELECT DISTINCT `category_code` FROM `student` WHERE 1";
$result = mysql_query($sql) or die(mysql_error());

while($row = mysql_fetch_array($result)){


    $query="SELECT COUNT(room_no) FROM available_room NATURAL JOIN student WHERE available_room.student_id = student.student_id AND student.category_code='".$row['category_code']."' AND student.gender='female' ";
    $fetch=mysql_query($query) or die(mysql_error());
    $data=mysql_fetch_array($fetch);

    echo "<tr><td>Total Alloted to ".$row['category_code']."&nbsp;&nbsp;</td><td>&nbsp;:&nbsp;</td> <td><span style='color:#0505FF;'>&nbsp;&nbsp;".$data['COUNT(room_no)']."</span></td>";


}

echo '</table>';
echo '</center>';

echo '</fieldset>';

// -------------------------------------------------- category wise girls ends ----------------------------------------------------------- //


echo '</td>';


echo '<td>';


// --------------------------------------------- hostelwise starts -------------------------------------------------------- //

echo '<fieldset>';
echo '<legend>Hostel-wise</legend>';
echo '<center>';
echo '<table>';

$sql = "SELECT DISTINCT `hostel` FROM `available_room` WHERE 1";
$result = mysql_query($sql) or die(mysql_error());

while($row = mysql_fetch_array($result)){


    $query="SELECT COUNT(room_no) FROM available_room WHERE hostel='".$row['hostel']."'";
    $fetch=mysql_query($query) or die(mysql_error());
    $data=mysql_fetch_array($fetch);

    echo "<tr><td>Total Seats in ".$row['hostel']."&nbsp;&nbsp;</td><td>&nbsp;:&nbsp;</td> <td><span style='color:#0505FF;'>&nbsp;&nbsp;".$data['COUNT(room_no)']."</span></td>";
    
    
    $query="SELECT COUNT(room_no) FROM available_room WHERE hostel='".$row['hostel']."' AND alloted=1";
    $fetch=mysql_query($query) or die(mysql_error());
    $data=mysql_fetch_array($fetch);

    echo "<tr><td>Total Seats alloted in ".$row['hostel']."&nbsp;&nbsp;</td><td>&nbsp;:&nbsp;</td> <td><span style='color:#0505FF;'>&nbsp;&nbsp;".$data['COUNT(room_no)']."</span></td>";



}


echo '</table>';
echo '</center>';

echo '</fieldset>';

// -------------------------------------------------- hostelwise ends ----------------------------------------------------------- //


echo '</td>';


echo '</tr>';


echo '</table>';

// --------------------------------------------------yearwise ends ----------------------------------------------------------- //



?>

<?php include_layout_template('admin_footer.php'); ?>
