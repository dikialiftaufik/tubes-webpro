<?php
session_start();
require_once 'configdb.php';

// Cek apakah data pembayaran tersedia
if (!isset($_SESSION['data_pembayaran'])) {
    header("Location: pembayaran.php");
    exit();
}

$data = $_SESSION['data_pembayaran'];

// Siapkan data
session_start();
include 'configdb.php';

$data = $_SESSION['data_pembayaran'];
$nama = $data['nama'];
$email = $data['email'];
$telepon = $data['telepon'];
$totalQuantity = $data['totalQuantity'];
$totalPrice = $data['totalPrice'];

// Proses penyimpanan atau insert ke database...


// Query untuk menyimpan ke tabel cart
$sql = "INSERT INTO cart (nama, email, nomor_telp, nama_makanan, jumlah, harga, order_id)
        VALUES ('$nama', '$email', '$nomor_telp', '$nama_makanan', $jumlah, $harga, '$order_id')";

if ($conn->query($sql) === TRUE) {
    echo "Pembayaran berhasil! Data telah dimasukkan ke dalam tabel cart.";
    // Redirect jika perlu: header("Location: sukses.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
