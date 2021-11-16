<?php

require "app.php";
require "session.php";
include "header.php";


$addProduct = $mysqli->prepare("INSERT INTO products(category_id, name, description, sku, price) VALUES (?, ?, ?, ?, ?)");
$addProduct->bind_param("issss", $category, $name, $description, $sku, $price);

$error = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $test1 = validateForm($_POST["category"]);
    $test2 = validateForm($_POST["name"]);
    $test3 = validateForm($_POST["description"]);
    $test4 = validateForm($_POST["sku"]);
    $test5 = validateForm($_POST["price"]);
    if ($test1 && $test2 && $test3 && $test4 && $test5) {
        $category = $_POST["category"];
        $name = $_POST["name"];
        $description = $_POST["description"];
        $sku = $_POST["sku"];
        $price = $_POST["price"];
        $addProduct->execute();
        $error = "";
    } else {
        $error = "*Error - Invalid data";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/css/form-styles.css">
    <title>Add product</title>
</head>
<body>
<div class="container">
    <h1>Add Product</h1>


    <form method="post">
        <p>Category Number:</p>
        <input type="text" name="category" value="">
        <br>
        <p>Product Name:</p>
        <input type="text" name="name" value="">
        <br>
        <p>Description:</p>
        <input class="descBox" type="text" name="description" value="">
        <br>
        <p>SKU:</p>
        <input type="text" name="sku" value="">
        <br>
        <p>Price:</p>
        <input type="text" name="price" value="">
        <br>
        <br>
        <input type="submit" value="submit">
        <p class="error_message"><?= $error ?></p>
    </form>
</div>


</body>


</html>
