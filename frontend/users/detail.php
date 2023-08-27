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
        function goChange(){
            window.location.href = "library.php";
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
                <li><a class="menu-content" id="prf" href="../journals/view_reply.php"><img id="img-user" src="../img/letter.png"></a></li>
                <li><a class="menu-content" id="prf" href="../accounts/profile.php"><img id="img-user" src="../img//user.png"></a></li>
            </ul>
        </div>
    </header>
    <main id="main-read">
        <div><h3 id='div-content-read'>Bài viết</h3></div>
        <div id="read-container" style='text-align:center'>
            <?php
                $id=$_GET['id'];
                $servername = "localhost";
                $username = "emo";
                $password = "123456EmoR2";
                $dbname = "emo";
                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Kết nối thất bại: " . $conn->connect_error);
                }

                //$camxuc = $_SESSION['camxuc'];
                $sql = "SELECT * FROM news WHERE id='$id';";
                $result = $conn->query($sql);
                if($result->num_rows>0)
                {
                    while($row=$result->fetch_assoc())
                        {
                            //Lấy dữ liệu từ cột trong dòng hiện tại
                            $id = $row['id'];
                            $title = $row['title'];
                            $content = $row['content'];
                            $description = $row['description'];
                            $avatar = $row['avatars'];
                        }
                    echo "<div><h3 class='title-lib'>",$title,"</h3></div>";
                    echo "<div><img src='../../uploads/",$avatar,"' style='max-width:1000px; max-height: 460px; text-align:center;'></div>";
                    echo "<div><p class='info-read-p'>",$content, "</p></div>";
                }else{
                    echo "Không có dữ liệu";
                }

                $conn->close();
            ?>
            <div class="info-read"><button class="btn_ch" onclick="goChange()">Quay lại</button></div>
        </div>
    </main>
</body>
</html>