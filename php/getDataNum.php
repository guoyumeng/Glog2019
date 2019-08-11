<?php
    require "conn.php";

    $name = $_POST['name'] ? $_POST['name'] : "null";

    

    if ($name != "null") {
        $result = mysql_query("SELECT COUNT(*) FROM users WHERE `username` LIKE '%$name%'");
    }else {
        $result = mysql_query("SELECT COUNT(*) FROM users");
    }

    if ($result != '') {
        echo mysql_result($result,0);
    }else{
        echo 0;
    }
    
    

?>