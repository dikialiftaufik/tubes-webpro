<?php
// get_reservation.php
require_once '../configdb.php';

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'ID tidak diberikan']);
    exit();
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM reservation WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(['error' => 'Data tidak ditemukan']);
}
$conn->close();
