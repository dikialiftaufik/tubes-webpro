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
    $masukan = $_POST['masukan'];

    $stmt = $conn->prepare("UPDATE feedback SET nama=?, masukan=? WHERE id=?");
    $stmt->bind_param("sss", $nama, $masukan, $id);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Data berhasil diperbarui']);
    } else {
        echo json_encode(['message' => 'Gagal memperbarui data']);
    }
} else {
    echo json_encode(['message' => 'Permintaan tidak valid']);
}
?>
