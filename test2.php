<?php
$tekst = 'hoi, hier staat tekst';
$pieces = explode(' ', 'hoi, hier staat tekst?');
$lastWord = array_pop($pieces);
print_r($pieces);

$sql = '';
foreach ($pieces as $index => $valeu) {
    $sql .= " " . $valeu;
}



include 'function.php';
$conn = dbconect();
$output = "";

mysqli_select_db($conn, $dbname) or die ("could not connect");

$query1 = mysqli_query($conn, "SELECT * FROM stockitems S JOIN stockitemholdings H ON S.StockItemid = H.StockItemid join photo p on S.StockItemID = p.StockItemID WHERE S.StockItemid = 1") or die('Geen overeenkomst');

$row = mysqli_fetch_array($query1);


$naam = $row['StockItemName'];
$prijs = $row["UnitPrice"] * 0.9;
$vooraad = $row["QuantityOnHand"];
$omschrijving = $row["SearchDetails"];
$row['photo'];
$i = 1;


    foreach ($row['photo'] as $photo) {
        print ($photo);
}

