<?php
session_start();

// Menerima data keranjang dari request AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pastikan data yang diterima adalah JSON
    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    
    if ($contentType === 'application/json') {
        // Ambil konten JSON dari request
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);
        
        // Validasi data yang diterima
        if ($decoded && is_array($decoded)) {
            // Simpan pesanan ke dalam session
            $_SESSION['pesanan'] = $decoded;
            
            // Hitung total quantity dan price
            $totalQuantity = 0;
            $totalPrice = 0;
            
            foreach ($decoded as $item) {
                $totalQuantity += $item['quantity'];
                $totalPrice += $item['price'] * $item['quantity'];
            }
            
            // Simpan total ke dalam session
            $_SESSION['totalQuantity'] = $totalQuantity;
            $_SESSION['totalPrice'] = $totalPrice;
            
            // Kirim respons sukses
            echo json_encode([
                'status' => 'success',
                'message' => 'Data pesanan berhasil disimpan'
            ]);
            exit;
        }
    }
    
    // Jika format tidak valid
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'Format data tidak valid'
    ]);
    exit;
}

//  metode request bukan POST
http_response_code(405);
echo json_encode([
    'status' => 'error',
    'message' => 'Metode tidak diizinkan'
]);