<?php
session_start();
require_once '../configdb.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user']['id'];
    
    // Handle file upload
    $profile_picture = $_SESSION['user']['profile_picture'];
    
    if(isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/profiles/';
        if(!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        
        $file_name = time() . '_' . basename($_FILES['profile_picture']['name']);
        $target_path = $upload_dir . $file_name;
        
        if(move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_path)) {
            $profile_picture = 'uploads/profiles/' . $file_name;
        }
    }
    
    // Update data
    $query = "UPDATE users SET 
        full_name = ?,
        email = ?,
        phone_number = ?,
        address = ?,
        gender = ?,
        profile_picture = ?
        WHERE id = ?";
        
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssi",
        $_POST['full_name'],
        $_POST['email'],
        $_POST['phone_number'],
        $_POST['address'],
        $_POST['gender'],
        $profile_picture,
        $user_id
    );
    
    if($stmt->execute()) {
        // Update session data
        $_SESSION['user'] = array_merge($_SESSION['user'], [
            'full_name' => $_POST['full_name'],
            'email' => $_POST['email'],
            'phone_number' => $_POST['phone_number'],
            'address' => $_POST['address'],
            'gender' => $_POST['gender'],
            'profile_picture' => $profile_picture
        ]);
        
        $_SESSION['success_message'] = "Profil berhasil diperbarui!";
    } else {
        $_SESSION['error_message'] = "Gagal memperbarui profil: " . $conn->error;
    }
    
    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit();
}