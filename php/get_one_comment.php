<?php
    require "conn.php";
    
    $coid = $_POST['coid'];

    $result = mysql_query("SELECT * FROM comment WHERE coid='$coid'");

    
    
    

    $arrdata = array();


    if ($result != '') {
        for ($i=0; $i < mysql_num_rows($result); $i++) { 
            $arrdata[$i] = mysql_fetch_array($result,MYSQL_ASSOC);
        }
    }

    echo json_encode($arrdata);

?>