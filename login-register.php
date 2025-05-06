<?php 
session_start();
if(isset($_SESSION['error'])): ?>
<script>
iziToast.error({
    title: 'Error!',
    message: '<?= $_SESSION["error"] ?>',
    position: 'topRight'
});
</script>
<?php unset($_SESSION['error']); endif; ?>

<?php if(isset($_SESSION['success'])): ?>
<script>
iziToast.success({
    title: 'Success!',
    message: '<?= $_SESSION["success"] ?>',
    position: 'topRight'
});
</script>
<?php unset($_SESSION['success']); endif; ?>

<?php if(isset($_SESSION['info'])): ?>
<script>
iziToast.info({
    title: 'Info!',
    message: '<?= $_SESSION["info"] ?>',
    position: 'topRight'
});
</script>
<?php unset($_SESSION['info']); endif; ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Login & Register</title>
    <link rel="icon" type="image/x-icon" href="img/logo/logo-alt.png" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">

    <style>
      @import url("https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

      * {
        box-sizing: border-box;
      }
      html, body {
        height: 100%;
        margin: 0;
        box-shadow: inset 0 0 0 2000px rgba(0, 0, 0, 0.60); /* Pastikan bayangan mencakup seluruh area */
        overflow: visible; /* Mencegah halaman di-scroll */
        position: static; /* Tambahkan ini */
        width: 100%; /* Tambahkan ini untuk memastikan cakupan penuh */
    }
      body, .main-wrapper {
        background: url('img/background.jpg') no-repeat center center/cover;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        font-family: "Poppins", sans-serif;
        height: 100vh;
        margin: 0;
      }
          h1 {
        font-weight: bold;
        margin: 0;
      }
      h2 {
        text-align: center;
      }
      p {
        font-size: 14px;
        font-weight: 100;
        line-height: 20px;
        letter-spacing: 0.5px;
        margin: 20px 0 30px;
      }
      span {
        font-size: 12px;
      }
      a {
        color: #333;
        font-size: 14px;
        text-decoration: none;
        margin: 15px 0;
      }
      button {
        border-radius: 20px;
        border: 1px solid #cc5134;
        background-color: #cc5134;
        color: #ffffff;
        font-size: 12px;
        font-weight: bold;
        padding: 12px 45px;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: transform 80ms ease-in;
      }
      button:active {
        transform: scale(0.95);
      }
      button:focus {
        outline: none;
      }
      button.ghost {
        background-color: transparent;
        border-color: #ffffff;
      }
      form {
        background-color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 50px;
        height: 100%;
        text-align: center;
      }
      input {
        background-color: #eee;
        border: none;
        padding: 12px 15px;
        margin: 8px 0;
        width: 100%;
      }
      .container {
        background-color: #fff;
        border-radius: 10px;
        position: relative;
        overflow: hidden;
        width: 768px;
        max-width: 100%;
        min-height: 480px;
      }
      .form-container {
        position: absolute;
        top: 0;
        height: 100%;
        transition: all 0.6s ease-in-out;
      }
      .sign-in-container {
        left: 0;
        width: 50%;
        z-index: 2;
      }
      .container.right-panel-active .sign-in-container {
        transform: translateX(100%);
      }
      .sign-up-container {
        left: 0;
        width: 50%;
        opacity: 0;
        z-index: 1;
      }
      .container.right-panel-active .sign-up-container {
        transform: translateX(100%);
        opacity: 1;
        z-index: 5;
        animation: show 0.6s;
      }
      
      .overlay-container {
        position: absolute;
        top: 0;
        left: 50%;
        width: 50%;
        height: 100%;
        overflow: hidden;
        transition: transform 0.6s ease-in-out;
        z-index: 100;
      }
      .container.right-panel-active .overlay-container {
        transform: translateX(-100%);
      }
      .overlay {
        background: #a2624d;
        background: -webkit-linear-gradient(to right, #D4145A, #d6901e);
        background: linear-gradient(to right, #D4145A, #d6901e);
        background-repeat: no-repeat;
        background-size: cover;
        background-position: 0 0;
        color: #ffffff;
        position: relative;
        left: -100%;
        height: 100%;
        width: 200%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
      }
      .container.right-panel-active .overlay {
        transform: translateX(50%);
      }
      .overlay-panel {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 40px;
        text-align: center;
        top: 0;
        height: 100%;
        width: 50%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
      }
      .overlay-left {
        transform: translateX(-20%);
      }
      .container.right-panel-active .overlay-left {
        transform: translateX(0);
      }
      .overlay-right {
        right: 0;
        transform: translateX(0);
      }
      .container.right-panel-active .overlay-right {
        transform: translateX(20%);
      }
      .social-container {
        margin: 20px 0;
      }
      .social-container a {
        border: 1px solid #dddddd;
        border-radius: 50%;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        margin: 0 5px;
        height: 40px;
        width: 40px;
      }
      .btn-gmail {
    border-radius: 20px;
    border: 1px solid #ff4b2b;
    background: linear-gradient(45deg, #ff4b2b, #ff416c);
    color: white;
    font-size: 12px;
    font-weight: bold;
    padding: 12px 45px;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: transform 80ms ease-in, box-shadow 0.3s ease;
    text-align: center;
}
.btn-gmail:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 15px rgba(255, 75, 43, 0.3);
    background: linear-gradient(45deg, #ff416c, #ff4b2b);
}
.btn-gmail:active {
    transform: scale(0.95);
    box-shadow: none;
}
.password-container {
      position: relative;
      display: inline-block;
    }
    .password-container input {
      padding-right: 100px; /* Memberikan ruang untuk ikon */
    }
    .password-container .toggle-password {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      cursor: pointer;
      color: #999;
    }
    .password-container .toggle-password:hover {
      color: #000;
    }
    .iziToast.iziToast-color-info {
    background: #2ecc71;
}
    </style>
  </head>
  <body>
    <div style="position: absolute; top: 20px; left: 30px;">
  <a href="index.html" style="
    display: flex;
    justify-content: center;
    align-items: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: white;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    text-decoration: none;
    color: #333;">
    <i class="fas fa-arrow-left"></i>
  </a>
</div>

</div>
    <div class="container" id="container">
<!-- Forgot Password Modal -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="forgotPasswordModalLabel">Lupa Password</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="emailInput">Masukkan Email Anda</label>
              <input type="email" class="form-control" id="emailInput" placeholder="example@example.com" required>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <a href="https://mail.google.com" class="btn btn-gmail" target="_blank">Buka Gmail</a>
          <button type="button" data-dismiss="modal">Kembali ke Login</button>
        </div>
      </div>
    </div>
  </div>
  
  
      <div class="form-container sign-up-container">
        <form action="auth/register_process.php" method="POST" id="registerForm">
          <h1>Buat Akun Baru</h1>
          
          <input type="text" name="full_name" id="registerName" placeholder="Masukkan Nama Lengkap" />
          <input type="email" name="email" id="registerEmail" placeholder="Masukkan Email" />
          <div class="password-container">
            <input type="password" name="password" id="registerPassword" placeholder="Masukkan Password" />
            <i class="fas fa-eye toggle-password" data-target="registerPassword"></i>
          </div>
          <button type="submit" id="registerButton">Daftar</button>
        </form>
      </div>
      <div class="form-container sign-in-container">
        <form action="auth/login_process.php" method="POST">
          <h1>Selamat Datang</h1>
         
          <input type="email" name="email" id="loginEmail" placeholder="Masukkan Email" />
          <div class="password-container">
            <input type="password" name="password" id="loginPassword" placeholder="Masukkan Password" />
            <i class="fas fa-eye toggle-password" data-target="password"></i>
          </div>
          <a href="#" data-toggle="modal" data-target="#forgotPasswordModal">Lupa password Anda?</a>

          <button type="submit" id="loginButton">Masuk</button>
        </form>
      </div>
      <div class="overlay-container">
        <div class="overlay">
          <div class="overlay-panel overlay-left">
            <img src="img/logo/logo2.png" alt="Logo BOLOOO" style="width: 225px; height: auto; margin-top: -50px; margin-bottom: 5px;">
            <h1>Selamat Datang Kembali!</h1>
            <p>
              Login dan dapatkan pengalaman kuliner yang lebih personal. Akses menu eksklusif, penawaran menarik, dan banyak lagi.
            </p>
            <button class="ghost" id="signIn">Masuk</button>
          </div>
          <div class="overlay-panel overlay-right">
            <img src="img/logo/logo2.png" alt="Logo BOLOOO" style="width: 225px; height: auto; margin-top: -50px; margin-bottom: 5px;">
            <h1>Hi, Pecinta Kuliner!</h1>
            <p>Yuk, mulai petualangan kulinermu bersama kami. Masukkan informasi pribadi Anda untuk membuka dunia cita rasa yang tak terbatas.</p>
            <button class="ghost" id="signUp">Daftar</button>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
<script>
  // Event Listener untuk Login dan Register
//   document.getElementById("loginButton").addEventListener("click", (e) => {
//     e.preventDefault();
//     handleAuth("login");
//   });

//   document.getElementById("registerButton").addEventListener("click", (e) => {
//     e.preventDefault();
//     document.getElementById("registerForm").submit(); // Submit form langsung
// });

  // Logika form toggle
  const signUpButton = document.getElementById("signUp");
  const signInButton = document.getElementById("signIn");
  const container = document.getElementById("container");

  signUpButton.addEventListener("click", () => container.classList.add("right-panel-active"));
  signInButton.addEventListener("click", () => container.classList.remove("right-panel-active"));

  // Tampilkan atau sembunyikan password
document.querySelectorAll('.toggle-password').forEach(toggle => {
  toggle.addEventListener('click', function () {
    const passwordContainer = this.closest('.password-container');
    const passwordInput = passwordContainer.querySelector('input[type="password"], input[type="text"]');
    
    // Toggle input type
    passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
    
    // Toggle eye icon
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
  });
});

    </script>
    <script>
// Notifikasi untuk semua aksi
document.addEventListener('DOMContentLoaded', function() {
    // Notifikasi form validation
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const inputs = this.querySelectorAll('input');
            let isValid = true;
            
            inputs.forEach(input => {
                if(!input.checkValidity()) {
                    isValid = false;
                    input.classList.add('is-invalid');
                    
                    iziToast.warning({
                        title: 'Peringatan',
                        message: `${input.placeholder} harus diisi!`,
                        position: 'topRight'
                    });
                }
            });

            if(!isValid) e.preventDefault();
        });
    });

    // Notifikasi toggle password
    document.querySelectorAll('.toggle-password').forEach(toggle => {
        toggle.addEventListener('click', function() {
            const isVisible = this.classList.contains('fa-eye-slash');
            iziToast.info({
                title: 'Keamanan',
                message: isVisible ? 'Password disembunyikan' : 'Password ditampilkan',
                position: 'topRight',
                timeout: 2000
            });
        });
    });

    // Notifikasi panel toggle
    const panelButtons = {
        signUp: 'Bergabung dengan komunitas kuliner',
        signIn: 'Selamat datang kembali!'
    };
    
    document.getElementById('signUp').addEventListener('click', () => showPanelToast('signUp'));
    document.getElementById('signIn').addEventListener('click', () => showPanelToast('signIn'));

    function showPanelToast(type) {
        iziToast.info({
            title: 'Mode Form',
            message: panelButtons[type],
            position: 'topRight',
            timeout: 2000,
            backgroundColor: '#e67e22'
        });
    }

    // Notifikasi forgot password
    document.querySelector('[data-target="#forgotPasswordModal"]').addEventListener('click', () => {
        iziToast.info({
            title: 'Reset Password',
            message: 'Masukkan email terdaftar Anda',
            position: 'topRight'
        });
    });

    // Notifikasi saat buka Gmail
    document.querySelector('.btn-gmail').addEventListener('click', function(e) {
        e.preventDefault();
        iziToast.info({
            title: 'Redirecting...',
            message: 'Mengarahkan ke halaman Gmail',
            position: 'topRight'
        });
        setTimeout(() => window.open(this.href, '_blank'), 1000);
    });

    // Notifikasi navigasi kembali
    document.querySelector('.fa-arrow-left').closest('a').addEventListener('click', function(e) {
        e.preventDefault();
        iziToast.info({
            title: 'Navigasi',
            message: 'Kembali ke halaman utama',
            position: 'topRight',
            onClosing: () => window.location.href = this.href
        });
    });

    // Notifikasi interaksi input
    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('focus', () => {
            iziToast.hide();
            iziToast.info({
                title: 'Input Aktif',
                message: `Sedang mengisi ${input.placeholder}`,
                position: 'topRight',
                timeout: 1000,
                backgroundColor: '#3498db'
            });
        });
    });
});

// Handle error dari PHP
<?php if(isset($_SESSION['db_error'])): ?>
iziToast.error({
    title: 'Database Error',
    message: '<?= $_SESSION["db_error"] ?>',
    position: 'topRight'
});
<?php unset($_SESSION['db_error']); endif; ?>
</script>
  </body>
</html>
