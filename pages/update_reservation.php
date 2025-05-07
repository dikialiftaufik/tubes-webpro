<?php
session_start();
require_once '../configdb.php';

header('Content-Type: application/json');

// Pastikan hanya user admin yang bisa update
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    echo json_encode(['message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'update') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jumlah_orang = $_POST['jumlah_orang'];
    $tanggal = $_POST['tanggal'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $pesanan = $_POST['pesanan'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE reservation SET nama=?, jumlah_orang=?, tanggal=?, jam_mulai=?, jam_selesai=?, pesanan=?, status=? WHERE id=?");
    $stmt->bind_param("sisssssi", $nama, $jumlah_orang, $tanggal, $jam_mulai, $jam_selesai, $pesanan, $status, $id);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Data berhasil diperbarui']);
    } else {
        echo json_encode(['message' => 'Gagal memperbarui data']);
    }
} else {
    echo json_encode(['message' => 'Permintaan tidak valid']);
}
?>
