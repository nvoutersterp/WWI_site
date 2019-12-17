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
} elseif (isset($_POST['uitloggen'])) {
    unset($_SESSION['clientID'], $_SESSION['isHoS'], $_SESSION['firstName']);
    $_SESSION['isIngelogt'] = false;

}

$orderId = $_GET['order_id']

?>
<!DOCTYPE HTML>
<head>
    <title>WWI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<HTML lang="EN">
<body class="body">
<!--link met de bootstraps en stylesheets-->
<header>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</header>
<!--header1 gedefinieerd om een sticky effect te krijgen van top-container en nav-bar-->
<div class=header1 id="header1" style="z-index: 100">
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
            <?php if (isset($_SESSION['isIngelogt']) and $_SESSION['isIngelogt']) {
                printIsIngelogt();
            } else { ?>
                <div class="login-popup" id="myLogin">
                    <form action="index.php" method="post" class="login-container">
                        Inloggen
                        <button type="button" onclick="closeLogin()">Close</button>
                        <br>
                        Gebruikersnaam: <input type="text" name="username" placeholder="e-mail"><br>
                        Wachtwoord: <input type="password" name="password"><br>
                        <a href="nieuwaccount.php">Nog geen account? Maak er nu een aan!</a><br>
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
    <?php printcategorie($conn); ?>

</div>

<?php

require "mollie-api-php-master/initialize.php";
/*
 * Retrieve the payment's current state.
 */
$ant = database_read_payment($orderId);


if ($ant['paymentStatus'] == 'paid') {
    print ('Dank voor uw bestlling!<br>Het word zsm verstuurd.');
    unset($_SESSION['winkelmand']);
    ?>
    <form action="index.php">
        <button type="button">Terug naar home</button>
    </form>
    <?php
} elseif ($ant['paymentStatus'] == 'open') {
    print ('dank voor uw koop. De betaling word nog verwerkt. Als we die hebben ontvangen sturen we het zsm naar u op.');
    unset($_SESSION['winkelmand']);
    ?>
    <form action="index.php">
        <button type="button">Terug naar home</button>
    </form>
    <?php
} else {
    print ("Sorry, er ging iets fout bij de betaling. hij is ". $ant['paymentStatus'] ."Probeer het a.u.b. opneuw te kopen:");
    ?>
    <form action="winkelmand.php">
        <button type="button">Terug naar winkelmand</button>
    </form> <?php
}


?>




<?php printFooter(); ?>
<script src="js/effecten.js"></script>
</body>
</HTML>