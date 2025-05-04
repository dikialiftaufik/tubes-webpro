<?php
// pages/delete_user.php
session_start();
require_once '../configdb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin') {
    $user_id = $_POST['user_id'];
    
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    
    if($stmt->execute()) {
        $_SESSION['success_message'] = "User berhasil dihapus!";
    } else {
        $_SESSION['error_message'] = "Gagal menghapus user: " . $conn->error;
    }
}

header("Location: users.php");
exit();