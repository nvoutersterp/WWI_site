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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="body">
<!--link met de bootstraps en stylesheets-->
<header>

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

//voor de foto's
$photoRow = mysqli_query($conn, "select * from photo where StockItemID = '$productID'");
$issetPhoto = mysqli_num_rows($photoRow);
$p = 0;
$q = 0;

?>

<div id="overzicht1">
    <div class="container">
        <h2><?php print($naam); ?></h2>
        <?php if ($issetPhoto != 0) { ?>
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <?php while ($q < $issetPhoto) { ?>
                        <li data-target="#myCarousel" data-slide-to="1" class="<?php if ($q == 0) {
                            print ('active ');
                        } ?>btn-dark border-dark"></li>
                        <?php $q++;
                    } ?>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <?php while ($photo = mysqli_fetch_array($photoRow)) { ?>
                        <div class="item <?php if ($p == 0) {
                            print ('active');
                        } ?>">
                            <img src="<?php print ($photo['photo']); ?>">
                            <div class="carousel-caption"></div>
                        </div>
                        <?php $p++;
                    } ?>

                </div>
                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        <?php } else {
            print ("<img src='images/archixl-logo.png'>");
        }

    //Afsluiten Database//
    mysqli_close($conn);
    ?>
</div>
</div>

<div id="overzicht2">
    <p>€<?php print($prijs); ?></p>
    <p>Omschrijving: <?php print($omschrijving); ?></p>
    <form action="winkelmand.php" method="post">
        <p><select name="quantity">
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
        <p>Nog in vooraad: <?php print($vooraad); ?></p>
        <p>
            <input type="hidden" name="stockItemID" value="<?php print($productID); ?>">
            <button type="submit">Toevoegen aan winkelwagen</button>
    </form>
    <form action="#favorieten.php" method="post">
        <input type="hidden" name="stockItemID" value="<?php print ($productID); ?>">
        <button type="submit">toevoegen aan favorieten</button>
    </form>
    </p>
</div>
<?php printFooter(); ?>

<link href="css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<script src="js/bootstrap.js" rel="script"></script>
<script src="js/effecten.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</body>
</html>
