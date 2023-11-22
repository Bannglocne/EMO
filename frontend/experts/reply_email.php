<?php
include("../base/check_session.php");
include("../base/connect_data.php")

$msg = "";
// Kiểm tra xem có dữ liệu được gửi từ form trả lời hay không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["email_id"]) && isset($_POST["reply_content"])) {
        $email_id = $_POST["email_id"];
        $reply_content = $_POST["reply_content"];

        // Thêm thông tin thư trả lời vào bảng "emails"
        $sql_insert_reply = "UPDATE emails SET reply_content = '$reply_content' WHERE id = '$email_id'";
        mysqli_query($conn,$sql_insert_reply);
        $stmt_insert_reply = $conn->prepare($sql_insert_reply);

        if ($stmt_insert_reply->execute()) {
            $msg = "Thư trả lời đã được gửi thành công!";
            header("Location: expert_page.php?msg='$msg'");
        } else {
            $msg = "Đã xảy ra lỗi. Vui lòng thử lại!";
            header("Location: expert_page.php?msg='$msg'");
        }

        // Đóng câu lệnh Prepared Statement
        $stmt_insert_reply->close();
    } else {
        $msg = "Dữ liệu không hợp lệ!";
        header("Location: expert_page.php?msg='$msg'");
    }
} else {
    $msg = "Yêu cầu không hợp lệ!";
    header("Location: expert_page.php?msg='$msg'");
}

// Đóng kết nối
$conn->close();
?>