<?php
// configdb.php
$host = "localhost";
$user = "root"; 
$password = ""; // Sesuaikan dengan password MySQL Anda
$database = "bolooo"; // Sesuaikan dengan nama database

// Membuat koneksi
$conn = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8mb4");
?>