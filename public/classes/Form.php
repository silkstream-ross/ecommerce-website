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

    public function validateText($field){
        if($this->values[$field] === ''){
            $this->errors[$field] = 'Error - field left blank';
        }else{
            $this->errors[$field] = '';
        }
    }

    public function validateEmail($field){
        if($this->values[$field] === ''){
            $this->errors[$field] = 'Error - field left blank';
        }else if(!filter_var($this->values[$field], FILTER_VALIDATE_EMAIL)){
            $this->errors[$field] = 'Error - invalid email';
        }
    }

    public function hasErrors(){
        return empty($this->errors);
    }
}