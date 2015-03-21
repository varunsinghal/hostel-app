<?php
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }
?>

<?php
Header('Content-type: application/octet-stream; charset=utf-8');
Header('Content-Disposition: attachment; filename=hostels-backup-'.date('d-m-Y H:i:s', time()).'-full_db.sql');
echo backup_tables();
?>

