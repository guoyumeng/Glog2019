<?php

    require "conn.php";
    
    $cid = $_POST['cid'];
    $state = $_POST['state'];


        mysql_query("UPDATE class 
        SET state = '$state' WHERE cid = '$cid'");


    
    
?>