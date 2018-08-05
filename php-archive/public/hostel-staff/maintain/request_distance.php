<?php

ob_start();
require_once("../../../includes/initialize.php");

$query = "SELECT * FROM pindata WHERE distance='0' ORDER BY id DESC";
$result = mysql_query($query) or die(mysql_error());
while($row = mysql_fetch_array($result)){
    $id = $row['id'];
    $addr = $row['address'];
    //echo "ID : ".$id." | Address : ".$addr."<br />";
    header('Location: gmaps/index.php?id='.$id.'&addr='.$addr);
}


ob_end_flush();
?>
