<?php
require 'app.php';

$subtotal = 0;
$showBasket = $mysqli->prepare("SELECT name, description, price, img FROM products WHERE product_id=?");
//$showBasket = $mysqli->prepare("SELECT name, description, price, img FROM products WHERE product_id=?");
//$showBasket->bind_param("i", $_SESSION['id']);
//$showBasket->execute();
//$showBasket->bind_result($name, $desc, $price, $img);
//

//$getPrices = $mysqli->prepare("SELECT price FROM products WHERE price=?");
//$getPrices->bind_param();
//var_dump($_SESSION['basket']);
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
            <th>Quantity</th>
            <th>Price</th>
            <th></th>
        </tr>
    </thead>
    <tbody id="basket-body">
    <?php
    foreach($_SESSION['basket'] as $key => $product){
        $showBasket->bind_param("i", $_SESSION['basket'][$key][0]);
        $showBasket->execute();
        $showBasket->bind_result($name, $desc, $price, $img);

        $showBasket->fetch();
        $showBasket->free_result();
        $quantity = $_SESSION['basket'][$key][1];
        ?>
        <tr>
            <td><img src="/uploads/products/<?=$img?>" width="339" height="425" alt="game-art"></td>
            <td><?=$name?></td>
            <td><?=$desc?></td>
            <td><?=$quantity?></td>
            <td>£<?=$price*=$quantity?></td>
            <td><button onclick="removeFromBasket(this, <?= $key ?>)">Remove</button></td>
        </tr>
    <?php
        $subtotal += $price;
    } ?>
    </tbody>
    <tfoot>
    <tr>
        <td>Subtotal:</td>
        <td colspan="3"></td>
        <td>£<?= $subtotal ?></td>
        <td></td>
    </tr>
    </tfoot>
</table>

<h1><a href="#">Checkout</a></h1>

<footer>
    <p>Copyright© Star Platinum</p>
</footer>

<script>
    function removeFromBasket(btn, position) {
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
        request.open("GET", "ajax-remove-from-basket.php?position="+position, true);
        request.send();
    }
</script>









</body>
<script src="js/main.js"></script>
</html>