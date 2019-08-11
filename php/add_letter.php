<?php

    require "conn.php";

    $title = $_POST['title'] ? $_POST['title'] : "无标题";

    $content = $_POST['content'];
    $class = $_POST['class'];
    $email = $_POST['email'] ? $_POST['email'] : "";



    if (mysql_query("INSERT INTO letter 
    (title, content, class, email, send_time)
        VALUES
    ('$title', '$content', '$class', '$email', NOW())")) {
        echo "OK";
    }

?>