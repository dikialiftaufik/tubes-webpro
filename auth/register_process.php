<?php
session_start();
include '../configdb.php';

// Validasi input
if(empty($_POST['full_name']) || empty($_POST['email']) || empty($_POST['password'])) {
    $_SESSION['error'] = "Semua field harus diisi!";
    header("Location: ../login-register.php");
    exit();
}

$full_name = $_POST['full_name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Generate username dari email
$username = strtolower(explode('@', $email)[0]); // Ambil bagian sebelum @
$username = preg_replace('/[^a-z0-9]/', '', $username); // Hapus karakter khusus

// Cek duplikat email
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0) {
    $_SESSION['error'] = "Email sudah terdaftar!";
    header("Location: ../login-register.php");
    exit();
}

// Cek duplikat username
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0) {
    // Jika username sudah ada, tambahkan angka random
    $username = $username.rand(100,999);
}

// Simpan ke database dengan username
$stmt = $conn->prepare("INSERT INTO users (full_name, email, password, username) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $full_name, $email, $password, $username);

if($stmt->execute()) {
    $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
    $_SESSION['info'] = "Username Anda: ".$username;
} else {
    $_SESSION['error'] = "Gagal melakukan registrasi: ".$conn->error;
}

header("Location: ../login-register.php");
exit();
?>