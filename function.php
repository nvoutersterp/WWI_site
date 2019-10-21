<?php

//start db conectie
function dbconect() {
    $connection = new mysqli("127.0.0.1", "root", "", "wideworldimporters", "3306");
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    return $connection;
}


?>


