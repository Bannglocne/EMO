<?php
// Gọi session_start() để bắt đầu phiên làm việc
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION["user_id"])) {
    // Nếu không có phiên làm việc, chuyển hướng người dùng đến trang đăng nhập
    header("Location: accounts/login.php");
    exit();
}

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
?>
<!DOCTYPE html>
<html>
<head>
    <title>Viết</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/style.css" />
    <script>
        function send_letter(){
            window.location.href = "../letters/write_letter.php";
        }
        function write_journal(){
            window.location.href = "../journals/choice_emo.php";
        }
        function send_mail(){
            window.location.href = "compose.php";
        }
    </script>
    <style>
        #write{
            border-bottom: 1px solid black;
        }
    </style>
</head>
<body>
    <header>
        <div id="menu">
            <ul id="menu-ul">
                <li><a class="menu-content" id="home" href="home.php">Trang chủ</a></li>
                <li><a class="menu-content" id="write" href="viet.php">Viết</a></li>
                <li><a class="menu-content" id="forest" href="../journals/emo_forest.php">Rừng</a></li>
                <li><img id="logo" src="../img/logo.png"></li>
                <li><a class="menu-content" id="garden" href="../journals/view_journal.php">Vườn</a></li>
                <li><a class="menu-content" id="prf" href="view_reply.php"><img id="img-user" src="../img/letter.png"></a></li>
                <li><a class="menu-content" id="prf" href="../accounts/profile.php"><img id="img-user" src="../img//user.png"></a></li>
            </ul>
        </div>
    </header>
    <main id="viet">
        <div id="img-flws">
            <img src="../img/flower1.png">
        </div>
        <div id="viet-content">
            <div id="qs-viet">
                <h3 class="h3-viet" id="question-viet">Hôm nay bạn muốn viết gì?</h3>
            </div>
            <div id="content-choice">
                <div id="viet-thu" >
                    <div class="block-content" >
                        <h3 class="h3-viet">Viết thư</h3>
                        <p class='text-viet'>Bạn đang gặp vấn đề về tâm lý nhưng lại ngại nói chuyện trực tiếp với gia đình và bác sĩ. Vậy thì hãy gửi ngay một lá thư đến với một người lạ nào đó để chia sẻ tâm tư và có thể nhận lại thư phản hồi.</p>
                    </div>
                    <div class="btn-container">
                        <button class="btn" onclick="send_letter()">Viết ngay</button>
                    </div>
                </div>
                <div id="viet-thu" >
                    <div class="block-content" >
                        <h3 class="h3-viet">Viết câu hỏi</h3>
                        <p class='text-viet'>Bạn đang gặp vấn đề về tâm lý nhưng lại ngại nói chuyện trực tiếp với gia đình và bác sĩ. Vậy thì hãy gửi ngay một lá thư đến với chuyên gia tâm lý một cách ẩn danh nhưng bạn vẫn sẽ nhận được lời khuyên có ích.</p>
                    </div>
                    <div class="btn-container">
                        <button class="btn" onclick="send_mail()">Viết ngay</button>
                    </div>
                </div>
                <div id="nhat-ki" >
                    <div class="block-content" >
                        <h3 class="h3-viet">Viết nhật ký</h3>
                        <p class='text-viet'>Bạn có một câu chuyện muốn giải bày nhưng lại khó nói, có thể là áp lực điểm số hay nỗi lo về gia đình,...Vậy thì hãy hít thật sâu và viết mọi tâm sự của bạn, sau đó cứ để nỗi niềm theo đó mà mang đi.</p>
                    </div>
                    <div class="btn-container">
                        <button class="btn" onclick="write_journal()">Viết ngay</button>
                    </div>
                </div>
            </div>
            <div>
                <div id="div-viet"><h3 class="h3-viet" id="div-content">MỌI VẤN ĐỀ TÂM LÝ CỦA BẠN HÃY ĐỂ <img id="emo" src="../img/logo.png"> SAN SẺ</h3></div>
            </div>
        </div>
    </main>
</body>
</html>
