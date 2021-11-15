<?php
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="/css/header.css">
</head>
<body>
<header>
    <h1 class="admin">Admin</h1>
    <a class="link" href="list-users.php">Home</a>
    <a class="link" href="#">Link</a>
    <a class="link" href="#">Link</a>
    <a class="link" href="logout.php">Log Out</a>
    <p class="userMessage">You're logged in as: <?=$_SESSION['user']['username']?></p>
</header>










</body>

</html>
