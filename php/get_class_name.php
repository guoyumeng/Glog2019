<?php
    require "conn.php";


        $class_name = $_POST['class_name'];
        $result = mysql_query("SELECT * FROM class WHERE class_name='$class_name'");

    

    

    

    $arrdata = array();


    if ($result != '') {
        for ($i=0; $i < mysql_num_rows($result); $i++) { 
            $arrdata[$i] = mysql_fetch_array($result,MYSQL_ASSOC);
        }
    }

    echo json_encode($arrdata);

?>