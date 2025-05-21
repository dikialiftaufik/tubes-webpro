<footer>
      <div class="footer-info">
        <div class="footer-info-items main-container">
          <div data-aos="fade-up">
            <h3>Selamat Datang di BOLOOO</h3>
            <p>Tempat setiap gigitan bercerita</p>
            <p>
              Masuki tempat berlindung kami yang nyaman, di mana kehangatan
              keramahan yang tulus mengundang Anda untuk bersantai dan menikmati
              momen kenikmatan yang menyenangkan.
            </p>
          </div>
          <div data-aos="fade-up" data-aos-delay="100">
            <h3>Kunjungi Kami</h3>
            <p>
              Jl. Sukapura No.76, Cipagalo, Kec. Bojongsoang, Kabupaten Bandung,
              Jawa Barat 40287
            </p>

            <h3>Hubungi Kami</h3>
            <p>
              6281215486311<br />
              BOLOOO.food@gmail.com
            </p>
          </div>

          <div data-aos="fade-up" data-aos-delay="200">
            <h3>Unduh Aplikasi</h3>
            <div>
              <a href="formPemesanan.html">
                <img
                  src="img/logo/google-play-icon.png"
                  alt="Google Play"
                  width="150px"
                  height="45px"
              /></a>
            </div>

            <div>
              <a href="formPemesanan.html">
                <img
                  src="img/logo/app-store-icon.png"
                  alt="App Store"
                  width="150px"
                  height="45px"
              /></a>
            </div>
          </div>
        </div>
      </div>

      <div class="footer-copyright">
        <div class="footer-items large-container">
          <div class="footer-left">&copy; <?= date('Y') ?> BOLOOO. All Rights Reserved</div>

          <div class="footer-mid">
            <img
              src="img/logo/logo.png"
              alt="logo"
              width="150px"
              height="100px"
            />
          </div>

          <div class="footer-right">Rasakan Bedanya</div>
        </div>
      </div>
    </footer>

    <script src="js/script.js" type="text/javascript"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
    <script>
      AOS.init();
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("reservation-item-form");
    const isLoggedIn = <?php echo isset($_SESSION['loggedin']) ? 'true' : 'false'; ?>;

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        if (isLoggedIn) {
            iziToast.success({
                title: "Berhasil!",
                message: "Reservasi Anda sedang diproses.",
                position: "topRight",
                timeout: 3000,
                onClosing: function () {
                    // Submit form secara normal
                    form.submit();
                }
            });
        } else {
            iziToast.warning({
                title: "Perhatian!",
                message: "Anda harus login terlebih dahulu untuk melakukan reservasi.",
                position: "topRight",
                timeout: 3000,
                onClosing: function () {
                    window.location.href = "login-register.php";
                }
            });
        }
    });
});
</script>
  </body>
</html>