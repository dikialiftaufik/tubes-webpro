<?php
session_start();
require_once '../configdb.php'; // Sesuaikan path jika berbeda

// Asumsi: user sudah terautentikasi karena account.php sudah melakukan validasi.
// Jadi, user_id pasti ada di sesi.
$user_id = $_SESSION['user']['id'];

// Pastikan request adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // --- Validasi Sisi Server ---
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $_SESSION['error_message'] = "Semua field password harus diisi.";
        header("Location: ../account.php"); // Redirect kembali ke halaman account
        exit;
    }

    if ($new_password !== $confirm_password) {
        $_SESSION['error_message'] = "Password baru dan konfirmasi password tidak cocok.";
        header("Location: ../account.php");
        exit;
    }

    // Optional: Validasi kekuatan password (misal: minimal 8 karakter, kombinasi huruf besar/kecil, angka, simbol)
    if (strlen($new_password) < 8) {
        $_SESSION['error_message'] = "Password baru harus memiliki minimal 8 karakter.";
        header("Location: ../account.php");
        exit;
    }
    // Anda bisa menambahkan validasi regex untuk kompleksitas password di sini jika diperlukan

    try {
        // Ambil password lama (hashed) dari database
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $hashed_current_password_db = $user['password'];

            // Verifikasi password saat ini
            if (password_verify($current_password, $hashed_current_password_db)) {
                // Password saat ini benar, hash password baru
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Perbarui password di database
                $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                $update_stmt->bind_param("si", $hashed_new_password, $user_id);

                if ($update_stmt->execute()) {
                    $_SESSION['success_message'] = "Password berhasil diperbarui. Silakan login kembali dengan password baru.";
                    // Setelah mengganti password, untuk keamanan, disarankan untuk mengarahkan ke halaman logout
                    // agar sesi saat ini diakhiri dan pengguna harus login lagi dengan password baru.
                    header("Location: logout.php"); // Mengarahkan ke logout, yang kemudian akan mengarahkan ke login.
                    exit;
                } else {
                    $_SESSION['error_message'] = "Gagal memperbarui password: " . $update_stmt->error;
                    header("Location: ../account.php");
                    exit;
                }
                $update_stmt->close();
            } else {
                $_SESSION['error_message'] = "Password saat ini salah.";
                header("Location: ../account.php");
                exit;
            }
        } else {
            // User tidak ditemukan (seharusnya tidak terjadi jika account.php sudah memvalidasi login)
            // Namun, ini sebagai fallback keamanan ekstrem.
            $_SESSION['error_message'] = "User tidak ditemukan atau sesi bermasalah. Silakan login ulang.";
            session_unset();
            session_destroy();
            header("Location: ../login-register.php"); // Mengarahkan ke login-register jika sesi benar-benar bermasalah
            exit;
        }
        $stmt->close();
    } catch (Exception $e) {
        error_log("Password update error for user ID {$user_id}: " . $e->getMessage());
        $_SESSION['error_message'] = "Terjadi kesalahan sistem saat memperbarui password. Silakan coba lagi.";
        header("Location: ../account.php");
        exit;
    } finally {
        // Tutup koneksi database
        if (isset($conn)) {
            $conn->close();
        }
    }
} else {
    // Jika diakses langsung tanpa POST request
    $_SESSION['error_message'] = "Akses tidak sah.";
    header("Location: ../account.php");
    exit;
}
?>