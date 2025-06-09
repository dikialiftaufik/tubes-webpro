<?php
session_start();
include '../configdb.php'; // Path ini sudah benar relatif terhadap Proses/

if (isset($_POST['update_profile'])) {
    // Gunakan $_SESSION['user']['id'] sesuai dengan account.php
    $user_id = $_SESSION['user']['id'] ?? null; 
    if (!$user_id) {
        // Handle case where user is not logged in or session is expired
        $_SESSION['error_message'] = "Sesi Anda telah berakhir, silakan login kembali.";
        header("Location: ../login-register.php"); 
        exit();
    }

    // Ambil data dari form POST, sesuaikan dengan nama 'name' di account.php
    $full_name = $_POST['full_name'] ?? '';
    $username = $_POST['username'] ?? ''; // Asumsi username tidak diubah karena disabled di form
    $email = $_POST['email'] ?? '';
    $phone_number = $_POST['phone_number'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $address = $_POST['address'] ?? '';

    $profile_picture_path = null;

    // Inisialisasi default path jika tidak ada update gambar atau gambar yang ada adalah default
    $current_profile_picture_db = null;

    // Dapatkan path gambar profil yang ada saat ini dari database
    $stmt_select_current_pic = $conn->prepare("SELECT profile_picture FROM users WHERE id = ?");
    $stmt_select_current_pic->bind_param("i", $user_id);
    $stmt_select_current_pic->execute();
    $result_current_pic = $stmt_select_current_pic->get_result();
    if ($result_current_pic->num_rows > 0) {
        $row_current_pic = $result_current_pic->fetch_assoc();
        $current_profile_picture_db = $row_current_pic['profile_picture'];
    }
    $stmt_select_current_pic->close();

    // Jika ada file gambar baru diupload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../uploads/profile/"; // WAJIB: Gunakan struktur folder yang sudah ada
        $file_extension = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));
        // Validasi ekstensi file (opsional, tapi disarankan)
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($file_extension, $allowed_extensions)) {
            $_SESSION['error_message'] = "Format file gambar tidak diizinkan. Hanya JPG, JPEG, PNG, dan GIF.";
            header("Location: ../account.php");
            exit();
        }

        $new_file_name = uniqid('profile_') . '.' . $file_extension; // Generate unique filename
        $target_file = $target_dir . $new_file_name;
        $profile_picture_path = 'uploads/profile/' . $new_file_name; // Path untuk disimpan di DB

        // Buat direktori jika belum ada
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Pastikan izin tulis
        }

        // Pindahkan file yang diupload
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
            // File berhasil diupload
            // Hapus gambar lama jika ada dan bukan default.jpg
            if ($current_profile_picture_db && $current_profile_picture_db !== 'uploads/profile/default.jpg' && file_exists("../" . $current_profile_picture_db)) {
                unlink("../" . $current_profile_picture_db); // Hapus file lama
            }
        } else {
            // Gagal memindahkan file
            $_SESSION['error_message'] = "Gagal mengunggah foto profil. Terjadi kesalahan saat memindahkan file.";
            header("Location: ../account.php");
            exit();
        }
    } else {
        // Jika tidak ada file baru diupload, gunakan path gambar profil yang ada di DB
        $profile_picture_path = $current_profile_picture_db;
    }

    // Siapkan query UPDATE
    // Pastikan nama kolom sesuai dengan database Anda: full_name, username, email, phone_number, gender, address, profile_picture
    $update_sql = "UPDATE users SET full_name = ?, email = ?, phone_number = ?, gender = ?, address = ?, profile_picture = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    // Tipe parameter: s (string) untuk full_name, email, phone_number, gender, address, profile_picture; i (integer) untuk id
    $stmt->bind_param("ssssssi", $full_name, $email, $phone_number, $gender, $address, $profile_picture_path, $user_id);
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Profil berhasil diperbarui.";
        // Update data user di sesi agar langsung tercermin di navbar dan halaman lain
        $_SESSION['user']['full_name'] = $full_name;
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['phone_number'] = $phone_number;
        $_SESSION['user']['gender'] = $gender;
        $_SESSION['user']['address'] = $address;
        
        // Update profile_picture di sesi hanya jika ada gambar baru diupload atau jika memang ada perubahan path
        if ($profile_picture_path) {
            $_SESSION['user']['profile_picture'] = $profile_picture_path;
        }
    } else {
        $_SESSION['error_message'] = "Gagal memperbarui profil: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: ../account.php");
    exit();
}
?>