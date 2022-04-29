<?php
require "app.php";

$query = "SELECT product_id, name, description, price, img FROM `products`;";
$ShowProducts = $db->prepare($query);
$products = $db->all($ShowProducts);

//$showProducts = $db->prepare("SELECT product_id, name, description, price, img FROM products", "$id, $name, $desc, $price, $img");
//$showProducts->execute();
////$showProducts->bind_result($id, $name, $desc, $price, $img);


?>

<!DOCTYPE html>
<html lang="en-gb">

<head>
    <title>Ecommerce Website</title>
    <?php include "includes/head-data.php"?>
</head>


<body>


<?php include "includes/header.php"?>

<div class="Star_image print"> <img src="images/Logo.svg" alt="Star"></div>
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
    <?php foreach($products as $product){
        ?>
        <div class="product-info"><img src="/uploads/products/<?=$product['img']?>" alt="product" height="422" width="339"><p><?=$product['name']?><br>£<?=$product['price']?><br></p>
        <form method="post" id="add-to-basket">
            <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
            <input type="text" name="quantity" value ="1" class="quantity-field">
            <button type="submit" value="Add To Basket"  class="add-to-basket">Add To Basket</button>
        </form>
        <div id="product-message"></div>
        </div>
    <?php
    }
//    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
////        if($_POST['quantity']>=1){
////            if(!in_array($_POST['product_id'], array_column($_SESSION['basket'], 'id'))){
////                array_push($_SESSION['basket'], ['id' => $_POST['product_id'], 'quantity' => $_POST['quantity']]);
////            }
////        }
//    }
    ?>
</div>

    <div class="about-text">
        <h1>About Us</h1>

        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sagittis vitae et leo duis ut diam quam. Feugiat sed lectus vestibulum mattis ullamcorper velit. Sit amet nisl suscipit adipiscing bibendum est ultricies integer. Eget aliquet nibh praesent tristique magna. Adipiscing bibendum est ultricies integer quis auctor elit sed vulputate. Volutpat odio facilisis mauris sit amet massa vitae. Amet volutpat consequat mauris nunc congue. Maecenas volutpat blandit aliquam etiam erat velit scelerisque in dictum. Orci sagittis eu volutpat odio facilisis. Laoreet suspendisse interdum consectetur libero.

        A condimentum vitae sapien pellentesque habitant. Cursus sit amet dictum sit amet justo donec enim. Amet venenatis urna cursus eget. Quis hendrerit dolor magna eget est lorem ipsum dolor sit. Purus ut faucibus pulvinar elementum integer enim neque volutpat ac. Risus nec feugiat in fermentum posuere urna. Sodales ut eu sem integer vitae justo eget magna fermentum. Cursus mattis molestie a iaculis at erat pellentesque. Aliquam nulla facilisi cras fermentum odio eu feugiat pretium nibh.  </p></div>

</div>

<p class="print">Note: this is a printed page and may not reflect the current state of the website.</p>


<div id="content-block"></div>
<footer>
    <p>Copyright© Star Platinum</p>
</footer>

<script>


     let add_to_basket_btns = document.getElementsByClassName("add-to-basket");
     for (let i = 0; i < add_to_basket_btns.length; i++) {
         add_to_basket_btns[i].addEventListener("click", function (event) {
             event.preventDefault();
             ConfirmBasket(this);
         });
     }

    function ConfirmBasket(element){
        let formData = new FormData(element.form);
        let request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if(request.status === 200){
                element.innerHTML = this.responseText;
            }
        }
        request.open("POST", "ajax-confirm-basket-message.php", true);
        // request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
        request.send(formData);
        for (var pair of formData.entries()) {
            console.log(pair[0]+ ', ' + pair[1]);
        }
    }

</script>
<script src="js/jquery-3.6.0.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>

