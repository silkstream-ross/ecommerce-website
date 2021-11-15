<?php
class Form{
    protected $values;
    protected $errors;

    public function __construct() {
        $this->values = [];
        $this->errors = [];
    }

    public function setValues($values) {
        $this->values = $values;
    }

    public function displayValue($field){
        if(isset($this->values[$field])) {
            return htmlentities($this->values[$field]);
        }
        return '';
    }

    public function displayError($field){
        if(isset($this->errors[$field])) {
            return htmlentities($this->errors[$field]);
        }
        return '';
    }

    public function validateText($text){
        if($this->values[$text] === ''){
            $this->errors[$text] = 'Error - field left blank';
        }else{
            $this->errors[$text] = '';
        }
    }

    public function validateEmail($email){
        if($this->values[$email] === ''){
            $this->errors[$email] = 'Error - field left blank';
        }else if(!filter_var($this->values[$email], FILTER_VALIDATE_EMAIL)){
            $this->errors[$email] = 'Error - invalid email';
        }
    }

    public function hasErrors(){
        if(count($this->errors)>0){
            return true;
        }else{
            return false;
        }
    }
}