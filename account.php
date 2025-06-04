<?php
session_start();

// Redirect jika belum login
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header("Location: login-register.php");
    exit;
}

// Ambil data user dari session
$user = $_SESSION['user'] ?? [
    'username' => 'dikialift13',
    'email' => 'dikia@example.com',
    'full_name' => 'John Doe'
];

// Tentukan foto profil berdasarkan username
$profileImage = "uploads/profile/default.jpg"; // default

// Periksa username dan atur foto profil yang sesuai
if ($user['username'] === 'dikialift') {
    $profileImage = "uploads/profiles/1746731699_fotodiki.jpg";
} elseif ($user['username'] === 'egafiandra') {
    $profileImage = "uploads/profiles/1746347113_fotoega.jpg";
}
?>

<!doctype html>
<html lang="en">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Akun Saya</title>
    <link rel="icon" type="image/x-icon" href="img/logo/logo-alt.png" />
    <link rel="stylesheet" href="css/responsive.css" />
    <link rel="stylesheet" href="css/orders.css" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
    <link
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
  rel="stylesheet"
/>
    <link
      href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
  </head>
  <body>
    <header>
      <nav id="nav-desktop">
        <div class="nav large-container">
          <ul>
            <li data-aos="fade-down" data-aos-duration="500">
              <a href="index.php">Home</a>
            </li>
            <li
              data-aos="fade-down"
              data-aos-duration="500"
              data-aos-delay="100"
            >
              <a href="AboutUs.php">About</a>
            </li>
            <li
              data-aos="fade-down"
              data-aos-duration="500"
              data-aos-delay="200"
            >
              <a href="Makanan.php">Menu</a>
            </li>
            <li
              data-aos="fade-down"
              data-aos-duration="500"
              data-aos-delay="400"
            >
              <a href="#reservation">Reservasi</a>
            </li>
          </ul>

          <img
            src="img/logo/logo2.png"
            data-aos="fade-down"
            data-aos-duration="500"
            data-aos-delay="300"
            alt="logo"
            width="150px"
            height="75px"
          />

          <ul>
            <li
              data-aos="fade-down"
              data-aos-duration="500"
              data-aos-delay="500"
            >
              <a href="#location">Lokasi</a>
            </li>
            <li
              data-aos="fade-down"
              data-aos-duration="500"
              data-aos-delay="600"
            >
              <a href="findJobs.php">Karir</a>
            </li>
            <li
              data-aos="fade-down"
              data-aos-duration="500"
              data-aos-delay="700"
            >
              <a href="findJobs.php">
                <i class="fas fa-shopping-cart"></i>
              </a>
            </li>

            <!-- Notification -->
            <li
  class="notification-dropdown"
  data-aos="fade-down"
  data-aos-duration="500"
  data-aos-delay="800"
>
  <a href="#">
    <i class="fas fa-bell"></i>
    <span class="notification-badge">3</span>
  </a>
  <div class="dropdown-content">
    <div class="notification-item">
      <img src="img/notification/1.avif" alt="Promo Tahun Baru" />
      <div class="notification-text">
        <h4>Promo Tahun Baru</h4>
        <p>Diskon hingga 50% untuk semua menu!</p>
      </div>
    </div>
    <div class="notification-item">
      <img src="img/notification/sate-goreng.jpg" alt="Promo Makan Hemat" />
      <div class="notification-text">
        <h4>Menu Baru Wajib Coba!</h4>
        <p>Rasakan kenikmatan sate goreng ayam!</p>
      </div>
    </div>
  </div>
</li>

<!-- User -->
<li
  class="user-dropdown"
  data-aos="fade-down"
  data-aos-duration="500"
  data-aos-delay="900"
>
  <a href="#">
    <i class="fas fa-user"></i>
  </a>
  <div class="dropdown-content-user">
    <div class="user-info">
  <div class="user-name"><?= htmlspecialchars($user['username']) ?></div>
