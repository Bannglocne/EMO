<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    // Nếu không có phiên làm việc, chuyển hướng người dùng đến trang đăng nhập
    header("Location: ../accounts/login.php");
    exit();
}
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_GET['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $sql = "UPDATE users SET username='$username',email='$email', role='$role' WHERE id='$id'";
    mysqli_query($conn,$sql);
    header("Location: detail.php?id=$id");
    exit();
}
$conn->close();
?>