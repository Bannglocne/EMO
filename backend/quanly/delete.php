<?php
session_start();

//Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "emo";
$password = "123456EmoR2";
$dbname = "emo";
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
$id = $_GET['id'];
$sql = "DELETE FROM users WHERE id='$id';";
mysqli_query($conn,$sql);
header("Location: quanly_users.php");

$conn->close();
?>