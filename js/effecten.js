
window.onscroll = function() {navFunction()};

var header = document.getElementById("header1");
var sticky = header.offsetTop;

function navFunction() {
    if (window.pageYOffset > sticky) {
        header.classList.add("sticky");
    } else {
        header.classList.remove("sticky");
    }
}

