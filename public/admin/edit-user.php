<?php
require "../app.php";
require "session.php";
include "header.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$updateQuery = "UPDATE users SET username = ?, email = ?, first_name = ?, last_name = ?, password = ? WHERE users_id=?";

$error = "";



if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $test1 = validateForm($_POST["username"]);
    $test2 = validateEmail($_POST["email"]);
    $test3 = validateForm($_POST["firstname"]);
    $test4 = validateForm($_POST["lastname"]);
    $test5 = validateForm($_POST["password"]);
    if($test1 && $test2 && $test3 &&$test4 && $test5){
        $newUsername = $_POST["username"];
        $newEmail = $_POST["email"];
        $newFirstname = $_POST["firstname"];
        $newLastname = $_POST["lastname"];
        $newPassword = $_POST["password"];
        $update = $db->prepare($updateQuery,[$newUsername, $newEmail, $newFirstname, $newLastname, $newPassword, $id]);
        $db->setHandle($update);
        $error = "";
    }else{
        $error = "*Error - Invalid data";
    }
}

$selectQuery = "SELECT * FROM users WHERE users_id=?";
$select = $db->prepare($selectQuery, [$id]);
$user = $db->one($select);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/css/form-styles.css">
    <title>Edit User</title>
</head>
<body>
<div class="container">
<h1>Edit user : <?=$user['username']?></h1>

<form method="post">
    <p>Username:</p>
    <input type="text" name="username" value="<?=$user['username']?>">
    <br>
    <p>Email:</p>
    <input type="text" name="email" value="<?=$user['email']?>">
    <br>
    <p>First Name:</p>
    <input type="text" name="firstname" value="<?=$user['first_name']?>">
    <br>
    <p>Last Name:</p>
    <input type="text" name="lastname" value="<?=$user['last_name']?>">
    <br>
    <p>Password:</p>
    <input type="text" name="password" value="<?=$user['password']?>">
    <br>
    <br>
    <input type="submit" value="submit">
    <p><?=$error?></p>
</form>
</div>
</body>







</html>
