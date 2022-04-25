//slider Home page

let img;
let nbpicture;
let next;
let after;
let counter = 0;

img = document.querySelectorAll(".pictureSlider"); //return array
nbpicture = img.length;
next = document.getElementById("next-slide");
after = document.getElementById("after-slide");

function nextSlide() {
  img[counter].classList.remove("visible");

  if (counter < nbpicture - 1) {
    counter++;
  } else {
    counter = 0;
  }

  img[counter].classList.add("visible");
}

function afterSlide() {
  img[counter].classList.remove("visible");

  if (counter > 0) {
    counter--;
  } else {
    counter = nbpicture - 1;
  }

  img[counter].classList.add("visible");
}

//DOM content Load
document.addEventListener("DOMContentLoaded", function () {
  //Pour que la 1ere image soit visible direct
  img[counter].classList.add("visible");

  //Lancement automatique toutes les 30secs, la condition est pour eviter les erreurs js sur les autres pages du site
  setInterval(nextSlide, 30000);

  after.addEventListener("click", nextSlide);
  next.addEventListener("click", afterSlide);
});
