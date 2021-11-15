<?php

?>

<!DOCTYPE html>
<html lang="en-gb">

<head>
    <title>Ecommerce Website</title>
    <link rel="stylesheet" href="css/main.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>


<body>

<header>
    <div class="container">
        <div class="menu_button">
            <a id="menu_button" href="#"><img src="images/menu.svg" height="50" width="50" alt="Menu"></a>
        </div>


        <ul>
            <li><a href="#"><img src="images/Basket.svg" alt="Basket"></a></li>
            <li><a href="#"><img src="images/Search.svg" alt="Search"></a></li>
            <li><a href="#"><img src="images/Profile.svg" alt="Profile"></a></li>
            <li><a href="#">Contact Us </a></li>
            <li><a href="#">Category 2 </a></li>
            <li><a href="#">Category 1 </a></li>
        </ul>


        <ul id="menu" style="z-index: 4">
            <a href="js/main.js"></a>
            <div class="menu_content">
                <a href="#">Category 1</a>
                <a href="#">Category 2</a>
                <a href="#">Contact Us</a>
                <a href="#"><img src="images/Menu_profile.svg" alt="Profile"></a>
                <a href="#"><img src="images/Menu_search.svg" alt="Search"></a>
                <a href="#"><img src="images/Menu_basket.svg" alt="Basket"></a>
                <a class="menu_button" id="close_button" href="#"><img src="images/close.svg" height="50" width="50" alt="Menu"></a>
            </div>
        </ul>

        <div class="Star_image"> <img src="images/Logo.svg" alt="Star"></div>
    </div>
</header>

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
    <div><img src="images/img_1.png" alt="product"><p>Item<br>£5.00<br><button type="button">Add To Basket</button></p></div>
    <div><img src="images/img_1.png" alt="product"><p>Item<br>£5.00<br><button type="button">Add To Basket</button></p></div>
    <div><img src="images/img_1.png" alt="product"><p>Item<br>£5.00<br><button type="button">Add To Basket</button></p></div>
    <div><img src="images/img_1.png" alt="product"><p>Item<br>£5.00<br><button type="button">Add To Basket</button></p></div>
    <div><img src="images/img_1.png" alt="product"><p>Item<br>£5.00<br><button type="button">Add To Basket</button></p></div>
    <div><img src="images/img_1.png" alt="product"><p>Item<br>£5.00<br><button type="button">Add To Basket</button></p></div>
    <div><img src="images/img_1.png" alt="product"><p>Item<br>£5.00<br><button type="button">Add To Basket</button></p></div>
    <div><img src="images/img_1.png" alt="product"><p>Item<br>£5.00<br><button type="button">Add To Basket</button></p></div>
    <div><img src="images/img_1.png" alt="product"><p>Item<br>£5.00<br><button type="button">Add To Basket</button></p></div>
</div>
</div>
<footer>
    <p>Copyright© Star Platinum</p>
</footer>
<script src="js/main.js">
</script>
</body>
</html>

