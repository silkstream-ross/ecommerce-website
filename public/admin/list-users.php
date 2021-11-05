<?php
$mysqli = new mysqli("ecommerce_website_database", "dev_database", "dev_database", "dev_database");
$showUsers = $mysqli->prepare("SELECT * FROM users");

$showUsers->execute();
$showUsers->bind_result($id, $username, $email, $firstName, $lastName, $password);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin</title>
</head>

<body>

<h1>Users</h1>

<table>
    <thead>
    <tr>
        <th>id</th>
        <th>username</th>
        <th>email</th>
        <th>first name</th>
        <th>last name</th>
    </tr>
    </thead>
    <tbody>
    <?php while($showUsers->fetch()): ?>
        <tr>
            <td><?=$id?></td>
            <td><?=$username?></td>
            <td><?=$email?></td>
            <td><?=$firstName?></td>
            <td><?=$lastName?></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>



</body>
</html>


