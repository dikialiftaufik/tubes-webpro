<?php
session_start();
require_once '../configdb.php';

// Set pesan default
$_SESSION['error'] = '';
$_SESSION['success'] = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = 'customer'; // Role otomatis

    // Validasi input kosong
    if (empty($full_name) || empty($username) || empty($email) || empty($password)) {
        $_SESSION['error'] = "Semua field harus diisi!";
        header("Location: ../login-register.php");
        exit();
    }

    try {
        // Cek username sudah ada
        $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $_SESSION['error'] = "Username sudah digunakan!";
            header("Location: ../login-register.php");
            exit();
        }
        $stmt->close();

        // Cek email sudah ada
        $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $_SESSION['error'] = "Email sudah terdaftar!";
            header("Location: ../login-register.php");
            exit();
        }
        $stmt->close();

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert data baru
        $stmt = $conn->prepare("INSERT INTO users (full_name, username, email, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $full_name, $username, $email, $hashed_password, $role);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Registrasi berhasil! Silakan login";
            header("Location: ../login-register.php");
            exit();
        } else {
            $_SESSION['error'] = "Gagal melakukan registrasi";
            header("Location: ../login-register.php");
            exit();
        }
        
        $stmt->close();
    } catch (Exception $e) {
        $_SESSION['error'] = "Terjadi kesalahan sistem";
        header("Location: ../login-register.php");
        exit();
    }
    
    $conn->close();
} else {
    header("Location: ../login-register.php");
    exit();
}
?>