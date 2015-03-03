<?php

ob_start();

require_once("../includes/initialize.php");
include_layout_template('header.php');
?>
Photo Instructions:
<ol>
<?php 
$query=mysql_query("select terms from terms where reallot=2 order by id");
while($result=mysql_fetch_array($query)){
  echo '<li>'.$result['terms'].'</li>';
}
?>
</ol>
<?php  include_layout_template('footer.php');
if(isset($database)) { $database->close_connection(); }
ob_end_flush()

?>
