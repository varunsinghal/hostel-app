<?php
ob_start();
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }
include_layout_template('admin_header.php');
?>
<center><h1 style="color: #ccc;">Edit Public Form</h1></center>
<br />
Guidelines -
<ul>
<li>Do not change the content inside curly brackets { }.</li>
<li>Do not make changes in header or footer.</li>
<li>If you want to change the terms then you need to change them twice first in "Edit Form" and second in "Edit terms".</li>
</ul>
Thank you.
<br><br>
<?php
$form = $_GET['form'];
if(isset($_POST['submit'])){
	$new_html = $_POST['new_html'];
	//backup - putting old code in tmp file
	$tmp_file_name = '..'.DS.'tmp'.DS.time().'.txt';
	$old_html = file_get_contents($form);
	$tmp_file = fopen($tmp_file_name, "w");
	chmod("$tmp_file_name",0777);
	file_put_contents($tmp_file_name, $old_html);
	//updating - put textarea code to layouts file
	file_put_contents($form, $new_html);
	echo output_message('File updated successfully.');
}

?>
Current file - <?php echo $form; ?>
<?php $old_html = file_get_contents($form); ?>
<form method="post" action="">
	<textarea style="width: 100%; height: 100%;" name="new_html">
		<?php echo $old_html; ?>
	</textarea>
<br><br>
<input type="submit" value="Update File" name="submit">
</form>
<?php

include_layout_template('footer.php');
if(isset($database)) { $database->close_connection(); }
ob_end_flush();

?>
