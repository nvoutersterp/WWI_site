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
    <a href="#kleding">kleding</a>
</header>
<!-- floading header with nav -->
<header id="header01" class="flex-header">
    <div>
        <a href="home.php">
            <img src="images/wwi%20logo%20text.png" class="logo">
        </a>
    </div>
    <div>
        <input size="30" type="search" name="search" placeholder="    Hoi, wat wil je kopen?" autocapitalize="off"
               autocomplete="off" spellcheck="false">
    </div>
    <div class="header-right">
        <a class="menu" href="#inloggen">/inloggen\</a>
        <a class="menu" href="#favo">/favo\</a>
        <a class="menu" href="#mand">/mandje\</a>
    </div>
</header>
<?php
include "function.php";
$connect = dbconnect();
$dbname = "wideworldimporters";

dbconect();
$stmt = $pdo->prepare("SELECT StockItemName FROM stockitems WHERE StockItemid=1");
$stmt->execute();

// loop langs alle rijen
while ($row = $stmt->fetch()) {

    // haal de kolom ‘naam’ op
    $naam = $row["StockItemName"];
    print($naam . "<br>");
}

?>

<br><br><br><br>
<div id="productoverzicht">
    <h1>naam</h1>
    <img src="images/wwi%20logo%20text.png">
    <p><select name="maat">
            <option value="s">S</option>
            <option value="m">M</option>
            <option value="l">L</option>
            <option value="xl">XL</option>
        </select>maat</p>
    <p>prijs></p>
    <p><input type="number" placeholder="1">aantal</p>
    <p><button>Toevoegen aan winkelwagen</button></p>
</div>
</body>
</html>
//te komen//

