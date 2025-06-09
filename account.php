<?php
session_start();

// Redirect jika belum login
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || !isset($_SESSION['user']['id'])) {
    header("Location: login-register.php");
    exit;
}

// Sertakan file koneksi database
require_once 'configdb.php';

// Ambil ID user dari session
$user_id = $_SESSION['user']['id'];

// Ambil data user dari database
$stmt = $conn->prepare("SELECT username, full_name, email, phone_number, gender, address, profile_picture, role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_db = $result->fetch_assoc();
$stmt->close();
$conn->close(); // Tutup koneksi setelah mendapatkan data

// Fallback jika data tidak ditemukan (seharusnya tidak terjadi jika user sudah login)
if (!$user_db) {
    session_unset();
    session_destroy();
    header("Location: login-register.php");
    exit;
}

// Gunakan data dari database, jika ada. Ini akan memastikan data di session paling up-to-date
// array_merge akan menimpa nilai dari $_SESSION['user'] dengan nilai dari $user_db jika ada kunci yang sama
$user = array_merge($_SESSION['user'], $user_db);

// Tentukan foto profil berdasarkan data dari database. Pastikan path benar.
$profileImage = $user['profile_picture'] ?? 'uploads/profile/default.jpg'; // Path relatif dari root proyek
// Logika penyesuaian path untuk tampilan di browser jika diperlukan
// Perhatikan bahwa di sini kita hanya menggunakan path yang sudah ada di DB.
// Path default di DB adalah 'uploads/profile/default.jpg'
// Path upload baru adalah 'uploads/profiles/nama_file_unik.jpg'
// Keduanya relatif dari root aplikasi, jadi langsung bisa digunakan.


require_once 'views/header-account.php';
require_once 'views/navbar-account.php';
require_once 'views/sidebar-account.php';
require_once 'views/alerts-land-page.php';
?>

  <main class="main-content">
    <div class="content-header">
        <h1>Akun Saya</h1>
    </div>

    <section class="account-section">
        <div class="section-header">
            <h2>Informasi Pribadi</h2>
            <button class="btn edit-info-btn" id="editPersonalInfo">
                <i class="fas fa-edit"></i> Edit Informasi
            </button>
        </div>
        
        <div class="account-info-container">
            <div class="profile-image-container">
                <img src="<?= htmlspecialchars($profileImage) ?>" alt="Profile Picture" class="account-profile-image">
                <div class="image-upload-overlay" style="display: none;">
                    <label for="profileImageInput" class="upload-label">
                        <i class="fas fa-camera"></i>
                        <span>Ubah Foto</span>
                    </label>
                    <input type="file" id="profileImageInput" name="profile_picture" accept="image/*" style="display: none;">
                </div>
            </div>

            <form class="personal-info-form" id="personalInfoForm" action="Proses/process_customer_profile_update.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="fullName">Nama Lengkap</label>
                  <input type="text" id="fullName" name="full_name" disabled 
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
                    <input type="tel" id="phone" name="phone_number" disabled 
                           value="<?= htmlspecialchars($user['phone_number'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="gender" value="male" disabled 
                                <?= ($user['gender'] ?? '') === 'male' ? 'checked' : '' ?>>
                            <span>Laki-laki</span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="gender" value="female" disabled
                                <?= ($user['gender'] ?? '') === 'female' ? 'checked' : '' ?>>
                            <span>Perempuan</span>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address">Alamat</label>
                    <textarea id="address" name="address" disabled><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                </div>

                <button type="submit" class="btn save-btn" style="display: none;">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </form>
        </div>
    </section>

    <section class="account-section">
        <div class="section-header">
            <h2>Pengaturan Keamanan</h2>
            <button class="btn edit-info-btn" id="editSecurityInfo">
                <i class="fas fa-edit"></i> Edit Keamanan
            </button>
        </div>

        <form class="security-form" id="securityForm" action="pages/update_pass.php" method="POST">
            <div class="form-group">
                <label for="currentPassword">Password Saat Ini</label>
                <input type="password" id="currentPassword" name="current_password" disabled placeholder="••••••••">
            </div>
            
            <div class="form-group">
                <label for="newPassword">Password Baru</label>
                <input type="password" id="newPassword" name="new_password" disabled placeholder="••••••••">
            </div>
            
            <div class="form-group">
                <label for="confirmPassword">Konfirmasi Password Baru</label>
                <input type="password" id="confirmPassword" name="confirm_password" disabled placeholder="••••••••">
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
// Fungsi untuk memuat data user (data sudah di-render oleh PHP)
function loadUserData() {
    // Data sudah di-render oleh PHP di atribut `value` input
    // Fungsi ini hanya memastikan elemen-elemen form terisi dengan nilai awal yang benar dari PHP
    const form = document.getElementById('personalInfoForm');
    const inputs = form.querySelectorAll('input:not([type="file"]), textarea, select');
    const radios = form.querySelectorAll('input[type="radio"]');

    // Cukup pastikan semua input dalam keadaan disabled secara default
    inputs.forEach(input => {
        input.disabled = true;
    });
    radios.forEach(radio => {
        radio.disabled = true;
    });
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

    // Check for success or error messages from PHP
    <?php if (isset($_SESSION['success_message'])): ?>
        iziToast.success({
            title: 'Berhasil',
            message: '<?= $_SESSION['success_message'] ?>',
            position: 'topRight'
        });
        <?php unset($_SESSION['success_message']); // Hapus pesan setelah ditampilkan ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        iziToast.error({
            title: 'Error',
            message: '<?= $_SESSION['error_message'] ?>',
            position: 'topRight'
        });
        <?php unset($_SESSION['error_message']); // Hapus pesan setelah ditampilkan ?>
    <?php endif; ?>
});

// Fungsi untuk memperbarui menu sidebar aktif
function updateActiveSidebarMenu() {
    const currentPage = window.location.pathname.split('/').pop();
    
    document.querySelectorAll('.sidebar-menu a').forEach(item => {
        const itemPage = item.getAttribute('href');
        item.classList.remove('active');
        
        // Memeriksa jika href item cocok dengan halaman saat ini atau jika itemPage adalah 'account.php'
        if (itemPage === currentPage || (itemPage.includes('account.php') && currentPage === 'account.php')) {
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

        // Username input should always be disabled for security reasons
        document.getElementById('username').disabled = true;

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

    // Form submission is now handled by PHP via action attribute
    form.addEventListener('submit', (e) => {
        // Show loading message when submitting
        iziToast.info({
            title: 'Memproses',
            message: 'Menyimpan perubahan...',
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
                    message: 'Foto profil berhasil diperbarui (akan tersimpan setelah Anda menekan "Simpan Perubahan")',
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

    // Form submission is now handled by PHP via action attribute
    form.addEventListener('submit', (e) => {
        // Client-side validation
        const currentPass = form.querySelector('#currentPassword').value;
        const newPass = form.querySelector('#newPassword').value;
        const confirmPass = form.querySelector('#confirmPassword').value;

        if (!currentPass || !newPass || !confirmPass) {
            iziToast.error({
                title: 'Error',
                message: 'Semua field password harus diisi',
                position: 'topRight'
            });
            e.preventDefault(); // Prevent form submission
            return;
        }

        if (newPass !== confirmPass) {
            iziToast.error({
                title: 'Error',
                message: 'Password baru tidak cocok',
                position: 'topRight'
            });
            e.preventDefault(); // Prevent form submission
            return;
        }

        // If validation passes, let the form submit
        iziToast.info({
            title: 'Memproses',
            message: 'Mengubah password...',
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
    <?php
    require_once 'views/footer-land-page.php';
    ?>