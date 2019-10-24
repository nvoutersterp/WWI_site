<?php
//actieve gebruiker
$currentUserData = array();

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
function insertPassword($username, $password){
    $conn = dbconect();
    $hash = password_hash($password, 1);
    $sql = "update people set HashedPassword='$hash' where LogonName = '$username'";
    $conn->query($sql);
    $conn->close();
}

function verifyPassword($password, $hash) {
    if (password_verify($password, $hash)) {
        return true;
    } else {
        return false;
    }
}

function setCurrentUser($username) {
    $conn = dbconect();
    $sql = "select PersonID,firstName,middelName,lastName,LogonName,IsSalesperson,PhoneNumber,postalCode,street,city from people where LogonName = '$username'";
    $result = $conn->query($sql);
    $conn->close();
    $currentUserData = $result; //verwerken resultaat
}

function accountLogin($password, $username) {
    $conn = dbconect();
    $sql = "SELECT hashedpassword FROM people WHERE LogonName='$username'";
    $result = $conn->query($sql);
    $conn->close();

    if ($result->num_rows > 0) {
        if (verifyPassword($password,$sql)) {
            setCurrentUser($username);
            return true; //mag inloggen
        } else {
            return false; //wachtwoord klopt niet
        }
    } else {
        return false; //mail/naam klopt niet
    }
}

//username//
function checkUsername($username) {
    $conn = dbconect();
    $sql = "SELECT logonname From people where LogonName='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows = 0) {
        $sql2 = "insert into people (LogonName) value ('$username')"; //mist personID!!!!!!!!
        $conn->query($sql2);
        return true;
    } else {
        return false;
    }
    $conn->close();
}

function createAccount($username, $wachtwoord) {
    if (checkUsername($username)) {
        insertPassword($username, $wachtwoord);
    } else {
        return false; //naam bestaat al
    }
}

function insertAccountData(array $info, $username) {
    $conn = dbconect();
    $sql = "update people set firstName='$info[voornaam]',middelName='$info[tussenvoegsel]',lastName='$info[achternaam]',PhoneNumber='$info[phonenummer]', EmailAddress='$username',postalCode='$info[postcode]',street='$info[straat]',city='$info[stad]' where LogonName='$username'";
    $conn->query($sql);
    $conn->close();
}

?>


