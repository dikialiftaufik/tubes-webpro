function showLegacy() {
    alert("This button could take you to the Dave Thomas' Legacy page.");
}

function showHistory() {
    alert("This button could take you to the Our History page.");
}

// Mobile Navigation
const hamburger = document.querySelector("#burger-navigation");
const mobileNavigation = document.querySelector(".nav-mobile-main");

hamburger.addEventListener("click", function () {
  hamburger.classList.toggle("open");
  mobileNavigation.classList.toggle("menu-active");
});
