<?php
require "link-database.php";

$select = $mysqli->prepare("SELECT * FROM users WHERE users_id=?");
$select->bind_param("i", $_GET['id']);

$update = $mysqli->prepare("UPDATE users SET username = ?, email = ?, first_name = ?, last_name = ?, password = ? WHERE users_id=?");
$update->bind_param("sssssi", $newUsername, $newEmail, $newFirstname, $newLastname, $newPassword, $id);


$select->execute();
$select->bind_result($id, $username, $email, $firstName, $lastName, $password);
$select->fetch();

$error = "";

function validateForm($data){
    $invalid_data = "";
    if($data === $invalid_data){
        return FALSE;
    }else{
        return TRUE;
    }
}


if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $test1 = validateForm($_POST["username"]);
    $test2 = validateForm($_POST["email"]);
    $test3 = validateForm($_POST["firstname"]);
    $test4 = validateForm($_POST["lastname"]);
    $test5 = validateForm($_POST["password"]);
    if($test1 && $test2 && $test3 &&$test4 && $test5){
        $newUsername = $_POST["username"];
        $newEmail = $_POST["email"];
        $newFirstName = $_POST["firstname"];
        $newLastName = $_POST["lastname"];
        $newPassword = $_POST["password"];
        $update->execute();
        $error = "";
    }else{
        $error = "*Error - Invalid data";
    }
}




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
    <input type="text" value="<?=$username?>">
    <br>
    <p>Email:</p>
    <input type="text" value="<?=$email?>">
    <br>
    <p>First Name:</p>
    <input type="text" value="<?=$firstName?>">
    <br>
    <p>Last Name:</p>
    <input type="text" value="<?=$lastName?>">
    <br>
    <p>Password:</p>
    <input type="text" value="<?=$password?>">
    <br>
    <br>
    <input type="submit" value="submit">
    <p><?=$error?></p>
</form>
<br>
<a href="list-users.php">Return</a>
</div>
</body>







</html>
