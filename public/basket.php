<?php
require 'app.php';

$_SESSION['id'] = 3;

$showBasket = $mysqli->prepare("SELECT name, description, price, img FROM products");
//$showBasket->bind_param("i", $_SESSION['id']);
$showBasket->execute();
$showBasket->bind_result($name, $desc, $price, $img);


//$getPrices = $mysqli->prepare("SELECT price FROM products WHERE price=?");
//$getPrices->bind_param();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Basket</title>
    <link rel="stylesheet" href="css/default.css">
    <?php require 'includes/head-data.php';?>
</head>
<body>
<?php require 'includes/header.php'; ?>
<h1>Your Basket</h1>
<table>
    <thead>
        <tr>
            <th>Product</th>
            <th colspan="2"></th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
    <?php while($showBasket->fetch()): ?>
        <tr>
            <td><img src="/uploads/products/<?=$img?>" width="339" height="425" alt="game-art"></td>
            <td><?=$name?></td>
            <td><?=$desc?></td>
            <td>£<?=$price?></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
    <tfoot>
    <tr>
        <td>Subtotal:</td>
        <td colspan="2"></td>
        <td></td>
    </tr>
    </tfoot>
</table>

<h1><a href="#">Checkout</a></h1>

<footer>
    <p>Copyright© Star Platinum</p>
</footer>

























</body>
<script src="js/main.js"></script>
</html>
