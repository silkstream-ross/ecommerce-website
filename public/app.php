<?php
session_start();
error_reporting(E_ALL);
define('ABSOLUTE_DIR',__DIR__);
mysqli_report(MYSQLI_REPORT_ERROR);
//$mysqli = new mysqli("ecommerce_website_database", "dev_database", "dev_database", "dev_database");

require 'classes/DatabaseConnection.php';

Silkstream\EreborClay\Core\DatabaseConnection::pushConnection('ecommerce_website_database', 'dev_database', "dev_database", "dev_database", "dev_database");

$db = new Silkstream\EreborClay\Core\DatabaseConnection('dev_database');

if (!isset($_SESSION['basket'])) {
    $_SESSION['basket'] = [];
}


function validateForm($data){
    $invalid_data = "";
    if($data === $invalid_data){
        return FALSE;
    }else{
        return TRUE;
    }
}


function validateEmail($data){
    if(filter_var($data, FILTER_VALIDATE_EMAIL)){
        return TRUE;
    }else{
        return FALSE;
    }

}

function validateLogin($username, $password){
    $mysqli = new mysqli("ecommerce_website_database", "dev_database", "dev_database", "dev_database");
    $filterUsername = filter_var($username, FILTER_SANITIZE_STRING);
    $filterPassword = filter_var($password, FILTER_SANITIZE_STRING);
    $checkData = $mysqli->prepare("SELECT users_id, username, password FROM users WHERE username=? and password=?");
    $checkData->bind_param("ss",$filterUsername, $filterPassword);
    $checkData->execute();
    $checkData->bind_result( $dbId, $dbUsername, $dbPassword);
    $checkData->fetch();
    if($filterUsername === $dbUsername && $filterPassword === $dbPassword){
        $_SESSION['user'] = [
            'id' => $dbId,
            'username' => $dbUsername
        ];
        return true;
    }else{
        return false;
    }

}



