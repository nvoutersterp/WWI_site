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
}

if (isset($_POST['uitloggen'])){
    session_destroy();
    header("refresh: 0;");   //geeft nog een foutcode
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

    <div class="header-right">
        <div class="menu1">
            <img src="images/inloggen.png" class="header-right-img" onclick="openLogin()">
            <?php if ($_SESSION['isIngelogt']) {
                printIsIngelogt();
            } else { ?>
            <div class="login-popup" id="myLogin">
                <form action="home.php" method="post" class="login-container">
                    inloggen
                    <button type="button" onclick="closeLogin()">Close</button>
                    <br>
                    gebruikersnaam: <input type="text" name="username" style="background: gray; color: white"
                                           required><br>
                    wachtwoord: <input type="password" name="password" style="background: gray ; color: white" required><br>
                    <a href="nieuwaccount.php">nog geen account? maak er nu een aan!</a><br>
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
        } else {
            print ('hoi, iemand');
        }?>
    </div>
</header>
<main>
    <br><br><br><br><br><br>

    <!-- database doet het -->
    <?php
    mysqli_select_db($conn, $dbname) or die ("could not connect");

    mysqli_close($conn);

    print("$output");
    print ($werktHet);
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