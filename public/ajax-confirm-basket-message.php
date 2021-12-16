<?php
require "app.php";

if($_POST['quantity']>=1){
    if(!in_array($_POST['product_id'], array_column($_SESSION['basket'], 'id'))){
        array_push($_SESSION['basket'], ['id' => $_POST['product_id'], 'quantity' => $_POST['quantity']]);
    }
}

?>

Added To Basket!

