<?php
    require "conn.php";

    
    $cart_user = $_GET["cart_user"];
    $cart_data = $_GET["cart_data"];

    $result = mysql_query("INSERT INTO cart ( cart_user, cart_data )
                       VALUES
                       ( '$cart_user', '$cart_data' );");



    echo $result;

?>