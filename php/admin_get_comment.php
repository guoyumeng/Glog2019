<?php
    require "conn.php";
    $of_article = $_POST['of_article'];

    $result = mysql_query("SELECT * FROM comment WHERE of_article = '$of_article' ORDER BY coid DESC");

    
    
    

    $arrdata = array();


    if ($result != '') {
        for ($i=0; $i < mysql_num_rows($result); $i++) { 
            $arrdata[$i] = mysql_fetch_array($result,MYSQL_ASSOC);
        }
    }

    echo json_encode($arrdata);

?>