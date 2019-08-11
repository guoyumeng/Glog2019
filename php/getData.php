<?php
    require "conn.php";

    $pageSize = $_POST['pageSize'];
    $pageVal = $_POST['pageVal'];
    $name = $_POST['name'] ? $_POST['name'] : "null";
    $old = ($pageVal-1)*$pageSize;

    if ($name != "null") {
        $result = mysql_query("SELECT * FROM users WHERE `username` LIKE '%$name%' ORDER BY uid DESC LIMIT $old,$pageSize");
    }else {
        $result = mysql_query("SELECT * FROM users ORDER BY uid DESC LIMIT $old,$pageSize");
    }
    

    $arrdata = array();


    if ($result != '') {
        for ($i=0; $i < mysql_num_rows($result); $i++) { 
            $arrdata[$i] = mysql_fetch_array($result,MYSQL_ASSOC);
        }
    }

    echo json_encode($arrdata);

?>