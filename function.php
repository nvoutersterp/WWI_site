<?php

//actieve gebruiker
$currentUserData = array();

//start db conectie
function dbconect() {
    $connection = new mysqli("127.0.0.1", "root", "", "wideworldimporters", "3306");
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    } else {
        return $connection;
    }
}

//account//
//password//
function insertPassword(string $username, string $password){
    $conn = dbconect();
    $hash = password_hash($password, 1);
    $sql = "update people set HashedPassword='$hash' where LogonName = '$username'";
    $conn->query($sql);
    $conn->close();
}

function verifyPassword(string $password, string $hash) {
    if (password_verify($password, $hash)) {
        return true;
    } else {
        return false;
    }
}

function setCurrentUser(string $username) {
    $conn = dbconect();
    $sql = "select PersonID,firstName,middelName,lastName,LogonName,IsSalesperson,PhoneNumber,postalCode,street,city from people where LogonName = '$username'";
    $result = $conn->query($sql);
    $conn->close();
    return $result; //verwerken resultaat
}

function accountLogin($password, $username) {
    $conn = dbconect();
    $sql = "SELECT hashedpassword FROM people WHERE LogonName='$username'";
    $result = $conn->query($sql);
    $conn->close();

    if ($result->num_rows > 0) {
        if (verifyPassword($password,$sql)) {
            $data = setCurrentUser($username);
            return true; //mag inloggen
        } else {
            return false; //wachtwoord klopt niet
        }
    } else {
        return false; //mail/naam klopt niet
    }
}

//username//
function checkUsername(string $username) {
    $conn = dbconect();
    $sql = "SELECT logonname From people where LogonName='$username'";
    $result = $conn->query($sql);
    $niewID = 0;

    if ($result->num_rows == 0) {
        $sql3 = "select max(personID) from people";
        $result2 = $conn->query($sql3); //zoek hoogste sleutel/id
        $maxID = $result2->fetch_assoc();
        foreach ($maxID as $getal) {
            $niewID = $getal;
        }
        $niewID++;
        $sql2 = "insert into people (PersonID,LogonName) value ('$niewID[0]','$username')";
        $conn->query($sql2);
        $conn->close();
        return true;
    } else {
        return false;
    }
    $conn->close();
}

function createAccount(string $username, string $wachtwoord) {
    if (checkUsername($username)) {
        insertPassword($username, $wachtwoord);
        return true;
    } else {
        return false; //naam bestaat al
    }
}

function insertAccountData(array $info, string $username) {
    $conn = dbconect();
    $sql = "update people set firstName='$info[voornaam]',middelName='$info[tussenvoegsel]',lastName='$info[achternaam]',PhoneNumber='$info[phonenummer]', EmailAddress='$username',postalCode='$info[postcode]',street='$info[straat]',city='$info[stad]' where LogonName='$username'";
    $conn->query($sql);
    $conn->close();
}


if (createAccount('test05','test05')){
    print ("gelukt");
} else {
    print ("niet zo gelukt");
}


