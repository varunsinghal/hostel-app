<?php

require_once("../../includes/initialize.php");
?>
<?php
if(isset($_GET['table_name']))
{
    echo '&nbsp;&nbsp;Select Field : <select name="column_name">';
    $query2 = "DESCRIBE ".$_GET['table_name'];
    $result1 = mysql_query($query2) or die(mysql_error());
    while($reset=mysql_fetch_array($result1))
    {
	
		echo '<option value="'.$reset['Field'].'">'.refine($reset['Field']).'</option>';
    }
    echo '</select>';
    

}
?>
