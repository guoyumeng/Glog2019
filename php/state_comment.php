<?php

    require "conn.php";
    
    $coid = $_POST['coid'];
    $state = $_POST['state'];

    echo $coid;
    echo $state;
    mysql_query("UPDATE comment SET state = '$state' WHERE coid = '$coid'");


    
    
?>