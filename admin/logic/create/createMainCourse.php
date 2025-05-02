<!-- File: admin/logic/create/createMainCourse.php -->
<?php
require_once '../../../configdb.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $calories = mysqli_real_escape_string($conn, $_POST['calories']);
    $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    
    // Upload gambar
    $targetDir = "../../../img/main-course/";
    $fileName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    
    if(move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
        $query = "INSERT INTO menu (name, image_url, type, price, calories, ingredients, description) 
                 VALUES ('$name', '$fileName', 'main_course', $price, $calories, '$ingredients', '$description')";
        
        if(mysqli_query($conn, $query)) {
            header("Location: ../../mainCourse.php?success=1");
        } else {
            header("Location: ../../mainCourse.php?error=" . urlencode(mysqli_error($conn)));
        }
    } else {
        header("Location: ../../mainCourse.php?error=Gagal upload gambar");
    }
}
?>