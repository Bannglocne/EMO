<?php
$servername = "localhost";
$username = "emo";
$password = "123456EmoR2";
$dbname = "emo";


$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>