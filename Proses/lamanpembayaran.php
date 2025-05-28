<?php
session_start();

// Cek apakah ada data pesanan dari localStorage yang dikirim via POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['pesanan_data'])) {
    $_SESSION['pesanan'] = json_decode($_POST['pesanan_data'], true);
}

// Jika tidak ada pesanan di session, coba ambil dari localStorage via JavaScript
if (!isset($_SESSION['pesanan']) || empty($_SESSION['pesanan'])) {
    // Jangan langsung redirect, beri kesempatan JavaScript untuk mengirim data
    if (!isset($_GET['from_js'])) {
        // Tampilkan halaman loading untuk menunggu data dari JavaScript
    }
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

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['nama'])) {
    $formData = [
        'nama' => trim($_POST['nama'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'telepon' => trim($_POST['telepon'] ?? ''),
        'csrf_token' => $_POST['csrf_token'] ?? ''
    ];

    $errors = validate_input($formData);

    if (empty($errors)) {
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
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pembayaran</title>
    <!-- Perbaikan path CSS - sesuaikan dengan struktur folder Anda -->
    <link rel="stylesheet" href="../css/lamanpembayaran.css" />
    <!-- Alternatif path CSS jika tidak ada -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            color: white;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #222;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        }

        .form-pembayaran {
            max-width: 600px;
            margin: 0 auto;
            background-color: #333;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #fff;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #555;
            border-radius: 5px;
            background-color: #444;
            color: white;
            font-size: 16px;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="tel"]:focus {
            outline: none;
            border-color: #ff4500;
            background-color: #555;
        }

        button {
            width: 100%;
            padding: 15px;
            background-color: #ff4500;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #e03e00;
        }

        .error-message {
            color: #dc3545;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            text-align: center;
        }

        h2 {
            color: #ff4500;
            margin-bottom: 20px;
            text-align: center;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            padding: 10px;
            background-color: #444;
            margin-bottom: 5px;
            border-radius: 5px;
            border-left: 4px solid #ff4500;
        }

        .loading-message {
            text-align: center;
            color: #ff4500;
            font-size: 18px;
            margin: 50px 0;
        }

        .no-data-message {
            text-align: center;
            color: #ccc;
            font-size: 16px;
            margin: 30px 0;
        }
    </style>
</head>
<body>
    <!-- Loading message -->
    <div id="loading-message" class="loading-message">
        Memuat data pesanan...
    </div>

    <!-- Main content -->
    <div id="main-content" style="display: none;">
        <div class="form-pembayaran">
            <h2>Form Pembayaran</h2>
            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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

                <button type="submit">Lanjutkan Pembayaran</button>
            </form>
        </div>

        <div class="container">
            <h2>Rincian Pesanan</h2>
            <ul id="pesanan-list">
                <?php
                if (isset($_SESSION['pesanan']) && !empty($_SESSION['pesanan'])) {
                    $totalQuantity = 0;
                    $totalPrice = 0;
                    foreach ($_SESSION['pesanan'] as $item) {
                        $itemTotal = $item['price'] * $item['quantity'];
                        echo "<li>{$item['name']} ({$item['quantity']}) - Rp " . number_format($itemTotal, 0, ',', '.') . "</li>";
                        $totalQuantity += $item['quantity'];
                        $totalPrice += $itemTotal;
                    }
                    $_SESSION['totalQuantity'] = $totalQuantity;
                    $_SESSION['totalPrice'] = $totalPrice;
                } else {
                    echo "<li class='no-data-message'>Pesanan akan dimuat...</li>";
                    $_SESSION['totalQuantity'] = 0;
                    $_SESSION['totalPrice'] = 0;
                }
                ?>
            </ul>

            <div style="margin-top: 20px; padding: 15px; background-color: #444; border-radius: 5px;">
                <p><strong>Total Makanan: <span id="total-quantity"><?php echo $_SESSION['totalQuantity'] ?? 0; ?></span></strong></p>
                <p><strong>Total Harga: Rp <span id="total-price"><?php echo number_format($_SESSION['totalPrice'] ?? 0, 0, ',', '.'); ?></span></strong></p>
            </div>
        </div>
    </div>

    <!-- Hidden form untuk mengirim data pesanan -->
    <form id="pesanan-form" method="post" style="display: none;">
        <input type="hidden" name="pesanan_data" id="pesanan_data">
    </form>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const loadingMessage = document.getElementById('loading-message');
        const mainContent = document.getElementById('main-content');
        const pesananList = document.getElementById('pesanan-list');
        const totalQuantitySpan = document.getElementById('total-quantity');
        const totalPriceSpan = document.getElementById('total-price');
        
        // Cek apakah ada data pesanan di localStorage
        const pesananData = localStorage.getItem('pesanan');
        
        if (pesananData) {
            try {
                const pesanan = JSON.parse(pesananData);
                
                if (pesanan && pesanan.length > 0) {
                    // Kirim data ke session PHP
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
        
        function showNoDataMessage() {
            loadingMessage.style.display = 'none';
            mainContent.style.display = 'block';
            
            pesananList.innerHTML = '<li class="no-data-message">Tidak ada data pesanan. <a href="makanan.php" style="color: #ff4500;">Kembali ke menu</a></li>';
            totalQuantitySpan.textContent = '0';
            totalPriceSpan.textContent = '0';
        }
        
        // Jika sudah ada data di session, tampilkan langsung
        <?php if (isset($_SESSION['pesanan']) && !empty($_SESSION['pesanan'])): ?>
        loadingMessage.style.display = 'none';
        mainContent.style.display = 'block';
        <?php endif; ?>
    });
    </script>
</body>
</html>