<?php
session_start();

// Cek apakah ada data pesanan dari localStorage yang dikirim via POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['pesanan_data'])) {
    $_SESSION['pesanan'] = json_decode($_POST['pesanan_data'], true);
    $_SESSION['data_loaded'] = true;
}

// Buat CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Fungsi tampil error
function display_error($message) {
    echo "<div class='error-message'>$message</div>";
}

// Validasi input
function validate_input($data) {
    $errors = [];

    if (empty($data['nama']) || !preg_match("/^[a-zA-Z ]+$/", $data['nama'])) {
        $errors[] = "Nama harus diisi dan hanya boleh huruf dan spasi.";
    }

    if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email harus diisi dan valid.";
    }

    if (empty($data['telepon']) || !preg_match("/^[0-9]{10,15}$/", $data['telepon'])) {
        $errors[] = "Nomor telepon harus 10–15 digit angka.";
    }

    if (!isset($_SESSION['pesanan']) || empty($_SESSION['pesanan'])) {
        $errors[] = "Pesanan tidak ditemukan.";
    }

    if (empty($data['csrf_token']) || $data['csrf_token'] !== $_SESSION['csrf_token']) {
        $errors[] = "Token tidak valid.";
    }

    return $errors;
}

// Jika form disubmit untuk pembayaran (bukan untuk loading data)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['nama']) && !isset($_POST['pesanan_data'])) {
    $formData = [
        'nama' => trim($_POST['nama'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'telepon' => trim($_POST['telepon'] ?? ''),
        'csrf_token' => $_POST['csrf_token'] ?? ''
    ];

    $errors = validate_input($formData);

    if (empty($errors)) {
        // Hitung total jika belum ada
        if (!isset($_SESSION['totalQuantity']) || !isset($_SESSION['totalPrice'])) {
            $totalQuantity = 0;
            $totalPrice = 0;
            if (isset($_SESSION['pesanan'])) {
                foreach ($_SESSION['pesanan'] as $item) {
                    $totalQuantity += $item['quantity'];
                    $totalPrice += $item['price'] * $item['quantity'];
                }
                $_SESSION['totalQuantity'] = $totalQuantity;
                $_SESSION['totalPrice'] = $totalPrice;
            }
        }

        $_SESSION['data_pembayaran'] = [
            'nama' => $formData['nama'],
            'email' => $formData['email'],
            'telepon' => $formData['telepon'],
            'totalQuantity' => $_SESSION['totalQuantity'],
            'totalPrice' => $_SESSION['totalPrice'],
            'metode' => 'QRIS'
        ];

        header("Location: konfirmasi.php");
        exit();
    }
}

// Hitung total pesanan jika ada
$totalQuantity = 0;
$totalPrice = 0;
if (isset($_SESSION['pesanan']) && !empty($_SESSION['pesanan'])) {
    foreach ($_SESSION['pesanan'] as $item) {
        $totalQuantity += $item['quantity'];
        $totalPrice += $item['price'] * $item['quantity'];
    }
    $_SESSION['totalQuantity'] = $totalQuantity;
    $_SESSION['totalPrice'] = $totalPrice;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pembayaran</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0c0c0c 0%, #1a1a1a 100%);
            color: white;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }

        .main-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px 0;
        }

        .payment-container {
            background: linear-gradient(135deg, #2a2a2a 0%, #1e1e1e 100%);
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            border: 1px solid #333;
        }

        .section-title {
            color: #ff4500;
            margin-bottom: 25px;
            text-align: center;
            font-size: 24px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .section-divider {
            border: none;
            height: 2px;
            background: linear-gradient(90deg, transparent, #ff4500, transparent);
            margin: 30px 0;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #fff;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"] {
            width: 100%;
            padding: 15px;
            border: 2px solid #444;
            border-radius: 10px;
            background-color: #333;
            color: white;
            font-size: 16px;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="tel"]:focus {
            outline: none;
            border-color: #ff4500;
            background-color: #3a3a3a;
            box-shadow: 0 0 15px rgba(255, 69, 0, 0.3);
        }

        .submit-btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #ff4500 0%, #e03e00 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 20px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 69, 0, 0.4);
        }

        .submit-btn:disabled {
            background: #666;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .error-message {
            color: #ff6b6b;
            background: linear-gradient(135deg, #2d1b1b 0%, #1a1111 100%);
            border: 1px solid #ff6b6b;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            text-align: center;
            font-weight: 500;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background-color: #333;
            margin-bottom: 10px;
            border-radius: 10px;
            border-left: 4px solid #ff4500;
            transition: all 0.3s ease;
        }

        .order-item:hover {
            background-color: #3a3a3a;
            transform: translateX(5px);
        }

        .item-info {
            flex: 1;
        }

        .item-name {
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .item-quantity {
            color: #ccc;
            font-size: 14px;
        }

        .item-price {
            font-weight: bold;
            color: #ff4500;
            font-size: 16px;
        }

        .total-section {
            margin-top: 25px;
            padding: 20px;
            background: linear-gradient(135deg, #333 0%, #2a2a2a 100%);
            border-radius: 10px;
            border: 2px solid #ff4500;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .total-row.grand-total {
            font-size: 20px;
            font-weight: bold;
            color: #ff4500;
            border-top: 2px solid #444;
            padding-top: 15px;
            margin-top: 15px;
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            backdrop-filter: blur(5px);
        }

        .loading-content {
            text-align: center;
            color: #ff4500;
            font-size: 18px;
        }

        .spinner {
            border: 4px solid #333;
            border-top: 4px solid #ff4500;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .no-data-message {
            text-align: center;
            color: #ccc;
            font-size: 16px;
            margin: 30px 0;
            padding: 30px;
            background-color: #333;
            border-radius: 10px;
        }

        .no-data-message a {
            color: #ff4500;
            text-decoration: none;
            font-weight: bold;
        }

        .no-data-message a:hover {
            text-decoration: underline;
        }

        .order-summary-section {
            margin-bottom: 30px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-container {
                padding: 10px;
            }
            
            .payment-container {
                padding: 25px;
            }
            
            body {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Loading overlay -->
    <div id="loading-overlay" class="loading-overlay" style="display: none;">
        <div class="loading-content">
            <div class="spinner"></div>
            <p>Memuat data pesanan...</p>
        </div>
    </div>

    <!-- Main content -->
    <div id="main-content">
        <div class="main-container">
            <div class="payment-container">
                <h1 class="section-title">Pembayaran</h1>
                
                <!-- Rincian Pesanan Section -->
                <div class="order-summary-section">
                    <h3 style="color: #ff4500; margin-bottom: 20px; font-size: 18px;">Rincian Pesanan</h3>
                    <div id="order-items">
                        <?php if (isset($_SESSION['pesanan']) && !empty($_SESSION['pesanan'])): ?>
                            <?php foreach ($_SESSION['pesanan'] as $item): ?>
                                <div class="order-item">
                                    <div class="item-info">
                                        <div class="item-name"><?php echo htmlspecialchars($item['name']); ?></div>
                                        <div class="item-quantity">Jumlah: <?php echo $item['quantity']; ?></div>
                                    </div>
                                    <div class="item-price">
                                        Rp <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="no-data-message" id="no-data-msg">
                                Tidak ada data pesanan.<br>
                                <a href="makanan.php">Kembali ke menu</a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="total-section">
                        <div class="total-row">
                            <span>Total Item:</span>
                            <span id="total-quantity"><?php echo $totalQuantity; ?></span>
                        </div>
                        <div class="total-row grand-total">
                            <span>Total Harga:</span>
                            <span>Rp <span id="total-price"><?php echo number_format($totalPrice, 0, ',', '.'); ?></span></span>
                        </div>
                    </div>
                </div>

                <hr class="section-divider">

                <!-- Form Pembayaran Section -->
                <div class="form-section">
                    <h3 style="color: #ff4500; margin-bottom: 20px; font-size: 18px;">Data Pembeli</h3>
                    
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="payment-form">
                        <?php
                        if (!empty($errors)) {
                            foreach ($errors as $error) {
                                display_error($error);
                            }
                        }
                        ?>
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                        <div class="form-group">
                            <label for="nama">Nama Pelanggan</label>
                            <input type="text" name="nama" id="nama" required pattern="[a-zA-Z ]+"
                                   value="<?php echo htmlspecialchars($_POST['nama'] ?? ''); ?>" 
                                   placeholder="Masukkan nama lengkap" />
                        </div>

                        <div class="form-group">
                            <label for="email">Email Pelanggan</label>
                            <input type="email" name="email" id="email" required
                                   value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" 
                                   placeholder="contoh@email.com" />
                        </div>

                        <div class="form-group">
                            <label for="telepon">Nomor Telepon</label>
                            <input type="tel" name="telepon" id="telepon" required pattern="[0-9]{10,15}"
                                   value="<?php echo htmlspecialchars($_POST['telepon'] ?? ''); ?>" 
                                   placeholder="08xxxxxxxxxx" />
                        </div>

                        <div class="form-group">
                            <label for="metode">Metode Pembayaran</label>
                            <input type="text" id="metode" name="metode" value="QRIS" readonly 
                                   style="background-color: #555; cursor: not-allowed;" />
                        </div>

                        <button type="submit" class="submit-btn" id="submit-btn">Lanjutkan Pembayaran</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden form untuk mengirim data pesanan -->
    <form id="pesanan-form" method="post" style="display: none;">
        <input type="hidden" name="pesanan_data" id="pesanan_data">
    </form>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const hasSessionData = <?php echo isset($_SESSION['pesanan']) && !empty($_SESSION['pesanan']) ? 'true' : 'false'; ?>;
        const dataLoaded = <?php echo isset($_SESSION['data_loaded']) ? 'true' : 'false'; ?>;
        
        // Jika belum ada data di session dan belum pernah load data
        if (!hasSessionData && !dataLoaded) {
            loadDataFromLocalStorage();
        } else {
            // Data sudah ada, tampilkan form
            enableForm();
        }
        
        function loadDataFromLocalStorage() {
            const pesananData = localStorage.getItem('keranjang');
            
            if (pesananData) {
                try {
                    const pesanan = JSON.parse(pesananData);
                    
                    if (pesanan && pesanan.length > 0) {
                        // Tampilkan loading
                        showLoading();
                        
                        // Kirim data ke server
                        document.getElementById('pesanan_data').value = pesananData;
                        document.getElementById('pesanan-form').submit();
                    } else {
                        showNoDataMessage();
                    }
                } catch (e) {
                    console.error('Error parsing pesanan data:', e);
                    showNoDataMessage();
                }
            } else {
                showNoDataMessage();
            }
        }
        
        function showLoading() {
            document.getElementById('loading-overlay').style.display = 'flex';
        }
        
        function hideLoading() {
            document.getElementById('loading-overlay').style.display = 'none';
        }
        
        function enableForm() {
            hideLoading();
            document.getElementById('submit-btn').disabled = false;
        }
        
        function showNoDataMessage() {
            hideLoading();
            document.getElementById('no-data-msg').style.display = 'block';
            document.getElementById('submit-btn').disabled = true;
        }
        
        // Disable form submission jika tidak ada data
        document.getElementById('payment-form').addEventListener('submit', function(e) {
            if (!hasSessionData && !<?php echo isset($_SESSION['pesanan']) && !empty($_SESSION['pesanan']) ? 'true' : 'false'; ?>) {
                e.preventDefault();
                alert('Tidak ada data pesanan. Silakan kembali ke menu untuk memilih makanan.');
                return false;
            }
        });
    });
    </script>
</body>
</html>