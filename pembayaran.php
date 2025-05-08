<?php
session_start();

// Pastikan data pembayaran tersedia
if (!isset($_SESSION['data_pembayaran']) || !isset($_SESSION['order_id'])) {
    header("Location: pembayaran.php");
    exit();
}

// Lakukan proses pembayaran di sini
// Update status pembayaran di database, dll.

// Setelah selesai, redirect ke halaman selesai
header("Location: selesai.php");
exit();
?>