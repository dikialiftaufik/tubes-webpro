<?php
// navbar-land-page.php
// Start session to track login state
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

    <header>
      <nav id="nav-desktop">
        <div class="nav large-container">
          <ul>
            <li data-aos="fade-down" data-aos-duration="500">
              <a href="index.php">Home</a>
            </li>
            <li
              data-aos="fade-down"
              data-aos-duration="500"
              data-aos-delay="100"
            >
              <a href="AboutUs.php">About</a>
            </li>
            <li
              data-aos="fade-down"
              data-aos-duration="500"
              data-aos-delay="200"
            >
              <a href="Makanan.php">Menu</a>
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
              <a href="#">Karir</a>
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
<?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
<li
  class="user-dropdown"
  data-aos="fade-down"
  data-aos-duration="500"
  data-aos-delay="900"
><a href="#">
              <i class="fas fa-user"></i>
            </a>
            <div class="dropdown-content-user">
              <div class="user-info">
                <img src="<?= file_exists($_SESSION['user']['profile']) ? $_SESSION['user']['profile'] : 'uploads/profiles/default.jpg' ?>" 
     class="profile-pic" 
     alt="<?= htmlspecialchars($_SESSION['user']['username']) ?>">
                <div class="user-name"><?= htmlspecialchars($_SESSION['user']['username']) ?></div>
              </div>
              <div class="dropdown-divider"></div>
              <a href="account.php" class="dropdown-item">
                <i class="fas fa-user-cog"></i> <p> Akun Saya</p>
              </a>
              <a href="orders.html" class="dropdown-item">
                <i class="fas fa-box"></i> <p> Pesanan Saya</p>
              </a>
              <a href="reservations.html" class="dropdown-item">
                <i class="fas fa-calendar-alt"></i> <p> Reservasi Saya</p>
              </a>
              <div class="dropdown-divider"></div>
              <a href="auth/logout.php" class="dropdown-item logout">
                <i class="fas fa-sign-out-alt"></i> <p> Sign Out</p>
              </a>
            </div>
          </li>
          <?php else: ?>
<li data-aos="fade-down" data-aos-duration="500" data-aos-delay="900">
        <a href="login-register.php" class="login-link">
            <i class="fas fa-sign-in-alt"></i>
            <span class="login-text">Login</span>
        </a>
</li>
<?php endif; ?>
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

      <!-- Hero -->
      <section id="hero">
        <div
          class="hero main-container"
          data-aos="fade-in"
          data-aos-duration="1000"
          data-aos-delay="800"
        >
          <h3>Mulai Perjalanan Kuliner Anda dengan Satu Klik!</h3>
          <h1>BOLOOO</h1>
          <div class="hero-cta">
            <a href="formPemesanan.php">
              <button class="cta-button">Pesan Sekarang</button>
            </a>

            <a href="#reservation">
              <button class="cta-button">Reservasi Meja</button>
            </a>
          </div>
        </div>
      </section>
      <div class="header-shadow"></div>
    </header>