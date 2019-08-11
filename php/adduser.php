<?php

    require "conn.php";
    $uid = $_POST['uid'] ? $_POST['uid'] : 0;
    $now = $_POST['now'];
    $username = $_POST['username'] ? $_POST['username'] : "未设置用户名";
    $password = $_POST['password'];
    $sex = $_POST['sex'];
    $address = $_POST['address'];
    $birthday = $_POST['birthday']/1000;

    $province = $_POST['province'] ? $_POST['province'] : "";
    $city = $_POST['city'] ? $_POST['city'] : "";
    $register_ip = $_POST['register_ip'] ? $_POST['register_ip'] : "未知IP";


    if ($now == "add") {
        mysql_query("INSERT INTO users 
        (username, password, address, sex, birthday, register_data, province, city, register_ip)
            VALUES
        ('$username', '$password', '$address', '$sex', '$birthday', NOW(), '$province', '$city', '$register_ip')");
    }else if ($now == "edit") {
        mysql_query("UPDATE users 
        SET username = '$username',password = '$password',address = '$address',sex = '$sex',birthday = '$birthday',update_data = NOW(),update_ip = '$register_ip' WHERE uid = '$uid'");
    };

    
    
?>