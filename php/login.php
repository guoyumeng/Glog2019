<?php
    require "conn.php";

    $username = $_POST['username'];
    $password = $_POST['password'];


    $result = mysql_query("SELECT * FROM users WHERE username = '$username' AND password = '$password'");

    

    $arrdata = array();


    if ($result != '') {
        for ($i=0; $i < mysql_num_rows($result); $i++) { 
            $arrdata[$i] = mysql_fetch_array($result,MYSQL_ASSOC);
        }
    }

    echo json_encode($arrdata);

?>