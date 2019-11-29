<?php
//print headers
function printHead()
{
    print ('<head>
    <meta charset="UTF-8   ">
    <title>WWI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--links -->
    <link rel="script" href="js/custom.js">
    <!-- CSS -->
     <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
    <link rel="stylesheet" href="css/style.css">
    <style>
        /*inloggen*/
        {
            box-sizing: border-box;
        }

        .login-popup {
            display: none;
            position: fixed;
            top: 0;
            right: 30%;
            border: 3px solid darkblue;
            z-index: 9;
        }

        .login-container {
            max-width: 350px;
            padding: 10px;
            background-color: white;
        }

    </style>
    <script src="js/effecten.js"></script>
</head>');
}

function printcategorie($conn)
{
    print ('<div id="nav" class="nav">');
    $query5 = mysqli_query($conn, "select StockGroupName, DutchName from stockgroups");

    while ($rowGroup = mysqli_fetch_array($query5)) {
        $groupName = $rowGroup['StockGroupName'];
        $dutchName = $rowGroup['DutchName'];
        print ('<a><form action="productpagina.php" method="POST">
            <input type="hidden" name="input" value="' . $groupName . '">
            <input type="submit" name="submit" value="' . $dutchName . '">
        </form></a>');
    }
    print ('</div>');
}

function printIsIngelogt()
{
    print ('<div class="login-popup" id="myLogin">
                <form method="post" action="index.php" id="uitloggen">
                    <input type="hidden" name="uitloggen" value="true">
                </form>
                <form method="post" action="accountpagina.php" class="login-container">uw account
                    <button type="button" onclick="closeLogin()">Close</button><br>
                    <button type="submit" form="uitloggen">uitloggen</button><br>
                    <button type="submit">naar account</button>
                </form>
                <script>
                    function openLogin() {
                        document.getElementById("myLogin").style.display = "block";
                    }

                    function closeLogin() {
                        document.getElementById("myLogin").style.display = "none";
                    }
                </script>
            </div>');
}


//database naam//
$dbname = "wideworldimporters";

//start db conectie
function dbconect()
{
    $connection = new mysqli("127.0.0.1", "root", "", "wideworldimporters", "3306");
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    } else {
        return $connection;
    }
}

//account//
//password//
function insertPassword(string $username, string $password)
{
    $conn = dbconect();
    $hash = password_hash($password, 1);
    $sql = "update client set hashedPassword='$hash' where eMail = '$username'";
    $conn->query($sql);
    $conn->close();
}

function verifyPassword(string $password, $hash)
{
    if (password_verify($password, $hash)) {
        return true;
    } else {
        return false;
    }
}

function setCurrentUser(string $username)
{
    $conn = dbconect();
    $sql = "select PersonID,firstName,middelName,lastName,LogonName,IsSalesperson,PhoneNumber,postalCode,street,city from people where LogonName = '$username'";
    $result = $conn->query($sql);
    $conn->close();
    return $result; //verwerken resultaat
}

function accountLogin($password, $username)
{
    $conn = dbconect();
    $sql = "SELECT hashedPassword FROM client WHERE eMail='$username'";
    $opgehaald = $conn->query($sql);
    $result = $opgehaald->fetch_assoc();
    $conn->close();

    if ($opgehaald->num_rows == 1) {
        if (verifyPassword($password, $result['hashedPassword'])) {
            return 1; //mag inloggen
        } else {
            return 3; //wachtwoord klopt niet
        }
    } else {
        return 2; //mail/naam klopt niet
    }
}

//username//
function checkUsername(string $username)
{
    $conn = dbconect();
    $sql = "SELECT eMail From client where eMail='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        $sql2 = "insert into client (eMail) value ('$username')";
        $conn->query($sql2);
        $conn->close();
        return true;
    } else {
        return false;
    }
    $conn->close();
}

function createAccount(string $username, string $wachtwoord)
{
    if (checkUsername($username)) {
        insertPassword($username, $wachtwoord);
        return true;
    } else {
        return false; //naam bestaat al
    }
}

function insertAccountData(array $info, string $username)
{
    $conn = dbconect();
    $sql = "update people set firstName='$info[voornaam]',middelName='$info[tussenvoegsel]',lastName='$info[achternaam]',PhoneNumber='$info[phonenummer]', EmailAddress='$username',postalCode='$info[postcode]',street='$info[straat]',city='$info[stad]' where LogonName='$username'";
    $conn->query($sql);
    $conn->close();
}

function groet($name){
    if (date('G') < 12) {
        $moment = 'Goedemorgen ';
    } elseif (date('G') > 18) {
        $moment = 'Goedeavond ';
    } else {
        $moment = 'Goedemiddag ';
    }

    print ($moment . $name);
}



