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
