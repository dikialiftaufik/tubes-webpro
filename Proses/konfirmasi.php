<?php
session_start();
include '../configdb.php';


// Redirect jika tidak ada data pembayaran
if (!isset($_SESSION['data_pembayaran']) || empty($_SESSION['data_pembayaran'])) {
    header("Location: index.php");
    exit();
}

// Generate kode pembayaran
if (!isset($_SESSION['kode_pembayaran'])) {
    $_SESSION['kode_pembayaran'] = 'QRIS-' . strtoupper(substr(md5(time()), 0, 8));
}

// Fungsi untuk format tanggal Indonesia
function formatTanggalIndonesia($timestamp) {
    $bulan = array(
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );
    
    $tanggal = date('j', $timestamp);
    $bulan_index = date('n', $timestamp);
    $tahun = date('Y', $timestamp);
    $jam = date('H:i', $timestamp);
    
    return $tanggal . ' ' . $bulan[$bulan_index] . ' ' . $tahun . ' ' . $jam . ' WIB';
}

// Waktu realtime saat ini
$waktu_pembayaran = time();
$batas_waktu = $waktu_pembayaran + (24 * 60 * 60); // 24 jam

// Simpan data pesanan ke database
function simpanPesananKeDatabase($conn, $dataPembayaran) {
    // Ambil data dari session
    $pesanan = $_SESSION['pesanan'];
    $dataPelanggan = $dataPembayaran;
    
    // Simpan data pesanan untuk setiap item
    foreach ($pesanan as $item) {
        $nama = $dataPelanggan['nama'];
        $email = $dataPelanggan['email'];
        $telepon = $dataPelanggan['telepon'];
        $nama_makanan = $item['name'];
        $jumlah = $item['quantity'];
        $harga = $item['price'] * $item['quantity'];
        $order_id = $_SESSION['kode_pembayaran'];
        
        // Siapkan query untuk menyimpan ke database
        $sql = "INSERT INTO cart (nama, email, nomor_telp, nama_makanan, jumlah, harga, order_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        // Gunakan prepared statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssiis", $nama, $email, $telepon, $nama_makanan, $jumlah, $harga, $order_id);
        
        // Eksekusi query
        if (!$stmt->execute()) {
            return false;
        }
        
        $stmt->close();
    }
    
    return true;
}

// Simulasi pembayaran berhasil
function simulasiPembayaran($conn) {
    global $waktu_pembayaran;
    
    // Disimulasikan pembayaran berhasil
    $_SESSION['status_pembayaran'] = 'berhasil';
    $_SESSION['waktu_pembayaran_berhasil'] = $waktu_pembayaran;
    
    // Simpan data pesanan ke database
    $dataPembayaran = $_SESSION['data_pembayaran'];
    $berhasil = simpanPesananKeDatabase($conn, $dataPembayaran);
    
    return $berhasil;
}

// Jika tombol simulasi ditekan
if (isset($_POST['simulasi_pembayaran'])) {
    $berhasil = simulasiPembayaran($conn);
    
    if ($berhasil) {
        // Redirect ke halaman terima kasih
        header("Location: terimakasih.php");
        exit();
    } else {
        $error_message = "Terjadi kesalahan saat menyimpan data ke database.";
    }
}

// Ambil data dari session
$dataPembayaran = $_SESSION['data_pembayaran'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Konfirmasi Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            line-height: 1.6;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        h1 {
            text-align: center;
            color: #333;
        }
        
        .qr-code {
            text-align: center;
            margin: 20px 0;
        }
        
        .qr-code img {
            max-width: 200px;
            height: auto;
        }
        
        .payment-details {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        .payment-code {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin: 10px 0;
            padding: 10px;
            background-color: #ffe9e9;
            border: 1px dashed #ff4500;
            border-radius: 4px;
        }
        
        .timer {
            text-align: center;
            margin: 15px 0;
            font-size: 18px;
        }
        
        .time-remaining {
            font-weight: bold;
            color: #ff4500;
        }
        
        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            margin-top: 10px;
            text-decoration: none;
        }
        
        .btn:hover {
            background-color: #45a049;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        table th, table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        table th {
            background-color: #f2f2f2;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Konfirmasi Pembayaran</h1>
        
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <div class="payment-details">
            <h2>Detail Pesanan</h2>
            <table>
                <tr>
                    <th>Nama</th>
                    <td><?php echo htmlspecialchars($dataPembayaran['nama']); ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo htmlspecialchars($dataPembayaran['email']); ?></td>
                </tr>
                <tr>
                    <th>Telepon</th>
                    <td><?php echo htmlspecialchars($dataPembayaran['telepon']); ?></td>
                </tr>
                <tr>
                    <th>Total Makanan</th>
                    <td><?php echo $dataPembayaran['totalQuantity']; ?></td>
                </tr>
                <tr>
                    <th>Total Harga</th>
                    <td>Rp <?php echo number_format($dataPembayaran['totalPrice'], 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <th>Metode Pembayaran</th>
                    <td><?php echo htmlspecialchars($dataPembayaran['metode']); ?></td>
                </tr>
                <tr>
                    <th>Waktu Pemesanan</th>
                    <td><?php echo formatTanggalIndonesia($waktu_pembayaran); ?></td>
                </tr>
                <tr>
                    <th>Batas Waktu Pembayaran</th>
                    <td><?php echo formatTanggalIndonesia($batas_waktu); ?></td>
                </tr>
                <tr>
                    <th>Kode Pembayaran</th>
                    <td><?php echo $_SESSION['kode_pembayaran']; ?></td>
                </tr>
            </table>
        </div>
        
        <div class="payment-code">
            Kode Pembayaran: <?php echo $_SESSION['kode_pembayaran']; ?>
        </div>
        
        <div class="qr-code">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?php echo urlencode($_SESSION['kode_pembayaran']); ?>" alt="QR Code Pembayaran">
        </div>
        
        <div class="timer">
            <p>Sisa waktu pembayaran: <span class="time-remaining" id="timer">24:00:00</span></p>
        </div>
        
        <form method="post" action="">
            <button type="submit" name="simulasi_pembayaran" class="btn">Simulasi Pembayaran Berhasil</button>
        </form>
        
        <a href="index.php" class="btn" style="background-color: #f44336; margin-top: 10px;">Batalkan Pesanan</a>
    </div>
    
    <script>
        // Timer pembayaran
        function startTimer(duration, display) {
            var timer = duration, hours, minutes, seconds;
            setInterval(function () {
                hours = parseInt(timer / 3600, 10);
                minutes = parseInt((timer % 3600) / 60, 10);
                seconds = parseInt(timer % 60, 10);
                
                hours = hours < 10 ? "0" + hours : hours;
                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;
                
                display.textContent = hours + ":" + minutes + ":" + seconds;
                
                if (--timer < 0) {
                    timer = 0;
                    display.textContent = "Waktu Habis";
                    display.style.color = "#ff0000";
                }
            }, 1000);
        }
        
        window.onload = function () {
            var twentyFourHours = 24 * 60 * 60,
                display = document.querySelector('#timer');
            startTimer(twentyFourHours, display);
        };
    </script>
</body>
</html>