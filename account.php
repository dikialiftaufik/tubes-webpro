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

require_once 'views/header-account.php';
require_once 'views/navbar-account.php';
require_once 'views/sidebar-account.php';
require_once 'views/alerts-land-page.php';
?>

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
    <!-- Footer -->
    <?php
    require_once 'views/footer-land-page.php';
    ?>