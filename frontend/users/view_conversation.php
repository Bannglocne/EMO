<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: accounts/login.php");
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

$contacted_user_id = $_GET["user_id"];

$sql_conversation = "SELECT e.title AS tieude, e.content AS noidung, e.reply_content AS traloi, e.timestamp AS thoigian, 'email' AS type
                     FROM emails e
                     WHERE (e.sender_id = ? AND e.receiver_id = ?) OR (e.sender_id = ? AND e.receiver_id = ?)
                     UNION
                     SELECT l.tieude, l.noidung, NULL AS traloi, l.thoigian, 'letter' AS type
                     FROM letters l
                     WHERE (l.sogui = ? AND l.sonhan = ?) OR (l.sogui = ? AND l.sonhan = ?)
                     ORDER BY thoigian DESC";
$stmt_conversation = $conn->prepare($sql_conversation);
$stmt_conversation->bind_param("iiiiiiii", $_SESSION["user_id"], $contacted_user_id, $contacted_user_id, $_SESSION["user_id"], $_SESSION["user_id"], $contacted_user_id, $contacted_user_id, $_SESSION["user_id"]);
$stmt_conversation->execute();
$result_conversation = $stmt_conversation->get_result();

// Fetch the username of the contacted user for display
$sql_contacted_username = "SELECT username FROM users WHERE id = ?";
$stmt_contacted_username = $conn->prepare($sql_contacted_username);
$stmt_contacted_username->bind_param("i", $contacted_user_id);
$stmt_contacted_username->execute();
$result_contacted_username = $stmt_contacted_username->get_result();
$contacted_username = $result_contacted_username->fetch_assoc()["username"];
?>


<!DOCTYPE html>
<html>
<head>
    <title>Cuộc trò chuyện</title>
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
        .chat-message {
            background-color: #FAA5C4;
            border-radius: 30px;
            padding: 10px;
            margin: 10px 0;
            max-width: 70%;
            font-weight: 500;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #FFF6F0;
            margin: 0;
            padding: 0;
        }

        .conversation {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            border: 3px solid;
            border-radius: 30px;
            text-align: center;
        }

        .chat-container {
            margin-top: 20px;
        }

        .chat-message {
            background-color: #f1f1f1;
            border-radius: 10px;
            padding: 10px;
            margin: 10px 0;
            max-width: 80%;
            margin-left: auto;
            margin-right: auto;
        }

        .chat-message strong {
            color: #2a2a2a;
            display: block;
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
    <div class="conversation">
    <h2>Cuộc trò chuyện với <?php echo $contacted_username; ?></h2>
        <div class="chat-container">
            <?php
            while ($message = $result_conversation->fetch_assoc()) {
                echo "<div class='chat-message'>";
                if ($message["type"] == "email") {
                    echo "<strong>Email:</strong> ";
                }
                echo "<strong>" . $message["tieude"] . "</strong><br>";
                echo nl2br($message["noidung"]);
                if ($message["type"] == "email" && !empty($message["traloi"])) {
                    echo "<br><strong>Phản hồi:</strong><br>";
                    echo nl2br($message["traloi"]);
                }
                echo "</div>";
            }
            ?>
        </div>
    </div>
</body>
</html>
