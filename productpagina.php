!DOCTYPE html>
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
        <input size="30" type="search" name="search" value="" placeholder="    Hoi, wat wil je kopen?" value="" autocapitalize="off"
               autocomplete="off" spellcheck="false">
    </div>
    <div class="header-right">
        <a class="menu" href="#inloggen">/inloggen\</a>
        <a class="menu" href="#favo">/favo\</a>
        <a class="menu" href="#mand">/mandje\</a>
    </div>
</header>

<main>

    //te komen//



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

//hiddes bijschrift//