<?php

// if its going to need dtabase then its good to start with require_once.
require_once(LIB_PATH.DS.'database.php');

class User extends DatabaseObject
{
  protected static $table_name = "users";
  protected static $db_fields = array('id','username','password','name','phone');
  public $id;
  public $username;
  public $level;
  public $password;
  public $name;
  public $phone;

  public function full_name(){
    if(isset($this->first_name) && ($this->last_name)){
      return $this->first_name." ".$this->last_name;
    } else {
      return "";
    }
  }
  
  public static function get_user_level($username=""){
    global $database;
    $sql = "SELECT level FROM users WHERE username = '{$username}' LIMIT 1";
    $result_set = $database->query($sql);
    while($row = $database->fetch_array($result_set)){
      $object = $row['level'];
    }
    return !(empty($object)) ? $object : false;
  }
  
  
  public static function authenticate($username="",$password=""){
    global $database;
    $username = $database->escape_value($username);
    $password = $database->escape_value($password);

    $sql = "SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' LIMIT 1";
    $result_array = self::find_by_sql($sql);
    return !(empty($result_array)) ? array_shift($result_array) : false;
  }

//------------------------------------------ Common Database Methods--------------------------------------


  public static function find_all(){
    return self::find_by_sql("SELECT * FROM ".self::$table_name);
  }
  public static function find_by_id($id = 0){
    global $database;
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id={$id} LIMIT 1");
    return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function find_by_sql($sql = ""){
    global $database;
    $result_set = $database->query($sql);
    $object_array = array();
    while($row = $database->fetch_array($result_set)){
      $object_array[] = self::instantiate($row);
    }
    return $object_array;
  }
  private static function instantiate($record){
    $object = new self;
    // $object->id          = $record['id'];
    // $object->username    = $record['username'];
    // $object->password    = $record['password'];
    // $object->first_name  = $record['first_name'];
    // $object->last_name   = $record['last_name'];
    // check that record exists in array
    foreach ($record as $attribute=>$value){
      if($object->has_attribute($attribute)){
        $object->$attribute = $value;
      }
    }
    return $object;
  }
  private function has_attribute($attribute){
    // get_object_vars returns an associative array with all attributes
    $object_vars = $this->attributes();
    // we dont care about value, just see that if it exists or not.
    return array_key_exists($attribute, $object_vars);
  }

  protected function attributes(){
    // return array of attribute key and attributes
    $attribues = array();
    foreach(self::$db_fields as $field){
      if(property_exists($this,$field)){
        $attributes[$field] = $field;
      }
    }
    return get_object_vars($this);
  }
  
  protected function sanatized_attributes(){
    global $database;
    $clean_attributes = array();
    // sanitize the values before submitting
    // do not alter actual value for each attribute
    foreach($this->attributes() as $key => $value){
      $clean_attributes[$key] = $database->escape_value($value);
    }
    return $clean_attributes;
  }

  public function save(){
    return isset($this->id) ? $this->update() : $this->create();
  }
  
  public function create(){
    global $database;
    $attributes = $this->sanatized_attributes();
    $sql = "INSERT INTO ".self::$table_name." (".join(", ", array_keys($attributes)).") VALUES('".join("', '",array_values($attributes))."')";
    if($database->query($sql)){
      $this->id = $database->insert_id();
      return true;
    } else {
      return false;
    }
  }

  public function update(){
    global $database;
    $attributes = $this->sanatized_attributes();
    $attribute_pairs = array();
    foreach($attributes as $key => $value){
      $attribute_pairs[] = "{$key} = '{$value}'";
    }
    $sql = "UPDATE ".self::$table_name." SET ".join(",", $attribute_pairs)." WHERE id = '".$database->escape_value($this->id)."'";
    $database->query($sql);
    return ($database->affected_rows() == 1) ? true : false;
  }

  public function delete(){
    global $database;
    $sql = "DELETE FROM ".self::$table_name." WHERE id=".$database->escape_value($this->id)." LIMIT 1";
    $database->query($sql);
    return ($database->affected_rows() == 1) ? true : false;
  }
}

?>