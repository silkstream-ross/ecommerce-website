<?php
require "../app.php";
require "session.php";


$addQuery = "INSERT INTO users(username, email, first_name, last_name, password) VALUES (?, ?, ?, ?, ?)";
//$addUser->bind_param("sssss", $username, $email, $firstName, $lastName, $password);



$error = "";


if($_SERVER["REQUEST_METHOD"] === "POST"){
    $test1 = validateForm($_POST["username"]);
    $test2 = validateEmail($_POST["email"]);
    $test3 = validateForm($_POST["firstname"]);
    $test4 = validateForm($_POST["lastname"]);
    $test5 = validateForm($_POST["password"]);
    if($test1 && $test2 && $test3 &&$test4 && $test5){
        $username = $_POST["username"];
        $email = $_POST["email"];
        $firstName = $_POST["firstname"];
        $lastName = $_POST["lastname"];
        $password = $_POST["password"];
        $addUser = $db->prepare($addQuery, [$username, $email, $firstName, $lastName, $password]);
        $db->SetHandle($addUser);
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
    <title>Add user</title>
</head>
<body>
<?= include "header.php"; ?>
<div class="container">
<h1>Add User</h1>


<form method="post">
    <p>Username:</p>
    <input type="text" name="username" value="">
    <br>
    <p>Email:</p>
    <input type="text" name="email" value="">
    <br>
    <p>First Name:</p>
    <input type="text" name="firstname" value="">
    <br>
    <p>Last Name:</p>
    <input type="text" name="lastname" value="">
    <br>
    <p>Password:</p>
    <input type="password" name="password" value="">
    <br>
    <br>
    <input type="submit" value="submit">
    <p class="error_message"><?=$error?></p>
</form>
</div>

</body>

</html>
