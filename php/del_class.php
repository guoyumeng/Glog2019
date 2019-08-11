<?php
    require "conn.php";


        $cid = $_POST['cid'];


    mysql_query("DELETE FROM class WHERE cid=$cid");

?>