</div>
    <div class="dropdown-divider"></div>
    <a href="account.php" class="dropdown-item">
      <i class="fas fa-user-cog"></i> <p> Akun Saya</p>
    </a>
    <a href="orders.php" class="dropdown-item">
      <i class="fas fa-box"></i> <p> Pesanan Saya</p>
    </a>
    <a href="reservations.php" class="dropdown-item">
      <i class="fas fa-calendar-alt"></i> <p> Reservasi Saya</p>
    </a>
    <div class="dropdown-divider"></div>
    <a href="signout.php" class="dropdown-item logout">
      <i class="fas fa-sign-out-alt"></i> <p> Sign Out</p>
    </a>
  </div>
</li>


          </ul>
        </div>
      </nav>

      <nav id="nav-mobile">
        <div class="nav-mobile">
          <div class="nav large-container">
            <img
              src="img/logo/logo-alt.png"
              data-aos="fade-down"
              data-aos-duration="500"
              data-aos-delay="200"
              alt="logo-alt"
              width="50px"
              height="50px"
            />
            <div id="burger-navigation">
              <span></span>
              <span></span>
              <span></span>
            </div>
          </div>
        </div>

        <div class="nav-mobile-main">
          <div>
            <a href="index.php">Home</a>
          </div>
          <div>
            <a href="about.php">About Us</a>
          </div>
          <div>
            <a href="Makanan.php">Menu</a>
          </div>
          <div>
            <a href="#reservation">Reservation</a>
          </div>
          <div>
            <a href="#location">Location</a>
          </div>
          <div>
            <a href="findJobs.php">Find Jobs</a>
          </div>
        </div>
      </nav>
          </header>

                  <!-- Main Content Container -->
<div class="container">
  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="user-profile">
  <img src="<?= $profileImage ?>" alt="User Profile" class="profile-image">
  <h3><?= htmlspecialchars($user['full_name']) ?></h3>
  <p>Member since 2024</p>
</div>
    <ul class="sidebar-menu">
      <li>
        <a href="account.php" class="active">
          <i class="fas fa-user"></i>
          <span>Akun Saya</span>
        </a>
      </li>
      <li>
        <a href="orders.php">
          <i class="fas fa-box"></i>
          <span>Pesanan Saya</span>
        </a>
      </li>
      <li>
        <a href="reservations.php">
          <i class="fas fa-calendar-alt"></i>
          <span>Reservasi Saya</span>
        </a>
      </li>
      </ul>
  </aside>

  <!-- Main Content -->
  <main class="main-content">
    <div class="content-header">
        <h1>Akun Saya</h1>
    </div>

    <!-- Personal Information Section -->
    <section class="account-section">
        <div class="section-header">
            <h2>Informasi Pribadi</h2>
            <button class="btn edit-info-btn" id="editPersonalInfo">
                <i class="fas fa-edit"></i> Edit Informasi
            </button>
        </div>
        
        <div class="account-info-container">
            <div class="profile-image-container">
                <img src="<?= $profileImage ?>" alt="Profile Picture" class="account-profile-image">
                <div class="image-upload-overlay" style="display: none;">
                    <label for="profileImageInput" class="upload-label">
                        <i class="fas fa-camera"></i>
                        <span>Ubah Foto</span>
                    </label>
                    <input type="file" id="profileImageInput" accept="image/*" style="display: none;">
                </div>
            </div>

            <form class="personal-info-form" id="personalInfoForm">
                <div class="form-group">
                  <label for="fullName">Nama Lengkap</label>
                  <input type="text" id="fullName" name="fullName" disabled 
                        value="<?= htmlspecialchars($user['full_name']) ?>">
                </div>

                <div class="form-group">
                  <label for="username">Username</label>
                  <input type="text" id="username" name="username" disabled 
                        value="<?= htmlspecialchars($user['username']) ?>">
                </div>

                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" id="email" name="email" disabled 
                        value="<?= htmlspecialchars($user['email']) ?>">
                </div>

                <div class="form-group">
                    <label for="phone">Nomor Telepon</label>
                    <input type="tel" id="phone" name="phone" disabled value="+1234567890">
                </div>

                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="gender" value="male" disabled checked>
                            <span>Laki-laki</span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="gender" value="female" disabled>
                            <span>Perempuan</span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="gender" value="other" disabled>
                            <span>Lainnya</span>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address">Alamat</label>
                    <textarea id="address" name="address" disabled>Jl. Contoh No. 123, Kota Bandung</textarea>
                </div>

                <button type="submit" class="btn save-btn" style="display: none;">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </form>
        </div>
    </section>

    <!-- Security Settings Section -->
    <section class="account-section">
        <div class="section-header">
            <h2>Pengaturan Keamanan</h2>
            <button class="btn edit-info-btn" id="editSecurityInfo">
                <i class="fas fa-edit"></i> Edit Keamanan
            </button>
        </div>

        <form class="security-form" id="securityForm">
            <div class="form-group">
                <label for="currentPassword">Password Saat Ini</label>
                <input type="password" id="currentPassword" name="currentPassword" disabled placeholder="••••••••">
            </div>
            
            <div class="form-group">
                <label for="newPassword">Password Baru</label>
                <input type="password" id="newPassword" name="newPassword" disabled placeholder="••••••••">
            </div>
            
            <div class="form-group">
                <label for="confirmPassword">Konfirmasi Password Baru</label>
                <input type="password" id="confirmPassword" name="confirmPassword" disabled placeholder="••••••••">
            </div>

            <button type="submit" class="btn save-btn" style="display: none;">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </form>
    </section>
