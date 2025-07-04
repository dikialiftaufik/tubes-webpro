<?php
// navbar-land-page.php
// Start session to track login state
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database configuration with correct path
$config_path = dirname(dirname(__FILE__)) . '/configdb.php';
if (file_exists($config_path)) {
    require_once $config_path;
} else {
    error_log("Database configuration file not found at: " . $config_path);
}

// Fetch active notifications from database
$notifications = [];
$notification_count = 0;

// Re-establish connection if it was closed in account.php or not available
// This ensures $conn is available for this script.
// It's generally better to pass $conn or manage connection lifecycle carefully.
// For a quick fix, ensure $conn is available or re-initialize if needed.
// Given that configdb.php usually has a persistent connection, this might not be an issue.
if (isset($conn)) { // Pastikan $conn sudah terdefinisi dan terkoneksi
    $sql = "SELECT * FROM notifications WHERE is_active = 1 ORDER BY created_at DESC LIMIT 3";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $notifications = $result->fetch_all(MYSQLI_ASSOC);
        $notification_count = count($notifications);
    }
    // Tidak menutup koneksi di sini agar bisa digunakan di index.php atau halaman lain yang meng-include navbar ini
}

// Definisikan jalur gambar profil default
$profile_picture_src = 'uploads/profile/default.jpg';

// Ambil foto profil dari sesi. account.php sudah memastikan ini up-to-date.
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] && isset($_SESSION['user']['profile_picture'])) {
    $session_profile_picture = $_SESSION['user']['profile_picture'];
    // Validasi apakah file ada di server
    if (file_exists($session_profile_picture)) { // Cek langsung karena path sudah relatif dari root
        $profile_picture_src = $session_profile_picture;
    }
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
          <a href="tentangkami/AboutUs.php">About</a>
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

        <li
          class="notification-dropdown"
          data-aos="fade-down"
          data-aos-duration="500"
          data-aos-delay="800"
        >
        <a href="#">
        <i class="fas fa-bell"></i>
        <?php if($notification_count > 0): ?>
            <span class="notification-badge"><?= $notification_count ?></span>
        <?php endif; ?>
        </a>
    <div class="dropdown-content">
        <?php if($notification_count > 0): ?>
            <?php foreach($notifications as $notif): ?>
            <div class="notification-item">
                <?php if(!empty($notif['image_path'])): ?>
                    <img src="<?= htmlspecialchars($notif['image_path']) ?>" 
                         alt="<?= htmlspecialchars($notif['title']) ?>"
                         style="width: 50px; height: 50px; object-fit: cover;">
                <?php else: ?>
                    <div class="bg-secondary d-flex align-items-center justify-content-center" 
                         style="width:50px;height:50px;">
                        <i class="fas fa-image text-white"></i>
                    </div>
                <?php endif; ?>
                <div class="notification-text">
                    <h4><?= htmlspecialchars($notif['title']) ?></h4>
                    <p><?= htmlspecialchars($notif['message']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="notification-item">
                <div class="bg-secondary d-flex align-items-center justify-content-center" 
                     style="width:50px;height:50px;">
                    <i class="fas fa-bell text-white"></i>
                </div>
                <div class="notification-text">
                    <h4>Tidak ada notifikasi</h4>
                    <p>Belum ada notifikasi aktif saat ini</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</li>

<?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
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

      <img src="<?php echo htmlspecialchars($profile_picture_src); ?>" 
           class="profile-pic" 
           alt="<?= htmlspecialchars($_SESSION['user']['username'] ?? '') ?>">
      <div class="user-name"><?= htmlspecialchars($_SESSION['user']['full_name'] ?? '') ?></div>
    </div>
    <div class="dropdown-divider"></div>
    
    <a href="account.php" class="dropdown-item account-item">
      <i class="fas fa-user-cog"></i> <p> Akun Saya</p>
    </a>
    
    <a href="orders.php" class="dropdown-item orders-item">
      <i class="fas fa-box"></i> <p> Pesanan Saya</p>
    </a>
    
    <a href="reservations.php" class="dropdown-item reservations-item">
      <i class="fas fa-calendar-alt"></i> <p> Reservasi Saya</p>
    </a>
    
    <div class="dropdown-divider"></div>
    
    <a href="auth/logout.php" class="dropdown-item logout-item">
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
        <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
        <a href="Proses/formPemesanan.php">
          <button class="cta-button">Pesan Sekarang</button>
        </a>
      <?php else: ?>
        <a href="login-register.php?redirect=order">
          <button class="cta-button">Pesan Sekarang</button>
        </a>
      <?php endif; ?>

        <a href="#reservation">
          <button class="cta-button">Reservasi Meja</button>
        </a>
      </div>
    </div>
  </section>
  <div class="header-shadow"></div>
</header>