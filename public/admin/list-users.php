<?php
session_start();
require "link-database.php";

if(!isset($_SESSION['user'])):
    header('Location: /admin/login.php');
    exit();
endif;


$showUsers = $mysqli->prepare("SELECT * FROM users");
$showUsers->execute();
$showUsers->bind_result($id, $username, $email, $firstName, $lastName, $password);
$deleteRow = $mysqli->prepare("DELETE FROM users WHERE id=?");




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/css/admin.css">
    <title>Admin</title>
</head>

<body>
<div class="container">
    <?php if(isset($_SESSION['user'])): ?>
<p>You're logged in as: <?=$_SESSION['user']['username']?></p>
    <?php endif ?>
    <h1>Users</h1>
<h2>All users</h2>
<table id="usersTable">
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
            <td class="editButton"><a href="edit-user.php?id=<?=$id?>">Edit</a></td>
            <td class="deleteButton"><input type="button" value="Delete" onclick="deleteRow(this,<?=$id?>)" /></td>
        </tr>
    <?php endwhile; ?>
        <tr>
            <td colspan="7" class="addButton"><a href="/admin/add-user.php">+ Add User</a></td>
        </tr>
    </tbody>
</table>
    <br>
    <a href="/admin/logout.php" class="logOut">Log Out</a>
</div>

<script>
    function deleteRow(btn, id) {
        let request = new XMLHttpRequest();
        request.onreadystatechange = function(){
            if (request.readyState === XMLHttpRequest.DONE){
                if(request.status === 200){
                    let row = btn.parentNode.parentNode;
                    row.parentNode.removeChild(row);
                }else{
                    alert("Something went wrong.");
                }
            }
        };
        request.open("GET", "ajax-delete-user.php?id="+id, true);
        request.send();
    }
</script>


</body>
</html>


