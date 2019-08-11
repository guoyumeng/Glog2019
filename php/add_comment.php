<?php

    require "conn.php";

    $user_id = $_POST['user_id'];
    $content = $_POST['content'];

    $of_article = $_POST['of_article'];
    $state = 1;
    $yes = 0;
    $no = 0;
    


    mysql_query("INSERT INTO comment 
    (user_id, content, time, of_article, state, yes, no)
        VALUES
    ('$user_id', '$content', NOW(), '$of_article', '$state', '$yes', '$no')");


    
    
?>