<?php

require_once("../../../includes/initialize.php");

$removepart = 'Gwalior,';

$keyword = 'Guna,Gwalior';

$result = mysql_query("SELECT * FROM pindata WHERE address LIKE '%$keyword%'");
$count = mysql_num_rows($result);
echo $count.'<hr />';
while($row = mysql_fetch_array($result))
{
	$id = $row['id'];
	$address = $row['address'];
	echo $id.'. Pincode : '.$row['pincode'].' | Address : '.$address.'<br />';
	$address = str_replace($removepart, '', $address);
	echo $address.'<br />';
	$result2 = mysql_query("UPDATE pindata SET address='$address', distance=0 WHERE id='$id'");
}

echo 'Done';

?>
