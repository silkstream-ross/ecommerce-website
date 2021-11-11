<?php
session_start();

$_SESSION["firstname"] = "John";
$_SESSION["lastname"] = "phil";

echo $_SESSION["firstname"];
echo "\n" . $_SESSION["lastname"];