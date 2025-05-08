<?php include 'views/header-log-reg.php'; ?>
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
<?php include 'views/footer-log-reg.php'; ?>