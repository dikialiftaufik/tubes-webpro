<?php
// get_notification.php
session_start();
require_once '../configdb.php';

$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("SELECT * FROM notifications WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if ($data) {
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'Notifikasi tidak ditemukan']);
}
exit();
?>