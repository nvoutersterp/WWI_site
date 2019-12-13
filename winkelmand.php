<?php session_start();

//db
include 'function.php';
$conn = dbconect();
$output = "";

mysqli_select_db($conn, $dbname) or die ("could not connect");


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
    } elseif ($ant == 4) {
        //is inactief
    } else {
        //andere fout
    }
}

if (isset($_POST['quantity']) and isset($_POST['stockItemID'])) {
    $_SESSION['winkelmand'][0] = 0;
    if (array_key_exists($_POST['stockItemID'], $_SESSION['winkelmand'])) {
        $_SESSION['winkelmand'][$_POST['stockItemID']] += $_POST['quantity'];
    } else {
        $_SESSION['winkelmand'][$_POST['stockItemID']] = $_POST['quantity'];
    }
    unset($_SESSION['winkelmand'][0]);
}

if (isset($_POST['toDelete'])) {
    $deleteID = $_POST['toDelete'];
    unset($_SESSION['winkelmand'][$deleteID]);
}

if (isset($_POST['alterQuantity']) and isset($_POST['alterQuantityID'])) {
    $_SESSION['winkelmand'][$_POST['alterQuantityID']] = $_POST['alterQuantity'];
}

if (isset($_POST['clearBukket'])) {
    if ($_POST['clearBukket']) {
        unset($_SESSION['winkelmand']);
        header("refresh:0");
    }
}

?>
<!DOCTYPE HTML>
<head>
    <title>WWI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<HTML lang="EN">
<body class="body">
<!--link met de bootstraps en stylesheets-->
<header>
    <link href="css/bootstrap.min.css" rel="stylesheet">
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
            <div> <?php
                if (isset($_SESSION['firstName'])) {
                    $name = $_SESSION['firstName'];
                } else {
                    $name = '';
                }
                groet($name);
                ?>
            </div>
            <a>
                <div class="icon">
                    <i class="fa fa-user" aria-hidden="true" onclick="openLogin()"></i>
                </div>
            </a>
            <?php if (isset($_SESSION['isIngelogt']) and $_SESSION['isIngelogt']) {
                printIsIngelogt();
            } else { ?>
                <div class="login-popup" id="myLogin">
                    <form action="winkelmand.php" method="post" class="login-container">
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

            <a href="winkelmand.php">
                <div class="icon">
                    <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                </div>
            </a>
            <a href="favorieten.php">
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

<?php
if (isset($_SESSION['winkelmand'])) {
$totPrice = 0;
foreach ($_SESSION['winkelmand'] as $productID => $quantity) {
$productInfoQuery = mysqli_query($conn, "select * from stockitems where StockItemID = '$productID'");
$productInfo = mysqli_fetch_array($productInfoQuery);
$poLength = strlen($productInfo['SearchDetails']);
if ($poLength < 30) {
    $productOmschrijving = $productInfo['SearchDetails'];
} else {
    $maxLength = 30 - $poLength;
    $productOmschrijving = substr_replace($productInfo['SearchDetails'], '...', $maxLength);
}

$stockItemName = $productInfo['StockItemName'];
$unitPrice = $productInfo['UnitPrice'] * 0.9;
$unitPriceCorrect = number_format((float)$unitPrice, 2, ',', '');
$productprijs = $unitPrice * $quantity;
$productprijsCorrect = number_format((float)$productprijs, 2, ',', '');
$totPrice += $productprijs;
$totPriceCorrect = number_format((float)$totPrice, 2, ',', '');

$photoRow = mysqli_query($conn, "select * from photo where StockItemID = '$productID'");
$issetPhoto = mysqli_num_rows($photoRow);
$Photo = mysqli_fetch_array($photoRow);

if ($issetPhoto != 0) {
    $productFoto = $Photo['photo'];
} else {
    $productFoto = 'images/archixl-logo.png';
}
?>
<div class="row2">
    <div class="card" style="width: 18rem; z-index: 0.5; margin-left: 1%">
        <img class="card-img-top" src="<?php print ($productFoto); ?>" alt="Card image cap">
    </div>
    <div class="card" style="width: 18rem; z-index: 0.5; margin-left: 1%">
        <h5 class="card-title"><?php print($quantity . 'x ' . $stockItemName); ?> </h5>
        <p class="card-text"><?php print($productOmschrijving); ?> </p>
        <p class="card-text"><?php print("Per stuk kost dit € $unitPriceCorrect"); ?> </p>
        <p class="card-text"><?php print("In totaal kost dit € $productprijsCorrect "); ?> </p>
        <form action='winkelmand.php' method='post'>
            <input type='hidden' name='toDelete' value='<?php print ($productID); ?>'>
            <button type='submit'>X</button>
        </form>
        <form action='winkelmand.php' method='post'>
            <select style='margin-left:9px' name='alterQuantity'>
                <?php unset($i);


                while ($i <= 10) {
                    if ($quantity == $i) {
                        $selected = 'selected';
                    } else {
                        $selected = '';
                    }

                    print ("<option value='$i' $selected>$i</option>");
                    $i++;
                } ?>
            </select>
            <input type='hidden' name='alterQuantityID' value='<?php print ($productID); ?>'>
            <button type='submit' class="btn btn-primary btn-sm">>></button>
        </form>
    </div>
</div>

</body>
<?php }
print ("in totaal kost het €$totPriceCorrect<br>");
} else {
    ?>

    <h3 class="font-weight-bold"> U heeft nog niks in uw winkelmand liggen... </h3>
    <?php
}
?>
<?php
$databaseconnect = dbconect();
$loginID = $_SESSION['clientID'];

$queryafrekenen = mysqli_query($conn, "SELECT verify FROM client WHERE clientID = '$loginID'");
$resultafrekenen = mysqli_fetch_array($queryafrekenen);
$verify = $resultafrekenen['verify'];


?>


<?php
if ($totPrice != 0) {
    if ($verify == 1) {
        ?>
        <form action="redirectpayment.php" method="post">
            <input type="hidden" name="value" value="<?php $totPriceNieuw = str_replace(',', '.', $totPriceCorrect); print ($totPriceNieuw); ?>">
            <button class="btn btn-primary btn-lg type=" submit
            ">afrekenen</button>
        </form><br>
        <?php
    } else {
        ?>


        <p style='color:red'><br><br>Om te kunnen betalen moet u eerst uw account verifieren! Dit staat in uw
            geregistreerde
            mail.</p>

        <?php
    }
}
?>

<form action="winkelmand.php" method="post">
    <input type="hidden" name="clearBukket" value="true">
    <button type="submit" class="btn btn-secondary btn-lg">leeg winkelmand</button>
</form>

</main>
<?php printFooter(); ?>
</body>
</html>