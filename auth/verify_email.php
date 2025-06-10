<?php
header('Content-Type: application/json');
session_start();
require_once '../configdb.php'; // Sesuaikan path dengan struktur folder Anda

// Pastikan request adalah POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method tidak diizinkan.'
    ]);
    exit;
}

// Ambil email dari POST data
$email = trim($_POST['email'] ?? '');

// Validasi input
if (empty($email)) {
    echo json_encode([
        'success' => false,
        'message' => 'Email harus diisi.'
    ]);
    exit;
}

// Validasi format email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false,
        'message' => 'Format email tidak valid.'
    ]);
    exit;
}

try {
    // Cek apakah email ada di database
    $stmt = $conn->prepare("SELECT id, email, full_name FROM users WHERE email = ? AND status = 'active'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Email ditemukan
        $user = $result->fetch_assoc();
        
        // Simpan informasi email yang terverifikasi dalam session untuk keamanan
        $_SESSION['verified_email'] = $email;
        $_SESSION['verified_email_time'] = time();
        $_SESSION['verified_user_id'] = $user['id'];
        
        // Log aktivitas verifikasi email (opsional)
        error_log("Email verification successful for: " . $email . " at " . date('Y-m-d H:i:s'));
        
        echo json_encode([
            'success' => true,
            'message' => 'Email terverifikasi berhasil.',
            'user_name' => $user['full_name'] // Bisa digunakan untuk personalisasi pesan
        ]);
    } else {
        // Email tidak ditemukan atau akun tidak aktif
        
        // Log percobaan verifikasi email yang gagal (untuk keamanan)
        error_log("Failed email verification attempt for: " . $email . " at " . date('Y-m-d H:i:s') . " from IP: " . $_SERVER['REMOTE_ADDR']);
        
        echo json_encode([
            'success' => false,
            'message' => 'Email tidak terdaftar dalam sistem atau akun tidak aktif.'
        ]);
    }

    $stmt->close();

} catch (Exception $e) {
    // Log error untuk debugging
    error_log("Database error in verify_email.php: " . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'Terjadi kesalahan sistem. Silakan coba lagi nanti.'
    ]);
} finally {
    // Tutup koneksi database
    if (isset($conn)) {
        $conn->close();
    }
}
?>