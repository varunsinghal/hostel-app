<?php
// A class to help work with sessions
// In our case to log users in and out

// inadviseable to store DB-related objects in session

class Session
{
  private $logged_in;
  public $user_id;
  public $user_name;
  public $user_level;
  public $terms;
  public $set_terms;
  
  function __construct(){
    session_start();
    $this->check_login();
    if($this->logged_in){
      // actions to do when logged in
      if(isset($this->user_level)){
	if($this->user_level != 1)
	{
	  if(!access_check($this->user_level, $_SERVER['PHP_SELF']))  // false is recieved from access_check if access is not grandet
	  {
	    redirect_to("access_denied.php");
	  }
	}
      }
      else {
	redirect_to("access_denied.php");
      }
    }
    else {
      // actions to do when not logged in
    }
  }
  
  public function is_logged_in(){
    return $this->logged_in;
  }
  
  public function login($user){
    // database will take care of username/password
    if($user){
      $this->user_id = $_SESSION['user_id'] = $user->id;
      $this->user_name = $_SESSION['user_name'] = $user->username;
      $this->user_level = $_SESSION['user_level'] = $user->level;
      $this->logged_in = true;
    }
  }
  
  public function logout(){
    log_action('Logout', "{$this->user_name} logged out.");
    unset($_SESSION['user_id']);
    unset($this->user_id);
    unset($_SESSION['user_name']);
    unset($this->user_name);
    unset($_SESSION['user_level']);
    unset($this->user_level);
    $this->logged_in = false;
  }

  private function check_login(){
    if(isset($_SESSION['user_id']) && isset($_SESSION['user_id'])){
      $this->user_id = $_SESSION['user_id'];
      $this->user_name = $_SESSION['user_name'];
      $this->user_level = $_SESSION['user_level'];
      $this->logged_in = true;
    } else {
      unset($this->user_id);
      unset($this->user_name);
      unset($this->user_level);
      $this->logged_in = false;
    }
  }

  public function terms(){
    if(isset($_SESSION['terms'])){
      if($_SESSION['terms']==1){
        $this->terms = true;
      }
      else{
        $this->terms = false;
      }
    }
    else{
      $this->terms = false;
    }
    return $this->terms;
  }

  public function set_terms($termValue){
    if($termValue==1){
      $_SESSION['terms']=1;
      $this->set_terms = true;
    }
    else{
      $this->set_terms = false;
    }
    return $this->set_terms;
  }

}

$session = new Session();

?>