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

      <?php if(!empty($error_message)): ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Login Gagal',
        text: '<?= $error_message ?>',
        confirmButtonColor: '#4d3835'
    });
</script>
<?php endif; ?>
      
    </script>
  </body>
</html>
