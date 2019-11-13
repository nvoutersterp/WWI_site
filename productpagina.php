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
    <a href="#kleding">kleding</a>
</header>
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
<br><br><br><br>
<main>

    <?php
    include 'function.php';
    $dbname = "wideworldimporters";
    $conn = dbconect();
    $output = "";

    mysqli_select_db($conn, $dbname) or die ("could not connect");

    //verkrijgen
    if (isset($_POST['search'])) {
        $searchq = $_POST['search'];
        $query1 = mysqli_query($conn, " SELECT * FROM stockitems WHERE stockitemname LIKE '%$searchq%'") or die('Kan niet zoeken');
       } elseif (isset($_POST['input'])) {
        $inputq = $_POST['input'];
        $query1 = mysqli_query($conn, "select StockItemID from stockitemstockgroups where StockGroupID on (select StockGroupID from stockgroups where StockGroupName = '$inputq')");
    }
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