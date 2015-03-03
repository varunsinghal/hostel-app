<?php

ob_start();

require_once("../../includes/initialize.php");


if(!$session->is_logged_in()){ redirect_to("login.php");}
?>

<?php

if(!isset($_GET['id'])){
    redirect_to("viewuser.php");
}

if(isset($_POST['submit'])){
    $user = new User();
    $user->id = trim($_GET['id']);
    $user->delete();
    log_action('User Account Deleted', "User account ID {$_GET['id']} deleted by {$session->user_name}");
    redirect_to("viewuser.php?status=delete");
}

?>

<?php include_layout_template('admin_header.php'); ?>

<form action="" method="post">
    Are you sure you want to delete the user?
    <br />
    <input type="submit" value="Delete" name="submit" /> or <a href="viewuser.php">Don't Delete</a>
</form>

<?php include_layout_template('admin_footer.php');
ob_end_flush();
?>