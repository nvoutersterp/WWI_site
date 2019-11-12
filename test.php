<?php
$connection = new mysqli("localhost", "root", "", "cursus", "3306");
$sql = "select * from medewerker where afd = '30'";
$stmt = $connection->prepare($sql);
$stmt->execute();

while ($row = $stmt->fetch()) {

    // haal de kolom ‘naam’ op
    $naam = $row["naam"];
    print($naam . "\n");
}

$connection->close();



?>