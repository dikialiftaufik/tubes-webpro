<?php
session_start();
require_once 'configdb.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login-register.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_reservation'])) {
    // Penyesuaian nama kolom
    $nama_pemesan = mysqli_real_escape_string($conn, $_POST['table_name']);
    $jumlah_orang = (int)$_POST['table_capacity'];
    $tanggal = mysqli_real_escape_string($conn, $_POST['order_date']);
    $jam_mulai = mysqli_real_escape_string($conn, $_POST['start_time']);
    $jam_selesai = mysqli_real_escape_string($conn, $_POST['jam_selesai']);
    
    $pesanan_array = $_POST['order'];
    $pesanan_escaped_array = array_map(function($item) use ($conn) {
        return mysqli_real_escape_string($conn, $item);
    }, $pesanan_array);
    $pesanan = implode(", ", $pesanan_escaped_array);

    $status = 'pending'; // Status default (huruf kecil)
    $id_user = $_SESSION['user_id'];

    // Penyesuaian query dengan nama kolom yang benar
    $stmt = $conn->prepare("INSERT INTO reservation (nama_pemesan, jumlah_orang, tanggal, jam_mulai, jam_selesai, pesanan, status, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisssssi", $nama_pemesan, $jumlah_orang, $tanggal, $jam_mulai, $jam_selesai, $pesanan, $status, $id_user);

    if ($stmt->execute()) {
        $_SESSION['reservation_success'] = true;
    } else {
        $_SESSION['reservation_error'] = "Gagal melakukan reservasi.";
    }

    $stmt->close();
    $conn->close();
    
    header("Location: index.php");
    exit();
}

header("Location: index.php");
exit();
?>