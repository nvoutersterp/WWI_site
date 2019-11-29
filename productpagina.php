<?php session_start();

//db
include 'function.php';
$conn = dbconect();
$output = "";
$rij = 1;

mysqli_select_db($conn, $dbname) or die ("could not connect");

//verder....
$werktHet = '';

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
    } else {
        //andere fout
    }
} elseif (!isset($_SESSION['isIngelogt'])){
    $_SESSION['isIngelogt'] = false;
}

?>
<!DOCTYPE HTML>
<HTML lang="EN">
<head>
    <title>WWI</title>
</head>
<body class="body">
<!--link met de bootstraps en stylesheets-->
<header>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</header>
<!--header1 gedefinieerd om een sticky effect te krijgen van top-container en nav-bar-->
<div class=header1 id="header1">
    <div class="top-container" id="top-container" >
        <!--        Laat logo zien met de juiste afmetingen-->
        <a href="index.php" class="logo"><img alt src="images/wwi%20logo%20text.png" width=180px height=50px> </a>
        <!--        snelkoppelingen naar de accountinformatie's-->
        <div class="top-container-right">
            <div> <?php
                if (isset($_SESSION['firstName'])) {
                    $name =  $_SESSION['firstName'];
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
            <?php if ($_SESSION['isIngelogt']) {
                printIsIngelogt();
            } else { ?>
                <div class="login-popup" id="myLogin">
                    <form action="index.php" method="post" class="login-container">
                        inloggen
                        <button type="button" onclick="closeLogin()">Close</button><br>
                        gebruikersnaam: <input type="text" name="username" style="background: gray; color: white" required><br>
                        wachtwoord: <input type="password" name="password" style="background: gray ; color: white" required><br>
                        <a href="nieuwaccount.php">nog geen account? Maak er nu een aan!</a><br>
                        <input type="hidden"<?php if (isset($_POST['search'])) {
                            $search = $_POST['search'];
                            print ('naam="search" value="'.$search.'"');
                        } elseif (isset($_POST['input'])) {
                            $input = $_POST['input'];
                            print ('naam="input" value="'.$input.'""');
                        } ?> >
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

            <a href="#mand">
                <div class="icon">
                    <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                </div>
            </a>
            <a href="#verlanglijst">
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


    <form action="productpagina.php" method="post">
        <select name="aantal">
            <option value="25" <?php if (isset($_POST['aantal'])) { if ($_POST['aantal'] == '25'){ print ('selected') ; }} ?>>25</option>
            <option value="50" <?php if (isset($_POST['aantal'])) { if ($_POST['aantal'] == '50'){ print ('selected') ; }} ?>>50</option>
            <option value="100" <?php if (isset($_POST['aantal'])) { if ($_POST['aantal'] == '100'){ print ('selected') ; }} ?>>100</option>
        </select>
        <select name="orderBy">
            <option value="abc_up" <?php if (isset($_POST['orderBy'])) { if ($_POST['orderBy'] == 'abc_up'){ print ('selected') ; }} ?>>abc</option>
            <option value="abc_down" <?php if (isset($_POST['orderBy'])) { if ($_POST['orderBy'] == 'abc_down'){ print ('selected') ; }} ?>>zyx</option>
            <option value="price_up" <?php if (isset($_POST['orderBy'])) { if ($_POST['orderBy'] == 'price_up'){ print ('selected') ; }} ?>>123</option>
            <option value="price_down" <?php if (isset($_POST['orderBy'])) { if ($_POST['orderBy'] == 'price_down'){ print ('selected') ; }} ?>>321</option>
        </select>
        <?php if (isset($_POST['input'])){
            $input = $_POST['input'];
            print ("<input type='hidden' name='input' value='$input'>");
        } else {

        } ?>
        <button type="submit">>></button>
    </form>

    <?php
    //sorteren op...
    if (isset($_POST['orderBy'])) {                                     //nog implementieren in SQL
        $pieces = explode('_', $_POST['orderBy']);
        if ($pieces[0] == 'abc') {
            $orderSoort = 'StockItemName';
        } elseif ($pieces[0] == 'price') {
            $orderSoort = 'UnitPrice';
        }
        if ($pieces[1] == 'up') {
            $orderType = 'asc';
        } else {
            $orderType = 'desc';
        }
        $orderBy = 'order by '. $orderSoort.' '.$orderType;
    } else {
        $orderBy = '';
    }

    //verkrijgen producten uit zoek resultaat
    $count = 0;
    if (isset($_POST['search'])) {
        $searchq = $_POST['search'];
        $query1 = mysqli_query($conn, " SELECT StockItemID, StockItemName, Photo, UnitPrice FROM stockitems WHERE stockitemname LIKE '%$searchq%' OR SearchDetails LIKE '%$searchq%' or Tags like '%$searchq%'") or die('Geen overeenkomst');
        $count = mysqli_num_rows($query1);
    } elseif (isset($_POST['input'])) {
        $inputq = $_POST['input'];
        $query1 = mysqli_query($conn, "select StockItemID, StockItemName, Photo, UnitPrice from stockitems where stockitemid in (select StockItemID from stockitemstockgroups where StockGroupID in (select StockGroupID from stockgroups where StockGroupName = '$inputq'))") or die('Geen overeenkomst');
        $count = mysqli_num_rows($query1);
    }

    if ($count == 0) {
        print ('sorry, we konden geen producten ophalen');
    } else {
    //gegevens ophalen//
    print ('<div>');
    while ($row = mysqli_fetch_array($query1)) {
    if ($rij % 3 == 1) {
        print ('<div>');
    }

    // data opslaan in variabelen, in: gegevens uit data base, uit: toonbare variabeln
    $productID = $row['StockItemID'];
    $productNaam = $row['StockItemName'];
    $productFoto = $row['Photo'];
    $productPrijs = $row['UnitPrice'] * 0.9;

    //extra info
    //    $maatArray = array('3XS', 'XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL', '4XL', '5XL', '6XL', '7XL');
    //    $vervang = '';
    //    $pieces = explode(' ', $productNaam);
    //    $lastWord = array_pop($pieces);
    //    if ($lastWord == '3XS' OR 'XXS' OR 'XS' or 'S' or 'M' or 'L' or 'XL' or 'XXL' or '3XL' or '4XL' or '5XL' or '6XL' or '7XL') {
    //        str_replace($maatArray, $vervang, $productNaam);
    //    }


    //weergave//
    ?>
    <a class="section"
       href="productoverzicht.php?productID=<?php print ($productID); ?>"> <?php echo '<img class="productfoto" src="data:image/jpeg;base64, ' . base64_decode($row['Photo']) . '"/>'; ?><?php
        print ($productNaam . '&nbsp €' . $productPrijs . '&nbsp');
        print ($row['Photo']);
        $rij++;
        print ('</a>');
        }
        }

        mysqli_close($conn);
        print("<br>$count producten gevonden")
        ?>

        <!--te komen-->


</main>
        <?php printFooter(); ?>
</body>
</html>