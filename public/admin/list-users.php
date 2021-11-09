<?php
$mysqli = new mysqli("ecommerce_website_database", "dev_database", "dev_database", "dev_database");
$showUsers = $mysqli->prepare("SELECT * FROM users");
$showUsers->execute();
$showUsers->bind_result($id, $username, $email, $firstName, $lastName, $password);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/css/admin.css">
    <title>Admin</title>
</head>

<body>
<div class="container">
<h1>Users</h1>
<h2>All users</h2>
<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>Username</th>
        <th>Email</th>
        <th>First name</th>
        <th>last name</th>
        <th></th>
        <th></th>
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
            <td class="editButton"><a href="edit-user.php" >Edit</a></td>
            <td class="deleteButton"><a href="list-users.php" onclick="">Delete</a></td>
        </tr>
    <?php endwhile; ?>
        <tr>
            <td colspan="7" class="addButton"><a href="/admin/add-user.php">+ Add User</a></td>
        </tr>
    </tbody>
</table>
</div>


</body>
</html>


