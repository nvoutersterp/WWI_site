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
    } else {
        //andere fout
    }
}

?>
<!DOCTYPE html>
<html lang="nl">
<?php printHead(); ?>
<body>
<?php printcategorie($conn); ?>

<!-- floading header with nav -->
<header id="header01" class="flex-header">
    <div>
        <a href="home.php">
            <img src="images/wwi%20logo%20text.png" class="logo">
        </a>
    </div>

    <div>
        <form action="productpagina.php" method="POST">
            <input size="30" type="search" name="search" placeholder="    Hoi, wat wil je kopen?" autocapitalize="off"
                   autocomplete="off" spellcheck="false">
            <input type="submit" name="submit" value=">>">
        </form>
    </div>
<?php
//devinieren
if (isset($_POST['productID'])){
    $productID = $_POST['productID'];
} else {
    $productID = $_GET['productID'];
} ?>
    <div class="header-right">
        <div class="menu1">
            <img src="images/inloggen.png" class="header-right-img" onclick="openLogin()">
            <?php if ($_SESSION['isIngelogt']) {
                printIsIngelogt();
            } else { ?>
            <div class="login-popup" id="myLogin">
                <form action="productoverzicht.php" class="login-container">
                    inloggen
                    <button type="button" onclick="closeLogin()">Close</button>
                    <br>
                    gebruikersnaam: <input type="text" style="background: gray; color: white" required><br>
                    wachtwoord: <input type="password" style="background: gray; color: white" required><br>
                    <a href="#nieuwAccount">nog geen account? maak er nu een aan!</a><br>
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
        </div>
        <a class="menu1" href="#favo">
            <img src="images/verjanglijstje.png" class="header-right-img">
        </a>

        <a class="menu1" href="#mand">
            <img src="images/winkelmandje.png" class="header-right-img">
        </a>
        <?php if (isset($_SESSION['firstName'])) {
            print ('welkom, ' . $_SESSION['firstName']);
        } ?>
    </div>
</header>
<main>
    <br><br><br><br><br><br><br>

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
</body>
</html>
