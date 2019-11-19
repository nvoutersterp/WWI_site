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
        <input type="submit" name="submit" value="kleding">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="Mugs">
        <input type="submit" name="submit" value="Mokken">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="T-Shirts">
        <input type="submit" name="submit" value="T-Shirts">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="Airline Novelties">
        <input type="submit" name="submit" value="Kheb geen idee">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="Computing Novelties">
        <input type="submit" name="submit" value="Nieuwe computer items">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="USB Novelties">
        <input type="submit" name="submit" value="USB sticks">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="Furry Footwear">
        <input type="submit" name="submit" value="Zachte Sokken">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="Toys">
        <input type="submit" name="submit" value="Speelgoed">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="Packaging Materials">
        <input type="submit" name="submit" value="Inpak Materiaal">
    </form>

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
        <a class="menu" href="#inloggen">/inloggen\</a>
        <a class="menu" href="#favo">/favo\</a>
        <a class="menu" href="#mand">/mandje\</a>
    </div>
</header>
<main>
    <br><br><br><br>

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

$query1 = mysqli_query($conn, "SELECT StockItemName, UnitPrice, Photo FROM stockitems WHERE StockItemid='$productID'") or die('Geen overeenkomst');

$row = mysqli_fetch_array($query1);

$naam = $row['StockItemName'];
$prijs = $row["UnitPrice"];
$afbeelding = $row["Photo"];


?>

<div id="overzicht1">
    <h2><?php print($naam);?></h2>
    <img src="#images/wwi%20logo%20text.png">
</div>
<div id="overzicht2">
    <p>€<?php print($prijs);?></p>
    <p><input type="number" placeholder="1">aantal</p>
    <p><button>Toevoegen aan winkelwagen</button></p>
</div>
</body>
</html>
