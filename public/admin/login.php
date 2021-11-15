<?php
require "app.php";


$validation_message = "";


if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $testLogin = validateLogin($_POST["username"], $_POST["password"]);
    if($testLogin === true){
        $validation_message =  "Login successful";
        header("Location: list-users.php");
        exit();
    }else{
        $validation_message = "Wrong username or password";
    }
}


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
<form method="post">
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
    <p><?=$validation_message?></p>
</form>
</div>
</body>













</html>
