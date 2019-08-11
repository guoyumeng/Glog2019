<?php

    require "conn.php";
    
    $aid = $_POST['aid'];
    $state = $_POST['state'];


        mysql_query("UPDATE article 
        SET state = '$state' WHERE aid = '$aid'");


    
    
?>