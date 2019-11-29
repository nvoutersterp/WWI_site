<!DOCTYPE HTML>
<HTML lang="EN">
<body class="body">
<!--link met de bootstraps en stylesheets-->
<header>
    <link rel="stylesheet" href="CSS/style.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</header>
<!--header1 gedefinieerd om een sticky effect te krijgen van top-container en nav-bar-->
<div class=header1 id="header1">
    <div class="top-container" id="top-container" >
<!--        Laat logo zien met de juiste afmetingen-->
        <a href="index.php" class="logo"><img alt src="images/wwi%20logo%20text.png" width=180px height=50px> </a>
<!--        snelkoppelingen naar de accountinformatie's-->
        <div class="top-container-right">
            <a href="google.com">
                <div class="icon">
                    <i class="fa fa-sign-in" aria-hidden="true"></i>
                </div>
            </a>
            <a href="google.com">
                <div class="icon">
                    <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                </div>
            </a>
            <a href="google.com">
                <div class="icon">
                    <i class="fa fa-heart" aria-hidden="true"></i>
                </div>
            </a>
        </div>
<!--            Het zoeken naar producten-->
            <form class="example" action="productpagina.php">
                <input class="searchbox" type="text" placeholder="Zoek hier naar producten" name="search">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>

    </div>
    <!-- snelkoppelingen naar de juist betreffende catogorie met icon's van de bootstrap-->
    <div class="nav" id="nav">
        <a class="active" href="#home">USB</a>
        <a href="#news">Rocket</a>
        <a href="#contact">T-shirt</a>
        <a href="#about">Hoodie's</a>
        <i class="fas fa-sign-in-alt"></i>
    </div>

</div>


<!--test voor de juistheid text-->
<?php

$text = "Hallo";
for ($i = 1; 1000 >= $i; $i++) {
    print($text . $i);
    ?> <br> <?php
}
?>
<!--link naar javascript voor sticky effect-->
<script src="CSS/effecten.js"></script>

</body>

<footer>
<div class="footer">
    <img alt src="images/gratis%20verzending.PNG" width="5%" height="5%"> <br>
    <p> Wide World Importers® </p>
</div>
</footer>



</HTML>

