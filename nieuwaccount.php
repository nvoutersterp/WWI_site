<?php session_start();

//db
include 'function.php';
$conn = dbconect();
$output = "";
$rij = 1;

mysqli_select_db($conn, $dbname) or die ("could not connect");
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
            <div> <?php groet(''); ?>
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

            <a href="#mand">
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

<!--from nieuw account-->
<h1>maak nu uw account aan</h1>
    <form method="post" action="nieuwaccount.php">
        geslacht: <input type="radio" name="gender" value="male" <?php if (isset($_POST['gender']) and $_POST['gender'] == 'male') { print ('checked'); } ?>> man &nbsp;
        <input type="radio"  name="gender" value="female" <?php if (isset($_POST['gender']) and $_POST['gender'] == 'female') { print ('checked'); } ?>> vrouw &nbsp;
        <input type="radio" name="gender" value="other" <?php if (isset($_POST['gender']) and $_POST['gender'] == 'other') { print ('checked'); } ?>> anders<br>
        voornaam: <input type="text" name="firstName" placeholder="Henk" value="<?php if (isset($_POST['firstName'])) {print ($_POST['firstName']);} ?>" autofocus required><br>
        tussenvoegel: <input type="text" name="middelName" placeholder="van" value="<?php if (isset($_POST['middelName'])) {print ($_POST['middelName']);} ?>" autofocus><br>
        achternaam: <input type="text" name="lastName" placeholder="Dreesden" value="<?php if (isset($_POST['lastName'])) {print ($_POST['lastName']);} ?>" autofocus required><br>
        geboortedag: <input type="date" name="birtday" value="<?php if (isset($_POST['birtday'])) {print ($_POST['birtday']);} ?>" autofocus><br>
        mail: <input type="email" name="eMail" placeholder="h.vandreesen@gmail.com" value="<?php if (isset($_POST['eMail'])) {print ($_POST['eMail']);} ?>" autofocus><br>
        controlle mail: <input type="email" name="eMailControlle" placeholder="h.vandreesen$gmail.com" value="<?php if (isset($_POST['eMailControlle'])) {print ($_POST['eMailControlle']);} ?>" autofocus><br>
        telefoonnummer: <input type="tel" name="phoneNumber" placeholder="0612345678" value="<?php if (isset($_POST['tel'])) {print ($_POST['tel']);} ?>" autofocus><br>
        adres: <input type="text" name="adres" placeholder="hendriklaan 1" value="<?php if (isset($_POST['adres'])) {print ($_POST['adres']);} ?>" autofocus><br>
        postcode: <input type="text" name="postcode" placeholder="1234AB" value="<?php if (isset($_POST['postcode'])) { print ($_POST['postcode']); } ?>" autofocus>
        plaats: <input type="text" name="plaats" placeholder="Zwolle" value="<?php if (isset($_POST['plaats'])) { print ($_POST['plaats']); } ?>" autofocus><br><br>
        wachtwoord: <input type="password" name="password" value="<?php if (isset($_POST['password'])) { print ($_POST['password']); } ?>" autofocus><br>
        wachtwoord: <input type="password" name="passwordControlle" value="<?php if (isset($_POST['passwordControlle'])) { print ($_POST['passwordControlle']); } ?>" autofocus><br>
        <button type="submit">verder</button>
    </form>
<?php
if (isset($_POST['gender']) and $_POST['gender'] != '') {
    $gender = $_POST['gender'];
} else {
    $gender = '';
}

if (isset($_POST['firstName']) and $_POST['firstName'] != '') {
    $firstName = $_POST['firstName'];
} else {
    $firstName = '';
}

if (isset($_POST['middelName']) and $_POST['middelName'] != '') {
    $middelName = $_POST['middelName'];
} else {
    $middelName = '';
}

if (isset($_POST['lastName']) and $_POST['lastName'] != '') {
    $lastName = $_POST['lastName'];
} else {
    $lastName = '';
}

if (isset($_POST['birtday']) and $_POST['birtday'] != '') {
    $gender = $_POST['birtday'];
} else {
    $gender = '';
}

if (isset($_POST['tel']) and $_POST['tel'] != '') {
    $telefoonnummer = $_POST['tel'];
} else {
    $telefoonnummer = '';
}

if (isset($_POST['adres']) and $_POST['adres'] != '') {
    $adres = $_POST['adres'];
} else {
    $adres = '';
}

if (isset($_POST['adres']) and $_POST['adres'] != '') {
    $adres = $_POST['adres'];
} else {
    $adres = '';
}

if (isset($_POST['postcode']) and $_POST['postcode'] != '') {
    $postcode = $_POST['postcode'];
} else {
    $postcode = '';
}

if (isset($_POST['plaats']) and $_POST['plaats'] != '') {
    $adres = $_POST['adres'];
} else {
    $adres = '';
}


$querySubmitUser = mysqli_query($conn, "") or die('Geen overeenkomst');

$row = mysqli_fetch_array($querySubmitUser);

?>

</main>
</body>
<?php printFooter(); ?>
</html>
