<?php session_start();

//db
include 'function.php';
$conn = dbconect();
$output = "";

mysqli_select_db($conn, $dbname) or die ("could not connect");

if (isset($_POST['quantity']) and isset($_POST['stockItemID'])) {
    $_SESSION['winkelmand'][0] = 0;
    if (array_key_exists($_POST['stockItemID'], $_SESSION['winkelmand'])){
        $_SESSION['winkelmand'][$_POST['stockItemID']] += $_POST['quantity'];
    } else {
        $_SESSION['winkelmand'][$_POST['stockItemID']] = $_POST['quantity'];
    }
    unset($_SESSION['winkelmand'][0]);
}

if (isset($_POST['clearBukket'])) {
    if ($_POST['clearBukket']) {
        unset($_SESSION['winkelmand']);
    }
}

?>
<!DOCTYPE HTML>
<head>
    <title>WWI</title>
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
                    <i class="fa fa-sign-in" aria-hidden="true" onclick="openLogin()"></i>
                </div>
            </a>
            <?php if (isset($_SESSION['isIngelogt']) and $_SESSION['isIngelogt']) {
                printIsIngelogt();
            } else { ?>
                <div class="login-popup" id="myLogin">
                    <form action="index.php" method="post" class="login-container">
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
if (isset($_SESSION['winkelmand'])){
    $totPrice = 0;
    foreach ($_SESSION['winkelmand'] as $productID => $quantity) {
        $productInfoQuery = mysqli_query($conn, "select * from stockitems where StockItemID = '$productID'");
        $productInfo = mysqli_fetch_array($productInfoQuery);

        $stockItemName = $productInfo['StockItemName'];
        $unitPrice = $productInfo['UnitPrice']*0.9;
        $unitPriceCorrect = str_replace('.', ',', $unitPrice);
        $productprijs = $unitPrice*$quantity;
        $productprijsCorrect = str_replace('.', ',', $productprijs);
        $totPrice += $productprijs;
        $totPriceCorrect = str_replace('.', ',', $totPrice);

        print("u koopt $quantity keer $stockItemName. Deze kost per stuk €$unitPriceCorrect en in totaal €$productprijsCorrect. <br>");
    }
    print ("in totaal kost het €$totPriceCorrect");
} else {
    print ('u heeft nog niks in uw winkelmand liggen, doe dat gauw!');
}


?>

<form action="winkelmand.php" method="post">
    <input type="hidden" name="clearBukket" value="true">
    <button type="submit">leeg winkelmand</button>
</form>

</main>
<?php printFooter(); ?>
</body>
</html>