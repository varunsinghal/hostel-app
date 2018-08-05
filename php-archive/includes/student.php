
<?php

// if its going to need dtabase then its good to start with require_once.
require_once(LIB_PATH.DS.'database.php');

class Student
{
    
    protected static $fields_academic = array('student_id', 'course', 'roll_no', 'branch', 'sem', 'year_of_admn');
    protected static $fields_permanent_address = array('student_id', 'permanent_add_line', 'permanent_city', 'permanent_state', 'permanent_country', 'permanent_pin', 'permanent_res_phone');
    protected static $fields_present_address = array('student_id', 'present_add_line', 'present_city', 'present_state', 'present_country', 'present_pin', 'present_res_phone');
    protected static $fields_local_guardian= array('student_id', 'lg_name', 'lg_address', 'lg_phone', 'lg_occupation', 'lg_office', 'lg_office_phone');
    protected static $fields_student = array('student_id', 'name', 'gender', 'personal_phone', 'email', 'category_code', 'school', 'recipt', 'blood_group', 'chronic', 'backs', 'file', 'reallot', 'father_name');
    protected static $fields_parent_details = array('student_id', 'father_name2', 'mother_name', 'father_phone', 'father_email', 'father_occupation','father_des', 'father_office_phone', 'mother_phone', 'mother_email', 'mother_occupation','mother_des', 'mother_office_phone', 'father_office_address', 'mother_office_address');
    protected static $fields_distance = array('student_id', 'distance');
    protected static $fields_bank_details= array('student_id','bank_acc_name','bank_code', 'bank_name', 'bank_ifsc', 'bank_acc', 'bank_add');
    protected static $fields_last_yr_details= array('student_id', 'last_room', 'last_sr1', 'last_sr2');
    protected static $fields_docu_submission = array('student_id', 'document');

   
    protected static $table_fieldlist = array(
        'academic'          => 'fields_academic',
        'permanent_address' => 'fields_permanent_address',
        'present_address'   => 'fields_present_address',
        'local_guardian'    => 'fields_local_guardian',
        'student'           => 'fields_student',
        'parent_details'    => 'fields_parent_details',
        'distance_from_home'=> 'fields_distance',
        'bank_details'      => 'fields_bank_details',
        'last_yr_details'   => 'fields_last_yr_details',
        'docu_submission'   => 'fields_docu_submission'

    );
    
    // decleration of objects
    public $student_id;
    public $name;
    public $gender;
    public $father_name;
    public $mother_name;
    public $personal_phone;
    public $email;
    public $category_code;
    public $school;
    public $recipt;
    public $blood_group;
    public $chronic;
	public $file;
    public $reallot;
	public $father_name2;
    public $course;
    public $roll_no;
    public $branch;
    public $sem;
    public $year_of_admn;
    public $backs;
    public $bank_name;
    public $bank_ifsc;
    public $bank_acc;
	public $bank_code;
	public $bank_add;
	public $bank_acc_name;
    public $father_phone;
    public $father_email;
    public $father_occupation;
	public $father_des;
	public $father_office_address;
    public $father_office_phone;
    public $mother_phone;
    public $mother_email;
    public $mother_occupation;
	public $mother_des;
	public $mother_office_address;
    public $mother_office_phone;
    public $permanent_add_line;
    public $permanent_city;
    public $permanent_state;
    public $permanent_country;
    public $permanent_pin;
    public $permanent_res_phone;
    public $present_add_line;
    public $present_city;
    public $present_state;
    public $present_country;
    public $present_pin;
    public $present_res_phone;
    public $lg_name;
    public $lg_address;
    public $lg_phone;
    public $lg_occupation;
	public $lg_office;
	public $lg_office_phone;
    public $distance;
    public $document;
    public $last_room;
    public $last_sr1;
    public $last_sr2;


    
    //---------------- Common Database methods -----------------------------
    
    public static function find_by_id($id = 0,$table_name){
        global $database;
        $result_array = self::find_by_sql("SELECT * FROM ".$table_name." WHERE student_id={$id} LIMIT 1", $table_name);
        return !empty($result_array) ? array_shift($result_array) : false;
    }
    public static function find_by_condition($condition, $table_name){
        global $database;
        $result_array = self::find_by_sql("SELECT * FROM ".$table_name." WHERE ".$condition, $table_name);
        return !empty($result_array) ? array_shift($result_array) : false;
    }
    public static function find_by_sql($sql = "", $table_name){
        global $database;
        $result_set = $database->query($sql);
        $object_array = array();
        while($row = $database->fetch_array($result_set)){
            $object_array[] = self::instantiate($row, self::${self::$table_fieldlist[$table_name]});
        }
        return $object_array;
    }
    
