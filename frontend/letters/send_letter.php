<?php
// Gọi session_start() để bắt đầu phiên làm việc
session_start();
$msg_mail = "";
// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION["user_id"])) {
    // Nếu không có phiên làm việc, chuyển hướng người dùng đến trang đăng nhập
    header("Location: ../accounts/login.php");
    exit();
}

// Kiểm tra xem người dùng có vai trò là người dùng thường hay không
if ($_SESSION["role"] !== 'user') {
    // Nếu không phải người dùng thường, chuyển hướng về trang chính
    header("Location: ../experts/expert_page.php");
    exit();
}

$servername = "localhost";
$username = "emo";
$password = "123456EmoR2";
$dbname = "emo";

// Kiểm tra xem có dữ liệu được gửi từ form soạn thư hay không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (isset($_POST["recipient_name"]) && isset($_POST["title"]) && isset($_POST["content"])) {
        $recipient_name = $_POST["recipient_name"];
        $title = $_POST["title"];
        $content = $_POST["content"];
        $_SESSION['tt_letter']= $title;
        $_SESSION['cnt_letter']= $content;
        // Kết nối đến cơ sở dữ liệu
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Kiểm tra kết nối
        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

        $sql_get_id = "SELECT * FROM users WHERE username = ?";
        $stmt_get_id = $conn->prepare($sql_get_id);
        $stmt_get_id->bind_param("s", $recipient_name);
        $stmt_get_id->execute();
        $result = $stmt_get_id->get_result();
        // Nếu có id phù hợp với tên nhận, thực hiện insert
        if ($result->num_rows > 0) {
            // Lấy ra id của tên nhận
            $row = $result->fetch_assoc();
            $recipient_id = $row['id'];
            $sql_insert_email = "INSERT INTO letters (sogui, sonhan, tieude, noidung) VALUES (?, ?, ?, ?)";
            $stmt_insert_email = $conn->prepare($sql_insert_email);
            $stmt_insert_email->bind_param("iiss", $_SESSION["user_id"], $recipient_id, $title, $content);
            // Thử gửi mail, nếu không được thì thông báo lại cho người dùng
            if ($stmt_insert_email->execute()) {
                $msg = "Thư đã được gửi thành công";
                $_SESSION['msg'] = $msg;
                header("Location: ../users/home.php");
            } else {
                $msg = "Đã xảy ra lỗi. Vui lòng thử lại!";
                $_SESSION['msg'] = $msg;
                header("Location: write_letter.php ");
            }
            // Đóng câu lệnh PreparedStatement
            $stmt_insert_email->close();
        } else {
            $msg = "Tên người nhận không tồn tại!";
            $_SESSION['msg_send_letter'] = $msg;
            header("Location: write_letter.php ");
            exit();
        }
        // Đóng kết nối
        $conn->close();
    } else {
        header("Location: ../redirect/loithu.html ");
    }
} else {
    header("Location: ../redirect/loithu.html ");
}
?>
