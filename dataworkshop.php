<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>dataworkshop</title>
</head>
<body>
<form method="post" action="dataworkshop.php">
    <input type="text" name="afd">
    <button>sent</button>
</form>
<table>
<?php
//if(isset($_POST["afd"])) {
//    $afd = filter_input(INPUT_POST, "afd", FILTER_SANITIZE_STRING);
//} else {
//    $afd = "";
//}


$db ="mysql:host=localhost;dbname=klant;port=3306";
$user = "root";
$pass = "";
$pdo = new PDO($db, $user, $pass);

$sql = "select * from medewerker where afd =?";
$stmt = $pdo->prepare($sql);
$stmt->execute(array($afd));

while ($row = $stmt->fetch()) {

    // haal de kolom ‘naam’ op
    $naam = $row["naam"];
    $maandsal = $row["maandsal"];
    $afdeling = $row["afd"];
    print("<tr><td>$naam</td><td>$maandsal</td><td>$afdeling</td></tr>");
}

$pdo = NULL;





?>
</table>
hoi
</body>
</html>