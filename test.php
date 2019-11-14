<?php
$connection = new mysqli("localhost", "root", "", "cursus", "3306");
$sql = "select * from medewerker where afd = '30'";
$stmt = $connection->prepare($sql);
$stmt->execute();

while ($row = $stmt->fetch()) {

    // haal de kolom ‘naam’ op
    $naam = $row["naam"];
   // print($naam . "\n");
}

$connection->close();


include "function.php";
$dbname = "wideworldimporters";
$conn = dbconect();

$productID = 20;

$db = "mysql:host=localhost;dbname=cursus;port=3306";
$user = "root";
$pass = "";
$pdo = new PDO($db, $user, $pass);

mysqli_select_db($conn, $dbname) or die ("could not connect");

$query1 = mysqli_query($conn, "SELECT StockItemName, UnitPrice, Photo FROM stockitems WHERE StockItemid='$productID'") or die('Geen overeenkomst');

$row = mysqli_fetch_array($query1);

$naam = $row['StockItemName'];
$prijs = $row["UnitPrice"];
$afbeelding = $row["Photo"];

print   ($naam);
?>