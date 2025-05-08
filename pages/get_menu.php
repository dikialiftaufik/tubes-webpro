<?php
// pages/get_menu.php
require_once '../configdb.php';

header('Content-Type: application/json');

try {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        throw new Exception('ID tidak valid');
    }
    
    $id = (int)$_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM menu WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        throw new Exception('Data tidak ditemukan');
    }
    
    echo json_encode($result->fetch_assoc());
} catch (Exception $e) {
    http_response_code(404);
    echo json_encode(['error' => $e->getMessage()]);
}