<?php session_start(); ?>
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
    <?php
    include 'function.php';
    $output = '';
    $conn = dbconect();
    $output = "";
    $rij = 1;

    mysqli_select_db($conn, $dbname) or die ("could not connect");

    $query5 = mysqli_query($conn, "select StockGroupName, DutchName from stockgroups");

    while ($rowGroup = mysqli_fetch_array($query5)) {
        ?>
        <form action="productpagina.php" method="POST">
            <input type="hidden" name="input" value="<?php print ($rowGroup['StockGroupName']); ?>">
            <input type="submit" name="submit" value="<?php print ($rowGroup['DutchName']); ?>" class="tabjes">
        </form>
    <?php } ?>
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
        <a class="menu" href="#inloggen">/inloggen\</a>
        <a class="menu" href="#favo">/favo\</a>
        <a class="menu" href="#mand">/mandje\</a>
    </div>
</header>
<main>
    <br><br><br><br><br><br>


    <form action="productpagina.php" method="post">
        <select name="aantal">
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
        <button type="submit">>></button>
    </form>

    <?php

    //verkrijgen //
    if (isset($_POST['search'])) {
        $searchq = $_POST['search'];
        $query1 = mysqli_query($conn, " SELECT StockItemID, StockItemName, Photo, UnitPrice FROM stockitems WHERE stockitemname LIKE '%$searchq%' OR SearchDetails LIKE '%$searchq%'") or die('Geen overeenkomst');
    } elseif (isset($_POST['input'])) {
        $inputq = $_POST['input'];
        $query1 = mysqli_query($conn, "select StockItemID, StockItemName, Photo, UnitPrice from stockitems where stockitemid in (select StockItemID from stockitemstockgroups where StockGroupID in (select StockGroupID from stockgroups where StockGroupName = '$inputq'))") or die('Geen overeenkomst');
    }
    $count = mysqli_num_rows($query1);
    if ($count == 0) {
        print ('Er zijn geen resultaten gevonden...');
    } else {
    //gegevens ophalen//
    print ('<div>');
    while ($row = mysqli_fetch_array($query1)) {
    if ($rij % 3 == 1) {
        print ('<div>');
    }
    $productID = $row['StockItemID'];
    $productNaam = $row['StockItemName'];
    $productFoto = $row['Photo'];
    $productPrijs = $row['UnitPrice'];

    //weergave//
    ?>
    <a class="section"
       href="productoverzicht.php?productID=<?php print ($productID); ?>"> <?php echo '<img class="productfoto" src="data:image/jpeg;base64, ' . base64_decode($row['Photo']) . '"/>'; ?><?php
        print ($productNaam . '&nbsp' . $productPrijs . '&nbsp');
        print ($row['Photo']);
        $rij++;
        print ('</a>');
        }
        }
        //Afsluiten Database//
        mysqli_close($conn);

        print("<br>$count producten gevonden")
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


<footer class="site-footer custom-border-top">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">

                <div class="col-md-6 col-lg-3">
                    <div class="block-5 mb-5">
                        <h3 class="footer-heading mb-4">Contact Info</h3>
                        <ul class="list-unstyled">
                            <li class="address">Windesheim</li>
                            <li class="phone"><a href="tel://0623479034">0623479034</a></li>
                        </ul>
                    </div>


                </div>
            </div>

        </div>
    </div>
</footer>
</body>
</html>