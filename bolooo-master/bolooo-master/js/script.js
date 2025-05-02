function initCarousel() {
  const newMenu = document.querySelector(".new-menu-carousel");
  const bestSeller = document.querySelector(".best-seller-carousel");

  for (let i = 0; i < 5; i++) {
    const newMenuCarousel = document
      .querySelector(".new-menu-carousel-slide")
      .cloneNode(true);
    const bestSellerCarousel = document
      .querySelector(".best-seller-carousel-slide")
      .cloneNode(true);

    newMenu.appendChild(newMenuCarousel);
    bestSeller.appendChild(bestSellerCarousel);
  }
}

initCarousel();

// Form Reservation

const form = document.querySelector("#reservation-item-form");
form.addEventListener("submit", function (event) {
  event.preventDefault();

  const tableName = document.querySelector("#table_name").value;
  const tableSize = document.querySelector("#table_capacity").value;
  const date = document.querySelector("#order_date").value;
  const order = document.querySelector("#order").value;

  const orderText = `Halo, saya ingin reservasi meja untuk ${tableSize} orang, atas nama ${tableName} pada tanggal/waktu ${date}
  
  Order: 
  ${order || "*Pesan di tempat"}
  `;

  window.location.replace(`https://wa.me/6281215486311?text=${orderText}`);
});

// Mobile Navigation
const hamburger = document.querySelector("#burger-navigation");
const mobileNavigation = document.querySelector(".nav-mobile-main");

hamburger.addEventListener("click", function () {
  hamburger.classList.toggle("open");
  mobileNavigation.classList.toggle("menu-active");
});
