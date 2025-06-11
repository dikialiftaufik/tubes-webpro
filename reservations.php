<!doctype html>
<html lang="en">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reservasi Saya</title>
    <link rel="icon" type="image/x-icon" href="img/logo/logo-alt.png" />
    <link rel="stylesheet" href="css/responsive.css" />
    <link rel="stylesheet" href="css/orders.css" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">

    <link
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
  rel="stylesheet"
/>
    <link
      href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
  </head>
  <body>
    <header>
      <nav id="nav-desktop">
        <div class="nav large-container">
          <ul>
            <li data-aos="fade-down" data-aos-duration="500">
              <a href="index.html">Home</a>
            </li>
            <li
              data-aos="fade-down"
              data-aos-duration="500"
              data-aos-delay="100"
            >
              <a href="AboutUs.html">About</a>
            </li>
            <li
              data-aos="fade-down"
              data-aos-duration="500"
              data-aos-delay="200"
            >
              <a href="Makanan.html">Menu</a>
            </li>
            <li
              data-aos="fade-down"
              data-aos-duration="500"
              data-aos-delay="400"
            >
              <a href="#reservation">Reservasi</a>
            </li>
          </ul>

          <img
            src="img/logo/logo2.png"
            data-aos="fade-down"
            data-aos-duration="500"
            data-aos-delay="300"
            alt="logo"
            width="150px"
            height="75px"
          />

          <ul>
            <li
              data-aos="fade-down"
              data-aos-duration="500"
              data-aos-delay="500"
            >
              <a href="#location">Lokasi</a>
            </li>
            <li
              data-aos="fade-down"
              data-aos-duration="500"
              data-aos-delay="600"
            >
              <a href="findJobs.html">Karir</a>
            </li>
            <li
              data-aos="fade-down"
              data-aos-duration="500"
              data-aos-delay="700"
            >
              <a href="findJobs.html">
                <i class="fas fa-shopping-cart"></i>
              </a>
            </li>

            <!-- Notification -->
            <li
  class="notification-dropdown"
  data-aos="fade-down"
  data-aos-duration="500"
  data-aos-delay="800"
>
  <a href="#">
    <i class="fas fa-bell"></i>
    <span class="notification-badge">3</span>
  </a>
  <div class="dropdown-content">
    <div class="notification-item">
      <img src="img/notification/1.avif" alt="Promo Tahun Baru" />
      <div class="notification-text">
        <h4>Promo Tahun Baru</h4>
        <p>Diskon hingga 50% untuk semua menu!</p>
      </div>
    </div>
    <div class="notification-item">
      <img src="img/notification/sate-goreng.jpg" alt="Promo Makan Hemat" />
      <div class="notification-text">
        <h4>Menu Baru Wajib Coba!</h4>
        <p>Rasakan kenikmatan sate goreng ayam!</p>
      </div>
    </div>
    <div class="notification-item">
      <img src="img/notification/4.webp" alt="Reservasi Spesial" />
      <div class="notification-text">
        <h4>Jam Operasional Baru</h4>
        <p>Sekarang kami buka hingga pukul 21:00!</p>
      </div>
    </div>
  </div>
</li>

<!-- User -->
<li
  class="user-dropdown"
  data-aos="fade-down"
  data-aos-duration="500"
  data-aos-delay="900"
>
  <a href="#">
    <i class="fas fa-user"></i>
  </a>
  <div class="dropdown-content-user">
    <div class="user-info">
      <img src="img/profile-pic.png" alt="User Profile" />
      <div class="user-name">dikialift13</div>
    </div>
    <div class="dropdown-divider"></div>
    <a href="account.html" class="dropdown-item">
      <i class="fas fa-user-cog"></i> <p> Akun Saya</p>
    </a>
    <a href="orders.html" class="dropdown-item">
      <i class="fas fa-box"></i> <p> Pesanan Saya</p>
    </a>
    <a href="reservations.html" class="dropdown-item">
      <i class="fas fa-calendar-alt"></i> <p> Reservasi Saya</p>
    </a>
    <div class="dropdown-divider"></div>
    <a href="signout.html" class="dropdown-item logout">
      <i class="fas fa-sign-out-alt"></i> <p> Sign Out</p>
    </a>
  </div>
