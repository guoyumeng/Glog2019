<?php
    require "conn.php";

    
    $coid = $_POST["coid"];
    $item = $_POST["item"];
    $new_num = $_POST["new_num"];

    echo $coid;
    echo $item;
    echo $new_num;


        if (mysql_query("UPDATE comment SET $item = '$new_num' WHERE coid = '$coid'")) {
            echo "OK";
        }

    



    

?>