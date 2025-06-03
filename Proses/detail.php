<?php
require_once __DIR__ . '/../configdb.php';

include './views/header.php';

// Ambil ID menu dari parameter URL
$menu_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($menu_id <= 0) {
    header("Location: makanan.php");
    exit();
}

// Query detail menu (termasuk kolom quantity => stok)
$sql = "
    SELECT 
      id,
      name          AS nama_makanan,
      price         AS harga,
      image_url     AS gambar,
      description   AS deskripsi,
      ingredients   AS bahan_utama,
      calories      AS kalori,
      type          AS jenis,
      quantity      AS stok
    FROM menu 
    WHERE id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $menu_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: makanan.php");
    exit();
}

$menu = $result->fetch_assoc();
$stmt->close();
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
      padding-bottom: 80px;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    .container {
      width: 90%;
      max-width: 1000px;
      margin: 20px auto;
      padding: 0;
      flex: 1;
    }
    .back-button {
      display: inline-block;
      margin-bottom: 20px;
      padding: 12px 24px;
      background-color: #666;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      transition: all 0.3s ease;
      font-weight: 500;
    }
    .back-button:hover {
      background-color: #555;
      transform: translateY(-1px);
    }
    .detail-card {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 12px 24px rgba(0,0,0,0.15);
      overflow: hidden;
      margin-bottom: 20px;
    }
    .detail-image {
      width: 100%;
      height: 350px;
      object-fit: cover;
      background-color: #f8f9fa;
    }
    .image-placeholder {
      width: 100%;
      height: 350px;
      background-color: #f8f9fa;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #999;
      font-size: 16px;
      text-align: center;
    }
    .detail-content {
      padding: 25px;
    }
    .menu-header {
      border-bottom: 2px solid #f0f0f0;
      padding-bottom: 20px;
      margin-bottom: 25px;
    }
    .menu-title {
      font-size: 2.2rem;
      margin: 0 0 12px 0;
      color: #333;
      font-weight: 700;
      line-height: 1.2;
    }
    .menu-type {
      display: inline-block;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 6px 16px;
      border-radius: 25px;
      font-size: 0.85rem;
      font-weight: 500;
      margin-bottom: 15px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .menu-price {
      font-size: 2.2rem;
      color: rgb(233, 2, 2);
      font-weight: 800;
      margin: 0;
    }
    .menu-description {
      font-size: 1rem;
      line-height: 1.7;
      color: #666;
      margin-bottom: 25px;
      text-align: justify;
    }
    .info-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 20px;
      margin-bottom: 30px;
    }
    .info-section {
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      padding: 20px;
      border-radius: 12px;
      border-left: 4px solid rgb(233, 2, 2);
    }
    .info-title {
      font-size: 1.1rem;
      font-weight: 600;
      color: #333;
      margin-bottom: 15px;
      display: flex;
      align-items: center;
    }
    .info-title i {
      margin-right: 12px;
      color: rgb(233, 2, 2);
      font-size: 1.2rem;
    }
    .ingredients-list {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
    }
    .ingredient-tag {
      background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
      padding: 8px 16px;
      border-radius: 25px;
      border: 2px solid #e9ecef;
      font-size: 0.9rem;
      color: #555;
      font-weight: 500;
      transition: all 0.3s ease;
    }
    .ingredient-tag:hover {
      border-color: rgb(233, 2, 2);
      transform: translateY(-2px);
    }
    .calories-info {
      display: flex;
      align-items: center;
      font-size: 1.1rem;
      color: #555;
      font-weight: 600;
    }
    .calories-info i {
      margin-right: 12px;
      color: #ff6b35;
      font-size: 1.3rem;
    }
    .order-section {
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      padding: 25px;
      border-radius: 12px;
      display: flex;
      gap: 20px;
      align-items: center;
      justify-content: center;
      margin-top: 25px;
      border: 2px solid #e9ecef;
    }
    .quantity-control {
      display: flex;
      align-items: center;
      background: white;
      border-radius: 30px;
      padding: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .quantity-btn {
      width: 45px;
      height: 45px;
      border: none;
      background: linear-gradient(135deg, rgb(233, 2, 2) 0%, rgb(180, 2, 2) 100%);
      color: white;
      border-radius: 50%;
      cursor: pointer;
      font-size: 1.2rem;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
    }
    .quantity-btn:hover {
      transform: scale(1.1);
      box-shadow: 0 4px 12px rgba(233, 2, 2, 0.3);
    }
    .quantity-display {
      padding: 0 25px;
      font-size: 1.3rem;
      font-weight: 700;
      min-width: 50px;
      text-align: center;
      color: #333;
    }
    .add-to-cart-btn {
      padding: 15px 35px;
      background: linear-gradient(135deg, rgb(233, 2, 2) 0%, rgb(180, 2, 2) 100%);
      color: white;
      border: none;
      border-radius: 30px;
      cursor: pointer;
      font-size: 1.1rem;
      font-weight: 600;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 12px;
      box-shadow: 0 6px 20px rgba(233, 2, 2, 0.3);
    }
    .add-to-cart-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(233, 2, 2, 0.4);
    }
    /* Tombol Habis */
    .sold-out-detail {
      padding: 15px 35px;
      background: #6c757d;
      color: white;
      border: none;
      border-radius: 30px;
      font-size: 1.1rem;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 12px;
      cursor: not-allowed;
      box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }
    .cart-panel {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      background: linear-gradient(135deg, rgba(233, 2, 2, 0.95) 0%, rgba(180, 2, 2, 0.95) 100%);
      color: white;
      padding: 18px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      z-index: 1000;
      box-shadow: 0 -4px 20px rgba(0,0,0,0.3);
      cursor: pointer;
      transition: all 0.3s ease;
      display: none;
      backdrop-filter: blur(10px);
    }
    .cart-panel:hover {
      background: linear-gradient(135deg, rgb(201, 15, 15) 0%, rgb(150, 15, 15) 100%);
    }
    .cart-left, .cart-right {
      display: flex;
      align-items: center;
    }
    .cart-left {
      flex-direction: column;
    }
    .cart-icon {
      font-size: 1.6rem;
      margin-left: 15px;
    }
    .cart-item-count {
      font-weight: 700;
      font-size: 1.2rem;
    }
    .cart-origin {
      font-size: 0.9rem;
      opacity: 0.9;
      margin-top: 2px;
    }
    .cart-total {
      font-weight: 700;
      font-size: 1.3rem;
    }
    .notification {
      position: fixed;
      bottom: 100px;
      left: 50%;
      transform: translateX(-50%);
      background: linear-gradient(135deg, rgba(0,0,0,0.9) 0%, rgba(33,33,33,0.9) 100%);
      color: white;
      padding: 15px 25px;
      border-radius: 12px;
      z-index: 1001;
      display: none;
      max-width: 80%;
      text-align: center;
      font-weight: 500;
      backdrop-filter: blur(10px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }
    /* Responsive */
    @media (max-width: 768px) {
      .container { width: 95%; margin: 15px auto; }
      .menu-title { font-size: 1.8rem; }
      .menu-price { font-size: 1.8rem; }
      .order-section { flex-direction: column; gap: 20px; padding: 20px; }
      .detail-image, .image-placeholder { height: 280px; }
      .detail-content { padding: 20px; }
      .ingredient-tag { font-size: 0.8rem; padding: 6px 12px; }
    }
    @media (max-width: 480px) {
      .container { width: 98%; margin: 10px auto; }
      .menu-title { font-size: 1.6rem; }
      .menu-price { font-size: 1.6rem; }
      .detail-content { padding: 15px; }
      .order-section { padding: 15px; }
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
      // Menentukan path gambar seperti biasa
      $image_path = '';
      $possible_paths = [
          'uploads/menu/' . basename($menu['gambar']),
          '../uploads/menu/' . basename($menu['gambar']),
          '../../uploads/menu/' . basename($menu['gambar']),
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
        <div class="menu-header">
          <h1 class="menu-title"><?php echo htmlspecialchars($menu['nama_makanan']); ?></h1>
          
          <?php if (!empty($menu['jenis'])): ?>
            <span class="menu-type"><?php echo htmlspecialchars($menu['jenis']); ?></span>
          <?php endif; ?>
          
          <div class="menu-price">Rp <?php echo number_format($menu['harga'], 0, ',', '.'); ?></div>
        </div>
        
        <?php if (!empty($menu['deskripsi'])): ?>
          <div class="menu-description">
            <?php echo nl2br(htmlspecialchars($menu['deskripsi'])); ?>
          </div>
        <?php endif; ?>
        
        <div class="info-grid">
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
        </div>
        
        <!-- ============================================================== -->
        <!-- Bagian form pemesanan / cek stok -->
        <!-- ============================================================== -->
        <?php if ($menu['stok'] > 0): ?>
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
        <?php else: ?>
          <div class="order-section" style="justify-content: center;">
            <button class="sold-out-detail" disabled>
              <i class="fas fa-times-circle"></i> Stok Habis
            </button>
          </div>
        <?php endif; ?>
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

  <script>
    // Data menu yang dikirim dari PHP
    const menuData = {
      id: <?php echo $menu['id']; ?>,
      name: "<?php echo addslashes($menu['nama_makanan']); ?>",
      price: <?php echo $menu['harga']; ?>
    };
    let currentQuantity = 1;

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
      // 1) Cek stok di PHP sekali lagi (sebelum fetch)
      <?php if ($menu['stok'] <= 0): ?>
        alert("Maaf, stok sudah habis.");
        return;
      <?php endif; ?>

      // 2) Panggil order_action.php untuk mengurangi stok di database
      fetch('order_action.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'id=' + encodeURIComponent(menuData.id)
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          // 2.a) Jika stok berhasil dikurangi, baru tambahkan ke localStorage
          let keranjang = JSON.parse(localStorage.getItem('keranjang')) || [];
          const idx = keranjang.findIndex(item => item.name === menuData.name);

          if (idx !== -1) {
            keranjang[idx].quantity += currentQuantity;
          } else {
            keranjang.push({
              name: menuData.name,
              price: menuData.price,
              quantity: currentQuantity
            });
          }
          localStorage.setItem('keranjang', JSON.stringify(keranjang));

          // Tampilkan notifikasi
          showNotification(currentQuantity + " " + menuData.name + " telah ditambahkan ke keranjang");
          updateCartPanel();

          // Reset quantity ke 1
          currentQuantity = 1;
          document.getElementById('quantity').textContent = currentQuantity;

          // 2.b) Perbarui teks stok di halaman detail menjadi new_stock
          const newStok = data.new_stock;
          // Ubah teks stok di info‐grid (jika Anda ingin menampilkan)
          // Namun di detail.php Anda tidak menampilkan “Stok Tersedia” secara eksplisit --
          // jika perlu, Anda bisa menaruh <p>Stok: ...</p> di detail‐layout dan update di sini.

          // 2.c) Jika stok baru = 0, ubah tombol menjadi “Stok Habis”
          if (newStok <= 0) {
            const orderSection = document.querySelector('.order-section');
            orderSection.innerHTML = `
              <button class="sold-out-detail" disabled>
                <i class="fas fa-times-circle"></i> Stok Habis
              </button>
            `;
          }
        }
        else if (data.status === 'out_of_stock') {
          // 3.a) Jika stok ternyata habis saat JS memanggil, munculkan pesan
          alert("Maaf, stok \"" + menuData.name + "\" sudah habis.");
          const orderSection = document.querySelector('.order-section');
          orderSection.innerHTML = `
            <button class="sold-out-detail" disabled>
              <i class="fas fa-times-circle"></i> Stok Habis
            </button>
          `;
        }
        else {
          // 4) Jika ada error lain
          alert("Terjadi kesalahan: " + data.message);
        }
      })
      .catch(err => {
        console.error("Fetch error:", err);
        alert("Gagal terhubung ke server untuk memesan \"" + menuData.name + "\"");
      });
    }

    function showNotification(message) {
      const notification = document.getElementById('notification');
      notification.textContent = message;
      notification.style.display = 'block';
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
        let itemCount = 0;
        let priceTotal = 0;

        keranjang.forEach(item => {
          itemCount += item.quantity;
          priceTotal += item.price * item.quantity;
        });

        totalItems.textContent = itemCount;
        totalPrice.textContent = new Intl.NumberFormat('id-ID').format(priceTotal);
        cartPanel.style.display = 'flex';
      } else {
        cartPanel.style.display = 'none';
      }
    }

    window.addEventListener('storage', function(e) {
      if (e.key === 'keranjang') {
        updateCartPanel();
      }
    });
  </script>
</body>
</html>

<?php include 'views/footer.php'; ?>
