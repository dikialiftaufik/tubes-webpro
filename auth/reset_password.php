<?php
session_start();
require_once __DIR__ . '/../configdb.php';

// Ambil data
$email    = trim($_POST['email'] ?? '');
$pass1    = $_POST['new_password'] ?? '';
$pass2    = $_POST['confirm_password'] ?? '';

// Validasi sederhana
if (!$email || !$pass1 || !$pass2) {
    $_SESSION['error'] = 'Semua field wajib diisi.';
    header('Location: ../login-register.php');
    exit;
}
if ($pass1 !== $pass2) {
    $_SESSION['error'] = 'Password baru dan konfirmasi tidak cocok.';
    header('Location: ../login-register.php');
    exit;
}

// Cek email terdaftar
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows === 0) {
    $_SESSION['error'] = 'Email tidak ditemukan.';
    $stmt->close();
    header('Location: ../login-register.php');
    exit;
}
$stmt->bind_result($user_id);
$stmt->fetch();
$stmt->close();

// Update password
$hash = password_hash($pass1, PASSWORD_DEFAULT);
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
$stmt->bind_param('si', $hash, $user_id);
if ($stmt->execute()) {
    $_SESSION['success'] = 'Password berhasil di-reset. Silakan login.';
} else {
    $_SESSION['error'] = 'Gagal mereset password. Coba lagi.';
}
$stmt->close();

header('Location: ../login-register.php');
exit;
