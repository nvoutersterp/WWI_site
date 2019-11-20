<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8   ">
    <title>WWI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--links -->
    <link rel="script" href="js/custom.js">
    <!-- CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
</head>
<body>

<header id="header02" class="flex-header">

    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="Clothing">
        <input type="submit" name="submit" value="kleding" class="tabjes">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="Mugs">
        <input type="submit" name="submit" value="Mokken" class="tabjes">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="T-Shirts">
        <input type="submit" name="submit" value="T-Shirts" class="tabjes">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="Airline Novelties">
        <input type="submit" name="submit" value="Kheb geen idee" class="tabjes">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="Computing Novelties">
        <input type="submit" name="submit" value="Nieuwe computer items" class="tabjes">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="USB Novelties">
        <input type="submit" name="submit" value="USB sticks" class="tabjes">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="Furry Footwear">
        <input type="submit" name="submit" value="Zachte Sokken" class="tabjes">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="Toys">
        <input type="submit" name="submit" value="Speelgoed" class="tabjes">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="Packaging Materials">
        <input type="submit" name="submit" value="Inpak Materiaal" class="tabjes">
    </form>
    <div id ="gratis">
        <img src="images/gratis%20verzending.PNG" class ="gratis1" >
    </div>
</header>

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

    <div class="header-right">
        <a class="menu1" href="#inloggen">
            <img src="images/inloggen.png" class="header-right-img">
        </a>

        <a class="menu1" href="#favo">
            <img src="images/verjanglijstje.png" class="header-right-img">
        </a>

        <a class="menu1" href="#mand">
            <img src="images/winkelmandje.png" class="header-right-img">
        </a>
    </div>
</header>
<main>
    <br><br><br><br><br><br><br>

<?php
include "function.php";
$dbname = "wideworldimporters";
$conn = dbconect();

$productID = $_GET['productID'];

$db ="mysql:host=localhost;dbname=cursus;port=3306";
$user = "root";
$pass = "";
$pdo = new PDO($db, $user, $pass);

mysqli_select_db($conn, $dbname) or die ("could not connect");

$query1 = mysqli_query($conn, "SELECT StockItemName, UnitPrice, Photo, QuantityOnHand, SearchDetails FROM stockitems S JOIN stockitemholdings H ON S.StockItemid = H.StockItemid WHERE S.StockItemid='$productID'") or die('Geen overeenkomst');

$row = mysqli_fetch_array($query1);


$naam = $row['StockItemName'];
$prijs = $row["UnitPrice"];
$afbeelding = $row["Photo"];
$vooraad = $row["QuantityOnHand"];
$omschrijving = $row["SearchDetails"];

?>

<div id="overzicht1">
    <h2><?php print($naam);?></h2>
    <img src="#images/wwi%20logo%20text.png">
</div>
<div id="overzicht2">
    <p>€<?php print($prijs);?></p>
    <p>Omschrijving: <?php print($omschrijving);?></p>
    <p><input type="number" name="aantal" min="1" max="<?php print($vooraad)?>" placeholder="1"> aantal</p>
    <p>Nog in vooraad: <?php print($vooraad);?></p>
    <p><button>Toevoegen aan winkelwagen</button></p>
</div>
</body>
</html>
