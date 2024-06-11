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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <style>
        body{
            background-color: #FFF6F0;
        }
    </style>
    <script>
        function changeWeb(){
            window.location.href ='add_news.php';
        }
    </script>
</head>

<body>
    <div id="pattern">
        <div class="flex-left"><img id="logo" src="../img/logo.png" height= "60px"></div>
        <div class="flex-right"></div>
    </div>

    <div id="body">
        <header>
            <ul id="menu-ul">
                <li><a class="menu-content" id="home" href="home.php">Trang chủ</a></li>
                <li><a href="../quanly/quanly_users.php">Người dùng</a></li>
                <li><a class="menu-content" id="pro" href="../accounts/profile.php">Pro5</a></li>
            </ul>
        </header>

        <main id="home-container">
            <h3 class="h3-content">Thêm bài viết</h3>
                <?php
                if(isset($_SESSION['$title_news']) and isset($_SESSION['description_news']) and isset($_SESSION['content_news']) and (isset($_SESSION['status_news'])) and isset($_SESSION['error_add_news'])){
                    $title = $_SESSION['$title_news'];
                    $description = $_SESSION['description_news'];
                    $content = $_SESSION['content_news'];
                    $status = $_SESSION['status_news'];
                    $error = $_SESSION['error_add_news'];
                }
                ?>
                <form method="post" action='insert_news.php' enctype=multipart/form-data>
                    <label>Hình ảnh</label>
                    <input type="file" name="avatar" required><br>

                    <label for="title">Tiêu đề: </label>
                    <input name="title" type="text" value="<?php if(isset($title)){echo $title; unset($_SESSION['$title_news']);} ?>" required><br>

                    <label for="description">Mô tả ngắn: </label>
                    <input name="description" type="text" value="<?php if(isset($description)){echo $description; unset($_SESSION['$description_news']);} ?>" required><br>

                    <label for="content">Nội dung: </label>
                    <textarea name="content" type="text" required><?php if(isset($content)){echo $content; unset($_SESSION['$content_news']);} ?></textarea><br>

                    <p>Trạng thái</p>
                    <select name='status'>
                        <?php
                        if(isset($status)){
                            if($status==0){
                                echo "<option value='0'>Disable</option><option value='1'>Action</option>";
                            }else{
                                echo "<option value='1'>Action</option><option value='0'>Disable</option>";
                            }
                            unset($_SESSION['$status_news']);
                        }else{
                            echo "<option value='0'>Disable</option><option value='1'>Action</option>";
                        }
                        ?>
                    </select>
                    <p class='error' name='error'>
                    <?php
                    if(isset($error)){
                        echo $error;
                        unset($_SESSION['error_add_news']);
                    }
                    ?>

                    </p>
                    <input name="submit" type="submit" value="Thêm">
                </form>
        </main>
    </div>
</body>
</html>
