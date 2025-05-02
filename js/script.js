document.addEventListener("DOMContentLoaded", () => {
  const desktopNavbar = document.getElementById("nav-desktop");
  const mobileNavbar = document.getElementById("nav-mobile");

  // Function to handle navbar styling on scroll
  window.addEventListener("scroll", () => {
    const scrollThreshold = 50;

    if (window.scrollY > scrollThreshold) {
      if (desktopNavbar) desktopNavbar.classList.add("scrolled");
      if (mobileNavbar) mobileNavbar.classList.add("scrolled");
    } else {
      if (desktopNavbar) desktopNavbar.classList.remove("scrolled");
      if (mobileNavbar) mobileNavbar.classList.remove("scrolled");
    }
  });
});

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

// JavaScript untuk slider otomatis dan manual
let currentIndex = 0;
let autoSlideInterval;
let isManualMode = false;

const slides = document.querySelectorAll(".image-slider .slides img");
const totalSlides = slides.length;

function showSlide(index) {
  // Reset index jika melebihi atau kurang dari jumlah slide
  if (index >= totalSlides) {
    currentIndex = 0;
  } else if (index < 0) {
    currentIndex = totalSlides - 1;
  } else {
    currentIndex = index;
  }

  // Sembunyikan semua slide, lalu tampilkan slide aktif
  slides.forEach((slide, i) => {
    slide.style.display = i === currentIndex ? "block" : "none";
  });
}

function plusSlides(n) {
  // Masuk ke mode manual
  isManualMode = true;
  clearInterval(autoSlideInterval);

  // Ganti slide
  showSlide(currentIndex + n);
}

function startAutoSlide() {
  autoSlideInterval = setInterval(() => {
    if (!isManualMode) {
      showSlide(currentIndex + 1);
    }
  }, 5000); // 5000ms = 5 detik
}

// Inisialisasi slider
showSlide(currentIndex);
startAutoSlide();

// Tambahkan listener untuk tombol next/prev
const nextButton = document.querySelector(".image-slider .next");
const prevButton = document.querySelector(".image-slider .prev");

nextButton.addEventListener("click", () => plusSlides(1));
prevButton.addEventListener("click", () => plusSlides(-1));

// Reset manual mode setelah 10 detik tidak ada interaksi
function resetManualMode() {
  isManualMode = false;
  startAutoSlide();
}

let manualModeTimeout;
[nextButton, prevButton].forEach((button) => {
  button.addEventListener("click", () => {
    clearTimeout(manualModeTimeout);
    manualModeTimeout = setTimeout(resetManualMode, 10000); // 10 detik
  });
});

// Mengatur batas agar tidak memilih tanggal kemarin atau sebelumnya
document.addEventListener("DOMContentLoaded", function () {
  flatpickr("#order_date", {
    // Atur lokal ke bahasa Indonesia
    locale: "id",

    // Format tanggal yang ditampilkan
    dateFormat: "Y-m-d",

    // Atur tanggal minimum ke hari ini
    minDate: "today",

    // Nonaktifkan input manual
    allowInput: false,

    // Konfigurasi tambahan untuk tampilan kalender
    inline: false, // Kalender tidak selalu terbuka
    showMonths: 1, // Tampilkan satu bulan

    // Fungsi untuk menangani perubahan tanggal
    onChange: function (selectedDates, dateStr, instance) {
      console.log("Tanggal yang dipilih:", dateStr);
    },
  });
});

const startTimeInput = document.getElementById("start-time");
const endTimeInput = document.getElementById("end-time");

// Event listener untuk mengatur 'min' di waktu selesai
startTimeInput.addEventListener("input", () => {
  const startTime = startTimeInput.value;

  if (startTime) {
    // Atur atribut 'min' di input waktu selesai
    endTimeInput.min = startTime;
  }
});

// Event listener untuk validasi waktu selesai
endTimeInput.addEventListener("input", () => {
  const endTime = endTimeInput.value;
  const startTime = startTimeInput.value;

  if (endTime && startTime && endTime <= startTime) {
    // Tampilkan pesan dengan iziToast jika waktu selesai tidak valid
    iziToast.error({
      title: "Error",
      message: "Waktu selesai harus lebih besar dari waktu mulai.",
      position: "topRight",
    });
    // Reset nilai waktu selesai
    endTimeInput.value = "";
  }
});

// Form Reservation
// const form = document.querySelector("#reservation-item-form");
// form.addEventListener("submit", function (event) {
//   event.preventDefault();

//   const tableName = document.querySelector("#table_name").value;
//   const tableSize = document.querySelector("#table_capacity").value;
//   const date = document.querySelector("#order_date").value;
//   const order = document.querySelector("#order").value;

//   const orderText = `Halo, saya ingin reservasi meja untuk ${tableSize} orang, atas nama ${tableName} pada tanggal/waktu ${date}

//   Order:
//   ${order || "*Pesan di tempat"}
//   `;

//   window.location.replace(`https://wa.me/6281215486311?text=${orderText}`);
// });

// Mobile Navigation
const hamburger = document.querySelector("#burger-navigation");
const mobileNavigation = document.querySelector(".nav-mobile-main");

hamburger.addEventListener("click", function () {
  hamburger.classList.toggle("open");
  mobileNavigation.classList.toggle("menu-active");
});

// Update badge based on notification count
document.addEventListener("DOMContentLoaded", function () {
  const notificationCount =
    document.querySelectorAll(".notification-item").length;
  const badge = document.querySelector(".notification-badge");
  badge.textContent = notificationCount;
});

document.addEventListener("DOMContentLoaded", function () {
  const dropdown = document.querySelector(".dropdown-content");
  const dropdownParent = document.querySelector(".notification-dropdown");

  // Event to hide dropdown when mouse leaves parent and dropdown area
  dropdownParent.addEventListener("mouseleave", () => {
    setTimeout(() => {
      if (!dropdown.matches(":hover")) {
        dropdown.style.display = "none";
      }
    }, 200); // Add slight delay for smoother interaction
  });

  // Event to show dropdown again when mouse enters parent
  dropdownParent.addEventListener("mouseenter", () => {
    dropdown.style.display = "block";
  });
});
