<?php session_start();

//db
include 'function.php';
$conn = dbconect();
$output = "";
$rij = 1;

mysqli_select_db($conn, $dbname) or die ("could not connect");

//verder....
$werktHet = '';

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
</header>
<!--header1 gedefinieerd om een sticky effect te krijgen van top-container en nav-bar-->
<div class=header1 id="header1">
    <div class="top-container" id="top-container" >
        <!--        Laat logo zien met de juiste afmetingen-->
        <a href="index.php" class="logo"><img alt src="images/wwi%20logo%20text.png" width=180px height=50px> </a>
        <!--        snelkoppelingen naar de accountinformatie's-->
        <div class="top-container-right">
            <div> <?php
                if (isset($_SESSION['firstName'])) {
                    $name =  $_SESSION['firstName'];
                } else {
                    $name = '';
                }
                groet($name);
                ?>
            </div>
            <a>
                <div class="icon">
                    <i class="fa fa-sign-in" aria-hidden="true" onclick="openLogin()"></i>
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
                        <button type="button" onclick="closeLogin()">Close</button><br>
                        gebruikersnaam: <input type="text" name="username" placeholder="email" style="background: gray; color: white" required><br>
                        wachtwoord: <input type="password" name="password" style="background: gray ; color: white" required><br>
                        <a href="nieuwaccount.php">nog geen account? Maak er nu een aan!</a><br>
                        <input type="hidden" name="productID" value="<?php print ($productID);?>">
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

    $query1 = mysqli_query($conn, "SELECT StockItemName, UnitPrice, Photo, QuantityOnHand, SearchDetails FROM stockitems S JOIN stockitemholdings H ON S.StockItemid = H.StockItemid WHERE S.StockItemid='$productID'") or die('Geen overeenkomst');

    $row = mysqli_fetch_array($query1);


    $naam = $row['StockItemName'];
    $prijs = $row["UnitPrice"] * 0.9;
    $afbeelding = $row["Photo"];
    $vooraad = $row["QuantityOnHand"];
    $omschrijving = $row["SearchDetails"];
    //Afsluiten Database//
    mysqli_close($conn);
    ?>

    <div id="overzicht1">
        <h2><?php print($naam); ?></h2>
        <img src="#images/wwi%20logo%20text.png">
    </div>
    <div id="overzicht2">
        <p>€<?php print($prijs); ?></p>
        <p>Omschrijving: <?php print($omschrijving); ?></p>
        <p><input type="number" name="aantal" min="1" max="<?php print($vooraad) ?>" placeholder="1"> aantal</p>
        <!-- nog te komen:
        leverancier, exl. btw, aantal per pakket en pakket type
         kleur en maat selecteerbaar-->
        <p>Nog in vooraad: <?php print($vooraad); ?></p>
        <p>
            <button>Toevoegen aan winkelwagen</button>
        </p>
    </div>
<?php printFooter(); ?>
</body>
</html>
