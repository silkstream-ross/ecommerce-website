<?php
require "public/app.php";
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$delete = $mysqli->prepare("DELETE FROM products WHERE product_id=?");
$delete->bind_param("i", $id);
$delete->execute();
