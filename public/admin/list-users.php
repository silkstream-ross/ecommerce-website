<?php
require "../app.php";
require "session.php";



$showQuery = "SELECT * FROM users";
$showUsers = $db->prepare($showQuery);
$Users = $db->all($showUsers);


//$deleteRow = $mysqli->prepare("DELETE FROM users WHERE id=?");




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/css/admin.css">
    <title>Admin</title>
</head>

<body>
<?= include "header.php"; ?>
<div class="container">
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
    <?php foreach($Users as $user){ ?>
        <tr>
            <td><?=$user['users_id']?></td>
            <td><?=$user['username']?></td>
            <td><?=$user['email']?></td>
            <td><?=htmlentities($user['first_name'])?></td>
            <td><?=$user['last_name']?></td>
            <td class="editButton"><a href="edit-user.php?id=<?=$user['users_id']?>">Edit</a></td>
            <td class="deleteButton"><input type="button" value="Delete" onclick="deleteRow(this,<?=$user['users_id']?>)" /></td>
        </tr>
    <?php } ?>
        <tr>
            <td colspan="7" class="addButton"><a href="/admin/add-user.php">+ Add User</a></td>
        </tr>
    </tbody>
</table>
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


