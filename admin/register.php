<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar</title>
    <link rel="icon" type="image/x-icon" href="../img/logo/logo-alt.png" />
    <!-- Link ke file CSS Bootstrap -->
    <link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />

    <style>
      body {
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

      .register-container {
        width: auto;
        margin: 0 auto;
        background: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(2px);
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        margin-top: 50px;
      }

      .register-container h2 {
        text-align: center;
        color: #302c24;
        margin-bottom: 30px;
      }

      .register-container .btn-primary {
        background-color: #4d3835;
        border-color: #4d3835;
      }

      .register-container .btn-primary:hover {
        background-color: #302c24;
        border-color: #302c24;
      }

      .register-container .form-control {
        background-color: #dcd1d6;
        border: 1px solid #564a4b;
        color: #302c24;
      }

      .register-container .form-control:focus {
        border-color: #4d3835;
        box-shadow: 0 0 5px rgba(77, 56, 53, 0.5);
      }

      .back-to-login {
        text-align: center;
        margin-top: 20px;
      }

      .back-to-login a {
        color: #4d3835;
        text-decoration: none;
      }

      .back-to-login a:hover {
        text-decoration: underline;
      }

      .form-label.required::after {
        content: " *";
        color: red;
      }

      .country-code-wrapper {
        border-right: none !important;
      }

      .form-control:focus {
        box-shadow: none;
        border-color: #dee2e6;
      }

      .required:after {
        content: " *";
        color: red;
      }

      /* Untuk mencegah spinner pada input type number */
      input::-webkit-outer-spin-button,
      input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
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
      <div class="register-container">
        <h2>Buat Akun</h2>
        <form id="registerForm">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="name" class="form-label required"
                  >Nama Lengkap</label
                >
                <input
                  type="text"
                  class="form-control"
                  id="name"
                  placeholder="Masukkan nama lengkap"
                  required
                />
              </div>

              <div class="mb-3">
                <label for="email" class="form-label required">Email</label>
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  placeholder="Masukkan email Anda"
                  required
                />
              </div>

              <div class="mb-3">
                <label for="password" class="form-label required"
                  >Password</label
                >
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
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label for="username" class="form-label required"
                  >Username</label
                >
                <input
                  type="text"
                  class="form-control"
                  id="username"
                  placeholder="Masukkan username"
                  required
                />
              </div>

              <div class="mb-3">
                <label for="phone" class="form-label required"
                  >No. Telepon</label
                >
                <div class="input-group">
                  <div
                    class="country-code-wrapper d-flex align-items-center border rounded-start px-2"
                    style="background-color: #f8f9fa"
                  >
                    <!-- Indonesian flag circle -->
                    <div
                      style="
                        width: 20px;
                        height: 20px;
                        overflow: hidden;
                        border-radius: 50%;
                        margin-right: 8px;
                      "
                    >
                      <div
                        style="
                          width: 100%;
                          height: 50%;
                          background-color: #ff0000;
                        "
                      ></div>
                      <div
                        style="
                          width: 100%;
                          height: 50%;
                          background-color: #ffffff;
                        "
                      ></div>
                    </div>
                    <!-- Country code -->
                    <span class="text-muted">+62</span>
                  </div>
                  <input
                    type="tel"
                    class="form-control border-start-0"
                    id="phone"
                    placeholder="81212345679"
                    maxlength="12"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                    required
                  />
                </div>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label required"
                  >Konfirmasi Password</label
                >
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
            </div>
          </div>

          <div class="text-center mt-4">
            <button
              type="button"
              id="registerButton"
              class="btn btn-primary w-100"
            >
              Buat akun Saya
            </button>
          </div>
        </form>

        <div class="back-to-login">
          <p>Sudah punya akun? <a href="login.html">Masuk disini</a></p>
        </div>
      </div>
    </div>

    <!-- Skrip JS -->
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

      // Tambahan validasi untuk input nomor telepon
      document
        .getElementById("phone")
        .addEventListener("keypress", function (e) {
          // Mencegah input selain angka
          if (!/[0-9]/.test(e.key)) {
            e.preventDefault();
          }

          // Mencegah input lebih dari 12 digit
          if (this.value.length >= 12) {
            e.preventDefault();
          }
        });

      document
        .getElementById("registerButton")
        .addEventListener("click", function () {
          // Validasi sederhana
          const username = document.getElementById("username").value;
          const email = document.getElementById("email").value;
          const password = document.getElementById("password").value;

          if (username && email && password) {
            // SweetAlert modal sukses
            Swal.fire({
              icon: "success",
              title: "Pendaftaran Berhasil!",
              html: `Akun Anda telah berhasil dibuat. 
                   <br><br>
                   <a href="login.html" class="btn btn-primary" style="text-decoration: none;">Login Sekarang</a>`,
              showConfirmButton: false,
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Pendaftaran Gagal!",
              text: "Harap lengkapi semua data yang diperlukan.",
            });
          }
        });
    </script>
  </body>
</html>
