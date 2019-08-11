<?php
    require "conn.php";
    
    $cid = $_POST['cid'];

    if ($cid == '') {
        $result = mysql_query("SELECT * FROM article WHERE state=1 ORDER BY aid DESC");
    }else{
        $result = mysql_query("SELECT * FROM article WHERE state=1 AND class LIKE '%,$cid,%' OR class LIKE '$cid,%' OR class LIKE '%,$cid' OR class LIKE '$cid' ORDER BY aid DESC");
    }
    
    
    

    $arrdata = array();


    if ($result != '') {
        for ($i=0; $i < mysql_num_rows($result); $i++) { 
            $arrdata[$i] = mysql_fetch_array($result,MYSQL_ASSOC);
        }
    }

    echo json_encode($arrdata);

?>