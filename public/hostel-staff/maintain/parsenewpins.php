<?php

$logfile = 'data_newpins.txt';

ini_set('max_execution_time', 1200); //1200 seconds = 20 minutes

require_once("../../../includes/initialize.php");

//$i = 1;
echo "<ol>";
if(file_exists($logfile) && is_readable($logfile) && $handle = fopen($logfile, 'r'))
{ // read
  while(!feof($handle)){
    $entry = fgets($handle);
    if(trim($entry) != ""){
    	$pincode = substr($entry, 0, 6);
    	$address = str_replace($pincode.', ', '', $entry);
    	//$query2 = "SELECT * FROM pindata WHERE id='$i' LIMIT 1";
    	//$result2 = mysql_query($query2);
    	//$datagot = mysql_fetch_array($result2);
    	$query = "INSERT INTO pindata (pincode, address) VALUES ('{$pincode}', '{$address}')";
    	mysql_query($query);
        echo "<li>{$pincode} : {$address}</li>";
      //$i++;
    }
  }
  fclose($handle);
} else {
  echo "Could not read from {$logfile}<br />";
}

echo "</ol>";

?>
