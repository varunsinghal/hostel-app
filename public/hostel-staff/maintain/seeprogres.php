<?php

ob_start();
require_once("../../../includes/initialize.php");

?>

<HEAD>
<meta http-equiv='refresh' content='2;url='seprogress.php'>
</HEAD>
<body style="background-color: #036;color:#FFFFFF;font-family:Arial, Helvetica, sans-serif;font-size:12px;">
<?php

$query = "SELECT * FROM pindata WHERE distance !=0 ORDER BY time DESC LIMIT 100";
$result = mysql_query($query);
while($row = mysql_fetch_array($result))
{
	echo $row['time']." | ID : ".$row['id']." | Pin : ".$row['pincode']." | Address : ".$row['address']." | Distance : ".$row['distance']."<br />";
}

ob_end_flush();

?>

</body>
