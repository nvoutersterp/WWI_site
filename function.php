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
    <link rel="stylesheet" href="css/bootstrap.min.css">
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

function printFooter()
{
    print('  <footer id="sticky-footer" style="margin-top:4%; width: 100%" class="py-4 bg-dark text-white-50">
    <div class="container text-center">
      <small>Copyright &copy; Your Website</small>
    </div>
  </footer>
<!-- Footer -->');
}

function printProducten($query1, $conn)
{
    $rij = 0;
    ?>
    <div class="row"> <?php
    while ($row = mysqli_fetch_array($query1)) {
        if ($rij < 24) {
            // data opslaan in variabelen, in: gegevens uit data base, uit: toonbare variabeln
            $productID = $row['StockItemID'];
            $productNaam = $row['StockItemName'];
            $poLength = strlen($row['SearchDetails']);
            if ($poLength < 30) {
                $productOmschrijving = $row['SearchDetails'];
            } else {
                $maxLength = 30 - $poLength;
                $productOmschrijving = substr_replace($row['SearchDetails'], '...', $maxLength);
            }

            $photoRow = mysqli_query($conn, "select * from photo where StockItemID = '$productID'");
            $issetPhoto = mysqli_num_rows($photoRow);
            $Photo = mysqli_fetch_array($photoRow);
            if ($issetPhoto != 0) {
                $productFoto = $Photo['photo'];
            } else {
                $productFoto = 'images/archixl-logo.png';
            }

            $productPrijs = number_format((float)$row['UnitPrice'] * 0.9, 2, ',', '');

            //weergave//
            ?>
            <div class="card" style="width: 18rem; z-index: 0.5; margin-left: 1%">
            <a href="productoverzicht.php?productID=<?php print ($productID); ?>"
               style="text-decoration: none; color: black">
                <img class="card-img-top" src="<?php print ($productFoto); ?>" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title"><?php print($productNaam); ?> </h5>
                    <p class="card-text"><?php print($productOmschrijving); ?> </p>
                    <p class="card-text">€<?php print($productPrijs) ?></p>
                    <a href="#favorieten.php" class="btn btn-primary fa fa-heart" style="float: left"></a>
                    <form action="winkelmand.php" method="post">
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="stockItemID" value="<?php print($productID); ?>">
                        <button type="submit" class="btn btn-success"><i class="fa fa-cart-arrow-down"></i></button>
                    </form>
                </div>
            </a>
            </div><?php
        }
        $rij++;
    }
    ?>
    <div> <?php
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
    $sql = "SELECT hashedPassword, isActive FROM client WHERE eMail='$username'";
    $opgehaald = $conn->query($sql);
    $result = $opgehaald->fetch_assoc();

    if ($opgehaald->num_rows == 1) {
        if ($result['isActive'] == 1) {
            if (verifyPassword($password, $result['hashedPassword'])) {
                $date = date('Y-m-d');
                $sql = "update client set lastVisit = '$date' where eMail = '$username'";
                $conn->query($sql);
                $conn->close();
                return 1; //mag inloggen
            } else {
                $conn->close();
                return 3; //wachtwoord klopt niet
            }
        } else {
            return 4; //inactief
        }
    } else {
        $conn->close();
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


//betalingen
function database_read_payment($orderId)
{
    $conn = dbconect();
    $sql = "select paymentStatus, bestellingID from bestelling where paymentID = '$orderId'";
    $result = $conn->query($sql);
    $conn->close();
    while ($row = $result->fetch_assoc()) {
        $return['paymentStatus'] = $row['paymentStatus'];
        $return['bestellingID'] = $row['bestellingID'];
    }
    return $return;
}

function database_write_new_payment($orderId, $status)
{
    $conn = dbconect();
    $sql = "insert into bestelling (paymentID, paymentStatus)values ('$orderId', '$status')";
    $conn->query($sql);
    $conn->close();
}

function database_write_payment($orderId, $status)
{
    $conn = dbconect();
    $sql = "update bestelling set status='$status' where paymentID = '$orderId'";
    $conn->query($sql);
    $conn->close();
}


//overig
function groet($name)
{
    if (date('G') < 12) {
        $moment = 'Goedemorgen ';
    } elseif (date('G') > 18) {
        $moment = 'Goedeavond ';
    } else {
        $moment = 'Goedemiddag ';
    }

    print ($moment . $name);
}


