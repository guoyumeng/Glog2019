<?php

    require "conn.php";

    $aid = $_POST['aid'];
    $now = $_POST['now'];
    $title = $_POST['title'] ? $_POST['title'] : "无标题";
    $state = $_POST['state'];
    $important = $_POST['important'];
    $content = $_POST['content'];
    $class = $_POST['class'];
    $author = $_POST['author'] ? $_POST['author'] : "佚名";
	$headerPic = $_POST['headerPic'];
    $time_stamp = time();
	
	

    if ($now == "add") {
        mysql_query("INSERT INTO article 
        (title, state, important, content, class, author, headerPic, publish_time, time_stamp)
            VALUES
        ('$title', '$state', '$important', '$content', '$class', '$author', '$headerPic', NOW(), '$time_stamp')");
    }else if ($now == "edit") {
        mysql_query("UPDATE article 
        SET title = '$title',state = '$state',important = '$important',content = '$content',class = '$class',author = '$author',headerPic = '$headerPic',update_data = NOW(),time_stamp = '$time_stamp' WHERE aid = '$aid'");
    };

    
    
?>