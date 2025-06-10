<?php
session_start();

// --- Pengaturan Session & Pesan ---
$success_message = '';
$error_message = "";
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) { // Tambahkan ini jika error dari redirect
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}

// --- Nonaktifkan Cache ---
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// --- Koneksi Database ---
require_once '../configdb.php';

// --- Proses Login (POST) ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validasi input
    if (empty($username) || empty($password)) {
        $error_message = "Username dan password harus diisi!";
    } else {
        try {
            // Query dengan prepared statement
            $stmt = $conn->prepare("SELECT id, username, password, role, full_name FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                
                // Verifikasi password
                if (password_verify($password, $user['password'])) {
                    // Set session
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'role' => $user['role'],
                        'full_name' => $user['full_name']
                    ];

                    // Cookie Ingat Saya
                    if (isset($_POST['rememberMe'])) {
                        $cookieValue = base64_encode($user['id'] . ':' . $user['username']);
                        setcookie(
                            'remember_user',
                            $cookieValue,
                            time() + (30 * 24 * 3600), // 30 hari
                            "/", // Path cookie agar tersedia di seluruh domain
                            "", // Domain (kosongkan untuk domain saat ini)
                            false, // Secure: true jika menggunakan HTTPS, false jika HTTP. Ganti ke true di produksi jika HTTPS.
                            true  // HttpOnly: mencegah akses JavaScript
                        );
                    }

                    // Redirect berdasarkan role
                    session_regenerate_id(true); // Regenerasi ID sesi untuk keamanan
                    if ($user['role'] === 'admin') {
                        header("Location: dashboard.php");
                    } elseif ($user['role'] === 'cashier') { // Gunakan 'cashier' sesuai DB
                        header("Location: cashier.php");
                    } else {
                        // Jika ada role lain yang login dari halaman ini, bisa dialihkan ke halaman lain
                        header("Location: ../index.php"); // Contoh: customer dialihkan ke index.php
                    }
                    exit();
                } else {
                    $error_message = "Password salah!";
                }
            } else {
                $error_message = "Username tidak ditemukan!";
            }
            
            $stmt->close();
        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            $error_message = "Terjadi kesalahan sistem";
        }
    }
}

include '../views/header-login.php';
?>

<body>
    <div class="logo-container">
        <img src="../img/logo/logo.png" alt="Logo" />
    </div>
    <div class="container d-flex align-items-center justify-content-center" style="height: 100vh">
        <div class="login-container">
            <h2>Selamat Datang!</h2>

            <?php if(!empty($error_message)): ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>

            <?php if(!empty($success_message)): ?>
                <div class="alert alert-success" role="alert">
                    <?= htmlspecialchars($success_message) ?>
                </div>
            <?php endif; ?>

            <form id="loginForm" method="POST" action=""> <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input
                        name="username"
                        type="text"
                        class="form-control"
                        id="username"
                        placeholder="Masukkan username"
                        required
                        autofocus
                    />
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
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

                <div class="remember-forgot">
                    <div>
                        <input type="checkbox" id="rememberMe" name="rememberMe"/>
                        <label for="rememberMe" class="form-check-label">Ingat Saya</label>
                    </div>
                    <div>
                        <a href="forgotPass.php">Lupa Password?</a>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            }
        }
    </script>

<?php
include '../views/footer-login.php';
?>