<?php
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }
?>


<?php


$id = $_POST['q'];
$query2 = "DELETE FROM feedback WHERE feedback_id=".$id." LIMIT 1";
$result1 = mysql_query($query2);

if($result1){
    echo "<tr><td colspan=7><center><b><font color='red'>DELETED</font></b></center></td></tr>";
    log_action('Feedback Deleted', "Feedback with id: {$id} deleted by {$session->user_name}.");
}
else {
    echo "<center><b><font color='red'>Some error occoured. Please refresh the page ang start all over again.</font></b></center>";
}

?>
