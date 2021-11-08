<?php
$mysqli = new mysqli("ecommerce_website_database", "dev_database", "dev_database", "dev_database");
$showUsers = $mysqli->prepare("SELECT * FROM users");

$showUsers->execute();
$showUsers->bind_result($id, $username, $email, $firstName, $lastName, $password);
$showUsers->fetch();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit User</title>
</head>
<body>
<h1>Edit user</h1>
<h2><?=$username?></h2>
</body>







</html>
