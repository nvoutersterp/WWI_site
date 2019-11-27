<html>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--links -->
        <link rel="script" href="js/custom.js">
        <!-- CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/custom.css">
    <head>
    </head>
        <body>
        <div class="col-md-9" >
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Your Profile</h4>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <form>
                                <div class="form-group row">
                                    <label for="username" class="col-4 col-form-label">Gebruikersnaam*</label>
                                    <div class="col-8">
                                        <input id="username" name="Gebruikersnaam" placeholder="Gebruikersnaam" class="form-control here" required="required" type="text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-4 col-form-label">Voornaam</label>
                                    <div class="col-8">
                                        <input id="name" name="voornaam" placeholder="Voornaam" class="form-control here" type="text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="lastname" class="col-4 col-form-label">Achternaam</label>
                                    <div class="col-8">
                                        <input id="lastname" name="achternaam" placeholder="Achternaam" class="form-control here" type="text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-4 col-form-label">Email*</label>
                                    <div class="col-8">
                                        <input id="email" name="email" placeholder="Email" class="form-control here" required="required" type="text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="adres" class="col-4 col-form-label">Adres</label>
                                    <div class="col-8">
                                        <input id="adres" name="adres" placeholder="Adres" class="form-control here" type="text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="postcode" class="col-4 col-form-label">Postcode</label>
                                    <div class="col-8">
                                        <input id="postcode" name="postcode" placeholder="Postcode" class="form-control here" type="text">
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
                                        <button name="submit" type="submit" class="btn btn-primary">Update mijn profiel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        </body>
</html>

<?php
    include'function.php';
    $dbname = "wideworldimporters";
    $conn = dbconect();
    $output = "";
    $rij = 1;

    mysqli_select_db($conn, $dbname) or die ("could not connect");

    $query1 = mysqli_query($conn, "");

    $row = mysqli_fetch_array($query1);

    $gebruikersnaam = $row[''];
    $wachtwoord = $row[''];
    $nieuwwachtwoord = $row[''];
    $voornaam = $row[''];
    $achternaam = $row[''];
    $email = $row[''];
    $straatnaam = $row[''];
    $huisnummer = $row[''];
    $postcode = $row[''];
    $woonplaats = $row[''];

?>