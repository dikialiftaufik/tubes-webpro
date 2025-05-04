<?php
// pages/forgotPass.php
session_start();

// Header untuk disable cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once '../configdb.php';

$error_message = "";
$success_message = "";
$show_password_form = false;
$max_attempts = 3; // Batas maksimal percobaan
$block_time = 300; // Waktu blokir dalam detik (5 menit)

// Cek status blokir
if (isset($_SESSION['reset_block_time']) && (time() - $_SESSION['reset_block_time']) < $block_time) {
    $remaining_time = $block_time - (time() - $_SESSION['reset_block_time']);
    $error_message = "Anda terlalu banyak mencoba. Silakan coba lagi setelah " . ceil($remaining_time/60) . " menit.";
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['reset_request'])) {
        // Tahap 1: Verifikasi username/email ---------------------------------
        $identifier = mysqli_real_escape_string($conn, trim($_POST['identifier'] ?? ''));
        
        // Validasi input
        if (empty($identifier)) {
            $error_message = "Username atau email harus diisi!";
        } else {
            // Cek percobaan reset
            $_SESSION['reset_attempts'] = ($_SESSION['reset_attempts'] ?? 0) + 1;
            
            // Jika melebihi batas
            if ($_SESSION['reset_attempts'] > $max_attempts) {
                $_SESSION['reset_block_time'] = time();
                $error_message = "Terlalu banyak percobaan. Silakan coba lagi nanti.";
            } else {
                // Cek user di database
                $stmt = $conn->prepare("SELECT id, username, email FROM users WHERE username = ? OR email = ?");
                $stmt->bind_param("ss", $identifier, $identifier);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows === 1) {
                    $user = $result->fetch_assoc();
                    $_SESSION['reset_user_id'] = $user['id'];
                    $show_password_form = true;
                    unset($_SESSION['reset_attempts']); // Reset counter jika valid
                } else {
                    $error_message = "Username/email tidak ditemukan! (Percobaan ke-" . $_SESSION['reset_attempts'] . ")";
                }
            }
        }
    } elseif (isset($_POST['reset_password'])) {
        // Tahap 2: Reset password -------------------------------------------
        if (!isset($_SESSION['reset_user_id'])) {
            header("Location: forgotPass.php");
            exit();
        }
        
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        // Validasi dasar
        $errors = [];
        if (empty($new_password)) {
            $errors[] = "Password baru harus diisi!";
        }
        if (empty($confirm_password)) {
            $errors[] = "Konfirmasi password harus diisi!";
        }
        if ($new_password !== $confirm_password) {
            $errors[] = "Password tidak sama!";
        }
        
        // Validasi kompleks
        if (empty($errors)) {
            if (strlen($new_password) < 8) {
                $errors[] = "Password minimal 8 karakter";
            }
            if (!preg_match('/[A-Za-z]/', $new_password)) {
                $errors[] = "Harus mengandung huruf";
            }
            // Validasi huruf kapital BARU
            if (!preg_match('/[A-Z]/', $new_password)) {
                $errors[] = "Harus mengandung minimal 1 huruf kapital";
            }
            if (!preg_match('/[0-9]/', $new_password)) {
                $errors[] = "Harus mengandung angka";
            }
            if (!preg_match('/[\W]/', $new_password)) {
                $errors[] = "Harus mengandung simbol";
            }
        }
        
        if (!empty($errors)) {
            $error_message = implode("<br>", $errors);
            $show_password_form = true;
        } else {
            // Update password
            $user_id = $_SESSION['reset_user_id'];
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->bind_param("si", $new_password, $user_id);
            
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Password berhasil diubah!";
                unset($_SESSION['reset_user_id']);
                header("Location: login.php");
                exit(); // Penting untuk menghentikan eksekusi script
            } else {
                $error_message = "Gagal mengubah password!";
            }
        }
    }
}

include '../views/header-forgot.php';
?>

  <body>
    <div class="logo-container">
      <img src="../img/logo/logo.png" alt="Logo" />
    </div>
    <div
      class="container d-flex align-items-center justify-content-center"
      style="height: 100vh"
    >
      <div class="forgot-password-container">
        <h2>Lupa Password</h2>

        <?php if($error_message): ?>
            <div class="alert alert-danger"><?= $error_message ?></div>
        <?php endif; ?>
            
        <?php if($success_message): ?>
            <div class="alert alert-success"><?= $success_message ?></div>
        <?php endif; ?>

        <?php if(!$show_password_form): ?>

          <form method="POST">
                    <div class="mb-3">
                        <label for="identifier" class="form-label">Username atau Email</label>
                        <input
                            type="text"
                            class="form-control"
                            id="identifier"
                            name="identifier"
                            placeholder="Masukkan username/email"
                            required
                        />
                    </div>
                    <button type="submit" name="reset_request" class="btn btn-primary w-100">
                        Verifikasi Akun
                    </button>
                </form>
            <?php else: ?>

              <!-- Form New Password -->
                <form method="POST">
                  <div class="password-criteria">
            <strong>Kriteria Password:</strong>
            <ul>
                <li>Minimal 8 karakter</li>
                <li>Minimal 1 huruf kapital (A-Z)</li>
                <li>Minimal 1 angka (0-9)</li>
                <li>Minimal 1 simbol (!@#$%^&* dll)</li>
            </ul>
        </div>

          <div class="mb-3">
            <label for="new_password" class="form-label required">Password Baru</label>
            <div class="input-group">
              <input
                type="password"
                class="form-control"
                id="new_password"
                name="new_password"
                placeholder="Masukkan password baru"
                required
              />
          </div><br>
          <div class="mb-3">
                        <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                        <input
                            type="password"
                            class="form-control"
                            id="confirm_password"
                            name="confirm_password"
                            placeholder="Konfirmasi password baru"
                            required
                        />
                    </div>
<br>
          <button type="submit" name="reset_password" class="btn btn-primary w-100">
                        Ubah Password
                    </button>
                </form>
            <?php endif; ?>
        </form>
        <div class="back-to-login">
          <p><a href="login.php">Kembali ke Login</a></p>
        </div>
      </div>
    </div>

<?php
include '../views/footer-login.php';
?>