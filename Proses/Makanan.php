<?php

require_once __DIR__ . '/../configdb.php';

include '../views/header.php';

// Query data menu + stok (kolom quantity)
$sql = "
  SELECT
    id,
    name        AS nama_makanan,
    price       AS harga,
    image_url   AS gambar,
    description AS deskripsi,
    quantity    AS stok
  FROM menu
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Menu Makanan</title>
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
      max-width: 1200px;
      margin: auto;
      padding: 40px 0;
      flex: 1;
    }
    h1 {
      text-align: center;
      margin-bottom: 40px;
      color: white;
    }
    .card-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
    }
    .card {
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      width: 300px;
      overflow: hidden;
      transition: transform 0.3s ease;
      position: relative;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    .card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      background-color: #f0f0f0;
    }
    .card h2 {
      font-size: 1.5rem;
      margin: 16px;
    }
    .card p {
      margin: 0 16px 16px;
      color: #555;
    }
    .card-content {
      cursor: pointer;
      transition: background-color 0.2s ease;
    }
    .card-content:hover {
      background-color: #f8f9fa;
    }
    .card-buttons {
      display: flex;
      gap: 8px;
      margin: 0 16px 16px;
    }
    .detail-button {
      flex: 1;
      padding: 10px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 0.9rem;
      text-align: center;
      text-decoration: none;
      transition: background-color 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 5px;
    }
    .detail-button:hover {
      background-color: #0056b3;
    }
    .order-button {
      flex: 1;
      padding: 10px;
      background-color: rgb(233, 2, 2);
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 0.9rem;
      text-align: center;
      text-decoration: none;
      transition: background-color 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 5px;
    }
    .order-button:hover {
      background-color: rgb(124, 9, 9);
    }
    .sold-out {
      flex: 1;
      padding: 10px;
      background-color: #6c757d;
      color: #fff;
      border: none;
      border-radius: 5px;
      font-size: 0.9rem;
      text-align: center;
      text-decoration: none;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 5px;
      cursor: not-allowed;
    }
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
    .image-placeholder {
      width: 100%;
      height: 200px;
      background-color: #f0f0f0;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #666;
      font-size: 14px;
      text-align: center;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Menu Makanan</h1>
    <div class="card-container">

      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="card" data-menu-id="<?= $row['id'] ?>">
            <?php
            // Cek path gambar, fallback ke default jika tidak ada
            $image_path = '';
            $possible_paths = [
                'uploads/menu/' . basename($row['gambar']),
                '../uploads/menu/' . basename($row['gambar']),
                '../../uploads/menu/' . basename($row['gambar']),
                $row['gambar']
            ];
            foreach ($possible_paths as $path) {
                if (
                    (file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $path) && is_file($_SERVER['DOCUMENT_ROOT'] . '/' . $path)) ||
                    (file_exists($path) && is_file($path)) ||
                    filter_var($path, FILTER_VALIDATE_URL)
                ) {
                    $image_path = $path;
                    break;
                }
            }
            if (empty($image_path)) {
                $image_path = 'uploads/menu/default.jpg';
            }
            ?>

            <div class="card-content" onclick="window.location.href='detail.php?id=<?= $row['id'] ?>'">
              <img 
                src="<?= htmlspecialchars($image_path) ?>" 
                alt="<?= htmlspecialchars($row['nama_makanan']) ?>"
                onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';"
              />
              <div class="image-placeholder" style="display: none;">
                <i class="fas fa-image" style="font-size: 2rem; color: #ccc;"></i><br>
                Gambar tidak tersedia<br>
                <small><?= htmlspecialchars($row['nama_makanan']) ?></small>
              </div>
              
              <h2><?= htmlspecialchars($row['nama_makanan']) ?></h2>
              <p><?= htmlspecialchars($row['deskripsi'] ?? '') ?></p>
              <p>Harga: Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
              <p class="stok-info"><strong><?= (int)$row['stok'] ?></strong></p>
            </div>
            
            <div class="card-buttons">
              <a href="detail.php?id=<?= $row['id'] ?>" class="detail-button">
                <i class="fas fa-info-circle"></i> Detail
              </a>

              <?php if ($row['stok'] > 0): ?>
                <button 
                  class="order-button" 
                  onclick="event.stopPropagation(); pesanDanKurangiStok(
                     <?= $row['id'] ?>,
                    '<?= addslashes($row['nama_makanan']) ?>',
                    <?= $row['harga'] ?>,
                    this.closest('.card')
                  )"
                >
                  <i class="fas fa-shopping-cart"></i> Pesan
                </button>
              <?php else: ?>
                <button class="sold-out" disabled>
                  <i class="fas fa-times-circle"></i> Habis
                </button>
              <?php endif; ?>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p style="text-align: center; color: white;">Tidak ada data makanan tersedia.</p>
      <?php endif; ?>

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
    document.addEventListener('DOMContentLoaded', function() {
      updateCartPanel();
    });

    function showNotification(message) {
      const notification = document.getElementById('notification');
      notification.textContent = message;
      notification.style.display = 'block';
      setTimeout(function() {
        notification.style.display = 'none';
      }, 2000);
    }

    function updateCartPanel() {
      const keranjang = JSON.parse(localStorage.getItem('keranjang')) || [];
      const cartPanel  = document.getElementById('cart-panel');
      const totalItems = document.getElementById('total-items');
      const totalPrice = document.getElementById('total-price');
      
      if (keranjang.length > 0) {
        let itemCount  = 0;
        let priceTotal = 0;
        
        keranjang.forEach(item => {
          itemCount  += item.quantity;
          priceTotal += item.price * item.quantity;
        });
        
        totalItems.textContent = itemCount;
        totalPrice.textContent = new Intl.NumberFormat('id-ID').format(priceTotal);
        cartPanel.style.display = 'flex';
      } else {
        cartPanel.style.display = 'none';
      }
    }

    function pesanDanKurangiStok(idMenu, nama, harga, elemCard) {
      fetch('order_action.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'id=' + encodeURIComponent(idMenu)
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          let keranjang = JSON.parse(localStorage.getItem('keranjang')) || [];
          const idx = keranjang.findIndex(item => item.name === nama);

          if (idx !== -1) {
            keranjang[idx].quantity += 1;
          } else {
            keranjang.push({
              name: nama,
              price: harga,
              quantity: 1
            });
          }
          localStorage.setItem('keranjang', JSON.stringify(keranjang));
          showNotification(nama + " telah ditambahkan ke keranjang");
          updateCartPanel();

          const stokInfo = elemCard.querySelector('.stok-info strong');
          if (stokInfo) {
            stokInfo.textContent = data.new_stock;
          }

          if (data.new_stock <= 0) {
            const buttonArea = elemCard.querySelector('.card-buttons');
            buttonArea.innerHTML = `
              <a href="detail.php?id=${idMenu}" class="detail-button">
                <i class="fas fa-info-circle"></i> Detail
              </a>
              <button class="sold-out" disabled>
                <i class="fas fa-times-circle"></i> Habis
              </button>
            `;
          }
        }
        else if (data.status === 'out_of_stock') {
          alert("Maaf, stok \"" + nama + "\" sudah habis.");
          const buttonArea = elemCard.querySelector('.card-buttons');
          buttonArea.innerHTML = `
            <a href="detail.php?id=${idMenu}" class="detail-button">
              <i class="fas fa-info-circle"></i> Detail
            </a>
            <button class="sold-out" disabled>
              <i class="fas fa-times-circle"></i> Habis
            </button>
          `;
          const stokInfo = elemCard.querySelector('.stok-info strong');
          if (stokInfo) {
            stokInfo.textContent = '0';
          }
        }
        else {
          alert("Terjadi kesalahan: " + data.message);
        }
      })
      .catch(err => {
        console.error("Fetch error:", err);
        alert("Gagal terhubung ke server untuk memesan \"" + nama + "\"");
      });
    }

    window.addEventListener('storage', function(e) {
      if (e.key === 'keranjang') {
        updateCartPanel();
      }
    });
  </script>
</body>
</html>

<?php include '../views/footer.php'; ?>