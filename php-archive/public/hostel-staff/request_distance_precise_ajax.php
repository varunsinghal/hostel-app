<?php
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }
if(isset($_GET["location2"]) & isset($_GET["student_id"])){
	$from = "Delhi Technological University, Shahabad Daulatpur Village, Rohini, New Delhi, Delhi";//Address of college
	$to = $_GET["location2"];//Get the student's address sent by the ajax query
	$st_id = $_GET["student_id"];//get the student id for updating in the database
	
	//get data ready
	$from = urlencode($from);
	$to = urlencode($to);
	
	//request data in json format
	$data = @file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=$from&destinations=$to&language=en-EN&sensor=false");//used @ to suppress the warning if network is down.
	if(!empty($data) && isset($data)){
	$data = json_decode($data);
	if($data->rows[0]->elements[0]->status=="OK"){//check if status was OK otherwise show error
		$distance = $data->rows[0]->elements[0]->distance->value/1000;
		$query1 = "update distance_from_home set distance = $distance where student_id = $st_id";
		$db->query($query1);
		echo $data->rows[0]->elements[0]->distance->value;//echo the distance
	}
	else{
		if(isset($_GET["less_precise"]))
		{
			$query2 = "update distance_from_home set distance = -1 where student_id = $st_id";
		}
		else
		{
			$query2 = "update distance_from_home set distance = 1 where student_id = $st_id";
		}
		$db->query($query2);
		echo 0;
	}
	}
	else echo 0;
}
else echo 0;//handle invalid requests
?>
