<?php
session_start();

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bolooo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data laporan
$sql = "SELECT * FROM laporan ORDER BY tanggal_transaksi DESC";
$result = $conn->query($sql);

require_once 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

ob_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pemesanan Makanan</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { text-align: center; color: #4a6fa5; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4a6fa5; color: white; }
        .total-row { background-color: #e9f7fe; font-weight: bold; }
        .logo { text-align: center; margin-bottom: 20px; }
        .date { text-align: right; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="logo">
        <h1>Laporan Pemesanan Makanan</h1>
        <p>Sistem Manajemen Restoran</p>
    </div>
    
    <div class="date">
        <p>Tanggal Cetak: <?php echo date('d F Y'); ?></p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Transaksi</th>
                <th>Nama Pelanggan</th>
                <th>Tanggal</th>
                <th>Pesanan</th>
                <th>Total Harga</th>
                <th>Metode Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php $no = 1; $total = 0; ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($row['id_transaksi']); ?></td>
                        <td><?php echo htmlspecialchars($row['nama_pelanggan']); ?></td>
                        <td><?php echo date('d M Y', strtotime($row['tanggal_transaksi'])); ?></td>
                        <td><?php echo htmlspecialchars($row['pesanan']); ?></td>
                        <td>Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars($row['metode_pembayaran']); ?></td>
                    </tr>
                    <?php $total += $row['total_harga']; ?>
                <?php endwhile; ?>
                <tr class="total-row">
                    <td colspan="5" style="text-align: right;">Total Keseluruhan:</td>
                    <td colspan="2">Rp <?php echo number_format($total, 0, ',', '.'); ?></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">Belum ada data laporan</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

<?php
$html = ob_get_clean();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("laporan_pemesanan_makanan.pdf", array("Attachment" => true));

$conn->close();
?>