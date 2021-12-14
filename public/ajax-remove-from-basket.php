<?php
require "app.php";
$position = isset($_GET['position']) ? (int)$_GET['position'] : 0;

if(isset($_SESSION['basket'][$position])){
    unset($_SESSION['basket'][$position]);
    echo 'OK';
} else {
    echo 'FAIL';
}






