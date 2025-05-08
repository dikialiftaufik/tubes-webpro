<?php

session_start();

// Redirect jika tidak ada pesanan dalam session
if (!isset($_SESSION['pesanan']) || empty($_SESSION['pesanan'])) {
    header("Location: index.php");
    exit();
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
if ($_SERVER["REQUEST_METHOD"] === "POST") {
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
    <title>Pembayaran</title>
    <link rel="stylesheet" href="css/css/lamanpembayaran.css" />
    <style>
        .error-message {
            color: #dc3545;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            text-align: center;
        }
    </style>
</head>
<body>
    <main>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form-pembayaran">
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
                       value="<?php echo htmlspecialchars($_POST['nama'] ?? ''); ?>" />
            </div>

            <div class="form-group">
                <label for="email">Email Pelanggan</label>
                <input type="email" name="email" id="email" required
                       value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" />
            </div>

            <div class="form-group">
                <label for="telepon">Nomor Telepon</label>
                <input type="tel" name="telepon" id="telepon" required pattern="[0-9]{10,15}"
                       value="<?php echo htmlspecialchars($_POST['telepon'] ?? ''); ?>" />
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
                        echo "<li>Pesanan tidak ditemukan.</li>";
                        $_SESSION['totalQuantity'] = 0;
                        $_SESSION['totalPrice'] = 0;
                    }
                    ?>
                </ul>

                <p>Total Makanan: <strong><?php echo $_SESSION['totalQuantity'] ?? 0; ?></strong></p>
                <p>Total Harga: <strong>Rp <?php echo number_format($_SESSION['totalPrice'] ?? 0, 0, ',', '.'); ?></strong></p>
            </div>

            <div class="form-group">
                <label for="metode">Metode Pembayaran</label>
                <input type="text" id="metode" name="metode" value="QRIS" readonly />
            </div>

            <button type="submit">Lanjutkan Pembayaran</button>
        </form>
    </main>
    
    <script>
    // Cek localStorage apakah data pesanan sudah tersedia
    document.addEventListener('DOMContentLoaded', function() {
        // Cek apakah ini adalah refresh halaman
        const isPageRefresh = performance.navigation.type === 1;
        
        // Jika ini adalah refresh halaman, tidak perlu melakukan apapun
        if (isPageRefresh) {
            return;
        }
        
        // Cek apakah ada data pesanan di localStorage
        const pesananData = localStorage.getItem('pesanan');
        if (!pesananData) {
            // Jika tidak ada, mungkin user mencoba akses langsung
            // Server-side redirect sudah menangani ini, tapi tambahkan pengecekan klien juga
            console.log('Tidak ada data pesanan, mengalihkan ke halaman utama...');
        }
    });
    </script>
</body>
</html>