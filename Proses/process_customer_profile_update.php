<?php
session_start();
require_once '../configdb.php';

// Pastikan user sudah login dan memiliki peran 'customer'
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || !isset($_SESSION['user']['id']) || ($_SESSION['user']['role'] ?? 'customer') !== 'customer') {
    $_SESSION['error_message'] = "Akses tidak sah.";
    header("Location: ../login-register.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user']['id'];
    
    // Ambil dan validasi data input
    $full_name = trim($_POST['full_name'] ?? ''); 
    $email = trim($_POST['email'] ?? '');
    $phone_number = !empty($_POST['phone_number']) ? trim($_POST['phone_number']) : NULL;
    $address = !empty($_POST['address']) ? trim($_POST['address']) : NULL;
    $gender = !empty($_POST['gender']) ? $_POST['gender'] : NULL;
    
    // Validasi input wajib
    if (empty($full_name)) {
        $_SESSION['error_message'] = "Nama lengkap tidak boleh kosong.";
        header("Location: ../account.php");
        exit();
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Email tidak valid.";
        header("Location: ../account.php");
        exit();
    }

    // Validasi phone number jika diisi
    if (!empty($phone_number) && !preg_match('/^[0-9+\-\s()]+$/', $phone_number)) {
        $_SESSION['error_message'] = "Format nomor telepon tidak valid.";
        header("Location: ../account.php");
        exit();
    }

    // Validasi gender jika diisi
    if (!empty($gender) && !in_array($gender, ['male', 'female'])) {
        $_SESSION['error_message'] = "Jenis kelamin tidak valid.";
        header("Location: ../account.php");
        exit();
    }

    // Cek email duplikat
    $email_check = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $email_check->bind_param("si", $email, $user_id);
    $email_check->execute();
    $email_result = $email_check->get_result();

    if ($email_result->num_rows > 0) {
        $_SESSION['error_message'] = "Email sudah digunakan oleh pengguna lain.";
        $email_check->close();
        header("Location: ../account.php");
        exit();
    }
    $email_check->close();
    
    // Inisialisasi profile_picture dengan nilai saat ini - PERBAIKAN PATH
    $profile_picture = $_SESSION['user']['profile_picture'] ?? 'uploads/profiles/default.jpg'; 

    // Handle file upload untuk foto profil
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/profiles/';
        
        // Buat direktori jika belum ada
        if (!is_dir($upload_dir)) {
            if (!mkdir($upload_dir, 0755, true)) { // PERBAIKAN: gunakan 0755 untuk keamanan
                $_SESSION['error_message'] = "Gagal membuat direktori upload.";
                header("Location: ../account.php");
                exit();
            }
        }
        
        // Validasi ukuran file - TAMBAHAN
        $max_file_size = 5 * 1024 * 1024; // 5MB
        if ($_FILES['profile_picture']['size'] > $max_file_size) {
            $_SESSION['error_message'] = "Ukuran file terlalu besar. Maksimal 5MB.";
            header("Location: ../account.php");
            exit();
        }
        
        $file_tmp_name = $_FILES['profile_picture']['tmp_name'];
        $file_name_original = basename($_FILES['profile_picture']['name']);
        $file_ext = strtolower(pathinfo($file_name_original, PATHINFO_EXTENSION));
        $unique_file_name = time() . '_' . uniqid() . '.' . $file_ext; 
        $target_path = $upload_dir . $unique_file_name;
        
        // Periksa tipe file yang diizinkan
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        $allowed_mime = ['image/jpeg', 'image/png', 'image/gif']; // TAMBAHAN: validasi MIME type
        
        if (!in_array($file_ext, $allowed_ext)) {
            $_SESSION['error_message'] = "Format file tidak didukung. Hanya JPG, JPEG, PNG, GIF yang diizinkan.";
            header("Location: ../account.php");
            exit();
        }

        // TAMBAHAN: Validasi MIME type untuk keamanan ekstra
        $file_mime = mime_content_type($file_tmp_name);
        if (!in_array($file_mime, $allowed_mime)) {
            $_SESSION['error_message'] = "Tipe file tidak valid.";
            header("Location: ../account.php");
            exit();
        }

        // Pindahkan file
        if (move_uploaded_file($file_tmp_name, $target_path)) {
            $profile_picture = 'uploads/profiles/' . $unique_file_name;
            
            // Hapus foto profil lama
            $old_profile_picture_db_path = $_SESSION['user']['profile_picture'] ?? '';
            if ($old_profile_picture_db_path !== 'uploads/profiles/default.jpg' && !empty($old_profile_picture_db_path)) {
                $old_file_to_delete = '../' . $old_profile_picture_db_path;
                if (file_exists($old_file_to_delete) && is_file($old_file_to_delete)) {
                    unlink($old_file_to_delete);
                }
            }
        } else {
            $_SESSION['error_message'] = "Gagal mengunggah foto profil. Periksa izin folder.";
            header("Location: ../account.php");
            exit();
        }
    } elseif (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] != UPLOAD_ERR_NO_FILE) {
        // PERBAIKAN: Handle upload errors yang lain
        $_SESSION['error_message'] = "Error saat upload file. Kode error: " . $_FILES['profile_picture']['error'];
        header("Location: ../account.php");
        exit();
    }
    
    // Update database
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
        $profile_picture,
        $user_id
    );
    
    if ($stmt->execute()) {
        // Update session dengan data terbaru
        $stmt_select = $conn->prepare("SELECT id, role, username, full_name, email, phone_number, gender, address, profile_picture FROM users WHERE id = ?");
        $stmt_select->bind_param("i", $user_id);
        $stmt_select->execute();
        $result_select = $stmt_select->get_result();
        $updated_user_data = $result_select->fetch_assoc();
        $stmt_select->close();

        if ($updated_user_data) {
            $_SESSION['user'] = $updated_user_data;
        }
        
        $_SESSION['success_message'] = "Profil berhasil diperbarui!";
    } else {
        $_SESSION['error_message'] = "Gagal memperbarui profil: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();

    header("Location: ../account.php");
    exit();

} else {
    header("Location: ../account.php");
    exit();
}
?>