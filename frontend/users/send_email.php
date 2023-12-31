<?php
include("../base/check_session.php");
include("../base/connect_data.php")

// Kiểm tra xem có dữ liệu được gửi từ form soạn thư hay không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["recipient"]) && isset($_POST["title"]) && isset($_POST["content"])) {
        $recipient_id = $_POST["recipient"];
        $title = $_POST["title"];
        $content = $_POST["content"];

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