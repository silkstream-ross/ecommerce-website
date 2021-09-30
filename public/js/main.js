var menu_button = document.getElementById("menu_button");
var close_button = document.getElementById("close_button");


menu_button.addEventListener("click", function (){
    var menu = document.getElementById("menu");
    if (window.getComputedStyle(menu).display === "none"){
        menu.style.display = "block";
    } else{
        menu.style.display = "none";
    }
});

close_button.addEventListener("click", function (){
    var menu = document.getElementById("menu");
    if (window.getComputedStyle(menu).display === "none"){
        menu.style.display = "block";
    } else{
        menu.style.display = "none";
    }
});



var slides = document.querySelectorAll("slide")

setInterval(banner_change(),3000);
function banner_change() {
    return(slides.classList.add("visible"))
};




