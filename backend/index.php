<?php
// Gọi session_start() để bắt đầu phiên làm việc
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (isset($_SESSION["ma_id"])) {
    // Nếu đã đăng nhập, chuyển hướng người dùng đến trang chính hoặc trang riêng của chuyên gia
    header("Location: manager/home.php");
    exit();
} else {
    // Nếu chưa đăng nhập, chuyển hướng người dùng đến trang đăng nhập
    header("Location: accounts/login.php");
    exit();
}
?>
