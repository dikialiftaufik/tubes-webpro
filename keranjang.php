<?php
session_start();
include './configdb.php';
include './views/header.php';
?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/responsive.css" />
    <link rel="stylesheet" href="../css/navbar.css" />
    <title>Keranjang Makanan</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: #000;
        color: white;
        margin: 0;
        padding: 0;
      }

      .container {
        display: flex;
        flex-direction: column;
        align-items: center;
      }

      header {
        background-color: #333;
        width: 100%;
        padding: 20px;
        text-align: center;
      }

      h1 {
        margin: 0;
        font-size: 2em;
      }

      .keranjang-container {
        width: 80%;
        margin: 30px 0;
      }

      ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
      }

      li {
        background-color: #555;
        padding: 15px;
        margin: 10px 0;
        border-radius: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
      }

      .quantity-controls {
        display: flex;
        align-items: center;
      }

      button {
        margin: 0 5px;
        background-color: #555;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
      }

      button:hover {
        background-color: #777;
      }

      button.remove-btn {
        background-color: #e03e00;
      }

      button.remove-btn:hover {
        background-color: #d03300;
      }

      .keranjang-footer {
        width: 80%;
        text-align: center;
        margin-top: 20px;
      }

      #checkout-button, #back-button {
        background-color: #ff4500;
        color: white;
        padding: 15px 30px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1.2em;
        margin: 10px;
      }

      #checkout-button:hover, #back-button:hover {
        background-color: #e03e00;
      }

      .total-info {
        margin-top: 20px;
        font-size: 1.2em;
      }

      footer {
        background-color: #333;
        color: white;
        text-align: center;
        padding: 10px;
        position: fixed;
        bottom: 0;
        width: 100%;
      }
      
      .empty-cart-message {
        text-align: center;
        margin: 50px 0;
      }
      
      .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        visibility: hidden;
      }
      
      .loading-spinner {
        border: 5px solid #f3f3f3;
        border-top: 5px solid #ff4500;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
      }
      
      @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
      }
    </style>
  </head>
  <body>
    <div class="container">
      <header>
        <h1>Keranjang Makanan</h1>
      </header>

      <main class="keranjang-container">
        <ul id="keranjang-list"></ul>
      </main>

      <div class="total-info" id="total-info">
        <p>Total Makanan: <span id="total-quantity">0</span></p>
        <p>Total Harga: Rp <span id="total-price">0</span></p>
      </div>

      <div class="keranjang-footer">
        <button id="back-button" onclick="kembaliKeMenu()">Kembali ke Menu</button>
        <button id="checkout-button" onclick="checkout()">Checkout</button>
      </div>
    </div>

    <div class="loading-overlay" id="loading-overlay">
      <div class="loading-spinner"></div>
    </div>

    <footer>
      <p>
        &copy; 2024 Keranjang Makanan |
        <a href="index.php">Kembali ke Beranda</a>
      </p>
    </footer>

    <script>
      document.addEventListener("DOMContentLoaded", () => {
        const keranjangList = document.getElementById("keranjang-list");
        const totalQuantityElement = document.getElementById("total-quantity");
        const totalPriceElement = document.getElementById("total-price");
        const checkoutButton = document.getElementById("checkout-button");
        const loadingOverlay = document.getElementById("loading-overlay");
        let keranjangItems = JSON.parse(localStorage.getItem("keranjang")) || [];

        // Cek jika keranjang kosong saat halaman dimuat
        if (keranjangItems.length === 0) {
          redirectToMenuIfEmpty();
        }

        function updateKeranjang() {
          keranjangList.innerHTML = "";
          let totalQuantity = 0;
          let totalPrice = 0;

          if (keranjangItems.length === 0) {
            keranjangList.innerHTML = `
              <div class="empty-cart-message">
                <h2>Keranjang Anda kosong</h2>
                <p>Silakan kembali ke menu untuk menambahkan makanan</p>
              </div>
            `;
            checkoutButton.disabled = true;
            checkoutButton.style.opacity = 0.5;
            
            // Set timeout untuk memberikan waktu membaca pesan
            setTimeout(redirectToMenuIfEmpty, 2000);
          } else {
            checkoutButton.disabled = false;
            checkoutButton.style.opacity = 1;
            
            keranjangItems.forEach((item, index) => {
              const li = document.createElement("li");
              li.innerHTML = `
                <span>${item.name} (Rp ${new Intl.NumberFormat('id-ID').format(item.price)})</span>
                <div class="quantity-controls">
                    <button onclick="kurangiJumlah(${index})">-</button>
                    <span>${item.quantity}</span>
                    <button onclick="tambahJumlah(${index})">+</button>
                    <button class="remove-btn" onclick="hapusItem(${index})">Hapus</button>
                </div>
              `;
              keranjangList.appendChild(li);

              totalQuantity += item.quantity;
              totalPrice += item.price * item.quantity;
            });
          }

          totalQuantityElement.textContent = totalQuantity;
          totalPriceElement.textContent = new Intl.NumberFormat('id-ID').format(totalPrice);
          
          // Trigger event untuk update panel di halaman lain
          let storageEvent = new StorageEvent('storage', {
            key: 'keranjang',
            newValue: localStorage.getItem('keranjang'),
            url: window.location.href
          });
          window.dispatchEvent(storageEvent);
        }

        function redirectToMenuIfEmpty() {
          if (keranjangItems.length === 0) {
            window.location.href = "index.php"; // Atau halaman menu Anda
          }
        }

        window.kembaliKeMenu = function() {
          window.location.href = "index.php"; // Atau halaman menu Anda
        };

        window.kurangiJumlah = function(index) {
          if (keranjangItems[index].quantity > 1) {
            keranjangItems[index].quantity--;
          } else {
            keranjangItems.splice(index, 1);
          }
          localStorage.setItem("keranjang", JSON.stringify(keranjangItems));
          updateKeranjang();
        };

        window.tambahJumlah = function(index) {
          keranjangItems[index].quantity++;
          localStorage.setItem("keranjang", JSON.stringify(keranjangItems));
          updateKeranjang();
        };

        window.hapusItem = function(index) {
          keranjangItems.splice(index, 1);
          localStorage.setItem("keranjang", JSON.stringify(keranjangItems));
          updateKeranjang();
        };

        // Fungsi untuk mengirim data keranjang ke server
        async function kirimDataKeranjang() {
          try {
            showLoading();
            
            const response = await fetch('proses_keranjang.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
              },
              body: localStorage.getItem('keranjang')
            });
            
            if (!response.ok) {
              throw new Error('Gagal mengirim data ke server');
            }
            
            const result = await response.json();
            return result;
          } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memproses pesanan: ' + error.message);
            hideLoading();
            return { status: 'error' };
          }
        }

        function showLoading() {
          loadingOverlay.style.visibility = 'visible';
        }

        function hideLoading() {
          loadingOverlay.style.visibility = 'hidden';
        }

        window.checkout = async function() {
          if (keranjangItems.length === 0) {
            alert("Keranjang Anda kosong!");
            return;
          }
          
          // Kirim data keranjang ke server terlebih dahulu
          const result = await kirimDataKeranjang();
          
          if (result.status === 'success') {
            // Simpan untuk referensi di localStorage
            localStorage.setItem("pesanan", JSON.stringify(keranjangItems));
            
            // Kosongkan keranjang
            keranjangItems = [];
            localStorage.setItem("keranjang", JSON.stringify(keranjangItems));
            
            // Redirect ke halaman pembayaran
            window.location.href = "lamanpembayaran.php";
          } else {
            hideLoading();
            alert("Gagal memproses pesanan. Silakan coba lagi.");
          }
        };

        updateKeranjang();
      });
    </script>
  </body>
</html>