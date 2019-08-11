<?php
    require "conn.php";

    $pageSize = $_POST['pageSize'];
    $pageVal = $_POST['pageVal'];
    $title = $_POST['title'] ? $_POST['title'] : "null";
    $old = ($pageVal-1)*$pageSize;

    if ($title != "null") {
        $result = mysql_query("SELECT * FROM article WHERE `title` LIKE '%$title%' ORDER BY aid DESC LIMIT $old,$pageSize");
    }else {
        $result = mysql_query("SELECT * FROM article ORDER BY aid DESC LIMIT $old,$pageSize");
    }
    

    $arrdata = array();


    if ($result != '') {
        for ($i=0; $i < mysql_num_rows($result); $i++) { 
            $arrdata[$i] = mysql_fetch_array($result,MYSQL_ASSOC);
        }
    }

    echo json_encode($arrdata);

?>