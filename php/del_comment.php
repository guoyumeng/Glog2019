<?php
    require "conn.php";

    $coid = $_POST['coid'];


    mysql_query("DELETE FROM comment WHERE coid=$coid");

?>