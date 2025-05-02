<?php
// melakukan koneksi ke mysql
$host = "localhost";
$user = "root";
$password = "";
$dbname = "bolooo";

$conn = mysqli_connect($host, $user, $password, $dbname);
if (!$conn) {
	die("Koneksi gagal: " . mysqli_connect_error());
} 
?>