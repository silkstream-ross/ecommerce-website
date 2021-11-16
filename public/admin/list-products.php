<?php
require "app.php";
require "session.php";
include "header.php";



$showProducts = $mysqli->prepare("SELECT * FROM products");
$showProducts->execute();
$showProducts->bind_result($id, $category, $name, $description, $sku, $price);
$deleteRow = $mysqli->prepare("DELETE FROM products WHERE id=?");




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/css/admin.css">
    <title>Admin</title>
</head>

<body>
<div class="container">
    <h1>Products</h1>
<h2>All Products</h2>
<table id="usersTable">
    <thead>
    <tr>
        <th>Id</th>
        <th>Category Id</th>
        <th>Product name</th>
        <th>Description</th>
        <th>SKU</th>
        <th>Price</th>
        <th></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php while($showProducts->fetch()): ?>
        <tr>
            <td><?=$id?></td>
            <td><?=htmlentities($category)?></td>
            <td><?=htmlentities($name)?></td>
            <td><?=htmlentities($description)?></td>
            <td><?=htmlentities($sku)?></td>
            <td><?=htmlentities($price)?></td>
            <td class="editButton"><a href="edit-product.php?id=<?=$id?>">Edit</a></td>
            <td class="deleteButton"><input type="button" value="Delete" onclick="deleteRow(this,<?=$id?>)" /></td>
        </tr>
    <?php endwhile; ?>
        <tr>
            <td colspan="8" class="addButton"><a href="/admin/add-product.php">+ Add User</a></td>
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
        request.open("GET", "ajax-delete-product.php?id="+id, true);
        request.send();
    }
</script>


</body>
</html>


