<?php
session_start();
require_once '../configdb.php'; // Assuming configdb.php is in the parent directory

// Set pesan default
$_SESSION['error'] = '';
$_SESSION['success'] = '';
// Flag to indicate a registration attempt for the login-register page
$_SESSION['register_form'] = true; 

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

    // Validasi format email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Format email tidak valid!";
        header("Location: ../login-register.php");
        exit();
    }

    // Validasi karakter username
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $_SESSION['error'] = "Username hanya boleh mengandung huruf, angka, dan underscore!";
        header("Location: ../login-register.php");
        exit();
    }

     // Validasi panjang password
     if (strlen($password) < 6) {
        $_SESSION['error'] = "Password minimal 6 karakter!"; //
        header("Location: ../login-register.php");
        exit();
    }

    try {
        // Cek full_name sudah ada
        $stmt_fn = $conn->prepare("SELECT full_name FROM users WHERE full_name = ?");
        $stmt_fn->bind_param("s", $full_name);
        $stmt_fn->execute();
        $stmt_fn->store_result();
        
        if ($stmt_fn->num_rows > 0) {
            $_SESSION['error'] = "Nama lengkap sudah digunakan!";
            $_SESSION['error_type'] = "full_name";
            $stmt_fn->close();
            header("Location: ../login-register.php");
            exit();
        }
        $stmt_fn->close();

        // Cek username sudah ada
        $stmt_user = $conn->prepare("SELECT username FROM users WHERE username = ?");
        $stmt_user->bind_param("s", $username);
        $stmt_user->execute();
        $stmt_user->store_result();
        
        if ($stmt_user->num_rows > 0) {
            $_SESSION['error'] = "Username sudah digunakan!"; 
            $_SESSION['error_type'] = "username"; // Tambahkan tipe error
            $stmt_user->close();
            header("Location: ../login-register.php");
            exit();
        }
        $stmt_user->close();

        // Cek email sudah ada
        $stmt_email = $conn->prepare("SELECT email FROM users WHERE email = ?");
        $stmt_email->bind_param("s", $email);
        $stmt_email->execute();
        $stmt_email->store_result();
        
        if ($stmt_email->num_rows > 0) {
            $_SESSION['error'] = "Email sudah terdaftar!"; 
            $_SESSION['error_type'] = "email";
            $stmt_email->close();
            header("Location: ../login-register.php");
            exit();
        }
        $stmt_email->close();

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert data baru
        $stmt_insert = $conn->prepare("INSERT INTO users (full_name, username, email, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt_insert->bind_param("sssss", $full_name, $username, $email, $hashed_password, $role);
        
        if ($stmt_insert->execute()) {
            $_SESSION['success'] = "Registrasi berhasil! Silakan login"; //
            // $_SESSION['register_form'] is already true, so the user will be on the login form with success message.
            // If you want them to stay on register form but see success, it's a bit unusual.
            // Typically, after successful registration, they are encouraged to login.
            // Forcing the register panel active on success might be confusing.
            // However, if you want to explicitly keep register panel for success:
            // $_SESSION['show_register_panel_on_success'] = true; // and handle this in login-register.php
            // For now, standard behavior is to show success and they can then sign in.
            // The panel logic in login-register.php will show login by default if no $register_form is forcing it.
            // Let's ensure the panel is NOT forced to register on success, but rather login.
            // So, for success, we can unset register_form or set it to false.
            $_SESSION['register_form'] = false; // On successful registration, direct to login panel with success message.

            header("Location: ../login-register.php");
            exit();
        } else {
            $_SESSION['error'] = "Gagal melakukan registrasi: " . $stmt_insert->error;
            header("Location: ../login-register.php");
            exit();
        }
        
        $stmt_insert->close();
    } catch (Exception $e) {
        // Log the detailed error for the admin, show a generic message to the user.
        error_log("Registration Error: " . $e->getMessage()); // Logs to server error log
        $_SESSION['error'] = "Terjadi kesalahan sistem. Silakan coba lagi nanti.";
        // $_SESSION['db_error'] = "Terjadi kesalahan: " . $e->getMessage(); // If you want to use the db_error session from footer
        header("Location: ../login-register.php");
        exit();
    }
    
    $conn->close();
} else {
    // If not a POST request, redirect them away or show an error.
    // Keeping $_SESSION['register_form'] = true might be undesirable if they didn't attempt POST.
    // unset($_SESSION['register_form']); // Or set to false if direct access not via form.
    header("Location: ../login-register.php");
    exit();
}
?>