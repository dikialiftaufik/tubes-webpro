<?php
// session_start(); // This should be at the very top, ideally in header-log-reg.php if it's included first.
                 // The provided header-log-reg.php already has session_start().

// Retrieve and unset session messages and flags
$success_message = isset($_SESSION['success']) ? $_SESSION['success'] : '';
$error_message = isset($_SESSION['error']) ? $_SESSION['error'] : '';
if (isset($_SESSION['success'])) unset($_SESSION['success']);
if (isset($_SESSION['error'])) unset($_SESSION['error']);

// Determine if the last action was a registration attempt that requires the register panel to be active
$activate_register_panel = isset($_SESSION['register_form']) ? $_SESSION['register_form'] : false;
if (isset($_SESSION['register_form'])) unset($_SESSION['register_form']);

// If user already login, redirect ke home
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
  header("Location: index.php");
  exit;
}

include 'views/header-log-reg.php'; // This file contains session_start()
?>

<div class="container" id="container" class="<?php echo $activate_register_panel ? 'right-panel-active' : ''; ?>">
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
          
          <input type="text" name="full_name" id="registerName" placeholder="Masukkan Nama Lengkap" required />
          <input type="text" name="username" id="registerUsername" placeholder="Masukkan Username" required />
          <input type="email" name="email" id="registerEmail" placeholder="Masukkan Email" required />
          <div class="password-container">
            <input type="password" name="password" id="registerPassword" placeholder="Masukkan Password" required />
            <i class="fas fa-eye toggle-password" data-target="registerPassword"></i>
          </div>
          <button type="submit" id="registerButton">Daftar</button>
        </form>
      </div>
      <div class="form-container sign-in-container">
        <form action="auth/login_process.php" method="POST" id="loginForm"> <h1>Selamat Datang</h1>
         
          <input type="email" name="email" id="loginEmail" placeholder="Masukkan Email" required />
          <div class="password-container">
            <input type="password" name="password" id="loginPassword" placeholder="Masukkan Password" required />
            <i class="fas fa-eye toggle-password" data-target="loginPassword"></i> </div>
          
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('container'); // Get container again if needed, or use the one from outer scope if JS is one block

    // Server-side feedback toasts
    const phpSuccessMessage = '<?= addslashes($success_message) ?>';
    const phpErrorMessage = '<?= addslashes($error_message) ?>';
    const errorType = '<?= isset($_SESSION['error_type']) ? $_SESSION['error_type'] : '' ?>';
    <?php unset($_SESSION['error_type']); ?>
    // $activate_register_panel is a PHP variable passed to JS
    const wasRegistrationAttempt = <?= $activate_register_panel ? 'true' : 'false' ?>;

    // The class 'right-panel-active' is now set directly in the HTML via PHP.
    // This JS can still be used if dynamic changes are needed post-load, but for initial state, PHP is fine.
    // if (wasRegistrationAttempt && container) {
    //     container.classList.add('right-panel-active');
    // }

    if (phpSuccessMessage) {
    let title = 'Sukses!';
    
    if (phpSuccessMessage.includes("Registrasi berhasil")) {
        title = 'Registrasi Berhasil';
        iziToast.success({
            title: title,
            message: phpSuccessMessage,
            position: 'topRight',
            timeout: 5000,
            icon: 'fas fa-check-circle',
            backgroundColor: '#2ecc71',
            onClose: () => {
                // Otomatis switch ke panel login setelah notifikasi
                container.classList.remove('right-panel-active');
            }
        });
    } else {
        iziToast.success({
            title: title,
            message: phpSuccessMessage,
            position: 'topRight',
            timeout: 5000
        });
    }
}

    if (phpErrorMessage) {
    let title = 'Gagal!';
    let icon = 'fas fa-exclamation-circle';
    let color = '#e74c3c';
    
    // Custom message berdasarkan jenis error
    if (wasRegistrationAttempt) {
        title = 'Registrasi Gagal';
        
        switch(errorType) {
            case 'username':
                message = 'Username sudah digunakan. Silakan pilih username lain.';
                icon = 'fas fa-user-times';
                break;
            case 'email':
                message = 'Email sudah terdaftar. Gunakan email lain atau lupa password.';
                icon = 'fas fa-envelope';
                break;
            case 'full_name':
                message = 'Nama lengkap sudah digunakan. Silakan gunakan nama lain.';
                icon = 'fas fa-id-card';
                break;
            default:
                message = phpErrorMessage;
        }
    } else {
        message = phpErrorMessage;
    }

    iziToast.error({
        title: title,
        message: message,
        position: 'topRight',
        timeout: 5000,
        icon: icon,
        backgroundColor: color,
        theme: 'dark'
    });
}

// Di dalam event listener DOMContentLoaded
if (errorType) {
    const inputMap = {
        'username': 'registerUsername',
        'email': 'registerEmail',
        'full_name': 'registerName'
    };
    
    if (inputMap[errorType]) {
        const errorInput = document.getElementById(inputMap[errorType]);
        if (errorInput) {
            errorInput.classList.add('input-error');
            
            // Hapus class error setelah 3 detik
            setTimeout(() => {
                errorInput.classList.remove('input-error');
            }, 3000);
        }
    }
}

    // Client-side validation for Register Form (as it was in your login-register.php)
    // This provides immediate feedback before server submission.
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            let isValid = true;
            // Ensure your inputs have the 'required' attribute for this to work as intended with querySelectorAll
            const inputs = this.querySelectorAll('input[required]'); 
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('is-invalid');
                    // You might want an iziToast here for each empty required field, 
                    // or rely on the generic "Harap isi semua field" below.
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            const password = document.getElementById('registerPassword');
            if (password && password.value.length < 6) {
                isValid = false;
                if (password) password.classList.add('is-invalid');
                iziToast.error({
                    title: 'Error Validasi',
                    message: 'Password minimal 6 karakter.',
                    position: 'topRight'
                });
            }

            if (!isValid) {
                e.preventDefault(); // Prevent form submission
                iziToast.error({
                    title: 'Error Validasi',
                    message: 'Harap isi semua field yang wajib diisi dengan benar.',
                    position: 'topRight'
                });
            }
        });
    }

    // Toggle password visibility (as it was in your login-register.php)
    // Ensure data-target matches the ID of the password input field.
    document.querySelectorAll('.toggle-password').forEach(icon => {
        icon.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const passwordInput = document.getElementById(targetId);
            if (passwordInput) {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                // Toggle icon classes
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            }
        });
    });
});
</script>
<style>
/* Tambahkan style untuk input tidak valid */
.is-invalid {
    border-color: #ff3860 !important; /* Red border for invalid inputs */
}
/* Di dalam tag style */
.input-error {
    border: 2px solid #e74c3c !important;
    animation: shake 0.5s;
}

@keyframes shake {
    0%, 100% {transform: translateX(0);}
    20%, 60% {transform: translateX(-5px);}
    40%, 80% {transform: translateX(5px);}
}
</style>
<?php include 'views/footer-log-reg.php'; ?>