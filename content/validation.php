<?php
class Validation{
    protected $errors=[];
    //check the null value
    public function isRequired($field, $value){
        if(empty(trim($value))){
            $this->errors[] ="$field is required";
        }
    }
//check the email format
public function isEmail ($field, $value){
        if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
            $this->errors[] ="$field must be a valid email";
        }
    }
    //check the password format
    public function isMatch($field1,$value1,$field2,$value2){
        if($value1!==$value2){
            $this->errors[] ="$field2 does not match";
        }
    }
    public function isAlphabetic($field1,$value1){
        if(!ctype_alpha(str_replace(' ', '', $value1))){
            $this->errors[] ="$field1 must contain only alphabetic characters";
        }
    }
    public function getErrors() {
        return $this->errors;
    }
    public function hasErrors() {
        return !empty($this->errors);
    }
}
?>