</main>
</div>

        
    <!-- Footer -->
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
              <a href="formPemesanan.php">
                <img
                  src="img/logo/google-play-icon.png"
                  alt="Google Play"
                  width="150px"
                  height="45px"
              /></a>
            </div>

            <div>
              <a href="formPemesanan.php">
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
    </footer>

    <script src="js/script.js" type="text/javascript"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <script>
// Fungsi untuk memuat data user
function loadUserData() {
    const userData = {
        username: "<?= $user['username'] ?>",
        email: "<?= $user['email'] ?>",
        full_name: "<?= $user['full_name'] ?>",
        phone: "+1234567890",
        gender: "male",
        address: "Jl. Contoh No. 123, Kota Bandung"
    };
    
    document.getElementById('fullName').value = userData.full_name;
    document.getElementById('username').value = userData.username;
    document.getElementById('email').value = userData.email;
    document.getElementById('phone').value = userData.phone;
    document.querySelector(`input[name="gender"][value="${userData.gender}"]`).checked = true;
    document.getElementById('address').value = userData.address;
}

// Event listener utama
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi komponen
    loadUserData();
    AOS.init();
    
    // Panggil fungsi inisialisasi
    initializePersonalInfoEditing();
    initializeSecurityEditing();
    updateActiveSidebarMenu();
});

// Fungsi untuk memperbarui menu sidebar aktif
function updateActiveSidebarMenu() {
    const currentPage = window.location.pathname.split('/').pop();
    
    document.querySelectorAll('.sidebar-menu a').forEach(item => {
        const itemPage = item.getAttribute('href');
        item.classList.remove('active');
        
        if (itemPage === currentPage) {
            item.classList.add('active');
        }
    });
}

