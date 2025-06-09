<?php
session_start();
require_once '../configdb.php'; // Sesuaikan path jika perlu

// Pastikan user sudah login dan memiliki peran 'customer'
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || !isset($_SESSION['user']['id']) || ($_SESSION['user']['role'] ?? 'customer') !== 'customer') {
    $_SESSION['error_message'] = "Akses tidak sah.";
    header("Location: ../login-register.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user']['id']; // Ambil ID user dari session
    
    // Ambil data yang dikirimkan dari form, gunakan operator null coalescing untuk default value
    $full_name = $_POST['full_name'] ?? ''; 
    $email = $_POST['email'] ?? '';
    $phone_number = $_POST['phone_number'] ?? NULL;
    $address = $_POST['address'] ?? NULL;
    $gender = $_POST['gender'] ?? NULL;
    
    // Inisialisasi profile_picture dengan nilai saat ini dari session/database
    // Ini penting agar jika tidak ada upload foto baru, path yang lama tetap digunakan
    $profile_picture = $_SESSION['user']['profile_picture'] ?? 'uploads/profile/default.jpg'; 

    // Handle file upload untuk foto profil
    // Pastikan bahwa ada file yang diunggah dan tidak ada error
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/profiles/'; // Path relatif dari Proses/ (misal: 'Proses/' ada di root, maka '../uploads/profiles/' menunjuk ke 'uploads/profiles/' di root)
        
        // Buat direktori jika belum ada
        if (!is_dir($upload_dir)) {
            // Coba buat dengan izin penuh (0777) - PERHATIKAN KEAMANAN: di lingkungan produksi, pertimbangkan 0755
            if (!mkdir($upload_dir, 0777, true)) { 
                $_SESSION['error_message'] = "Gagal membuat direktori upload. Periksa izin server pada folder 'uploads/'.";
                header("Location: ../account.php");
                exit();
            }
        }
        
        $file_tmp_name = $_FILES['profile_picture']['tmp_name'];
        $file_name_original = basename($_FILES['profile_picture']['name']);
        $file_ext = strtolower(pathinfo($file_name_original, PATHINFO_EXTENSION));
        // Buat nama file unik untuk menghindari konflik nama dan caching
        $unique_file_name = time() . '_' . uniqid() . '.' . $file_ext; 
        $target_path = $upload_dir . $unique_file_name;
        
        // Periksa tipe file yang diizinkan (misal: gambar)
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($file_ext, $allowed_ext)) {
            $_SESSION['error_message'] = "Format file tidak didukung. Hanya JPG, JPEG, PNG, GIF yang diizinkan.";
            header("Location: ../account.php");
            exit();
        }

        // Pindahkan file yang diunggah dari direktori temporer ke direktori tujuan
        if (move_uploaded_file($file_tmp_name, $target_path)) {
            // Jika berhasil dipindahkan, update path foto profil ke path baru
            $profile_picture = 'uploads/profiles/' . $unique_file_name; // Simpan path relatif dari root aplikasi untuk database
            
            // Hapus foto profil lama jika bukan default dan ada di path yang benar
            // Penting: Pastikan path lama yang akan dihapus juga relatif terhadap lokasi file ini (Proses/)
            $old_profile_picture_db_path = $_SESSION['user']['profile_picture'] ?? ''; // Ambil path lama dari session
            if ($old_profile_picture_db_path !== 'uploads/profile/default.jpg' && !empty($old_profile_picture_db_path)) {
                $old_file_to_delete = '../' . $old_profile_picture_db_path; // Menyesuaikan path untuk penghapusan dari Proses/
                if (file_exists($old_file_to_delete) && is_file($old_file_to_delete)) {
                    unlink($old_file_to_delete); // Hapus file lama
                }
            }
        } else {
            // Jika move_uploaded_file gagal, berikan pesan error yang lebih spesifik
            $error_code = $_FILES['profile_picture']['error'];
            $error_message = "Gagal mengunggah foto profil. Kode error: " . $error_code;
            switch ($error_code) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $error_message .= " (Ukuran file terlalu besar dari batas PHP atau form).";
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $error_message .= " (File hanya terunggah sebagian).";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $error_message .= " (Tidak ada file yang diunggah).";
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $error_message .= " (Direktori temporer tidak ditemukan).";
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $error_message .= " (Gagal menulis file ke disk. Periksa izin folder 'uploads/profiles/').";
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $error_message .= " (Ekstensi PHP menghentikan unggahan file).";
                    break;
                default:
                    $error_message .= " (Error tidak diketahui, mungkin izin folder tidak tepat).";
            }
            $_SESSION['error_message'] = $error_message;
            header("Location: ../account.php");
            exit();
        }
    }
    
    // Perbarui data pengguna di database
    // Gunakan koneksi dari configdb.php
    $query = "UPDATE users SET 
        full_name = ?,
        email = ?,
        phone_number = ?,
        address = ?,
        gender = ?,
        profile_picture = ?,
        updated_at = CURRENT_TIMESTAMP
        WHERE id = ?";
        
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        $_SESSION['error_message'] = "Terjadi kesalahan dalam mempersiapkan query: " . $conn->error;
        header("Location: ../account.php");
        exit();
    }

    $stmt->bind_param("ssssssi",
        $full_name,
        $email,
        $phone_number,
        $address,
        $gender,
        $profile_picture, // Variabel ini sudah berisi path baru jika diunggah, atau path yang lama
        $user_id
    );
    
    if ($stmt->execute()) {
        // Jika pembaruan database berhasil, perbarui juga data di session
        // Ambil data terbaru dari database untuk memastikan session up-to-date dan konsisten
        $stmt_select = $conn->prepare("SELECT id, role, username, full_name, email, phone_number, gender, address, profile_picture FROM users WHERE id = ?");
        $stmt_select->bind_param("i", $user_id);
        $stmt_select->execute();
        $result_select = $stmt_select->get_result();
        $updated_user_data = $result_select->fetch_assoc();
        $stmt_select->close();

        if ($updated_user_data) {
            $_SESSION['user'] = $updated_user_data; // Timpa seluruh data user di session
        } else {
            $_SESSION['error_message'] = "Profil berhasil diperbarui, tetapi gagal memuat ulang data session.";
        }
        
        $_SESSION['success_message'] = "Profil berhasil diperbarui!";
    } else {
        $_SESSION['error_message'] = "Gagal memperbarui profil: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();

    // Redirect kembali ke halaman akun
    header("Location: ../account.php");
    exit();

} else {
    // Jika diakses langsung tanpa POST request, redirect kembali ke halaman akun
    header("Location: ../account.php");
    exit();
}
?>