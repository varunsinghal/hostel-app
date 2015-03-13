<?php

function strip_zeros($marked_string=""){
  //remove marked zeroes
  $no_zeros = str_replace('*0','',$marked_string);
  //remove marks
  $cleaned_string = str_replace('*','',$no_zeros);
  return $cleaned_string;
}

function redirect_to($location = NULL){
  if($location != NULL){
    header("Location:{$location}");
    exit;
  }
}

function refine($input){
  $input = str_replace('_', ' ', $input);
  $input = str_replace('name2', 'name', $input);
  $input = str_replace('recipt', 'hostel roll no', $input);
  $input = str_replace('acc name', 'holder name', $input);
  $input = str_replace('acc', 'account No.', $input);
  $input = str_replace('des', 'designation', $input);
  $input = preg_replace('/add line$/', 'address line', $input);
  $input = preg_replace('/add$/', 'address', $input);
  //$input = str_replace('add', 'address', $input);
  $input = ucwords($input);
  return $input;
}

function output_message($message = ""){
  if(!empty($message)){
    return "<p class=\"message\">Message : {$message}</p>";
  }
  else{
    return "";
  }
}


function __autoload($class_name){
  $class_name = strtolower($class_name);
  $path = LIB_PATH.DS."{$class_name}.php";
  if(file_exists($path)){
    require_once($path);
  } else {
    die("The file {$class_name}.php could not be found.");
  }
}


function include_layout_template($template=""){
  include(SITE_ROOT.DS.'public'.DS.'layouts'.DS.$template);
}


function log_action($action, $message=""){
  $logfile = SITE_ROOT.DS.'logs'.DS.'log.txt';
  $new = file_exists($logfile) ? false : true;
  if($handle = fopen($logfile,'a')){ // append
    $timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
    $content = "{$timestamp} | {$action}: {$message}\r\n";
    fwrite($handle, $content);
    fclose($handle);
    if($new){
      chmod($logfile, 0755);
    }
  } else {
    echo "Could not open log file for writing.<br />";
  }
}



function access_check($user_level="", $page_name="")  // it will return false if access not granted
{
  switch($user_level)
  {
    case 2: {
      // in case of level 2 we will specify what all the user cannot see
      if ( strlen(strstr($page_name, 'viewuser.php'))>0 || strlen(strstr($page_name, 'newuser.php'))>0 || strlen(strstr($page_name, 'updateuser.php'))>0 || strlen(strstr($page_name, 'deleteuser.php'))>0 || strlen(strstr($page_name, 'logfile.php'))>0) {
	return false;
	break;
      }
      else {
	return true;
	break;
      }
    }
    case 3: {
      // in case of level 3 we will specify only allowed places
      if ( strlen(strstr($page_name, '/index.php'))>0 || strlen(strstr($page_name, '/allotedrooms.php'))>0 || strlen(strstr($page_name, '/search.php'))>0 || strlen(strstr($page_name, '/view.php'))>0 || strlen(strstr($page_name, '/add_remark.php'))>0 || strlen(strstr($page_name, '/logout.php'))>0) {
	return true;
	break;
      }
      else {
	return false;
	break;
      }
    }
    case 4: {
      // in case of level 4 we will specify only allowed places
      if ( strlen(strstr($page_name, '/index.php'))>0 || strlen(strstr($page_name, '/allotedrooms.php'))>0 || strlen(strstr($page_name, '/logout.php'))>0) {
	return true;
	break;
      }
      else {
	return false;
	break;
      }
    }
    default: {
      return false;
    }
  }
}


?>
