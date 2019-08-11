<?php
    require "conn.php";

    $old = $_POST['old'];
    if ($old == 1) {
        $old_time = strtotime("-1 day");
        $result = mysql_query("SELECT * FROM visit WHERE time > '$old_time'");
    }else if ($old == 0) {
		$old_time = strtotime("-30 day");
        $result = mysql_query("SELECT * FROM visit WHERE time > '$old_time'");
    }
    

    
    

    $arrdata = array();


    if ($result != '') {
        for ($i=0; $i < mysql_num_rows($result); $i++) { 
            $arrdata[$i] = mysql_fetch_array($result,MYSQL_ASSOC);
        }
    }

    echo json_encode($arrdata);
    
 

?>