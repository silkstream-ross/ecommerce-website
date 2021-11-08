<?php
$mysqli = new mysqli("ecommerce_website_database", "dev_database", "dev_database", "dev_database");


$addUser = $mysqli->prepare("INSERT INTO users(username, email, first_name, last_name, password) VALUES (?, ?, ?, ?, ?)");
$types = "sssss";
$addUser->bind_param($types, $username, $email, $firstName, $lastName, $password);





if($_SERVER["REQUEST_METHOD"] === "POST"){
    $username = $_POST["username"];
    $email = $_POST["email"];
    $firstName = $_POST["firstname"];
    $lastName = $_POST["lastname"];
    $password = $_POST["password"];
    $addUser->execute();
}





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/css/add-user.css">
    <title>Add user</title>
</head>
<body>
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
</form>
<br>
<a href="list-users.php">Return</a>


</div>








</body>






</html>
