<?php

ob_start();
require_once("../includes/initialize.php");
include_layout_template('header.php');
?>
<?php

if (isset($_POST['submit']))
{
	include_once 'securimage/securimage.php';
    $securimage = new Securimage();
    if ($securimage->check($_POST['captcha_code']) == false) {
        echo '<script>history.go(-1)</script>';
        exit;
    }
}

echo 
'<table>
<tr><td>Name: </td><td>'.$_POST['name'].'</td></tr>
<tr><td>Father Name: </td><td>'.$_POST['fathername'].'</td></tr>
<tr><td>Father Phone: </td><td>'.$_POST['fatherphone'].'</td></tr>
<tr><td>Hostel Roll:</td><td>'.$_POST['hostelrollno'].'</td></tr>
<tr><td>Feedback:</td><td>'.$_POST['textarea'].'</td></tr>
</table>';

$check = mysql_query("select available_room.room_id , student.student_id , parent_details.father_phone from available_room , student , parent_details where student.recipt = '$_POST[hostelrollno]' and available_room.student_id = student.student_id and available_room.alloted = 1 and parent_details.father_phone = '$_POST[fatherphone]'");
if($check){
			$rows = mysql_num_rows($check);
		}
else{
		$rows = 0;
	}
if($rows != 0)
{
		$row = mysql_fetch_array($check);
		$time = strftime("%Y-%m-%d %H:%M:%S", time());
		$query = mysql_query("insert into feedback ( student_id , message, submission_time ) values( '$row[student_id]' , '$_POST[textarea]', '$time')");
		if($query)
			{
				echo " <br>Your feedback has been submitted.<br>";
			}
		else
			{
				echo "<br> Server not responding. Try again later.<br> ";
			}
}
else
	{
		 echo "<br>Your form has NOT been approved.<br>Kindly check your details. <a href='feedback.php'>Go Back</a>" ;
	}

?>