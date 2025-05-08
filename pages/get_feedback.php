<?php
require_once '../configdb.php';
$id = (int)$_GET['id'];
$stmt = $conn->prepare("SELECT * FROM feedback WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
echo json_encode($result);
