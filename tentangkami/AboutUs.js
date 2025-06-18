// Mobile Navigation
const hamburger = document.querySelector("#burger-navigation");
const mobileNavigation = document.querySelector(".nav-mobile-main");

hamburger.addEventListener("click", function () {
  hamburger.classList.toggle("open");
  mobileNavigation.classList.toggle("menu-active");
});

// Efek hover pada foto tim
const teamImages = document.querySelectorAll('.team-img');

teamImages.forEach((image) => {
    image.addEventListener('mouseover', () => {
        image.style.transform = 'scale(1.1)';
    });

    image.addEventListener('mouseout', () => {
        image.style.transform = 'scale(1)';
    });
});

var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    // Tutup semua panel yang terbuka
    var allPanels = document.getElementsByClassName("panel");
    for (var j = 0; j < allPanels.length; j++) {
      if (allPanels[j] !== this.nextElementSibling && allPanels[j].style.display === "block") { //cek jika panel bukan panel yang di klik dan dalam keadaan terbuka
        allPanels[j].style.display = "none";
        allPanels[j].previousElementSibling.classList.remove("active"); //menghapus class active pada button accordion yang di tutup
      }
    }

    // Buka atau tutup panel yang diklik
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
}