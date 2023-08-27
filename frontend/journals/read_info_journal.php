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
            window.location.href = "change_journal.php?id=<?php echo $_GET['id'] ?>";
        }
        function comeback(userID){
            window.location.href = "info.php?id="+userID;
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
                <li><a class="menu-content" id="home" href="../users/">Trang chủ</a></li>
                <li><a class="menu-content" id="write" href="../users/viet.php">Viết</a></li>
                <li><a class="menu-content" id="forest" href="emo_forest.php">Rừng</a></li>
                <li><img id="logo" src="../img/logo.png"></li>
                <li><a class="menu-content" id="garden" href="../journals/view_journal.php">Vườn</a></li>
                <li><a class="menu-content" id="prf" href="../users/view_reply.php"><img id="img-user" src="../img/letter.png"></a></li>
                <li><a class="menu-content" id="prf" href="../accounts/profile.php"><img id="img-user" src="../img//user.png"></a></li>
            </ul>
        </div>
    </header>
    <main id="main-read">
        <div><h3 id='div-content-read'>Đọc nhật kí</h3></div>
        <div id="read-container">
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
                $sql = "SELECT * FROM journals WHERE id='$id';";
                $result = $conn->query($sql);
                if($result->num_rows>0)
                {
                    while($row=$result->fetch_assoc())
                        {
                            //Lấy dữ liệu từ cột trong dòng hiện tại
                            $id = $row['id'];
                            $userID = $row['user_id'];
                            $camxuc = $row['emotion'];
                            $content = $row['content'];
                            $date = $row['date'];
                            $month = $row['month'];
                            $year = $row['year'];
                        }
                    echo "<div class='info-read'><p class='info-read-p'>Ngày viết: ",$date,"/",$month,"/",$year,"</p></div>";
                    if($camxuc=='1'){
                        echo "<div class='info-read' id='camxuc-read'><p class='info-read-p'>Cảm xúc: </p><p class='info-read-p' id='vui-prf'>Vui</p></div>";
                    }
                    elseif($camxuc=='2'){
                        echo "<div class='info-read' id='camxuc-read'><p class='info-read-p'>Cảm xúc: </p><p class='info-read-p' id='buon-prf''>Buồn</p></div>";
                    }
                    else{
                        echo "<div class='info-read' id='camxuc-read'><p class='info-read-p'>Cảm xúc: </p><p class='info-read-p' id='khac-prf'>Khác</p></div>";
                    }
                    echo "<div class='info-read'><p class='info-read-p'>Nội dung: ",$content, "</p></div>";
                    echo "<button class='info-prf' style='margin-block: 10px' id='change_info' onclick='comeback($userID)'>Quay lại</button>";
                }else{
                    echo "Không có dữ liệu";
                }

                $conn->close();
            ?>
        </div>
    </main>
</body>
</html>