<?php

require_once("../../includes/initialize.php");

if($session->is_logged_in()){
  redirect_to("index.php");
}

// remember to give ur form's submit tag a name submit attribute


if(isset($_POST['submit'])){  // form has been submitted
  $username = trim($_POST['username']);
  $password = md5(trim($_POST['password']));

  // check db to see if username/password exists
  $found_user = User::authenticate($username,$password);

  
  if($found_user){
    $session->login($found_user);
    log_action('Login', "{$found_user->username} logged in (IP : {$_SERVER['REMOTE_ADDR']}).");
    redirect_to("index.php");
  } else {
    $message = "Incorrect username/password combination";
    log_action('Failed Login Attempt', "Failed login attempt by IP : {$_SERVER['REMOTE_ADDR']}.");
  }
} else { // form not submitted
  $username = "";
  $password = "";
}

?>

<html>
  <head>
    <title>Admin : HOSTELS @ DTU</title>
  </head>
  <body style="background-color: #036;">
    <div id="header">
    </div>
    <div id="main">
		<div style="position: fixed; top:2px;text-align:center;"><center style=" font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#FFFFFF;"><?php if(isset($message)){echo output_message($message); } ?></center></div>
		<form action="login.php" method="post">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="">
   <tbody><tr>
      <td height="600" style="vertical-align: middle;">
      <center style=" font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#FFFFFF;">Staff Login</center><br />
	  <table width="30%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px solid #FFFFFF">
         <tbody><tr>
            <td height="8" colspan="2"></td>
         </tr>
         <tr>
            <td width="35%" height="25" style=" font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#FFFFFF; padding-left:15px">User Name</td>
            <td>	 
			<input type="text" name="username" maxlength="30" style="border:1px solid #0099FF; font-family:Arial, Helvetica, sans-serif; font-size:10px;; width:180px" size="25" onclick="this.value=''" value="-- Login Name --"></td>
         </tr>
         <tr>
            <td height="25" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#FFFFFF; padding-left:15px">Password</td>
            <td>
			<input type="password" name="password" style="border:1px solid #0099FF; font-family:Arial, Helvetica, sans-serif; font-size:10px;; width:180px" size="25" value=""></td>
         </tr>
         <tr>
            <td height="25">&nbsp;</td>
            <td><label>
               <input type="submit" name="submit" value="Login" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; border:none; color:#000000" />  
            </label>&nbsp;<button type="button" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; border:none; color:#000000" onclick="window.location='http://hostels.dtu.ac.in'">Home</button></td>
         </tr>
         <tr>
            <td height="8" colspan="2"></td>
            </tr>
      </tbody></table></td>
   </tr>
</tbody></table>
</form>

    <div id="footer" style="position:fixed; bottom : 15px;font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#FFFFFF; padding-left:15px">&copy; Copyright <?php echo date("Y", time()); ?>, DWD - DTU</div>
  </body>
</html>
<?php if(isset($database)) { $database->close_connection(); } ?>