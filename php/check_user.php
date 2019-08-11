<?php
    require "conn.php";

    $uid = $_POST['uid'];


    $result = mysql_query("SELECT * FROM users WHERE uid = '$uid'");

    

    $arrdata = array();


    if ($result != '') {
        for ($i=0; $i < mysql_num_rows($result); $i++) { 
            $arrdata[$i] = mysql_fetch_array($result,MYSQL_ASSOC);
        }
    }

    echo json_encode($arrdata);

?>