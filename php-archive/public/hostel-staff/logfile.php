<?php

require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }

$logfile = SITE_ROOT.DS.'logs'.DS.'log.txt';
if(isset($_GET['clear'])){
  if($_GET['clear']=='true'){
      file_put_contents($logfile, '');
      log_action('Logs Cleared', "by {$session->user_name}");
      redirect_to("logfile.php"); // so that again not cleared
  }    
}


include_layout_template('admin_header.php');

?>

<br />

<h2>Log Files</h2>
<p><a href="logfile.php?clear=true">Clear log file</a></p>




<?php

$file=$logfile;
$linecount = 0;
$handle = fopen($file, "r");
while(!feof($handle)){
  $line = fgets($handle);
  $linecount++;
}

fclose($handle);



function rfgets($handle) {
    $line = null;
    $n = 0;

    if ($handle) {
        $line = '';

        $started = false;
        $gotline = false;

        while (!$gotline) {
            if (ftell($handle) == 0) {
                fseek($handle, -1, SEEK_END);
            } else {
                fseek($handle, -2, SEEK_CUR);
            }

            $readres = ($char = fgetc($handle));

            if (false === $readres) {
                $gotline = true;
            } elseif ($char == "\n" || $char == "\r") {
                if ($started)
                    $gotline = true;
                else
                    $started = true;
            } elseif ($started) {
                $line .= $char;
            }
        }
    }

    fseek($handle, 1, SEEK_CUR);

    return strrev($line);
}


$filename = $logfile;

$handle = @fopen($filename, 'r');
echo "<ul class=\"log-entries\">";
for ($i = 0; $i < $linecount; $i++) {
    $buffer = rfgets($handle);
    if($buffer != "")
    {
    	echo "<li>".$buffer."</li>";
    }
}
echo "</ul>";

fclose($handle);

?>


<?php include_layout_template('footer.php'); ?>