</li>


          </ul>
        </div>
      </nav>

      <nav id="nav-mobile">
        <div class="nav-mobile">
          <div class="nav large-container">
            <img
              src="img/logo/logo-alt.png"
              data-aos="fade-down"
              data-aos-duration="500"
              data-aos-delay="200"
              alt="logo-alt"
              width="50px"
              height="50px"
            />
            <div id="burger-navigation">
              <span></span>
              <span></span>
              <span></span>
            </div>
          </div>
        </div>

        <div class="nav-mobile-main">
          <div>
            <a href="index.html">Home</a>
          </div>
          <div>
            <a href="about.html">About Us</a>
          </div>
          <div>
            <a href="Makanan.html">Menu</a>
          </div>
          <div>
            <a href="#reservation">Reservation</a>
          </div>
          <div>
            <a href="#location">Location</a>
          </div>
          <div>
            <a href="findJobs.html">Find Jobs</a>
          </div>
        </div>
      </nav>
          </header>

                  <!-- Main Content Container -->
<div class="container">
  <!-- Sidebar -->
  <aside class="sidebar">
    
    <ul class="sidebar-menu">
      <li>
        <a href="account.php">
          <i class="fas fa-user"></i>
          <span>Akun Saya</span>
        </a>
      </li>
      <li>
        <a href="orders.php" class="active">
          <i class="fas fa-box"></i>
          <span>Pesanan Saya</span>
        </a>
      </li>
      <li>
        <a href="reservations.php">
          <i class="fas fa-calendar-alt"></i>
          <span>Reservasi Saya</span>
        </a>
      </li>
      </ul>
  </aside>

  <!-- Main Content -->
<main class="main-content">
    <div class="reservations-container">
        <!-- Header Section -->
        <div class="page-header">
            <h1>Reservasi Saya</h1>
            <!-- <button class="btn-primary" id="new-reservation">Buat Reservasi Baru</button> -->
        </div>

        <!-- Reservations Filter -->
        <div class="filter-section">
            <div class="filter-group">
                <label for="status-filter">Status:</label>
                <select id="status-filter">
                    <option value="all">Semua Status</option>
                    <option value="pending">Menunggu Konfirmasi</option>
                    <option value="confirmed">Dikonfirmasi</option>
                    <option value="completed">Selesai</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="date-filter">Tanggal:</label>
                <input type="date" id="date-filter">
            </div>
        </div>

        <!-- Active Reservations Section -->
        <section class="reservations-section">
    <h2>Reservasi Aktif</h2>
    <div class="reservations-grid">
                <!-- Past Reservation Card -->
                <div class="reservation-card past">
                    <div class="reservation-header">
                        <span class="reservation-status completed">Menunggu</span>
                    </div>
                    <div class="reservation-details">
                        <p><strong>Tanggal:</strong> 12 Juni 2025</p>
                        <p><strong>Waktu:</strong> 19:00-20:00</p>
                        <p><strong>Jumlah Tamu:</strong> 2 orang</p>
                    </div>
                    <div class="reservation-menu">
                        <h3>Menu yang Dipesan:</h3>
                        <ul>
                            <li>Sate Ayam x2</li>
                            <li>Nasi x2</li>
                        </ul>
                    </div>
                    <div class="reservation-actions">
                        <button class="btn-secondary" onclick="location.href='orders.html?id=RSV123455'">Lihat Detail</button>
                        <button class="btn-primary">Batalkan</button>
                    </div>
                </div>
            </div>
</section>

        <!-- Past Reservations Section -->
        <section class="reservations-section">
            <h2>Riwayat Reservasi</h2>
            <div class="reservations-grid">
                <!-- Past Reservation Card -->
                <div class="reservation-card past">
                    <div class="reservation-header">
                        <span class="reservation-status completed">Selesai</span>
                    </div>
                    <div class="reservation-details">
                        <p><strong>Tanggal:</strong> 12 Mei 2025</p>
                        <p><strong>Waktu:</strong> 19:00-20:00</p>
                        <p><strong>Jumlah Tamu:</strong> 4 orang</p>
                    </div>
                    <div class="reservation-menu">
                        <h3>Menu yang Dipesan:</h3>
                        <ul>
                            <li>Sate Ayam x2</li>
                            <li>Sate Kambing x6</li>
                        </ul>
                    </div>
                    <div class="reservation-actions">
                        <button class="btn-secondary" onclick="location.href='orders.html?id=RSV123455'">Lihat Detail</button>
                        <button class="btn-primary">Pesan Lagi</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Empty State -->
        <div class="empty-state" style="display: none;">
            <img src="images/empty-reservations.svg" alt="Tidak ada reservasi">
            <h3>Belum Ada Reservasi</h3>
            <p>Anda belum memiliki reservasi. Mulai buat reservasi sekarang!</p>
            <button class="btn-primary">Buat Reservasi</button>
        </div>
    </div>
