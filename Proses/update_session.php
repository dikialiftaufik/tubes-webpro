<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $_SESSION['pesanan'] = $data['pesanan'];
    $_SESSION['totalQuantity'] = $data['totalQuantity'];
    $_SESSION['totalPrice'] = $data['totalPrice'];
    
    echo json_encode(['status' => 'success']);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
?>