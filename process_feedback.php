<?php
// process_feedback.php
session_start();
require_once 'configdb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])) {
    // Ambil data dari form dan session
    $user_id = $_SESSION['user']['id'];
    $tgl_masukan = date('Y-m-d H:i:s');
    $judul_masukan = mysqli_real_escape_string($conn, $_POST['judul_masukan']);
    $pesan_masukan = mysqli_real_escape_string($conn, $_POST['pesan_masukan']);

    // Validasi input
    if (empty($judul_masukan) || empty($pesan_masukan)) {
        $_SESSION['error'] = "Judul dan pesan masukan harus diisi";
        header("Location: feedback_form.php");
        exit();
    }

    // Insert ke database
    $stmt = $conn->prepare("INSERT INTO feedback (user_id, tgl_masukan, judul_masukan, pesan_masukan) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $user_id, $tgl_masukan, $judul_masukan, $pesan_masukan);

    if ($stmt->execute()) {
        $_SESSION['feedback_success'] = true;
    } else {
        $_SESSION['feedback_error'] = "Gagal mengirim masukan: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: saran.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}
?>