<?php
// Gọi session_start() để bắt đầu phiên làm việc
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION["ma_id"])) {
    // Nếu không có phiên làm việc, chuyển hướng người dùng đến trang đăng nhập
    header("Location: ../accounts/login.php");
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
    <title>Trang chủ</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script>
        function changeWeb(){
            window.location.href ='add_news.php';
        }
    </script>
</head>
<body>
    <div id="logo">
        <img>
    </div>
    <div id='body'>
        <header>
            <ul id="menu-ul">
                <li><a class="menu-content" id="home" href="home.php">Trang chủ</a></li>
                <li><a href="../quanly/quanly_users.php">Người dùng</a></li>
                <li><a class="menu-content" id="pro" href="../accounts/profile.php">Pro5</a></li>
            </ul>
        </header>
        <main id="home-container">
            <h3 class="h3-content">Thay đổi bài viết</h3>
                    <?php
                    $id = $_GET['id'];
                    $sql = "SELECT * FROM news WHERE id = '$id'";
                    $result = mysqli_query($conn,$sql);
                    if($result->num_rows>0){
                        while($row=$result->fetch_assoc()){
                            $avatar = $row['avatars'];
                            $title = $row['title'];
                            $description = $row['description'];
                            $content = $row['content'];
                            $status = $row['status'];
                        }
                        echo "<form method='post' action='update.php?id=$id'>";
                        echo "<lable for='img'>Ảnh</lable>";
                        echo "<input type='file' name='avatar' value='../../uploads/",$avatar,"' required><br>";
                        echo "<label for='title'>Tiêu đề: </label>";
                        echo "<input name='title' type='text' value='", $title,"' required><br>";
                        echo "<label for='description'>Mô tả ngắn: </label>";
                        echo "<input name='description' type='text' value='", $description,"' required><br>";
                        echo "<label for='content'>Nội dung: </label>";
                        echo "<input name='content' type='text' value='", $content,"' required><br>";
                        echo "<lable for='status'>Trạng thái</lable>";
                        echo "<select name='status'>";
                        if($status==0){
                            echo "<option value='0'>Disable</option>
                            <option value='1'>Action</option>";
                        }else{
                            echo "<option value='1'>Action</option><option value='0'>Disable</option>";
                        }
                        echo "</select>";
                        echo "<input name='submit' type='submit' value='Lưu'>";
                        echo "</form>";
                    }
                    ?>
                    
                
        </main>
    </div>
</body>
</html>
