<?php
    require "conn.php";

    
    $page = $_GET["page"];
    $key = $_GET["key"];
    $value = $_GET["value"];

    $result = mysql_query("SELECT * FROM `$page` WHERE $key='$value'");

    $arrdata = array();

    for ($i=0; $i < mysql_num_rows($result); $i++) { 
        $arrdata[$i] = mysql_fetch_array($result,MYSQL_ASSOC);
    }

    echo json_encode($arrdata);

?>