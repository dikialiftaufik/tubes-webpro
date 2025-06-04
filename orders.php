<?php
session_start();
include 'configdb.php';

$user_id = $_SESSION['user']['id'] ?? 0;
$orders = [];

$sql = "SELECT o.id AS order_id, o.status, o.created_at,
               m.name AS nama_makanan, m.image_url,
               oi.quantity, oi.price_at_order
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        JOIN menu m ON oi.menu_id = m.id
        WHERE o.user_id = ?
        ORDER BY o.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $orders[$row['order_id']]['items'][] = $row;
    $orders[$row['order_id']]['status'] = $row['status'];
    $orders[$row['order_id']]['created_at'] = $row['created_at'];
}

// Function to translate status to Indonesian
function translateStatus($status) {
    $statusTranslations = [
        'pending' => 'Diproses',
        'processing' => 'Sedang Diproses',
        'preparing' => 'Sedang Disiapkan',
        'ready' => 'Siap Diambil',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
        'delivered' => 'Terkirim'
    ];
    
    return $statusTranslations[$status] ?? ucwords(str_replace('_', ' ', $status));
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pesanan Saya</title>
  <link rel="icon" type="image/x-icon" href="img/logo/logo-alt.png" />
  <link rel="stylesheet" href="css/responsive.css" />
  <link rel="stylesheet" href="css/orders.css" />
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
<?php ?>
<header>
  <nav id="nav-desktop">
    <div class="nav large-container">
      <ul>
        <li data-aos="fade-down" data-aos-duration="500"><a href="index.php">Home</a></li>
        <li data-aos="fade-down" data-aos-duration="500" data-aos-delay="100"><a href="AboutUs.php">About</a></li>
        <li data-aos="fade-down" data-aos-duration="500" data-aos-delay="200"><a href="Makanan.php">Menu</a></li>
        <li data-aos="fade-down" data-aos-duration="500" data-aos-delay="400"><a href="#reservation">Reservasi</a></li>
      </ul>

      <img src="img/logo/logo2.png" data-aos="fade-down" data-aos-duration="500" data-aos-delay="300" alt="logo" width="150px" height="75px" />

      <ul>
        <li data-aos="fade-down" data-aos-duration="500" data-aos-delay="500"><a href="#location">Lokasi</a></li>
        <li data-aos="fade-down" data-aos-duration="500" data-aos-delay="600"><a href="findJobs.php">Karir</a></li>
        <li data-aos="fade-down" data-aos-duration="500" data-aos-delay="700"><a href="findJobs.php"><i class="fas fa-shopping-cart"></i></a></li>
        <li class="notification-dropdown" data-aos="fade-down" data-aos-duration="500" data-aos-delay="800">
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
        <li class="user-dropdown" data-aos="fade-down" data-aos-duration="500" data-aos-delay="900">
          <a href="#">
            <i class="fas fa-user"></i>
          </a>
          <div class="dropdown-content-user">
            <div class="user-info">
              <img src="img/profile-pic.png" alt="User Profile" />
              <div class="user-name"><?= htmlspecialchars($_SESSION['user']['username'] ?? 'Guest') ?></div>
            </div>
            <div class="dropdown-divider"></div>
            <a href="account.php" class="dropdown-item"><i class="fas fa-user-cog"></i><p> Akun Saya</p></a>
            <a href="orders.php" class="dropdown-item"><i class="fas fa-box"></i><p> Pesanan Saya</p></a>
            <a href="reservations.php" class="dropdown-item"><i class="fas fa-calendar-alt"></i><p> Reservasi Saya</p></a>
            <div class="dropdown-divider"></div>
            <a href="signout.php" class="dropdown-item logout"><i class="fas fa-sign-out-alt"></i><p> Sign Out</p></a>
          </div>
        </li>
      </ul>
    </div>
  </nav>
  <nav id="nav-mobile">
    <div class="nav-mobile">
      <div class="nav large-container">
        <img src="img/logo/logo-alt.png" data-aos="fade-down" data-aos-duration="500" data-aos-delay="200" alt="logo-alt" width="50px" height="50px" />
        <div id="burger-navigation">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
    </div>
    <div class="nav-mobile-main">
      <div><a href="index.php">Home</a></div>
      <div><a href="about.php">About Us</a></div>
      <div><a href="Makanan.php">Menu</a></div>
      <div><a href="#reservation">Reservation</a></div>
      <div><a href="#location">Location</a></div>
      <div><a href="findJobs.php">Find Jobs</a></div>
    </div>
  </nav>
</header>
<?php ?>

<div class="container">
  <aside class="sidebar">
    <ul class="sidebar-menu">
      <li><a href="account.php"><i class="fas fa-user"></i><span>Akun Saya</span></a></li>
      <li><a href="orders.php" class="active"><i class="fas fa-box"></i><span>Pesanan Saya</span></a></li>
      <li><a href="reservations.php"><i class="fas fa-calendar-alt"></i><span>Reservasi Saya</span></a></li>
    </ul>
  </aside>

  <main class="main-content">
    <div class="orders-list">
      <?php if (empty($orders)): ?>
        <div class="no-orders">
          <h3>Belum ada pesanan</h3>
          <p>Anda belum memiliki pesanan apapun. Silakan pesan menu favorit Anda!</p>
          <a href="Makanan.php" class="btn btn-primary">Lihat Menu</a>
        </div>
      <?php else: ?>
        <?php foreach ($orders as $orderId => $orderData): ?>
        <div class="order-card <?= $orderData['status'] === 'completed' ? 'completed' : '' ?>">
          <div class="order-header">
            <div class="order-info">
              <span class="order-id">#<?= htmlspecialchars($orderId) ?></span>
              <span class="order-date"><?= date('j F Y, H:i', strtotime($orderData['created_at'])) ?></span>
            </div>
            <span class="order-status <?= htmlspecialchars($orderData['status']) ?>">
              <?= translateStatus($orderData['status']) ?>
            </span>
          </div>

          <div class="order-items">
            <?php foreach ($orderData['items'] as $item): ?>
            <div class="order-item">
              <img src="uploads/menu/<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['nama_makanan']) ?>" class="item-image">
              <div class="item-details">
                <h4><?= htmlspecialchars($item['nama_makanan']) ?></h4>
                <p class="item-quantity"><?= $item['quantity'] ?>x</p>
                <p class="item-price">Rp <?= number_format($item['price_at_order'], 0, ',', '.') ?>/porsi</p>
              </div>
            </div>
            <?php endforeach; ?>
          </div>

          <div class="order-footer">
            <div class="order-total">
              <span>Total Pesanan:</span>
              <h3>
                Rp <?= number_format(array_sum(array_map(function($i){ return $i['price_at_order'] * $i['quantity']; }, $orderData['items'])), 0, ',', '.') ?>
              </h3>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </main>
</div>

<!-- Footer Section -->
<footer style="background-color: #2c2c2c; color: white; padding: 40px 0; margin-top: 50px;">
  <div class="large-container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px;">
      <div>
        <img src="img/logo/logo2.png" alt="Logo" style="width: 120px; margin-bottom: 15px;">
        <p style="line-height: 1.6; margin-bottom: 15px;">
          Restoran terbaik dengan cita rasa autentik dan pelayanan terpercaya. 
          Nikmati pengalaman kuliner yang tak terlupakan bersama kami.
        </p>
        <div style="display: flex; gap: 10px;">
          <a href="#" style="color: #ffd700; font-size: 20px;"><i class="fab fa-facebook"></i></a>
          <a href="#" style="color: #ffd700; font-size: 20px;"><i class="fab fa-instagram"></i></a>
          <a href="#" style="color: #ffd700; font-size: 20px;"><i class="fab fa-twitter"></i></a>
        </div>
      </div>
      
      <div>
        <h4 style="color: #ffd700; margin-bottom: 15px;">Menu Utama</h4>
        <ul style="list-style: none; padding: 0;">
          <li style="margin-bottom: 8px;"><a href="index.php" style="color: white; text-decoration: none;">Home</a></li>
          <li style="margin-bottom: 8px;"><a href="AboutUs.php" style="color: white; text-decoration: none;">About</a></li>
          <li style="margin-bottom: 8px;"><a href="Makanan.php" style="color: white; text-decoration: none;">Menu</a></li>
          <li style="margin-bottom: 8px;"><a href="#reservation" style="color: white; text-decoration: none;">Reservasi</a></li>
        </ul>
      </div>
      
      <div>
        <h4 style="color: #ffd700; margin-bottom: 15px;">Kontak</h4>
        <div style="margin-bottom: 10px;">
          <i class="fas fa-map-marker-alt" style="color: #ffd700; margin-right: 10px;"></i>
          <span>Jl. Kuliner No. 123, Bandung, Jawa Barat</span>
        </div>
        <div style="margin-bottom: 10px;">
          <i class="fas fa-phone" style="color: #ffd700; margin-right: 10px;"></i>
          <span>+62 22 1234 5678</span>
        </div>
        <div style="margin-bottom: 10px;">
          <i class="fas fa-envelope" style="color: #ffd700; margin-right: 10px;"></i>
          <span>info@restaurant.com</span>
        </div>
      </div>
      
      <div>
        <h4 style="color: #ffd700; margin-bottom: 15px;">Jam Operasional</h4>
        <div style="margin-bottom: 8px;">
          <strong>Senin - Jumat:</strong><br>
          <span>10:00 - 21:00</span>
        </div>
        <div style="margin-bottom: 8px;">
          <strong>Sabtu - Minggu:</strong><br>
          <span>09:00 - 22:00</span>
        </div>
      </div>
    </div>
    
    <hr style="border: none; border-top: 1px solid #555; margin: 30px 0;">
    
    <div style="text-align: center;">
      <p>&copy; 2025 Restaurant. All rights reserved.</p>
    </div>
  </div>
</footer>

<script src="js/script.js" type="text/javascript"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
<script>AOS.init();</script>
</body>
</html>