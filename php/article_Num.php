<?php

    require "conn.php";

    $aid = $_POST['aid'];
    $read_num = $_POST['read_num'];


        mysql_query("UPDATE article 
        SET read_num = '$read_num' WHERE aid = '$aid'");


    
    
?>