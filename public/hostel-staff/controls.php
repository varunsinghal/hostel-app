<?php
       require_once("../../includes/initialize.php");
       if(!$session->is_logged_in()){ redirect_to("login.php"); }
       include_layout_template('admin_header.php');
?>

<script type="text/javascript">
function changeRegistration(stuid)
       {
	      var r=confirm("Are you sure you want to change the registration status?");
	      if(r==true){
		     document.getElementById('registration_status').innerHTML="<img src='../images/ajax-loader_b.gif' height=15 />";
		     if (stuid=="")
		     {
			    document.getElementById('registration_status').innerHTML="error";
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
				   window.location.reload();
			    }
		     }
		     xmlhttp.open("POST","change_registration_status.php",true);
		     xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		     xmlhttp.send("status="+stuid);
	      }
       }
       
       
function changeReallotment(stuid)
       {
	      var r=confirm("Are you sure you want to change the registration status?");
	      if(r==true){
		     document.getElementById('reallotment_status').innerHTML="<img src='../images/ajax-loader_b.gif' height=15 />";
		     if (stuid=="")
		     {
			    document.getElementById('reallotment_status').innerHTML="error";
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
				   window.location.reload();
			    }
		     }
		     xmlhttp.open("POST","change_reallotment_status.php",true);
		     xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		     xmlhttp.send("status="+stuid);
	      }
       }
       
function changeSurrender(stuid)
       {
	      var r=confirm("Are you sure you want to change the surrender status?");
	      if(r==true){
		     document.getElementById('surrender_status').innerHTML="<img src='../images/ajax-loader_b.gif' height=15 />";
		     if (stuid=="")
		     {
			    document.getElementById('surrender_status').innerHTML="error";
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
				   window.location.reload();
			    }
		     }
		     xmlhttp.open("POST","change_surrender_status.php",true);
		     xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		     xmlhttp.send("status="+stuid);
	      }
       }
            
function changeAllotment_status(stuid)
       {
	      var r=confirm("Are you sure you want to change the allotment check status?");
	      if(r==true){
		     document.getElementById('allotcheck_status').innerHTML="<img src='../images/ajax-loader_b.gif' height=15 />";
		     if (stuid=="")
		     {
			    document.getElementById('allotcheck_status').innerHTML="error";
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
				   window.location.reload();
			    }
		     }
		     xmlhttp.open("POST","change_allotment_status.php",true);
		     xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		     xmlhttp.send("status="+stuid);
	      }
       }
</script>

<?php

echo '<center><h2 style="color:#ccc">Admin Controls</h2></center>';
echo '<br /><br />';
if(isset($_GET['q'])){
echo output_message($_GET['q']);
}
echo '<h3 style="color: #0A85FF">Registration</h3><div id="registration_status">';
$query2 = "SELECT * FROM control_variables WHERE control='registration'";
$result1 = mysql_query($query2) or die(mysql_error());
$reset=mysql_fetch_array($result1);
if($reset['flag'] == 1)
{
       echo '<span style="color:green;">LIVE</span>';
}
else
{
       echo '<span style="color:red;">CLOSED</span>';
}
echo '</div><hr />';
echo '<a href="javascript:void(0);" onClick="changeRegistration(1);"><img src="../images/start.gif" width="50px" /></a>&nbsp;&nbsp;<a href="javascript:void(0);" onClick="changeRegistration(2);"><img src="../images/stop.gif" width="50px" ></a>';


echo '<hr /><br /><br /><hr />';
echo '<h3 style="color: #0A85FF">Re-Allotment</h3><div id="reallotment_status">';
$query2 = "SELECT * FROM control_variables WHERE control='reallotment'";
$result1 = mysql_query($query2) or die(mysql_error());
$reset=mysql_fetch_array($result1);
if($reset['flag'] == 1)
{
       echo '<span style="color:green;">LIVE</span>';
}
else
{
       echo '<span style="color:red;">CLOSED</span>';
}
echo '</div><hr />';
echo '<a href="javascript:void(0);" onClick="changeReallotment(1);"><img src="../images/start.gif" width="50px" /></a>&nbsp;&nbsp;<a href="javascript:void(0);" onClick="changeReallotment(2);"><img src="../images/stop.gif" width="50px" ></a>';

echo '<hr /><br /><br /><hr />';
echo '<h3 style="color: #0A85FF">Surrender</h3><div id="surrender_status">';
$query2 = "SELECT * FROM control_variables WHERE control='surrender'";
$result1 = mysql_query($query2) or die(mysql_error());
$reset=mysql_fetch_array($result1);
if($reset['flag'] == 1)
{
       echo '<span style="color:green;">LIVE</span>';
}
else
{
       echo '<span style="color:red;">CLOSED</span>';
}
echo '</div><hr />';
echo '<a href="javascript:void(0);" onClick="changeSurrender(1);"><img src="../images/start.gif" width="50px" /></a>&nbsp;&nbsp;<a href="javascript:void(0);" onClick="changeSurrender(2);"><img src="../images/stop.gif" width="50px" ></a>';


echo '<hr /><br /><br /><hr />';
echo '<h3 style="color: #0A85FF">Allotment Status</h3><div id="allotcheck_status">';
$query2 = "SELECT * FROM control_variables WHERE control='allotment_status'";
$result1 = mysql_query($query2) or die(mysql_error());
$reset=mysql_fetch_array($result1);
if($reset['flag'] == 1)
{
       echo '<span style="color:green;">LIVE</span>';
}
else
{
       echo '<span style="color:red;">CLOSED</span>';
}
echo '</div><hr />';
echo '<a href="javascript:void(0);" onClick="changeAllotment_status(1);"><img src="../images/start.gif" width="50px" /></a>&nbsp;&nbsp;<a href="javascript:void(0);" onClick="changeAllotment_status(2);"><img src="../images/stop.gif" width="50px" ></a>';
echo '<hr />';
?> 
<h3 style="color: #0A85FF">Maintenance</h3>
<small>If you come across any error or discrepancy please click on service button</small><hr />
<a href="service.php"><button style="color:#CCC; background: #400080; width:100px; height: 40px;">Service</button></a>
&ensp;
<a href="service_surrender.php"><button style="color:#CCC; background: #400080; width:100px; height: 40px;">Surrender</button></a>
&ensp;
<hr />

<h3 style="color: #0A85FF">Flush Database</h3>
<small>To flush unverified junk applications from database which were not accepted by the office</small><hr />
<a href="flush.php"><button style="color:#CCC; background: #400080; width:100px; height: 40px;">Flush</button></a>



<?php include_layout_template('footer.php'); ?>
