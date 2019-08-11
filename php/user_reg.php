<?php

    require "conn.php";

    $username = $_POST['username'] ? $_POST['username'] : "未设置用户名";
    $password = $_POST['password'];
    $sex = $_POST['sex'];
	$imageUrl = $_POST['imageUrl'];

    $province = $_POST['province'] ? $_POST['province'] : "";
    $city = $_POST['city'] ? $_POST['city'] : "";
    $register_ip = $_POST['register_ip'] ? $_POST['register_ip'] : "未知IP";



      $isok =  mysql_query("INSERT INTO users 
        (username, password, sex, imageUrl, register_data, province, city, register_ip)
            VALUES
        ('$username', '$password', '$sex', '$imageUrl', NOW(), '$province', '$city', '$register_ip')");


        $arrdata = array();

        echo json_encode($arrdata);

    
    
?>