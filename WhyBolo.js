const slides = document.querySelector('.slides');
const slide = document.querySelectorAll('.slide');
const prevButton = document.querySelector('.prev');
const nextButton = document.querySelector('.next');

let currentIndex = 0;

function updateSliderPosition() {
    slides.style.transform = `translateX(-${currentIndex * 100}%)`;
}

nextButton.addEventListener('click', () => {
    if (currentIndex < slide.length - 1) {
        currentIndex++;
    } else {
        currentIndex = 0; 
    }
    updateSliderPosition();
});

prevButton.addEventListener('click', () => {
    if (currentIndex > 0) {
        currentIndex--;
    } else {
        currentIndex = slide.length - 1; 
    }
    updateSliderPosition();
});

// Mobile Navigation
const hamburger = document.querySelector("#burger-navigation");
const mobileNavigation = document.querySelector(".nav-mobile-main");

hamburger.addEventListener("click", function () {
  hamburger.classList.toggle("open");
  mobileNavigation.classList.toggle("menu-active");
});