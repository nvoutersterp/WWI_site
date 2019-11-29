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

<body class="body">
<div class=header1 id="header1">
    <div class="top-container" id="top-container" >
        <!--        Laat logo zien met de juiste afmetingen-->
        <a href="home.php" class="logo"><img alt src="images/wwi%20logo%20text.png" width=180px height=50px> </a>
        <!--        snelkoppelingen naar de accountinformatie's-->
        <div class="top-container-right">
            <div class="icon">
                <i class="fa fa-sign-in" aria-hidden="true" onclick="openLogin()"></i>
                <?php if ($_SESSION['isIngelogt']) {
                    printIsIngelogt();
                } else { ?>
                    <div class="login-popup" id="myLogin">
                        <form action="home.php" method="post" class="login-container">
                            inloggen
                            <button type="button" onclick="closeLogin()">Close</button><br>
                            gebruikersnaam: <input type="text" name="username" style="background: gray; color: white" required><br>
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
            <a href="#mandje">
                <div class="icon">
                    <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                </div>
            </a>
            <a href="#favo">
                <div class="icon">
                    <i class="fa fa-heart" aria-hidden="true"></i>
                </div>
            </a>
        </div>

        <?php
        if (date('G') < 12) {
            $moment = 'goedemorgen ';
        } elseif (date('G') > 18) {
            $moment = 'goedeavond ';
        } else {
            $moment = 'goedemiddag ';
        }

        if (isset($_SESSION['firstName'])) {
            $name =  $_SESSION['firstName'];
        } else {
            $name = '';
        }
groet($name);

        print ($moment . $name);
        ?>

        <!--            Het zoeken naar producten-->
        <form action="productpagina.php" method="POST" class="example">
            <input size="30" type="search" name="search" placeholder="    Hoi, wat wil je kopen?" autocapitalize="off"
                   autocomplete="off" spellcheck="false" class="searchbox">
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>

        <?php printcategorie($conn); ?>

<main>

    <!-- database doet het -->
    <?php
    mysqli_select_db($conn, $dbname) or die ("could not connect");

    mysqli_close($conn);

    print("$output");
    print ($werktHet);
?>

</main>

<footer>
    <div class="footer">
        <img alt src="images/gratis%20verzending.PNG" width="5%" height="5%"> <br>
        <p> Wide World Importers® </p>
    </div>
</footer>
</body>
</html>