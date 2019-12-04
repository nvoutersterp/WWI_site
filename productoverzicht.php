<?php session_start();

//db
include 'function.php';
$conn = dbconect();
$output = "";

mysqli_select_db($conn, $dbname) or die ("could not connect");

if (isset($_POST['username']) and isset($_POST['password'])) {
    $eMail = $_POST['username'];
    $ant = accountLogin($_POST['password'], $eMail);
    if ($ant == 1) {
        $queryInloggen = mysqli_query($conn, "select * from client where eMail='$eMail'");
        $rowInloggen = mysqli_fetch_array($queryInloggen);
        $_SESSION['clientID'] = $rowInloggen['clientID'];
        $_SESSION['isHoS'] = $rowInloggen['isHos'];
        $_SESSION['isIngelogt'] = true;
        $_SESSION['firstName'] = $rowInloggen['firstName'];
    } elseif ($ant == 2) {
        //gebruikersnaam klopt niet
    } elseif ($ant == 3) {
        //wachtwoord klopt niet
    } elseif ($ant == 4) {
        //is inactief
    } else {
        //andere fout
    }
}

?>
<!DOCTYPE HTML>
<HTML lang="EN">
<head>
    <title>WWI</title>
</head>
<body class="body">
<!--link met de bootstraps en stylesheets-->
<header>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.css">
</header>
<!--header1 gedefinieerd om een sticky effect te krijgen van top-container en nav-bar-->
<div class=header1 id="header1">
    <div class="top-container" id="top-container">
        <!--        Laat logo zien met de juiste afmetingen-->
        <a href="index.php" class="logo"><img alt src="images/wwi%20logo%20text.png" width=180px height=50px> </a>
        <!--        snelkoppelingen naar de accountinformatie's-->
        <div class="top-container-right">
            <div> <?php
                if (isset($_SESSION['firstName'])) {
                    $name = $_SESSION['firstName'];
                } else {
                    $name = '';
                }
                groet($name);
                ?>
            </div>
            <a>
                <div class="icon">
                    <i class="fa fa-user" aria-hidden="true" onclick="openLogin()"></i>
                </div>
            </a>
            <?php
            //devinieren
            if (isset($_POST['productID'])) {
                $productID = $_POST['productID'];
            } else {
                $productID = $_GET['productID'];
            }

            //login popup
            if ($_SESSION['isIngelogt']) {
                printIsIngelogt();
            } else { ?>
                <div class="login-popup" id="myLogin">
                    <form action="index.php" method="post" class="login-container">
                        inloggen
                        <button type="button" onclick="closeLogin()">Close</button>
                        <br>
                        gebruikersnaam: <input type="email" name="username" placeholder="email"
                                               style="background: gray; color: white" required><br>
                        wachtwoord: <input type="password" name="password" style="background: gray ; color: white"
                                           required><br>
                        <a href="nieuwaccount.php">nog geen account? Maak er nu een aan!</a><br>
                        <input type="hidden" name="productID" value="<?php print ($productID); ?>">
                        <button type="submit">inloggen</button>
                    </form>
                    <script>
                        function openLogin() {
                            document.getElementById("myLogin").style.display = "block";
                        }

                        function closeLogin() {
                            document.getElementById("myLogin").style.display = "none";
                        }
                    </script>
                </div>
            <?php } ?>

            <a href="winkelmand.php">
                <div class="icon">
                    <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                </div>
            </a>
            <a href="#verlanglijst">
                <div class="icon">
                    <i class="fa fa-heart" aria-hidden="true"></i>
                </div>
            </a>
        </div>
        <!--            Het zoeken naar producten-->
        <form class="example" action="productpagina.php" method="POST">
            <input class="searchbox" type="text" placeholder="Zoek hier naar producten" name="search">
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>

    </div>
    <!-- snelkoppelingen naar de juist betreffende catogorie met icon's van de bootstrap-->
    <div class="nav" id="nav">
        <?php printcategorie($conn); ?>
    </div>

</div>


<?php
$dbname = "wideworldimporters";

$db = "mysql:host=localhost;dbname=cursus;port=3306";
$user = "root";
$pass = "";
$pdo = new PDO($db, $user, $pass);

$query1 = mysqli_query($conn, "SELECT * FROM stockitems S JOIN stockitemholdings H ON S.StockItemid = H.StockItemid WHERE S.StockItemid='$productID'") or die('Geen overeenkomst');

$row = mysqli_fetch_array($query1);


$naam = $row['StockItemName'];
$prijs = number_format((float)$row['UnitPrice'] * 0.9, 2, ',', '');
$vooraad = $row["QuantityOnHand"];
$omschrijving = $row["SearchDetails"];
$i = 1;

?>

<div id="overzicht1">
    <br>
    <?php

    $photoRow = mysqli_query($conn, "select * from photo where StockItemID = '$productID'");
    $issetPhoto = mysqli_num_rows($photoRow);
    if ($issetPhoto != 0) {
        while ($photo = mysqli_fetch_array($photoRow)) {
            $link = $photo['photo'];
            print ("<img src='$link'><br>");
        }
    } else {
        print ("<img src='images/archixl-logo.png'>");
    }

    //Afsluiten Database//
    mysqli_close($conn);
    ?>
</div><br>
<div class="col-md-15"><h2><?php print(' '); print($naam); ?></h2>
    <p class="prijs">€<?php print($prijs); ?></p>
    <h2 class="omschrijving-1"> Omschrijving: </h2> <p class="omschrijving-2"> <?php print($omschrijving); ?></p>
    <form action="winkelmand.php" method="post">
        <p><select name="quantity"  class="form-control">
                <?php
                if ($vooraad > 10) {
                    $verkoopbaar = 10;
                } else {
                    $verkoopbaar = $vooraad;
                }

                while ($i <= $verkoopbaar) {
                    print ('<option value="' . $i . '">' . $i . '</option>');
                    $i++;
                } ?>
            </select></p>
        <!-- nog te komen:
        leverancier, exl. btw, aantal per pakket en pakket type;
         kleur en maat selecteerbaar-->
        <?php
        if ($vooraad > 10) {
            print("<p>Nog in vooraad: $vooraad </p>");
        }
        ?>

        <p>
            <input type="hidden" name="stockItemID" value="<?php print($productID); ?>">
            <button type="submit">Toevoegen aan winkelwagen</button>
    </form>
    <form action="favorieten.php" method="post">
        <input type="hidden" name="stockItemID" value="<?php print ($productID); ?>">
        <button type="submit">toevoegen aan favorieten</button>
    </form>
    </p>
</div>
<?php printFooter(); ?>

<script src="js/effecten.js"></script>

</body>
</html>
