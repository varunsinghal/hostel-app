<?php
ob_start();

require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }
?>


<?php
    
    $sql = "SELECT * FROM distance_from_home";
    $rec = mysql_query($sql) or die (mysql_error());
    
    $num_fields = mysql_num_fields($rec);
    $header="";
	$data="";
	
	for($i = 0; $i < $num_fields; $i++ )
    {
        $header .= mysql_field_name($rec,$i)."\t";
    }
    
    while($row = mysql_fetch_row($rec))
    {
        $line = '';
        foreach($row as $value)
        {                                            
            if((!isset($value)) || ($value == ""))
            {
                $value = "\t";
            }
            else
            {
                $value = str_replace( '"' , '""' , $value );
                $value =  $value . "\t";
            }
            $line .= $value;
        }
        $data .= trim( $line ) . "\n";
    }
    
    $data = str_replace("\r" , "" , $data);
    
    if ($data == "")
    {
        $data = "\\n No Record Found!\n";                        
    }
    
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=distance_from_home.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    print "$header\n$data";

        if(isset($database)) { $database->close_connection(); }
    ob_end_flush();

?>