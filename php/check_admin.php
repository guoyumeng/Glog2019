<?php
    require "conn.php";

    $auid = $_POST['auid'];

    $result = mysql_query("SELECT * FROM admin_user WHERE auid = '$auid'");

    

    $arrdata = array();


    if ($result != '') {
        for ($i=0; $i < mysql_num_rows($result); $i++) { 
            $arrdata[$i] = mysql_fetch_array($result,MYSQL_ASSOC);
        }
    }

    echo json_encode($arrdata);

?>