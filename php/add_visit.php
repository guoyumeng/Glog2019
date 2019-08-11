<?php

    require "conn.php";

    $time = TIME();

    $province = $_GET['province'] ? $_GET['province'] : "";
    $city = $_GET['city'] ? $_GET['city'] : "";
    $ip = $_GET['ip'] ? $_GET['ip'] : "未知IP";
    $callback = $_GET['callback'];



    $dos = mysql_query("INSERT INTO visit 
    (time, province, city, ip)
        VALUES
    ('$time', '$province', '$city', '$ip')");

    $state = "";

    if ($dos) {
        $state = "OK";
    } else {
        $state = "ERROR";
    }

    echo $callback."('".$state."')";
    
    
?>