</main>
</div>

        
    <!-- Footer -->
    <footer>
      <div class="footer-info">
        <div class="footer-info-items main-container">
          <div data-aos="fade-up">
            <h3>Selamat Datang di BOLOOO</h3>
            <p>Tempat setiap gigitan bercerita</p>
            <p>
              Masuki tempat berlindung kami yang nyaman, di mana kehangatan
              keramahan yang tulus mengundang Anda untuk bersantai dan menikmati
              momen kenikmatan yang menyenangkan.
            </p>
          </div>
          <div data-aos="fade-up" data-aos-delay="100">
            <h3>Kunjungi Kami</h3>
            <p>
              Jl. Sukapura No.76, Cipagalo, Kec. Bojongsoang, Kabupaten Bandung,
              Jawa Barat 40287
            </p>

            <h3>Hubungi Kami</h3>
            <p>
              6281215486311<br />
              BOLOOO.food@gmail.com
            </p>
          </div>

          <div data-aos="fade-up" data-aos-delay="200">
            <h3>Unduh Aplikasi</h3>
            <div>
              <a href="formPemesanan.html">
                <img
                  src="img/logo/google-play-icon.png"
                  alt="Google Play"
                  width="150px"
                  height="45px"
              /></a>
            </div>

            <div>
              <a href="formPemesanan.html">
                <img
                  src="img/logo/app-store-icon.png"
                  alt="App Store"
                  width="150px"
                  height="45px"
              /></a>
            </div>
          </div>
        </div>
      </div>

      <div class="footer-copyright">
        <div class="footer-items large-container">
          <div class="footer-left">&copy; 2024 BOLOOO. All Rights Reserved</div>

          <div class="footer-mid">
            <img
              src="img/logo/logo.png"
              alt="logo"
              width="150px"
              height="100px"
            />
          </div>

          <div class="footer-right">Rasakan Bedanya</div>
        </div>
    </footer>

    <script src="js/script.js" type="text/javascript"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
    <script>
