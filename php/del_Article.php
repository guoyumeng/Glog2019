<?php
    require "conn.php";

    if(isset($_POST['delete_id'])){
        $delete_id = $_POST['delete_id'];
    }

    mysql_query("DELETE FROM article WHERE aid=$delete_id");

?>