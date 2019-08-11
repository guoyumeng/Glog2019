<?php

    require "conn.php";
    
    $uid = $_POST['uid'];
    $state = $_POST['state'];


        mysql_query("UPDATE users 
        SET state = '$state' WHERE uid = '$uid'");


    
    
?>