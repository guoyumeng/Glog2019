<?php
    require "conn.php";

    if(isset($_POST['delete_id'])){
        $delete_id = $_POST['delete_id'];
    }

    mysql_query("DELETE FROM users WHERE uid=$delete_id");

?>