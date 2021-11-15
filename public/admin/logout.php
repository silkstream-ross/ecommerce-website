<?php
require 'app.php';
unset($_SESSION['user']);
header('Location: /admin/login.php');
exit();