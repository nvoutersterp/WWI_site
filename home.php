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
    <
</head>
<body>
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


<!-- database doet het -->
<?php
include 'function.php';

$conn = dbconect();

$sql = "SELECT temperature FROM vehicletemperatures";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "temp: " . $row["temperature"] . "<br>";
    }
} else {
    echo "geen reseltaten";
}

$conn->close();
?>

</body>
</html>