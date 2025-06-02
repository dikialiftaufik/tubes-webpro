<?php
session_start();
require_once '../configdb.php';

// Set pesan default
$_SESSION['error'] = '';
$_SESSION['success'] = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validasi input kosong
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Email dan password harus diisi!";
        header("Location: ../login-register.php");
        exit();
    }

    try {
        // Cari user berdasarkan email
        $stmt = $conn->prepare("SELECT id, full_name, username, email, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if ($user) {
            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                // Set session user
                $_SESSION['loggedin'] = true; // Tambahkan ini
                $_SESSION['user'] = [ // Simpan dalam array 'user'
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'full_name' => $user['full_name'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'profile' => 'uploads/profiles/default.jpg' // Default profile
                ];
                
                // Set session untuk notifikasi
                $_SESSION['login_success'] = "Berhasil masuk sebagai " . $user['full_name'];
                
                header("Location: ../index.php");
                exit();
            } else {
                $_SESSION['error'] = "Password salah!";
                header("Location: ../login-register.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Email tidak ditemukan!";
            header("Location: ../login-register.php");
            exit();
        }
    } catch (Exception $e) {
        error_log("Login error: " . $e->getMessage());
        $_SESSION['error'] = "Terjadi kesalahan sistem. Silakan coba lagi nanti.";
        header("Location: ../login-register.php");
        exit();
    }
} else {
    header("Location: ../login-register.php");
    exit();
}