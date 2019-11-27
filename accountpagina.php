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
                <input size="30" type="search" name="search" placeholder="    Hoi, wat wil je kopen?"
                       autocapitalize="off"
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
        <br><br><br><br><br><br><br><br>

        <?php
            $dbname = "wideworldimporters";
            $clientid = $_SESSION['clientID'];

            $query1 = mysqli_query($conn, "SELECT * FROM client WHERE clientID='$clientid'");

            $row = mysqli_fetch_array($query1);

            $email = $row['eMail'];
            $wachtwoord = $row[''];
            $nieuwwachtwoord = $row[''];
            $voornaam = $row['firstName'];
            $tussenvoegsel = $row['middelName'];
            $achternaam = $row['lastName'];
            $telefoonnummer = $row['phoneNumber'];
            $adres = $row['adres'];
            $postcode = $row['postcode'];
            $woonplaats = $row['plaats'];

        ?>

        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Your Profile</h4>
                            <hr>
                        </div>
                    </div>
                            <form>
                                <div class="form-group row">
                                    <label for="name" class="col-4 col-form-label">Voornaam</label>
                                    <div class="col-8">
                                        <input id="name" name="voornaam" placeholder="<?php print("$voornaam");?>" class="form-control here" type="text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tussenvoegsels" class="col-4 col-form-label">Tussenvoegsels</label>
                                    <div class="col-8">
                                        <input id="name" name="Tussenvoegsels" placeholder="<?php print("$tussenvoegsel");?>" class="form-control here" type="text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="lastname" class="col-4 col-form-label">Achternaam</label>
                                    <div class="col-8">
                                        <input id="lastname" name="achternaam" placeholder="<?php print("$achternaam");?>" class="form-control here" type="text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-4 col-form-label">Email*</label>
                                    <div class="col-8">
                                        <input id="email" name="email" placeholder="<?php print("$email");?>" class="form-control here" required="required" type="text">
                                    </div>
                                </div>
                            <div class="form-group row">
                                <label for="adres" class="col-4 col-form-label">Adres</label>
                                <div class="col-8">
                                    <input id="adres" name="adres" placeholder="<?php print("$adres");?>" class="form-control here" type="text">
                                </div>
                            </div>
                                <div class="form-group row">
                                    <label for="telefoonnummer" class="col-4 col-form-label">Telefoonnummer</label>
                                    <div class="col-8">
                                        <input id="name" name="telefoonmummer" placeholder="<?php print("$telefoonnummer");?>" class="form-control here" type="text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="postcode" class="col-4 col-form-label">Postcode</label>
                                    <div class="col-8">
                                        <input id="postcode" name="postcode" placeholder="<?php print("$postcode");?>" class="form-control here" type="text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="plaats" class="col-4 col-form-label">WoonPlaats</label>
                                            <div class="col-8">
                                                <input id="name" name="plaats" placeholder="<?php print("$woonplaats");?>" class="form-control here" type="text">
                                            </div>
                                </div>
                                <div class="form-group row">
                                    <label for="newpass" class="col-4 col-form-label">Nieuw wachtwoord</label>
                                    <div class="col-8">
                                        <input id="newpass" name="nieuwwachtwoord" placeholder="Nieuw wachtwoord" class="form-control here" type="text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-4 col-8">
                                        <button name="submit" type="submit" class="btn btn-primary">Update mijn profiel
                                        </button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
        </body>
    </html>