<?php
       require_once("../../includes/initialize.php");
       if(!$session->is_logged_in()){ redirect_to("login.php"); }
       include_layout_template('admin_header.php');
?>
<script type="text/javascript" src="js/jquery1_11_1.js"></script>
<script>
var n=1;
function get_distance()//get distance of the nth child
{
	if(n<=$("tbody").children("tr").length){
	st_id = $("tbody tr:nth-child("+n+")").children(".st_id").html();
	address = $("tbody tr:nth-child("+n+")").children(".address").html();
	address = address.replace('#','');//remove # from the complete string as 
	console.log(address);
	$.ajax({
		url: "request_distance_precise_ajax.php?<?php if (isset($_GET["less_precise"])) echo "less_precise" ?>&location2="+address+"&student_id="+st_id,
		context: document.body,
		timeout:15000,
		success:function(data){
					if(data!=0)	{$( "tbody tr:nth-child("+n+")" ).children(".status").addClass( "done" );}
					else {$( "tbody tr:nth-child("+n+")" ).children(".status").addClass( "error" );}
					n++;
					get_distance();
					}
		});
	}
	else if($("tbody").children("tr").length==0)
	{
		alert("All distances have been updated sucessfully.");
		$("#status").html("All distances updated.");
	}
	else{
		location.reload();
	}
}

$(document).ready(function(){
	get_distance();
});
</script>
<style>
.status
{
	background:url(../images/ajax-loader_b.gif) no-repeat;
	display:block;
	background-size:contain;
}
.done
{
	background:url(../images/accept.png) no-repeat !important;
	background-size:contain;
}
.error
{
	background:url(../images/error.png) no-repeat !important;
	background-size:contain;
}
</style>
<body>

<div class="container">
  <div class="content">
  <center>
  <font color="#FF3300" size="5px">DTU-HOME DISTANCE CALCULATOR</font><br /><br />
	<span id="status">We are updating distances.....Please wait....</span>
	<?php
		if(isset($_GET["less_precise"]))
		{
			$query3="SELECT student_id FROM distance_from_home where distance=1 LIMIT 20";
		}
		else
		{
		$query3="SELECT student_id FROM distance_from_home where distance=0 LIMIT 20";
		}
    		$st_ids= $db->query($query3);
			$st_array = "";
    		while($st_id= $db->fetch_array($st_ids)){
				$st_array.= $st_id["student_id"].",";
    		}
			$st_array = trim($st_array,",");
			$query4="SELECT * FROM present_address where student_id in ($st_array)";
			if($st_array != "")
			{
			echo "<table>
			<thead>
			<tr>
			<th>Student ID</th><th>Address</th><th>Status</th>
			</tr>
			</thead><tbody>";
			$add = $db->query($query4);
			while($address= $db->fetch_array($add))
			{
				if(isset($_GET["less_precise"])) $addr = $address['present_city'].', '.$address['present_state'];
				else $addr = $address['present_add_line'].', '.$address['present_city'].', '.$address['present_state'];
				echo "<tr><td class='st_id'>".$address["student_id"]."</td><td class='address'>".$addr."</td>"."<td class='status'></td></tr>";				
			}
			echo "</tbody><table>";
			}
    	?>
    <div style='width: 100%; font-size:10px; background-color:#CCC;'>Powered by DWD - DTU</div>
</center>
    <!-- end .content --></div>
  <!-- end .container --></div>

</body>
</html>
