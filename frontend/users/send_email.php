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

// Kiểm tra xem có dữ liệu được gửi từ form soạn thư hay không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["recipient"]) && isset($_POST["title"]) && isset($_POST["content"])) {
        $recipient_id = $_POST["recipient"];
        $title = $_POST["title"];
        $content = $_POST["content"];

        // Kết nối đến cơ sở dữ liệu (chú ý thay đổi thông tin kết nối phù hợp với máy bạn)
        $servername = "localhost";
        $username = "emo";
        $password = "123456EmoR2";
        $dbname = "emo";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Kiểm tra kết nối
        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

        // Kiểm tra xem người dùng có soạn quá 2 bức thư một tháng hay không
        $sql_count_emails = "SELECT COUNT(*) AS total_emails FROM emails WHERE sender_id = ?";
        $stmt_count_emails = $conn->prepare($sql_count_emails);
        $stmt_count_emails->bind_param("i", $_SESSION["user_id"]);
        $stmt_count_emails->execute();
        $result_count_emails = $stmt_count_emails->get_result();
        $row_count_emails = $result_count_emails->fetch_assoc();
        $total_emails = $row_count_emails["total_emails"];

        // Kiểm tra xem người dùng có viết quá 500 từ trong một bức thư hay không
        $word_count = strlen($content);
        $msg="";
        // Nếu người dùng đã soạn quá 2 bức thư một tháng hoặc đã viết quá 500 từ trong một bức thư, thì chuyển hướng người dùng đến trang báo lỗi
        if ($total_emails >= 2) {
            $msg = "Bạn không được gửi quá 2 bức thư mỗi tháng!";
            $_SESSION['msg_mail']=$msg;
            header("Location: view_reply.php");
            exit();
        }elseif ($word_count > 500){
            $msg = "Số từ trong thư của bạn không được quá 500 từ!";
            $_SESSION['msg_mail_tu']=$msg;
            $_SESSION['title_send_mail'] = $title;
            $_SESSION['content_send_mail']=$content;
            header("Location: compose.php");
            exit();
        }

        // Thêm thông tin thư vào bảng "emails"
        $sql_insert_email = "INSERT INTO emails (sender_id, receiver_id, title, content) VALUES (?, ?, ?, ?)";
        $stmt_insert_email = $conn->prepare($sql_insert_email);
        $stmt_insert_email->bind_param("iiss", $_SESSION["user_id"], $recipient_id, $title, $content);

        if ($stmt_insert_email->execute()) {
            $msg_mail = "Thư đã được gửi thành công";
            $_SESSION['msg'] = $msg_mail;
            header("Location: home.php");
        } else {
            $msg_mail = "Đã xảy ra lỗi. Vui lòng thử lại!";
            $_SESSION['msg'] = $msg;
            header("Location: compose.php ");
        }

        // Đóng câu lệnh Prepared Statement
        $stmt_insert_email->close();

        // Đóng kết nối
        $conn->close();
    } else {
        header("Location: ../redirect/loithu.html ");
    }
} else {
    header("Location: ../redirect/loithu.html ");
}
?>