<?php

    require "conn.php";

    $aid = $_POST['aid'];
    $class = $_POST['class'];



        if (mysql_query("UPDATE article SET class = '$class' WHERE aid = '$aid'")) {
            echo "OK";
        }
    
        


    
    
?>