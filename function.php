<?php

//start db conectie
function dbconect() {
    $connection = new mysqli("127.0.0.1", "root", "", "wideworldimporters", "3306");
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    return $connection;
}


//account//
//password//
function hashPassword($password) {
    return password_hash($password, 1);
}

function verifyPassword($password, $hash) {
    if (password_verify($password, $hash)) {
        return true;
    } else {
        return false;
    }
}

function accountLogin($password, $username) {
    $conn = dbconect();
    $sql = "SELECT hashedpassword FROM people WHERE LogonName='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        if (verifyPassword($password,$sql)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

//username//
function checkUsername($username) {

}

function insertUsername($username) {

}

function insertAccountData(string $info, $username) {

}

?>


