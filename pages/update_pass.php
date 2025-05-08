<?php
// Konversi Hash Password (hash-passwords.php)
// -------------------------------------------
// INSTRUKSI:
// 1. Simpan file ini di folder admin/ atau lokasi aman.
// 2. Backup database terlebih dahulu.
// 3. Buka file ini via browser, lalu hapus setelah selesai.

require_once '../configdb.php'; // Sesuaikan path

echo "<h3>Konversi Password ke Hash</h3>";

// 1. Ambil semua data pengguna dengan password plaintext
$query = "SELECT id, password FROM users";
$result = $conn->query($query);

if ($result->num_rows === 0) {
    die("Tidak ada data pengguna.");
}

$total_updated = 0;
$errors = [];

// 2. Loop setiap pengguna dan hash password
while ($row = $result->fetch_assoc()) {
    $user_id = $row['id'];
    $plain_password = $row['password'];

    // Skip jika password sudah di-hash
    if (password_needs_rehash($plain_password, PASSWORD_DEFAULT)) {
        // Hash password
        $hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

        // Update ke database
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashed_password, $user_id);

        if ($stmt->execute()) {
            $total_updated++;
        } else {
            $errors[] = "Gagal update user ID $user_id: " . $stmt->error;
        }

        $stmt->close();
    }
}

// 3. Tampilkan hasil
echo "<p>Total password diupdate: $total_updated</p>";

if (!empty($errors)) {
    echo "<h4>Error:</h4>";
    foreach ($errors as $error) {
        echo "<p>$error</p>";
    }
}

echo "<p>Proses selesai. Hapus file ini!</p>";

$conn->close();
?>