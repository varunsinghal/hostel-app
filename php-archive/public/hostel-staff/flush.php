<?php
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }
include_layout_template('admin_header.php');

?>

<script type="text/javascript">
function delStudent(stuid)
       {
		     document.getElementById('cont').innerHTML="<img src='../images/ajax-loader_b.gif' height=24 />'";
		     if (stuid=="")
		     {
			    document.getElementById('cont').innerHTML="error";
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
				   document.getElementById('cont').innerHTML=xmlhttp.responseText;
				   document.getElementById('cont').innerHTML="";
			    }
		     }
		     xmlhttp.open("POST","delete_student.php",true);
		     xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		     xmlhttp.send("q="+stuid);
       }

</script>

<?php


echo '<center><h2 style="color:#ccc">Flush Database</h2></center><br />';


$query = "SELECT COUNT(*) FROM docu_submission WHERE document='0' ";
$result1 = mysql_query($query) or die(mysql_error());
$row1 = mysql_fetch_array($result1);
echo 'Un-verified junk applications : '.$row1['COUNT(*)'];
echo '<br />';
echo '<a href="flush.php?i=1">Flush</a><br /><br />';


if(isset($_GET['i']))
{
    
    if($_GET['i'] == 1)
    {
	$query = "SELECT * FROM docu_submission WHERE document='0' ";
	$result = mysql_query($query) or die(mysql_error());
	log_action('Database Flush Initiated', "Database Flush initiated by {$session->user_name}.");
	echo "<div id='cont'></div>";
	
	while($row = mysql_fetch_array($result)){
	    $id = $row['student_id'];
	    echo "<script type='text/javascript'>delStudent(".$id.");</script>";
	    log_action('Database Flush Process', "Student with form number {$id} deleted.");
	}
	
	
	if(!$row)
	{
	    echo "<b><font color='green'>Flushing Complete. Database Clean.</font></b>";
	    log_action('Database Flush Completed', "Database Flushed by {$session->user_name}.");
	}
    }

}


?>

<?php include_layout_template('admin_footer.php'); ?>