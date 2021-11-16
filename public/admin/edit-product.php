<?php

require "app.php";
require "session.php";
include "header.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;


$error = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $test1 = validateForm($_POST["category"]);
    $test2 = validateForm($_POST["name"]);
    $test3 = validateForm($_POST["description"]);
    $test4 = validateForm($_POST["sku"]);
    $test5 = validateForm($_POST["price"]);
    if ($test1 && $test2 && $test3 && $test4 && $test5) {
        $update = $mysqli->prepare("UPDATE products SET category_id = ?, name = ?, description = ?, sku = ?, price = ? WHERE product_id=?");
        $update->bind_param("issssi", $newCategory, $newName, $newDesc, $newSKU, $newPrice, $id);
        $newCategory = $_POST["category"];
        $newName = $_POST["name"];
        $newDesc = $_POST["description"];
        $newSKU = $_POST["sku"];
        $newPrice = $_POST["price"];
        $update->execute();
        $error = "";
    } else {
        $error = "*Error - Invalid data";
    }
}

$select = $mysqli->prepare("SELECT * FROM products WHERE product_id=?");
$select->bind_param("i", $id);
$select->execute();
$select->bind_result($id, $category, $name, $description, $sku, $price);
$select->fetch();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/css/form-styles.css">
    <title>Edit Product</title>
</head>
<body>
<div class="container">
    <h1>Edit product : <?= $name ?></h1>

    <form method="post">
        <p>Category Number:</p>
        <input type="text" name="category" value="<?= $category ?>">
        <br>
        <p>Name:</p>
        <input type="text" name="name" value="<?= $name ?>">
        <br>
        <p>Description:</p>
        <input type="text" name="description" value="<?= $description ?>">
        <br>
        <p>SKU:</p>
        <input type="text" name="sku" value="<?= $sku ?>">
        <br>
        <p>Price:</p>
        <input type="text" name="price" value="<?= $price ?>">
        <br>
        <br>
        <input type="submit" value="submit">
        <p><?= $error ?></p>
    </form>
</div>
</body>
<!--need to create a form element-->
<!--allow user to upload file-->
<!--need to understand $_FILES-->
<!--pretty sure need new row in products table for an image path-->
<!--store image in separate page-->
<!--user home.php to query the image path for each product-->

</html>
