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
    include'function.php';
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
    <?php } //Afsluiten Database//
    mysqli_close($conn); ?>
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
    <br><br><br><br><br><br>

    <!-- database doet het -->
    <?php
    mysqli_select_db($conn, $dbname) or die ("could not connect");

    //verkrijgen zoekopdracht
    if(isset($_POST["search"])) {
        $searchq = $_POST["search"];
        $query1 = mysqli_query($conn, " SELECT *
 FROM stockitems 
 WHERE stockitemname LIKE '%$searchq%'
 AND SearchDetails LIKE '%$searchq%'") or die('Kan niet zoeken');
        $count = mysqli_num_rows($query1);
        if ($count == 0) {
            $output = 'Er zijn geen resultaten gevonden...';
        } else {
            while ($row = mysqli_fetch_array($query1)) {
                $naamitem = $row['StockItemName'];
                $output .= '<div>' . $naamitem;
            }
        }
        mysqli_close($conn);
    }
    print("$output");
    ?>



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