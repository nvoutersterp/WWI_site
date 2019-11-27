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
<!DOCTYPE html>
<html lang="nl">
<?php printHead(); ?>
<body>
<?php printcategorie($conn); ?>

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

    <div>
        <div class="menu1">
            <img src="images/inloggen.png" class="header-right-img" onclick="openLogin()">
            <?php if ($_SESSION['isIngelogt']) {
                    printIsIngelogt();
                } else { ?>
            <div class="login-popup" id="myLogin">
                <form action="productpagina.php" class="login-container">
                    inloggen
                    <button type="button" onclick="closeLogin()">Close</button>
                    <br>
                    gebruikersnaam: <input type="text" style="background: gray; color: white" required><br>
                    wachtwoord: <input type="password" style="background: gray ; color: white" required><br>
                    <a href="#nieuwAccount">nog geen account? maak er nu een aan!</a><br>
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
        </div>
        <a class="menu1" href="#favo">
            <img src="images/verjanglijstje.png" class="header-right-img">
        </a>

        <a class="menu1" href="#mand">
            <img src="images/winkelmandje.png" class="header-right-img">
        </a>
        <?php if (isset($_SESSION['firstName'])) {
            print ('welkom, ' . $_SESSION['firstName']);
        } ?>
    </div>
</header>
<main>

    <br><br><br><br><br><br>


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