<?php
    require "conn.php";
    $old_time = time() - (60 * 60 * 24 * 30);

    $result = mysql_query("SELECT * FROM article WHERE state=1 AND time_stamp > '$old_time' ORDER BY read_num DESC LIMIT 0,3");

    $arrdata = array();


    if ($result != '') {
        for ($i=0; $i < mysql_num_rows($result); $i++) { 
            $arrdata[$i] = mysql_fetch_array($result,MYSQL_ASSOC);
        }
    }

    echo json_encode($arrdata);

?>