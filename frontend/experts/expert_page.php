<?php
session_start(); // Gọi session_start() chỉ một lần

if (!isset($_SESSION["user_id"])) {
    header("Location: ../accounts/login.html");
    exit();
}

if ($_SESSION["role"] != 'expert') {
    header("Location: ../users/home.php");
    exit();
}

$servername = "localhost";
$username = "emo";
$password = "123456EmoR2";
$dbname = "emo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

echo "<h1>Chào mừng chuyên gia " . $_SESSION["username"] . "</h1>";

// Lấy tất cả các email của chuyên gia
$sql_get_emails = "SELECT id, sender_id, title, content, timestamp, reply_content FROM emails WHERE receiver_id = ? ORDER BY timestamp DESC";
$stmt_get_emails = $conn->prepare($sql_get_emails);
$stmt_get_emails->bind_param("i", $_SESSION["user_id"]);
$stmt_get_emails->execute();
$result_get_emails = $stmt_get_emails->get_result();

// Sắp xếp các email theo thời gian
$emails = [];
while ($row = $result_get_emails->fetch_assoc()) {
    $emails[] = $row;
}

// Ẩn các email sau khi chuyên gia đã trả lời
foreach ($emails as $key => $email) {
    if ($email["reply_content"] !== null) {
        unset($emails[$key]);
    }
}

// Hiển thị danh sách các email đã nhận
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hòm thư của chuyên gia</title>
    <meta charset="utf-8">
    <script>
        function gologout(){
            if(confirm('Bạn có chắc muốn đăng xuất?'))
            {
                window.location.href = "../accounts/logout.php";
            }
        }
    </script>
    <link rel="stylesheet" href="../css/chuyengia.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&family=Quicksand:wght@400;700&family=Raleway:wght@300;900&display=swap" rel="stylesheet">
</head>
<body>
    <button id="btn-ex" onclick="gologout()">Đăng xuất</button>
    <div class = "thudanhan">
        <h2  style="margin-left: 5%">Danh sách các thư đã nhận:</h2>
    </div>

    <div class = "danhsachthu">
        <ul class = "danhsach">
            <?php
            foreach ($emails as $email) {
                $email_id = $email["id"];
                $sender_id = $email["sender_id"];
                $title = $email["title"];
                $content = $email["content"];
                $timestamp = $email["timestamp"];

                // Lấy tên người gửi thư
                $sql_get_sender_username = "SELECT username FROM users WHERE id = ?";
                $stmt_get_sender_username = $conn->prepare($sql_get_sender_username);
                $stmt_get_sender_username->bind_param("i", $sender_id);
                $stmt_get_sender_username->execute();
                $result_get_sender_username = $stmt_get_sender_username->get_result();
                $sender_username = $result_get_sender_username->fetch_assoc()["username"];
                $stmt_get_sender_username->close();
                ?>
                <li>
                    <div class = "nguoigui">
                        <strong>Người gửi:</strong> <?php echo $sender_username; ?><br>
                    </div>

                    <div class = "tieude">
                        <strong>Tiêu đề:</strong> 
                        
                        <div class = "noidungtieude">
                            <?php echo $title; ?>
                        </div>
                    </div>

                    <div class = "noidung">
                        <strong>Nội dung:</strong>
                    </div>

                    <?php echo '<p class="onhaplieu">' . nl2br($content) . '</p>'; ?>

                    <div class = "thoigian">
                        <strong>Thời gian gửi:</strong> 
                        
                        <div class = "ngaygio">
                            <?php echo $timestamp; ?><br>
                        </div>
                    </div>

                    <!-- Form trả lời thư -->
                    <form action="reply_email.php" method="post">
                        <input type="hidden" name="email_id" value="<?php echo $email_id; ?>">

                        <div id="traloi">Trả lời:</div>
                        
                        <div class = "">
                            <textarea id="reply_content" name="reply_content" rows="3" required></textarea><br>
                        </div>

                        <input id="btn-ex" type="submit" value="Gửi">
                    </form>
                    <hr>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>
</body>
</html>