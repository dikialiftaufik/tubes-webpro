<?php
session_start(); 

// --- Bagian 1: Pengaturan Session & Pesan ---
$success_message = ''; // untuk menyimpan notifikasi yang akan ditampilkan
$error_message = "";
if (isset($_SESSION['success_message'])) { 
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

// --- Bagian 2: Nonaktifkan Cache ---
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// --- Bagian 3: Koneksi Database ---
require_once '../configdb.php';

// --- Bagian 4: Proses Login (POST) ---
if ($_SERVER["REQUEST_METHOD"] == "POST") { // memastikan kode hanya dijalankan jika form dikirim dengan metode POST
    $username = mysqli_real_escape_string($conn, $_POST['username']); // mencegah sql injection
    $password = $_POST['password']; // tidak menggunakan mysqli_real_escape_string karena akan di hash
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // validasi field kosong
    if (empty($username) || empty($password) || empty($role)) {
        $error_message = "Semua field harus diisi!";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND role = ?");
        $stmt->bind_param("ss", $username, $role);
        $stmt->execute();
        $result = $stmt->get_result();

        // memastikan hanya ada satu data pengguna yang cocok dengan username dan role.
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc(); // mengonversi hasil query ke array asosiatif
            
            // --- Perbaikan 1: Verifikasi Password dengan Hash ---
            if (password_verify($password, $user['password'])) { 
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'full_name' => $user['full_name']
                ];

                // --- Perbaikan 2: Cookie "Ingat Saya" ---
                if (isset($_POST['rememberMe'])) {
                    // Set cookie berlaku 30 hari
                    $cookie_name = "remember_user";
                    $cookie_value = base64_encode($user['id'] . ":" . $user['username']);
                    setcookie(
                        $cookie_name,
                        $cookie_value,
                        time() + (30 * 24 * 3600), // 30 hari
                        "/", // berlaku seluruh path website
                        "",
                        false, // HTTPS tidak wajib
                        true   // Hanya diakses via HTTP
                    );
                }

                // Redirect berdasarkan role
                session_regenerate_id(true); // Keamanan: anti session fixation
                if ($user['role'] === 'admin') {
                    header("Location: dashboard.php");
                } else {
                    header("Location: cashier.php");
                }
                exit();
            } else {
                $error_message = "Password salah!";
            }
        } else {
            $error_message = "Username tidak ditemukan atau role tidak sesuai!";
        }
    }
}

include '../views/header-login.php';
?>

  <body>
    <div class="logo-container">
      <img src="../img/logo/logo.png" alt="Logo" />
    </div>
    <div
      class="container d-flex align-items-center justify-content-center"
      style="height: 100vh"
    >
      <div class="login-container">
        <h2>Selamat Datang!</h2>

        <?php if(!empty($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <?php if(!empty($success_message)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $success_message; ?>
        </div>
        <?php endif; ?>

        <form id="loginForm" method="POST">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input
              name="username"
              type="text"
              class="form-control"
              id="username"
              placeholder="Masukkan username"
              required
            />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label required">Password</label>
            <div class="input-group">
              <input
                name="password"
                type="password"
                class="form-control"
                id="password"
                placeholder="Masukkan password"
                required
              />
              <button
                class="btn btn-outline-dark"
                type="button"
                id="togglePassword"
                onclick="togglePasswordVisibility()"
              >
                <i class="bi bi-eye" id="eyeIcon"></i>
              </button>
            </div>
          </div>
          <div class="mb-3">
            <label for="role" class="form-label">Role</label>
              <select class="form-control" id="role" name="role" required>
                <option value="" disabled>Pilih Role</option>
                <option value="admin" name="admin">Admin</option>
                <option value="cashier" name="cashier">Kasir</option>
              </select>
          </div>

          <!-- Remember Me dan Forgot Password -->
          <div class="remember-forgot">
            <div>
              <input type="checkbox" id="rememberMe" name="rememberMe"/>
              <label for="rememberMe" class="form-check-label"
                >Ingat Saya</label
              >
            </div>
            <div>
              <a href="forgotPass.php">Lupa Password?</a>
            </div>
          </div>

          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
      </div>
    </div>

<?php
include '../views/footer-login.php';
?>