    private function has_attribute($attribute, $field_name){
        // get_object_vars returns an associative array with all attributes
        $object_vars = $this->attributes($field_name);
        // we dont care about value, just see that if it exists or not.
        return array_key_exists($attribute, $object_vars);
    }
    
    private static function instantiate($record, $field_name){
        $object = new self;
        $object_array = array();
        // $object->id          = $record['id'];
        // $object->username    = $record['username'];
        // $object->password    = $record['password'];
        // $object->first_name  = $record['first_name'];
        // $object->last_name   = $record['last_name'];
        // check that record exists in array
        foreach ($record as $attribute=>$value){
            if($object->has_attribute($attribute, $field_name)){
                $object_array[$attribute] = $value;
            }
        }
        return $object_array;
    }
  
    protected function attributes($field_name){
        // return array of attribute key and attributes
        global $database;
        $attributes = array();
        foreach($field_name as $field){
            $attributes[$field] = $database->escape_value($this->$field);
        }
        return $attributes;
    }
    
    public function save(){
        // for student table
        $table_name = "student";
        if(!self::find_by_condition("name='{$this->name}' AND ( personal_phone='{$this->personal_phone}' )", $table_name)){
            $this->create($table_name, self::$fields_student);
        } else {
            $this->create($table_name, self::$fields_student);
        //    $temp = self::find_by_condition("name='{$this->name}' AND ( father_name='{$this->father_name}' OR personal_phone='{$this->personal_phone}' )", $table_name);
        //    $this->student_id = $temp['student_id'];
        //    $this->update($table_name, self::$fields_student);
        }

        // for parent_details table
        $table_name = "parent_details";
        if(!self::find_by_id($this->student_id, $table_name)){
            $this->create($table_name, self::$fields_parent_details);
        } else {
            $this->update($table_name, self::$fields_parent_details);
        }
        // for academic table
        $table_name = "academic";
        if(!self::find_by_id($this->student_id, $table_name)){
            $this->create($table_name, self::$fields_academic);
        } else {
            $this->update($table_name, self::$fields_academic);
        }
        
        // for present address table
        $table_name = "present_address";
        if(!self::find_by_id($this->student_id, $table_name)){
            $this->create($table_name, self::$fields_present_address);
        } else {
            $this->update($table_name, self::$fields_present_address);
        }
        
        // for permanent address table
        $table_name = "permanent_address";
        if(!self::find_by_id($this->student_id, $table_name)){
            $this->create($table_name, self::$fields_permanent_address);
        } else {
            $this->update($table_name, self::$fields_permanent_address);
        }
        // for local_guardian table
        $table_name = "local_guardian";
        if(!self::find_by_id($this->student_id, $table_name)){
            $this->create($table_name, self::$fields_local_guardian);
        } else {
            $this->update($table_name, self::$fields_local_guardian);
        }
        // for distance table
        $table_name = "distance_from_home";
        if(!self::find_by_id($this->student_id, $table_name)){
            $this->create($table_name, self::$fields_distance);
        } else {
            $this->update($table_name, self::$fields_distance);
        }
        // for bank_details table
        $table_name = "bank_details";
        if(!self::find_by_id($this->student_id, $table_name)){
            $this->create($table_name, self::$fields_bank_details);
        } else {
            $this->update($table_name, self::$fields_bank_details);
        }
        // for last_yr_details table
        $table_name = "last_yr_details";
        if(!self::find_by_id($this->student_id, $table_name)){
            $this->create($table_name, self::$fields_last_yr_details);
        } else {
            $this->update($table_name, self::$fields_last_yr_details);
        }
        // for docu_submission table
        $table_name = "docu_submission";
        if(!self::find_by_id($this->student_id, $table_name)){
            $this->create($table_name, self::$fields_docu_submission);
        } else {
            $this->update($table_name, self::$fields_docu_submission);
        }
        return true;
    }
    
    
    public function save_by_admin($id_recieved){
        // for student table
        $table_name = "student";
        if(!self::find_by_condition("name='{$this->name}' AND ( personal_phone='{$this->personal_phone}' )", $table_name)){
            $this->create($table_name, self::$fields_student);
        } else {
            $temp = self::find_by_condition("student_id='{$id_recieved}'", $table_name);
            $this->student_id = $temp['student_id'];
            $this->update($table_name, self::$fields_student);
        }
        // for parent_details table
        $table_name = "parent_details";
        if(!self::find_by_id($this->student_id, $table_name)){
            $this->create($table_name, self::$fields_parent_details);
        } else {
            $this->update($table_name, self::$fields_parent_details);
        }
        // for academic table
        $table_name = "academic";
        if(!self::find_by_id($this->student_id, $table_name)){
            $this->create($table_name, self::$fields_academic);
        } else {
            $this->update($table_name, self::$fields_academic);
        }
        
        // for present address table
        $table_name = "present_address";
        if(!self::find_by_id($this->student_id, $table_name)){
            $this->create($table_name, self::$fields_present_address);
        } else {
            $this->update($table_name, self::$fields_present_address);
        }
        
        // for permanent address table
        $table_name = "permanent_address";
        if(!self::find_by_id($this->student_id, $table_name)){
            $this->create($table_name, self::$fields_permanent_address);
        } else {
            $this->update($table_name, self::$fields_permanent_address);
        }
        // for local_guardian table
        $table_name = "local_guardian";
        if(!self::find_by_id($this->student_id, $table_name)){
            $this->create($table_name, self::$fields_local_guardian);
        } else {
            $this->update($table_name, self::$fields_local_guardian);
        }
        // for distance table
        $table_name = "distance_from_home";
        if(!self::find_by_id($this->student_id, $table_name)){
            $this->create($table_name, self::$fields_distance);
        } else {
            $this->update($table_name, self::$fields_distance);
        }
        // for bank_details table
        $table_name = "bank_details";
        if(!self::find_by_id($this->student_id, $table_name)){
            $this->create($table_name, self::$fields_bank_details);
        } else {
            $this->update($table_name, self::$fields_bank_details);
        }
        // for last_yr_details table
        $table_name = "last_yr_details";
        if(!self::find_by_id($this->student_id, $table_name)){
            $this->create($table_name, self::$fields_last_yr_details);
        } else {
            $this->update($table_name, self::$fields_last_yr_details);
        }
        // for docu_submission table
        $table_name = "docu_submission";
        if(!self::find_by_id($this->student_id, $table_name)){
            $this->create($table_name, self::$fields_docu_submission);
        } else {
            $this->update($table_name, self::$fields_docu_submission);
        }
        return true;
    }
    
