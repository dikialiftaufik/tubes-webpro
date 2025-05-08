<?php
session_start();

// Redirect jika tidak ada status pembayaran berhasil
if (!isset($_SESSION['status_pembayaran']) || $_SESSION['status_pembayaran'] !== 'berhasil') {
    header("Location: index.php");
    exit();
}

// Ambil data pembayaran
$dataPembayaran = $_SESSION['data_pembayaran'] ?? [];
$kodePembayaran = $_SESSION['kode_pembayaran'] ?? '';
$waktuPembayaran = $_SESSION['waktu_pembayaran_berhasil'] ?? time();

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

// Hapus data pembayaran setelah selesai
function bersihkanSession() {
    // Simpan dulu kode pembayaran untuk referensi
    $kodePembayaran = $_SESSION['kode_pembayaran'] ?? '';
    
    // Hapus data session yang terkait pembayaran
    unset($_SESSION['pesanan']);
    unset($_SESSION['data_pembayaran']);
    unset($_SESSION['totalQuantity']);
    unset($_SESSION['totalPrice']);
    unset($_SESSION['status_pembayaran']);
    unset($_SESSION['waktu_pembayaran_berhasil']);
    
    // Simpan kembali kode pembayaran untuk referensi user
    $_SESSION['last_order_code'] = $kodePembayaran;
}

// Auto bersihkan session setelah halaman ini
bersihkanSession();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Terima Kasih</title>
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
            text-align: center;
        }
        
        h1 {
            color: #4CAF50;
            margin-bottom: 20px;
        }
        
        .success-icon {
            font-size: 72px;
            color: #4CAF50;
            margin-bottom: 20px;
        }
        
        .payment-details {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
            text-align: left;
        }
        
        .order-code {
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0;
            padding: 10px;
            background-color: #e9f7ef;
            border: 1px dashed #4CAF50;
            border-radius: 4px;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
            font-weight: bold;
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
            width: 40%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-icon">✓</div>
        
        <h1>Pembayaran Berhasil!</h1>
        
        <p>Terima kasih telah melakukan pesanan. Pesanan Anda sedang diproses.</p>
        
        <div class="order-code">
            Kode Pesanan: <?php echo $kodePembayaran; ?>
        </div>
        
        <div class="payment-details">
            <h2>Detail Pembayaran</h2>
            <table>
                <?php if(!empty($dataPembayaran)): ?>
                <tr>
                    <th>Nama</th>
                    <td><?php echo htmlspecialchars($dataPembayaran['nama'] ?? '-'); ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo htmlspecialchars($dataPembayaran['email'] ?? '-'); ?></td>
                </tr>
                <tr>
                    <th>Total Makanan</th>
                    <td><?php echo $dataPembayaran['totalQuantity'] ?? 0; ?></td>
                </tr>
                <tr>
                    <th>Total Harga</th>
                    <td>Rp <?php echo number_format($dataPembayaran['totalPrice'] ?? 0, 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <th>Metode Pembayaran</th>
                    <td><?php echo htmlspecialchars($dataPembayaran['metode'] ?? '-'); ?></td>
                </tr>
                <tr>
                    <th>Waktu Pembayaran</th>
                    <td><?php echo formatTanggalIndonesia($waktuPembayaran); ?></td>
                </tr>
                <?php else: ?>
                <tr>
                    <td colspan="2">Tidak ada detail pembayaran tersedia.</td>
                </tr>
                <?php endif; ?>
            </table>
        </div>
        
        <p>Bukti pembayaran telah dikirim ke email Anda. Jika membutuhkan bantuan, silakan hubungi kami.</p>
        
        <a href="index.php" class="btn">Kembali ke Beranda</a>
    </div>
</body>
</html>