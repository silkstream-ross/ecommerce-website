<?php
require "../app.php";
$position = isset($_GET['position']) ? (int)$_GET['position'] : 0;
unset($_SESSION['cart'][$position]);





