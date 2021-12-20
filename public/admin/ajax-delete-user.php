<?php
require "../app.php";
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$deleteQuery = "DELETE FROM users WHERE users_id=?";
$delete = $db->prepare($deleteQuery, $id);
$db->setHandle($delete);
