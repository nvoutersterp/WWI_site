<?php session_start();

//db
use PHPMailer\PHPMailer\PHPMailer;
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="body">
<!--link met de bootstraps en stylesheets-->
<header>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</header>
<!--header1 gedefinieerd om een sticky effect te krijgen van top-container en nav-bar-->
<div class=header1 id="header1">
    <div class="top-container" id="top-container">
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
            <?php if (isset($_SESSION['isIngelogt']) and $_SESSION['isIngelogt']) {
                printIsIngelogt();
            } else { ?>
                <div class="login-popup" id="myLogin">
                    <form action="index.php" method="post" class="login-container">
                        inloggen
                        <button type="button" onclick="closeLogin()">Close</button>
                        <br>
                        gebruikersnaam: <input type="text" name="username" style="background: gray; color: white"
                                               required><br>
                        wachtwoord: <input type="password" name="password" style="background: gray ; color: white"
                                           required><br>
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
<?php
//verwerken
if (isset($_POST['gender']) and isset($_POST['firstName']) and isset($_POST['middelName']) and isset($_POST['lastName']) and isset($_POST['birtday']) and isset($_POST['adres']) and isset($_POST['postcode']) and isset($_POST['plaats'])) {
    if (isset($_POST['eMail']) and isset($_POST['eMailControlle']) and $_POST['eMail'] != '' and $_POST['eMailControlle'] != '') {
        if ($_POST['eMail'] == $_POST['eMailControlle']) {
            if (isset($_POST['password']) and isset($_POST['passwordControlle']) and $_POST['password'] != '' and $_POST['passwordControlle'] != '') {
                if ($_POST['password'] == $_POST['passwordControlle']) {
                    $eMail = $_POST['eMail'];
                    $pasword = $_POST['password'];
                    if (createAccount($eMail, $pasword)) {

                        $gender = $_POST['gender'];
                        $firstName = ucfirst($_POST['firstName']);
                        if (isset($_POST['middelName'])) {
                            $middelName = $_POST['middelName'];
                        } else {
                            $middelName = NULL;
                        }
                        $lastName = ucfirst($_POST['lastName']);
                        $birtday = $_POST['birtday'];
                        if (isset($_POST['phoneNumber'])) {
                            $telefoonnummer = $_POST['phoneNumber'];
                        } else {
                            $telefoonnummer = NULL;
                        }
                        $adres = ucfirst($_POST['adres']);
                        $postcode = $_POST['postcode'];
                        $plaats = ucfirst($_POST['plaats']);
                        $date = date('Y-m-d');

                        $queryCollectNieuwID = mysqli_query($conn, "select clientID from client where eMail = '$eMail'") or die('Geen overeenkomst');

                        $rowClientID = mysqli_fetch_array($queryCollectNieuwID);
                        $clientID = $rowClientID['clientID'];

                        //                        Hidde code
                        $vkey = md5 (time() . $eMail);


                        $querySubmitNieuwClient = mysqli_query($conn, "update client set gender = '$gender', firstName = '$firstName', middelName = '$middelName', lastName = '$lastName', birthday = '$birtday', phoneNumber = '$telefoonnummer', postcode = '$postcode', plaats = '$plaats', adres = '$adres', created = '$date', vkey = '$vkey' where clientID = '$clientID'") or die('Geen overeenkomst');

                        // send email
                        if ($querySubmitNieuwClient) {
                            $to = $eMail;
                            $subject = "Email Verificatie";
                            $message = "<a href='http://localhost/WWI_site/verify.php?vkey=$vkey'>Register Account</a>";
                            $headers = 'From: wwi_site@yahoo.com' . "\r\n" . "MIME-Version: 1.0" . "\r\n" .
                                "Content-type:text/html;charset=UTF-8" . "\r\n";

                            $htmlContent = '
                                    <html> 
                                    <head> 
                                        <title>Welkom bij WorldWideImporters! </title> 
                                    </head> 
                                    <body> 
                                        <h1>Dankjewel '. $firstName.'! Klik op verifieer om uw account te activeren.</h1> 
                                           <table cellspacing="0" style="border: 2px dashed #0b7dda; width: 100%;"> 
                                                <tr> 
                                                    <th>Namens:</th><td><img src="https://i.ibb.co/Tg0WHsY/wwi-logo-text.png" alt="wwi-logo-text"></td> 
                                                </tr> 
                                                <tr style="background-color: #e0e0e0;"> 
                                                    <th>Email:</th><td>contact@wwi.com</td> 
                                                </tr> 
                                                <tr> 
                                                    <th></th><td><a href=\'http://localhost/WWI_site/verify.php?vkey='.$vkey.'\'>Verifieer</a></td> 
                                                </tr>
                                            </table> 
                                    </body> 
                                    </html>';

                            mail($to, $subject, $htmlContent, $headers);
                        }


                        $vervolg = 1;
                    } else {
                        $login = mysqli_query($conn, "select isActive from client where eMail = '$eMail'") or die('Geen overeenkomst');
                        $rowlogin = mysqli_fetch_array($login);

                        if ($rowlogin['isActive'] == 1) {
                            print ('<h1 style="cursor: pointer;" onclick="openLogin()">U staat al geregistreerd, log a.u.b. in</h1>');
                            $vervolg = 0;
                        } elseif ($login == 0) {
                            print ('het ziet er naar uit dat u al bij ons bekent bent, echter staat uw account wel op nonactief. <br> Wilt u dat ongedaan maken? neem dan contact op met de helpdesk.');
                            $vervolg = 0;
                        } else {
                            print ('er is een fout opgetreden, sorry!');
                            $vervolg = 0;
                        }
                    }
                } else {
                    print ('wachtword komt niet overeen');
                    $vervolg = 0;
                }
            } else {
                print ('wachtwoord niet ingevuld');
                $vervolg = 0;
            }
        } else {
            print ('mail komt niet overeen');
            $vervolg = 0;
        }
    } else {
        print ('mail niet ingevuld');
        $vervolg = 0;
    }
} else {
    $vervolg = 0;
}


if ($vervolg == 0) { ?>
    <h1 class="text">maak nu uw account aan</h1>
    <form method="post" action="nieuwaccount.php">
        *geslacht: <input type="radio" name="gender" value="male" <?php if (isset($_POST['gender']) and $_POST['gender'] == 'male') {print ('checked');} ?> required> man &nbsp;
        <input type="radio" name="gender" value="female" <?php if (isset($_POST['gender']) and $_POST['gender'] == 'female') {print ('checked');} ?>> vrouw &nbsp;
        <input type="radio" name="gender" value="other" <?php if (isset($_POST['gender']) and $_POST['gender'] == 'other') {print ('checked');} ?>> anders<br>
        *voornaam: <input type="text" name="firstName" placeholder="Henk" value="<?php if (isset($_POST['firstName'])) {print ($_POST['firstName']);} ?>" autofocus required><br>
        tussenvoegel: <input type="text" name="middelName" placeholder="van" value="<?php if (isset($_POST['middelName'])) {print ($_POST['middelName']);} ?>" autofocus><br>
        *achternaam: <input type="text" name="lastName" placeholder="Dreesden" value="<?php if (isset($_POST['lastName'])) {print ($_POST['lastName']);} ?>" autofocus required><br>
        *geboortedag: <input type="date" name="birtday" value="<?php if (isset($_POST['birtday'])) {print ($_POST['birtday']);} ?>" autofocus required><br>
        *mail: <input type="email" name="eMail" placeholder="h.vandreesen@domein.com" value="<?php if (isset($_POST['eMail'])) {print ($_POST['eMail']);} ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Geef a.u.b. een geldige email op" autofocus required><br>
        *controlle mail: <input type="email" name="eMailControlle" placeholder="h.vandreesen@domein.com" value="<?php if (isset($_POST['eMailControlle'])) {print ($_POST['eMailControlle']);} ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Geef a.u.b. een geldige email op" autofocus required><br>
        telefoonnummer: <input type="tel" name="phoneNumber" placeholder="0612345678" value="<?php if (isset($_POST['phoneNumber'])) {print ($_POST['phoneNumber']);} ?>" pattern="[0-9.+]{,12}" title="geef een geldig nummer op (zonder '-')." autofocus><br>
        *adres: <input type="text" name="adres" placeholder="hendriklaan 1" value="<?php if (isset($_POST['adres'])) {print ($_POST['adres']);} ?>" autofocus required><br>
        *postcode: <input type="text" name="postcode" placeholder="1234AB" value="<?php if (isset($_POST['postcode'])) {print ($_POST['postcode']);} ?>" pattern="[0-9]{4}[A-Z]{2}$" title="geef een geldig postcode op in de vorm: 1234AB" autofocus required>
        *plaats: <input type="text" name="plaats" placeholder="Zwolle" value="<?php if (isset($_POST['plaats'])) {print ($_POST['plaats']);} ?>" autofocus required><br><br>
        *wachtwoord: <input type="password" name="password" value="<?php if (isset($_POST['password'])) {print ($_POST['password']);} ?>" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Gebruik minimaal een cijfer, een hoofdletter en een kleine letter. Ook moet het wachtwoord minimaal acht karakters hebben" autofocus required><br>
        *controlle wachtwoord: <input type="password" name="passwordControlle" value="<?php if (isset($_POST['passwordControlle'])) {print ($_POST['passwordControlle']);} ?>" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Gebruik minimaal een cijfer, een hoofdletter en een kleine letter. Ook moet het wachtwoord minimaal acht karakters hebben" autofocus required><br>
        <button type="submit">verder</button>
    </form>
    <?php
} elseif ($vervolg == 1) { ?>
<form action="index.php" method="post" class="accountResultForm">
    <input type="hidden" name="username" value="<?php print ($eMail); ?>">
    <input type="hidden" name="password" value="<?php print ($pasword); ?>">
    <h1><?php print ($firstName); ?>, uw account is succesvol aangemaak!</h1><br><p> Controlleer uw email voor de verificatiecode</p>

    <button type="submit"><?php if (isset($_SESSION['fromShoppingCart']) and $_SESSION['fromShoppingCart']) {
            print ('Ga verder met afrekkennen');
        } else {
        print ('Ga verder met winkelen');
    } ?></button>
</form>
    <?php }

?>

</main>
</body>
<?php printFooter(); ?>
</html>
