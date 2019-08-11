<?php
    require "conn.php";
    $aid = $_POST['aid'];


    


    $result = mysql_query("SELECT COUNT(*) FROM comment WHERE of_article='$aid'");


    if ($result != '') {
        echo mysql_result($result,0);
    }else{
        echo 0;
    }

?>