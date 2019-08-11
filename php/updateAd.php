<?php
    require "conn.php";

    
    $cart_user = $_GET["cart_user"];
    $cart_data = $_GET["cart_data"];

    $result = mysql_query("UPDATE `cart` SET cart_data='$cart_data' WHERE cart_user='$cart_user';");



    echo $result;

?>