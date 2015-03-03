<?php

require_once("../../../includes/initialize.php");

$i = 1;

$keyword = '';

$result = mysql_query("SELECT * FROM pindata WHERE address LIKE '%$keyword%'");
$count = mysql_num_rows($result);
echo $count.'<hr />';
while($row = mysql_fetch_array($result))
{
	$id = $row['id'];
	$address = $row['address'];
	echo $id.' | '.$i.'. Pincode : '.$row['pincode'].' | Address : '.$address.'<br />';
	$address = str_replace($removepart, '', $address);
	echo $address.'<br />';
	if($id != $i)
	{
		$result2 = mysql_query("UPDATE pindata SET id='$i' WHERE id='$id'");
	}
	$i++;
}

echo 'Done';

?>
