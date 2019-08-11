<?php
    require "conn.php";


        $uname = $_POST['uname'];
        $result = mysql_query("SELECT * FROM class WHERE url_name='$uname'");

    

    

    

    $arrdata = array();


    if ($result != '') {
        for ($i=0; $i < mysql_num_rows($result); $i++) { 
            $arrdata[$i] = mysql_fetch_array($result,MYSQL_ASSOC);
        }
    }

    echo json_encode($arrdata);

?>