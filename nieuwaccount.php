<?php session_start();

//db
include 'function.php';
$conn = dbconect();
$output = "";
$rij = 1;

mysqli_select_db($conn, $dbname) or die ("could not connect");
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
                <input size="30" type="search" name="search" placeholder="    Hoi, wat wil je kopen?"
                       autocapitalize="off"
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
                            wachtwoord: <input type="password" name="password" style="background: gray ; color: white"
                                               required><br>
                            <a href="#nieuwAccount">nog geen account? maak er nu een aan!</a><br>
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
        </div>
    </header>
    <main>
        <br><br><br><br><br><br>
        <h1>maak nu uw account aan</h1>
        <form method="post">
            geslacht: <input type="radio" name="gender" value="male"> man &nbsp; <input type="radio" name="gender" value="female"> vrouw &nbsp; <input type="radio" name="gender" value="other"> anders<br>
            voornaam: <input type="text" name="fisrtName" placeholder="Henk" autofocus required><br>
            tussenvoegel: <input type="text" name="middelName" placeholder="van" autofocus><br>
            achternaam: <input type="text" name="lastName" placeholder="Dreesden" autofocus required><br>
            geboortedag: <input type="date" name="birtday" autofocus required><br>
            mail: <input type="email" name="eMail" placeholder="h.vandreesen@gmail.com" autofocus required><br>
            telefoonnummer: <input type="tel" name="phoneNumber" placeholder="0612345678"><br>

        </form>
<?php

?>