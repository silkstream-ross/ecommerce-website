<?php
require "app.php";
require "session.php";
include "header.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;


$error = "";



if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $test1 = validateForm($_POST["username"]);
    $test2 = validateEmail($_POST["email"]);
    $test3 = validateForm($_POST["firstname"]);
    $test4 = validateForm($_POST["lastname"]);
    $test5 = validateForm($_POST["password"]);
    if($test1 && $test2 && $test3 &&$test4 && $test5){
        $update = $mysqli->prepare("UPDATE users SET username = ?, email = ?, first_name = ?, last_name = ?, password = ? WHERE users_id=?");
        $update->bind_param("sssssi", $newUsername, $newEmail, $newFirstname, $newLastname, $newPassword, $id);
        $newUsername = $_POST["username"];
        $newEmail = $_POST["email"];
        $newFirstname = $_POST["firstname"];
        $newLastname = $_POST["lastname"];
        $newPassword = $_POST["password"];
        $update->execute();
        $error = "";
    }else{
        $error = "*Error - Invalid data";
    }
}

$select = $mysqli->prepare("SELECT * FROM users WHERE users_id=?");
$select->bind_param("i", $id);
$select->execute();
$select->bind_result($id, $username, $email, $firstName, $lastName, $password);
$select->fetch();



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/css/form-styles.css">
    <title>Edit User</title>
</head>
<body>
<div class="container">
<h1>Edit user : <?=$username?></h1>

<form method="post">
    <p>Username:</p>
    <input type="text" name="username" value="<?=$username?>">
    <br>
    <p>Email:</p>
    <input type="text" name="email" value="<?=$email?>">
    <br>
    <p>First Name:</p>
    <input type="text" name="firstname" value="<?=$firstName?>">
    <br>
    <p>Last Name:</p>
    <input type="text" name="lastname" value="<?=$lastName?>">
    <br>
    <p>Password:</p>
    <input type="text" name="password" value="<?=$password?>">
    <br>
    <br>
    <input type="submit" value="submit">
    <p><?=$error?></p>
</form>
</div>
</body>







</html>
