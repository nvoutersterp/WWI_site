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

<?php
//vast stellen
$limit = 500;
$offset = 0;
$pagina = 1;
$rij = 1;

?>

<header id="header02" class="flex-header">

    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="Clothing">
        <input type="submit" name="submit" value="kleding" class="tabjes">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="Mugs">
        <input type="submit" name="submit" value="Mokken" class="tabjes">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="T-Shirts">
        <input type="submit" name="submit" value="T-Shirts" class="tabjes">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="Airline Novelties">
        <input type="submit" name="submit" value="Kheb geen idee" class="tabjes">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="Computing Novelties">
        <input type="submit" name="submit" value="Nieuwe computer items" class="tabjes">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="USB Novelties">
        <input type="submit" name="submit" value="USB sticks" class="tabjes">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="Furry Footwear">
        <input type="submit" name="submit" value="Zachte Sokken" class="tabjes">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="Toys">
        <input type="submit" name="submit" value="Speelgoed" class="tabjes">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="Packaging Materials">
        <input type="submit" name="submit" value="Inpak Materiaal" class="tabjes">
    </form>
    <div id ="gratis">
        <img src="images/gratis%20verzending.PNG" class ="gratis1" >
    </div>
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
        <a class="menu1" href="#inloggen">
            <img src="images/inloggen.png" class="header-right-img">
        </a>

        <a class="menu1" href="#favo">
            <img src="images/verjanglijstje.png" class="header-right-img">
        </a>

        <a class="menu1" href="#mand">
            <img src="images/winkelmandje.png" class="header-right-img">
        </a>
    </div>
</header>
<main>
    <br><br><br><br><br><br><br>

    <!--werkt nog niet
    <form action="productpagina.php" method="post">
        <select name="aantal">
            <option value="25"<?php if (isset($_POST['aantal'])) {
        if ($_POST['aantal'] == 25) {
            print ('selected');
            $limit = 25;
        }
    } ?>>25</option>
            <option value="50"<?php if (isset($_POST['aantal'])) {
        if ($_POST['aantal'] == 50) {
            print ('selected');
            $limit = 50;
        }
    } ?>>50</option>
            <option value="100"<?php if (isset($_POST['aantal'])) {
        if ($_POST['aantal'] == 100) {
            print ('selected');
            $limit = 100;
        }
    } ?>>100</option>
        </select>
        <input type="submit" name="submit" value=">>"></input>
    </form>
    -->

    <?php

    //code
    for ($i = 1; $i < $pagina; $i++) {
        $offset += $limit;
    }

    //instellen database
    include 'function.php';
    $dbname = "wideworldimporters";
    $output = '';
    $conn = dbconect();
    $output = "";

    mysqli_select_db($conn, $dbname) or die ("could not connect");

    //verkrijgen
    if (isset($_POST['search'])) {
        $searchq = $_POST['search'];
        $query1 = mysqli_query($conn, " SELECT StockItemID FROM stockitems WHERE stockitemname LIKE '%$searchq%' OR SearchDetails LIKE '%$searchq%' OR StockItemID LIKE '%$searchq%' limit $limit offset $offset") or die('Geen overeenkomst');
        $queryTotaal = mysqli_query($conn, " SELECT StockItemID FROM stockitems WHERE stockitemname LIKE '%$searchq%' OR SearchDetails LIKE '%$searchq%' OR StockItemID LIKE '%$searchq%'") or die('Geen overeenkomst');
    } elseif (isset($_POST['input'])) {
        $inputq = $_POST['input'];
        $query1 = mysqli_query($conn, "select StockItemID from stockitemstockgroups where StockGroupID in (select StockGroupID from stockgroups where StockGroupName = '$inputq') limit $limit offset $offset") or die('Geen overeenkomst');
        $queryTotaal = mysqli_query($conn, "select StockItemID from stockitemstockgroups where StockGroupID in (select StockGroupID from stockgroups where StockGroupName = '$inputq')") or die('Geen overeenkomst');
    }
    $count = mysqli_num_rows($query1);
    if ($count == 0) {
        print ('Er zijn geen resultaten gevonden...');
    } else {
    print ('<div>');
    while ($row = mysqli_fetch_array($query1)) {
    if ($rij % 3 == 1) {
        print ('<div>');
    }
    //gegevens ophalen//
    $productID = $row['StockItemID'];
    $query2 = mysqli_query($conn, "select StockItemName, Photo, UnitPrice from stockitems where StockItemID = '$productID'");
    $result = mysqli_fetch_array($query2);
    $productNaam = $result['StockItemName'];
    $productFoto = $result['Photo'];
    $productPrijs = $result['UnitPrice'];
    //weergave//
    ?>
    <a class="section"
       href="productoverzicht.php?productID=<?php print ($productID); ?>"> <?php echo '<img class="productfoto" src="data:image/jpeg;base64, ' . base64_decode($result['Photo']) . '"/>'; ?><?php
        print ($productNaam . '&nbsp' . $productPrijs . '&nbsp');
        print ($result['Photo']);
        $rij++;
        print ('</a>');
        }
        }


        mysqli_close($conn);

        print("<br>$count producten gevonden");


        //aantal pagina's
        $countTotaal = mysqli_num_rows($queryTotaal);
        while ($countTotaal > $limit) {
            print ('<br><button>hoi</button>');
            $countTotaal -= $_POST['aantal'];
        }


        ?>

        <!--te komen-->

</main>


<button onclick="topFunction()" class="page_up_button" title="Go to top">
    <img src="images/external-content.duckduckgo.jpg">
    <script>
        upbutton = document.getElementsByClassName("page_up_button");

        window.onscroll = function () {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
                upbutton.style.display = "block";
            } else {
                upbutton.style.display = "none";
            }
        }

        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
</button>


<footer>
    <!-- te komen -->
</footer>
</body>
</html>