// Fungsi untuk inisialisasi edit informasi pribadi
function initializePersonalInfoEditing() {
    const editBtn = document.getElementById('editPersonalInfo');
    const form = document.getElementById('personalInfoForm');
    const saveBtn = form.querySelector('.save-btn');
    const inputs = form.querySelectorAll('input:not([type="file"]), textarea, select');
    const radios = form.querySelectorAll('input[type="radio"]');
    const profileImageInput = document.getElementById('profileImageInput');
    const imageOverlay = document.querySelector('.image-upload-overlay');
    let isEditing = false;

    editBtn.addEventListener('click', () => {
        isEditing = !isEditing;
        
        inputs.forEach(input => {
            input.disabled = !isEditing;
        });
        
        radios.forEach(radio => {
            radio.disabled = !isEditing;
        });

        saveBtn.style.display = isEditing ? 'flex' : 'none';
        imageOverlay.style.display = isEditing ? 'flex' : 'none';
        
        editBtn.innerHTML = isEditing ? 
            '<i class="fas fa-times"></i> Batal' : 
            '<i class="fas fa-edit"></i> Edit Informasi';

        if (isEditing) {
            iziToast.info({
                title: 'Mode Edit',
                message: 'Anda dapat mengedit informasi pribadi',
                position: 'topRight'
            });
        }
    });

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        
        // Simulasi penyimpanan data
        isEditing = false;
        inputs.forEach(input => {
            input.disabled = true;
        });
        radios.forEach(radio => {
            radio.disabled = true;
        });
        saveBtn.style.display = 'none';
        imageOverlay.style.display = 'none';
        editBtn.innerHTML = '<i class="fas fa-edit"></i> Edit Informasi';

        iziToast.success({
            title: 'Berhasil',
            message: 'Informasi pribadi berhasil diperbarui',
            position: 'topRight'
        });
    });

    profileImageInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                document.querySelector('.account-profile-image').src = e.target.result;
                iziToast.success({
                    title: 'Berhasil',
                    message: 'Foto profil berhasil diperbarui',
                    position: 'topRight'
                });
            };
            reader.readAsDataURL(file);
        }
    });
}

// Fungsi untuk inisialisasi edit keamanan
function initializeSecurityEditing() {
    const editBtn = document.getElementById('editSecurityInfo');
    const form = document.getElementById('securityForm');
    const saveBtn = form.querySelector('.save-btn');
    const inputs = form.querySelectorAll('input');
    let isEditing = false;

    editBtn.addEventListener('click', () => {
        isEditing = !isEditing;
        
        inputs.forEach(input => {
            input.disabled = !isEditing;
            if (isEditing) {
                input.value = '';
                input.placeholder = 'Masukkan password';
            } else {
                input.value = '';
                input.placeholder = '••••••••';
            }
        });

        saveBtn.style.display = isEditing ? 'flex' : 'none';
        editBtn.innerHTML = isEditing ? 
            '<i class="fas fa-times"></i> Batal' : 
            '<i class="fas fa-edit"></i> Edit Keamanan';

        if (isEditing) {
            iziToast.info({
                title: 'Mode Edit',
                message: 'Anda dapat mengubah password',
                position: 'topRight'
            });
        }
    });

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        
        const currentPass = form.querySelector('#currentPassword').value;
        const newPass = form.querySelector('#newPassword').value;
        const confirmPass = form.querySelector('#confirmPassword').value;

        if (!currentPass || !newPass || !confirmPass) {
            iziToast.error({
                title: 'Error',
                message: 'Semua field harus diisi',
                position: 'topRight'
            });
            return;
        }

        if (newPass !== confirmPass) {
            iziToast.error({
                title: 'Error',
                message: 'Password baru tidak cocok',
                position: 'topRight'
            });
            return;
        }

        isEditing = false;
        inputs.forEach(input => {
            input.disabled = true;
            input.value = '';
            input.placeholder = '••••••••';
        });
        saveBtn.style.display = 'none';
        editBtn.innerHTML = '<i class="fas fa-edit"></i> Edit Keamanan';

        iziToast.success({
            title: 'Berhasil',
            message: 'Password berhasil diperbarui',
            position: 'topRight'
        });
    });
}

// Fungsi untuk tombol lihat password
document.querySelectorAll('.toggle-password').forEach(toggle => {
    toggle.addEventListener('click', function() {
        const input = this.previousElementSibling;
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
});
    </script>
  </body>
</html>