<!-- Skrip JS Bootstrap -->
    <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      document
        .getElementById("sendResetLink")
        .addEventListener("click", function () {
          const email = document.getElementById("email").value.trim();
          if (!email) {
            Swal.fire({
              icon: "error",
              title: "Gagal!",
              text: "Alamat email tidak boleh kosong.",
              confirmButtonText: "OK",
            });
          } else {
            Swal.fire({
              icon: "success",
              title: "Link Reset Dikirim!",
              html: `
    <p>Link reset telah dikirim ke email Anda.</p>
    <div style="display: flex; justify-content: center; gap: 10px; margin-top: 20px;">
      <button onclick="window.open('https://mail.google.com', '_blank')" style="padding: 10px 20px; background-color: #1a73e8; color: white; border: none; border-radius: 5px; cursor: pointer;">Buka Gmail</button>
      <button onclick="window.location.href='login.html'" style="padding: 10px 20px; background-color: #6c63ff; color: white; border: none; border-radius: 5px; cursor: pointer;">Login Sekarang</button>
    </div>
  `,
              showConfirmButton: false, // Hilangkan tombol default SweetAlert2
            });
          }
        });
    </script>
  </body>
</html>