<?php
if(!isset($_SESSION['user'])):
    header('Location: /admin/login.php');
    exit();
endif;