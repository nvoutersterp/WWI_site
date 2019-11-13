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
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="Clothing">
        <input type="submit" name="submit" value="kleding">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="Mugs">
        <input type="submit" name="submit" value="Mokken">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="T-Shirts">
        <input type="submit" name="submit" value="T-Shirts">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="Airline Novelties">
        <input type="submit" name="submit" value="Kheb geen idee">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="Computing Novelties">
        <input type="submit" name="submit" value="Nieuwe computer items">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="USB Novelties">
        <input type="submit" name="submit" value="USB sticks">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="Furry Footwear">
        <input type="submit" name="submit" value="Zachte Sokken">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="Toys">
        <input type="submit" name="submit" value="Speelgoed">
    </form>
    <form action="productpagina.php" method="POST">
        <input type="hidden" name="input" value="Packaging Materials">
        <input type="submit" name="submit" value="Inpak Materiaal">
    </form>

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
<br><br><br><br>
<main>

    <?php
    include 'function.php';
    $dbname = "wideworldimporters";
    $output = '';
    $bladeren = false;
    $conn = dbconect();
    $output = "";

    mysqli_select_db($conn, $dbname) or die ("could not connect");

    //verkrijgen
    if (isset($_POST['search'])) {
        $searchq = $_POST['search'];
        $query1 = mysqli_query($conn, " SELECT * FROM stockitems WHERE stockitemname LIKE '%$searchq%'") or die('Geen overeenkomst');
    } elseif (isset($_POST['input'])) {
        $inputq = $_POST['input'];
        $bladeren = true;
        $query1 = mysqli_query($conn, "select StockItemID from stockitemstockgroups where StockGroupID in (select StockGroupID from stockgroups where StockGroupName = '$inputq')") or die('Geen overeenkomst');
    }
    $count = mysqli_num_rows($query1);
    if ($count == 0) {
        $output = 'Er zijn geen resultaten gevonden...';
    } else {
        while ($row = mysqli_fetch_array($query1)) {
            if ($bladeren){
                $naamitem = $row['StockItemID'];
            } else {
                $naamitem = $row['StockItemName'];
            }
            $output .= '<div>' . $naamitem;
        }
    }
    mysqli_close($conn);

    print("$output");
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









<!--<!DOCTYPE html>-->
<!--<html lang="nl">-->
<!--<head>-->
<!--    <meta charset="UTF-8   ">-->
<!--    <title>WWI</title>-->
<!--    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">-->
<!--    <!--links -->-->
<!--    <link rel="script" href="js/custom.js">-->
<!--    <!-- CSS -->-->
<!--    <link rel="stylesheet" href="css/bootstrap.min.css">-->
<!--    <link rel="stylesheet" href="css/custom.css">-->
<!--</head>-->
<!--<body>-->
<!---->
<!--<header id="header02" class="flex-header">-->
<!--    <form action="productpagina.php" method="POST">-->
<!---->
<!--        <input type="hidden" name="input" value="Clothing">-->
<!--        <input type="submit" name="submit" value="kleding">-->
<!--        <input type="hidden" name="input" value="Mugs">-->
<!--        <input type="submit" name="submit" value="Mokken">-->
<!--        <input type="hidden" name="input" value="T-Shirts">-->
<!--        <input type="submit" name="submit" value="T-Shirts">-->
<!--        <input type="hidden" name="input" value="Airline Novelties">-->
<!--        <input type="submit" name="submit" value="Kheb geen idee">-->
<!--        <input type="hidden" name="input" value="Computing Novelties">-->
<!--        <input type="submit" name="submit" value="Nieuwe computer items">-->
<!--        <input type="hidden" name="input" value="USB Novelties">-->
<!--        <input type="submit" name="submit" value="USB sticks">-->
<!--        <input type="hidden" name="input" value="Furry Footwear">-->
<!--        <input type="submit" name="submit" value="Zachte Sokken">-->
<!--        <input type="hidden" name="input" value="Toys">-->
<!--        <input type="submit" name="submit" value="Speelgoed">-->
<!--        <input type="hidden" name="input" value="Packaging Materials">-->
<!--        <input type="submit" name="submit" value="Inpak Materiaal">-->
<!---->
<!---->
<!--</header>-->
<!---->
<!--<!-- floading header with nav -->-->
<!--<header id="header01" class="flex-header">-->
<!--    <div>-->
<!--        <a href="home.php">-->
<!--            <img src="images/wwi%20logo%20text.png" class="logo">-->
<!--        </a>-->
<!--    </div>-->
<!--    <div>-->
<!--        <input size="30" type="search" name="search" placeholder="    Hoi, wat wil je kopen?" autocapitalize="off"-->
<!--               autocomplete="off" spellcheck="false">-->
<!--        <input type="submit" name="submit" value=">>">-->
<!---->
<!--    </div>-->
<!--    <div class="header-right">-->
<!--        <a class="menu" href="#inloggen">/inloggen\</a>-->
<!--        <a class="menu" href="#favo">/favo\</a>-->
<!--        <a class="menu" href="#mand">/mandje\</a>-->
<!--    </div>-->
<!--</header>-->
<!--<br><br><br>-->
<!--</form>-->
<!--<main class="content">-->
<!---->
<!---->
<!--    <!-- database doet het -->-->
<!--    --><?php
//    include 'function.php';
//    $dbname = "wideworldimporters";
//    $output = "";
//    $conn = dbconect();
//
//    mysqli_select_db($conn, $dbname) or die ("could not connect");
//
//    //verkrijgen zoekopdracht
//    if(isset($_POST["search"])) {
//        $searchq = $_POST["search"];
//        $query1 = mysqli_query($conn, " SELECT *
// FROM stockitems
// WHERE stockitemname LIKE '%$searchq%'
// AND SearchDetails LIKE '%$searchq%'") or die('Kan niet zoeken');
//        $count = mysqli_num_rows($query1);
//        if ($count == 0) {
//            $output = 'Er zijn geen resultaten gevonden...';
//        } else {
//            while ($row = mysqli_fetch_array($query1)) {
//                $naamitem = $row['StockItemName'];
//                $output .= '<div>' . $naamitem;
//            }
//        }
//        mysqli_close($conn);
//    }
//    print("$output");
//    ?>
<!---->
<!---->
<!---->
<!--</main>-->
<!---->
<!---->
<!---->
<!--<button onclick="topFunction()" class="page_up_button" title="Go to top">-->
<!--    <img src="images/external-content.duckduckgo.jpg">-->
<!--    <script>-->
<!--        upbutton = document.getElementsByClassName("page_up_button");-->
<!---->
<!--        window.onscroll = function () {-->
<!--            scrollFunction()-->
<!--        };-->
<!---->
<!--        function scrollFunction() {-->
<!--            if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {-->
<!--                upbutton.style.display = "block";-->
<!--            } else {-->
<!--                upbutton.style.display = "none";-->
<!--            }-->
<!--        }-->
<!---->
<!--        function topFunction() {-->
<!--            document.body.scrollTop = 0;-->
<!--            document.documentElement.scrollTop = 0;-->
<!--        }-->
<!--    </script>-->
<!--</button>-->
<!---->
<!--<footer>-->
<!--    <!-- te komen -->-->
<!--</footer>-->
<!--</body>-->
<!--</html>-->