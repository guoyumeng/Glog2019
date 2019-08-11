<?php
    require "conn.php";

    $aid = $_POST['aid'];

    $result = mysql_query("SELECT * FROM article WHERE aid='$aid'");
    
    

    $arrdata = array();


    if ($result != '') {
        for ($i=0; $i < mysql_num_rows($result); $i++) { 
            $arrdata[$i] = mysql_fetch_array($result,MYSQL_ASSOC);
        }
    }

    echo json_encode($arrdata);

?>