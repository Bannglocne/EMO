<?php
session_start(); // Gọi session_start() chỉ một lần

if (!isset($_SESSION["user_id"])) {
    header("Location: accounts/login.php");
    exit();
}

if ($_SESSION["role"] == 'expert') {
    header("Location: ../experts/expert_page.php");
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

// Lấy danh sách các thư đã gửi và các phản hồi từ chuyên gia từ bảng emails
$sql_get_emails = "SELECT e.id, e.title, e.content, e.timestamp, e.reply_content, u.username AS expert_username
                   FROM emails e
                   LEFT JOIN users u ON e.receiver_id = u.id
                   WHERE e.sender_id = ? AND e.reply_content IS NOT NULL
                   ORDER BY e.timestamp DESC";
$stmt_get_emails = $conn->prepare($sql_get_emails);
$stmt_get_emails->bind_param("i", $_SESSION["user_id"]);
$stmt_get_emails->execute();
$result_get_emails = $stmt_get_emails->get_result();

$sql_get_received_letters = "SELECT l.so, l.tieude, l.noidung, l.thoigian, u.username AS sender_username
                            FROM letters l
                            LEFT JOIN users u ON l.sogui = u.id
                            WHERE l.sonhan = ?
                            ORDER BY l.thoigian DESC";
$stmt_get_letters = $conn->prepare($sql_get_received_letters);
$stmt_get_letters->bind_param("i", $_SESSION["user_id"]);
$stmt_get_letters->execute();
$result_get_letters = $stmt_get_letters->get_result();
?>

<!-- Code HTML -->
<!DOCTYPE html>
<html>
<head>
    <title>Xem phản hồi</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/xemthu.css">
    <?php
        if(isset($_SESSION['msg_mail'])){
            $msg = $_SESSION['msg_mail'];
            echo "<script> alert('$msg');</script>";
            unset($_SESSION['msg_mail']);
        }
    ?>
    <style>
        #img-user{
            height: 50px;
        }
        #logo{
            height: 60px;
        }
    </style>
</head>
<body>
    <header>
        <div id="head-content">
            <div id="menu">
                <ul id="menu-ul">
                    <li><a class="menu-content" id="home" href="home.php">Trang chủ</a></li>
                    <li><a class="menu-content" id="write" href="viet.php">Viết</a></li>
                    <li><a class="menu-content" id="forest" href="../journals/emo_forest.php">Rừng</a></li>
                    <li><img id="logo" src="../img/logo.png" height= "60px"></li>
                    <li><a class="menu-content" id="garden" href="../journals/view_journal.php">Vườn</a></li>
                    <li><a class="menu-content" id="prf" href="view_reply.php"><img id="img-user" src="../img/letter.png"></a></li>
                    <li><a class="menu-content" id="prf" href="../accounts/profile.php"><img id="img-user" src="../img//user.png"></a></li>
                </ul>
            </div>
        </div>
    </header>

    <br>
    <br>

    <!-- Ô vuông "Hồi âm" -->
    <div class="tatca">
        <div class="tieude">
            <span class="hoiam">Hồi âm</span>
        </div>

        <br>
        <ul id="traloi">
            <?php
                // Hiển thị danh sách các thư từ bảng emails
                while ($row = $result_get_emails->fetch_assoc()) {
                    $email_id = $row["id"];
                    $reply_content = $row["reply_content"];
                    $expert_username = $row["expert_username"];
                    ?>
                    <li>
                        <div class="traloi">
                            <h3 class="title">Thư hồi âm từ chuyên gia <?php echo $expert_username; ?></h3>
                            <div class="content"><?php echo nl2br($reply_content); ?></div>
                        </div>
                        <br>
                    </li>
                    <?php
                }

                // Hiển thị danh sách các thư nhận từ bảng letters
                while ($row = $result_get_letters->fetch_assoc()) {
                    $letter_id = $row["so"];
                    $title = $row["tieude"];
                    $content = $row["noidung"];
                    $sender_username = $row["sender_username"];
                    ?>
                    <li>
                        <div class="traloi">
                            <h3 class="title">Thư nhận từ người gửi <?php echo $sender_username; ?></h3>
                            <div class="content"><?php echo nl2br($content); ?></div>
                        </div>
                        <br>
                    </li>
                    <?php
                }
            ?>
        </ul>
    </div>
</body>
</html>