<?php
include("../base/check_session.php");
include("../base/connect_data.php")

// Kiểm tra xem có dữ liệu được gửi từ form soạn thư hay không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (isset($_POST["recipient_name"]) && isset($_POST["title"]) && isset($_POST["content"])) {
        $recipient_name = $_POST["recipient_name"];
        $title = $_POST["title"];
        $content = $_POST["content"];
        $_SESSION['tt_letter']= $title;
        $_SESSION['cnt_letter']= $content;

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
