<?php


ob_start();

require_once("../../includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("login.php"); }
?>


<?php

require_once("../../includes/initialize.php");


if(!isset($_GET['id'])){
  redirect_to('viewuser.php');
}

// remember to give ur form's submit tag a name submit attribute
if(isset($_POST['submit'])){  // form has been submitted
  
  $user = new User();
  $user->id = $_GET['id'];
  $user->username = trim($_POST['username']);
  $user->password = md5(trim($_POST['password']));
  $user->level = trim($_POST['level']);
  $user->name = trim($_POST['name']);
  $user->phone = trim($_POST['phone']);
  $user->update();
  log_action('User Details Updated', "Details of {$user->username} updated by {$session->user_name}");
  redirect_to('viewuser.php?status=update');

  // check db to see if username/password exists
//  $found_user = User::authenticate($username,$password);

} else { // form not submitted
  $username = "";
  $password = "";
  $name = "";
  $phone = "";
  $level = "";
}

?>

<html>
  <head>
    <title>Admin : HOSTELS @ DTU</title>
    <link href="../stylesheets2/main.css" media="all" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <div id="header">
      <h1>Admin : HOSTELS @ DTU</h1>
    </div>
    <div id="main">
      <center><a href="viewuser.php">&laquo; Back</a></center>
		<h2>Update User</h2>
		<?php if(isset($message)){echo output_message($message); } ?>
		
		<form action="" method="post">
		  <table>
		    <tr>
		      <td>Username:</td>
		      <td>
		        <input type="text" name="username" maxlength="30" value="<?php echo htmlentities($username); ?>" />
		      </td>
		    </tr>
		    <tr>
		      <td>Password:</td>
		      <td>
		        <input type="password" name="password" maxlength="30" value="<?php echo htmlentities($password); ?>" />
		      </td>
		    </tr>
                    <tr>
		      <td>Name:</td>
		      <td>
		        <input type="text" name="name" maxlength="30" value="<?php echo htmlentities($name); ?>" />
		      </td>
		    </tr>
                    <tr>
		      <td>Phone Number:</td>
		      <td>
		        <input type="text" name="phone" maxlength="30" value="<?php echo htmlentities($phone); ?>" />
		      </td>
		    </tr>
		    <tr>
		      <td>User Level:</td>
		      <td>
			<select name="level"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option></select><br />
		      </td>
		    </tr>
		    <tr>
		      <td colspan="2">
		        <input type="submit" name="submit" value="Update" />
		      </td>
		    </tr>
		  </table>
		</form>
    </div>
    <div id="footer">Powered By DWD-DTU, Copyright <?php echo date("Y", time()); ?></div>
  </body>
</html>
<?php if(isset($database)) { $database->close_connection(); }
ob_end_flush();

?>