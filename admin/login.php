<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Login</title>
    <link rel="icon" type="image/x-icon" href="../img/logo/logo-alt.png" />
    <!-- Link ke file CSS Bootstrap -->
    <link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />
    <!-- SweetAlert2 CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"
      rel="stylesheet"
    />
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

      /* Background Image */
      body {
        font-family: "Poppins", sans-serif;
        background-image: url("../img/hero-section.jpg");
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        height: 100vh;
        margin: 0;
        box-shadow: inset 0 0 0 2000px rgba(0, 0, 0, 0.45);
      }

      .logo-container {
        text-align: center;
        margin-top: -20px;
        margin-bottom: -120px;
      }

      .logo-container img {
        width: 190px;
        height: auto;
        padding: 10px;
      }

      /* Kontainer Login */
      .login-container {
        width: auto;
        height: fit-content;
        margin: 0 auto;
        background: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(2px);
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        overflow: hidden;
      }

      /* Judul Form Login */
      .login-container h2 {
        text-align: center;
        color: #302c24;
        margin-bottom: 30px;
      }

      /* Gaya untuk Logo */
      .logo {
        display: block;
        margin: 0 auto 20px;
        width: 100px;
      }

      /* Tombol Login */
      .login-container .btn-primary {
        background-color: #4d3835;
        border-color: #4d3835;
      }

      /* Tombol Hover untuk Login */
      .login-container .btn-primary:hover {
        background-color: #302c24;
        border-color: #302c24;
      }

      /* Gaya untuk Input Field */
      .login-container .form-control {
        background-color: #dcd1d6;
        border: 1px solid #564a4b;
        color: #302c24;
      }

      .login-container .form-control:focus {
        border-color: #4d3835;
        box-shadow: 0 0 5px rgba(77, 56, 53, 0.5);
      }

      /* Remember Me dan Forgot Password */
      .remember-forgot {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
      }

      .remember-forgot a {
        color: #4d3835;
        text-decoration: none;
      }

      .remember-forgot a:hover {
        text-decoration: underline;
      }

      /* Register Link */
      .register-link {
        text-align: center;
        margin-top: 20px;
      }

      .register-link a {
        color: #4d3835;
        text-decoration: none;
      }

      .register-link a:hover {
        text-decoration: underline;
      }
    </style>
  </head>

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
        <form id="loginForm">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input
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

          <!-- Remember Me dan Forgot Password -->
          <div class="remember-forgot">
            <div>
              <input type="checkbox" id="rememberMe" />
              <label for="rememberMe" class="form-check-label"
                >Ingat Saya</label
              >
            </div>
            <div>
              <a href="forgotPass.html">Lupa Password?</a>
            </div>
          </div>

          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
      </div>
    </div>

    <!-- Skrip JS Bootstrap -->
    <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
      function togglePasswordVisibility() {
        const passwordInput = document.getElementById("password");
        const eyeIcon = document.getElementById("eyeIcon");

        if (passwordInput.type === "password") {
          passwordInput.type = "text";
          eyeIcon.classList.remove("bi-eye");
          eyeIcon.classList.add("bi-eye-slash");
        } else {
          passwordInput.type = "password";
          eyeIcon.classList.remove("bi-eye-slash");
          eyeIcon.classList.add("bi-eye");
        }
      }

      document
        .getElementById("loginForm")
        .addEventListener("submit", function (e) {
          e.preventDefault();

          const username = document.getElementById("username").value.trim();
          const password = document.getElementById("password").value.trim();

          if (!username && !password) {
            Swal.fire({
              icon: "error",
              title: "Login Gagal",
              text: "Username dan Password harus diisi!",
              confirmButtonColor: "#4d3835",
            });
          } else if (!username) {
            Swal.fire({
              icon: "error",
              title: "Login Gagal",
              text: "Username harus diisi!",
              confirmButtonColor: "#4d3835",
            });
          } else if (!password) {
            Swal.fire({
              icon: "error",
              title: "Login Gagal",
              text: "Password harus diisi!",
              confirmButtonColor: "#4d3835",
            });
          } else if (username === "dikialif" && password === "admin123") {
            // Jika username dan password cocok
            Swal.fire({
              icon: "success",
              title: "Login Berhasil",
              text: "Selamat datang, Admin!",
              // confirmButtonColor: "#4d3835",
              showConfirmButton: false, // Menghilangkan tombol OK
              timer: 3000, // Timer 3 detik
              timerProgressBar: true,
            }).then(() => {
              window.location.href = "dashboard.html";
            });
          } else {
            // Jika username atau password salah
            Swal.fire({
              icon: "error",
              title: "Login Gagal",
              text: "Username atau Password salah!",
              confirmButtonColor: "#4d3835",
            });
          }
        });
    </script>
  </body>
</html>
