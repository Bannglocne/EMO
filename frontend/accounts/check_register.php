<?php
session_start();
// Kết nối đến cơ sở dữ liệu (chú ý thay đổi thông tin kết nối phù hợp với máy bạn)
$servername = "localhost";
$username = "emo";
$password = "123456EmoR2";
$dbname = "emo";

$error = "";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $conpwd = $_POST["confirmPassword"];
    $_SESSION['username_rig'] = $username;
    $_SESSION['email_rig'] = $email;
    $_SESSION['password_rig'] = $password;
    $_SESSION['conpwd_rig'] = $conpwd;


    // Kiểm tra xem tên đăng nhập đã tồn tại chưa
    $sql_check_username = "SELECT id FROM users WHERE username=?";
    $stmt_check_username = $conn->prepare($sql_check_username);
    $stmt_check_username->bind_param("s", $username);
    $stmt_check_username->execute();
    $result_check_username = $stmt_check_username->get_result();

    // Kiểm tra xem email đã tồn tại chưa
    $sql_check_email = "SELECT id FROM users WHERE email=?";
    $stmt_check_email = $conn->prepare($sql_check_email);
    $stmt_check_email->bind_param("s", $email);
    $stmt_check_email->execute();
    $result_check_email = $stmt_check_email->get_result();

    if ($result_check_username->num_rows > 0) {
        $error = "Tên đăng nhập đã tồn tại. Vui lòng thử lại!\n";
        $_SESSION["error_rig"] = $error;
        header("Location: register.php");
    } elseif ($result_check_email->num_rows > 0) {
        $error = "Email đã tồn tại. Vui lòng thử lại!\n";
        $_SESSION["error_rig"] = $error;
        header("Location: register.php");
    } elseif ($password!=$conpwd) {
        $error = "Mật khẩu không khớp. Vui lòng thử lại!\n";
        $_SESSION["error_rig"] = $error;
        header("Location: register.php");
    } else {
        // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Thêm thông tin đăng ký vào cơ sở dữ liệu
        $sql_insert = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("sss", $username, $email, $hashed_password);
        
        if ($stmt_insert->execute()) {
            echo "Đăng ký thành công!";
            // Chuyển hướng người dùng đến trang chủ với tài khoản đã đăng ký
            $_SESSION["user_id"] = $stmt_insert->insert_id; // Lấy ID của tài khoản vừa đăng ký
            $_SESSION["username"] = $username; // $username là tên đăng nhập vừa đăng ký
            $_SESSION["role"] = 'user';
            header("Location: ../users/home.php");
            exit();
        } else {
            $error = "Đã xảy ra lỗi. Vui lòng thử lại!";
            $_SESSION["error_rig"] = $error;
            header("Location: register.php");
        }
    }

    // Đóng các câu lệnh Prepared Statements
    $stmt_check_username->close();
    $stmt_check_email->close();
    $stmt_insert->close();
}

// Đóng kết nối
$conn->close();