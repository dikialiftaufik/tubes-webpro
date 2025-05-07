<?php
session_start();
include '../configdb.php'; 

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 0) {
    $_SESSION['error'] = "Email tidak terdaftar!";
    header("Location: ../login-register.php");
    exit();
}

$user = $result->fetch_assoc();

if(!password_verify($password, $user['password'])) {
    $_SESSION['error'] = "Password salah!";
    header("Location: ../login-register.php");
    exit();
}

// Login berhasil
$_SESSION['user'] = [
    'id' => $user['id'],
    'name' => $user['full_name'],
    'email' => $user['email']
];

$_SESSION['success'] = "Login berhasil!";
header("Location: ../index.php"); // Redirect ke halaman utama
exit();

// Setelah validasi login sukses
$_SESSION['loggedin'] = true;
$_SESSION['user_email'] = $email; // Contoh menyimpan email user
// Redirect ke halaman index
header("Location: ../../index.php");
exit;
?>