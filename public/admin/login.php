<?php
require "link-database.php";
$checkData = $mysqli->prepare("SELECT * FROM users WHERE username=?, password=?");


?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/css/login.css">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <title>Login</title>
</head>
<body>
<div class="container">
<h1>Ecommerce Website</h1>
<form method="post" action="list-users.php">
    <i class="fa fa-user icon"></i>
    <input id="usernameField" type="text" name="username" placeholder="Username" required>
    <br>
    <br>
    <div class="passwordField">
        <i class="fa fa-key icon"></i>
        <input type="password" name="password" placeholder="Password" required>
    </div>
    <br>
    <input type="submit" value="Sign In">
</form>
</div>
</body>













</html>
