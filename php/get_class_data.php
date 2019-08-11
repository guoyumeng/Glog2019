<?php
    require "conn.php";

    if ($_POST['cid'] != '0') {
        $cid = $_POST['cid'];
        $result = mysql_query("SELECT * FROM class WHERE cid='$cid'");
    }else{
        $result = mysql_query("SELECT * FROM class");
    }

    $arrdata = array();


    if ($result != '') {
        for ($i=0; $i < mysql_num_rows($result); $i++) { 
            $arrdata[$i] = mysql_fetch_array($result,MYSQL_ASSOC);
        }
    }

    echo json_encode($arrdata);

?>