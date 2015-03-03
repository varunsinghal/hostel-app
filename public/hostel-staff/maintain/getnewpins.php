<?php

ini_set('max_execution_time', 1200); //1200 seconds = 20 minutes


require_once("../../../includes/initialize.php");

function write_file($message=""){
  $logfile = 'data_newpins.txt';
  $new = file_exists($logfile) ? false : true;
  if($handle = fopen($logfile,'a')){ // append
    $content = "{$message}\r\n";
    fwrite($handle, $content);
    fclose($handle);
    if($new){
      chmod($logfile, 0755);
    }
  } else {
    echo "Could not open log file for writing.<br />";
  }
}

function searchstr($mystring, $searchitem) {

$pos = strrpos($mystring, $searchitem);
if ($pos === false) {
    return false;
}
else { 
 return true;
 }
}


$query = mysql_query("SELECT DISTINCT present_pin FROM present_address WHERE present_country='india' ORDER BY present_pin ASC");
while($queryresult = mysql_fetch_array($query))
{

$pintofind = $queryresult['present_pin'];

$querys = mysql_query("SELECT count(pincode) FROM pindata WHERE pincode='$pintofind'");
$datafrompindata = mysql_fetch_array($querys);
if($datafrompindata['count(pincode)'] == 0 && strlen($queryresult['present_pin']) == 6 && $pintofind != '000000')
{
$data = array();
$data['pg'] = "search";
$data['country'] = 'IN';
$data['search'] =$pintofind;

$post_str = '';
foreach($data as $key=>$value)
{
	$post_str .= $key.'='.urlencode($value).'&';
}
$post_str = substr($post_str, 0, -1);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://www.geopostcodes.com/index.php');
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_str);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

$response = curl_exec($ch);
curl_close($ch);

//echo $response;

if(searchstr($response, 'TOO MANY REQUESTS - Please try again later'))
{
	echo 'TOO MANY REQUESTS - Please try again later<br />exiting..';
	exit(0);
}


$dom = new DOMDocument;
//$dom->preserveWhiteSpace = false;
$dom->validateOnParse = true;
$dom->strictErrorChecking = false;
@$dom->loadHTML($response);
//print_r($dom);
/*
$divs = $dom->getElementsByTagName('td');
foreach ($divs as $div) {
    foreach ($div->attributes as $attr) {
      $name = $attr->nodeName;
      $value = $attr->nodeValue;
      echo "Attribute '$name' :: '$value'<br />";
    }
}
*/


$pinline = array();
$detailaddrline = array();
$mainaddr = array();
$divs = $dom->getElementsByTagName('b');
for ($i=2; $i<$divs->length-1; $i++) {
    $pinline[] = $divs->item($i)->nodeValue;
    $mainaddr[] = str_replace(substr($divs->item($i)->nodeValue, 0, 6), '', $divs->item($i)->nodeValue);
}


$finder = new DomXPath($dom);
$classname="browserln";
$nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");

//$finder = new Zend_Dom_Query($response);
//$classname = 'browserln';
//$nodes = $finder->query("*[class~=\"$classname\"]");

//echo $nodes;

//$html = $dom->saveHTML();
//echo $html;

//$pincode = substr($nodes->item(3)->nodeValue, 0, 6); 
for($j = 0; $j<$nodes->length; $j++)
{
	 $temp = str_replace($pinline[$j], '', $nodes->item($j)->nodeValue);
	 $str = '';
	 $temparr = explode('»',$temp);
	 $temparr = array_reverse($temparr);
	 $temparr = array_unique($temparr);
	 foreach ($temparr as $vale) {$str .= $vale.",";}
	 $str = substr($str, 0, -1);
	 $detailaddrline[] = $str;
}

for($k=0; $k<$nodes->length; $k++)
{
	//$detailaddrline[$k] = str_replace($pinline[$k], '', $detailaddrline[$k]);
	$pinline[$k] = substr($pinline[$k], 0, 6);
	$pintowrite = $pinline[$k];
	$addrtowrite = $mainaddr[$k].",".$detailaddrline[$k];
	write_file($pintowrite.','.$addrtowrite);
	echo "Pin : ".$pintowrite." done.<br />";
	//echo "Pin : ".$pinline[$k]." | Address : ".$mainaddr[$k].", ".$detailaddrline[$k]."<br />";
}
}
}
//$addressdata = array_reverse($addressdata);

//foreach ($addressdata as $entity)
//{
//	echo $entity.", ";
//}


?>