document.querySelectorAll('.btn-danger').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        
        if (confirm('Batalkan reservasi ini?')) {
            fetch('cancel_reservation.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${id}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.closest('.reservation-card').remove();
                } else {
                    alert('Gagal membatalkan reservasi');
                }
            });
        }
    });
});
    
        AOS.init();

        // DOM Elements
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar active state
    const sidebarLinks = document.querySelectorAll('.sidebar-menu a');
    const currentPath = window.location.pathname;

    // Remove active class from all links and add to current page
    sidebarLinks.forEach(link => {
        link.classList.remove('active');
        if (currentPath.includes(link.getAttribute('href'))) {
            link.classList.add('active');
        }
    });

    // Filter functionality
    const statusFilter = document.getElementById('status-filter');
    const dateFilter = document.getElementById('date-filter');
    const reservationCards = document.querySelectorAll('.reservation-card');

    function filterReservations() {
        const selectedStatus = statusFilter.value;
        const selectedDate = dateFilter.value;

        reservationCards.forEach(card => {
            let showCard = true;

            // Status filtering
            if (selectedStatus !== 'all') {
                const cardStatus = card.querySelector('.reservation-status').classList[1];
                if (cardStatus !== selectedStatus) {
                    showCard = false;
                }
            }

            // Date filtering
            if (selectedDate) {
                const cardDate = card.querySelector('.reservation-details p:first-child').textContent;
                const formattedCardDate = formatDate(cardDate);
                if (formattedCardDate !== selectedDate) {
                    showCard = false;
                }
            }

            card.style.display = showCard ? 'block' : 'none';
        });

        checkEmptyState();
    }

    // Helper function to format date from card text
    function formatDate(dateText) {
        const date = dateText.split(':')[1].trim();
        // Convert "8 Januari 2025" to "2025-01-08" format
        const months = {
            'Januari': '01', 'Februari': '02', 'Maret': '03', 'April': '04',
            'Mei': '05', 'Juni': '06', 'Juli': '07', 'Agustus': '08',
            'September': '09', 'Oktober': '10', 'November': '11', 'Desember': '12'
        };

        const [day, month, year] = date.split(' ');
        return `${year}-${months[month]}-${day.padStart(2, '0')}`;
    }

    // Check if no reservations are shown and display empty state
    function checkEmptyState() {
        const visibleCards = Array.from(reservationCards).filter(card => 
            card.style.display !== 'none'
        ).length;

        const emptyState = document.querySelector('.empty-state');
        if (emptyState) {
            emptyState.style.display = visibleCards === 0 ? 'block' : 'none';
        }
    }

    // Event listeners for filters
    if (statusFilter) {
        statusFilter.addEventListener('change', filterReservations);
    }
    if (dateFilter) {
        dateFilter.addEventListener('change', filterReservations);
    }

    // New Reservation Button
    const newReservationBtn = document.getElementById('new-reservation');
    if (newReservationBtn) {
        newReservationBtn.addEventListener('click', () => {
            // Implement new reservation functionality
            // This could open a modal or redirect to a new reservation form
            alert('Fitur Buat Reservasi Baru akan segera hadir!');
        });
    }

    // Cancel Reservation Buttons
    const cancelButtons = document.querySelectorAll('.btn-danger');
    cancelButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const card = this.closest('.reservation-card');
            const reservationId = card.querySelector('.reservation-id').textContent;
            
            if (confirm(`Apakah Anda yakin ingin membatalkan reservasi ${reservationId}?`)) {
                // Add animation before removing
                card.style.transition = 'all 0.3s ease';
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.remove();
                    checkEmptyState();
                }, 300);
            }
        });
    });

    // View Detail Buttons
    const viewDetailButtons = document.querySelectorAll('.btn-secondary');
    viewDetailButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const reservationId = this.closest('.reservation-card')
                                    .querySelector('.reservation-id').textContent;
            // Implementation for viewing details
            // This could open a modal or redirect to a details page
            window.location.href = `orders.html?id=${reservationId.replace('#', '')}`;
        });
    });

    // Order Again Buttons
    const orderAgainButtons = document.querySelectorAll('.btn-primary');
    orderAgainButtons.forEach(button => {
        if (button.textContent.trim() === 'Pesan Lagi') {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const card = this.closest('.reservation-card');
                const menuItems = Array.from(card.querySelectorAll('.reservation-menu li'))
                                    .map(li => li.textContent);
                
                // Implementation for re-ordering
                alert(`Memproses pemesanan ulang dengan menu:\n${menuItems.join('\n')}`);
            });
        }
    });

    // Add smooth scrolling for better UX
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add hover effects for cards
    reservationCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
            this.style.boxShadow = '0 8px 16px rgba(0, 0, 0, 0.2)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
    });
});

      document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("reservation-item-form");

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        const isLoggedIn = sessionStorage.getItem("loggedIn");

        if (isLoggedIn) {
            iziToast.success({
                title: "Berhasil!",
                message: "Reservasi Anda sedang diproses.",
                position: "topRight",
                timeout: 3000,
                onClosing: function () {
                    // Simulasi pengiriman data reservasi ke halaman admin
                    const reservasiData = {
                        nama: document.getElementById("table_name").value,
                        jumlahOrang: document.getElementById("table_capacity").value,
                        tanggalWaktu: document.getElementById("order_date").value,
                        pesanan: document.getElementById("order").value,
                    };

                    // Simpan data ke localStorage sementara (simulasi)
                    localStorage.setItem("reservasiData", JSON.stringify(reservasiData));
                    window.location.href = "admin/reservation.html";
                }
            });
        } else {
            iziToast.warning({
                title: "Perhatian!",
                message: "Anda harus login terlebih dahulu untuk melakukan reservasi.",
                position: "topRight",
                timeout: 3000,
                onClosing: function () {
                    window.location.href = "login-register.html";
                }
            });
        }
    });

    // Fungsi logout otomatis setelah 2 menit
    setTimeout(() => {
        sessionStorage.removeItem("loggedIn");
    }, 120000); // 2 menit dalam milidetik
});

document.querySelectorAll('.toggle-password').forEach(toggle => {
  toggle.addEventListener('click', function() {
    const input = this.previousElementSibling;
    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
    input.setAttribute('type', type);
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
  });
});
    </script>
  </body>
</html>
