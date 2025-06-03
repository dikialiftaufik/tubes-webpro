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
if ($user['username'] === 'diki') {
    $profileImage = "uploads/profiles/1746731699_fotodiki.jpg";
} elseif ($user['username'] === 'ega') {
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
        <a href="account.php">
          <i class="fas fa-user"></i>
          <span>Akun Saya</span>
        </a>
      </li>
      <li>
        <a href="orders.php" class="active">
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
        <h1>My Account</h1>
    </div>

    <!-- Personal Information Section -->
    <section class="account-section">
        <div class="section-header">
            <h2>Personal Information</h2>
            <button class="btn edit-info-btn" id="editPersonalInfo">
                <i class="fas fa-edit"></i> Edit Information
            </button>
        </div>
        
        <div class="account-info-container">
            <div class="profile-image-container">
                <img src="<?= $profileImage ?>" alt="Profile Picture" class="account-profile-image">
                <div class="image-upload-overlay" style="display: none;">
                    <label for="profileImageInput" class="upload-label">
                        <i class="fas fa-camera"></i>
                        <span>Change Photo</span>
                    </label>
                    <input type="file" id="profileImageInput" accept="image/*" style="display: none;">
                </div>
            </div>

            <form class="personal-info-form" id="personalInfoForm">
                <<form class="personal-info-form" id="personalInfoForm">
                <div class="form-group">
                  <label for="fullName">Full Name</label>
                  <input type="text" id="fullName" name="fullName" disabled 
                        value="<?= htmlspecialchars($user['full_name']) ?>">
                </div>

                <div class="form-group">
                  <label for="username">Username</label>
                  <input type="text" id="username" name="username" disabled 
                        value="<?= htmlspecialchars($user['username']) ?>">
                </div>

                <div class="form-group">
                  <label for="email">Email Address</label>
                  <input type="email" id="email" name="email" disabled 
                        value="<?= htmlspecialchars($user['email']) ?>">
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" disabled value="+1234567890">
                </div>

                <div class="form-group">
                    <label>Gender</label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="gender" value="male" disabled checked>
                            <span>Male</span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="gender" value="female" disabled>
                            <span>Female</span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="gender" value="other" disabled>
                            <span>Other</span>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" disabled>123 Main Street, Apt 4B, City, Country</textarea>
                </div>

                <button type="submit" class="btn save-btn" style="display: none;">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </form>
        </div>
    </section>

    <!-- Security Settings Section -->
    <section class="account-section">
        <div class="section-header">
            <h2>Security Settings</h2>
            <button class="btn edit-info-btn" id="editSecurityInfo">
                <i class="fas fa-edit"></i> Edit Security
            </button>
        </div>

        <form class="security-form" id="securityForm">
            <div class="form-group">
                <label for="currentPassword">Password</label>
                <input type="password" id="currentPassword" name="currentPassword" disabled placeholder="••••••••">
            </div>

            <button type="submit" class="btn save-btn" style="display: none;">
                <i class="fas fa-save"></i> Save Changes
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
function loadUserData() {
    // Ini contoh static, di real app harus fetch dari server
    const userData = {
        username: "<?= $user['username'] ?>",
        email: "<?= $user['email'] ?>",
        full_name: "<?= $user['full_name'] ?>",
        phone: "+1234567890",
        gender: "male",
        address: "123 Main Street, Apt 4B, City, Country"
    };
    
    document.getElementById('fullName').value = userData.full_name;
    document.getElementById('username').value = userData.username;
    document.getElementById('email').value = userData.email;
    document.getElementById('phone').value = userData.phone;
    document.querySelector(`input[name="gender"][value="${userData.gender}"]`).checked = true;
    document.getElementById('address').value = userData.address;
}

// Panggil saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    loadUserData();
    
      AOS.init();

      // Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Update active sidebar menu item
    updateActiveSidebarMenu();

    // Initialize Personal Information editing functionality
    initializePersonalInfoEditing();

    // Initialize Security Settings editing functionality
    initializeSecurityEditing();

    // Initialize Notification Settings functionality
    initializeNotificationSettings();
});

// Function to update the active sidebar menu item
function updateActiveSidebarMenu() {
    // Remove active class from all menu items
    document.querySelectorAll('.sidebar-menu a').forEach(item => {
        item.classList.remove('active');
    });

    // Add active class to the Account menu item
    const accountMenuItem = document.querySelector('.sidebar-menu a[href="account.php"]');
    if (accountMenuItem) {
        accountMenuItem.classList.add('active');
    }
}

