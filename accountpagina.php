<?php session_start();

//db
include 'function.php';
$conn = dbconect();
$output = "";

mysqli_select_db($conn, $dbname) or die ("could not connect");

?>
    <!DOCTYPE HTML>
    <head>
        <title>WWI</title>
    </head>
    <HTML lang="EN">
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
                <?php if ($_SESSION['isIngelogt']) {
                    printIsIngelogt();
                } else { ?>
                    <div class="login-popup" id="myLogin">
                        <form action="index.php" method="post" class="login-container">
                            inloggen
                            <button type="button" onclick="closeLogin()">Close</button><br>
                            gebruikersnaam: <input type="text" name="username" style="background: gray; color: white" required><br>
                            wachtwoord: <input type="password" name="password" style="background: gray ; color: white" required><br>
                            <a href="nieuwaccount.php">nog geen account? Maak er nu een aan!</a><br>
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
$clientid = $_SESSION['clientID'];

$query1 = mysqli_query($conn, "SELECT * FROM client WHERE clientID='$clientid'");

$row = mysqli_fetch_array($query1);

$email = $row['eMail'];
$wachtwoord = $row[''];
$nieuwwachtwoord = $row[''];
$voornaam = $row['firstName'];
$tussenvoegsel = $row['middelName'];
$achternaam = $row['lastName'];
$telefoonnummer = $row['phoneNumber'];
$adres = $row['adres'];
$postcode = $row['postcode'];
$woonplaats = $row['plaats'];

    ?>

    <?php

//wijzigprofiel
if (isset($_POST['submitProfiel'])) {
    if (!empty($_POST['email'])) {
        $nieuweEmail = $_POST['email'];
        $queryemail = mysqli_query($conn, "UPDATE client SET eMail='$nieuweEmail' WHERE clientID='$clientid'");
        print("Email is gewijzigd naar: $nieuweEmail");
        print('</br>');
    }
    if (!empty($_POST['voornaam'])) {
        $nieuweVoornaam = $_POST['voornaam'];
        $queryvoornaam = mysqli_query($conn, "UPDATE client SET firstName='$nieuweVoornaam' WHERE clientID='$clientid'");
        print("Voornaam is gewijzigd naar: $nieuweVoornaam");
        print('</br>');
    }
    if (!empty($_POST['tussenvoegsels'])) {
        $nieuweTussenvoegsels = $_POST['tussenvoegsels'];
        $querytussenvoegsels = mysqli_query($conn, "UPDATE client SET middelName='$nieuweTussenvoegsels' WHERE clientID='$clientid'");
        print("Tussenvoegsels is gewijzigd naar: $nieuweTussenvoegsels");
        print('</br>');
    }
    if (!empty($_POST['achternaam'])) {
        $nieuweAchternaam = $_POST['achternaam'];
        $queryachetrnaam = mysqli_query($conn, "UPDATE client SET lastName='$nieuweAchternaam' WHERE clientID='$clientid'");
        print("Achternaam is gewijzigd naar: $nieuweAchternaam");
        print('</br>');
    }
    if (!empty($_POST['telefoonnummer'])) {
        $nieuwtelefoonnummer = $_POST['telefoonnummer'];
        $querytelefoonnummer = mysqli_query($conn, "UPDATE client SET phoneNumber='$nieuwtelefoonnummer' WHERE clientID='$clientid'");
        print("Telefoonnummer is gewijzigd naar: $nieuwtelefoonnummer");
        print('</br>');
    }
    if (!empty($_POST['postcode'])) {
        $nieuwePostcode = $_POST['postcode'];
        $querypostcode = mysqli_query($conn, "UPDATE client SET postcode='$nieuwePostcode' WHERE clientID='$clientid'");
        print("Postcode is gewijzigd naar: $nieuwePostcode");
        print('</br>');
    }
    if (!empty($_POST['plaats'])) {
        $nieuweWoonplaats = $_POST['plaats'];
        $querywoonplaats = mysqli_query($conn, "UPDATE client SET plaats='$nieuweWoonplaats' WHERE clientID='$clientid'");
        print("Woonplaats is gewijzigd naar: $nieuweWoonplaats");
        print('</br>');
    }
}
?>

<div class="col-md-9">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h4>Your Profile</h4>
                    <hr>
                </div>
            </div>
            <form>
                <div class="form-group row">
                    <label for="name" class="col-4 col-form-label">Voornaam</label>
                    <div class="col-8">
                        <input id="name" name="voornaam" placeholder="<?php print("$voornaam"); ?>"
                               class="form-control here" type="text">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tussenvoegsels" class="col-4 col-form-label">Tussenvoegsels</label>
                    <div class="col-8">
                        <input id="name" name="Tussenvoegsels" placeholder="<?php print("$tussenvoegsel"); ?>"
                               class="form-control here" type="text">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lastname" class="col-4 col-form-label">Achternaam</label>
                    <div class="col-8">
                        <input id="lastname" name="achternaam" placeholder="<?php print("$achternaam"); ?>"
                               class="form-control here" type="text">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-4 col-form-label">Email*</label>
                    <div class="col-8">
                        <input id="email" name="email" placeholder="<?php print("$email"); ?>"
                               class="form-control here" required="required" type="text">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="adres" class="col-4 col-form-label">Adres</label>
                    <div class="col-8">
                        <input id="adres" name="adres" placeholder="<?php print("$adres"); ?>"
                               class="form-control here" type="text">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="telefoonnummer" class="col-4 col-form-label">Telefoonnummer</label>
                    <div class="col-8">
                        <input id="name" name="telefoonmummer" placeholder="<?php print("$telefoonnummer"); ?>"
                               class="form-control here" type="text">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="postcode" class="col-4 col-form-label">Postcode</label>
                    <div class="col-8">
                        <input id="postcode" name="postcode" placeholder="<?php print("$postcode"); ?>"
                               class="form-control here" type="text">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="plaats" class="col-4 col-form-label">WoonPlaats</label>
                    <div class="col-8">
                        <input id="name" name="plaats" placeholder="<?php print("$woonplaats"); ?>"
                               class="form-control here" type="text">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="newpass" class="col-4 col-form-label">Nieuw wachtwoord</label>
                    <div class="col-8">
                        <input id="newpass" name="nieuwwachtwoord" placeholder="Nieuw wachtwoord"
                               class="form-control here" type="text">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="offset-4 col-8">
                        <button name="submit" type="submit" class="btn btn-primary">Update mijn profiel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</main>
<?php printFooter(); ?>
</body>
</html>