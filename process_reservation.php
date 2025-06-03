<?php
session_start();
require_once 'configdb.php'; // Sesuaikan path sesuai struktur folder

// Cek apakah user sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login-register.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_reservation'])) {
    // Ambil dan sanitasi data dari form
    $nama = mysqli_real_escape_string($conn, $_POST['table_name']);
    $jumlah_orang = (int)$_POST['table_capacity'];
    $tanggal = mysqli_real_escape_string($conn, $_POST['order_date']);
    $jam_mulai = mysqli_real_escape_string($conn, $_POST['start_time']);
    $jam_selesai = mysqli_real_escape_string($conn, $_POST['jam_selesai']);
    $pesanan_array = $_POST['order'];
    $pesanan_escaped_array = array_map(function($item) use ($conn) {
        return mysqli_real_escape_string($conn, $item);
    }, $pesanan_array);
    $pesanan = implode(", ", $pesanan_escaped_array);

    $status = 'Pending'; // Status default

    // Query untuk insert data reservasi
    $stmt = $conn->prepare("INSERT INTO reservation (nama, jumlah_orang, tanggal, jam_mulai, jam_selesai, pesanan, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisssss", $nama, $jumlah_orang, $tanggal, $jam_mulai, $jam_selesai, $pesanan, $status);

    if ($stmt->execute()) {
        $_SESSION['reservation_success'] = true;
    } else {
        $_SESSION['reservation_error'] = "Gagal melakukan reservasi.";
    }

    $stmt->close();
    $conn->close();
    
    header("Location: index.php"); // Redirect kembali ke halaman utama
    exit();
}

// Jika akses tidak valid, redirect
header("Location: index.php");
exit();
?>