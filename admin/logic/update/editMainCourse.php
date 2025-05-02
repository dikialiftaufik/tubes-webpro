<!-- File: admin/logic/update/editMainCourse.php -->
<?php
require_once '../../../configdb.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $calories = mysqli_real_escape_string($conn, $_POST['calories']);
    $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    
    // Jika ada gambar baru diupload
    if(!empty($_FILES["image"]["name"])) {
        $targetDir = "../../../img/main-course/";
        $fileName = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath);
        $imageUpdate = ", image_url = '$fileName'";
    } else {
        $imageUpdate = "";
    }
    
    $query = "UPDATE menu SET 
              name = '$name', 
              price = $price, 
              calories = $calories, 
              ingredients = '$ingredients', 
              description = '$description' 
              $imageUpdate 
              WHERE id = $id";
    
    if(mysqli_query($conn, $query)) {
        header("Location: ../../mainCourse.php?success=1");
    } else {
        header("Location: ../../mainCourse.php?error=" . urlencode(mysqli_error($conn)));
    }
}
?>