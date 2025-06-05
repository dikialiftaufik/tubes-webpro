<?php
// File: htdocs/tubes/proses/order_action.php

require_once __DIR__ . '/../configdb.php';
header('Content-Type: application/json; charset=utf-8');

// Pastikan permintaan benar‐benar POST dan terdapat parameter 'id'
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}

$menu_id = intval($_POST['id']);

// 1) Periksa stok saat ini dari tabel menu
$stmt = $conn->prepare("SELECT quantity FROM menu WHERE id = ?");
$stmt->bind_param('i', $menu_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(['status' => 'error', 'message' => 'Menu tidak ditemukan']);
    exit;
}

$row = $result->fetch_assoc();
$current_stock = intval($row['quantity']);
$stmt->close();

if ($current_stock <= 0) {
    // Jika stok sudah habis, kembalikan status out_of_stock
    echo json_encode(['status' => 'out_of_stock', 'message' => 'Stok habis']);
    exit;
}

// 2) Kurangi stok satu unit
$new_stock = $current_stock - 1;
$stmt2 = $conn->prepare("UPDATE menu SET quantity = ? WHERE id = ?");
$stmt2->bind_param('ii', $new_stock, $menu_id);


if ($stmt2->execute()) {
    // Berhasil mengurangi stok
    echo json_encode([
        'status'    => 'success',
        'message'   => 'Stok berhasil dikurangi',
        'new_stock' => $new_stock
    ]);
} else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui stok']);
}
$stmt2->close();
$conn->close();
