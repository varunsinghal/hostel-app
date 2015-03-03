<?php
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }
include_layout_template('admin_header.php'); ?>
<?php
if (isset($_GET['room'])) { 
if($_GET['room']=="notalloted")
{
echo '<h2 style="color:#9C9">Room is Already Alloted!</h2>';
}
if($_GET['room']=="allotedalready")
{
echo '<h2 style="color:#9C9">This Student has Already been Alloted the room!</h2>';
}
if($_GET['room']=="alloted")
{
echo '<h2 style="color:#9C9">Room has Been Alloted</h2>';
}
if($_GET['room']=="empty")
{
echo '<h2 style="color:#9C9">The field for room or form no. is empty!</h2>';
}
if($_GET['room']=="error")
{
echo '<h2 style="color:#9C9">Hey Dont try anything illegal!!!</h2><br>';
}
}
?>
<script type='text/javascript'>

function showUser(str)
{
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
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
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","display_student_info.php?q="+str,true);
xmlhttp.send();
}

</script>

<form action="allot_final.php" method="post" name="main">

FORM NO <select name="form_no" onchange="showUser(this.value)">
        <option value="">Select the Form No.</option>
        		<?php 
		$query = 'SELECT student_id FROM student';
		$result_set = mysql_query($query);
		while( $value= mysql_fetch_array($result_set))
		
		{ $value1=$value['student_id'];
		echo "<option value=$value1>".$value1."</option>"; 
		}
		
		?>
		</select>
<br><br>
<div id="txtHint"><b>Person info will be listed here.</b></div>
<br><br>
ROOM NO <input type="text" name="room_no" maxlength="4" >
HOSTEL <select name="hostel">
		<option>HJB</option>
        <option>VVS</option>
        <option>BCH</option>
        <option>VMH</option>
        <option>JCB</option>
        <option>CVR</option>
        <option>TRANSIT</option>
        <option>KALPANA CHAWLA</option>
        <option>SISTER NIVEDITA</option>
        <option>TYPE-1</option>
        <option>TYPE-2</option>
        <option>TYPE-3</option>
        <option>TYPE-4</option>
        <option>TYPE-5</option>
        </select>
        
<br><br>
<input type="submit" name="main" value="ALLOT">
</form>        
<?php include_layout_template('admin_footer.php'); ?>