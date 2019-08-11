<?php
    require "conn.php";

    $title = $_POST['title'] ? $_POST['title'] : "null";


    

    if ($title != "null") {
        $result = mysql_query("SELECT COUNT(*) FROM article WHERE `title` LIKE '%$title%'");
    }else {
        $result = mysql_query("SELECT COUNT(*) FROM article");
    }

    if ($result != '') {
        echo mysql_result($result,0);
    }else{
        echo 0;
    }
    
    

?>