<?php
require_once '../../../configdb.php';

// Memeriksa apakah parameter id tersedia pada URL
if(isset($_GET['id'])) {
    // Mengambil nilai id dari URL
    $id = $_GET['id'];
    
    // Menggunakan prepared statement untuk mencegah SQL injection
    $query = "DELETE FROM menu WHERE id = ?";
    
    // Menyiapkan statement
    $stmt = mysqli_prepare($conn, $query);
    
    if($stmt) {
        // Mengikat parameter ke statement
        mysqli_stmt_bind_param($stmt, "i", $id); // "i" artinya parameter bertipe integer
        
        // Mengeksekusi statement
        $result = mysqli_stmt_execute($stmt);
        
        // Menutup statement
        mysqli_stmt_close($stmt);
        
        if($result) {
            // Jika berhasil, arahkan ke halaman utama dengan pesan sukses
            header("Location: ../../mainCourse.php?success=1");
            exit;
        } else {
            // Jika gagal, arahkan ke halaman utama dengan pesan error
            $error_message = "Gagal menghapus menu: " . mysqli_error($conn);
            header("Location: ../../mainCourse.php?error=" . urlencode($error_message));
            exit;
        }
    } else {
        // Jika prepared statement gagal dibuat
        $error_message = "Gagal menyiapkan query: " . mysqli_error($conn);
        header("Location: ../../mainCourse.php?error=" . urlencode($error_message));
        exit;
    }
} else {
    // Jika parameter id tidak ditemukan
    header("Location: ../../mainCourse.php?error=" . urlencode("ID menu tidak ditemukan"));
    exit;
}
?>