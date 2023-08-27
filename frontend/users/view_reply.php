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

// Fetch from emails table
$sql_contacted_from_emails = "SELECT DISTINCT u.id, u.username
                              FROM users u 
                              JOIN emails e ON u.id = e.receiver_id OR u.id = e.sender_id
                              WHERE (e.sender_id = ? OR e.receiver_id = ?) AND u.id != ?
                              ORDER BY u.username ASC";
$stmt_from_emails = $conn->prepare($sql_contacted_from_emails);
$stmt_from_emails->bind_param("iii", $_SESSION["user_id"], $_SESSION["user_id"], $_SESSION["user_id"]);
$stmt_from_emails->execute();
$result_from_emails = $stmt_from_emails->get_result();

// Fetch from letters table
$sql_contacted_from_letters = "SELECT DISTINCT u.id, u.username
                               FROM users u 
                               JOIN letters l ON u.id = l.sonhan OR u.id = l.sogui
                               WHERE (l.sogui = ? OR l.sonhan = ?) AND u.id != ?
                               ORDER BY u.username ASC";
$stmt_from_letters = $conn->prepare($sql_contacted_from_letters);
$stmt_from_letters->bind_param("iii", $_SESSION["user_id"], $_SESSION["user_id"], $_SESSION["user_id"]);
$stmt_from_letters->execute();
$result_from_letters = $stmt_from_letters->get_result();

// Combine and filter unique users
$all_contacted_users = [];

while ($user = $result_from_emails->fetch_assoc()) {
    $all_contacted_users[$user['id']] = $user['username'];
}
while ($user = $result_from_letters->fetch_assoc()) {
    $all_contacted_users[$user['id']] = $user['username'];
}

// Now, $all_contacted_users will have a list of unique contacted users combined from both tables.
?>



<!DOCTYPE html>
<html>
<head>
    <title>Xem thư đã gửi</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/xemthu.css">
    <style>
        /* Styling for the list of contacted users */
        .contact-list {
            list-style-type: none;
            padding: 0;
            margin: 20px 0;
            max-width: 300px;
            margin-left: auto;
            margin-right: auto;
        }

        .contact-list li {
            padding: 10px;
            margin-bottom: 5px;
            background-color: #f4f4f4;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }

        .contact-list li:hover {
            background-color: #FAA5C4;
            color: #fff;
            cursor: pointer;
        }
        ul a{
            text-decoration: none;
            color: black;
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
    <div class="container">
        <h2>Danh sách người dùng bạn đã liên hệ</h2>
        <ul class="contact-list">
            <?php
            foreach ($all_contacted_users as $id => $username) {
                echo '<li><a href="view_conversation.php?user_id=' . $id . '">' . $username . '</a></li>';
            }
            ?>
        </ul>
    </div>
</body>
</html>

