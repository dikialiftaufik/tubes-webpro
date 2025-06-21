document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.timeline-nav button');
    const timelineItems = document.querySelectorAll('.timeline-item');
    let currentIndex = 0;

    // Fungsi untuk menampilkan item berdasarkan dekade yang dipilih
    function showItemsByDecade(decade) {
        timelineItems.forEach(item => {
            if (item.getAttribute('data-decade') === decade) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Fungsi untuk menampilkan item berdasarkan indeks tombol yang aktif
    function setActiveButton(index) {
        buttons.forEach(btn => btn.classList.remove('active'));
        buttons[index].classList.add('active');
        const selectedDecade = buttons[index].getAttribute('data-decade');
        showItemsByDecade(selectedDecade);
    }

    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth' 
        });
    }

    // Event listener untuk tombol navigasi atas
    buttons.forEach((button, index) => {
        button.addEventListener('click', () => {
            currentIndex = index;
            setActiveButton(currentIndex);
            scrollToTop(); // Scroll ke atas
        });
    });

    // Event listener untuk tombol Previous dan Next
    document.getElementById('prev-btn').addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            setActiveButton(currentIndex);
            scrollToTop(); // Scroll ke atas
        }
    });

    document.getElementById('next-btn').addEventListener('click', () => {
        if (currentIndex < buttons.length - 1) {
            currentIndex++;
            setActiveButton(currentIndex);
            scrollToTop(); // Scroll ke atas
        }
    });

    // Tampilkan item pertama secara default
    setActiveButton(currentIndex);
});

// Mobile Navigation
const hamburger = document.querySelector("#burger-navigation");
const mobileNavigation = document.querySelector(".nav-mobile-main");

hamburger.addEventListener("click", function () {
    hamburger.classList.toggle("open");
    mobileNavigation.classList.toggle("menu-active");
});
