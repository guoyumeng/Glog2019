<?php
    require "conn.php";

        $result = mysql_query("SELECT * FROM article WHERE state=1 AND important=1 ORDER BY aid DESC");

    
    
    

    $arrdata = array();


    if ($result != '') {
        for ($i=0; $i < mysql_num_rows($result); $i++) { 
            $arrdata[$i] = mysql_fetch_array($result,MYSQL_ASSOC);
        }
    }

    echo json_encode($arrdata);

?>