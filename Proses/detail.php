<?php
require_once __DIR__ . '/../configdb.php';

include './views/header.php';

// Ambil ID dari parameter URL
$menu_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($menu_id <= 0) {
    header("Location: menu.php");
    exit();
}

// Query untuk mengambil detail makanan berdasarkan ID
$sql = "SELECT id, name AS nama_makanan, price AS harga, image_url AS gambar, 
               description AS deskripsi, ingredients AS bahan_utama, 
               calories AS kalori, type AS jenis 
        FROM menu WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $menu_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: menu.php");
    exit();
}

$menu = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php echo htmlspecialchars($menu['nama_makanan']); ?> - Detail Menu</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: rgb(4, 4, 4);
      margin: 0;
      padding: 0;
      padding-bottom: 70px;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    
    .container {
      width: 90%;
      max-width: 1000px;
      margin: auto;
      padding: 40px 0;
      flex: 1;
    }
    
    .back-button {
      display: inline-block;
      margin-bottom: 20px;
      padding: 10px 20px;
      background-color: #666;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }
    
    .back-button:hover {
      background-color: #555;
    }
    
    .detail-card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
      overflow: hidden;
      margin-bottom: 20px;
    }
    
    .detail-image {
      width: 100%;
      height: 400px;
      object-fit: cover;
      background-color: #f0f0f0;
    }
    
    .image-placeholder {
      width: 100%;
      height: 400px;
      background-color: #f0f0f0;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #666;
      font-size: 16px;
      text-align: center;
    }
    
    .detail-content {
      padding: 30px;
    }
    
    .menu-title {
      font-size: 2.5rem;
      margin: 0 0 10px 0;
      color: #333;
      font-weight: bold;
    }
    
    .menu-type {
      display: inline-block;
      background-color: #e9f5ff;
      color: #0066cc;
      padding: 5px 15px;
      border-radius: 20px;
      font-size: 0.9rem;
      margin-bottom: 15px;
    }
    
    .menu-price {
      font-size: 2rem;
      color: rgb(233, 2, 2);
      font-weight: bold;
      margin-bottom: 20px;
    }
    
    .menu-description {
      font-size: 1.1rem;
      line-height: 1.6;
      color: #555;
      margin-bottom: 25px;
    }
    
    .info-section {
      background-color: #f8f9fa;
      padding: 20px;
      border-radius: 8px;
      margin-bottom: 25px;
    }
    
    .info-title {
      font-size: 1.3rem;
      font-weight: bold;
      color: #333;
      margin-bottom: 15px;
      display: flex;
      align-items: center;
    }
    
    .info-title i {
      margin-right: 10px;
      color: rgb(233, 2, 2);
    }
    
    .ingredients-list {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
    }
    
    .ingredient-tag {
      background-color: #fff;
      padding: 8px 15px;
      border-radius: 20px;
      border: 2px solid #e0e0e0;
      font-size: 0.9rem;
      color: #555;
    }
    
    .calories-info {
      display: flex;
      align-items: center;
      font-size: 1.1rem;
      color: #666;
    }
    
    .calories-info i {
      margin-right: 10px;
      color: #ff6b35;
    }
    
    .order-section {
      display: flex;
      gap: 15px;
      align-items: center;
      justify-content: center;
      margin-top: 30px;
    }
    
    .quantity-control {
      display: flex;
      align-items: center;
      background-color: #f0f0f0;
      border-radius: 25px;
      padding: 5px;
    }
    
    .quantity-btn {
      width: 40px;
      height: 40px;
      border: none;
      background-color: rgb(233, 2, 2);
      color: white;
      border-radius: 50%;
      cursor: pointer;
      font-size: 1.2rem;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .quantity-btn:hover {
      background-color: rgb(124, 9, 9);
    }
    
    .quantity-display {
      padding: 0 20px;
      font-size: 1.2rem;
      font-weight: bold;
      min-width: 40px;
      text-align: center;
    }
    
    .add-to-cart-btn {
      padding: 15px 30px;
      background-color: rgb(233, 2, 2);
      color: white;
      border: none;
      border-radius: 25px;
      cursor: pointer;
      font-size: 1.1rem;
      font-weight: bold;
      transition: background-color 0.3s ease;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    
    .add-to-cart-btn:hover {
      background-color: rgb(124, 9, 9);
    }
    
    /* Style untuk panel keranjang - sama seperti halaman menu */
    .cart-panel {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      background-color: rgba(255, 61, 55, 0.97);
      color: white;
      padding: 15px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      z-index: 1000;
      box-shadow: 0 -2px 10px rgba(0,0,0,0.2);
      cursor: pointer;
      transition: all 0.3s ease;
      display: none;
    }
    
    .cart-panel:hover {
      background-color: rgb(201, 15, 15);
    }
    
    .cart-left {
      display: flex;
      flex-direction: column;
    }
    
    .cart-right {
      display: flex;
      align-items: center;
    }
    
    .cart-icon {
      font-size: 1.5rem;
      margin-left: 10px;
    }
    
    .cart-item-count {
      font-weight: bold;
      font-size: 1.2rem;
    }
    
    .cart-origin {
      font-size: 0.9rem;
      opacity: 0.9;
    }
    
    .cart-total {
      font-weight: bold;
      font-size: 1.2rem;
    }
    
    .notification {
      position: fixed;
      bottom: 80px;
      left: 50%;
      transform: translateX(-50%);
      background-color: rgba(0,0,0,0.8);
      color: white;
      padding: 12px 20px;
      border-radius: 8px;
      z-index: 1001;
      display: none;
      max-width: 80%;
      text-align: center;
    }

    /* Footer Styles */
    footer {
      background-color: #333;
      color: white;
      text-align: center;
      padding: 10px 0;
      margin-top: 20px;
    }

    footer a {
      color: white;
      text-decoration: none;
      margin: 0 10px;
    }

    footer a:hover {
      text-decoration: underline;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
      .menu-title {
        font-size: 2rem;
      }
      
      .menu-price {
        font-size: 1.5rem;
      }
      
      .order-section {
        flex-direction: column;
        gap: 20px;
      }
      
      .detail-image {
        height: 300px;
      }
      
      .image-placeholder {
        height: 300px;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <a href="makanan.php" class="back-button">
      <i class="fas fa-arrow-left"></i> Kembali ke Menu
    </a>
    
    <div class="detail-card">
      <?php
      // Handle gambar seperti di halaman menu
      $image_path = '';
      $possible_paths = [
          'uploads/menu/' . basename($menu['gambar']),
          '../uploads/menu/' . basename($menu['gambar']),
          '../../uploads/menu/' . basename($menu['gambar']),
          'uploads/menu/' . basename($menu['gambar']),
          '../uploads/menu/' . basename($menu['gambar']),
          $menu['gambar']
      ];
      
      foreach ($possible_paths as $path) {
          if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $path) || 
              file_exists($path) || 
              filter_var($path, FILTER_VALIDATE_URL)) {
              $image_path = $path;
              break;
          }
      }
      
      if (empty($image_path)) {
          $image_path = 'uploads/menu/' . basename($menu['gambar']);
      }
      ?>
      
      <img 
        src="<?php echo htmlspecialchars($image_path); ?>" 
        alt="<?php echo htmlspecialchars($menu['nama_makanan']); ?>"
        class="detail-image"
        onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';"
      />
      
      <div class="image-placeholder" style="display: none;">
        <div>
          <i class="fas fa-image" style="font-size: 3rem; color: #ccc;"></i><br><br>
          Gambar tidak tersedia<br>
          <small><?php echo htmlspecialchars($menu['nama_makanan']); ?></small>
        </div>
      </div>
      
      <div class="detail-content">
        <h1 class="menu-title"><?php echo htmlspecialchars($menu['nama_makanan']); ?></h1>
        
        <?php if (!empty($menu['jenis'])): ?>
          <span class="menu-type"><?php echo htmlspecialchars($menu['jenis']); ?></span>
        <?php endif; ?>
        
        <div class="menu-price">Rp <?php echo number_format($menu['harga'], 0, ',', '.'); ?></div>
        
        <?php if (!empty($menu['deskripsi'])): ?>
          <div class="menu-description">
            <?php echo nl2br(htmlspecialchars($menu['deskripsi'])); ?>
          </div>
        <?php endif; ?>
        
        <?php if (!empty($menu['bahan_utama'])): ?>
          <div class="info-section">
            <div class="info-title">
              <i class="fas fa-leaf"></i>
              Bahan Utama
            </div>
            <div class="ingredients-list">
              <?php 
              $ingredients = explode(',', $menu['bahan_utama']);
              foreach ($ingredients as $ingredient): 
                $ingredient = trim($ingredient);
                if (!empty($ingredient)):
              ?>
                <span class="ingredient-tag"><?php echo htmlspecialchars($ingredient); ?></span>
              <?php 
                endif;
              endforeach; 
              ?>
            </div>
          </div>
        <?php endif; ?>
        
        <?php if (!empty($menu['kalori']) && $menu['kalori'] > 0): ?>
          <div class="info-section">
            <div class="calories-info">
              <i class="fas fa-fire"></i>
              <strong><?php echo number_format($menu['kalori']); ?> Kalori</strong>
            </div>
          </div>
        <?php endif; ?>
        
        <div class="order-section">
          <div class="quantity-control">
            <button class="quantity-btn" onclick="changeQuantity(-1)">
              <i class="fas fa-minus"></i>
            </button>
            <span class="quantity-display" id="quantity">1</span>
            <button class="quantity-btn" onclick="changeQuantity(1)">
              <i class="fas fa-plus"></i>
            </button>
          </div>
          
          <button class="add-to-cart-btn" onclick="tambahKeKeranjang()">
            <i class="fas fa-shopping-cart"></i>
            Tambah ke Keranjang
          </button>
        </div>
      </div>
    </div>
  </div>
  
  <div class="notification" id="notification"></div>
  
  <div class="cart-panel" id="cart-panel" onclick="window.location.href='keranjang.php'">
    <div class="cart-left">
      <div class="cart-item-count"><span id="total-items">0</span> item</div>
      <div class="cart-origin">Diantar dari <span id="restoran-name">Restoran Anda</span></div>
    </div>
    <div class="cart-right">
      <div class="cart-total">Rp <span id="total-price">0</span></div>
      <div class="cart-icon"><i class="fas fa-shopping-cart"></i></div>
    </div>
  </div>

  <footer>
    <a href="saran.php">Kritik & Saran</a>
  </footer>

  <script>
    // Data menu dari PHP
    const menuData = {
      name: "<?php echo addslashes($menu['nama_makanan']); ?>",
      price: <?php echo $menu['harga']; ?>
    };
    
    let currentQuantity = 1;
    
    // Periksa keranjang saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
      updateCartPanel();
    });
    
    function changeQuantity(change) {
      currentQuantity += change;
      if (currentQuantity < 1) {
        currentQuantity = 1;
      }
      document.getElementById('quantity').textContent = currentQuantity;
    }
    
    function tambahKeKeranjang() {
      // Dapatkan keranjang yang ada atau buat array kosong jika belum ada
      let keranjang = JSON.parse(localStorage.getItem('keranjang')) || [];
      
      // Cek apakah item sudah ada di keranjang
      const indexItem = keranjang.findIndex(item => item.name === menuData.name);
      
      if (indexItem !== -1) {
        // Jika item sudah ada, tambahkan quantity
        keranjang[indexItem].quantity += currentQuantity;
      } else {
        // Jika item belum ada, tambahkan item baru
        keranjang.push({
          name: menuData.name,
          price: menuData.price,
          quantity: currentQuantity
        });
      }
      
      // Simpan kembali ke localStorage
      localStorage.setItem('keranjang', JSON.stringify(keranjang));
      
      // Tampilkan notifikasi
      showNotification(currentQuantity + " " + menuData.name + " telah ditambahkan ke keranjang");
      
      // Update panel keranjang
      updateCartPanel();
      
      // Reset quantity ke 1
      currentQuantity = 1;
      document.getElementById('quantity').textContent = currentQuantity;
    }
    
    function showNotification(message) {
      const notification = document.getElementById('notification');
      notification.textContent = message;
      notification.style.display = 'block';
      
      // Hilangkan notifikasi setelah 3 detik
      setTimeout(function() {
        notification.style.display = 'none';
      }, 3000);
    }
    
    function updateCartPanel() {
      const keranjang = JSON.parse(localStorage.getItem('keranjang')) || [];
      const cartPanel = document.getElementById('cart-panel');
      const totalItems = document.getElementById('total-items');
      const totalPrice = document.getElementById('total-price');
      
      if (keranjang.length > 0) {
        // Hitung total item dan harga
        let itemCount = 0;
        let priceTotal = 0;
        
        keranjang.forEach(item => {
          itemCount += item.quantity;
          priceTotal += item.price * item.quantity;
        });
        
        // Update tampilan
        totalItems.textContent = itemCount;
        totalPrice.textContent = new Intl.NumberFormat('id-ID').format(priceTotal);
        
        // Tampilkan panel
        cartPanel.style.display = 'flex';
      } else {
        // Sembunyikan panel jika keranjang kosong
        cartPanel.style.display = 'none';
      }
    }
    
    // Tambahan untuk menangkap perubahan pada storage di tab/window lain
    window.addEventListener('storage', function(e) {
      if (e.key === 'keranjang') {
        updateCartPanel();
      }
    });
  </script>
</body>
</html>

<?php include 'views/footer.php'; ?>