<?php

    require "conn.php";

    $class_name = $_POST['class_name'];
    $url_name = $_POST['url_name'];
    $now = $_POST['now'];
    $cid = $_POST['cid'] ? $_POST['cid'] : 0;


    if ($now == "add") {
        if (mysql_query("INSERT INTO class (class_name, state, url_name) VALUES ('$class_name', 0, '$url_name')")) {
            echo "OK";
        }
    }elseif ($now == "edit") {
        if (mysql_query("UPDATE class SET class_name = '$class_name',url_name = '$url_name' WHERE cid = '$cid'")) {
            echo "OK";
        }
    } 
        


    
    
?>