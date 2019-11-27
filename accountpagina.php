<?php session_start();

//db
include 'function.php';
$conn = dbconect();
$output = "";
$rij = 1;

mysqli_select_db($conn, $dbname) or die ("could not connect");

//verder....
$werktHet = '';
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
                printIsIngelogt($_SESSION['clientID']);
            } else { ?>
                <div class="login-popup" id="myLogin">
                    <form action="productpagina.php" class="login-container">
                        inloggen
                        <button type="button" onclick="closeLogin()">Close</button>
                        <br>
                        gebruikersnaam: <input type="text" style="background: gray; color: white" required><br>
                        wachtwoord: <input type="password" style="background: gray ; color: white" required><br>
                        <a href="#nieuwAccount">nog geen account? klik hier!</a><br>
                        <input type="hidden"<?php if (isset($_POST['search'])) {
                            $search = $_POST['search'];
                            print ('naam="search" value="' . $search . '"');
                        } elseif (isset($_POST['input'])) {
                            $input = $_POST['input'];
                            print ('naam="input" value="' . $input . '""');
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
    <?php if (isset($_SESSION['clientID'])) {
        $clientID = $_SESSION['clientID'];
        $query10 = mysqli_query($conn, "select * from client where clientID = '$clientID'");

        while ($row = mysqli_fetch_array($query10)) {
            $firstName = $row['firstName'];
            $middelName = $row['middelName'];
            $lastName = $row['lastName'];
        }
        print ("goedemiddag, ".$firstName." ".$middelName." ".$lastName);
    } else {
        print ('sorry, we konden niks ophalen');
    } ?>

