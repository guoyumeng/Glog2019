<?php
    require "conn.php";


        $cid = $_POST['cid'];
        $result = mysql_query("SELECT * FROM article WHERE class LIKE '%,$cid,%' OR class LIKE '$cid,%' OR class LIKE '%,$cid' OR class LIKE '$cid'");

    

    

    

    $arrdata = array();


    if ($result != '') {
        for ($i=0; $i < mysql_num_rows($result); $i++) { 
            $arrdata[$i] = mysql_fetch_array($result,MYSQL_ASSOC);
        }
    }

    echo json_encode($arrdata);

?>