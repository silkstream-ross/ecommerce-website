var menu_button = document.getElementById("menu_button");
var close_button = document.getElementById("close_button");
var left_button = document.querySelector(".left_button");
var right_button = document.querySelector(".right_button");

menu_button.addEventListener("click", function (e){
    var menu = document.getElementById("menu");
    if (window.getComputedStyle(menu).display === "none"){
        menu.style.display = "block";
    } else{
        menu.style.display = "none";
    }
    e.preventDefault();
});

close_button.addEventListener("click", function (e){
    var menu = document.getElementById("menu");
    if (window.getComputedStyle(menu).display === "none"){
        menu.style.display = "block";
    } else{
        menu.style.display = "none";
    }
    e.preventDefault();
});

left_button.addEventListener("click", function (e){
    previous_slide();
    stop_autoplay();
    start_autoplay();
    e.preventDefault();
});

right_button.addEventListener("click", function (e){
    next_slide();
    stop_autoplay();
    start_autoplay();
    e.preventDefault();
});


var slides = document.querySelectorAll(".slide");
var current_slide = 0;
var timer = 0;

function change_slide(new_slide){
    slides[current_slide].classList.remove("visible");
    slides[new_slide].classList.add("visible");
    current_slide = new_slide;
//fade out current image
//fade in new image
}

function next_slide(){
    var new_slide = current_slide+1;
    if (new_slide === slides.length){
        new_slide = 0;
    }
    change_slide(new_slide);
}

function previous_slide(){
    var new_slide = current_slide-1;
    if (new_slide === -1){
        new_slide = slides.length-1;
    }
    change_slide(new_slide);
}

function start_autoplay(){
    timer = setInterval(next_slide,3000);
    console.log(timer);
}

function stop_autoplay(){
    clearInterval(timer);
}

start_autoplay();