// Function to initialize Personal Information editing
function initializePersonalInfoEditing() {
    const editBtn = document.getElementById('editPersonalInfo');
    const form = document.getElementById('personalInfoForm');
    const saveBtn = form.querySelector('.save-btn');
    const inputs = form.querySelectorAll('input:not([type="file"]), textarea');
    const profileImageInput = document.getElementById('profileImageInput');
    const imageOverlay = document.querySelector('.image-upload-overlay');
    let isEditing = false;

    // Handle Edit button click
    editBtn.addEventListener('click', () => {
        isEditing = !isEditing;
        
        // Toggle input fields
        inputs.forEach(input => {
            input.disabled = !isEditing;
        });

        // Toggle buttons and overlay
        saveBtn.style.display = isEditing ? 'flex' : 'none';
        imageOverlay.style.display = isEditing ? 'flex' : 'none';
        editBtn.innerHTML = isEditing ? 
            '<i class="fas fa-times"></i> Cancel' : 
            '<i class="fas fa-edit"></i> Edit Information';

        // Show notification
        if (isEditing) {
            iziToast.info({
                title: 'Edit Mode',
                message: 'You can now edit your personal information',
                position: 'topRight'
            });
        }
    });

    // Handle form submission
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        
        // Here you would typically send the data to your server
        // For demonstration, we'll just show a success message
        
        // Reset form state
        isEditing = false;
        inputs.forEach(input => {
            input.disabled = true;
        });
        saveBtn.style.display = 'none';
        imageOverlay.style.display = 'none';
        editBtn.innerHTML = '<i class="fas fa-edit"></i> Edit Information';

        // Show success notification
        iziToast.success({
            title: 'Success',
            message: 'Personal information updated successfully',
            position: 'topRight'
        });
    });

    // Handle profile image upload
    profileImageInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                document.querySelector('.account-profile-image').src = e.target.result;
                
                // Show success notification
                iziToast.success({
                    title: 'Success',
                    message: 'Profile picture updated successfully',
                    position: 'topRight'
                });
            };
            reader.readAsDataURL(file);
        }
    });
}

// Function to initialize Security Settings editing
function initializeSecurityEditing() {
    const editBtn = document.getElementById('editSecurityInfo');
    const form = document.getElementById('securityForm');
    const saveBtn = form.querySelector('.save-btn');
    const inputs = form.querySelectorAll('input');
    let isEditing = false;

    // Handle Edit button click
    editBtn.addEventListener('click', () => {
        isEditing = !isEditing;
        
        // Toggle input fields
        inputs.forEach(input => {
            input.disabled = !isEditing;
            if (isEditing) {
                input.value = ''; // Clear password fields when editing
            } else {
                input.value = '••••••••'; // Reset to placeholder when not editing
            }
        });

        // Toggle buttons
        saveBtn.style.display = isEditing ? 'flex' : 'none';
        editBtn.innerHTML = isEditing ? 
            '<i class="fas fa-times"></i> Cancel' : 
            '<i class="fas fa-edit"></i> Edit Security';

        // Show notification
        if (isEditing) {
            iziToast.info({
                title: 'Edit Mode',
                message: 'You can now change your password',
                position: 'topRight'
            });
        }
    });

    // Handle form submission
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        
        // Validate password fields
        const newPass = form.querySelector('#newPassword').value;
        const confirmPass = form.querySelector('#confirmPassword').value;

        if (newPass !== confirmPass) {
            iziToast.error({
                title: 'Error',
                message: 'New passwords do not match',
                position: 'topRight'
            });
            return;
        }

        // Here you would typically send the data to your server
        // For demonstration, we'll just show a success message
        
        // Reset form state
        isEditing = false;
        inputs.forEach(input => {
            input.disabled = true;
            input.value = '••••••••';
        });
        saveBtn.style.display = 'none';
        editBtn.innerHTML = '<i class="fas fa-edit"></i> Edit Security';

        // Show success notification
        iziToast.success({
            title: 'Success',
            message: 'Password updated successfully',
            position: 'topRight'
        });
    });
}

// Function to initialize Notification Settings
function initializeNotificationSettings() {
    const form = document.querySelector('.notification-form');
    const toggleInputs = form.querySelectorAll('input[type="checkbox"]');

    // Handle toggle changes
    toggleInputs.forEach(input => {
        input.addEventListener('change', () => {
            const settingName = input.nextElementSibling.nextElementSibling.textContent;
            const state = input.checked ? 'enabled' : 'disabled';
            
            // Show notification
            iziToast.info({
                title: 'Notification Setting',
                message: `${settingName} has been ${state}`,
                position: 'topRight'
            });
        });
    });

    // Handle form submission
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        
        // Here you would typically send the data to your server
        // For demonstration, we'll just show a success message
        
        // Show success notification
        iziToast.success({
            title: 'Success',
            message: 'Notification preferences saved successfully',
            position: 'topRight'
        });
    });
}

      document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("reservation-item-form");

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        const isLoggedIn = sessionStorage.getItem("loggedIn");

        if (isLoggedIn) {
            iziToast.success({
                title: "Berhasil!",
                message: "Reservasi Anda sedang diproses.",
                position: "topRight",
                timeout: 3000,
                onClosing: function () {
                    // Simulasi pengiriman data reservasi ke halaman admin
                    const reservasiData = {
                        nama: document.getElementById("table_name").value,
                        jumlahOrang: document.getElementById("table_capacity").value,
                        tanggalWaktu: document.getElementById("order_date").value,
                        pesanan: document.getElementById("order").value,
                    };

                    // Simpan data ke localStorage sementara (simulasi)
                    localStorage.setItem("reservasiData", JSON.stringify(reservasiData));
                    window.location.href = "admin/reservation.php";
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

    // Fungsi logout otomatis setelah 2 menit
    setTimeout(() => {
        sessionStorage.removeItem("loggedIn");
    }, 120000); // 2 menit dalam milidetik
});

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