    public function create($table_name="",$table_field=""){
        global $database;
        $attributes = $this->attributes($table_field);
        if($table_name == "student"){
            array_shift($attributes);
            $sql = "INSERT INTO ".$table_name. " (".join(", ", array_keys($attributes)).") VALUES ('".join("', '", array_values($attributes))."')";
            if($database->query($sql)){
                $this->student_id = $database->insert_id();
                return true;
            }
            else {
                return false;
            }
        } else {
            $attributes = $this->attributes($table_field);
            $sql = "INSERT INTO ".$table_name. " (".join(", ", array_keys($attributes)).") VALUES ('".join("', '", array_values($attributes))."')";
            if($database->query($sql)){
                return true;
            } else {
                return false;
            }
        }
    }
    
    public function update($table_name="",$table_field=""){
        global $database;
        $attributes = $this->attributes($table_field);
        $attribute_pairs = array();
        foreach($attributes as $key => $value){
            $attribute_pairs[] = "{$key} = '{$value}'";
        }
        $sql = "UPDATE ".$table_name." SET ".join(",", $attribute_pairs)." WHERE student_id = '".$database->escape_value($this->student_id)."'";
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }
    
    public function delete($table_name="",$table_field=""){
        global $database;
        $attributes = $this->attributes($table_field);
        $attribute_pairs = array();
        foreach($attributes as $key => $value){
            $attribute_pairs[] = "{$key} = '{$value}'";
        }
        $sql = "DELETE FROM ".self::$table_name." WHERE id=".$database->escape_value($this->id)." LIMIT 1";
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }
    
}

?>
