<?php
require "../app.php";
require "session.php";




$showQuery = "SELECT * FROM products";
$showProducts = $db->prepare($showQuery);
$products = $db->all($showProducts);
//$deleteRow = $mysqli->prepare("DELETE FROM products WHERE id=?");




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/css/admin.css">
    <title>Admin</title>
</head>

<body>

<?=include "header.php"; ?>

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
    <?php foreach($products as $product){ ?>
        <tr>
            <td><?=$product['product_id']?></td>
            <td><?=htmlentities($product['category_id'])?></td>
            <td><?=htmlentities($product['name'])?></td>
            <td><?=htmlentities($product['description'])?></td>
            <td><?=htmlentities($product['sku'])?></td>
            <td><?=htmlentities($product['price'])?></td>
            <td class="editButton"><a href="edit-product.php?id=<?=$product['product_id']?>">Edit</a></td>
            <td class="deleteButton"><input type="button" value="Delete" onclick="deleteRow(this,<?=$product['product_id']?>)" /></td>
        </tr>
    <?php } ?>
        <tr>
            <td colspan="8" class="addButton"><a href="/admin/add-product.php">+ Add Product</a></td>
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


