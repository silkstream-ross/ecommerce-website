<?php
require "app.php";

$showProducts = $mysqli->prepare("SELECT product_id, name, description, price, img FROM products");
$showProducts->execute();
$showProducts->bind_result($id, $name, $desc, $price, $img);



?>

<!DOCTYPE html>
<html lang="en-gb">

<head>
    <title>Ecommerce Website</title>
    <?php include "includes/head-data.php"?>
</head>


<body>


<?php include "includes/header.php"?>

<div class="container">
<div class="banner" style="position:relative;">
    <img src="images/banner1.png" alt="Banner" class="slide visible">
    <img src="images/banner2.png" alt="Banner" class="slide">
    <img src="images/banner3.png" alt="Banner" class="slide">
</div>
<div class ="banner_arrows">
    <a href="#" class="left_button"><img src="images/arrowLeft.svg" width="50" height="50" alt="arrow"></a>
    <a href="#" class="right_button"><img src ="images/arrowRight.svg" width="50" height="50" alt="arrow"></a>
</div>
<h1>Products</h1>


<div class="flex-container">
    <?php while($showProducts->fetch()): ?>
    <div><img src="/uploads/products/<?=$img?>" alt="product" height="422" width="339"><p><?=$name?><br>£<?=$price?><br><button type="button">Add To Basket</button></p></div>
    <?php endwhile; ?>
</div>
</div>
<footer>
    <p>Copyright© Star Platinum</p>
</footer>
<script src="js/jquery-3.6.0.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>

